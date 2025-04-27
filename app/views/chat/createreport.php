<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Create Chat Report | <?php echo SITENAME; ?></title>
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

        <main class="groups-main">
            <aside class="groups-sidebar">
                <h2>Chat Navigation</h2>
                <?php $current_page = basename($_SERVER['REQUEST_URI']); ?>

                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="<?php echo ($current_page == 'index' ? 'active' : ''); ?>">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="<?php echo ($current_page == 'search' ? 'active' : ''); ?>">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="<?php echo ($current_page == 'requests' ? 'active' : ''); ?>">Chat Requests</a>
                    <a href="<?php echo ($_SESSION['user_role_id'] == 3) ? URLROOT . '/chat/report' : URLROOT . '/chat/myreports'; ?>" 
   class="<?php echo ($current_page == (($_SESSION['user_role_id'] == 3) ? 'view Reports' : 'Report')) ? 'active' : ''; ?>">
    <?php echo ($_SESSION['user_role_id'] == 3) ? 'Reports' : 'Report'; ?>
</a>
            </aside>

            <div class="groups-content">
            <a href="<?php echo URLROOT; ?>/chat/myreports" class="back-button">
                        <i class="fas fa-arrow-left"></i> back to report
                    </a>
                <h1>Create Chat Report</h1>
                <p>Use the form below to submit a report regarding a chat or message.</p>

                <form action="<?php echo URLROOT; ?>/chat/submitreport" method="POST" class="report-form">
                    <div class="form-group">
                        <label for="reported_user_message">Reported User or Message Identifier:</label>
                        <input type="text" id="reported_user_message" name="reported_user_message" value="<?php echo isset($_GET['user']) ? htmlspecialchars($_GET['user']) : (isset($data['reported_user_message']) ? htmlspecialchars($data['reported_user_message']) : ''); ?>" required>
                        <small>e.g., Username, Message ID, or description of the message location.</small>
                        <?php if (!empty($data['reported_user_message_err'])) : ?>
                            <p class="error-message"><?php echo $data['reported_user_message_err']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="report_category">Report Category:</label>
                        <select id="report_category" name="report_category" required>
                            <option value="">-- Select Category --</option>
                            <option value="inappropriate_content">Inappropriate Content</option>
                            <option value="harassment">Harassment</option>
                            <option value="spam">Spam</option>
                            <option value="other">Other</option>
                        </select>
                        <?php if (!empty($data['category_err'])) : ?>
                            <p class="error-message"><?php echo $data['category_err']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="report_description">Description:</label>
                        <textarea id="report_description" name="report_description" rows="6" required></textarea>
                        <small>Provide detailed information about the issue.</small>
                        <?php if (!empty($data['description_err'])) : ?>
                            <p class="error-message"><?php echo $data['description_err']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Submit Report</button>
                        <a href="<?php echo URLROOT; ?>/chat/index" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".groups-nav a");

        links.forEach(link => {
            link.addEventListener("click", function() {
                // Remove active class from all links
                links.forEach(l => l.classList.remove("active"));

                // Add active class to the clicked link
                this.classList.add("active");
            });
        });
    });
</script>

</html>