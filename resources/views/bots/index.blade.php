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
                    <h1 class="h2">Your Telegram Bots</h1>
                    <a href="{{ route('bots.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add New Bot
                    </a>
                </div>

                @if(auth()->user()->bots->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Token</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->bots as $bot)
                                    <tr>
                                        <td>{{ $bot->id }}</td>
                                        <td>{{ $bot->name ?: 'Unnamed Bot' }}</td>
                                        <td>
                                            <code class="small">{{ Str::limit($bot->token, 20) }}</code>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('bots.show', $bot) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                <a href="{{ route('bots.edit', $bot) }}" 
                                                   class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('bots.destroy', $bot) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this bot?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="display-6 text-muted mb-3">
                            <i class="bi bi-robot"></i>
                        </div>
                        <h3>No Bots Yet</h3>
                        <p class="text-muted">Get started by creating your first Telegram bot</p>
                        <a href="{{ route('bots.create') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-lg"></i> Create Your First Bot
                        </a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-app-layout>
