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

    <?php if (empty($data['messages'])): ?>
        <div class="no-messages">No messages yet. Start the conversation!</div>
    <?php else: ?>
        <?php foreach ($data['messages'] as $message): ?>
            <?php
                // Make sure $message is an object (stdClass)
                $isSender = ($message->sender_id == $_SESSION['user_id']);
                $bubbleClass = $isSender ? 'sent' : 'received';
            ?>
            <div class="message-bubble <?php echo $bubbleClass; ?>">
                <div class="message-content">
                    <?php echo htmlspecialchars($message->message); ?>
                </div>
                <span class="message-time">
                    <?php echo date('H:i', strtotime($message->sent_at)); ?>
                </span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div><style>
.chat-messages {
    padding: 20px;
    display: flex;
    flex-direction: column;
}
.name-card {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}
.name-image img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 12px;
}
.title {
    margin: 0;
    font-size: 1.2em;
}
.no-messages {
    text-align: center;
    color: #888;
    margin-top: 30px;
}
.message-bubble {
    max-width: 60%;
    padding: 10px 16px;
    border-radius: 18px;
    margin: 8px 0;
    display: flex;
    flex-direction: column;
    word-break: break-word;
}
.sent {
    align-self: flex-end;
    background: #6a5acd;
    color: #fff;
    border-bottom-right-radius: 4px;
    text-align: right;
}
.received {
    align-self: flex-start;
    background: #f1f0f0;
    color: #222;
    border-bottom-left-radius: 4px;
    text-align: left;
}
.message-content {
    margin-bottom: 4px;
}
.message-time {
    font-size: 0.75em;
    color: #bbb;
    align-self: flex-end;
}

.chat-input-container {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
}

.chat-input {
    flex: 1;
    padding: 12px 16px;
    border: 1px solid #ccc;
    border-radius: 20px;
    font-size: 1em;
    width: 100%; /* makes input expand to fill available space */
    box-sizing: border-box;
}
.chat-form button {
    background: #800080;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    margin-left: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.2em;
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
        // Auto-scroll to bottom of chat
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    </script>
</body>
</html>