@extends('layouts.gatepass')

@section('title', 'QR Login Code')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">QR Login Code</h1>
            <p class="text-gray-600 mt-2">Generate and manage your personal QR login code</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- QR Code Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <!-- Card Header -->
        <div class="bg-gradient-theme p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-white">Your Personal QR Login Code</h2>
                    <p class="text-white/80 text-sm mt-1">Scan this QR code to instantly login to your account</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd"></path>
                        <path d="M11 4a1 1 0 10-2 0v1a1 1 0 002 0V4zM10 7a1 1 0 011 1v1h2a1 1 0 110 2h-3a1 1 0 01-1-1V8a1 1 0 011-1zM16 9a1 1 0 100 2 1 1 0 000-2zM9 13a1 1 0 011-1h1a1 1 0 110 2v2a1 1 0 11-2 0v-3zM7 11a1 1 0 100-2H4a1 1 0 100 2h3zM17 13a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM16 17a1 1 0 100-2h-3a1 1 0 100 2h3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- QR Code Display -->
        <div class="p-8">
            <div class="flex justify-center mb-8">
                <div class="relative">
                    <div class="p-6 bg-white border-4 border-gray-200 rounded-xl shadow-lg">
                        <img src="{{ route('qr.image', $qrToken) }}" 
                             alt="Your QR Login Code" 
                             class="w-64 h-64"
                             onerror="this.src='data:image/svg+xml;base64,{{ base64_encode('<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;256&quot; height=&quot;256&quot; viewBox=&quot;0 0 256 256&quot;><rect width=&quot;256&quot; height=&quot;256&quot; fill=&quot;#f3f4f6&quot;/><text x=&quot;128&quot; y=&quot;128&quot; text-anchor=&quot;middle&quot; dominant-baseline=&quot;middle&quot; fill=&quot;#6b7280&quot; font-size=&quot;14&quot;>QR Loading...</text></svg>') }}'">
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute -top-2 -right-2 bg-green-100 text-green-800 rounded-full px-3 py-1 text-sm font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Active
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4 mb-8">
                <a href="{{ route('qr.image', $qrToken) }}" 
                   download="qr-login-code.png"
                   class="btn-primary-theme px-6 py-3 text-white rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download QR Code
                </a>
                <button onclick="copyToClipboard('{{ $qrLoginUrl }}', this)" 
                        class="btn-secondary-theme px-6 py-3 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copy Login URL
                </button>
            </div>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Login URL -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Login URL</h3>
                    <p class="text-sm text-gray-600">Direct login link for your QR code</p>
                </div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                <code class="text-xs text-gray-700 break-all">{{ $qrLoginUrl }}</code>
            </div>
        </div>

        <!-- Token Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Token Information</h3>
                    <p class="text-sm text-gray-600">Your unique QR login token</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Token:</span>
                    <code class="text-gray-800">{{ substr($qrToken, 0, 8) }}...</code>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Generated:</span>
                    <span class="text-gray-800">{{ $qrGeneratedAt->format('M d, Y \a\t h:i A') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
            <div class="bg-purple-100 rounded-lg p-3 mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">How to Use Your QR Code</h3>
                <p class="text-sm text-gray-600">Follow these steps to use your QR login code</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="bg-blue-50 rounded-lg p-4 mb-3">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold">1</span>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-2">Download QR Code</h4>
                    <p class="text-sm text-gray-600">Save your QR code image to your device</p>
                </div>
            </div>
            
            <div class="text-center">
                <div class="bg-green-50 rounded-lg p-4 mb-3">
                    <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <span class="text-green-600 font-bold">2</span>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-2">Visit Login Page</h4>
                    <p class="text-sm text-gray-600">Go to login page and click "QR Login" tab</p>
                </div>
            </div>
            
            <div class="text-center">
                <div class="bg-purple-50 rounded-lg p-4 mb-3">
                    <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <span class="text-purple-600 font-bold">3</span>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-2">Scan QR Code</h4>
                    <p class="text-sm text-gray-600">Use camera or upload the QR image to login</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Regenerate QR Code -->
    <div class="mt-6 text-center">
        <form method="POST" action="{{ route('qr.regenerate') }}" class="inline-block">
            @csrf
            <button type="submit" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg flex items-center mx-auto transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Regenerate QR Code
            </button>
        </form>
        <p class="text-sm text-gray-500 mt-2">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            Regenerating will invalidate your current QR code
        </p>
    </div>
</div>

<script>
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Copied!';
        button.classList.add('bg-green-100', 'text-green-700');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('bg-green-100', 'text-green-700');
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
        // Show error feedback
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>Failed!';
        button.classList.add('bg-red-100', 'text-red-700');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('bg-red-100', 'text-red-700');
        }, 2000);
    });
}
</script>
@endsection
