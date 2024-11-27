@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <div class="d-flex justify-content-between align-items-center px-3 mb-3">
                    <h6 class="sidebar-heading text-muted">YOUR BOTS</h6>
                    <a href="{{ route('bots.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg"></i> New Bot
                    </a>
                </div>
                <ul class="nav flex-column">
                    @forelse(Auth::user()->bots as $bot)
                        <li class="nav-item">
                            <a href="{{ route('bots.show', $bot) }}" 
                               class="nav-link {{ request()->is('bots/'.$bot->id) ? 'active' : '' }}">
                                <i class="bi bi-robot"></i>
                                {{ $bot->name }}
                            </a>
                        </li>
                    @empty
                        <li class="nav-item">
                            <span class="nav-link text-muted">
                                <i class="bi bi-info-circle"></i>
                                No bots yet
                            </span>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Welcome to Bot Methods!</h5>
                            <p class="card-text">Get started by creating a new bot using the sidebar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
