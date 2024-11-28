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
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="group-chat-main">
            <div class="group-chat-container">
                <div class="group-chat-header">
                    <div class="group-chat-info">
                        <h2>Book Club Chat</h2>
                        <span>15 members</span>
                    </div>
                    <a href="<?php echo URLROOT; ?>/groups/viewgroup/1" class="back-to-group">
                        <i class="fas fa-arrow-left"></i> Back to Group
                    </a>
                </div>
                  <div class="group-chat-messages">
                      <div class="chat-message received">
                          <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="User" class="message-avatar">
                          <div class="message-content">
                              <div class="message-info">
                                  <span class="message-sender">Sarah Johnson</span>
                                  <span class="message-time">10:30 AM</span>
                              </div>
                              <p>What did everyone think of chapter 5?</p>
                          </div>
                      </div>

                      <div class="chat-message sent">
                          <div class="message-content">
                              <div class="message-info">
                                  <span class="message-time">10:32 AM</span>
                              </div>
                              <p>The plot twist was unexpected!</p>
                          </div>
                      </div>

                      <div class="chat-message received">
                          <img src="<?php echo URLROOT; ?>/img/default-user2.jpg" alt="User" class="message-avatar">
                          <div class="message-content">
                              <div class="message-info">
                                  <span class="message-sender">Michael Chen</span>
                                  <span class="message-time">10:35 AM</span>
                              </div>
                              <p>I loved how the author developed the characters.</p>
                          </div>
                      </div>

                      <!-- Add Emily Davis and final sent message -->
                  </div>
                <div class="group-chat-input">
                    <input type="text" placeholder="Type your message...">
                    <button class="send-message">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
