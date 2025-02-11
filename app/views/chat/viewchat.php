<!-- app/views/chat/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/chats.css">
    <title>Chats | <?php echo SITENAME; ?></title>
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
                            <img src="<?php echo URLROOT; ?>/img/default-user.png" alt="Chat with John Doe">
                        </div>
                            <h3 class="title">Mr. Sunil</h3>
            </div>
                 <div class="back-image">
                 <img src="<?php echo URLROOT; ?>/img/chat.jpg" alt="Chat with John Doe">
                        </div>
                        <?php if (!empty($data['messages'])): ?>
                        <?php foreach ($data['messages'] as $message): ?>
                            <div class="message-wrapper <?php echo ($message->sender_id == $_SESSION['user_id']) ? 'sent' : 'received'; ?>">
                                <div class="message">
                                    <?php echo htmlspecialchars($message->message); ?>
                                    <span class="message-time">
                                        <?php echo date('H:i', strtotime($message->sent_at)); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-messages">No messages yet. Start the conversation!</div>
                    <?php endif; ?>
        </div>
      

        <form class="chat-form" action="<?php echo URLROOT; ?>/chat/sendMessage" method="POST">
                    <input type="hidden" name="chat_id" value="<?php echo $data['chat']->id; ?>">
                    <input type="hidden" name="recipient_id" value="<?php echo $data['otherUser']->id; ?>">
                    <div class="chat-input-container">
                        <input type="text" name="message" placeholder="Type a message..." required>
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
    
    
</main>
</div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>


</html>