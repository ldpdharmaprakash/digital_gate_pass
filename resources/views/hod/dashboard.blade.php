@extends('layouts.gatepass')

@section('title', 'HOD Dashboard')

@section('content')
<div x-data="hodDashboard()" x-init="initCharts()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">HOD Dashboard</h1>
        <p class="text-gray-600 mt-2">Department gatepass management and oversight</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Approval</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalRequests }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Approved Today</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $approvedToday }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in" style="animation-delay: 0.2s">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Rejected Today</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $rejectedToday }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in" style="animation-delay: 0.3s">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Department Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $departmentStats['total'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Total Requests</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $departmentStats['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">All time</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Pending</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $departmentStats['pending'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Awaiting approval</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Approved</h3>
            <p class="text-2xl font-bold text-green-600">{{ $departmentStats['approved'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Final approved</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Rejected</h3>
            <p class="text-2xl font-bold text-red-600">{{ $departmentStats['rejected'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Not approved</p>
        </div>
    </div>

    <!-- Quick Actions & Pending Requests -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('hod.gatepasses.pending') }}" class="btn-primary w-full flex items-center justify-center px-4 py-3 text-white font-medium rounded-lg hover:shadow-lg transition-shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pending Approvals
                    </a>
                    <a href="{{ route('hod.gatepasses.department') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Department Requests
                    </a>
                    <a href="{{ route('hod.reports') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Department Reports
                    </a>
                </div>
            </div>

            <!-- Department Info -->
            <div class="mt-6 bg-purple-50 border border-purple-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-purple-900 mb-2">Department Information</h3>
                <div class="space-y-2 text-sm text-purple-800">
                    <p><strong>Department:</strong> {{ auth()->user()->hod->department->name }}</p>
                    <p><strong>Code:</strong> {{ auth()->user()->hod->department->code }}</p>
                    <p><strong>Employee ID:</strong> {{ auth()->user()->hod->employee_id }}</p>
                    <p><strong>Total Students:</strong> {{ auth()->user()->hod->department->students()->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Pending Your Approval</h2>
                    <a href="{{ route('hod.gatepasses.pending') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($pendingGatepasses as $gatepass)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $gatepass->student->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $gatepass->student->register_number }} • {{ $gatepass->gatepass_date->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-900">{{ $gatepass->out_time->format('H:i') }} - {{ $gatepass->in_time->format('H:i') }}</p>
                                        <p class="text-xs text-gray-500">Staff: {{ $gatepass->staffApprovedBy->name }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($gatepass->reason, 80) }}</p>
                            </div>
                            <div class="ml-4">
                                <form action="{{ route('hod.gatepasses.approve', $gatepass) }}" method="POST" class="flex space-x-2">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                                        Approve
                                    </button>
                                    <button type="submit" name="action" value="reject" class="px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500">No pending approvals</p>
                            <p class="text-sm text-gray-400 mt-1">All staff-approved requests have been processed</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends Chart -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Monthly Gatepass Trends</h2>
        <div class="h-64">
            <canvas id="monthlyTrendsChart"></canvas>
        </div>
    </div>
</div>

<script>
function hodDashboard() {
    return {
        initCharts() {
            const ctx = document.getElementById('monthlyTrendsChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Gatepass Requests',
                            data: [65, 78, 90, 81, 95, 110, 125, 140, 130, 145, 160, 155],
                            borderColor: 'rgb(168, 85, 247)',
                            backgroundColor: 'rgba(168, 85, 247, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
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
