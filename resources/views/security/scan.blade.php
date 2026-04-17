@extends('layouts.gatepass')

@section('title', 'QR Code Scanner')

@section('content')
<div x-data="qrScanner()" x-init="initScanner()">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">QR Code Scanner</h1>
                <p class="text-gray-600 mt-2">Scan gatepass QR codes for instant verification</p>
            </div>
            <a href="{{ route('security.dashboard') }}" class="flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- QR Scanner Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">QR Code Scanner</h2>
                    <div class="flex items-center space-x-2">
                        <span x-show="isScanning" class="flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                            Scanning
                        </span>
                        <span x-show="!isScanning" class="flex items-center px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-1"></span>
                            Ready
                        </span>
                    </div>
                </div>
                
                <!-- Scanner Container -->
                <div class="relative">
                    <div id="qr-reader" class="w-full max-w-md mx-auto">
                        <video id="qr-video" class="w-full rounded-lg border-2 border-gray-300" :class="isScanning ? 'border-red-500 ring-4 ring-red-200' : ''"></video>
                        <canvas id="qr-canvas" class="hidden"></canvas>
                    </div>
                    
                    <!-- Scanner Controls -->
                    <div class="mt-6 flex justify-center space-x-4">
                        <button @click="startScanning" x-show="!isScanning" class="flex items-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Start Scanning
                        </button>
                        <button @click="stopScanning" x-show="isScanning" class="flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                            </svg>
                            Stop Scanning
                        </button>
                    </div>
                    
                    <!-- Scan Result -->
                    <div x-show="scanResult" x-html="scanResult" class="mt-4"></div>
                </div>
            </div>
        </div>

        <!-- Manual Entry Section -->
        <div class="lg:col-span-1">
            <!-- Manual Entry -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Manual Entry</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gatepass ID / QR Code</label>
                        <input type="text" x-model="manualGatepassId" placeholder="Enter gatepass ID or paste QR code" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                    <button @click="verifyManualGatepass()" class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Verify Gatepass
                    </button>
                    <div x-show="manualResult" x-html="manualResult" class="mt-2"></div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <button @click="quickExit()" class="w-full flex items-center justify-center px-4 py-3 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Quick Exit
                    </button>
                    <button @click="quickEntry()" class="w-full flex items-center justify-center px-4 py-3 bg-green-100 text-green-700 font-medium rounded-lg hover:bg-green-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Quick Entry
                    </button>
                    <a href="{{ route('security.logs') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        View Logs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gatepass Details Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">Gatepass Details</h3>
                            <div class="mt-2" x-html="modalContent"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Close
                    </button>
                    <button @click="markExitFromModal()" x-show="canMarkExit" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Mark Exit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
