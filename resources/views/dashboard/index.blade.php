@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(request()->route('bot'))
    <!-- Bot-specific content will be rendered here -->
    @yield('bot-content')
@else
    <div class="text-center py-5">
        <div class="display-1 text-muted mb-4">
            <i class="bi bi-robot"></i>
        </div>
        <h3 class="text-muted mb-3">Welcome to Your Bot Dashboard</h3>
        <p class="text-muted mb-4">Select a bot from the sidebar or create a new one to get started</p>
        
        @if($bots->isEmpty())
            <a href="{{ route('bots.create') }}" class="btn btn-primary" style="background-color: #3390EC; border-color: #3390EC;">
                <i class="bi bi-plus-lg me-2"></i>Add Your First Bot
            </a>
        @endif
    </div>
@endif
@endsection
