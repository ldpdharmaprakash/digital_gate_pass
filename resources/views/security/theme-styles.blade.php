{{-- Security-specific theme styles --}}
@php
$securityPrimary = Session::get('theme_color', '#1e3a8a');
$securitySecondary = '#ff6b35';
$securityAccent = '#4ecdc4';
$securityDanger = '#e74a3b';
$securityWarning = '#f39c12';
$securitySuccess = '#27ae60';
@endphp

<style>
/* Security Theme Variables */
:root {
    --security-primary: {{ $securityPrimary }};
    --security-secondary: {{ $securitySecondary }};
    --security-accent: {{ $securityAccent }};
    --security-danger: {{ $securityDanger }};
    --security-warning: {{ $securityWarning }};
    --security-success: {{ $securitySuccess }};
}

/* Security-specific overrides */
.security-theme {
    background: linear-gradient(135deg, var(--security-primary) 0%, #2c3e50 100%);
    color: white;
}

.security-theme .card {
    border-left: 4px solid var(--security-primary);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.security-theme .btn-primary {
    background-color: var(--security-primary);
    border-color: var(--security-primary);
    color: white;
}

.security-theme .btn-primary:hover {
    background-color: #2c3e50;
    border-color: #2c3e50;
}

.security-theme .btn-danger {
    background-color: var(--security-danger);
    border-color: var(--security-danger);
}

.security-theme .btn-success {
    background-color: var(--security-success);
    border-color: var(--security-success);
}

.security-theme .btn-warning {
    background-color: var(--security-warning);
    border-color: var(--security-warning);
}

.security-theme .badge {
    font-weight: 500;
}

.security-theme .navbar {
    background-color: var(--security-primary) !important;
    border-bottom: 2px solid var(--security-secondary);
}

.security-theme .sidebar {
    background-color: #2c3e50 !important;
}

.security-theme .sidebar .nav-link {
    color: #ecf0f1;
    border-left: 3px solid transparent;
}

.security-theme .sidebar .nav-link:hover,
.security-theme .sidebar .nav-link.active {
    background-color: var(--security-primary);
    border-left-color: var(--security-secondary);
    color: white;
}

.security-theme .card-header {
    background-color: var(--security-primary);
    color: white;
    border-bottom: 2px solid var(--security-secondary);
}

.security-theme .table th {
    background-color: var(--security-primary);
    color: white;
}

.security-theme .table-hover tbody tr:hover {
    background-color: rgba(30, 58, 138, 0.1);
}

/* QR Scanner specific styles */
.qr-scanner-container {
    border: 3px solid var(--security-primary);
    border-radius: 12px;
    background: white;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.qr-scanner-active {
    border-color: var(--security-success);
    box-shadow: 0 0 20px rgba(39, 174, 96, 0.4);
}

.qr-scanner-error {
    border-color: var(--security-danger);
    box-shadow: 0 0 20px rgba(231, 74, 59, 0.4);
}

/* Entry/Exit button styles */
.entry-exit-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.entry-exit-buttons .btn {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.entry-exit-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Status badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

/* Security dashboard cards */
.security-stat-card {
    border: none;
    border-radius: 12px;
    background: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.security-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.security-stat-card .card-body {
    padding: 1.5rem;
}

.security-stat-card .stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

/* Animations */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.scanning-active {
    animation: pulse 2s infinite;
}

/* Loading states */
.loading-spinner {
    border: 3px solid var(--security-primary);
    border-top: 3px solid transparent;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .entry-exit-buttons {
        grid-template-columns: 1fr;
    }
    
    .security-stat-card {
        margin-bottom: 1rem;
    }
}
</style>
