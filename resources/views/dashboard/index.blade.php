<x-app-layout>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="d-flex justify-content-between align-items-center px-3 mb-3">
                        <h6 class="sidebar-heading text-muted">Your Bots</h6>
                        <a href="{{ route('bots.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg"></i> New Bot
                        </a>
                    </div>
                    
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
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                @if(request()->route('bot'))
                    <!-- Bot-specific content will be rendered here -->
                    @yield('bot-content')
                @else
                    <div class="text-center py-5">
                        <h3>Welcome to Your Bot Dashboard</h3>
                        <p class="text-muted">Select a bot from the sidebar or create a new one to get started</p>
                        
                        @if(auth()->user()->bots->isEmpty())
                            <a href="{{ route('bots.create') }}" class="btn btn-primary mt-3">
                                Create Your First Bot
                            </a>
                        @endif
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-app-layout>
