@extends('layouts.gatepass')

@section('title', 'Create Gatepass Request')

@section('content')
<div x-data="gatepassForm()">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create Gatepass Request</h1>
        <p class="text-gray-600 mt-2">Fill in the details below to submit your gatepass request</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student Information Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Student Information</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Register Number</p>
                        <p class="font-medium text-gray-900">{{ $student->register_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Department</p>
                        <p class="font-medium text-gray-900">{{ $student->department->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Semester</p>
                        <p class="font-medium text-gray-900">{{ $student->semester }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Hosteller</p>
                        <p class="font-medium text-gray-900">
                            @if($student->hosteller === 'yes')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Yes</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">No</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                <h3 class="text-sm font-semibold text-blue-900 mb-2">Instructions</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Select a date for your gatepass</li>
                    <li>• Specify valid out and in times</li>
                    <li>• Provide a clear reason for the request</li>
                    <li>• Requests require staff and HOD approval</li>
                    @if($student->hosteller === 'yes')
                        <li>• Hosteller requests also need warden approval</li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Gatepass Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('student.gatepasses.store') }}" method="POST" @submit="submitting = true">
                @csrf
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Gatepass Details</h2>
                    
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date Field -->
                        <div>
                            <label for="gatepass_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date of Gatepass <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="gatepass_date" 
                                name="gatepass_date" 
                                required
                                min="{{ now()->format('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-theme transition-colors"
                                x-model="formData.gatepass_date"
                                @change="validateDate()"
                            >
                            <p class="mt-1 text-sm text-gray-500">Select today or a future date</p>
                        </div>

                        <!-- Out Time Field -->
                        <div>
                            <label for="out_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Out Time <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="time" 
                                id="out_time" 
                                name="out_time" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-theme transition-colors"
                                x-model="formData.out_time"
                            >
                        </div>

                        <!-- In Time Field -->
                        <div>
                            <label for="in_time" class="block text-sm font-medium text-gray-700 mb-2">
                                In Time <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="time" 
                                id="in_time" 
                                name="in_time" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-theme transition-colors"
                                x-model="formData.in_time"
                            >
                            <p class="mt-1 text-sm text-gray-500">Must be after out time</p>
                        </div>

                        <!-- Reason Field -->
                        <div class="md:col-span-2">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Reason for Gatepass <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="reason" 
                                name="reason" 
                                rows="4" 
                                required
                                maxlength="500"
                                placeholder="Please provide a detailed reason for your gatepass request..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus-theme transition-colors resize-none"
                                x-model="formData.reason"
                            ></textarea>
                            <p class="mt-1 text-sm text-gray-500">
                                <span x-text="formData.reason.length"></span> / 500 characters
                            </p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('student.gatepasses.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors btn-secondary-theme">
                            Cancel
                        </a>
                        <!-- <button 
                            type="submit" 
                            :disabled="submitting"
                            class="btn-secondery px-6 py-2 text-white rounded-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                            :class="{ 'opacity-50 cursor-not-allowed': submitting }"
                        >
                            <svg x-show="!submitting" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <svg x-show="submitting" class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span x-text="submitting ? 'Submitting...' : 'Submit Request'"></span>
                        </button> -->

                        <button 
    type="submit"
    :disabled="submitting"
    class="
        relative inline-flex items-center justify-center
        px-7 py-2.5
        text-sm font-semibold tracking-wide
        text-white
        rounded-lg
        btn-primary-theme
        shadow-md
        transition-all duration-300 ease-in-out
        hover:shadow-lg
        focus:outline-none focus:ring-2 focus:ring-offset-2
        disabled:opacity-60 disabled:cursor-not-allowed
    "
    :class="{ 'opacity-60 cursor-not-allowed': submitting }"
>
    <!-- Plus Icon -->
    <svg x-show="!submitting" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>

    <!-- Loader -->
    <svg x-show="submitting" class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
        </path>
    </svg>

    <!-- Text -->
    <span x-text="submitting ? 'Submitting...' : 'Submit Request'"></span>
</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function gatepassForm() {
    return {
        submitting: false,
        formData: {
            gatepass_date: '',
            out_time: '',
            in_time: '',
            reason: ''
        },
        
        validateDate() {
            // Additional date validation if needed
            const selectedDate = new Date(this.formData.gatepass_date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                this.formData.gatepass_date = today.toISOString().split('T')[0];
            }
        }
    }
}
</script>
@endsection
