@extends('layouts.gatepass')

@section('title', 'Bulk User Upload')

@section('content')
<div class="container-fluid px-3 py-4">
    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full shadow-lg">
            <i class="fas fa-users text-white mr-3"></i>
            <h1 class="text-2xl font-bold text-white">Bulk User Upload</h1>
        </div>
        <p class="text-gray-600 mt-4 text-lg">Efficiently import multiple users at once with our streamlined bulk upload system</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start">
            <i class="fas fa-check-circle text-green-400 mr-3 flex-shrink-0"></i>
            <div class="flex-1">
                <h3 class="text-green-800 font-semibold">Upload Successful!</h3>
                <p class="text-green-700 mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-start">
            <i class="fas fa-exclamation-circle text-red-400 mr-3 flex-shrink-0"></i>
            <div class="flex-1">
                <h3 class="text-red-800 font-semibold">Upload Failed!</h3>
                <p class="text-red-700 mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if(session('errors') && session('errors') > 0)
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 flex-shrink-0"></i>
                <div class="flex-1">
                    <h3 class="text-yellow-800 font-semibold">Warning - {{ session('errors') }} Errors Found</h3>
                    <p class="text-yellow-700 mt-1">Some records could not be imported. Please review the details below:</p>
                    @if(session('error_details'))
                        <div class="mt-3 bg-yellow-100 rounded p-3">
                            <ul class="list-disc list-inside space-y-1 text-sm text-yellow-800">
                                @foreach(session('error_details') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- Left Column - Instructions & Upload -->
        <div class="xl:col-span-3 space-y-6">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('errors') && session('errors') > 0)
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>{{ session('errors') }} errors occurred during import:</strong>
                            <ul>
                                @if(session('error_details'))
                                    @foreach(session('error_details') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif

                    <!-- Step 1: Download Template -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-download text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Download Templates</h3>
                                <p class="text-gray-600 mt-1">Choose the appropriate CSV template for the user type you want to upload</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="group relative bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-all duration-200 hover:border-blue-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                        <i class="fas fa-user-graduate text-blue-600"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600">Students</h4>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Upload student data with class assignments</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">Includes: name, email, department, class, semester</span>
                                    <a href="{{ route('admin.download-template', 'students') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 w-full justify-center">
                                        <i class="fas fa-download text-white mr-2"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                            
                            <div class="group relative bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-all duration-200 hover:border-green-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                        <i class="fas fa-briefcase text-green-600"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-600">Staff</h4>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Upload staff data with class incharge assignments</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">Includes: designation, qualifications, class incharge</span>
                                    <a href="{{ route('admin.download-template', 'staff') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 w-full justify-center">
                                        <i class="fas fa-download text-white mr-2"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                            
                            <div class="group relative bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-all duration-200 hover:border-yellow-300 ">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                                        <i class="fas fa-user-tie text-yellow-600"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-yellow-600">HODs</h4>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Upload Head of Department data</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">Includes: department, qualifications, class IDs</span>
                                    <a href="{{ route('admin.download-template', 'hods') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-150 w-full justify-center" style="background-color: #ea580c !important; background: #ea580c !important; color: #ffffff !important;" onmouseover="this.style.backgroundColor='#c2410c'" onmouseout="this.style.backgroundColor='#ea580c'">
                                        <i class="fas fa-download text-white mr-2"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                            
                            <div class="group relative bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-all duration-200 hover:border-purple-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                        <i class="fas fa-building text-purple-600"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600">Wardens</h4>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">Upload warden data</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">Includes: hostel type, appointment</span>
                                    <a href="{{ route('admin.download-template', 'wardens') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-150 w-full justify-center" style="background-color: #db2777 !important; background: #db2777 !important; color: #ffffff !important;" onmouseover="this.style.backgroundColor='#be185d'" onmouseout="this.style.backgroundColor='#db2777'">
                                        <i class="fas fa-download text-white mr-2"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Fill Template -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 mt-8">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Fill Template Instructions</h3>
                                <p class="text-gray-600 mt-1">Follow these guidelines to ensure successful import</p>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="text-blue-800 font-semibold mb-3 flex items-center">
                                <i class="fas fa-info-circle text-blue-800 mr-2"></i>
                                Important Instructions
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-blue-800">
                                <div>
                                    <h5 class="font-semibold text-blue-900 mb-2">✅ Required Fields</h5>
                                    <ul class="space-y-2">
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-blue-600 mr-2 flex-shrink-0 mt-0.5"></i>
                                            <span>Fill the downloaded CSV template with your data</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-blue-600 mr-2 flex-shrink-0 mt-0.5"></i>
                                            <span>Do not change the column headers</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-blue-600 mr-2 flex-shrink-0 mt-0.5"></i>
                                            <span>All required fields must be filled</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-blue-900 mb-2">⚠️ Important Notes</h5>
                                    <ul class="space-y-2">
                                        <li class="flex items-start">
                                            <i class="fas fa-exclamation text-yellow-600 mr-2 flex-shrink-0 mt-0.5"></i>
                                            <span>Use valid college_id and department_id</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-exclamation text-yellow-600 mr-2 flex-shrink-0 mt-0.5"></i>
                                            <span>Passwords will be automatically hashed</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-exclamation text-yellow-600 mr-2 flex-shrink-0 mt-0.5"></i>
                                            <span>Save file as CSV format</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Upload File -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 mt-8">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-cloud-upload-alt text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Upload CSV File</h3>
                                <p class="text-gray-600 mt-1">Select user type and upload your filled CSV template</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.process-bulk-upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <div>
                                <label for="user_type" class="block text-sm font-medium text-gray-700 mb-2">User Type <span class="text-red-500">*</span></label>
                                <select id="user_type" name="user_type" required class="mt-1 block w-full pl-3 pr-10 py-3 border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Select User Type</option>
                                    <option value="students">👨‍🎓 Students</option>
                                    <option value="staff">👨‍🏫 Staff Members</option>
                                    <option value="hods">👔‍💼 Heads of Department</option>
                                    <option value="wardens">🏢 Wardens</option>
                                </select>
                            </div>

                            <div>
                                <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">CSV File <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-lg">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-file-csv text-gray-400"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="csv_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:ring-2 focus-within:border-blue-500">
                                                <span id="file-label-text">Choose CSV file</span>
                                                <input id="csv_file" name="csv_file" type="file" class="sr-only" accept=".csv" required>
                                            </label>
                                            <p class="text-xs text-gray-500">CSV format only. Maximum 10MB.</p>
                                        </div>
                                        <div id="selected-file-info" class="mt-2 text-sm text-gray-600 hidden">
                                            <span class="font-medium">Selected file:</span> <span id="selected-file-name" class="text-blue-600"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 shadow-lg">
                                    <i class="fas fa-upload mr-2"></i>
                                    Upload Users
                                </button>
                                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 shadow-md">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Reference Data -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-book text-indigo-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Quick Reference Guide</h3>
                                <p class="text-gray-600 mt-1">Use these IDs when filling your CSV templates</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- College IDs -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4">
                                <h4 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                                    <i class="fas fa-university text-blue-800 mr-2"></i>
                                    College IDs
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-blue-600">1</span>
                                        <span class="text-gray-700">Engineering College</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-blue-600">2</span>
                                        <span class="text-gray-700">Arts & Science College</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-blue-600">3</span>
                                        <span class="text-gray-700">Polytechnic College</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Department IDs -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4">
                                <h4 class="text-lg font-semibold text-green-900 mb-3 flex items-center">
                                    <i class="fas fa-university text-green-800 mr-2"></i>
                                    Department IDs
                                </h4>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-green-600">1</span>
                                        <span class="text-gray-700">Computer Science & Engineering</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-green-600">2</span>
                                        <span class="text-gray-700">Electronics & Communication Engineering</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-green-600">3</span>
                                        <span class="text-gray-700">Mechanical Engineering</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-green-600">4</span>
                                        <span class="text-gray-700">Civil Engineering</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-green-600">5</span>
                                        <span class="text-gray-700">Electrical & Electronics Engineering</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-green-600">101</span>
                                        <span class="text-gray-700">B.A Tamil</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-green-600">102</span>
                                        <span class="text-gray-700">B.A English</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Class IDs -->
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4">
                                <h4 class="text-lg font-semibold text-purple-900 mb-3 flex items-center">
                                    <i class="fas fa-chalkboard text-purple-800 mr-2"></i>
                                    Sample Class IDs
                                </h4>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-purple-600">24</span>
                                        <span class="text-gray-700">CSE 1st Year A</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-purple-600">25</span>
                                        <span class="text-gray-700">CSE 1st Year B</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-purple-600">26</span>
                                        <span class="text-gray-700">CSE 2nd Year A</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-purple-600">28</span>
                                        <span class="text-gray-700">ECE 1st Year A</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 px-3 bg-white rounded-md">
                                        <span class="font-mono text-purple-600">36</span>
                                        <span class="text-gray-700">Tamil 1st Year A</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.step-section {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #f8f9fa;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .grid-cols-1.sm\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .bg-white.rounded-xl.shadow-lg.p-6 {
        padding: 1rem;
    }
    
    .bg-white.rounded-lg.border.border-gray-200.p-6 {
        padding: 1rem;
    }
}

