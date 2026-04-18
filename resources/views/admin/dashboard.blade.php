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
                    <i class="fas fa-users text-blue-600"></i>
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
                    <i class="fas fa-file-alt text-green-600"></i>
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
                    <i class="fas fa-clock text-yellow-600"></i>
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
                    <i class="fas fa-chart-bar text-purple-600"></i>
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
                        <i class="fas fa-user-plus mr-2"></i>
                        Add New User
                    </a>
                    <a href="{{ route('admin.departments.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-building mr-2"></i>
                        Add Department
                    </a>
                    <a href="{{ route('admin.reports') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-chart-bar mr-2"></i>
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
                            <i class="fas fa-inbox text-gray-400 mx-auto mb-4"></i>
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
