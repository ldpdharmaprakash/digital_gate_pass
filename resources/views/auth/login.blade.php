<x-guest-layout>
    <!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<div class="text-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
    <p class="text-gray-600">Sign in to access your account</p>
</div>

<!-- Tab Navigation -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="switchTab('password')" id="password-tab" class="tab-button active py-2 px-1 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600">
                <i class="fas fa-key mr-2"></i>Password Login
            </button>
            <button onclick="switchTab('qr')" id="qr-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                <i class="fas fa-qrcode mr-2"></i>QR Login
            </button>
        </nav>
    </div>
</div>

<!-- Password Login Tab -->
<div id="password-content" class="tab-content">
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium mb-2" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="Enter your email address"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                    name="remember"
                >
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="btn-login w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-sign-in-alt mr-2"></i>
                {{ __('Sign In') }}
            </button>
        </div>
    </form>
</div>

<!-- QR Login Tab -->
<div id="qr-content" class="tab-content hidden">
    <div class="space-y-6">
        <!-- QR Scanner Section -->
        <div class="bg-white p-6 rounded-lg border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Scan QR Code</h3>
            
            <!-- QR Scanner Container -->
            <div id="qr-reader" class="mb-4 relative">
                <div class="scanner-placeholder">
                    <i class="fas fa-qrcode text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-center">Click "Start Camera" to begin scanning</p>
                </div>
            </div>
            
            <!-- Scanner Controls -->
            <div class="flex space-x-3 mb-4">
                <button onclick="startScanner()" id="startScanner" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-camera mr-2"></i>Start Camera
                </button>
                <button onclick="stopScanner()" id="stopScanner" class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors" disabled>
                    <i class="fas fa-stop mr-2"></i>Stop Camera
                </button>
            </div>
            
            <!-- File Upload -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors" id="dropZone">
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-600 mb-2">Drop QR image here or click to upload</p>
                <input type="file" id="qrFileInput" accept="image/*" class="hidden">
                <button onclick="document.getElementById('qrFileInput').click()" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-folder-open mr-2"></i>Choose File
                </button>
            </div>
        </div>
        
        <!-- Scan Status -->
        <div id="scanStatus" class="hidden">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                    <div>
                        <p class="text-blue-800 font-medium">Scanning QR Code...</p>
                        <p class="text-blue-600 text-sm">Please wait while we process the QR code.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scan Result -->
        <div id="scanResult" class="hidden">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <div>
                        <p class="text-green-800 font-medium">QR Code Detected!</p>
                        <p class="text-green-600 text-sm">Redirecting to login...</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Error Message -->
        <div id="scanError" class="hidden">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">Scanning Failed</p>
                        <p class="text-red-600 text-sm" id="errorMessage">Please try again or use file upload.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Options -->
<!-- <div class="mt-6">
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Or continue with</span>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-3">
        <button class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
            <i class="fas fa-building mr-2"></i>
            Staff Portal
        </button>
        <button class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
            <i class="fas fa-user-graduate mr-2"></i>
            Student Portal
        </button>
    </div>
