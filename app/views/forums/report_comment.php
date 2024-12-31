<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forums.css">
    <title>Report Comment | <?php echo SITENAME; ?></title>
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

        <main>
            <div class="create-announcement-container">
                <div class="page-header">
                    <h1>Report Comment</h1>
                    <a href="<?php echo URLROOT; ?>/forums/index" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Forums
                    </a>
                </div>

                <form action="<?php echo URLROOT; ?>/forums/report_comment/<?php echo $data['comment_id']; ?>" method="POST" class="announcement-form">
                    <div class="form-group">
                        <label for="reason">Reason for Reporting:</label>
                        <textarea name="reason" id="reason" rows="10"
                            class="form-control <?php echo (!empty($data['reason_err'])) ? 'is-invalid' : ''; ?>"
                            placeholder="Please provide details about why you are reporting this comment" required></textarea>
                        <span class="invalid-feedback"><?php echo isset($data['reason_err']) ? $data['reason_err'] : ''; ?></span>
                    </div>

                    <div class="form-actions">
                        <a href="<?php echo URLROOT; ?>/forums/index" class="btn btn-cancel">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>