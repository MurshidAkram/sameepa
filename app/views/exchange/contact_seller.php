
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/contact_seller.css">
    <title>Contact Seller | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
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

        <main class="seller-chat-main">
            <div class="seller-chat-container">
                <div class="seller-chat-header">
                    <div class="seller-chat-info">
                        <h2>Chat with John Doe</h2>
                        <span>Lawn Mowing Service</span>
                    </div>
                    <a href="<?php echo URLROOT; ?>/exchange/view_listing" class="back-to-listing">
                        <i class="fas fa-arrow-left"></i> Back to Listing
                    </a>
                </div>
                <div class="seller-chat-messages">
                    <div class="chat-message sent">
                        <div class="message-content">
                            <div class="message-info">
                                <span class="message-time">11:28 AM</span>
                            </div>
                            <p>Hi, I'm interested in your lawn mowing service. What are your rates?</p>
                        </div>
                    </div>

                    <div class="chat-message received">
                        <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="Seller" class="message-avatar">
                        <div class="message-content">
                            <div class="message-info">
                                <span class="message-sender">John Doe</span>
                                <span class="message-time">11:30 AM</span>
                            </div>
                            <p>Hello! Thanks for your interest. The rate is $30 per hour, and I'm available on weekends. Would you like to schedule a service?</p>
                        </div>
                    </div>
                </div>
                <div class="seller-chat-input">
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
