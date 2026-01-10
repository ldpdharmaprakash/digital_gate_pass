<x-guest-layout>
    <!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<div class="text-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
    <p class="text-gray-600">Sign in to access your account</p>
</div>

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

<!-- Additional Options -->
<div class="mt-6">
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
</div>

<script>
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
