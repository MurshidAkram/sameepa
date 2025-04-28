<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/form-styles.css">
    <title><?php echo SITENAME; ?> - Sign Up</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-image: url('<?php echo URLROOT; ?>/img/signup.jpg');
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }

    .form-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        width: 90%;
        margin: 20px auto;
        padding: 15px;
        flex-shrink: 0;
    }

    .form-content {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-content h1 {
        margin-bottom: 10px;
        font-size: 1.5rem;
        color: #333;
        text-align: center;
    }

    .form-content p {
        margin-bottom: 15px;
        font-size: 0.9rem;
        color: #555;
        text-align: center;
    }

    .form-content form {
        width: 100%;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        color: #333;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 0.9rem;
        border: 1.5px solid #e0e0e0;
        border-radius: 5px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-errors p {
        color: #d9534f;
        font-size: 0.8rem;
        margin: 5px 0;
    }

    .form-submit {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 0.9rem;
        color: #fff;
        background-color: #800080;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .form-submit:hover {
        background-color: #800080;
    }



    html,
    body {
        height: 100%;
        overflow-x: hidden;
    }

    main {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    @media (min-width: 768px) {
        .form-container {
            flex-direction: row;
        }

        .form-image {
            flex: 1;
            display: block;
            background-size: cover;
            background-position: center;
            height: auto;
        }
    }
</style>

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
                <form action="<?php echo URLROOT; ?>/users/signup" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
                    </div>
                    <input type="hidden" name="role" value="1">
                    <div class="form-group resident-only">
                        <label for="address">Address/House No:</label>
                        <input type="number" name="address" id="address" min="1" required>
                    </div>
                    <div class="form-group resident-only">
                        <label for="phonenumber">Phone No.</label>
                        <input type="text" name="phonenumber" id="phonenumber" value="<?php echo isset($data['phonenumber']) ? $data['phonenumber'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="verification_document">Verification Document (PDF):</label>
                        <input type="file" name="verification_document" id="verification_document" accept=".pdf">
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
        <!-- <div class="form-image" style="background-image: url('<?php echo URLROOT; ?>/public/img/signup.jpg');"></div> -->
    </div>



    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>