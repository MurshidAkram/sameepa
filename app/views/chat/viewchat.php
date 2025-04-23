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
    <style>
        
    </style>
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
                <div class="chat-header">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="back-button">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="name-card">
                        <div class="name-image">
                            <img src="<?php echo URLROOT; ?>/chat/image/<?php echo is_object($data['otherUser']) ? $data['otherUser']->id : $data['otherUser']['id']; ?>" alt="Chat with <?php echo htmlspecialchars(is_object($data['otherUser']) ? $data['otherUser']->name : $data['otherUser']['name']); ?>">
                        </div>
                        <h3 class="title"><?php echo htmlspecialchars(is_object($data['otherUser']) ? $data['otherUser']->name : $data['otherUser']['name']); ?></h3>
                    </div>
                </div>

                <div class="chat-messages" id="chat-messages">
    <?php foreach ($data['messages'] as $message): ?>
        <?php
            $isSender = ($message->sender_id == $_SESSION['user_id']);
            $rowClass = $isSender ? 'sent' : 'received';
        ?>
        <div class="message-row <?php echo $rowClass; ?>" data-message-id="<?php echo $message->id; ?>">
            <div class="message-bubble">
                <div class="message-content"><?php echo htmlspecialchars($message->message); ?></div>
                <div class="message-meta">
                    <?php if ($message->is_edited): ?>
                        <span class="message-edited">edited</span>
                    <?php endif; ?>
                    <span class="message-time"><?php echo date('H:i', strtotime($message->sent_at)); ?></span>
                </div>
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
</div>
                    
                <form class="chat-form" action="<?php echo URLROOT; ?>/chat/sendMessage" method="POST">
                    <input type="hidden" name="chat_id" value="<?php echo is_object($data['chat']) ? $data['chat']->id : $data['chat']['id']; ?>">
                    <input type="hidden" name="recipient_id" value="<?php echo is_object($data['otherUser']) ? $data['otherUser']->id : $data['otherUser']['id']; ?>">
                    <div class="chat-input-container">
                        <input type="text" name="message" placeholder="Type a message..." required class="chat-input">
                    </div>
                    <button type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
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

                    // Create save button
                    const saveBtn = document.createElement('button');
                    saveBtn.textContent = 'Save';
                    saveBtn.className = 'save-edit-btn';

                    // Create cancel button
                    const cancelBtn = document.createElement('button');
                    cancelBtn.textContent = 'Cancel';
                    cancelBtn.className = 'cancel-edit-btn';

                    // Replace message content with input and save button
                    messageContent.innerHTML = '';
                    messageContent.appendChild(input);
                    messageContent.appendChild(saveBtn);
                    messageContent.appendChild(cancelBtn)

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
                                const messageMeta = messageRow.querySelector('.message-meta');
            if (messageMeta) {
                // Check if "edited" span already exists to avoid duplicates
                if (!messageMeta.querySelector('.message-edited')) {
                    const editedSpan = document.createElement('span');
                    editedSpan.className = 'message-edited';
                    editedSpan.textContent = 'edited';
                    // Insert before the timestamp
                    const timeSpan = messageMeta.querySelector('.message-time');
                    messageMeta.insertBefore(editedSpan, timeSpan);
                    // Add a space for readability
                    messageMeta.insertBefore(document.createTextNode(' '), timeSpan);
                }
            }

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
                    // Add event listener to cancel button
cancelBtn.addEventListener('click', function() {
    messageContent.innerHTML = currentText;
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

                        fetch(this.action, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            const contentType = response.headers.get('content-type');

                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.statusText);
                            }

                            // Check if the response is JSON
                            if (contentType && contentType.includes('application/json')) {
    return response.json();
} else {
    return response.text().then(text => {
        console.error('Unexpected response (not JSON):', text);
        throw new Error('Unexpected response from server.');
    });
}

                        })
                        .then(data => {
                            if (data.success) {
                                // Add fade out animation
                                messageRow.style.transition = 'opacity 0.3s, transform 0.3s';
                                messageRow.style.opacity = '0';
                                messageRow.style.transform = 'translateX(20px)';
                                
                                setTimeout(() => {
                                    messageRow.remove();
                                }, 300);
                            } else {
                                alert(data.message || 'Failed to delete message');
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