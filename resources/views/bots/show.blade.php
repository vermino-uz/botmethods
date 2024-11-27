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
                        @foreach (auth()->user()->bots as $userBot)
                            <a href="{{ route('bots.show', $userBot) }}" 
                               class="nav-link {{ $bot->id === $userBot->id ? 'active' : '' }}">
                                <i class="bi bi-robot me-2"></i>
                                {{ $userBot->name ?: 'Unnamed Bot' }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{ $bot->name ?: 'Unnamed Bot' }}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('delete-bot-form').submit();">
                                Delete Bot
                            </button>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Bot Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        Bot Details
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Bot Token</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $bot->token }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)" data-copy-text="{{ $bot->token }}">
                                    Copy
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Created At</label>
                            <input type="text" class="form-control" value="{{ $bot->created_at }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Bot API Methods -->
                <div class="card">
                    <div class="card-header">
                        API Methods
                    </div>
                    <div class="card-body">
                        <!-- Send Message Form -->
                        <form class="mb-4 api-method-form" action="{{ route('bots.send-message', $bot) }}" method="POST">
                            @csrf
                            <h5>Send Message</h5>
                            <div class="mb-3">
                                <label for="chat_id" class="form-label">Chat ID</label>
                                <input type="text" class="form-control" id="chat_id" name="chat_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>

                        <hr>

                        <!-- Get Updates Form -->
                        <form class="mb-4 api-method-form" action="{{ route('bots.updates', $bot) }}" method="GET">
                            <h5>Get Updates</h5>
                            <button type="submit" class="btn btn-primary">Get Updates</button>
                        </form>
                    </div>
                </div>

                <!-- Delete Bot Form -->
                <form id="delete-bot-form" action="{{ route('bots.destroy', $bot) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </main>
        </div>
    </div>

    <!-- API Response Modal -->
    <div class="modal fade" id="apiResponseModal" tabindex="-1" aria-labelledby="apiResponseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="apiResponseModalLabel">API Response</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="modalSpinner">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="apiResponseBody"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(button) {
            const text = button.dataset.copyText;
            navigator.clipboard.writeText(text).then(() => {
                const originalText = button.innerText;
                button.innerText = 'Copied!';
                setTimeout(() => {
                    button.innerText = originalText;
                }, 2000);
            });
        }
    </script>
    @endpush
</x-app-layout>
