@extends('layouts.gatepass')

@section('title', 'Staff Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Staff Profile</h1>
        <p class="text-gray-600 mt-2">View your professional information</p>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Profile Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-cyan-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-600">{{ auth()->user()->staff->designation }} • {{ auth()->user()->email }}</p>
                    <div class="mt-2 flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Staff Member
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

                <!-- Professional Information -->
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
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Students Assigned</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->staff->assignedStudents()->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

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
