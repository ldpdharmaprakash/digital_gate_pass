<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Digital Gatepass Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @php
        use App\Support\CollegeTheme;
        $college = session('college', 'engineering');
        $theme = CollegeTheme::getTheme($college);
        @endphp

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Theme Variables */
            :root {
                --primary: {{ $theme['primary'] }};
                --primary-hover: {{ $theme['primary_hover'] }};
                --accent: {{ $theme['accent'] }};
                --sidebar-bg: {{ $theme['sidebar_bg'] }};
                --sidebar-active: {{ $theme['sidebar_active'] }};
                --sidebar-hover: {{ $theme['sidebar_hover'] }};
                --sidebar-text: {{ $theme['sidebar_text'] }};
                --sidebar-icon: {{ $theme['sidebar_icon'] }};
                --header-bg: {{ $theme['header_bg'] }};
                --header-border: {{ $theme['header_border'] }};
                --header-text: {{ $theme['header_text'] }};
                --header-accent: {{ $theme['header_accent'] }};
                --btn-primary: {{ $theme['btn_primary'] }};
                --btn-primary-hover: {{ $theme['btn_primary_hover'] }};
                --btn-primary-focus: {{ $theme['btn_primary_focus'] }};
                --btn-secondary: {{ $theme['btn_secondary'] }};
                --btn-secondary-hover: {{ $theme['btn_secondary_hover'] }};
                --card-bg: {{ $theme['card_bg'] }};
                --card-border: {{ $theme['card_border'] }};
                --card-accent: {{ $theme['card_accent'] }};
                --card-shadow: {{ $theme['card_shadow'] }};
                --card-hover-shadow: {{ $theme['card_hover_shadow'] }};
                --page-bg: {{ $theme['page_bg'] }};
                --page-tint: {{ $theme['page_tint'] }};
                --status-pending: {{ $theme['status_pending'] }};
                --status-approved: {{ $theme['status_approved'] }};
                --status-rejected: {{ $theme['status_rejected'] }};
                --shadow-color: {{ $theme['shadow_color'] }};
                --shadow-strong: {{ $theme['shadow_strong'] }};
                --text-primary: {{ $theme['text_primary'] }};
                --text-secondary: {{ $theme['text_secondary'] }};
                --text-muted: {{ $theme['text_muted'] }};
                
                /* Dynamic Gradient Variables */
                --gradient-start: {{ $theme['primary'] }};
                --gradient-end: {{ $theme['accent'] }};
                --focus-color: {{ $theme['primary'] }};
                
                /* CSS Custom Properties for Responsive Design */
                --sidebar-width: 16rem;
                --font-size-xs: 0.75rem;
                --font-size-sm: 0.875rem;
                --font-size-base: 1rem;
                --font-size-lg: 1.125rem;
                --font-size-xl: 1.25rem;
                --font-size-2xl: 1.5rem;
                --font-size-3xl: 1.875rem;
                --font-size-4xl: 2.25rem;
                --spacing-xs: 0.25rem;
                --spacing-sm: 0.5rem;
                --spacing-md: 1rem;
                --spacing-lg: 1.5rem;
                --spacing-xl: 2rem;
                --spacing-2xl: 3rem;
                --border-radius-sm: 0.25rem;
                --border-radius-md: 0.375rem;
                --border-radius-lg: 0.5rem;
                --border-radius-xl: 0.75rem;
                --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            }
            
            /* Dynamic Gradient Classes */
            .gradient-theme {
                background: linear-gradient(to right, var(--gradient-start), var(--gradient-end)) !important;
            }
            
            .gradient-vertical {
                background: linear-gradient(to bottom, var(--gradient-start), var(--gradient-end)) !important;
            }
            
            .gradient-diagonal {
                background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end)) !important;
            }
            
            /* Dynamic Focus Classes */
            .focus-theme:focus {
                outline: none !important;
                box-shadow: 0 0 0 3px var(--focus-color) !important;
                border-color: var(--focus-color) !important;
            }
            
            /* Theme Classes */
            .btn-theme {
                background-color: var(--btn-primary) !important;
                color: white !important;
            }
            .btn-theme:hover {
                background-color: var(--btn-primary-hover) !important;
            }
            .text-theme { color: var(--primary) !important; }
            .bg-theme { background-color: var(--primary) !important; }
            .sidebar-theme { 
                background: var(--sidebar-bg) !important;
                color: var(--sidebar-text) !important;
            }
            
            .sidebar-active {
                background-color: var(--sidebar-active) !important;
                color: var(--sidebar-text) !important;
            }
            
            .sidebar-hover:hover {
                background-color: var(--sidebar-hover) !important;
            }
            
            .header-theme {
                background-color: var(--header-bg) !important;
                border-bottom: 1px solid var(--header-border) !important;
                color: var(--header-text) !important;
            }
            
            .btn-primary-theme {
                background-color: var(--btn-primary) !important;
                color: white !important;
                border: none !important;
                transition: all 0.3s ease !important;
            }
            
            .btn-primary-theme:hover {
                background-color: var(--btn-primary-hover) !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 12px var(--shadow-color) !important;
            }
            
            .card-theme {
                background-color: var(--card-bg) !important;
                border: 1px solid var(--card-border) !important;
                box-shadow: 0 4px 12px var(--card-shadow) !important;
                transition: all 0.3s ease !important;
            }
            
            .card-theme:hover {
                box-shadow: 0 8px 20px var(--card-hover-shadow) !important;
                border-color: var(--card-accent) !important;
            }
            
            .card-accent {
                border-left: 4px solid var(--card-accent) !important;
            }
            
            .page-bg {
                background-color: var(--page-bg) !important;
            }
            
            .page-bg::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: var(--page-tint);
                pointer-events: none;
                z-index: -1;
            }
            
            .status-pending {
                background-color: var(--status-pending) !important;
                color: white !important;
            }
            
            .status-approved {
                background-color: var(--status-approved) !important;
                color: white !important;
            }
            
            .status-rejected {
                background-color: var(--status-rejected) !important;
                color: white !important;
            }
            
            .text-primary-theme { color: var(--text-primary) !important; }
            .text-secondary-theme { color: var(--text-secondary) !important; }
            .text-muted-theme { color: var(--text-muted) !important; }
            .text-accent-theme { color: var(--header-accent) !important; }
            
            /* Responsive Sidebar */
            .sidebar-responsive {
                width: var(--sidebar-width);
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                height: 100vh;
                overflow-y: auto;
                position: fixed;
                top: 0;
                left: 0;
            }
            
            @media (min-width: 1024px) {
                .sidebar-responsive {
                    position: fixed;
                    transform: translateX(0);
                    flex-shrink: 0;
                    border-right: 1px solid #e5e7eb;
                    height: 100vh;
                    overflow-y: hidden;
                }
            }
            
            .sidebar-responsive.sidebar-open {
                transform: translateX(0);
            }
            
            /* Responsive Main Content */
            .main-content-responsive {
                margin-left: 0;
                transition: margin-left 0.3s ease-in-out;
                min-height: 100vh;
                width: 100%;
                flex: 1;
                position: relative;
            }
            
            @media (min-width: 1024px) {
                .main-content-responsive {
                    margin-left: var(--sidebar-width);
                    width: calc(100% - var(--sidebar-width));
                    position: relative;
                }
            }
            
            @media (min-width: 1100px) {
                .main-content-responsive {
                    margin-left: var(--sidebar-width);
                    width: calc(100% - var(--sidebar-width));
                    max-width: none;
                    position: relative;
                }
            }
            
            /* Responsive Grid System */
            .grid-responsive {
                display: grid;
                gap: var(--spacing-md);
                grid-template-columns: 1fr;
                width: 100%;
            }
            
            @media (min-width: 640px) {
                .grid-responsive {
                    gap: var(--spacing-lg);
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            
            @media (min-width: 1024px) {
                .grid-responsive {
                    gap: var(--spacing-xl);
                    grid-template-columns: repeat(3, 1fr);
                }
            }
            
            @media (min-width: 1100px) {
                .grid-responsive {
                    gap: var(--spacing-xl);
                    grid-template-columns: repeat(4, 1fr);
                    max-width: none;
                }
            }
            
            /* Responsive Cards */
            .card-responsive {
                padding: var(--spacing-md);
                border-radius: var(--border-radius-md);
                background: white;
                box-shadow: var(--shadow-sm);
                transition: all 0.3s ease;
            }
            
            @media (min-width: 1024px) {
                .card-responsive {
                    padding: var(--spacing-lg);
                    border-radius: var(--border-radius-lg);
                    box-shadow: var(--shadow-md);
                }
            }
            
            /* Responsive Forms */
            .form-responsive input,
            .form-responsive select,
            .form-responsive textarea {
                padding: var(--spacing-md);
                font-size: var(--font-size-sm);
                border-radius: var(--border-radius-md);
                border: 1px solid #d1d5db;
                transition: all 0.3s ease;
            }
            
            @media (min-width: 1024px) {
                .form-responsive input,
                .form-responsive select,
                .form-responsive textarea {
                    padding: var(--spacing-lg);
                    font-size: var(--font-size-base);
                    border-radius: var(--border-radius-lg);
                }
            }
            
            /* Responsive Tables */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-responsive table {
                min-width: 100%;
                font-size: var(--font-size-xs);
            }
            
            @media (min-width: 1024px) {
                .table-responsive table {
                    font-size: var(--font-size-base);
                }
            }
            
            /* Mobile Optimizations */
            @media (max-width: 639px) {
                .mobile-hidden {
                    display: none !important;
                }
                
                .mobile-full {
                    width: 100% !important;
                }
                
                .mobile-center {
                    text-align: center !important;
                    justify-content: center !important;
                }
                
                .mobile-stack {
                    flex-direction: column !important;
                }
                
                .mobile-spacing {
                    margin-bottom: var(--spacing-md) !important;
                }
                
                .mobile-padding {
                    padding: var(--spacing-sm) !important;
                }
                
                .sidebar-responsive {
                    width: 100% !important;
                    max-width: 280px;
                }
                
                /* Small screen typography adjustments */
                .text-sm-responsive { font-size: 0.875rem; line-height: 1.25rem; }
                .text-base-responsive { font-size: 1rem; line-height: 1.5rem; }
                .text-lg-responsive { font-size: 1.125rem; line-height: 1.75rem; }
                .text-xl-responsive { font-size: 1.25rem; line-height: 1.75rem; }
                .text-2xl-responsive { font-size: 1.5rem; line-height: 2rem; }
                .text-3xl-responsive { font-size: 1.875rem; line-height: 2.25rem; }
            }
            
            /* Large Screen Width Fixes */
            @media (min-width: 1100px) {
                .main-content-responsive > div {
                    width: 100%;
                    max-width: none;
                }
                
                .grid-responsive {
                    width: 100%;
                    max-width: none;
                }
                
                .card-responsive {
                    width: 100%;
                }
            }
            
            /* Touch Optimizations */
            @media (hover: none) and (pointer: coarse) {
                .card-responsive:hover {
                    transform: none;
                    box-shadow: none;
                    border: 1px solid #e5e7eb;
                }
                
                .nav-item-responsive:hover {
                    transform: none;
                }
                
                .btn-responsive:hover {
                    transform: none;
                }
                
                .btn-responsive {
                    min-height: 44px;
                    min-width: 44px;
                }
            }
            
            /* Print Optimizations */
            @media print {
                .sidebar-responsive,
                .header-responsive,
                .mobile-hidden {
                    display: none !important;
                }
                
                .main-content-responsive {
                    margin-left: 0 !important;
                }
                
                .card-responsive {
                    break-inside: avoid;
                    box-shadow: none;
                    border: 1px solid #e5e7eb;
                }
            }
            
            /* High DPI Displays */
            @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
                .card-responsive {
                    border-width: 0.5px;
                }
                
                .nav-item-responsive {
                    border-width: 0.5px;
                }
            }
            
            /* Animations */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes slideIn {
                from { transform: translateX(-100%); }
                to { transform: translateX(0); }
            }
            
            .animate-fade-in {
                animation: fadeIn 0.5s ease-in;
            }
            
            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }
            
            /* Glass Effect */
            .glass-effect {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
            }
            
            /* Gradient Backgrounds */
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .navy-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            }
            
            .teal-gradient {
                background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            }
            
            /* Card Hover Effects */
            .card-hover:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-xl);
            }
            
            /* Stat Cards */
            .stat-card {
                background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
            }
            
            [x-cloak] { display: none !important; }
            
            .glass-effect {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
            }
            
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .navy-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #312e81 100%);
            }
            
            .teal-gradient {
                background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            }
            
            .card-hover {
                transition: all 0.3s ease;
            }
            
            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            
            .animate-fade-in {
                animation: fadeIn 0.5s ease-in;
            }
            
            .stat-card {
                background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
            }
        </style>
    </head>
    <body class="font-inter antialiased page-bg" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="sidebar-responsive sticky top-0 left-0 z-50 sidebar-theme shadow-lg" :class="sidebarOpen ? 'sidebar-open' : ''">
                <div class="flex items-center justify-center h-16 gradient-theme">
                    <h1 class="text-white text-xl font-bold">Gatepass System</h1>
                </div>
                
                <nav class="mt-8 px-4 h-[calc(100vh-4rem)] overflow-y-auto">
                    @auth
                        <div class="mb-6">

                            <div class="flex items-center mobile-stack mobile-spacing">
                                <div class="flex-shrink-0">
                                  <div class="w-10 h-10 rounded-full gradient-theme flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-3 mobile-center mobile-spacing">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-theme text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="text-sm-responsive">Dashboard</span>
                            </a>
                            
                            @if(auth()->user()->isStudent())
                                <a href="{{ route('student.gatepasses.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('student.gatepasses.*') ? 'bg-theme text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">My Gatepasses</span>
                                </a>
                                <a href="{{ route('student.gatepasses.create') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span class="text-sm-responsive">New Request</span>
                                </a>
                            @endif
                            
                            @if(auth()->user()->isStaff())
                                <a href="{{ route('staff.gatepasses.pending') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('staff.gatepasses.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Pending Requests</span>
                                </a>
                                <a href="{{ route('staff.students.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Students</span>
                                </a>
                            @endif
                            
                            @if(auth()->user()->isHod())
                                <a href="{{ route('hod.gatepasses.pending') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('hod.gatepasses.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Pending Requests</span>
                                </a>
                                <a href="{{ route('hod.reports') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Reports</span>
                                </a>
                            @endif
                            
                            @if(auth()->user()->isWarden())
                                <a href="{{ route('warden.gatepasses.pending') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('warden.gatepasses.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Hosteller Requests</span>
                                </a>
                                <a href="{{ route('warden.verification') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Verification</span>
                                </a>
                                <a href="{{ route('warden.reports') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Reports</span>
                                </a>
                            @endif
                            
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Users</span>
                                </a>
                                <a href="{{ route('admin.departments.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.departments.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Departments</span>
                                </a>
                                <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Reports</span>
                                </a>
                            @endif
                        </div>
                        
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="text-sm-responsive">Logout</span>
                                </button>
                            </form>
                        </div>
                    @endauth
                </nav>
            </aside>

            <!-- Main content -->
            <main class="main-content-responsive flex-1">
                <!-- Top navigation -->
                <header class="sticky top-0 z-40 bg-white shadow-sm border-b border-gray-200">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-600 p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <div class="flex items-center space-x-4 mobile-stack mobile-spacing">
                            <!-- College/Role Selection Dropdown -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600 font-medium">Theme:</span>
                                <form method="GET" action="/set-college" class="flex">
                                    <select name="college"
                                        onchange="this.form.submit()"
                                        class="appearance-none bg-white border border-gray-300 rounded-lg text-sm px-3 py-1.5 pr-8 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer shadow-sm hover:shadow-md">
                                        <option value="engineering" {{ session('college')=='engineering'?'selected':'' }}>🔧 Engineering</option>
                                        <option value="arts" {{ session('college')=='arts'?'selected':'' }}>🎨 Arts</option>
                                        <option value="polytechnic" {{ session('college')=='polytechnic'?'selected':'' }}>⚙️ Polytechnic</option>
                                        <option value="warden" {{ session('college')=='warden'?'selected':'' }}>🛡️ Warden</option>
                                        <option value="security" {{ session('college')=='security'?'selected':'' }}>🔐 Security</option>
                                    </select>
                                </form>
                            </div>
                            
                            @if(session('success'))
                                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-2 rounded-lg text-sm animate-fade-in mobile-full mobile-center">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-2 rounded-lg text-sm animate-fade-in mobile-full mobile-center">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <div class="p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>

            <!-- Mobile sidebar overlay -->
            <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden" @click="sidebarOpen = false"></div>
        </div>
    </body>
</html>
