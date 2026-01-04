@extends('layouts.gatepass')

@section('title', 'Admin Dashboard')

@section('content')
<div x-data="adminDashboard()" x-init="initCharts()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">System overview and management</p>
    </div>

    <!-- System Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in" style="animation-delay: 0.1s">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Gatepasses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_gatepasses'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in" style="animation-delay: 0.2s">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Requests</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_gatepasses'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in" style="animation-delay: 0.3s">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Departments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['departments'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Distribution Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">User Distribution</h2>
            <div class="h-64">
                <canvas id="userDistributionChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Gatepass Status Overview</h2>
            <div class="h-64">
                <canvas id="gatepassStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.users.create') }}" class="btn-primary w-full flex items-center justify-center px-4 py-3 text-white font-medium rounded-lg hover:shadow-lg transition-shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Add New User
                    </a>
                    <a href="{{ route('admin.departments.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Add Department
                    </a>
                    <a href="{{ route('admin.reports') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        View Reports
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Gatepasses -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Gatepass Activity</h2>
                    <a href="{{ route('admin.reports') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentGatepasses as $gatepass)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $gatepass->student->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $gatepass->student->register_number }} • {{ $gatepass->student->department->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-900">{{ $gatepass->gatepass_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $gatepass->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($gatepass->reason, 50) }}</p>
                            </div>
                            <div class="ml-4">
                                @if($gatepass->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($gatepass->status === 'final_approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $gatepass->status }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">No recent gatepass activity</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function adminDashboard() {
    return {
        initCharts() {
            // User Distribution Chart
            const userCtx = document.getElementById('userDistributionChart');
            if (userCtx) {
                new Chart(userCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Students', 'Staff', 'HODs', 'Wardens', 'Admins'],
                        datasets: [{
                            data: [
                                {{ $stats['students'] }},
                                {{ $stats['staff'] }},
                                {{ $stats['hods'] }},
                                {{ $stats['wardens'] }},
                                {{ $stats['admins'] }}
                            ],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(168, 85, 247, 0.8)',
                                'rgba(251, 146, 60, 0.8)',
                                'rgba(239, 68, 68, 0.8)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            }

            // Gatepass Status Chart
            const statusCtx = document.getElementById('gatepassStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Pending', 'Approved', 'Rejected'],
                        datasets: [{
                            label: 'Gatepasses',
                            data: [
                                {{ $stats['pending_gatepasses'] }},
                                {{ $stats['approved_gatepasses'] }},
                                {{ $stats['rejected_gatepasses'] }}
                            ],
                            backgroundColor: [
                                'rgba(250, 204, 21, 0.8)',
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(239, 68, 68, 0.8)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    }
}
</script>
@endsection
