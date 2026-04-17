@extends('layouts.gatepass')

@section('title', 'Security Dashboard')

@section('content')
<div x-data="securityDashboard()" x-init="initCharts()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Security Dashboard</h1>
        <p class="text-gray-600 mt-2">Gatepass verification and entry/exit management</p>
    </div>

    <!-- Security Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Gatepasses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingGatepasses }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Approved Gatepasses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $approvedGatepasses }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in" style="animation-delay: 0.2s">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Rejected Gatepasses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $rejectedGatepasses }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-xl p-6 card-hover animate-fade-in" style="animation-delay: 0.3s">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Today's Activity</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $todayExits }} Exits / {{ $todayEntries }} Entries</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Entry/Exit Activity Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Today's Entry/Exit Activity</h2>
            <div class="h-64">
                <canvas id="activityChart"></canvas>
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
                    <a href="{{ route('security.scan') }}" class="btn-primary w-full flex items-center justify-center px-4 py-3 text-white font-medium rounded-lg hover:shadow-lg transition-shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Scan QR Code
                    </a>
                    <button @click="quickVerify()" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Verify Gatepass
                    </button>
                    <a href="{{ route('security.logs') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        View Logs
                    </a>
                </div>
                
                <!-- Manual Entry -->
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Manual Gatepass Entry</h3>
                    <input type="text" x-model="gatepassId" placeholder="Enter Gatepass ID" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <button @click="verifyGatepass()" class="mt-2 w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        Verify
                    </button>
                    <div x-show="verificationResult" x-html="verificationResult" class="mt-2"></div>
                </div>
            </div>
        </div>

        <!-- Recent Gatepasses -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Today's Gatepasses</h2>
                    <a href="{{ route('security.gatepasses') }}" class="text-red-600 hover:text-red-800 text-sm font-medium">
                        View All
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentGatepasses as $gatepass)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $gatepass->student->name ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600">{{ $gatepass->student->register_number ?? 'N/A' }} • {{ $gatepass->student->department->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-900">{{ $gatepass->gatepass_date }}</p>
                                        <p class="text-xs text-gray-500">{{ $gatepass->out_time }} - {{ $gatepass->in_time ?? 'Pending' }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($gatepass->reason, 50) }}</p>
                            </div>
                            <div class="ml-4">
                                @switch($gatepass->status)
                                    @case('pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                        @break
                                    @case('final_approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $gatepass->status }}
                                        </span>
                                @endswitch
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">No gatepasses found for today</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function securityDashboard() {
    return {
        gatepassId: '',
        verificationResult: '',
        
        initCharts() {
            // Activity Chart
            const activityCtx = document.getElementById('activityChart');
            if (activityCtx) {
                new Chart(activityCtx, {
                    type: 'line',
                    data: {
                        labels: ['6AM', '8AM', '10AM', '12PM', '2PM', '4PM', '6PM', '8PM'],
                        datasets: [{
                            label: 'Exits',
                            data: [2, 5, 3, 8, 12, 7, 4, 2],
                            borderColor: 'rgba(239, 68, 68, 1)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Entries',
                            data: [1, 3, 2, 6, 10, 5, 3, 1],
                            borderColor: 'rgba(34, 197, 94, 1)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
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

            // Gatepass Status Chart
            const statusCtx = document.getElementById('gatepassStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Approved', 'Rejected'],
                        datasets: [{
                            data: [{{ $pendingGatepasses }}, {{ $approvedGatepasses }}, {{ $rejectedGatepasses }}],
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
                                position: 'bottom',
                            }
                        }
                    }
                });
            }
        },
        
        verifyGatepass() {
            if (!this.gatepassId.trim()) {
                this.verificationResult = '<div class="p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">Please enter a gatepass ID</div>';
                return;
            }
            
            fetch('{{ route("security.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ gatepass_id: this.gatepassId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.verificationResult = `
                        <div class="p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            <h6 class="font-semibold">✓ Gatepass Found!</h6>
                            <p><strong>Student:</strong> ${data.student?.name || 'N/A'}</p>
                            <p><strong>Status:</strong> <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">${data.status_text}</span></p>
                            <p><strong>Date:</strong> ${data.gatepass?.gatepass_date || 'N/A'}</p>
                            <p><strong>Time:</strong> ${data.gatepass?.out_time || 'N/A'} - ${data.gatepass?.in_time || 'Pending'}</p>
                            <p><strong>Reason:</strong> ${data.gatepass?.reason || 'N/A'}</p>
                        </div>
                    `;
                } else {
                    this.verificationResult = `<div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded">✗ ${data.message}</div>`;
                }
            })
            .catch(error => {
                this.verificationResult = '<div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded">Error verifying gatepass</div>';
            });
        },
        
        quickVerify() {
            const gatepassId = prompt('Enter Gatepass ID for quick verification:');
            if (gatepassId) {
                this.gatepassId = gatepassId;
                this.verifyGatepass();
            }
        }
    }
}
</script>
