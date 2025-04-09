<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Reported Messages | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        switch ($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>

        <main class="reported-main">
           <!-- Add this to the top of the reported_messages.php view -->
            <div class="top-page">
                <a href="<?php echo URLROOT; ?>/groups/admin_dashboard" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <h1>Reported Messages for <?php echo $data['group']['group_name']; ?></h1>
            <?php if (empty($data['reported_messages'])) : ?>
                <p>No reported messages found.</p>
            <?php else : ?>
                <div class="reported-messages-list">
                    <?php foreach ($data['reported_messages'] as $message) : ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <p><span class="comment-content"><?php echo $message->message; ?> &nbsp </span> <span class="comment-author"> By: <?php echo $message->sender_name; ?></span> </p>
                                <span class="comment-date"><?php echo date('F j, Y g:i A', strtotime($message->created_at)); ?></span>
                                <div class="comment-actions">
                                    <form action="<?php echo URLROOT; ?>/groups/delete_message/<?php echo $message->message_id; ?>" method="POST" style="display: inline;">
                                        <button type="submit" class="btndelcomment" onclick="return confirm('Are you sure you want to delete this message?')">
                                            Delete Message
                                        </button>
                                    </form>
                                    <a href="<?php echo URLROOT; ?>/groups/ignore_message_report/<?php echo $message->id; ?>" class="btn-ignore-report">Ignore Report</a>
                                </div>
                            </div>
                            <p class="reportedreason"> Reported for: <?php echo $message->reason; ?> </p>
                            <div class="comment-footer">
                                <span class="comment-report-reason">Reported by: <?php echo $message->reporter_name; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>