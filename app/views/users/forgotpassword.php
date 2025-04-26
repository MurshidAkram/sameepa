<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Forgot Password| <?php echo SITENAME; ?></title>


</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="form-container">
        <div class="form-content">
            <?php if (!empty($data['success'])): ?>
                <div class="success-message"><?php echo $data['success']; ?></div>
            <?php endif; ?>

            <?php if (!empty($data['errors'])): ?>
                <div class="form-errors">
                    <?php foreach ($data['errors'] as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo URLROOT; ?>/users/forgotpassword" method="post">
                <h2>Forgot Password</h2>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
                <button type="submit">Send Reset Link</button>
            </form>
        </div>
        <div class="form-image" style="background-image: url('<?php echo URLROOT; ?>/img/login.jpg');"></div>

    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

</body>

</html>