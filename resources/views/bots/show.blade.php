@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
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
        const apiMethods = {
            'sendmessage': [
                {'chat_id': 'int'},
                {'message': 'string'}
            ],
            'getme': []
            // Add more methods as needed
        };

        document.addEventListener('DOMContentLoaded', function() {
            const apiMethodSelect = document.getElementById('api-method');
            const methodFieldsContainer = document.getElementById('method-fields');

            // Populate dropdown
            for (const method in apiMethods) {
                const option = document.createElement('option');
                option.value = method;
                option.textContent = method.replace(/([a-z])([A-Z])/g, '$1 $2'); // Converts camelCase to spaced words
                apiMethodSelect.appendChild(option);
            }

            // Update form fields on method change
            apiMethodSelect.addEventListener('change', function() {
                const selectedMethod = apiMethodSelect.value;
                methodFieldsContainer.innerHTML = '';

                if (apiMethods[selectedMethod]) {
                    apiMethods[selectedMethod].forEach(field => {
                        const fieldName = Object.keys(field)[0];
                        const fieldType = field[fieldName];
                        const formGroup = document.createElement('div');
                        formGroup.className = 'mb-3';

                        const label = document.createElement('label');
                        label.className = 'form-label';
                        label.setAttribute('for', fieldName);
                        label.textContent = fieldName.charAt(0).toUpperCase() + fieldName.slice(1);

                        const input = document.createElement('input');
                        input.className = 'form-control';
                        input.id = fieldName;
                        input.name = fieldName;
                        input.type = fieldType === 'int' ? 'number' : 'text';
                        input.required = true;

                        formGroup.appendChild(label);
                        formGroup.appendChild(input);
                        methodFieldsContainer.appendChild(formGroup);
                    });
                }
            });
        });

        function submitApiRequest() {
            const form = document.getElementById('api-method-form');
            const formData = new FormData(form);
            const method = formData.get('api-method');
            let url = '';
            let options = {};

            if (method === 'sendmessage') {
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
            } else if (method === 'getme') {
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
