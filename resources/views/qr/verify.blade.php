<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Verification - {{ $gatepass->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .status-approved {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .status-pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .college-theme {
            background: {{ $gatepass->college->primary_color ?? '#1e40af' }};
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="college-theme text-white p-6 text-center">
                <h1 class="text-2xl font-bold mb-2">🎓 DIGITAL GATEPASS VERIFICATION</h1>
                <p class="text-sm opacity-90">{{ $gatepass->college->college_name }}</p>
            </div>
        </div>

        <!-- Verification Status -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Verification Status</h2>
                <div class="px-4 py-2 rounded-full text-white font-bold text-sm {{ $gatepass->isFinalApproved() ? 'status-approved' : 'status-pending' }}">
                    {{ $gatepass->isFinalApproved() ? '✅ APPROVED' : '⏳ PENDING' }}
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Gatepass ID</p>
                    <p class="font-semibold text-lg">#{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Verification Date</p>
                    <p class="font-semibold">{{ now()->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Student Information -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                Student Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Name</p>
                    <p class="font-medium">{{ $gatepass->student->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Register Number</p>
                    <p class="font-medium">{{ $gatepass->student->register_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Department</p>
                    <p class="font-medium">{{ $gatepass->student->department->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Semester</p>
                    <p class="font-medium">{{ $gatepass->student->semester }}</p>
                </div>
            </div>
        </div>

        <!-- Gatepass Details -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Gatepass Details
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Date</p>
                    <p class="font-medium">{{ $gatepass->gatepass_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Duration</p>
                    <p class="font-medium">{{ $gatepass->out_time->format('h:i A') }} - {{ $gatepass->in_time->format('h:i A') }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-600 mb-1">Reason</p>
                    <p class="font-medium bg-gray-50 p-3 rounded">{{ $gatepass->reason }}</p>
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                QR Code for Verification
            </h3>
            <div class="flex justify-center items-center">
                <div class="p-4 bg-white border-2 border-gray-300 rounded-lg">
                    @if($gatepass->qr_code)
                        <img src="{{ $gatepass->qr_code }}" alt="Gatepass QR Code" class="w-48 h-48" />
                    @else
                        <div class="text-center text-gray-500">
                            <svg class="w-48 h-48" viewBox="0 0 200 200">
                                <rect width="200" height="200" fill="#f3f4f6"/>
                                <text x="100" y="100" text-anchor="middle" dominant-baseline="middle" fill="#6b7280" font-size="12">
                                    QR Not Available
                                </text>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-center mt-4 text-sm text-gray-600">
                <p class="mb-2">Scan this QR code to verify gatepass details</p>
                <p class="font-mono bg-gray-100 p-2 rounded">Verification URL:</p>
                <p class="font-mono text-blue-600 font-semibold break-all">{{ url('/qr/verify/' . $gatepass->id) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                Security Information
            </h3>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Verification Notice</p>
                        <p class="text-sm text-yellow-700 mt-1">
                            This gatepass has been verified digitally. Security personnel can cross-reference this information with the physical gatepass document.
                        </p>
                        <p class="text-xs text-yellow-600 mt-2">
                            Generated on: {{ now()->format('M d, Y h:i A') }} | IP: {{ request()->ip() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-500">
            <p>© {{ date('Y') }} {{ $gatepass->college->college_name }} - Digital Gatepass System</p>
        </div>
    </div>

    <script>
        // Auto-refresh every 30 seconds for real-time updates
        setTimeout(() => {
            window.location.reload();
        }, 30000);
    </script>
</body>
</html>
