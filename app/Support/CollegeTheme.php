<?php

namespace App\Support;

class CollegeTheme
{
    public static function getTheme($college = 'engineering')
    {
        $themes = [
            
            'admin' => [

                /* ================= CORE IDENTITY ================= */
                'primary' => '#2563eb',          // Strong institutional blue
                'primary_hover' => '#1d4ed8',
                'secondary' => '#4f46e5',        // Indigo accent
                'accent' => '#6366f1',

                /* ================= SIDEBAR (MAIN BRAND) ================= */
                'sidebar_bg' => 'linear-gradient(200deg, #f5f5f5ff 0%, #8791ffff 100%, #985ef6ff 100%)',
                'sidebar_active' => '#3b82f6',
                'sidebar_hover' => 'rgba(255,255,255,0.08)',
                'sidebar_text' => '#ffffff',
                'sidebar_icon' => '#e0e7ff',

                /* ================= HEADER ================= */
                'header_bg' => '#ffffff',
                'header_border' => '#e5e7eb',
                'header_text' => '#1f2937',
                'header_accent' => '#2563eb',

                /* ================= BUTTONS ================= */
                'btn_primary' => '#2563eb',
                'btn_primary_hover' => '#1d4ed8',
                'btn_primary_focus' => 'rgba(37,99,235,0.25)',
                'btn_secondary' => '#64748b',
                'btn_secondary_hover' => '#475569',

                /* ================= CARDS ================= */
                'card_bg' => '#ffffff',
                'card_border' => '#e5e7eb',
                'card_accent' => '#2563eb',
                'card_shadow' => 'rgba(37,99,235,0.08)',
                'card_hover_shadow' => 'rgba(37,99,235,0.18)',

                /* ================= PAGE BACKGROUND ================= */
                'page_bg' => '#f8fafc',
                'page_tint' => 'rgba(37,99,235,0.03)',

                /* ================= STATUS ================= */
                'status_pending' => '#f59e0b',
                'status_approved' => '#10b981',
                'status_rejected' => '#ef4444',

                /* ================= LOGIN ================= */
                'login_gradient_start' => '#1e3a8a',
                'login_gradient_end' => '#4f46e5',
                'login_card_glow' => 'rgba(79,70,229,0.25)',

                /* ================= SHADOW SYSTEM ================= */
                'shadow_color' => 'rgba(37,99,235,0.10)',
                'shadow_strong' => 'rgba(37,99,235,0.20)',

                /* ================= TEXT ================= */
                'text_primary' => '#1f2937',
                'text_secondary' => '#64748b',
                'text_muted' => '#94a3b8',
            ],

            'warden' => [
                // Core Identity Colors
                'primary' => '#7f1d1d',
                'primary_hover' => '#991b1b',
                'secondary' => '#db2777',
                'accent' => '#db2777',
                
                // Sidebar (Strong Identity Element)
                'sidebar_bg' => 'linear-gradient(180deg, #faf5f6ff 0%, #d32954ff 100%)',
                'sidebar_active' => '#be123c',
                'sidebar_hover' => 'rgba(190, 18, 60, 0.1)',
                'sidebar_text' => '#ffffff',
                'sidebar_icon' => '#ffffff',
                
                // Header (Branding Element)
                'header_bg' => '#ffffff',
                'header_border' => '#fce7f3',
                'header_text' => '#1f2937',
                'header_accent' => '#7f1d1d',
                
                // Buttons (Interactive Feel)
                'btn_primary' => '#7f1d1d',
                'btn_primary_hover' => '#991b1b',
                'btn_primary_focus' => 'rgba(127, 29, 29, 0.2)',
                'btn_secondary' => '#6b7280',
                'btn_secondary_hover' => '#4b5563',
                
                // Cards (Subtle Difference)
                'card_bg' => '#ffffff',
                'card_border' => '#fce7f3',
                'card_accent' => '#7f1d1d',
                'card_shadow' => 'rgba(127, 29, 29, 0.1)',
                'card_hover_shadow' => 'rgba(127, 29, 29, 0.15)',
                
                // Background (Visual Mood)
                'page_bg' => '#fdf4ff',
                'page_tint' => 'rgba(127, 29, 29, 0.02)',
                
                // Status Badges (Theme-based)
                'status_pending' => '#f59e0b',
                'status_approved' => '#10b981',
                'status_rejected' => '#ef4444',
                
                // Login Page (First Impression)
                'login_gradient_start' => '#7f1d1d',
                'login_gradient_end' => '#db2777',
                'login_card_glow' => 'rgba(127, 29, 29, 0.2)',
                
                // Shadows (Modern Look)
                'shadow_color' => 'rgba(127, 29, 29, 0.1)',
                'shadow_strong' => 'rgba(127, 29, 29, 0.2)',
                
                // Text Colors
                'text_primary' => '#1f2937',
                'text_secondary' => '#6b7280',
                'text_muted' => '#9ca3af',
            ],
            'polytechnic' => [
                // ==============================
                // CORE IDENTITY (Elegant Plum Rose)
                // ==============================
                'primary' => '#8b5cf6',            // Soft academic violet
                'primary_hover' => '#7c3aed',
                'secondary' => '#ec4899',          // Rose accent
                'accent' => '#f472b6',

                // ==============================
                // SIDEBAR (Main Identity Surface)
                // ==============================
                'sidebar_bg' => 'linear-gradient(180deg, #fdf2f8 0%, #e9d5ff 100%)',
                'sidebar_active' => '#8b5cf6',
                'sidebar_hover' => 'rgba(139, 92, 246, 0.08)',
                'sidebar_text' => '#4c1d95',
                'sidebar_icon' => '#7c3aed',

                // ==============================
                // HEADER (Clean Academic Look)
                // ==============================
                'header_bg' => '#ffffff',
                'header_border' => '#f3e8ff',
                'header_text' => '#4c1d95',
                'header_accent' => '#8b5cf6',

                // ==============================
                // BUTTONS (Clear + Soft)
                // ==============================
                'btn_primary' => '#8b5cf6',
                'btn_primary_hover' => '#7c3aed',
                'btn_primary_focus' => 'rgba(139, 92, 246, 0.25)',
                'btn_secondary' => '#f9a8d4',
                'btn_secondary_hover' => '#f472b6',

                // ==============================
                // CARDS (Soft Premium Surface)
                // ==============================
                'card_bg' => '#ffffff',
                'card_border' => '#f3e8ff',
                'card_accent' => '#8b5cf6',
                'card_shadow' => 'rgba(139, 92, 246, 0.08)',
                'card_hover_shadow' => 'rgba(139, 92, 246, 0.15)',

                // ==============================
                // PAGE BACKGROUND (Reading Comfort)
                // ==============================
                'page_bg' => '#fdf4ff',
                'page_tint' => 'rgba(236, 72, 153, 0.03)',

                // ==============================
                // STATUS (Universal UX)
                // ==============================
                'status_pending' => '#f59e0b',
                'status_approved' => '#10b981',
                'status_rejected' => '#ef4444',

                // ==============================
                // LOGIN (Premium Feminine Academic)
                // ==============================
                'login_gradient_start' => '#ec4899',
                'login_gradient_end' => '#8b5cf6',
                'login_card_glow' => 'rgba(236, 72, 153, 0.25)',

                // ==============================
                // SHADOWS
                // ==============================
                'shadow_color' => 'rgba(139, 92, 246, 0.1)',
                'shadow_strong' => 'rgba(139, 92, 246, 0.2)',

                // ==============================
                // TEXT
                // ==============================
                'text_primary' => '#4c1d95',
                'text_secondary' => '#6b7280',
                'text_muted' => '#9ca3af',
            ],

            'engineering' => [
                // Core Identity Colors (Saffron Academic Identity)
                'primary' => '#f59e0b',           // saffron yellow
                'primary_hover' => '#d97706',     // deep saffron
                'secondary' => '#fde68a',         // soft yellow
                'accent' => '#fbbf24',            // warm saffron accent
                
                // Sidebar (Campus Identity)
                'sidebar_bg' => 'linear-gradient(180deg, #fff7ed 0%, #fbbf24 100%)',
                'sidebar_active' => '#d97706',
                'sidebar_hover' => 'rgba(217, 119, 6, 0.12)',
                'sidebar_text' => '#ffffff',
                'sidebar_icon' => '#ffffff',
                
                // Header (Clean Academic)
                'header_bg' => '#ffffff',
                'header_border' => '#fde68a',
                'header_text' => '#1f2937',
                'header_accent' => '#f59e0b',
                
                // Buttons (Warm Interaction)
                'btn_primary' => '#f59e0b',
                'btn_primary_hover' => '#d97706',
                'btn_primary_focus' => 'rgba(245, 158, 11, 0.25)',
                'btn_secondary' => '#6b7280',
                'btn_secondary_hover' => '#4b5563',
                
                // Cards (Soft Modern)
                'card_bg' => '#ffffff',
                'card_border' => '#fde68a',
                'card_accent' => '#f59e0b',
                'card_shadow' => 'rgba(245, 158, 11, 0.10)',
                'card_hover_shadow' => 'rgba(245, 158, 11, 0.18)',
                
                // Background (Light Campus Mood)
                'page_bg' => '#fffbeb',
                'page_tint' => 'rgba(245, 158, 11, 0.03)',
                
                // Status Badges
                'status_pending' => '#f59e0b',
                'status_approved' => '#10b981',
                'status_rejected' => '#ef4444',
                
                // Login Page (Warm Gradient)
                'login_gradient_start' => '#f59e0b',
                'login_gradient_end' => '#fde68a',
                'login_card_glow' => 'rgba(245, 158, 11, 0.25)',
                
                // Shadows (Glow saffron)
                'shadow_color' => 'rgba(245, 158, 11, 0.10)',
                'shadow_strong' => 'rgba(245, 158, 11, 0.22)',
                
                // Text Colors
                'text_primary' => '#1f2937',
                'text_secondary' => '#6b7280',
                'text_muted' => '#9ca3af',
            ],

            'arts' => [
                // Core Identity Colors (Neon Green Identity)
                'primary' => '#059669',                 // deep green base
                'primary_hover' => '#047857',
                'secondary' => '#0fe01d',               // neon green
                'accent' => '#0fe01d',                  // main highlight

                // Sidebar (Campus Identity Area)
                'sidebar_bg' => 'linear-gradient(180deg, #ecfff1 0%, #0fe01d 100%)',
                'sidebar_active' => '#0fe01d',
                'sidebar_hover' => 'rgba(15, 224, 29, 0.12)',
                'sidebar_text' => '#ffffff',
                'sidebar_icon' => '#ffffff',

                // Header
                'header_bg' => '#ffffff',
                'header_border' => '#d1fadf',
                'header_text' => '#1f2937',
                'header_accent' => '#0fe01d',

                // Buttons
                'btn_primary' => '#0fe01d',
                'btn_primary_hover' => '#0cc51a',
                'btn_primary_focus' => 'rgba(15, 224, 29, 0.25)',
                'btn_secondary' => '#6b7280',
                'btn_secondary_hover' => '#4b5563',

                // Cards
                'card_bg' => '#ffffff',
                'card_border' => '#d1fadf',
                'card_accent' => '#0fe01d',
                'card_shadow' => 'rgba(15, 224, 29, 0.12)',
                'card_hover_shadow' => 'rgba(15, 224, 29, 0.22)',

                // Page Background
                'page_bg' => '#f3fff5',
                'page_tint' => 'rgba(15, 224, 29, 0.03)',

                // Status Badges
                'status_pending' => '#f59e0b',
                'status_approved' => '#0fe01d',
                'status_rejected' => '#ef4444',

                // Login Page
                'login_gradient_start' => '#059669',
                'login_gradient_end' => '#0fe01d',
                'login_card_glow' => 'rgba(15, 224, 29, 0.30)',

                // Shadows
                'shadow_color' => 'rgba(15, 224, 29, 0.12)',
                'shadow_strong' => 'rgba(15, 224, 29, 0.25)',

                // Text
                'text_primary' => '#1f2937',
                'text_secondary' => '#6b7280',
                'text_muted' => '#9ca3af',
            ],

            'security' => [
                // Core Identity Colors (Soft Glow Red)
                'primary' => '#ff4d4d',
                'primary_hover' => '#ff3333',
                'secondary' => '#ff8080',
                'accent' => '#ff6b6b',
                
                // Sidebar (Glow Gradient Look)
                'sidebar_bg' => 'linear-gradient(180deg, #fff5f5 0%, #ff4d4d 100%)',
                'sidebar_active' => '#ff3333',
                'sidebar_hover' => 'rgba(255, 77, 77, 0.15)',
                'sidebar_text' => '#ffffff',
                'sidebar_icon' => '#ffffff',
                
                // Header (Clean + Glow Accent)
                'header_bg' => '#ffffff',
                'header_border' => '#ffe5e5',
                'header_text' => '#1f2937',
                'header_accent' => '#ff4d4d',
                
                // Buttons (Soft Glow)
                'btn_primary' => '#ff4d4d',
                'btn_primary_hover' => '#ff3333',
                'btn_primary_focus' => 'rgba(255, 77, 77, 0.25)',
                'btn_secondary' => '#9ca3af',
                'btn_secondary_hover' => '#6b7280',
                
                // Cards (Glow Shadow)
                'card_bg' => '#ffffff',
                'card_border' => '#ffe5e5',
                'card_accent' => '#ff4d4d',
                'card_shadow' => 'rgba(255, 77, 77, 0.15)',
                'card_hover_shadow' => 'rgba(255, 77, 77, 0.25)',
                
                // Background (Very Light Security Tint)
                'page_bg' => '#fffafa',
                'page_tint' => 'rgba(255, 77, 77, 0.03)',
                
                // Status Badges
                'status_pending' => '#fbbf24',
                'status_approved' => '#34d399',
                'status_rejected' => '#ff4d4d',
                
                // Login Page (Glow Hero Gradient)
                'login_gradient_start' => '#ff4d4d',
                'login_gradient_end' => '#ff8080',
                'login_card_glow' => 'rgba(255, 77, 77, 0.35)',
                
                // Shadows (Glow Feeling)
                'shadow_color' => 'rgba(255, 77, 77, 0.15)',
                'shadow_strong' => 'rgba(255, 77, 77, 0.30)',
                
                // Text Colors
                'text_primary' => '#1f2937',
                'text_secondary' => '#6b7280',
                'text_muted' => '#9ca3af',
            ],

        ];

        return $themes[$college] ?? $themes['engineering'];
    }
}
