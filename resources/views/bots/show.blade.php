@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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
@endsection
