<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f8f9fa; }
        .hero-section { background: linear-gradient(135deg, #3390EC 0%, #2B7DD1 100%); color: white; padding: 80px 0; }
        .feature-icon { width: 60px; height: 60px; background-color: #e9ecef; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.8rem; }
        .feature-icon i { font-size: 1.4rem; color: #3390EC; }
        .btn-primary { background-color: #3390EC; border-color: #3390EC; }
        .btn-primary:hover { background-color: #2B7DD1; border-color: #2B7DD1; }
        .btn-outline-light:hover { background-color: rgba(255, 255, 255, 0.1); color: white; }
        .navbar { background-color: transparent; padding: 0.8rem 0; }
        .navbar-brand { color: white !important; font-weight: 600; }
        .nav-link { color: rgba(255, 255, 255, 0.9) !important; }
    </style>
</head>
<body>
    <div class="hero-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
                <div class="d-flex">
                    @if (Route::has('login'))
                        <div class="d-flex gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-light">Sign in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-light">Get Started</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">Build Powerful Telegram Bots with Ease</h1>
                    <p class="lead mb-3">Create, manage, and scale your Telegram bots all in one place. No coding required.</p>
                    <div class="d-flex gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg">Get Started Free</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Sign In</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3 bg-white rounded-3 h-100 shadow-sm">
                    <div class="feature-icon"><i class="bi bi-lightning-charge"></i></div>
                    <h3 class="h5 mb-2">Quick Setup</h3>
                    <p class="text-muted mb-0">Get your bot up and running in minutes with our intuitive interface.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-white rounded-3 h-100 shadow-sm">
                    <div class="feature-icon"><i class="bi bi-gear"></i></div>
                    <h3 class="h5 mb-2">Powerful Features</h3>
                    <p class="text-muted mb-0">Access advanced bot management tools and analytics.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-white rounded-3 h-100 shadow-sm">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h3 class="h5 mb-2">Secure & Reliable</h3>
                    <p class="text-muted mb-0">Built with security in mind, ensuring your bots run smoothly 24/7.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
