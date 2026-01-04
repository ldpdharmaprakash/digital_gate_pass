<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'student':
                return app(StudentController::class)->dashboard();
            case 'staff':
                return app(StaffController::class)->dashboard();
            case 'hod':
                return app(HodController::class)->dashboard();
            case 'warden':
                return app(WardenController::class)->dashboard();
            case 'admin':
                return app(AdminController::class)->dashboard();
            default:
                abort(403);
        }
    }
}
