<!-- app/views/announcements/edit.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/announcements/announcements.css">
    <title>Edit Announcement | <?php echo SITENAME; ?></title>
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
            default:
                redirect('announcements/index');
        }
        ?>

        <main>
            <div class="create-announcement-container">
                <div class="page-header">
                    <h1>Edit Announcement</h1>
                    <a href="<?php echo URLROOT; ?>/announcements/index" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Announcements
                    </a>
                </div>

                <form action="<?php echo URLROOT; ?>/announcements/edit/<?php echo $data['id']; ?>" method="POST" class="announcement-form">
                    <div class="form-group">
                        <label for="title">Announcement Title:</label>
                        <input type="text" name="title" id="title"
                            class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['title']; ?>"
                            placeholder="Enter announcement title">
                        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="content">Announcement Content:</label>
                        <textarea name="content" id="content" rows="10"
                            class="form-control <?php echo (!empty($data['content_err'])) ? 'is-invalid' : ''; ?>"
                            placeholder="Enter announcement content"><?php echo $data['content']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['content_err']; ?></span>
                    </div>

                    <div class="form-actions">
                        <a href="<?php echo URLROOT; ?>/announcements/index" class="btn btn-cancel">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Announcement</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>