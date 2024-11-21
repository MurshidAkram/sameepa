<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Login | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="form-container">
        <div class="form-content">
            <div class="form-wrapper">
                <h1>Login</h1>
                <p>Enter your credentials to log in.</p>
                <?php if (!empty($data['errors'])): ?>
                    <div class="form-errors">
                        <?php foreach ($data['errors'] as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="form-submit">Login</button>
                    <a href=" <?php echo URLROOT; ?>/users/forgotpassword">Forgot password?</a>
                </form>
            </div>
        </div>
        <div class="form-image" style="background-image: url('<?php echo URLROOT; ?>/img/login.jpg');"></div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>