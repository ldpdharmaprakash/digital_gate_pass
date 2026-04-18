<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GatepassApprovalController extends Controller
{
    /**
     * Handle gatepass approval via email link
     */
    public function approve($gatepassId, $recipientId, $token)
    {
        try {
            $gatepass = Gatepass::findOrFail($gatepassId);
            $recipient = User::findOrFail($recipientId);
            
            // Verify token
            if (!$this->verifyActionToken($gatepass, $recipient, 'approve', $token)) {
                return redirect()->route('login')
                    ->with('error', 'Invalid or expired approval link.');
            }
            
            // Check if user has permission to approve
            if (!$this->canApprove($gatepass, $recipient)) {
                return redirect()->route('login')
                    ->with('error', 'You do not have permission to approve this gatepass.');
            }
            
            // Auto-login the user
            Auth::login($recipient);
            
            // Process approval
            $this->processApproval($gatepass, $recipient, 'approved');
            
            // Send acknowledgment emails
            $this->sendAcknowledgmentEmails($gatepass, $recipient, 'approved');
            
            // Redirect to appropriate dashboard based on user role
            $dashboardRoute = $this->getDashboardRoute($recipient->role);
            return redirect()->route($dashboardRoute)
                ->with('success', 'Gatepass approved successfully!');
                
        } catch (\Exception $e) {
            Log::error('Gatepass approval error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'An error occurred while processing the approval.');
        }
    }
    
    /**
     * Handle gatepass rejection via email link
     */
    public function reject($gatepassId, $recipientId, $token)
    {
        try {
            $gatepass = Gatepass::findOrFail($gatepassId);
            $recipient = User::findOrFail($recipientId);
            
            // Verify token
            if (!$this->verifyActionToken($gatepass, $recipient, 'reject', $token)) {
                return redirect()->route('login')
                    ->with('error', 'Invalid or expired rejection link.');
            }
            
            // Check if user has permission to reject
            if (!$this->canApprove($gatepass, $recipient)) {
                return redirect()->route('login')
                    ->with('error', 'You do not have permission to reject this gatepass.');
            }
            
            // Auto-login the user
            Auth::login($recipient);
            
            // Process rejection
            $this->processApproval($gatepass, $recipient, 'rejected');
            
            // Send acknowledgment emails
            $this->sendAcknowledgmentEmails($gatepass, $recipient, 'rejected');
            
            // Redirect to appropriate dashboard based on user role
            $dashboardRoute = $this->getDashboardRoute($recipient->role);
            return redirect()->route($dashboardRoute)
                ->with('success', 'Gatepass rejected successfully!');
                
        } catch (\Exception $e) {
            Log::error('Gatepass rejection error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'An error occurred while processing the rejection.');
        }
    }
    
    /**
     * Verify action token
     */
    private function verifyActionToken(Gatepass $gatepass, User $recipient, string $action, string $token): bool
    {
        // Generate expected token
        $expectedToken = hash('sha256', $gatepass->id . $recipient->id . $action . $gatepass->created_at->timestamp);
        
        // Check if token matches (allow tokens from last 7 days)
        $tokenAge = now()->diffInDays($gatepass->created_at);
        if ($tokenAge > 7) {
            return false;
        }
        
        return hash_equals($expectedToken, $token);
    }
    
    /**
     * Check if user can approve this gatepass
     */
    private function canApprove(Gatepass $gatepass, User $recipient): bool
    {
        $userRole = $recipient->role;
        $currentStatus = $gatepass->status;
        
        return match($userRole) {
            'staff' => in_array($currentStatus, ['pending', 'staff_rejected']), // Can re-approve rejected
            'hod' => in_array($currentStatus, ['staff_approved', 'hod_rejected']), // Can re-approve rejected
            'warden' => in_array($currentStatus, ['staff_approved', 'hod_approved', 'warden_rejected']), // Can re-approve rejected
            'admin' => true, // Admin can approve at any stage
            default => false
        };
    }
    
    /**
     * Process approval/rejection
     */
    private function processApproval(Gatepass $gatepass, User $recipient, string $action)
    {
        $userRole = $recipient->role;
        $currentStatus = $gatepass->status;
        
        // Check if this is a decision change (re-approval or rejection change)
        $isDecisionChange = $this->isDecisionChange($gatepass, $recipient, $action);
        
        if ($action === 'approved') {
            $newStatus = match($userRole) {
                'staff' => 'staff_approved',
                'hod' => 'hod_approved',
                'warden' => 'final_approved',
                'admin' => 'final_approved',
                default => $currentStatus
            };
            
            // Clear any previous rejection by this user
            $this->clearPreviousRejection($gatepass, $userRole);
            
            // Set approver
            match($userRole) {
                'staff' => $gatepass->staff_approved_by = $recipient->id,
                'hod' => $gatepass->hod_approved_by = $recipient->id,
                'warden' => $gatepass->warden_approved_by = $recipient->id,
                'admin' => $gatepass->warden_approved_by = $recipient->id,
                default => null
            };
            
            // Set approval timestamps
            match($userRole) {
                'staff' => $gatepass->staff_approved_at = now(),
                'hod' => $gatepass->hod_approved_at = now(),
                'warden' => $gatepass->warden_approved_at = now(),
                'admin' => $gatepass->warden_approved_at = now(),
                default => null
            };
            
        } else { // rejected
            $newStatus = match($userRole) {
                'staff' => 'staff_rejected',
                'hod' => 'hod_rejected',
                'warden' => 'warden_rejected',
                'admin' => 'final_rejected',
                default => 'final_rejected'
            };
            
            // Clear any previous approval by this user
            $this->clearPreviousApproval($gatepass, $userRole);
            
            // Set rejecter
            match($userRole) {
                'staff' => $gatepass->staff_rejected_by = $recipient->id,
                'hod' => $gatepass->hod_rejected_by = $recipient->id,
                'warden' => $gatepass->warden_rejected_by = $recipient->id,
                'admin' => $gatepass->warden_rejected_by = $recipient->id,
                default => null
            };
            
            // Set rejection timestamp
            match($userRole) {
                'staff' => $gatepass->staff_rejected_at = now(),
                'hod' => $gatepass->hod_rejected_at = now(),
                'warden' => $gatepass->warden_rejected_at = now(),
                'admin' => $gatepass->warden_rejected_at = now(),
                default => null
            };
        }
        
        $gatepass->status = $newStatus;
        $gatepass->save();
        
        // Log the decision change if applicable
        if ($isDecisionChange) {
            Log::info("Decision changed by {$userRole} for gatepass {$gatepass->id}: {$currentStatus} -> {$newStatus}");
        }
        
        // Send notification to next approver if approved
        if ($action === 'approved' && $newStatus !== 'final_approved') {
            $this->notifyNextApprover($gatepass);
        }
    }
    
    /**
     * Check if this is a decision change
     */
    private function isDecisionChange(Gatepass $gatepass, User $recipient, string $action): bool
    {
        $userRole = $recipient->role;
        $currentStatus = $gatepass->status;
        
        return match($userRole) {
            'staff' => in_array($currentStatus, ['staff_rejected', 'staff_approved']),
            'hod' => in_array($currentStatus, ['hod_rejected', 'hod_approved']),
            'warden' => in_array($currentStatus, ['warden_rejected', 'warden_approved']),
            default => false
        };
    }
    
    /**
     * Clear previous rejection by user
     */
    private function clearPreviousRejection(Gatepass $gatepass, string $userRole)
    {
        match($userRole) {
            'staff' => [
                $gatepass->staff_rejected_by = null,
                $gatepass->staff_rejected_at = null,
            ],
            'hod' => [
                $gatepass->hod_rejected_by = null,
                $gatepass->hod_rejected_at = null,
            ],
            'warden' => [
                $gatepass->warden_rejected_by = null,
                $gatepass->warden_rejected_at = null,
            ],
            default => null
        };
    }
    
    /**
     * Clear previous approval by user
     */
    private function clearPreviousApproval(Gatepass $gatepass, string $userRole)
    {
        match($userRole) {
            'staff' => [
                $gatepass->staff_approved_by = null,
                $gatepass->staff_approved_at = null,
            ],
            'hod' => [
                $gatepass->hod_approved_by = null,
                $gatepass->hod_approved_at = null,
            ],
            'warden' => [
                $gatepass->warden_approved_by = null,
                $gatepass->warden_approved_at = null,
            ],
            default => null
        };
    }
    
    /**
     * Notify next approver in the chain
     */
    private function notifyNextApprover(Gatepass $gatepass)
    {
        $nextApprovalType = match($gatepass->status) {
            'staff_approved' => 'hod',
            'hod_approved' => 'warden',
            default => null
        };
        
        if ($nextApprovalType) {
            // Find the next approver
            $nextApprover = $this->findNextApprover($gatepass, $nextApprovalType);
            
            if ($nextApprover) {
                \Mail::to($nextApprover->email)->send(
                    new \App\Mail\GatepassNotificationMail($gatepass, $nextApprover, $nextApprovalType)
                );
            }
        }
    }
    
    /**
     * Find the next approver based on college and department
     */
    private function findNextApprover(Gatepass $gatepass, string $approvalType): ?User
    {
        $query = User::where('role', $approvalType)
                    ->where('college_id', $gatepass->college_id)
                    ->where('is_active', true);
        
        if ($approvalType === 'hod' && $gatepass->student->department) {
            $query->where('department_id', $gatepass->student->department_id);
        }
        
        return $query->first();
    }
    
    /**
     * Get dashboard route based on user role
     */
    private function getDashboardRoute(string $role): string
    {
        return match($role) {
            'admin' => 'admin.dashboard',
            'staff' => 'staff.dashboard',
            'hod' => 'hod.dashboard',
            'warden' => 'warden.dashboard',
            'security' => 'security.dashboard',
            'student' => 'student.dashboard',
            default => 'dashboard'
        };
    }
    
    /**
     * Send acknowledgment emails for gatepass actions
     */
    private function sendAcknowledgmentEmails(Gatepass $gatepass, User $actor, string $action)
    {
        try {
            $recipients = [];
            
            // Always notify the student
            $recipients[] = $gatepass->student->user;
            
            // Notify other authorities based on action
            if ($action === 'approved') {
                // Notify next approver if not final approval
                if ($gatepass->status !== 'final_approved') {
                    $nextApprovalType = match($gatepass->status) {
                        'staff_approved' => 'hod',
                        'hod_approved' => 'warden',
                        default => null
                    };
                    
                    if ($nextApprovalType) {
                        $nextApprover = $this->findNextApprover($gatepass, $nextApprovalType);
                        if ($nextApprover) {
                            $recipients[] = $nextApprover;
                        }
                    }
                } else {
                    // Final approval - notify security and all previous approvers
                    $security = $this->findNextApprover($gatepass, 'security');
                    if ($security) {
                        $recipients[] = $security;
                    }
                    
                    // Notify staff and HOD if they approved
                    if ($gatepass->staff_approved_by) {
                        $staff = User::find($gatepass->staff_approved_by);
                        if ($staff) {
                            $recipients[] = $staff;
                        }
                    }
                    
                    if ($gatepass->hod_approved_by) {
                        $hod = User::find($gatepass->hod_approved_by);
                        if ($hod) {
                            $recipients[] = $hod;
                        }
                    }
                }
            } elseif ($action === 'rejected') {
                // Rejection - notify all authorities who were involved
                $authorities = ['staff', 'hod', 'warden', 'security'];
                foreach ($authorities as $authority) {
                    $authorityUser = $this->findNextApprover($gatepass, $authority);
                    if ($authorityUser) {
                        $recipients[] = $authorityUser;
                    }
                }
            }
            
            // Remove duplicates and send emails
            $uniqueRecipients = collect($recipients)->unique('id');
            
            foreach ($uniqueRecipients as $recipient) {
                \Mail::to($recipient->email)->send(
                    new \App\Mail\GatepassAcknowledgmentMail($gatepass, $actor, $action, $recipient)
                );
            }
            
            Log::info('Acknowledgment emails sent for ' . $action . ' action to ' . $uniqueRecipients->count() . ' recipients');
            
        } catch (\Exception $e) {
            Log::error('Failed to send acknowledgment emails: ' . $e->getMessage());
        }
    }
}
