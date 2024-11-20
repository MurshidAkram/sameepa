<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Contact Us | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="form-container">
        <div class="form-content">
            <div class="form-wrapper">
                <h1>Contact Us</h1>
                <p>If you have any questions or need support, feel free to reach out to us using the form below.</p>
                <?php if (!empty($data['errors'])): ?>
                    <div class="form-errors">
                        <?php foreach ($data['errors'] as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo URLROOT; ?>/pages/contact" method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="form-submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>