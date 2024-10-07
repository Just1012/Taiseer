@extends('dashboard.layouts.master')
@section('title', __('backend.inbox'))
@section('content')
    <div class="container">
        <style>
            /* Message aligned to the left */
            .message-left {
                text-align: left;
                margin-right: auto;
                /* Align to the left */
            }

            /* Message aligned to the right */
            .message-right {
                text-align: right;
                margin-left: auto;
                /* Align to the right */
            }

            /* Message box styling */
            .message-box {
                display: inline-block;
                padding: 10px;
                border-radius: 10px;
                max-width: 60%;
                word-wrap: break-word;
            }
        </style>
        <div class="row" style="margin-top: 20px;">

            <!-- Sidebar for Chat Filters -->
            <div class="col-md-3">
                <div class="list-group">
                    <!-- All Chats -->
                    <a href="javascript:void(0);" id="all-messages" class="list-group-item list-group-item-action">
                        All Chats
                        <small class="badge badge-secondary">({{ $allChatsCount }})</small>
                    </a>

                    <!-- Unread Chats -->
                    <a href="javascript:void(0);" id="unread-messages" class="list-group-item list-group-item-action">
                        Unread Chats
                        <small class="badge badge-danger">({{ $unreadChatsCount }})</small>
                    </a>

                    <!-- Read Chats -->
                    <a href="javascript:void(0);" id="read-messages" class="list-group-item list-group-item-action">
                        Read Chats
                        <small class="badge badge-success">({{ $readChatsCount }})</small>
                    </a>
                </div>
            </div>
            <!-- Sidebar to List Chats -->
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" id="chat-search" style="width: 85%" name="q"
                        class="form-control no-border no-bg" placeholder="Search all Chats">

                    <button type="submit" style="padding-top: 10px;"
                        class="input-group-addon no-border no-shadow no-bg pull-left">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div class="list-group" id="chat-list">
                    <!-- Chats will be loaded dynamically here -->
                </div>
            </div>

            <!-- Chat Box -->
            <div class="col-md-6">
                <div class="card-inner">
                    <div class="card-header-inner">
                        <h4 id="chat-title">Select a Chat</h4>
                    </div>
                    <div class="card-body chat-box" id="chat-box" style="height: 400px; overflow-y: scroll;">
                        <ul id="chat-messages" class="list-unstyled" style="padding: 10px;">
                            <!-- Messages will be loaded here dynamically -->
                        </ul>
                    </div>

                    <div class="card-footer-inner">
                        <!-- Form to Send New Message -->
                        <form id="chat-form" style="display:none;">
                            @csrf
                            <div class="input-group">
                                <input type="text" id="message_text" name="message_text" class="form-control"
                                    placeholder="Type your message...">
                                <input type="hidden" id="active_chat_id" name="chat_id">
                                <div class="input-group-append">
                                    <button class="btn btn-primary m-t" type="submit"><i class="material-icons">
                                            &#xe31b;</i>Send</button>

                                </div>
                            </div>
                            <small class="text-danger" id="error-message" style="display:none;">Please enter a
                                message.</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Function to load chats into the chat list
            function loadChats(url) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        // Clear the existing chat list
                        $('#chat-list').empty();

                        // Iterate over the chats and append them to the chat list
                        response.forEach(function(chat) {
                            $('#chat-list').append(`
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action chat-item"
                            data-chat-id="${chat.id}">
                            ${chat.name}
                            <small class="badge badge-secondary text-danger">(${chat.unread_messages_count})</small>
                        </a>
                    `);
                        });

                        // Attach event listener to fetch messages when a chat is clicked
                        $('.chat-item').on('click', function() {
                            var chatId = $(this).data('chat-id');
                            $('#active_chat_id').val(
                                chatId); // Set the active chat ID for sending new messages

                            fetchMessages(chatId); // Fetch messages for the clicked chat
                        });
                    },
                    error: function() {
                        alert('Error loading chats');
                    }
                });
            }

            // Function to fetch messages for a given chat ID
            function fetchMessages(chatId) {
                $.ajax({
                    url: 'admin/chats/messages/' + chatId, // Adjust the URL if necessary
                    method: 'GET',
                    success: function(response) {
                        if (response.chat && response.messages) {
                            // Update chat title
                            $('#chat-title').text(response.chat.name || 'N/A');

                            // Clear current messages
                            $('#chat-messages').empty();

                            // Append new messages to chat
                            response.messages.forEach(function(message) {
                                var messageText = message.message_text || 'N/A';
                                var senderName = message.sender_name || 'N/A';
                                var isUser = message.is_user;
                                var createdAt = message.created_at ||
                                    'N/A'; // diffForHumans() value
                                var hoverTime = message.hover_time ||
                                    'N/A'; // Detailed date-time value

                                var messageAlignment = isUser !== null ? 'message-left' :
                                    'message-right';
                                var buttonClass = isUser !== null ? 'btn-secondary' :
                                    'btn-primary';

                                $('#chat-messages').append(`
                            <li class="mb-2 ${messageAlignment}">
                                <div class="message-box">
                                    <strong class="btn ${buttonClass}">${messageText}</strong><br>
                                    <small>${senderName}</small>
                                    <span class="text-muted" style="font-size: 0.8em;" title="${hoverTime}">
                                        ${createdAt}
                                    </span>
                                </div>
                            </li>
                        `);
                            });

                            // Scroll to the bottom of the chat box
                            $('#chat-box').animate({
                                scrollTop: $('#chat-box').prop('scrollHeight')
                            }, 500);

                            // Show the chat form for sending new messages
                            $('#chat-form').show();
                        } else {
                            alert('Error: Missing chat or messages in the response.');
                        }
                    },
                    error: function() {
                        alert('Error loading chat messages');
                    }
                });
            }

            // Click event for "All Messages"
            $(document).on('click', '#all-messages', function() {
                loadChats('{{ route('chats.all') }}'); // Load all chats
            });

            // Click event for "Unread Messages"
            $(document).on('click', '#unread-messages', function() {
                loadChats('{{ route('chats.unread') }}'); // Load unread chats
            });

            // Click event for "Read Messages"
            $(document).on('click', '#read-messages', function() {
                loadChats('{{ route('chats.read') }}'); // Load read chats
            });

            // Handle form submission for sending a message
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();

                let messageText = $('#message_text').val();
                let chatId = $('#active_chat_id').val();

                if (!messageText.trim()) {
                    $('#error-message').show(); // Show error if message is empty
                    return;
                }

                $('#error-message').hide(); // Hide error if valid message

                $.ajax({
                    url: '{{ route('storeMessage') }}', // Assuming storeMessage route exists
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message_text: messageText,
                        chat_id: chatId
                    },
                    success: function(response) {
                        if (response.data) {
                            var messageText = response.data.message_text || 'N/A';
                            var senderName =
                                '{{ auth()->user()->name }}'; // Display the current user's name (sender)
                            var createdAt = 'Just now'; // Since it's just sent
                            var hoverTime = new Date()
                                .toLocaleString(); // Current time for hover
                            var messageAlignment =
                                'message-right'; // User's message is aligned to the right
                            var buttonClass =
                                'btn-primary'; // Use primary style for user's message

                            // Append new message with styling
                            $('#chat-messages').append(`
                        <li class="mb-2 ${messageAlignment}">
                            <div class="message-box">
                                <strong class="btn ${buttonClass}">${messageText}</strong><br>
                                <small>${senderName}</small> <!-- Sender name included here -->
                                <span class="text-muted" style="font-size: 0.8em;" title="${hoverTime}">
                                    ${createdAt}
                                </span>
                            </div>
                        </li>
                    `);

                            $('#message_text').val(''); // Clear the input field

                            // Scroll to the bottom of the chat box
                            $('#chat-box').animate({
                                scrollTop: $('#chat-box').prop('scrollHeight')
                            }, 500);
                        } else {
                            alert('Error sending message.');
                        }
                    },
                    error: function() {
                        alert('Error sending message');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Real-time search when typing in the search input
            $('#chat-search').on('keyup', function() {
                let query = $(this).val();

                // Send AJAX request only if the search query is not empty
                if (query.length > 0) {
                    $.ajax({
                        url: '{{ route('searchChats') }}', // Adjust the route if necessary
                        method: 'GET',
                        data: {
                            q: query
                        },
                        success: function(response) {
                            $('#chat-list').empty(); // Clear the chat list

                            // Append the search results to the chat list
                            response.chats.forEach(function(chat) {
                                $('#chat-list').append(`
                                    <a href="javascript:void(0);" class="list-group-item list-group-item-action chat-item"
                                        data-chat-id="${chat.id}">
                                        ${chat.name}
                                        <small class="badge badge-secondary text-danger">(${chat.unread_messages_count})</small>
                                    </a>
                                `);
                            });

                            // Reattach the click event listener to each chat item
                            attachChatClickEvent();
                        },
                        error: function() {
                            alert('Error fetching chats');
                        }
                    });
                } else {
                    // Clear the chat list if the search query is empty
                    $('#chat-list').empty();
                }
            });

            // Attach click event to dynamically loaded chat items
            function attachChatClickEvent() {
                $('.chat-item').on('click', function() {
                    var chatId = $(this).data('chat-id');
                    $('#active_chat_id').val(chatId);

                    // Fetch chat messages via AJAX or handle chat click logic here
                    fetchMessages(chatId);
                });
            }

            // Function to fetch messages for a given chat ID
            function fetchMessages(chatId) {
                $.ajax({
                    url: 'admin/chats/messages/' + chatId, // Adjust the URL if necessary
                    method: 'GET',
                    success: function(response) {
                        if (response.chat && response.messages) {
                            // Update chat title
                            $('#chat-title').text(response.chat.name || 'N/A');

                            // Clear current messages
                            $('#chat-messages').empty();

                            // Append new messages to chat
                            response.messages.forEach(function(message) {
                                var messageText = message.message_text || 'N/A';
                                var senderName = message.sender_name || 'N/A';
                                var isUser = message.is_user;
                                var createdAt = message.created_at ||
                                    'N/A'; // diffForHumans() value
                                var hoverTime = message.hover_time ||
                                    'N/A'; // Detailed date-time value

                                var messageAlignment = isUser !== null ? 'message-left' :
                                    'message-right';
                                var buttonClass = isUser !== null ? 'btn-secondary' :
                                    'btn-primary';

                                $('#chat-messages').append(`
                            <li class="mb-2 ${messageAlignment}">
                                <div class="message-box">
                                    <strong class="btn ${buttonClass}">${messageText}</strong><br>
                                    <small>${senderName}</small>
                                    <span class="text-muted" style="font-size: 0.8em;" title="${hoverTime}">
                                        ${createdAt}
                                    </span>
                                </div>
                            </li>
                        `);
                            });

                            // Scroll to the bottom of the chat box
                            $('#chat-box').animate({
                                scrollTop: $('#chat-box').prop('scrollHeight')
                            }, 500);

                            // Show the chat form for sending new messages
                            $('#chat-form').show();
                        } else {
                            alert('Error: Missing chat or messages in the response.');
                        }
                    },
                    error: function() {
                        alert('Error loading chat messages');
                    }
                });
            }
        });
    </script>
@endpush
