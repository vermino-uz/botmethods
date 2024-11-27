<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --sidebar-width: 280px;
            --header-height: 64px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        /* Navbar Styles */
        .navbar {
            height: var(--header-height);
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color) !important;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            bottom: 0;
            left: 0;
            width: var(--sidebar-width);
            background: #ffffff;
            box-shadow: 1px 0 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1040;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            margin-top: var(--header-height);
            transition: all 0.3s ease;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #4b5563;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            border-radius: 0;
            transition: all 0.2s ease;
            margin: 0.25rem 0.75rem;
        }

        .sidebar .nav-link:hover {
            color: var(--primary-color);
            background-color: #f3f4f6;
            border-radius: 8px;
        }

        .sidebar .nav-link.active {
            color: var(--primary-color);
            background-color: #ebe9fe;
            border-radius: 8px;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            padding: 0.75rem 1.5rem;
            margin-bottom: 0.5rem;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border-radius: 12px 12px 0 0 !important;
        }

        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1rem;
            font-weight: 500;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Form Controls */
        .form-control {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        }

        /* Table Styles */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #f9fafb;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .navbar-brand {
                margin-left: 0.5rem;
            }

            #sidebarToggle {
                padding: 0.25rem 0.75rem;
                font-size: 1.25rem;
                margin-right: 0.5rem;
            }

            .sidebar-open::after {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1035;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top">
        <div class="container-fluid px-4">
            <button class="navbar-toggler border-0 d-md-none" type="button" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-robot me-2"></i>
                {{ config('app.name', 'BotMethods') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        @auth
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="px-3 mb-3">
                    <a href="{{ route('bots.create') }}" class="btn btn-primary w-100" style="background-color: #3390EC; border-color: #87CEFA; color: #000;">
                        <i class="bi bi-plus-lg me-2"></i>New Bot
                    </a>
                </div>
                
                <h6 class="sidebar-heading">Your Bots</h6>
                <div class="nav flex-column">
                    @forelse (auth()->user()->bots as $bot)
                        <a href="{{ route('bots.show', $bot) }}" 
                           class="nav-link {{ request()->route('bot') && request()->route('bot')->id === $bot->id ? 'active' : '' }}">
                            <i class="bi bi-robot me-2"></i>
                            {{ $bot->name ?: 'Unnamed Bot' }}
                        </a>
                    @empty
                        <div class="text-muted px-3">
                            <p>No bots yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endauth

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Sidebar Toggle for Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                });

                // Close sidebar when clicking outside
                document.addEventListener('click', function(event) {
                    if (window.innerWidth < 768 && 
                        !sidebar.contains(event.target) && 
                        !sidebarToggle.contains(event.target) && 
                        sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        document.body.classList.remove('sidebar-open');
                    }
                });
            }
        });

        // Copy to Clipboard Function
        function copyToClipboard(button) {
            const textToCopy = button.getAttribute('data-copy-text');
            navigator.clipboard.writeText(textToCopy).then(() => {
                const originalText = button.innerHTML;
                button.innerHTML = 'Copied!';
                setTimeout(() => {
                    button.innerHTML = originalText;
                }, 2000);
            });
        }
    </script>
</body>
</html>