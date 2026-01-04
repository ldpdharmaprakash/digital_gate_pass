@extends('layouts.gatepass')

@section('title', 'Verify Gatepass')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gatepass Verification</h1>
        <p class="text-gray-600 mt-2">Verify gatepasses by entering the gatepass number</p>
    </div>

    <!-- Verification Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('warden.verification.search') }}" class="flex gap-4">
            <div class="flex-1">
                <label for="gatepass_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Gatepass Number
                </label>
                <input 
                    type="text" 
                    name="gatepass_number" 
                    id="gatepass_number" 
                    placeholder="Enter gatepass number (e.g., 000001)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('gatepass_number') }}"
                >
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary px-6 py-2 text-white rounded-lg">
                    Verify
                </button>
            </div>
        </form>
    </div>

    @if(request('gatepass_number'))
        @php
            $gatepassId = ltrim(request('gatepass_number'), '0');
            $gatepass = \App\Models\Gatepass::find($gatepassId);
        @endphp
        
        @if($gatepass)
            <!-- Gatepass Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center space-x-3">
                                <h2 class="text-2xl font-bold text-gray-900">Gatepass #{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</h2>
                                @if($gatepass->isFinalApproved())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Valid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Invalid
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Information</h3>
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
                            </div>
                        </div>

                        <!-- Gatepass Details -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Gatepass Details</h3>
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
                            </div>
                        </div>
                    </div>

                    <!-- Verification Status -->
                    <div class="mt-6 p-4 rounded-lg @if($gatepass->isFinalApproved()) bg-green-50 border-green-200 @else bg-red-50 border-red-200 @endif border">
                        <div class="flex items-center">
                            @if($gatepass->isFinalApproved())
                                <svg class="w-6 h-6 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-green-800 font-semibold">✓ This gatepass is valid and approved</p>
                            @else
                                <svg class="w-6 h-6 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-red-800 font-semibold">✗ This gatepass is not valid or not approved</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Not Found -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Gatepass Not Found</h3>
                    <p class="text-gray-600">No gatepass found with number: {{ request('gatepass_number') }}</p>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
