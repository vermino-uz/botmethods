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
                    <form id="api-method-form">
                        <div class="mb-3">
                            <label for="method-search" class="form-label">Search Methods</label>
                            <input type="text" class="form-control" id="method-search" placeholder="Search for a method...">
                        </div>
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
        const apiMethods = {
    getUpdates: [
        { offset: 'int' },
        { limit: 'int' },
        { timeout: 'int' },
        { allowed_updates: 'array' }
    ],
    getWebhookInfo: [
    ],
    setWebhook: [
        { url: 'url' }
    ],
    deleteWebhook: [
        { drop_pending_updates: 'boolean' }
    ],
    getMe: [
    ],
    sendMessage: [
        { chat_id: 'int' },
        { text: 'string' },
        { parse_mode: 'string' },
        { reply_to_message_id: 'int' }
    ],
    forwardMessage: [
        { chat_id: 'int' },
        { from_chat_id: 'int' },
        { message_id: 'int' }
    ],
    sendPhoto: [
        { chat_id: 'int' },
        { photo: 'url' },
        { caption: 'string' },
        { parse_mode: 'string' }
    ],
    sendAudio: [
        { chat_id: 'int' },
        { audio: 'url' },
        { caption: 'string' },
        { duration: 'int' }
    ],
    sendDocument: [
        { chat_id: 'int' },
        { document: 'url' },
        { caption: 'string' }
    ],
    sendVideo: [
        { chat_id: 'int' },
        { video: 'url' },
        { caption: 'string' },
        { supports_streaming: 'boolean' }
    ],
    sendAnimation: [
        { chat_id: 'int' },
        { animation: 'url' },
        { caption: 'string' }
    ],
    sendVoice: [
        { chat_id: 'int' },
        { voice: 'url' },
        { caption: 'string' },
        { duration: 'int' }
    ],
    sendLocation: [
        { chat_id: 'int' },
        { latitude: 'float' },
        { longitude: 'float' }
    ],
    editMessageLiveLocation: [
        { chat_id: 'int' },
        { message_id: 'int' },
        { latitude: 'float' },
        { longitude: 'float' }
    ],
    stopMessageLiveLocation: [
        { chat_id: 'int' },
        { message_id: 'int' }
    ],
    sendVenue: [
        { chat_id: 'int' },
        { latitude: 'float' },
        { longitude: 'float' },
        { title: 'string' },
        { address: 'string' }
    ],
    sendContact: [
        { chat_id: 'int' },
        { phone_number: 'string' },
        { first_name: 'string' }
    ],
    sendPoll: [
        { chat_id: 'int' },
        { question: 'string' },
        { options: 'array' },
        { is_anonymous: 'boolean' }
    ],
    sendDice: [
        { chat_id: 'int' }
    ],
    getUserProfilePhotos: [
        { user_id: 'int' },
        { offset: 'int' },
        { limit: 'int' }
    ],
    getFile: [
        { file_id: 'string' }
    ],
    kickChatMember: [
        { chat_id: 'int' },
        { user_id: 'int' }
    ],
    unbanChatMember: [
        { chat_id: 'int' },
        { user_id: 'int' }
    ],
    restrictChatMember: [
        { chat_id: 'int' },
        { user_id: 'int' },
        { permissions: 'object' }
    ],
    promoteChatMember: [
        { chat_id: 'int' },
        { user_id: 'int' },
        { can_change_info: 'boolean' }
    ],
    setChatPermissions: [
        { chat_id: 'int' },
        { permissions: 'object' }
    ],
    getChat: [
        { chat_id: 'int' }
    ],
    getChatAdministrators: [
        { chat_id: 'int' }
    ],
    getChatMemberCount: [
        { chat_id: 'int' }
    ],
    getChatMember: [
        { chat_id: 'int' },
        { user_id: 'int' }
    ],
    answerCallbackQuery: [
        { callback_query_id: 'string' },
        { text: 'string' },
        { show_alert: 'boolean' }
    ],
    editMessageText: [
        { chat_id: 'int' },
        { message_id: 'int' },
        { text: 'string' },
        { parse_mode: 'string' }
    ],
    deleteMessage: [
        { chat_id: 'int' },
        { message_id: 'int' }
    ]
};


        document.addEventListener('DOMContentLoaded', function() {
            const methodSearchInput = document.getElementById('method-search');
            const apiMethodSelect = document.getElementById('api-method');
            const methodFieldsContainer = document.getElementById('method-fields');

            // Populate dropdown initially
            for (const method in apiMethods) {
                const option = document.createElement('option');
                option.value = method;
                option.textContent = method.replace(/([a-z])([A-Z])/g, '$1 $2'); // Converts camelCase to spaced words
                apiMethodSelect.appendChild(option);
            }

            methodSearchInput.addEventListener('input', function() {
                const searchTerm = methodSearchInput.value.toLowerCase();
                let matchFound = false;

                for (let i = 0; i < apiMethodSelect.options.length; i++) {
                    const option = apiMethodSelect.options[i];
                    const text = option.textContent.toLowerCase();

                    if (text.includes(searchTerm)) {
                        option.style.display = '';
                        if (!matchFound) {
                            apiMethodSelect.selectedIndex = i;
                            matchFound = true;
                        }
                    } else {
                        option.style.display = 'none';
                    }
                }

                // Trigger change event to update fields
                if (matchFound) {
                    apiMethodSelect.dispatchEvent(new Event('change'));
                }
            });

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
            const botToken = '{{ $bot->token }}';
            let url = `https://api.telegram.org/bot${botToken}/${method}?`;

            for (let [key, value] of formData.entries()) {
                if (key !== 'api-method' && value) {
                    url += `${key}=${encodeURIComponent(value)}&`;
                }
            }

            url = url.slice(0, -1); // Remove trailing '&'

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    showResponse(data);
                })
                .catch(error => {
                    showResponse({ error: error.message });
                });
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
