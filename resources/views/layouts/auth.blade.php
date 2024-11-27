<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --telegram-blue: #2AABEE;
            --telegram-button-blue: #3390EC;
            --telegram-hover-blue: #2b95d6;
            --telegram-bg: #ffffff;
            --telegram-secondary: #F5F5F5;
            --telegram-text: #232323;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--telegram-blue) !important;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 12px 12px 0 0 !important;
            padding: 1.5rem;
        }

        .card-header h5 {
            color: var(--telegram-text);
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: var(--telegram-blue);
            box-shadow: 0 0 0 2px rgba(42, 171, 238, 0.1);
        }

        .btn-primary {
            background-color: var(--telegram-button-blue);
            border-color: var(--telegram-button-blue);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--telegram-hover-blue);
            border-color: var(--telegram-hover-blue);
            transform: translateY(-1px);
        }

        .invalid-feedback {
            font-size: 0.875rem;
        }

        a {
            color: var(--telegram-blue);
            text-decoration: none;
        }

        a:hover {
            color: var(--telegram-hover-blue);
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #212529;
            --bs-body-color: #dee2e6;
            --bs-primary: #3390EC;
            --bs-primary-rgb: 51, 144, 236;
        }

        [data-bs-theme="dark"] .card {
            --bs-card-bg: #2C3338;
            --bs-card-border-color: #373B3E;
        }

        [data-bs-theme="dark"] .form-control {
            background-color: #2C3338;
            border-color: #373B3E;
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .form-control:focus {
            background-color: #2C3338;
            border-color: #3390EC;
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .text-muted {
            color: #adb5bd !important;
        }

        .theme-icon {
            width: 1em;
            height: 1em;
            display: none;
        }

        [data-bs-theme="dark"] .theme-icon-dark {
            display: inline-block;
        }

        [data-bs-theme="light"] .theme-icon-light {
            display: inline-block;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 1.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
    </nav>

    <div class="auth-container">
        <div class="container mt-5">
            {{ $slot }}
        </div>
    </div>

    <button class="btn btn-link position-fixed top-0 end-0 mt-3 me-3" id="theme-toggle">
        <svg class="theme-icon theme-icon-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
        <svg class="theme-icon theme-icon-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;
            
            // Check for saved theme preference, otherwise use system preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                html.setAttribute('data-bs-theme', savedTheme);
            } else {
                const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                html.setAttribute('data-bs-theme', systemTheme);
            }

            // Theme toggle handler
            themeToggle.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (!localStorage.getItem('theme')) {
                    html.setAttribute('data-bs-theme', e.matches ? 'dark' : 'light');
                }
            });
        });
    </script>
</body>
</html>
