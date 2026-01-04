@extends('layouts.gatepass')

@section('title', 'Warden Dashboard')

@section('content')
<div x-data="wardenDashboard()" x-init="initCharts()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Warden Dashboard</h1>
        <p class="text-gray-600 mt-2">Hostel gatepass management and verification</p>
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
                <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Hostellers</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $hostellerStats['total'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hosteller Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Total Requests</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $hostellerStats['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">All time</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Pending</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $hostellerStats['pending'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Awaiting approval</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Approved</h3>
            <p class="text-2xl font-bold text-green-600">{{ $hostellerStats['approved'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Final approved</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Rejected</h3>
            <p class="text-2xl font-bold text-red-600">{{ $hostellerStats['rejected'] }}</p>
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
                    <a href="{{ route('warden.gatepasses.pending') }}" class="btn-primary w-full flex items-center justify-center px-4 py-3 text-white font-medium rounded-lg hover:shadow-lg transition-shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pending Approvals
                    </a>
                    <a href="{{ route('warden.verification') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Verify Gatepass
                    </a>
                    <a href="{{ route('warden.reports') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Hostel Reports
                    </a>
                </div>
            </div>

            <!-- Hostel Info -->
            <div class="mt-6 bg-orange-50 border border-orange-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-orange-900 mb-2">Hostel Information</h3>
                <div class="space-y-2 text-sm text-orange-800">
                    <p><strong>Hostel Type:</strong> {{ ucfirst(auth()->user()->warden->hostel_type) }}</p>
                    <p><strong>Employee ID:</strong> {{ auth()->user()->warden->employee_id }}</p>
                    <p><strong>Total Hostellers:</strong> {{ App\Models\Student::where('hosteller', 'yes')->count() }}</p>
                    <p><strong>Active Today:</strong> {{ App\Models\Gatepass::whereDate('gatepass_date', today())->whereHas('student', function($q) { $q->where('hosteller', 'yes'); })->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Pending Your Approval</h2>
                    <a href="{{ route('warden.gatepasses.pending') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
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
                                        <p class="text-sm text-gray-600">{{ $gatepass->student->register_number }} • {{ $gatepass->student->department->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-900">{{ $gatepass->gatepass_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $gatepass->out_time->format('H:i') }} - {{ $gatepass->in_time->format('H:i') }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($gatepass->reason, 80) }}</p>
                            </div>
                            <div class="ml-4">
                                <form action="{{ route('warden.gatepasses.approve', $gatepass) }}" method="POST" class="flex space-x-2">
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
                            <p class="text-sm text-gray-400 mt-1">All HOD-approved requests have been processed</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Hostel Activity Chart -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Weekly Hostel Activity</h2>
        <div class="h-64">
            <canvas id="hostelActivityChart"></canvas>
        </div>
    </div>
</div>

<script>
function wardenDashboard() {
    return {
        initCharts() {
            const ctx = document.getElementById('hostelActivityChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{
                            label: 'Gatepasses Approved',
                            data: [8, 12, 6, 15, 18, 22, 5],
                            backgroundColor: 'rgba(251, 146, 60, 0.8)',
                            borderColor: 'rgb(251, 146, 60)',
                            borderWidth: 1
                        }, {
                            label: 'Active Today',
                            data: [3, 5, 2, 8, 10, 12, 1],
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderColor: 'rgb(34, 197, 94)',
                            borderWidth: 1
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
