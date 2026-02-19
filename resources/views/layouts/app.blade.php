<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @php
        use App\Support\CollegeTheme;
        $college = session('college', 'engineering');
        $theme = CollegeTheme::getTheme($college);
        @endphp

        <!-- Dynamic Theme Styles -->
        <style>
            :root {
                /* Core Identity Colors */
                --primary: {{ $theme['primary'] }};
                --primary-hover: {{ $theme['primary_hover'] }};
                --secondary: {{ $theme['secondary'] }};
                --accent: {{ $theme['accent'] }};
                
                /* Sidebar (Strong Identity Element) */
                --sidebar-bg: {{ $theme['sidebar_bg'] }};
                --sidebar-active: {{ $theme['sidebar_active'] }};
                --sidebar-hover: {{ $theme['sidebar_hover'] }};
                --sidebar-text: {{ $theme['sidebar_text'] }};
                --sidebar-icon: {{ $theme['sidebar_icon'] }};
                
                /* Header (Branding Element) */
                --header-bg: {{ $theme['header_bg'] }};
                --header-border: {{ $theme['header_border'] }};
                --header-text: {{ $theme['header_text'] }};
                --header-accent: {{ $theme['header_accent'] }};
                
                /* Buttons (Interactive Feel) */
                --btn-primary: {{ $theme['btn_primary'] }};
                --btn-primary-hover: {{ $theme['btn_primary_hover'] }};
                --btn-primary-focus: {{ $theme['btn_primary_focus'] }};
                --btn-secondary: {{ $theme['btn_secondary'] }};
                --btn-secondary-hover: {{ $theme['btn_secondary_hover'] }};
                
                /* Cards (Subtle Difference) */
                --card-bg: {{ $theme['card_bg'] }};
                --card-border: {{ $theme['card_border'] }};
                --card-accent: {{ $theme['card_accent'] }};
                --card-shadow: {{ $theme['card_shadow'] }};
                --card-hover-shadow: {{ $theme['card_hover_shadow'] }};
                
                /* Background (Visual Mood) */
                --page-bg: {{ $theme['page_bg'] }};
                --page-tint: {{ $theme['page_tint'] }};
                
                /* Status Badges (Theme-based) */
                --status-pending: {{ $theme['status_pending'] }};
                --status-approved: {{ $theme['status_approved'] }};
                --status-rejected: {{ $theme['status_rejected'] }};
                
                /* Login Page (First Impression) */
                --login-gradient-start: {{ $theme['login_gradient_start'] }};
                --login-gradient-end: {{ $theme['login_gradient_end'] }};
                --login-card-glow: {{ $theme['login_card_glow'] }};
                
                /* Shadows (Modern Look) */
                --shadow-color: {{ $theme['shadow_color'] }};
                --shadow-strong: {{ $theme['shadow_strong'] }};
                
                /* Text Colors */
                --text-primary: {{ $theme['text_primary'] }};
                --text-secondary: {{ $theme['text_secondary'] }};
                --text-muted: {{ $theme['text_muted'] }};
                
                /* Dynamic Gradient Variables */
                --gradient-start: {{ $theme['primary'] }};
                --gradient-end: {{ $theme['accent'] }};
                --focus-color: {{ $theme['primary'] }};
            }
            
            /* Debug: Current Theme */
            .debug-theme {
                position: fixed;
                top: 10px;
                left: 10px;
                background: rgba(0,0,0,0.8);
                color: white;
                padding: 10px;
                border-radius: 5px;
                font-size: 12px;
                z-index: 99999;
            }
            
            /* Professional Theme Classes */
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
            
            .ring-theme:focus {
                ring: 2px solid var(--focus-color) !important;
                border-color: var(--focus-color) !important;
            }
            
            /* Button Classes */
            .btn-primary-theme {
                background: linear-gradient(to right, var(--gradient-start), var(--gradient-end)) !important;
                color: white !important;
                border: none !important;
                transition: all 0.3s ease !important;
            }
            
            .btn-primary-theme:hover {
                background: linear-gradient(to right, var(--primary-hover), var(--gradient-start)) !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 12px var(--shadow-color) !important;
            }
            
            .btn-primary-theme:focus {
                box-shadow: 0 0 0 3px var(--btn-primary-focus) !important;
            }
            
            .btn-secondary-theme {
                background-color: var(--btn-secondary) !important;
                color: white !important;
                border: none !important;
                transition: all 0.3s ease !important;
            }
            
            .btn-secondary-theme:hover {
                background-color: var(--btn-secondary-hover) !important;
            }
            
            /* Card Classes */
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
            
            /* Page Background */
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
            
            /* Status Classes */
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
            
            /* Text Classes */
            .text-primary-theme { color: var(--text-primary) !important; }
            .text-secondary-theme { color: var(--text-secondary) !important; }
            .text-muted-theme { color: var(--text-muted) !important; }
            .text-accent-theme { color: var(--header-accent) !important; }
            .text-theme { color: var(--primary) !important; }
            .bg-theme { background-color: var(--primary) !important; }
            
            /* Enhanced Dropdown Styling */
            .college-dropdown {
                background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
                color: white;
                border: none;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
                backdrop-filter: blur(10px);
                position: relative;
                overflow: hidden;
                font-weight: 600;
                letter-spacing: 0.5px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 9999;
            }
            
            .college-dropdown::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
                animation: shimmer 2s infinite;
            }
            
            .college-dropdown:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);
                background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            }
            
            .college-dropdown:focus {
                outline: none;
                box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.5), 0 8px 25px rgba(0, 0, 0, 0.35);
                transform: scale(1.02);
                z-index: 10000;
            }
            
            .college-dropdown option {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                color: #1f2937;
                padding: 12px 16px;
                font-weight: 500;
                border-left: 3px solid var(--primary);
                transition: all 0.2s ease;
            }
            
            .college-dropdown option:hover {
                background: linear-gradient(135deg, var(--bg-main) 0%, #ffffff 100%);
                border-left-color: var(--accent);
                transform: translateX(5px);
            }
            
            .college-dropdown option:checked {
                background: var(--primary);
                color: white;
                border-left-color: var(--accent);
                font-weight: 600;
            }
            
            @keyframes shimmer {
                0% { left: -100%; }
                100% { left: 200%; }
            }
            
            /* Enhanced Container */
            .dropdown-container {
                position: relative;
                z-index: 9998;
            }
            
            .dropdown-container::after {
                content: '';
                position: absolute;
                bottom: -8px;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 0;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-top: 8px solid var(--primary);
                z-index: 10;
            }
            
            /* Fix dropdown positioning */
            .nav-dropdown-wrapper {
                position: relative;
                z-index: 9997;
            }
            
            /* Ensure dropdown appears above all content */
            .college-dropdown-wrapper {
                position: relative;
                z-index: 9999;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased page-bg">
        <!-- Debug Theme Info -->
        <div class="debug-theme">
            College: {{ $college }}<br>
            Primary: {{ $theme['primary'] }}<br>
            Sidebar: {{ $theme['sidebar_active'] }}
        </div>
        
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="header-theme shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center">
                            <div>
                                {{ $header }}
                            </div>
                            
                            <!-- College/Role Selection Dropdown -->
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-secondary-theme font-medium">Select Theme:</span>
                                <form method="GET" action="/set-college" class="flex">
                                    <select name="college"
                                        onchange="this.form.submit()"
                                        class="appearance-none bg-white/90 backdrop-blur border border-gray-300 rounded-lg text-sm px-4 py-2 pr-8 hover:border-gray-400 focus-theme transition-all duration-300 cursor-pointer shadow-sm hover:shadow-md">
                                        <option value="engineering" {{ session('college')=='engineering'?'selected':'' }}>🔧 Engineering College</option>
                                        <option value="arts" {{ session('college')=='arts'?'selected':'' }}>🎨 Arts & Science College</option>
                                        <option value="polytechnic" {{ session('college')=='polytechnic'?'selected':'' }}>⚙️ Polytechnic College</option>
                                        <option value="warden" {{ session('college')=='warden'?'selected':'' }}>🛡️ Warden</option>
                                        <option value="security" {{ session('college')=='security'?'selected':'' }}>🔐 Security</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
