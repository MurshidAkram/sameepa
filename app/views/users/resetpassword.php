<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/form-styles.css">
    <?php require APPROOT . '/views/inc/components/header.php'; ?>

</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="form-container">
        <?php if (!empty($data['errors'])): ?>
            <div class="form-errors">
                <?php foreach ($data['errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo URLROOT; ?>/users/resetpassword" method="post">
            <input type="hidden" name="token" value="<?php echo $data['token']; ?>">
            <h2>Reset Password</h2>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>

</html>