<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Group Chat - Book Club | <?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        <main class="group-chat-main">
        <div class="group-chat-container">
    <div class="group-chat-header">
        <div class="group-chat-info">
            <h2><?php echo $data['group']['group_name']; ?></h2>
            <span><?php echo $data['member_count']; ?> members</span>
        </div>
        <a href="<?php echo URLROOT; ?>/groups/viewgroup/<?php echo $data['group']['group_id']; ?>" class="back-to-group">
            <i class="fas fa-arrow-left"></i> Back to Group
        </a>
    </div>
    
    <div class="group-chat-messages" id="chatMessages">
    <?php foreach($data['messages'] as $message): ?>
        <div class="chat-message <?php echo ($message->user_id == $_SESSION['user_id']) ? 'sent' : 'received'; ?>" data-id="<?php echo $message->id; ?>">
            <?php if($message->user_id != $_SESSION['user_id']): ?>
                <?php if(!empty($message->profile_picture)): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($message->profile_picture); ?>" alt="User" class="message-avatar">
                <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="User" class="message-avatar">
                <?php endif; ?>
            <?php endif; ?>
            <div class="message-content">
                <div class="message-info">
                    <?php if($message->user_id != $_SESSION['user_id']): ?>
                        <span class="message-sender"><?php echo $message->sender_name; ?></span> &nbsp;
                    <?php endif; ?>
                    <span class="message-time"><?php echo date('h:i A', strtotime($message->sent_at)); ?></span>
                </div>
                <p><?php echo $message->message; ?></p>
                <?php if($message->user_id != $_SESSION['user_id']): ?>
                    <button class="report-message-btn" onclick="showReportForm(<?php echo $message->id; ?>)">
                        <i class="fas fa-flag"></i>
                    </button>
                <?php endif; ?>
                <?php if($message->user_id == $_SESSION['user_id']): ?>
                    <button class="delete-message-btn" onclick="deleteMessage(<?php echo $message->id; ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <div class="group-chat-input">
        <input type="text" id="messageInput" placeholder="Type your message...">
        <button class="send-message" id="sendMessage">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
        </main>
    </div>

    <div id="reportFormContainer" class="report-form-container" style="display: none;">
        <form id="reportForm" action="<?php echo URLROOT; ?>/groups/report_message" method="POST">
            <input type="hidden" name="group_id" id="reportGroupId">
            <input type="hidden" name="message_id" id="reportMessageId">
            <textarea name="reason" id="reportReason" placeholder="Reason for reporting" required></textarea>
            <button type="submit" class="btn-submit">Submit Report</button>
            <button type="button" onclick="hideReportForm()" class="btn-cancel">Cancel</button>
        </form>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
document.getElementById('sendMessage').addEventListener('click', sendMessage);
document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (message) {
        console.log('Sending message:', message);
        fetch('<?php echo URLROOT; ?>/groups/sendMessage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `group_id=<?php echo $data['group']['group_id']; ?>&message=${encodeURIComponent(message)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                const chatMessages = document.getElementById('chatMessages');
                const messageHTML = `
                    <div class="chat-message sent" data-id="${data.message_id}">
                        <div class="message-content">
                            <div class="message-info">
                                <span class="message-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                            </div>
                            <p>${data.message}</p>
                            <button class="delete-message-btn" onclick="deleteMessage(${data.message_id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                chatMessages.insertAdjacentHTML('beforeend', messageHTML);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                messageInput.value = '';
            } else {
                console.error('Failed to send message:', data);
                alert(data.message || 'Failed to send message');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('An error occurred while sending the message.');
        });
    }
}

function showReportForm(messageId) {
    document.getElementById('reportGroupId').value = <?php echo $data['group']['group_id']; ?>;
    document.getElementById('reportMessageId').value = messageId;
    document.getElementById('reportFormContainer').style.display = 'block';
}

function hideReportForm() {
    document.getElementById('reportFormContainer').style.display = 'none';
}

function deleteMessage(messageId) {
    if (messageId === 0) {
        alert('Cannot delete a message that has not been saved yet. Please refresh the page.');
        return;
    }
    
    if (confirm('Are you sure you want to delete this message?')) {
        fetch(`<?php echo URLROOT; ?>/groups/deleteOwnMessage/${messageId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `messageId=${messageId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const messageElement = document.querySelector(`.chat-message[data-id="${data.messageId}"]`);
                if (messageElement) {
                    messageElement.remove();
                }
            } else {
                alert(data.message || 'Failed to delete message');
            }
        });
    }
}
</script>

</body>

</html>