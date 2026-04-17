<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailNotificationController extends Controller
{
    /**
     * Test email notifications for all roles
     */
    public function testEmailNotifications()
    {
        $collegeId = 1; // Change this to your college ID
        
        // Check if staff, HOD, warden, security users exist
        $staff = User::where('role', 'staff')->where('college_id', $collegeId)->where('is_active', true)->first();
        $hod = User::where('role', 'hod')->where('college_id', $collegeId)->where('is_active', true)->first();
        $warden = User::where('role', 'warden')->where('college_id', $collegeId)->where('is_active', true)->first();
        $security = User::where('role', 'security')->where('college_id', $collegeId)->where('is_active', true)->first();
        
        $debug = [
            'college_id' => $collegeId,
            'staff' => $staff ? $staff->name . ' (' . $staff->email . ')' : 'Not found',
            'hod' => $hod ? $hod->name . ' (' . $hod->email . ')' : 'Not found',
            'warden' => $warden ? $warden->name . ' (' . $warden->email . ')' : 'Not found',
            'security' => $security ? $security->name . ' (' . $security->email . ')' : 'Not found',
        ];
        
        return response()->json($debug);
    }
    
    /**
     * Test basic email sending
     */
    public function testEmailSending()
    {
        try {
            Mail::raw('This is a test email from the gatepass system.', function($message) {
                $message->to('test@example.com')->subject('Test Email');
            });
            return 'Test email sent successfully!';
        } catch (\Exception $e) {
            return 'Error sending test email: ' . $e->getMessage();
        }
    }
    
    /**
     * Show email configuration
     */
    public function showEmailConfig()
    {
        $config = [
            'mail_driver' => config('mail.default'),
            'mail_host' => config('mail.mailers.smtp.host'),
            'mail_port' => config('mail.mailers.smtp.port'),
            'mail_encryption' => config('mail.mailers.smtp.encryption'),
            'mail_username' => config('mail.mailers.smtp.username'),
            'mail_password' => config('mail.mailers.smtp.password') ? '***SET***' : 'NOT SET',
            'mail_from_address' => config('mail.from.address'),
            'mail_from_name' => config('mail.from.name'),
        ];
        
        return response()->json($config);
    }
    
    /**
     * Send test gatepass notification to all roles
     */
    public function sendTestGatepassNotification()
    {
        try {
            // Create a test gatepass (or use an existing one)
            $gatepass = Gatepass::first();
            
            if (!$gatepass) {
                return 'No gatepass found to test with';
            }
            
            $collegeId = $gatepass->college_id;
            $recipients = [];
            
            // Find all recipients
            $roles = ['staff', 'hod', 'warden', 'security'];
            
            foreach ($roles as $role) {
                $query = User::where('role', $role)->where('college_id', $collegeId)->where('is_active', true);
                
                // For HOD, filter by department
                if ($role === 'hod' && $gatepass->student && $gatepass->student->department_id) {
                    $query->where('department_id', $gatepass->student->department_id);
                }
                
                $user = $query->first();
                
                if ($user) {
                    $recipients[] = [
                        'user' => $user,
                        'type' => $role,
                        'email' => $user->email
                    ];
                    
                    Log::info("Found {$role} recipient: {$user->name} ({$user->email})");
                } else {
                    Log::warning("No {$role} recipient found for college ID: {$collegeId}");
                }
            }
            
            // Send emails to all recipients
            $sentCount = 0;
            $failedCount = 0;
            
            foreach ($recipients as $recipient) {
                try {
                    Log::info("Attempting to send email to: {$recipient['email']} ({$recipient['type']})");
                    
                    Mail::to($recipient['email'])->send(
                        new \App\Mail\GatepassNotificationMail($gatepass, $recipient['user'], $recipient['type'])
                    );
                    
                    Log::info("Email sent successfully to: {$recipient['email']}");
                    $sentCount++;
                    
                } catch (\Exception $e) {
                    Log::error("Failed to send email to {$recipient['email']}: " . $e->getMessage());
                    $failedCount++;
                }
            }
            
            return response()->json([
                'message' => "Test complete",
                'sent' => $sentCount,
                'failed' => $failedCount,
                'total_recipients' => count($recipients),
                'gatepass_id' => $gatepass->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('Test gatepass notification error: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }
    
    /**
     * Create missing user accounts for testing
     */
    public function createTestUsers()
    {
        try {
            $collegeId = 1;
            $departmentId = 1;
            
            $testUsers = [
                ['role' => 'staff', 'name' => 'Test Staff', 'email' => 'staff@test.com'],
                ['role' => 'hod', 'name' => 'Test HOD', 'email' => 'hod@test.com'],
                ['role' => 'warden', 'name' => 'Test Warden', 'email' => 'warden@test.com'],
                ['role' => 'security', 'name' => 'Test Security', 'email' => 'security@test.com'],
            ];
            
            $created = [];
            
            foreach ($testUsers as $userData) {
                $existing = User::where('email', $userData['email'])->first();
                
                if (!$existing) {
                    $user = User::create([
                        'college_id' => $collegeId,
                        'department_id' => $userData['role'] === 'hod' ? $departmentId : null,
                        'name' => $userData['name'],
                        'username' => $userData['role'] . '_test',
                        'email' => $userData['email'],
                        'password' => bcrypt('password'),
                        'role' => $userData['role'],
                        'is_active' => true,
                        'phone' => '1234567890',
                        'gender' => 'male',
                    ]);
                    
                    $created[] = $user->email;
                }
            }
            
            return response()->json([
                'message' => 'Test users created',
                'created' => $created,
                'note' => 'Password is "password" for all test accounts'
            ]);
            
        } catch (\Exception $e) {
            return 'Error creating test users: ' . $e->getMessage();
        }
    }
}
