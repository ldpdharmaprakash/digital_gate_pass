<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QRVerificationController;
use App\Http\Controllers\QRAuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\WardenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GatepassApprovalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Public gatepass QR access (for both students and security)
Route::get('/gatepass-qr/{gatepass}', [QRAuthController::class, 'showGatepassByQR'])->name('gatepass.qr.show');
Route::get('/gatepass-qr/{gatepass}/generate', [QRAuthController::class, 'generateGatepassQR'])->name('gatepass.qr.generate');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::get('/gatepasses', [StudentController::class, 'indexGatepasses'])->name('gatepasses.index');
    Route::get('/gatepasses/create', [StudentController::class, 'createGatepass'])->name('gatepasses.create');
    Route::post('/gatepasses', [StudentController::class, 'storeGatepass'])->name('gatepasses.store');
    Route::get('/gatepasses/{gatepass}', [StudentController::class, 'showGatepass'])->name('gatepasses.show');
    Route::get('/gatepasses/{gatepass}/download', [StudentController::class, 'downloadGatepass'])->name('gatepasses.download');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/profile', [StaffController::class, 'profile'])->name('profile');
    Route::get('/gatepasses/pending', [StaffController::class, 'pendingGatepasses'])->name('gatepasses.pending');
    Route::post('/gatepasses/{gatepass}/approve', [StaffController::class, 'approveGatepass'])->name('gatepasses.approve');
    Route::get('/gatepasses/{gatepass}/details', [StaffController::class, 'getGatepassDetails'])->name('gatepasses.details');
    Route::get('/gatepasses/{gatepass}', [StaffController::class, 'showGatepass'])->name('gatepasses.show');
    Route::get('/gatepasses/approved', [StaffController::class, 'approvedGatepasses'])->name('gatepasses.approved');
    Route::get('/students', [StaffController::class, 'students'])->name('students.index');
    Route::get('/students/{student}/gatepasses', [StaffController::class, 'studentGatepasses'])->name('students.gatepasses');
});

// HOD Routes
Route::middleware(['auth', 'role:hod'])->prefix('hod')->name('hod.')->group(function () {
    Route::get('/profile', [HodController::class, 'profile'])->name('profile');
    Route::get('/gatepasses/pending', [HodController::class, 'pendingGatepasses'])->name('gatepasses.pending');
    Route::post('/gatepasses/{gatepass}/approve', [HodController::class, 'approveGatepass'])->name('gatepasses.approve');
    Route::get('/gatepasses/{gatepass}/details', [HodController::class, 'getGatepassDetails'])->name('gatepasses.details');
    Route::get('/gatepasses/{gatepass}', [HodController::class, 'showGatepass'])->name('gatepasses.show');
    Route::get('/gatepasses/approved', [HodController::class, 'approvedGatepasses'])->name('gatepasses.approved');
    Route::get('/reports', [HodController::class, 'reports'])->name('reports');
    Route::get('/reports/download', [HodController::class, 'downloadReport'])->name('reports.download');
});

// Warden Routes
Route::middleware(['auth', 'role:warden'])->prefix('warden')->name('warden.')->group(function () {
    Route::get('/profile', [WardenController::class, 'profile'])->name('profile');
    Route::get('/gatepasses/pending', [WardenController::class, 'pendingGatepasses'])->name('gatepasses.pending');
    Route::post('/gatepasses/{gatepass}/approve', [WardenController::class, 'approveGatepass'])->name('gatepasses.approve');
    Route::get('/gatepasses/{gatepass}', [WardenController::class, 'showGatepass'])->name('gatepasses.show');
    Route::get('/gatepasses/hostellers', [WardenController::class, 'hostellerGatepasses'])->name('gatepasses.hostellers');
    Route::get('/gatepasses/approved', [WardenController::class, 'approvedGatepasses'])->name('gatepasses.approved');
    Route::get('/verification', [WardenController::class, 'verification'])->name('verification');
    Route::post('/verification', [WardenController::class, 'verifyGatepass'])->name('verification.search');
    Route::get('/reports', [WardenController::class, 'reports'])->name('reports');
    Route::get('/reports/download', [WardenController::class, 'downloadReport'])->name('reports.download');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/departments', [AdminController::class, 'departments'])->name('departments.index');
    Route::get('/departments/create', [AdminController::class, 'createDepartment'])->name('departments.create');
    Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('departments.store');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/download', [AdminController::class, 'downloadReport'])->name('reports.download');
    Route::post('/export/gatepasses', [AdminController::class, 'exportGatepasses'])->name('export.gatepasses');
    Route::get('/bulk-upload', [AdminController::class, 'bulkUpload'])->name('bulk-upload');
    Route::post('/bulk-upload', [AdminController::class, 'processBulkUpload'])->name('process-bulk-upload');
    Route::get('/download-template/{type}', [AdminController::class, 'downloadTemplate'])->name('download-template');
});

