<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Digital Gatepass System') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }
            
            .login-container {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }
            
            .logo-container {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 50%;
                width: 80px;
                height: 80px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
                transition: transform 0.3s ease;
            }
            
            .logo-container:hover {
                transform: scale(1.05);
            }
            
            .input-group {
                position: relative;
            }
            
            .input-group input {
                padding-left: 2.5rem;
                border: 2px solid #e5e7eb;
                transition: all 0.3s ease;
            }
            
            .input-group input:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }
            
            .input-group i {
                position: absolute;
                left: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                color: #9ca3af;
                z-index: 10;
            }
            
            .btn-login {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }
            
            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            }
            
            .floating-shapes {
                position: fixed;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: -1;
            }
            
            .shape {
                position: absolute;
                opacity: 0.1;
            }
            
            .shape-1 {
                width: 200px;
                height: 200px;
                background: white;
                border-radius: 50%;
                top: 10%;
                left: 10%;
                animation: float 6s ease-in-out infinite;
            }
            
            .shape-2 {
                width: 150px;
                height: 150px;
                background: white;
                border-radius: 50%;
                bottom: 20%;
                right: 15%;
                animation: float 8s ease-in-out infinite reverse;
            }
            
            .shape-3 {
                width: 100px;
                height: 100px;
                background: white;
                border-radius: 50%;
                top: 50%;
                right: 10%;
                animation: float 7s ease-in-out infinite;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/" class="flex items-center space-x-3">
                    <div class="logo-container">
                        <i class="fas fa-graduation-cap text-white text-3xl"></i>
                    </div>
                    <div class="text-white">
                        <h1 class="text-2xl font-bold">Gatepass System</h1>
                        <p class="text-sm opacity-90">Digital Campus Access</p>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 login-container rounded-2xl">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-white text-sm">
                <p>&copy; 2026 Digital Gatepass System. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
