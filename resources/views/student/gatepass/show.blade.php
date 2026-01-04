@extends('layouts.gatepass')

@section('title', 'Gatepass Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gatepass Details</h1>
            <p class="text-gray-600 mt-2">View your gatepass request information</p>
        </div>
        <a href="{{ route('student.gatepasses.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to My Gatepasses
        </a>
    </div>

    <!-- Gatepass Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Status Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Gatepass #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</h2>
                    <p class="text-sm text-gray-600 mt-1">Submitted on {{ $gatepass->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <div class="text-right">
                    @if($gatepass->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Pending
                        </span>
                    @elseif($gatepass->status === 'staff_approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Staff Approved
                        </span>
                    @elseif($gatepass->status === 'hod_approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            HOD Approved
                        </span>
                    @elseif($gatepass->status === 'final_approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Final Approved
                        </span>
                    @elseif(in_array($gatepass->status, ['staff_rejected', 'hod_rejected', 'warden_rejected', 'final_rejected']))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Rejected
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ $gatepass->status }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Information -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Student Information</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Name:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->student->user->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Register Number:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->student->register_number }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Department:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->student->department->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Semester:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->student->semester }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Hosteller:</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                @if($gatepass->student->hosteller === 'yes')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Yes</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">No</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Gatepass Details -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Gatepass Details</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Date:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->gatepass_date->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Out Time:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->out_time->format('h:i A') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">In Time:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->in_time->format('h:i A') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Duration:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $gatepass->out_time->diffInHours($gatepass->in_time) }} hours</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Reason -->
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-3">Reason for Gatepass</h3>
                <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-4">{{ $gatepass->reason }}</p>
            </div>

            <!-- Approval Timeline -->
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-3">Approval Timeline</h3>
                <div class="space-y-3">
                    <!-- Staff Approval -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($gatepass->staff_approved_at)
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Staff Approval</p>
                            @if($gatepass->staff_approved_at)
                                <p class="text-xs text-gray-500">{{ $gatepass->staffApprovedBy->name ?? 'N/A' }} • {{ $gatepass->staff_approved_at->format('M d, Y h:i A') }}</p>
                                @if($gatepass->staff_remarks)
                                    <p class="text-xs text-gray-600 mt-1">Remarks: {{ $gatepass->staff_remarks }}</p>
                                @endif
                            @else
                                <p class="text-xs text-gray-500">Pending</p>
                            @endif
                        </div>
                    </div>

                    <!-- HOD Approval -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($gatepass->hod_approved_at)
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">HOD Approval</p>
                            @if($gatepass->hod_approved_at)
                                <p class="text-xs text-gray-500">{{ $gatepass->hodApprovedBy->name ?? 'N/A' }} • {{ $gatepass->hod_approved_at->format('M d, Y h:i A') }}</p>
                                @if($gatepass->hod_remarks)
                                    <p class="text-xs text-gray-600 mt-1">Remarks: {{ $gatepass->hod_remarks }}</p>
                                @endif
                            @else
                                <p class="text-xs text-gray-500">Pending</p>
                            @endif
                        </div>
                    </div>

                    <!-- Warden Approval (for hostellers) -->
                    @if($gatepass->student->hosteller === 'yes')
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($gatepass->warden_approved_at)
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Warden Approval</p>
                                @if($gatepass->warden_approved_at)
                                    <p class="text-xs text-gray-500">{{ $gatepass->wardenApprovedBy->name ?? 'N/A' }} • {{ $gatepass->warden_approved_at->format('M d, Y h:i A') }}</p>
                                    @if($gatepass->warden_remarks)
                                        <p class="text-xs text-gray-600 mt-1">Remarks: {{ $gatepass->warden_remarks }}</p>
                                    @endif
                                @else
                                    <p class="text-xs text-gray-500">Pending</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    @if($gatepass->isFinalApproved())
                        <p class="text-green-600 font-medium">✓ This gatepass has been approved</p>
                    @elseif($gatepass->isRejected())
                        <p class="text-red-600 font-medium">✗ This gatepass has been rejected</p>
                    @else
                        <p>This gatepass is currently being processed</p>
                    @endif
                </div>
                <div class="flex space-x-3">
                    @if($gatepass->isFinalApproved())
                        <a href="{{ route('student.gatepasses.download', $gatepass) }}" class="btn-primary px-4 py-2 text-white rounded-lg flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download PDF
                        </a>
                    @endif
                    <a href="{{ route('student.gatepasses.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