// QR Verification Routes (Public - for scanning)
Route::get('/qr/verify/{id}', [QRVerificationController::class, 'verify'])->name('qr.verify');
Route::post('/qr/verify', [QRVerificationController::class, 'verifyApi'])->name('qr.verify.api');

// QR Authentication Routes (Public - for QR login)
Route::get('/auth/qr/{token}', [QRAuthController::class, 'qrLogin'])->name('qr.login');
Route::get('/qr-image/{token}', [QRAuthController::class, 'generateQRImage'])->name('qr.image');

// QR Management Routes (Auth required)
Route::middleware('auth')->prefix('qr')->name('qr.')->group(function () {
    Route::get('/my-qr', [QRAuthController::class, 'showMyQR'])->name('my-qr');
    Route::post('/regenerate', [QRAuthController::class, 'regenerateQR'])->name('regenerate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Gatepass Email Approval Routes
Route::get('/gatepass/approve/{gatepassId}/{recipientId}/{token}', [GatepassApprovalController::class, 'approve'])->name('gatepass.approve.email');
Route::get('/gatepass/reject/{gatepassId}/{recipientId}/{token}', [GatepassApprovalController::class, 'reject'])->name('gatepass.reject.email');


// Email notification testing routes
Route::get('/test-email-notifications', [App\Http\Controllers\EmailNotificationController::class, 'testEmailNotifications']);
Route::get('/test-email', [App\Http\Controllers\EmailNotificationController::class, 'testEmailSending']);
Route::get('/email-config', [App\Http\Controllers\EmailNotificationController::class, 'showEmailConfig']);
Route::get('/test-gatepass-notification', [App\Http\Controllers\EmailNotificationController::class, 'sendTestGatepassNotification']);
Route::get('/create-test-users', [App\Http\Controllers\EmailNotificationController::class, 'createTestUsers']);

require __DIR__.'/auth.php';

// Security Routes
Route::prefix('security')->middleware(['auth', 'role:security'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SecurityController::class, 'dashboard'])->name('security.dashboard');
    Route::get('/gatepasses', [App\Http\Controllers\SecurityController::class, 'index'])->name('security.gatepasses');
    Route::get('/gatepasses/pending', [App\Http\Controllers\SecurityController::class, 'pending'])->name('security.gatepasses.pending');
    Route::get('/gatepasses/approved', [App\Http\Controllers\SecurityController::class, 'approved'])->name('security.gatepasses.approved');
    Route::get('/gatepasses/rejected', [App\Http\Controllers\SecurityController::class, 'rejected'])->name('security.gatepasses.rejected');
    
    // QR Scanning and Verification
    Route::get('/scan', [App\Http\Controllers\SecurityController::class, 'scanQR'])->name('security.scan');
    Route::post('/verify-gatepass', [App\Http\Controllers\SecurityController::class, 'verifyGatepass'])->name('security.verify');
    
    // Entry/Exit Management
    Route::post('/mark-exit', [App\Http\Controllers\SecurityController::class, 'markExit'])->name('security.mark.exit');
    Route::post('/mark-entry', [App\Http\Controllers\SecurityController::class, 'markEntry'])->name('security.mark.entry');
    
    // Security Logs
    Route::get('/logs', [App\Http\Controllers\SecurityController::class, 'logs'])->name('security.logs');
});
