<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title><?php echo SITENAME; ?> - Sign Up</title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="form-container">
        <div class="form-content">
            <div class="form-wrapper">
                <h1>Sign Up</h1>
                <p>Create an account to access the community features.</p>
                <?php if (!empty($data['errors'])): ?>
                    <div class="form-errors">
                        <?php foreach ($data['errors'] as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo URLROOT; ?>/users/signup" method="POST">
                    <div class="form-group">
                        <label for="username">Name:</label>
                        <input type="text" name="username" id="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" name="confirm_password" id="confirm_password">
                    </div>
                    <button type="submit" class="form-submit">Register</button>
                </form>
            </div>
        </div>
        <div class="form-image" style="background-image: url('<?php echo URLROOT; ?>/public/img/signup.jpg');"></div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>