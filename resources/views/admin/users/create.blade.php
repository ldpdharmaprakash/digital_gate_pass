@extends('layouts.gatepass')

@section('title', 'Create User')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New User</h1>
            <p class="text-gray-600 mt-2">Add a new user to the system</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
    </div>

    <!-- Create User Form -->
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h3>
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                </div>
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                    <input type="text" id="username" name="username" required value="{{ old('username') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Role Selection -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Role Assignment</h3>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                    <select id="role" name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a role</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="hod" {{ old('role') == 'hod' ? 'selected' : '' }}>HOD</option>
                        <option value="warden" {{ old('role') == 'warden' ? 'selected' : '' }}>Warden</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">Department <span class="text-red-500">*</span></label>
                    <select id="department_id" name="department_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Required for students, staff, and HODs</p>
                </div>

                <!-- Role-specific fields will be shown dynamically with JavaScript -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Additional Information</h3>
                </div>

                <!-- Student Fields -->
                <div id="student-fields" class="hidden md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="register_number" class="block text-sm font-medium text-gray-700 mb-2">Register Number <span class="text-red-500">*</span></label>
                            <input type="text" id="register_number" name="register_number" value="{{ old('register_number') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">Semester <span class="text-red-500">*</span></label>
                            <input type="text" id="semester" name="semester" value="{{ old('semester') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="hosteller" class="block text-sm font-medium text-gray-700 mb-2">Hosteller <span class="text-red-500">*</span></label>
                            <select id="hosteller" name="hosteller" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="no" {{ old('hosteller') == 'no' ? 'selected' : '' }}>No</option>
                                <option value="yes" {{ old('hosteller') == 'yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        <div>
                            <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">Parent Name <span class="text-red-500">*</span></label>
                            <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">Parent Phone <span class="text-red-500">*</span></label>
                            <input type="tel" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Staff/HOD/Warden Fields -->
                <div id="employee-fields" class="hidden md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">Employee ID <span class="text-red-500">*</span></label>
                            <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="designation" class="block text-sm font-medium text-gray-700 mb-2">Designation <span class="text-red-500">*</span></label>
                            <input type="text" id="designation" name="designation" value="{{ old('designation') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div id="hostel-type-field" class="hidden">
                            <label for="hostel_type" class="block text-sm font-medium text-gray-700 mb-2">Hostel Type <span class="text-red-500">*</span></label>
                            <select id="hostel_type" name="hostel_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="boys" {{ old('hostel_type') == 'boys' ? 'selected' : '' }}>Boys</option>
                                <option value="girls" {{ old('hostel_type') == 'girls' ? 'selected' : '' }}>Girls</option>
                                <option value="mixed" {{ old('hostel_type') == 'mixed' ? 'selected' : '' }}>Mixed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn-primary px-6 py-2 text-white rounded-lg">
                    Create User
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const studentFields = document.getElementById('student-fields');
    const employeeFields = document.getElementById('employee-fields');
    const hostelTypeField = document.getElementById('hostel-type-field');
    
    function toggleFields() {
        const role = roleSelect.value;
        
        // Hide all fields first
        studentFields.classList.add('hidden');
        employeeFields.classList.add('hidden');
        hostelTypeField.classList.add('hidden');
        
        // Show relevant fields
        if (role === 'student') {
            studentFields.classList.remove('hidden');
        } else if (role === 'staff' || role === 'hod' || role === 'warden') {
            employeeFields.classList.remove('hidden');
            if (role === 'warden') {
                hostelTypeField.classList.remove('hidden');
            }
        }
    }
    
    roleSelect.addEventListener('change', toggleFields);
    toggleFields(); // Call once on load
});
</script>
@endsection
