<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            
            // Redirect based on user role
            return $this->redirectToDashboard($user);
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'QR login failed. Please try again.');
        }
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
}
