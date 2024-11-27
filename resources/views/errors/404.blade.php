@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-1">404</h1>
            <h2 class="mb-4">Page Not Found</h2>
            <p class="lead mb-4">The page you are looking for could not be found.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <i class="bi bi-house-door"></i> Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