@media (min-width: 641px) and (max-width: 1024px) {
    .container-fluid {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
}

/* Full width utilization */
.container-fluid {
    max-width: 100%;
    width: 100%;
}

/* Better button styling */
.btn-full-width {
    width: 100%;
}

@media (min-width: 640px) {
    .btn-full-width {
        width: auto;
    }
}

/* Ensure button background colors are displayed */
.bg-blue-600 {
    background-color: #2563eb !important;
}

.bg-green-600 {
    background-color: #16a34a !important;
}

.bg-orange-600 {
    background-color: #ea580c !important;
}

.bg-pink-600 {
    background-color: #db2777 !important;
}

/* More specific targeting for download buttons */
a[href*="download-template"].bg-orange-600 {
    background-color: #ea580c !important;
    background-image: none !important;
}

/* Even more specific targeting for HODs button */
a[href*="download-template/hods"] {
    background-color: #ea580c !important;
    background-image: none !important;
}

a[href*="download-template/hods"]:hover {
    background-color: #c2410c !important;
}

/* Specific targeting for Wardens button */
a[href*="download-template/wardens"] {
    background-color: #db2777 !important;
    background-image: none !important;
}

a[href*="download-template/wardens"]:hover {
    background-color: #be185d !important;
}

/* CSS Reset for buttons - override everything */
* {
    box-sizing: border-box;
}

/* Force button colors with maximum specificity */
.bg-orange-600,
body .bg-orange-600,
html body .bg-orange-600,
.container .bg-orange-600,
.container-fluid .bg-orange-600 {
    background-color: #ea580c !important;
    background: #ea580c !important;
    color: #ffffff !important;
}

.bg-pink-600,
body .bg-pink-600,
html body .bg-pink-600,
.container .bg-pink-600,
.container-fluid .bg-pink-600 {
    background-color: #db2777 !important;
    background: #db2777 !important;
    color: #ffffff !important;
}

/* Override any conflicting styles */
a[href*="hods"].bg-orange-600,
a[href*="hods"].bg-orange-600:hover,
a[href*="hods"][style*="background"] {
    background-color: #ea580c !important;
    background: #ea580c !important;
    color: #ffffff !important;
}

a[href*="wardens"].bg-pink-600,
a[href*="wardens"].bg-pink-600:hover,
a[href*="wardens"][style*="background"] {
    background-color: #db2777 !important;
    background: #db2777 !important;
    color: #ffffff !important;
}

a[href*="download-template"].bg-blue-600 {
    background-color: #2563eb !important;
    background-image: none !important;
}

a[href*="download-template"].bg-green-600 {
    background-color: #16a34a !important;
    background-image: none !important;
}

a[href*="download-template"].bg-pink-600 {
    background-color: #db2777 !important;
    background-image: none !important;
}

.text-white {
    color: #ffffff !important;
}

/* Button hover states */
.bg-blue-600:hover {
    background-color: #1d4ed8 !important;
}

.bg-green-600:hover {
    background-color: #15803d !important;
}

.bg-orange-600:hover {
    background-color: #c2410c !important;
}

.bg-pink-600:hover {
    background-color: #be185d !important;
}

.step-section h4 {
    color: #495057;
    margin-bottom: 15px;
    font-weight: 600;
}

.step-section h4 i {
    margin-right: 10px;
}

.card.border-primary {
    border-left: 4px solid #007bff !important;
}

.card.border-success {
    border-left: 4px solid #28a745 !important;
}

.card.border-warning {
    border-left: 4px solid #ffc107 !important;
}

.card.border-info {
    border-left: 4px solid #17a2b8 !important;
}

.custom-file-label::after {
    content: "Browse";
}

.table-sm {
    font-size: 0.875rem;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    // DOM elements cache for better performance
    const fileInput = document.getElementById('csv_file');
    const fileLabelText = document.getElementById('file-label-text');
    const selectedFileName = document.getElementById('selected-file-name');
    const selectedFileInfo = document.getElementById('selected-file-info');
    const helpText = document.querySelector('.text-xs.text-gray-500');
    const uploadForm = document.querySelector('form[action*="process-bulk-upload"]');
    
    // Constants
    const MAX_FILE_SIZE_MB = 10;
    const BYTES_TO_MB = 1024 * 1024;
    
    /**
     * Format file size in MB with 2 decimal places
     */
    function formatFileSize(bytes) {
        return (bytes / BYTES_TO_MB).toFixed(2);
    }
    
    /**
     * Update UI elements with file information
     */
    function updateFileUI(file) {
        if (!file) {
            resetFileUI();
            return;
        }
        
        try {
            const fileName = file.name;
            const fileSize = parseFloat(formatFileSize(file.size));
            const fileSizeText = `${fileName} (${fileSize} MB)`;
            
            // Update file label with name
            fileLabelText.textContent = fileName;
            selectedFileName.textContent = fileSizeText;
            selectedFileInfo.classList.remove('hidden');
            
            // Validate file size and update UI accordingly
            if (fileSize > MAX_FILE_SIZE_MB) {
                selectedFileName.classList.add('text-red-600');
                helpText.textContent = 'CSV format only. File size exceeds 10MB limit.';
            } else {
                selectedFileName.classList.remove('text-red-600');
                helpText.textContent = 'CSV format only. Maximum 10MB.';
            }
        } catch (error) {
            console.error('Error updating file UI:', error);
            resetFileUI();
        }
    }
    
    /**
     * Reset file UI to initial state
     */
    function resetFileUI() {
        fileLabelText.textContent = 'Choose CSV file';
        selectedFileInfo.classList.add('hidden');
        helpText.textContent = 'CSV format only. Maximum 10MB.';
        selectedFileName.classList.remove('text-red-600');
    }
    
    /**
     * Validate file type
     */
    function validateFileType(file) {
        const allowedTypes = ['text/csv', 'application/csv'];
        return allowedTypes.includes(file.type) || file.name.toLowerCase().endsWith('.csv');
    }
    
    /**
     * Handle file selection change
     */
    function handleFileChange(event) {
        const file = event.target.files[0];
        
        if (!file) {
            resetFileUI();
            return;
        }
        
        // Validate file type
        if (!validateFileType(file)) {
            helpText.textContent = 'Please select a valid CSV file.';
            selectedFileName.textContent = file.name;
            selectedFileName.classList.add('text-red-600');
            selectedFileInfo.classList.remove('hidden');
            return;
        }
        
        updateFileUI(file);
    }
    
    /**
     * Handle form submission
     */
    function handleFormSubmit(event) {
        // Reset file input and UI
        fileInput.value = '';
        resetFileUI();
        
        // Optional: Show loading state
        const submitButton = uploadForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
        }
    }
    
    // Event listeners
    if (fileInput) {
        fileInput.addEventListener('change', handleFileChange);
    }
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', handleFormSubmit);
    }
    
    // Handle file drag and drop (optional enhancement)
    const dropZone = fileInput.closest('.border-dashed');
    if (dropZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        dropZone.addEventListener('drop', handleDrop, false);
        dropZone.addEventListener('dragover', () => dropZone.classList.add('border-blue-400'), false);
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-blue-400'), false);
    }
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function handleDrop(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileChange({ target: { files: files } });
        }
        dropZone.classList.remove('border-blue-400');
    }
});
</script>
@endpush
