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
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select class="signupselect" name="role" id="role">
                            <option value="">Select Role</option>
                            <option value="1">Resident</option>
                            <option value="2">Admin</option>
                            <option value="4">Maintenance</option>
                            <option value="5">Security</option>
                            <option value="6">External Service Provider</option>
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