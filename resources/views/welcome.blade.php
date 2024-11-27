<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
            color: var(--telegram-text);
            min-height: 100vh;
        }

        .hero-section {
            padding: 120px 0 80px;
            background: radial-gradient(circle at 30% 107%, rgba(42, 171, 238, 0.1) 0%, rgba(42, 171, 238, 0) 80%);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--telegram-text) 0%, #505050 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 2rem;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--telegram-blue);
            margin-bottom: 1rem;
        }

        .btn-primary {
            background-color: var(--telegram-button-blue);
            border-color: var(--telegram-button-blue);
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--telegram-hover-blue);
            border-color: var(--telegram-hover-blue);
            transform: translateY(-2px);
        }

        .btn-outline {
            color: var(--telegram-button-blue);
            border: 2px solid var(--telegram-button-blue);
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.2s ease;
            background: transparent;
        }

        .btn-outline:hover {
            background-color: var(--telegram-button-blue);
            color: white;
            transform: translateY(-2px);
        }

        .nav-link {
            color: var(--telegram-text);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--telegram-blue);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-section {
                padding: 80px 0 60px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div class="d-flex">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link me-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Create and Manage Your Telegram Bots</h1>
                    <p class="hero-subtitle">Build, test, and deploy Telegram bots with ease. No coding required.</p>
                    <div class="d-flex gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started Free</a>
                            <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111646.png" alt="Telegram Bot" class="img-fluid" style="max-width: 400px; opacity: 0.9;">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-robot feature-icon"></i>
                        <h3 class="h4 mb-3">Easy Bot Creation</h3>
                        <p class="text-muted mb-0">Create your Telegram bot in minutes with our intuitive interface. No technical knowledge required.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-gear feature-icon"></i>
                        <h3 class="h4 mb-3">Powerful Management</h3>
                        <p class="text-muted mb-0">Manage all your bots from a single dashboard. Monitor performance and make updates easily.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-graph-up feature-icon"></i>
                        <h3 class="h4 mb-3">Real-time Testing</h3>
                        <p class="text-muted mb-0">Test your bot's functionality in real-time and make adjustments on the fly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
