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
            
            // Process approval
            $this->processApproval($gatepass, $recipient, 'approved');
            
            // Send acknowledgment emails
            $this->sendAcknowledgmentEmails($gatepass, $recipient, 'approved');
            
            return redirect()->route('login')
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
            
            // Process rejection
            $this->processApproval($gatepass, $recipient, 'rejected');
            
            // Send acknowledgment emails
            $this->sendAcknowledgmentEmails($gatepass, $recipient, 'rejected');
            
            return redirect()->route('login')
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
            'staff' => $currentStatus === 'pending',
            'hod' => $currentStatus === 'staff_approved',
            'warden' => in_array($currentStatus, ['staff_approved', 'hod_approved']),
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
        
        if ($action === 'approved') {
            $newStatus = match($userRole) {
                'staff' => 'staff_approved',
                'hod' => 'hod_approved',
                'warden' => 'final_approved',
                'admin' => 'final_approved',
                default => $currentStatus
            };
            
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
            
            // Set rejecter
            match($userRole) {
                'staff' => $gatepass->staff_rejected_by = $recipient->id,
                'hod' => $gatepass->hod_rejected_by = $recipient->id,
                'warden' => $gatepass->warden_rejected_by = $recipient->id,
                'admin' => $gatepass->warden_rejected_by = $recipient->id,
                default => null
            };
        }
        
        $gatepass->status = $newStatus;
        $gatepass->save();
        
        // Send notification to next approver if approved
        if ($action === 'approved' && $newStatus !== 'final_approved') {
            $this->notifyNextApprover($gatepass);
        }
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
