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
                                <option value="send-message">Send Message</option>
                                <option value="get-updates">Get Updates</option>
                                <option value="set-webhook">Set Webhook</option>
                                <option value="delete-webhook">Delete Webhook</option>
                                <option value="get-webhook-info">Get Webhook Info</option>
                                <option value="get-me">Get Me</option>
                                <option value="log-out">Log Out</option>
                                <option value="close">Close</option>
                                <option value="send-photo">Send Photo</option>
                                <option value="send-audio">Send Audio</option>
                                <option value="send-document">Send Document</option>
                                <option value="send-video">Send Video</option>
                                <option value="send-animation">Send Animation</option>
                                <option value="send-voice">Send Voice</option>
                                <option value="send-video-note">Send Video Note</option>
                                <option value="send-media-group">Send Media Group</option>
                                <option value="send-location">Send Location</option>
                                <option value="edit-message-live-location">Edit Message Live Location</option>
                                <option value="stop-message-live-location">Stop Message Live Location</option>
                                <option value="send-venue">Send Venue</option>
                                <option value="send-contact">Send Contact</option>
                                <option value="send-poll">Send Poll</option>
                                <option value="send-dice">Send Dice</option>
                                <option value="send-chat-action">Send Chat Action</option>
                                <option value="get-user-profile-photos">Get User Profile Photos</option>
                                <option value="get-file">Get File</option>
                                <option value="ban-chat-member">Ban Chat Member</option>
                                <option value="unban-chat-member">Unban Chat Member</option>
                                <option value="restrict-chat-member">Restrict Chat Member</option>
                                <option value="promote-chat-member">Promote Chat Member</option>
                                <option value="set-chat-administrator-custom-title">Set Chat Administrator Custom Title</option>
                                <option value="ban-chat-sender-chat">Ban Chat Sender Chat</option>
                                <option value="unban-chat-sender-chat">Unban Chat Sender Chat</option>
                                <option value="set-chat-permissions">Set Chat Permissions</option>
                                <option value="export-chat-invite-link">Export Chat Invite Link</option>
                                <option value="create-chat-invite-link">Create Chat Invite Link</option>
                                <option value="edit-chat-invite-link">Edit Chat Invite Link</option>
                                <option value="revoke-chat-invite-link">Revoke Chat Invite Link</option>
                                <option value="approve-chat-join-request">Approve Chat Join Request</option>
                                <option value="decline-chat-join-request">Decline Chat Join Request</option>
                                <option value="set-chat-photo">Set Chat Photo</option>
                                <option value="delete-chat-photo">Delete Chat Photo</option>
                                <option value="set-chat-title">Set Chat Title</option>
                                <option value="set-chat-description">Set Chat Description</option>
                                <option value="pin-chat-message">Pin Chat Message</option>
                                <option value="unpin-chat-message">Unpin Chat Message</option>
                                <option value="unpin-all-chat-messages">Unpin All Chat Messages</option>
                                <option value="leave-chat">Leave Chat</option>
                                <option value="get-chat">Get Chat</option>
                                <option value="get-chat-administrators">Get Chat Administrators</option>
                                <option value="get-chat-member-count">Get Chat Member Count</option>
                                <option value="get-chat-member">Get Chat Member</option>
                                <option value="set-chat-sticker-set">Set Chat Sticker Set</option>
                                <option value="delete-chat-sticker-set">Delete Chat Sticker Set</option>
                                <option value="get-forum-topic-icon-stickers">Get Forum Topic Icon Stickers</option>
                                <option value="create-forum-topic">Create Forum Topic</option>
                                <option value="edit-forum-topic">Edit Forum Topic</option>
                                <option value="close-forum-topic">Close Forum Topic</option>
                                <option value="reopen-forum-topic">Reopen Forum Topic</option>
                                <option value="delete-forum-topic">Delete Forum Topic</option>
                                <option value="unpin-all-forum-topic-messages">Unpin All Forum Topic Messages</option>
                                <option value="edit-general-forum-topic">Edit General Forum Topic</option>
                                <option value="close-general-forum-topic">Close General Forum Topic</option>
                                <option value="reopen-general-forum-topic">Reopen General Forum Topic</option>
                                <option value="hide-general-forum-topic">Hide General Forum Topic</option>
                                <option value="unhide-general-forum-topic">Unhide General Forum Topic</option>
                                <option value="answer-callback-query">Answer Callback Query</option>
                                <option value="set-my-commands">Set My Commands</option>
                                <option value="delete-my-commands">Delete My Commands</option>
                                <option value="get-my-commands">Get My Commands</option>
                                <option value="set-chat-menu-button">Set Chat Menu Button</option>
                                <option value="get-chat-menu-button">Get Chat Menu Button</option>
                                <option value="set-my-default-administrator-rights">Set My Default Administrator Rights</option>
                                <option value="get-my-default-administrator-rights">Get My Default Administrator Rights</option>
                                <option value="edit-message-text">Edit Message Text</option>
                                <option value="edit-message-caption">Edit Message Caption</option>
                                <option value="edit-message-media">Edit Message Media</option>
                                <option value="edit-message-reply-markup">Edit Message Reply Markup</option>
                                <option value="stop-poll">Stop Poll</option>
                                <option value="delete-message">Delete Message</option>
                                <option value="send-sticker">Send Sticker</option>
                                <option value="get-sticker-set">Get Sticker Set</option>
                                <option value="get-custom-emoji-stickers">Get Custom Emoji Stickers</option>
                                <option value="upload-sticker-file">Upload Sticker File</option>
                                <option value="create-new-sticker-set">Create New Sticker Set</option>
                                <option value="add-sticker-to-set">Add Sticker To Set</option>
                                <option value="set-sticker-position-in-set">Set Sticker Position In Set</option>
                                <option value="delete-sticker-from-set">Delete Sticker From Set</option>
                                <option value="set-sticker-set-thumb">Set Sticker Set Thumb</option>
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
'send-photo': `
    <div class="mb-3">
        <label for="chat_id" class="form-label">Chat ID</label>
        <input type="text" class="form-control" id="chat_id" name="chat_id" required>
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Photo URL</label>
        <input type="text" class="form-control" id="photo" name="photo" required>
    </div>
    <div class="mb-3">
        <label for="caption" class="form-label">Caption (optional)</label>
        <textarea class="form-control" id="caption" name="caption" rows="2"></textarea>
    </div>
`,
'send-document': `
    <div class="mb-3">
        <label for="chat_id" class="form-label">Chat ID</label>
        <input type="text" class="form-control" id="chat_id" name="chat_id" required>
    </div>
    <div class="mb-3">
        <label for="document" class="form-label">Document URL</label>
        <input type="text" class="form-control" id="document" name="document" required>
    </div>
    <div class="mb-3">
        <label for="caption" class="form-label">Caption (optional)</label>
        <textarea class="form-control" id="caption" name="caption" rows="2"></textarea>
    </div>
`,
'get-me': '',
'get-chat': `
    <div class="mb-3">
        <label for="chat_id" class="form-label">Chat ID</label>
        <input type="text" class="form-control" id="chat_id" name="chat_id" required>
    </div>
`,
'leave-chat': `
    <div class="mb-3">
        <label for="chat_id" class="form-label">Chat ID</label>
        <input type="text" class="form-control" id="chat_id" name="chat_id" required>
    </div>
`,
'send-audio': `
    <div class="mb-3">
        <label for="chat_id" class="form-label">Chat ID</label>
        <input type="text" class="form-control" id="chat_id" name="chat_id" required>
    </div>
    <div class="mb-3">
        <label for="audio" class="form-label">Audio URL</label>
        <input type="text" class="form-control" id="audio" name="audio" required>
    </div>
    <div class="mb-3">
        <label for="caption" class="form-label">Caption (optional)</label>
        <textarea class="form-control" id="caption" name="caption" rows="2"></textarea>
    </div>
`,
'send-video': `
    <div class="mb-3">
        <label for="chat_id" class="form-label">Chat ID</label>
        <input type="text" class="form-control" id="chat_id" name="chat_id" required>
    </div>
    <div class="mb-3">
        <label for="video" class="form-label">Video URL</label>
        <input type="text" class="form-control" id="video" name="video" required>
    </div>
    <div class="mb-3">
        <label for="caption" class="form-label">Caption (optional)</label>
        <textarea class="form-control" id="caption" name="caption" rows="2"></textarea>
    </div>
`

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
