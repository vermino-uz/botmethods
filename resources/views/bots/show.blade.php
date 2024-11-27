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
                        <form id="api-method-form">
                            <div class="mb-3">
                                <label for="api-method" class="form-label">Select Method</label>
                                <select class="form-select" id="api-method" name="api-method">
                                    <option value="send-message">Send Message</option>
                                    <option value="get-updates">Get Updates</option>
                                </select>
                            </div>

                            <!-- Dynamic Fields -->
                            <div id="method-fields">
                                <!-- Fields will be dynamically inserted here -->
                            </div>

                            <button type="button" class="btn btn-primary" onclick="submitApiRequest()">Submit</button>
                        </form>
                    </div>
                </div>
            </main>
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
                        <pre id="apiResponseContent"></pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Bot Form -->
        <form id="delete-bot-form" action="{{ route('bots.destroy', $bot) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const methodFields = {
                    'send-message': `
                        <div class="mb-3">
                            <label for="chat_id" class="form-label">Chat ID</label>
                            <input type="text" class="form-control" id="chat_id" name="chat_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                        </div>
                    `,
                    'get-updates': ''
                };

                const apiMethodSelect = document.getElementById('api-method');
                const methodFieldsContainer = document.getElementById('method-fields');

                function updateMethodFields() {
                    const selectedMethod = apiMethodSelect.value;
                    methodFieldsContainer.innerHTML = methodFields[selectedMethod] || '';
                }

                apiMethodSelect.addEventListener('change', updateMethodFields);
                updateMethodFields();
            });

            function submitApiRequest() {
                const form = document.getElementById('api-method-form');
                const formData = new FormData(form);
                const method = formData.get('api-method');
                let url = '';
                let options = {};

                if (method === 'send-message') {
                    url = `{{ route('bots.send-message', $bot) }}`;
                    options = {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            chat_id: formData.get('chat_id'),
                            message: formData.get('message')
                        })
                    };
                } else if (method === 'get-updates') {
                    url = `{{ route('bots.updates', $bot) }}`;
                    options = {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    };
                }

                fetch(url, options)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('apiResponseContent').textContent = JSON.stringify(data, null, 2);
                        new bootstrap.Modal(document.getElementById('apiResponseModal')).show();
                    })
                    .catch(error => {
                        document.getElementById('apiResponseContent').textContent = 'Error: ' + error;
                        new bootstrap.Modal(document.getElementById('apiResponseModal')).show();
                    });
            }
        </script>
    </div>
</x-app-layout>
