<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass Verification #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
        }
        .primary-bg {
            background-color: var(--primary-color);
        }
        .primary-border {
            border-color: var(--primary-color);
        }
        .primary-text {
            color: var(--primary-color);
        }
        .status-approved {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="primary-bg text-white p-4 no-print">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Gatepass Verification</h1>
                <p class="text-blue-100">Security Verification Portal</p>
            </div>
            <div class="text-right">
                <div class="text-lg font-mono">#{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="text-sm text-blue-100">{{ $gatepass->created_at->format('M d, Y h:i A') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto p-4">
        <!-- Status Alert -->
        <div class="status-approved text-white p-4 rounded-lg mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <div class="font-bold">Gatepass Verified</div>
                <div class="text-sm">This gatepass has been approved by all authorities</div>
            </div>
        </div>

        <!-- Student Information Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 primary-text" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    Student Information
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex items-center space-x-4">
                            <img src="{{ $studentPhotoBase64 }}" alt="Student Photo" class="w-20 h-24 rounded-lg border-2 border-gray-300 object-cover">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $gatepass->student->user->name }}</h3>
                                <p class="text-gray-600">{{ $gatepass->student->register_number }}</p>
                                <p class="text-sm text-gray-500">{{ $gatepass->student->department->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Semester:</span>
                            <span class="font-medium">{{ $gatepass->student->semester }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Section:</span>
                            <span class="font-medium">{{ $gatepass->student->section }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Hosteller:</span>
                            <span class="font-medium">{{ $gatepass->student->hosteller === 'yes' ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gatepass Details Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Gatepass Details
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold primary-text">{{ $gatepass->gatepass_date->format('d') }}</div>
                        <div class="text-gray-600">{{ $gatepass->gatepass_date->format('M Y') }}</div>
                        <div class="text-sm text-gray-500">Date</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $gatepass->out_time->format('h:i') }}</div>
                        <div class="text-gray-600">{{ $gatepass->out_time->format('A') }}</div>
                        <div class="text-sm text-gray-500">Out Time</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $gatepass->in_time->format('h:i') }}</div>
                        <div class="text-gray-600">{{ $gatepass->in_time->format('A') }}</div>
                        <div class="text-sm text-gray-500">In Time</div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h4 class="font-semibold text-gray-900 mb-2">Reason for Gatepass:</h4>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-700">{{ $gatepass->reason }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approval Status Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100-4h-.5a1 1 0 000-2H8a2 2 0 012 2v9a2 2 0 11-4 0V5z" clip-rule="evenodd"></path>
                    </svg>
                    Approval Status
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Staff Approval -->
                    <div class="text-center p-4 rounded-lg border {{ $gatepass->staff_approved_at ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full {{ $gatepass->staff_approved_at ? 'bg-green-100' : 'bg-gray-200' }} flex items-center justify-center">
                            @if($gatepass->staff_approved_at)
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <h4 class="font-semibold text-gray-900">Staff</h4>
                        @if($gatepass->staff_approved_at)
                            <p class="text-sm text-green-600">Approved</p>
                            <p class="text-xs text-gray-500">{{ $gatepass->staffApprovedBy->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400">{{ $gatepass->staff_approved_at->format('M d, h:i A') }}</p>
                        @else
                            <p class="text-sm text-gray-500">Pending</p>
                        @endif
                    </div>

                    <!-- HOD Approval -->
                    <div class="text-center p-4 rounded-lg border {{ $gatepass->hod_approved_at ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full {{ $gatepass->hod_approved_at ? 'bg-green-100' : 'bg-gray-200' }} flex items-center justify-center">
                            @if($gatepass->hod_approved_at)
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <h4 class="font-semibold text-gray-900">HOD</h4>
                        @if($gatepass->hod_approved_at)
                            <p class="text-sm text-green-600">Approved</p>
                            <p class="text-xs text-gray-500">{{ $gatepass->hodApprovedBy->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400">{{ $gatepass->hod_approved_at->format('M d, h:i A') }}</p>
                        @else
                            <p class="text-sm text-gray-500">Pending</p>
                        @endif
                    </div>

                    <!-- Warden Approval -->
                    <div class="text-center p-4 rounded-lg border {{ $gatepass->warden_approved_at ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full {{ $gatepass->warden_approved_at ? 'bg-green-100' : 'bg-gray-200' }} flex items-center justify-center">
                            @if($gatepass->warden_approved_at)
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <h4 class="font-semibold text-gray-900">Warden</h4>
                        @if($gatepass->warden_approved_at)
                            <p class="text-sm text-green-600">Approved</p>
                            <p class="text-xs text-gray-500">{{ $gatepass->wardenApprovedBy->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400">{{ $gatepass->warden_approved_at->format('M d, h:i A') }}</p>
                        @else
                            <p class="text-sm text-gray-500">Pending</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code Card -->
        @if($qrCode)
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zM13 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1V4zM13 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3z"></path>
                    </svg>
                    QR Code
                </h2>
            </div>
            <div class="p-6 text-center">
                <img src="{{ $qrCode }}" alt="Gatepass QR Code" class="w-32 h-32 mx-auto border-2 border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500 mt-2">Scan to verify this gatepass</p>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 no-print">
            <a href="{{ route('gatepass.qr.generate', $gatepass) }}" target="_blank" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                Generate QR Code
            </a>
            <a href="{{ route('student.gatepasses.download', $gatepass) }}" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download PDF
            </a>
            <button onclick="window.print()" class="flex-1 bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-800 text-white p-4 mt-8 no-print">
        <div class="max-w-4xl mx-auto text-center">
            <p class="text-sm">© {{ date('Y') }} Digital Gatepass System | Security Verification Portal</p>
        </div>
    </div>
</body>
</html>
