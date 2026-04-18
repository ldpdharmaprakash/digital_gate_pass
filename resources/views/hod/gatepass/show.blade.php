@extends('layouts.gatepass')

@section('title', 'Gatepass Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gatepass Details</h1>
            <p class="text-gray-600 mt-2">Review hosteller gatepass request</p>
        </div>
        <a href="{{ route('hod.gatepasses.pending') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Pending
        </a>
    </div>

    <!-- Gatepass Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <!-- Status Header -->
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3">
                        <h2 class="text-2xl font-bold text-gray-900">Gatepass #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</h2>
                        @if($gatepass->status === 'hod_approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 animate-pulse">
                                Pending Your Approval
                            </span>
                        @elseif($gatepass->status === 'final_approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Final Approved
                            </span>
                        @elseif(in_array($gatepass->status, ['staff_rejected', 'hod_rejected', 'warden_rejected', 'final_rejected']))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $gatepass->status)) }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Submitted on {{ $gatepass->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Student Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Student Information
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Name:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->student->user->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Register Number:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->student->register_number }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Department:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->student->department->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Semester:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->student->semester }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Hosteller:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->student->hosteller === 'yes' ? 'Yes' : 'Day Scholar' }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Gatepass Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Gatepass Details
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Date:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->gatepass_date->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Out Time:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->out_time->format('h:i A') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">In Time:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->in_time->format('h:i A') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Duration:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $gatepass->out_time->diffInHours($gatepass->in_time) }} hours</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-600">Status:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $gatepass->status)) }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reason -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Reason for Gatepass
                </h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-gray-900 leading-relaxed">{{ $gatepass->reason }}</p>
                </div>
            </div>

            <!-- Approval Status -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Approval Status
                </h3>
                <div class="space-y-4">
                    <!-- Staff Approval -->
                    <div class="border rounded-lg p-4 @if($gatepass->staff_approved_at) border-green-200 bg-green-50 @else border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full @if($gatepass->staff_approved_at) bg-green-100 @else bg-gray-200 flex items-center justify-center mr-3">
                                    @if($gatepass->staff_approved_at)
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Staff Approval</h4>
                                    @if($gatepass->staff_approved_at)
                                        <p class="text-xs text-gray-600">Approved by {{ $gatepass->staffApprovedBy->name }} on {{ $gatepass->staff_approved_at->format('M d, Y h:i A') }}</p>
                                    @else
                                        <p class="text-xs text-gray-600">Pending</p>
                                    @endif
                                </div>
                            </div>
                            @if($gatepass->staff_remarks)
                                <div class="text-sm text-gray-600">
                                    <strong>Remarks:</strong> {{ $gatepass->staff_remarks }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- HOD Approval -->
                    <div class="border rounded-lg p-4 @if($gatepass->hod_approved_at) border-green-200 bg-green-50 @else border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full @if($gatepass->hod_approved_at) bg-green-100 @else bg-gray-200 flex items-center justify-center mr-3">
                                    @if($gatepass->hod_approved_at)
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">HOD Approval</h4>
                                    @if($gatepass->hod_approved_at)
                                        <p class="text-xs text-gray-600">Approved by {{ $gatepass->hodApprovedBy->name }} on {{ $gatepass->hod_approved_at->format('M d, Y h:i A') }}</p>
                                    @else
                                        <p class="text-xs text-gray-600">Pending</p>
                                    @endif
                                </div>
                            </div>
                            @if($gatepass->hod_remarks)
                                <div class="text-sm text-gray-600">
                                    <strong>Remarks:</strong> {{ $gatepass->hod_remarks }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Warden Approval (if hosteller) -->
                    @if($gatepass->student->hosteller === 'yes')
                        <div class="border rounded-lg p-4 @if($gatepass->warden_approved_at) border-green-200 bg-green-50 @else border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full @if($gatepass->warden_approved_at) bg-green-100 @else bg-gray-200 flex items-center justify-center mr-3">
                                        @if($gatepass->warden_approved_at)
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Warden Approval</h4>
                                        @if($gatepass->warden_approved_at)
                                            <p class="text-xs text-gray-600">Approved by {{ $gatepass->wardenApprovedBy->name }} on {{ $gatepass->warden_approved_at->format('M d, Y h:i A') }}</p>
                                        @else
                                            <p class="text-xs text-gray-600">Pending</p>
                                        @endif
                                    </div>
                                </div>
                                @if($gatepass->warden_remarks)
                                    <div class="text-sm text-gray-600">
                                        <strong>Remarks:</strong> {{ $gatepass->warden_remarks }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approval Actions -->
            @if($gatepass->canUserChangeDecision(Auth::user()) || $gatepass->canBeApprovedByHod())
                <div class="mt-8 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">HOD Approval Action</h3>
                    <form method="POST" action="{{ route('hod.gatepasses.approve', $gatepass) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="action" class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                                <select name="action" id="action" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Select Action</option>
                                    @if($gatepass->status === 'staff_approved')
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                    @elseif($gatepass->status === 'hod_rejected')
                                        <option value="approve">Re-approve</option>
                                    @elseif($gatepass->status === 'hod_approved')
                                        <option value="reject">Change to Reject</option>
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks (Optional)</label>
                                <textarea name="remarks" id="remarks" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Add any remarks or comments..."></textarea>
                            </div>
                            <div class="flex space-x-4">
                                <button type="submit" class="btn-primary px-6 py-2 text-white rounded-lg">
                                    Submit Action
                                </button>
                                <a href="{{ route('hod.gatepasses.pending') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
