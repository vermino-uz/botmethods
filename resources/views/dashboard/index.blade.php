@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <a href="{{ route('bots.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Add New Bot
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($bots->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    @foreach($bots as $bot)
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                            <i class="bi bi-robot text-primary"></i>
                                        </div>
                                        <h5 class="card-title mb-0">{{ $bot->name ?: 'Unnamed Bot' }}</h5>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Bot Token</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="{{ $bot->token }}" readonly>
                                            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="copyToClipboard(this)" data-copy-text="{{ $bot->token }}">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text" class="form-control form-control-sm" value="{{ $bot->username }}" readonly>
                                            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="copyToClipboard(this)" data-copy-text="{{ $bot->username }}">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="text-muted small mb-3">
                                        <i class="bi bi-clock me-1"></i>
                                        Created {{ $bot->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('bots.show', $bot) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-gear me-1"></i>
                                            Manage Bot
                                        </a>
                                        <form action="{{ route('bots.destroy', $bot) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this bot?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="display-1 text-muted mb-4">
                            <i class="bi bi-robot"></i>
                        </div>
                        <h3 class="text-muted mb-3">Welcome to Your Bot Dashboard</h3>
                        <p class="text-muted mb-4">Get started by creating your first Telegram bot</p>
                        <a href="{{ route('bots.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-2"></i>Create Your First Bot
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
