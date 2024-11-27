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
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control" value="{{ $bot->username }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)" data-copy-text="{{ $bot->username }}">
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
                    <form id="api-method-form" onsubmit="return submitApiRequest()">
                        <div class="mb-3">
                            <label for="api-method" class="form-label">Select Method</label>
                            <div class="input-group">
                                <input type="text" id="method-search" class="form-control" placeholder="Search methods...">
                                <select id="api-method" name="api-method" class="form-select" required>
                                    <option value="">Select a method</option>
                                </select>
                            </div>
                        </div>

                        <div id="method-fields" class="mb-3">
                            <!-- Method parameters will be dynamically added here -->
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i>
                            Send Request
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- API Response Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">API Response</h5>
                    <div class="ms-auto me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleAllNodes()">
                            <i class="bi bi-arrows-expand"></i>
                            Toggle All
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="copyResponse()">
                            <i class="bi bi-clipboard"></i>
                            Copy
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="json-container bg-light p-3 rounded">
                        <pre><code class="language-json" id="responseContent"></code></pre>
                    </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            hljs.highlightAll();
            
            const methodSearchInput = document.getElementById('method-search');
            const apiMethodSelect = document.getElementById('api-method');
            const methodFieldsContainer = document.getElementById('method-fields');

            // List of Telegram Bot API methods with their parameters
            const apiMethods = {
                getMe: {},
                getUpdates: {
                    offset: { type: 'number', description: 'Identifier of the first update to be returned' },
                    limit: { type: 'number', description: 'Limits the number of updates to be retrieved' },
                    timeout: { type: 'number', description: 'Timeout in seconds for long polling' },
                    allowed_updates: { type: 'string', description: 'List of update types to receive' }
                },
                sendMessage: {
                    chat_id: { type: 'string', required: true, description: 'Unique identifier for the target chat' },
                    text: { type: 'string', required: true, description: 'Text of the message to be sent' },
                    parse_mode: { type: 'string', description: 'Mode for parsing entities in the message text' },
                    disable_notification: { type: 'boolean', description: 'Sends the message silently' }
                },
                sendPhoto: {
                    chat_id: { type: 'string', required: true, description: 'Unique identifier for the target chat' },
                    photo: { type: 'string', required: true, description: 'Photo to send (file_id or URL)' },
                    caption: { type: 'string', description: 'Photo caption' },
                    parse_mode: { type: 'string', description: 'Mode for parsing entities in the caption' }
                },
                getChat: {
                    chat_id: { type: 'string', required: true, description: 'Unique identifier for the target chat' }
                }
            };

            // Populate method select on page load
            function populateSelect(methods) {
                apiMethodSelect.innerHTML = '<option value="">Select a method</option>';
                Object.keys(methods).sort().forEach(method => {
                    const option = document.createElement('option');
                    option.value = method;
                    option.textContent = method;
                    apiMethodSelect.appendChild(option);
                });
            }

            // Initial population
            populateSelect(apiMethods);

            // Search functionality
            methodSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredMethods = Object.keys(apiMethods)
                    .filter(method => method.toLowerCase().includes(searchTerm))
                    .reduce((obj, key) => {
                        obj[key] = apiMethods[key];
                        return obj;
                    }, {});
                populateSelect(filteredMethods);
            });

            // Generate parameter fields when method is selected
            apiMethodSelect.addEventListener('change', function() {
                const selectedMethod = this.value;
                methodFieldsContainer.innerHTML = '';

                if (selectedMethod && apiMethods[selectedMethod]) {
                    const parameters = apiMethods[selectedMethod];
                    Object.entries(parameters).forEach(([param, details]) => {
                        const div = document.createElement('div');
                        div.className = 'mb-3';
                        
                        const label = document.createElement('label');
                        label.className = 'form-label';
                        label.htmlFor = param;
                        label.textContent = `${param}${details.required ? ' *' : ''}`;
                        
                        const input = document.createElement('input');
                        input.type = details.type === 'boolean' ? 'checkbox' : 'text';
                        input.className = details.type === 'boolean' ? 'form-check-input' : 'form-control';
                        input.id = param;
                        input.name = param;
                        if (details.required) input.required = true;
                        
                        const small = document.createElement('small');
                        small.className = 'form-text text-muted';
                        small.textContent = details.description;
                        
                        div.appendChild(label);
                        div.appendChild(input);
                        div.appendChild(small);
                        methodFieldsContainer.appendChild(div);
                    });
                }
            });

            function submitApiRequest() {
                const form = document.getElementById('api-method-form');
                const formData = new FormData(form);
                const method = formData.get('api-method');
                const botToken = '{{ $bot->token }}';
                let url = `https://api.telegram.org/bot${botToken}/${method}?`;

                // Convert FormData to URL parameters
                const params = {};
                for (let [key, value] of formData.entries()) {
                    if (key !== 'api-method' && value) {
                        params[key] = value;
                    }
                }

                // Make the API request
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(params)
                })
                .then(response => response.json())
                .then(data => {
                    const responseContent = document.getElementById('responseContent');
                    responseContent.textContent = JSON.stringify(data, null, 2);
                    hljs.highlightElement(responseContent);
                    
                    const responseModal = new bootstrap.Modal(document.getElementById('responseModal'));
                    responseModal.show();
                })
                .catch(error => {
                    const responseContent = document.getElementById('responseContent');
                    responseContent.textContent = JSON.stringify({ error: error.message }, null, 2);
                    hljs.highlightElement(responseContent);
                    
                    const responseModal = new bootstrap.Modal(document.getElementById('responseModal'));
                    responseModal.show();
                });

                return false; // Prevent form submission
            }

            let jsonResponse = null;

            function makeCollapsible(json) {
                if (typeof json !== 'object' || json === null) return json;
                
                const collapse = (element) => {
                    const toggleBtn = element.previousElementSibling;
                    if (toggleBtn && toggleBtn.classList.contains('json-toggle')) {
                        toggleBtn.classList.toggle('collapsed');
                        element.style.display = element.style.display === 'none' ? 'block' : 'none';
                    }
                };

                const processElement = (element) => {
                    if (element.nodeType === Node.ELEMENT_NODE) {
                        if (element.tagName === 'SPAN' && element.classList.contains('hljs-string')) {
                            try {
                                const content = element.textContent;
                                const parsed = JSON.parse(content);
                                if (typeof parsed === 'object' && parsed !== null) {
                                    const toggle = document.createElement('span');
                                    toggle.className = 'json-toggle';
                                    toggle.addEventListener('click', () => collapse(element));
                                    element.parentNode.insertBefore(toggle, element);
                                }
                            } catch (e) {}
                        }
                        Array.from(element.children).forEach(processElement);
                    }
                };

                return processElement;
            }

            function toggleAllNodes() {
                const toggles = document.querySelectorAll('.json-toggle');
                const someCollapsed = Array.from(toggles).some(t => t.classList.contains('collapsed'));
                
                toggles.forEach(toggle => {
                    const content = toggle.nextElementSibling;
                    if (someCollapsed) {
                        toggle.classList.remove('collapsed');
                        content.style.display = 'block';
                    } else {
                        toggle.classList.add('collapsed');
                        content.style.display = 'none';
                    }
                });
            }

            function copyResponse() {
                if (jsonResponse) {
                    navigator.clipboard.writeText(JSON.stringify(jsonResponse, null, 2))
                        .then(() => {
                            const copyBtn = document.querySelector('[onclick="copyResponse()"]');
                            const originalHtml = copyBtn.innerHTML;
                            copyBtn.innerHTML = '<i class="bi bi-check"></i> Copied!';
                            setTimeout(() => {
                                copyBtn.innerHTML = originalHtml;
                            }, 2000);
                        });
                }
            }

            function showResponse(response) {
                jsonResponse = response;
                const formatted = JSON.stringify(response, null, 2);
                const responseContent = document.getElementById('responseContent');
                responseContent.textContent = formatted;
                hljs.highlightElement(responseContent);
                makeCollapsible(response)(responseContent);
                
                const modal = new bootstrap.Modal(document.getElementById('responseModal'));
                modal.show();
            }
        });
    </script>

    @push('scripts')
    <!-- Highlight.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css">
    <!-- Highlight.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/json.min.js"></script>

    <style>
        .json-container {
            position: relative;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .json-container pre {
            margin: 0;
            white-space: pre-wrap;
        }

        .collapsible:hover {
            cursor: pointer;
            text-decoration: underline;
        }

        .collapsed::after {
            content: '...';
            color: #999;
        }

        .json-toggle {
            cursor: pointer;
            user-select: none;
        }

        .json-toggle::before {
            content: '▼';
            display: inline-block;
            margin-right: 5px;
            transition: transform 0.1s;
        }

        .json-toggle.collapsed::before {
            transform: rotate(-90deg);
        }
    </style>
    @endpush
@endsection