</div> -->

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    // Check if HTML5 QR Code library loaded
    if (typeof Html5Qrcode === 'undefined') {
        console.error('HTML5 QR Code library not loaded');
        alert('QR Code library failed to load. Please refresh the page and try again.');
        // Fallback to file upload only
        document.addEventListener('DOMContentLoaded', function() {
            const startBtn = document.getElementById('startScanner');
            if (startBtn) {
                startBtn.disabled = true;
                startBtn.innerHTML = '<i class="fas fa-camera mr-2"></i>Camera Unavailable';
                startBtn.title = 'Camera not available - please use file upload';
            }
        });
    }

    let html5QrCode = null;
    let isScanning = false;

    // Tab switching
    function switchTab(tab) {
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected content
        document.getElementById(tab + '-content').classList.remove('hidden');
        
        // Add active class to selected tab
        const activeTab = document.getElementById(tab + '-tab');
        activeTab.classList.add('active', 'border-indigo-500', 'text-indigo-600');
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        
        // Stop scanner when switching away from QR tab
        if (tab !== 'qr' && isScanning) {
            stopScanner();
        }
    }

    // QR Scanner functions
    function startScanner() {
        console.log('Starting QR scanner...');
        
        if (isScanning) {
            console.log('Scanner already running');
            return;
        }
        
        // Check if library is available
        if (typeof Html5Qrcode === 'undefined') {
            console.error('HTML5 QR Code library not available');
            showError('QR Code library not available. Please use file upload option.');
            return;
        }
        
        // Hide placeholder and show loading
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) {
            console.error('QR reader element not found');
            showError('QR scanner element not found. Please refresh the page.');
            return;
        }
        
        qrReader.innerHTML = '<div class="scanner-loading"><i class="fas fa-spinner fa-spin text-4xl text-indigo-600"></i><p class="text-gray-600 mt-2">Initializing camera...</p></div>';
        
        // Check for camera support
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            console.error('Camera not supported in this browser');
            showError('Camera not supported in this browser. Please use file upload option.');
            resetScannerPlaceholder();
            return;
        }
        
        try {
            html5QrCode = new Html5Qrcode("qr-reader");
            console.log('HTML5 QR Code instance created');
            
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };
            
            // Try to get cameras first
            Html5Qrcode.getCameras().then(devices => {
                console.log('Cameras found:', devices);
                
                if (devices && devices.length) {
                    // Prefer rear camera on mobile
                    let cameraId = devices[0].id;
                    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                    
                    if (isMobile && devices.length > 1) {
                        // Look for rear camera
                        const rearCamera = devices.find(device => 
                            device.label.toLowerCase().includes('back') || 
                            device.label.toLowerCase().includes('rear')
                        );
                        if (rearCamera) {
                            cameraId = rearCamera.id;
                            console.log('Using rear camera:', rearCamera.label);
                        }
                    }
                    
                    console.log('Starting scanner with camera:', cameraId);
                    
                    html5QrCode.start(
                        cameraId,
                        config,
                        (decodedText, decodedResult) => {
                            console.log('QR Code detected:', decodedText);
                            handleQRSuccess(decodedText);
                        },
                        (errorMessage) => {
                            console.log('Scan error:', errorMessage);
                            // Handle scan error silently
                        }
                    ).then(() => {
                        isScanning = true;
                        updateScannerButtons(true);
                        console.log('Scanner started successfully');
                    }).catch((err) => {
                        console.error('Unable to start scanning:', err);
                        showError('Camera access denied or not available. Please use file upload option.');
                        resetScannerPlaceholder();
                    });
                } else {
                    console.error('No cameras found');
                    showError('No camera found. Please use file upload option.');
                    resetScannerPlaceholder();
                }
            }).catch(err => {
                console.error('Error getting cameras:', err);
                showError('Unable to access camera. Please use file upload option.');
                resetScannerPlaceholder();
            });
        } catch (error) {
            console.error('Error in startScanner:', error);
            showError('Scanner initialization failed. Please use file upload option.');
            resetScannerPlaceholder();
        }
    }

    function stopScanner() {
        if (!isScanning || !html5QrCode) return;
        
        html5QrCode.stop().then(() => {
            isScanning = false;
            updateScannerButtons(false);
            resetScannerPlaceholder();
        }).catch((err) => {
            console.error(`Failed to stop scanning: ${err}`);
            isScanning = false;
            updateScannerButtons(false);
            resetScannerPlaceholder();
        });
    }

    function resetScannerPlaceholder() {
        const qrReader = document.getElementById('qr-reader');
        qrReader.innerHTML = `
            <div class="scanner-placeholder">
                <i class="fas fa-qrcode text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-center">Click "Start Camera" to begin scanning</p>
            </div>
        `;
    }

    function showError(message) {
        hideAllMessages();
        document.getElementById('errorMessage').textContent = message;
        document.getElementById('scanError').classList.remove('hidden');
    }

    function hideAllMessages() {
        document.getElementById('scanStatus').classList.add('hidden');
        document.getElementById('scanResult').classList.add('hidden');
        document.getElementById('scanError').classList.add('hidden');
    }

    function updateScannerButtons(scanning) {
        const startBtn = document.getElementById('startScanner');
        const stopBtn = document.getElementById('stopScanner');
        
        if (scanning) {
            startBtn.disabled = true;
            startBtn.classList.add('opacity-50', 'cursor-not-allowed');
            stopBtn.disabled = false;
            stopBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            startBtn.disabled = false;
            startBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            stopBtn.disabled = true;
            stopBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function handleQRSuccess(decodedText) {
        stopScanner();
        hideAllMessages();
        
        // Show scanning status
        document.getElementById('scanStatus').classList.remove('hidden');
        
        // Check if it's a QR login URL
        if (decodedText.includes('/auth/qr/')) {
            // Extract token from URL
            const match = decodedText.match(/\/auth\/qr\/([a-f0-9\-]+)/);
            if (match && match[1]) {
                // Show success
                document.getElementById('scanStatus').classList.add('hidden');
                document.getElementById('scanResult').classList.remove('hidden');
                
                // Redirect to QR login
                setTimeout(() => {
                    window.location.href = decodedText;
                }, 1500);
            } else {
                showError('Invalid QR code format. Please scan a valid login QR code.');
            }
        } else {
            showError('This QR code is not a login QR code. Please scan a valid login QR code.');
        }
    }

    // File upload handling
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('qrFileInput');
        if (!fileInput) {
            console.error('File input element not found');
            return;
        }
        
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            console.log('File selected:', file);
            
            if (file) {
                hideAllMessages();
                document.getElementById('scanStatus').classList.remove('hidden');
                
                console.log('Processing file:', file.name, file.type, file.size);
                
                // Check if library is available
                if (typeof Html5Qrcode === 'undefined') {
                    console.error('HTML5 QR Code library not available for file scanning');
                    showError('QR Code library not available. Please refresh the page.');
                    resetScannerPlaceholder();
                    return;
                }
                
                const html5QrCode = new Html5Qrcode("qr-reader");
                console.log('HTML5 QR Code instance created for file scanning');
                
                html5QrCode.scanFile(file, true)
                    .then(decodedText => {
                        console.log('QR Code from file:', decodedText);
                        handleQRSuccess(decodedText);
                    })
                    .catch(err => {
                        console.error(`Error scanning file: ${err}`);
                        showError('Failed to scan QR code. Please try with a clear image.');
                        resetScannerPlaceholder();
                    });
            } else {
                console.error('No file selected');
                showError('No file selected. Please choose an image file.');
            }
        });
    });

    // Drag and drop handling
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        if (!dropZone) {
            console.error('Drop zone element not found');
            return;
        }
        
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-indigo-500', 'bg-indigo-50');
            console.log('Drag over detected');
        });
        
        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-indigo-500', 'bg-indigo-50');
            console.log('Drag leave detected');
        });
        
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-indigo-500', 'bg-indigo-50');
            console.log('Drop detected');
            
            const files = e.dataTransfer.files;
            console.log('Files dropped:', files);
            
            if (files.length > 0) {
                const file = files[0];
                console.log('Processing file:', file.name, file.type, file.size);
                
                if (file.type.startsWith('image/')) {
                    document.getElementById('qrFileInput').files = files;
                    const event = new Event('change', { bubbles: true });
                    document.getElementById('qrFileInput').dispatchEvent(event);
                    console.log('File dispatched to input handler');
                } else {
                    console.error('Invalid file type:', file.type);
                    showError('Please upload an image file (JPG, PNG, GIF).');
                }
            } else {
                console.error('No files in drop event');
                showError('No file detected. Please try again.');
            }
        });
        
        // Add visual feedback for drag events
        dropZone.addEventListener('dragenter', function(e) {
            e.preventDefault();
            this.classList.add('border-indigo-500', 'bg-indigo-50');
        });
    });

    // Password toggle functionality
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>
</x-guest-layout>
