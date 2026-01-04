@extends('layouts.gatepass')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
        <p class="text-gray-600 mt-2">View and manage your personal information</p>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Profile Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-600">{{ ucfirst(auth()->user()->role) }} • {{ auth()->user()->email }}</p>
                    <div class="mt-2 flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Username</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->username }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->phone ?? 'Not provided' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Student/Staff Specific Information -->
                @if(auth()->user()->isStudent())
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Academic Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Register Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->register_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->department->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Semester</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->semester }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Section</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->section }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hosteller</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($student->hosteller === 'yes')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Yes</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">No</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                @elseif(auth()->user()->isStaff())
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->staff->employee_id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->staff->department->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Designation</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->staff->designation }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(auth()->user()->staff->type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Joining Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->staff->joining_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                @elseif(auth()->user()->isHod())
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->hod->employee_id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->hod->department->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Appointment Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->hod->appointment_date->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Students Under Supervision</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->hod->department->students()->count() }}</dd>
                            </div>
                        </dl>
                    </div>
                @elseif(auth()->user()->isWarden())
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->warden->employee_id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hostel Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(auth()->user()->warden->hostel_type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Appointment Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->warden->appointment_date->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Hostellers</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ App\Models\Student::where('hosteller', 'yes')->count() }}</dd>
                            </div>
                        </dl>
                    </div>
                @endif
            </div>

            <!-- Parent Information (for students) -->
            @if(auth()->user()->isStudent())
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Parent/Guardian Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Parent Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->parent_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Parent Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $student->parent_phone }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            @endif

            <!-- Account Actions -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Account Actions</h3>
                <div class="flex space-x-4">
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Edit Profile
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Change Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
