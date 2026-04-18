<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gatepass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QRAuthController extends Controller
{
    /**
     * Handle QR login via token
     */
    public function qrLogin($token)
    {
        try {
            // Check if this is a temporary QR login token for email approval
            if (request()->has('action') && request()->has('gatepass') && request()->has('token')) {
                return $this->handleEmailApprovalQRLogin($token);
            }
            
            // Find user by QR token
            $user = User::where('qr_token', $token)->first();
            
            if (!$user) {
                return redirect()->route('login')
                    ->with('error', 'Invalid QR code. Please try again.');
            }
            
            // Check if user is active
            if (!$user->is_active) {
                return redirect()->route('login')
                    ->with('error', 'Account is inactive. Please contact administrator.');
            }
            
            // Authenticate user
            Auth::login($user);
            
            // Regenerate session for security
            Session::regenerate();
            
            // Set flag to indicate successful QR login
            Session::flash('qr_login_success', true);
            
            // Redirect based on user role
            return $this->redirectToDashboard($user);
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'QR login failed. Please try again.');
        }
    }
    
    /**
     * Handle QR login for email approval links
     */
    private function handleEmailApprovalQRLogin($token)
    {
        try {
            // Find the recipient user by email (since this is a temporary token)
            $gatepassId = request()->get('gatepass');
            $action = request()->get('action');
            $approvalToken = request()->get('token');
            
            // Find the gatepass and validate the approval token
            $gatepass = \App\Models\Gatepass::findOrFail($gatepassId);
            
            // Find the recipient based on the approval token
            $recipientId = $this->extractRecipientIdFromToken($approvalToken, $gatepassId);
            $recipient = \App\Models\User::findOrFail($recipientId);
            
            // Verify the approval token
            $expectedToken = hash('sha256', $gatepassId . $recipientId . $action . $gatepass->created_at->timestamp);
            if (!hash_equals($expectedToken, $approvalToken)) {
                return redirect()->route('login')
                    ->with('error', 'Invalid approval link.');
            }
            
            // Auto-login the user
            Auth::login($recipient);
            Session::regenerate();
            
            // Process the approval/reject action
            $approvalController = new \App\Http\Controllers\GatepassApprovalController();
            
            if ($action === 'approve') {
                return $approvalController->approve($gatepassId, $recipientId, $approvalToken);
            } elseif ($action === 'reject') {
                return $approvalController->reject($gatepassId, $recipientId, $approvalToken);
            }
            
            return redirect()->route('login')
                ->with('error', 'Invalid action specified.');
                
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Email approval failed. Please try again.');
        }
    }
    
    /**
     * Extract recipient ID from approval token
     */
    private function extractRecipientIdFromToken($token, $gatepassId)
    {
        // For simplicity, we'll find the recipient by trying all possible users
        // In a production environment, you might want to store the recipient ID in the token
        $users = \App\Models\User::where('college_id', \App\Models\Gatepass::find($gatepassId)->college_id)
                               ->where('is_active', true)
                               ->get();
        
        foreach ($users as $user) {
            $expectedToken = hash('sha256', $gatepassId . $user->id . 'approve', \App\Models\Gatepass::find($gatepassId)->created_at->timestamp);
            if (hash_equals($expectedToken, $token)) {
                return $user->id;
            }
        }
        
        throw new \Exception('Recipient not found for token');
    }
    
    /**
     * Show user's QR code
     */
    public function showMyQR()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Generate QR token if not exists
        if (!$user->qr_token) {
            $user->generateQRToken();
        }
        
        $qrLoginUrl = $user->getQRLoginUrl();
        $qrToken = $user->qr_token;
        $qrGeneratedAt = $user->qr_token_generated_at;
        
        return view('qr.my-qr', compact(
            'user',
            'qrLoginUrl',
            'qrToken',
            'qrGeneratedAt'
        ));
    }
    
    /**
     * Regenerate QR token
     */
    public function regenerateQR()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Generate new QR token
        $newToken = $user->generateQRToken();
        
        return redirect()->route('qr.my-qr')
            ->with('success', 'QR code regenerated successfully!');
    }
    
    /**
     * Redirect user to appropriate dashboard based on role
     */
    private function redirectToDashboard($user)
    {
        switch ($user->role) {
            case 'student':
                return redirect()->route('student.dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            case 'hod':
                return redirect()->route('hod.dashboard');
            case 'warden':
                return redirect()->route('warden.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->route('login')
                    ->with('error', 'Invalid user role.');
        }
    }
    
    /**
     * Generate QR code image for display
     */
    public function generateQRImage($token)
    {
        try {
            $user = User::where('qr_token', $token)->first();
            
            if (!$user) {
                abort(404);
            }
            
            $qrLoginUrl = $user->getQRLoginUrl();
            
            // Use external QR code API
            $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?';
            $qrParams = [
                'size' => '300x300',
                'data' => $qrLoginUrl,
                'format' => 'png',
                'margin' => '2',
                'ecc' => 'H',
                'color' => '000000',
                'bgcolor' => 'FFFFFF'
            ];
            
            $qrUrl = $qrApiUrl . http_build_query($qrParams);
            
            // Redirect to QR image
            return redirect($qrUrl);
            
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    /**
     * Generate QR code for specific gatepass
     */
    public function generateGatepassQR(Gatepass $gatepass)
    {
        try {
            // Generate unique QR URL for this gatepass
            $qrUrl = route('gatepass.qr.show', $gatepass->id);
            
            // Use external QR code API
            $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?';
            $qrParams = [
                'size' => '300x300',
                'data' => $qrUrl,
                'format' => 'png',
                'margin' => '2',
                'ecc' => 'H',
                'color' => '000000',
                'bgcolor' => 'FFFFFF'
            ];
            
            $qrUrl = $qrApiUrl . http_build_query($qrParams);
            
            // Redirect to QR image
            return redirect($qrUrl);
            
        } catch (\Exception $e) {
            abort(404);
        }
    }
    
    /**
     * Show gatepass by QR code (public access)
     */
    public function showGatepassByQR(Gatepass $gatepass)
    {
        try {
            // Load gatepass with relationships
            $gatepass->load(['student.user', 'student.department', 'staffApprovedBy', 'hodApprovedBy', 'wardenApprovedBy']);
            
            // Check if gatepass is approved
            if (!$gatepass->isFinalApproved()) {
                return view('errors.gatepass-not-approved', compact('gatepass'));
            }
            
            // Get theme color from college
            $primaryColor = $gatepass->student->user->college->primary_color ?? '#3B82F6';
            
            // Generate QR code for this gatepass
            $qrCode = null;
            try {
                $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode(route('gatepass.qr.show', $gatepass->id)) . "&format=png&margin=2&ecc=H&color=000000&bgcolor=FFFFFF";
                $qrImageData = file_get_contents($qrApiUrl);
                if ($qrImageData !== false) {
                    $qrCode = 'data:image/png;base64,' . base64_encode($qrImageData);
                }
            } catch (\Exception $e) {
                $qrCode = null;
            }
            
            // Use default avatar if student photo doesn't exist
            $studentPhotoPath = public_path('images/avatars/' . $gatepass->student->id . '.jpg');
            if (!file_exists($studentPhotoPath)) {
                $studentPhotoBase64 = 'data:image/svg+xml;base64,' . base64_encode(
                    '<svg width="120" height="150" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="150" fill="#f3f4f6"/><circle cx="60" cy="45" r="20" fill="#9ca3af"/><path d="M60 75c-22 0-40 18-40 40v10h80v-10c0-22-18-40-40-40z" fill="#9ca3af"/></svg>'
                );
            } else {
                $studentPhotoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($studentPhotoPath));
            }
            
            // Show gatepass verification page instead of downloading PDF
            return view('gatepass.qr-verification', compact(
                'gatepass', 
                'primaryColor',
                'studentPhotoBase64',
                'qrCode'
            ));
            
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
