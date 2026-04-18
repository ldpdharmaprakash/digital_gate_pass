@extends('layouts.gatepass')

@section('title', 'Reports')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reports</h1>
            <p class="text-gray-600 mt-2">View system-wide statistics and analytics</p>
        </div>
        <a href="{{ route('admin.reports.download') }}" class="btn-primary px-6 py-3 text-white rounded-lg flex items-center">
            <i class="fas fa-file-pdf mr-2"></i>
            Download PDF Report
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-file-alt text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Requests</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $monthlyStats->sum('count') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <i class="fas fa-building text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Departments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $departmentStats->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <i class="fas fa-users text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ array_sum($roleStats) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <i class="fas fa-chart-line text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Today</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Gatepass::whereDate('gatepass_date', today())->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Monthly Statistics ({{ date('Y') }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($monthlyStats as $stat)
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">{{ \Carbon\Carbon::create()->month($stat->month)->format('F') }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stat->count }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Gatepasses</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Department Statistics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Department Statistics</h2>
        <div class="space-y-4">
            @foreach($departmentStats as $department)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ $department->name }}</p>
                        <p class="text-xs text-gray-500">{{ $department->gatepasses_count }} gatepasses</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold text-gray-900">{{ $department->gatepasses_count }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Role Statistics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">User Distribution</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">Students</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $roleStats['students'] }}</p>
            </div>
            
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">Staff</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $roleStats['staff'] }}</p>
            </div>
            
            <div class="bg-purple-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-purple-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">HODs</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $roleStats['hods'] }}</p>
            </div>
            
            <div class="bg-orange-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-orange-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">Wardens</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $roleStats['wardens'] }}</p>
            </div>
            
            <div class="bg-red-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">Admins</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $roleStats['admins'] }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