function qrScanner() {
    return {
        isScanning: false,
        scanner: null,
        manualGatepassId: '',
        scanResult: '',
        manualResult: '',
        showModal: false,
        modalContent: '',
        canMarkExit: false,
        currentGatepass: null,
        
        initScanner() {
            // Initialize scanner when component loads
        },
        
        startScanning() {
            this.isScanning = true;
            this.scanResult = '<div class="p-3 bg-blue-100 border border-blue-400 text-blue-700 rounded">Initializing scanner...</div>';
            
            const videoElement = document.getElementById('qr-video');
            
            this.scanner = new Html5Qrcode(
                videoElement,
                { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                }
            );
            
            this.scanner.start(
                { facingMode: "environment" },
                {
                    qrbox: { width: 250, height: 250 }
                },
                (decodedText, decodedResult) => {
                    this.onScanSuccess(decodedText, decodedResult);
                },
                (errorMessage) => {
                    // Handle scan failure silently
                    console.warn('QR scan failure:', errorMessage);
                }
            ).catch((err) => {
                this.scanResult = `<div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded">Camera access denied or unavailable</div>`;
                this.isScanning = false;
            });
        },
        
        stopScanning() {
            if (this.scanner) {
                this.scanner.stop().then(() => {
                    this.isScanning = false;
                    this.scanner = null;
                }).catch((err) => {
                    console.error('Failed to stop scanning:', err);
                });
            }
        },
        
        onScanSuccess(decodedText, decodedResult) {
            this.stopScanning();
            this.verifyGatepass(decodedText);
        },
        
        verifyManualGatepass() {
            if (!this.manualGatepassId.trim()) {
                this.manualResult = '<div class="p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">Please enter a gatepass ID</div>';
                return;
            }
            this.verifyGatepass(this.manualGatepassId);
        },
        
        verifyGatepass(gatepassId) {
            this.scanResult = '<div class="p-3 bg-blue-100 border border-blue-400 text-blue-700 rounded">Verifying gatepass...</div>';
            this.manualResult = '';
            
            fetch('{{ route("security.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ gatepass_id: gatepassId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.currentGatepass = data.gatepass;
                    this.showGatepassDetails(data);
                    
                    this.scanResult = `
                        <div class="p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            <h6 class="font-semibold">✓ Gatepass Verified!</h6>
                            <p><strong>Student:</strong> ${data.student?.name || 'N/A'}</p>
                            <p><strong>Status:</strong> <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">${data.status_text}</span></p>
                            <p><strong>Date:</strong> ${data.gatepass?.gatepass_date || 'N/A'}</p>
                            <p><strong>Time:</strong> ${data.gatepass?.out_time || 'N/A'} - ${data.gatepass?.in_time || 'Pending'}</p>
                        </div>
                    `;
                } else {
                    this.scanResult = `<div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded">✗ ${data.message}</div>`;
                }
            })
            .catch(error => {
                this.scanResult = '<div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded">Error verifying gatepass</div>';
            });
        },
        
        showGatepassDetails(data) {
            this.modalContent = `
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-900">Student Information</h4>
                        <div class="mt-2 space-y-1">
                            <p><strong>Name:</strong> ${data.student?.name || 'N/A'}</p>
                            <p><strong>Register No:</strong> ${data.student?.register_number || 'N/A'}</p>
                            <p><strong>Department:</strong> ${data.student?.department?.name || 'N/A'}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Gatepass Details</h4>
                        <div class="mt-2 space-y-1">
                            <p><strong>ID:</strong> ${data.gatepass?.id || 'N/A'}</p>
                            <p><strong>Date:</strong> ${data.gatepass?.gatepass_date || 'N/A'}</p>
                            <p><strong>Out Time:</strong> ${data.gatepass?.out_time || 'N/A'}</p>
                            <p><strong>In Time:</strong> ${data.gatepass?.in_time || 'Pending'}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Reason</h4>
                        <p class="mt-2">${data.gatepass?.reason || 'N/A'}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Status</h4>
                        <p class="mt-2"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">${data.status_text}</span></p>
                    </div>
                </div>
            `;
            
            this.canMarkExit = data.gatepass?.status === 'final_approved';
            this.showModal = true;
        },
        
        markExitFromModal() {
            if (this.currentGatepass) {
                this.markExit(this.currentGatepass.id);
                this.showModal = false;
            }
        },
        
        markExit(gatepassId) {
            fetch('{{ route("security.mark.exit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ gatepass_id: gatepassId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Exit marked successfully!');
                    this.currentGatepass = null;
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error marking exit. Please try again.');
            });
        },
        
        quickExit() {
            const gatepassId = prompt('Enter Gatepass ID for exit:');
            if (gatepassId) {
                this.markExit(gatepassId);
            }
        },
        
        quickEntry() {
            const studentId = prompt('Enter Student ID for entry:');
            if (studentId) {
                fetch('{{ route("security.mark.entry") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ student_id: studentId })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    alert('Error marking entry. Please try again.');
                });
            }
        }
    }
}
</script>
@endsection
