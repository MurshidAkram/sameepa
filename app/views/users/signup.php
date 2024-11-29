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
    /* General body styling */
    /* General body styling */
    /* General body styling */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-image: url('<?php echo URLROOT; ?>/img/signup.jpg');
        /* Path to your background image */
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
        /* Prevent horizontal scrolling */
    }

    /* Form container styling */
    .form-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.9);
        /* Semi-transparent white */
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        /* Reduced width */
        width: 90%;
        /* Responsive width */
        margin: 20px auto;
        padding: 15px;
        /* Reduced padding */
        flex-shrink: 0;
    }

    /* Form content styling */
    .form-content {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Form title and description */
    .form-content h1 {
        margin-bottom: 10px;
        font-size: 1.5rem;
        /* Reduced font size */
        color: #333;
        text-align: center;
    }

    .form-content p {
        margin-bottom: 15px;
        font-size: 0.9rem;
        /* Reduced font size */
        color: #555;
        text-align: center;
    }

    /* Form styling */
    .form-content form {
        width: 100%;
    }

    .form-group {
        margin-bottom: 12px;
        /* Reduced spacing */
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        /* Reduced font size */
        color: #333;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        /* Reduced padding */
        font-size: 0.9rem;
        /* Reduced font size */
        border: 1.5px solid #e0e0e0;
        /* Slightly thinner border */
        border-radius: 5px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #007bff;
        outline: none;
    }

    /* Error message styling */
    .form-errors p {
        color: #d9534f;
        font-size: 0.8rem;
        /* Reduced font size */
        margin: 5px 0;
    }

    /* Submit button */
    .form-submit {
        display: block;
        width: 100%;
        padding: 10px;
        /* Reduced padding */
        font-size: 0.9rem;
        /* Reduced font size */
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

    /* Footer styling
.footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: relative;
    bottom: 0;
    width: 100%;
    margin-top: auto;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
} */

    /* Ensure page scrolls */
    html,
    body {
        height: 100%;
        /* Ensure the height includes content overflow */
        overflow-x: hidden;
        /* Prevent horizontal scrolling */
    }

    main {
        flex: 1;
        /* Allow the main content to grow and push the footer down */
        display: flex;
        flex-direction: column;
    }

    /* Responsive Design */
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
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select name="role" style="
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    color: #333;
    background-color: #fff;
    transition: border-color 0.3s;" id="role">
                            <option value="">Select Role</option>
                            <option value="1">Resident</option>
                        </select>
                    </div>
                    <div class="form-group resident-only">
                        <label for="address">Address/House No:</label>
                        <input type="text" name="address" id="address" value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>">
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

    <script>
        // Show/hide the resident-only fields based on the selected role
        const roleSelect = document.getElementById('role');
        const residentOnlyFields = document.querySelectorAll('.resident-only');

        roleSelect.addEventListener('change', () => {
            residentOnlyFields.forEach(field => {
                field.style.display = roleSelect.value === '1' ? 'block' : 'none';
            });
        });
    </script>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>