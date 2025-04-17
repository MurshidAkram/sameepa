<!-- app/views/chat/viewChat.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/chats.css">
    <title>Chat with <?php echo htmlspecialchars(is_object($data['otherUser']) ? $data['otherUser']->name : $data['otherUser']['name']); ?> | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        switch ($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>

        <main class="chat-main">
            <div class="groups-content">
                <a href="<?php echo URLROOT; ?>/chat/index" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <div class="chat-messages" id="chat-messages">
                    <div class="name-card">
                        <div class="name-image">
                            <img src="<?php echo URLROOT; ?>/img/default-user.png" alt="Chat with <?php echo htmlspecialchars(is_object($data['otherUser']) ? $data['otherUser']->name : $data['otherUser']['name']); ?>">
                        </div>
                        <h3 class="title"><?php echo htmlspecialchars(is_object($data['otherUser']) ? $data['otherUser']->name : $data['otherUser']['name']); ?></h3>
                    </div>

                    <?php foreach ($data['messages'] as $message): ?>
                        <?php
                            $isSender = ($message->sender_id == $_SESSION['user_id']);
                            $rowClass = $isSender ? 'sent' : 'received';
                        ?>
                        <div class="message-row <?php echo $rowClass; ?>" data-message-id="<?php echo $message->id; ?>">
                            <div class="message-bubble">
                                <div class="message-content"><?php echo htmlspecialchars($message->message); ?></div>
                                <span class="message-time"><?php echo date('H:i', strtotime($message->sent_at)); ?></span>
                            </div>
                            <?php if ($isSender): ?>
                                <div class="message-actions">
                                    <button class="icon-btn edit-btn" title="Edit"><i class="fas fa-edit"></i></button>
                                    <form class="delete-form" action="<?php echo URLROOT; ?>/chat/deleteMessage" method="POST" style="display:inline;">
                                        <input type="hidden" name="message_id" value="<?php echo $message->id; ?>">
                                        <input type="hidden" name="chat_id" value="<?php echo $message->chat_id; ?>">
                                        <input type="hidden" name="recipient_id" value="<?php echo is_object($data['otherUser']) ? $data['otherUser']->id : $data['otherUser']['id']; ?>">
                                        <button type="submit" class="icon-btn delete-btn" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <style>
                        .chat-messages {
                            display: flex;
                            flex-direction: column;
                            gap: 16px;
                            padding: 20px;
                        }

                        .message-row {
                            display: flex;
                            align-items: flex-end;
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 2px;
                        }

                        .sent {
                            justify-content: flex-end;
                        }

                        .received {
                            justify-content: flex-start;
                        }

                        .message-bubble {
                            max-width: 60%;
                            padding: 12px 18px;
                            border-radius: 18px;
                            word-break: break-word;
                            background: #800080;
                            color: #fff;
                            border-bottom-right-radius: 6px;
                            text-align: left;
                            min-width: 60px;
                            margin-left: auto;
                        }

                        .received .message-bubble {
                            background: #f1f0f0;
                            color: #222;
                            border-bottom-left-radius: 6px;
                            border-bottom-right-radius: 18px;
                            margin-left: 0;
                            margin-right: auto;
                        }

                        .message-content {
                            margin-bottom: 4px;
                        }

                        .message-time {
                            font-size: 0.8em;
                            color: rgba(255,255,255,0.7);
                            display: block;
                            text-align: right;
                        }

                        .received .message-time {
                            color: #888;
                        }

                        .message-actions {
                            display: flex;
                            flex-direction: column;
                            gap: 6px;
                            align-items: center;
                            min-width: 28px;
                            margin: 0 0 4px 8px;
                        }

                        .icon-btn {
                            background: #fff;
                            border: none;
                            border-radius: 50%;
                            width: 22px;
                            height: 22px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: #888;
                            font-size: 13px;
                            cursor: pointer;
                            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
                            transition: background 0.2s, color 0.2s;
                            padding: 0;
                        }

                        .icon-btn:hover {
                            background: #f3e9ff;
                            color: #800080;
                        }

                        .edit-btn i { color: #6a5acd; }
                        .delete-btn i { color: #e74c3c; }

                        .chat-input-container {
                            display: flex;
                            align-items: center;
                            width: 100%;
                        }

                        .chat-input {
                            flex: 1;
                            min-width: 0;
                            width: 100%;
                            padding: 14px 18px;
                            border: 1.5px solid #e2e8f0;
                            border-radius: 24px;
                            font-size: 1em;
                            outline: none;
                            background: #f9f9f9;
                            margin-right: 10px;
                            transition: border-color 0.2s;
                        }

                        .dashboard-container,
                        .groups-content,
                        .chat-messages {
                            max-width: 100vw;
                            overflow-x: hidden;
                        }
                    </style>

                    <form class="chat-form" action="<?php echo URLROOT; ?>/chat/sendMessage" method="POST">
                        <input type="hidden" name="chat_id" value="<?php echo is_object($data['chat']) ? $data['chat']->id : $data['chat']['id']; ?>">
                        <input type="hidden" name="recipient_id" value="<?php echo is_object($data['otherUser']) ? $data['otherUser']->id : $data['otherUser']['id']; ?>">
                        <div class="chat-input-container">
                            <input type="text" name="message" placeholder="Type a message..." required class="chat-input">
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>

        <?php require APPROOT . '/views/inc/components/footer.php'; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-scroll to bottom of chat
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.scrollTop = chatMessages.scrollHeight;

                // Add event listeners for edit and delete buttons
                const editButtons = document.querySelectorAll('.edit-btn');
                const deleteForms = document.querySelectorAll('.delete-form');

                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const messageRow = this.closest('.message-row');
                        const messageId = messageRow.dataset.messageId;
                        const messageContent = messageRow.querySelector('.message-content');
                        const currentText = messageContent.textContent;

                        // Create an input for editing
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.value = currentText;
                        input.className = 'edit-message-input';
                        input.style.width = '100%';
                        input.style.padding = '8px';
                        input.style.borderRadius = '12px';
                        input.style.border = '1px solid #ddd';

                        // Create save button
                        const saveBtn = document.createElement('button');
                        saveBtn.textContent = 'Save';
                        saveBtn.className = 'save-edit-btn';
                        saveBtn.style.marginLeft = '8px';
                        saveBtn.style.padding = '5px 10px';
                        saveBtn.style.borderRadius = '12px';
                        saveBtn.style.backgroundColor = '#800080';
                        saveBtn.style.color = 'white';
                        saveBtn.style.border = 'none';
                        saveBtn.style.cursor = 'pointer';

                        // Replace message content with input and save button
                        messageContent.innerHTML = '';
                        messageContent.appendChild(input);
                        messageContent.appendChild(saveBtn);

                        // Focus on the input
                        input.focus();

                        // Add event listener to save button
                        saveBtn.addEventListener('click', function() {
                            const newMessage = input.value.trim();

                            if (!newMessage) {
                                alert('Message cannot be empty');
                                return;
                            }

                            // Send update request
                            fetch('<?php echo URLROOT; ?>/chat/updateMessage', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    messageId: messageId,
                                    newMessage: newMessage
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok: ' + response.statusText);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Update the UI
                                    messageContent.innerHTML = newMessage;
                                } else {
                                    alert(data.message || 'Failed to update message');
                                    messageContent.innerHTML = currentText;
                                }
                            })
                            .catch(error => {
                                console.error('Error updating message:', error);
                                alert('An error occurred while updating the message: ' + error.message);
                                messageContent.innerHTML = currentText;
                            });
                        });
                    });
                });

                // Handle delete forms
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        if (confirm('Are you sure you want to delete this message?')) {
                            const formData = new FormData(this);
                            const messageRow = this.closest('.message-row');
                            const messageId = formData.get('message_id');

                            console.log('Deleting message ID:', messageId); // Debug log

                            fetch(this.action, {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => {
                                console.log('Response status:', response.status); // Debug log
                                const contentType = response.headers.get('content-type');
                                console.log('Response content-type:', contentType); // Debug log

                                if (!response.ok) {
                                    throw new Error('Network response was not ok: ' + response.statusText);
                                }

                                // Check if the response is JSON
                                if (contentType && contentType.includes('application/json')) {
                                    return response.json();
                                } else {
                                    // If not JSON, get the raw text for debugging
                                    return response.text().then(text => {
                                        throw new Error('Expected JSON, but received: ' + text);
                                    });
                                }
                            })
                            .then(data => {
                                console.log('Response data:', data); // Debug log
                                if (data.success) {
                                    messageRow.remove();
                                    console.log('Message ID', messageId, 'deleted successfully');
                                } else {
                                    alert(data.message || 'Failed to delete message');
                                    console.error('Deletion failed:', data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting message:', error);
                                alert('An error occurred while deleting the message: ' + error.message);
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>