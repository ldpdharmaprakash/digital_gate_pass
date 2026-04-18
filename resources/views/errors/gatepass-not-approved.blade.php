@extends('layouts.app')

@section('title', 'Gatepass Not Approved')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-24 w-24 text-red-500">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Gatepass Not Approved</h2>
            <p class="mt-2 text-sm text-gray-600">
                This gatepass has not been approved yet.
            </p>
        </div>
        
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Gatepass Details</h3>
                    <dl class="mt-2 space-y-1 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <dt>Gatepass ID:</dt>
                            <dd class="font-medium">#{{ str_pad($gatepass->id, 6, '0', STR_PAD_LEFT) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Student:</dt>
                            <dd class="font-medium">{{ $gatepass->student->user->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Date:</dt>
                            <dd class="font-medium">{{ $gatepass->gatepass_date->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Status:</dt>
                            <dd>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ ucfirst(str_replace('_', ' ', $gatepass->status)) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
                
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600 text-center">
                        Please wait for the gatepass to be approved before accessing it via QR code.
                    </p>
                </div>
                
                <div class="pt-4">
                    <a href="{{ url('/') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Go to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
