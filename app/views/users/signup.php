<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <title><?php echo SITENAME; ?> - Sign Up</title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <h1>Sign Up</h1>
    <p>Create an account to access the community features.</p>

    <form action="<?php echo URLROOT; ?>/users/signup" method="POST">
        <label for="username">Name:</label>
        <input type="text" name="username" id="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>">
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password">
        <br>

        <button type="submit">Register</button>
    </form>

    <?php if (!empty($data['errors'])): ?>
        <ul>
            <?php foreach ($data['errors'] as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>