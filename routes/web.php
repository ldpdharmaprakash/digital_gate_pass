<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\WardenController;
use App\Http\Controllers\AdminController;
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
    Route::get('/gatepasses/approved', [StaffController::class, 'approvedGatepasses'])->name('gatepasses.approved');
    Route::get('/students', [StaffController::class, 'students'])->name('students.index');
    Route::get('/students/{student}/gatepasses', [StaffController::class, 'studentGatepasses'])->name('students.gatepasses');
});

// HOD Routes
Route::middleware(['auth', 'role:hod'])->prefix('hod')->name('hod.')->group(function () {
    Route::get('/profile', [HodController::class, 'profile'])->name('profile');
    Route::get('/gatepasses/pending', [HodController::class, 'pendingGatepasses'])->name('gatepasses.pending');
    Route::post('/gatepasses/{gatepass}/approve', [HodController::class, 'approveGatepass'])->name('gatepasses.approve');
    Route::get('/gatepasses/department', [HodController::class, 'departmentGatepasses'])->name('gatepasses.department');
    Route::get('/gatepasses/approved', [HodController::class, 'approvedGatepasses'])->name('gatepasses.approved');
    Route::get('/reports', [HodController::class, 'reports'])->name('reports');
});

// Warden Routes
Route::middleware(['auth', 'role:warden'])->prefix('warden')->name('warden.')->group(function () {
    Route::get('/profile', [WardenController::class, 'profile'])->name('profile');
    Route::get('/gatepasses/pending', [WardenController::class, 'pendingGatepasses'])->name('gatepasses.pending');
    Route::post('/gatepasses/{gatepass}/approve', [WardenController::class, 'approveGatepass'])->name('gatepasses.approve');
    Route::get('/gatepasses/hostellers', [WardenController::class, 'hostellerGatepasses'])->name('gatepasses.hostellers');
    Route::get('/gatepasses/approved', [WardenController::class, 'approvedGatepasses'])->name('gatepasses.approved');
    Route::get('/verification', [WardenController::class, 'verification'])->name('verification');
    Route::post('/verification', [WardenController::class, 'verifyGatepass'])->name('verification.verify');
    Route::get('/reports', [WardenController::class, 'reports'])->name('reports');
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
    Route::post('/export/gatepasses', [AdminController::class, 'exportGatepasses'])->name('export.gatepasses');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
