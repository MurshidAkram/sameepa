<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/superadmin/createUser.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <title><?php echo SITENAME; ?> Create Users</title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <div class="form-wrapper">
                <h1>Create Employee Account</h1>
                <?php if (!empty($data['errors'])): ?>
                    <div class="form-errors">
                        <?php foreach ($data['errors'] as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo URLROOT; ?>/users/createUser" method="POST">
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
                        <select name="role" id="role">
                            <option value="">Select Role</option>
                            <!-- <option value="1">Resident</option> -->
                            <option value="2">Admin</option>
                            <option value="3">SuperAdmin</option>
                            <option value="4">Maintenance</option>
                            <option value="5">Security</option>
                            <!--                             <option value="6">External Service Provider</option>
 -->
                        </select>
                    </div>
                    <div class="form-group resident-only">
                        <label for="address">Address:</label>
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
                    <button type="submit" class="form-submit">Create Employee Account</button>
                </form>
            </div>

        </main>
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

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Headings */
        h1,
        h2,
        h3,
        h4 {
            color: #800080;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 600;
            display: inline-block;
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            flex-direction: row;
            width: 100%;
            min-height: 100vh;
        }



        /* Main Content */
        main {
            flex-grow: 1;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 100%;
        }


        .form-wrapper {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 70px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(128, 0, 128, 0.1);
        }

        .form-wrapper h1 {
            color: #800080;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-wrapper p {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #800080;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #800080;
        }

        .form-submit {
            background-color: #800080;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
        }

        .form-submit:hover {
            background-color: #9a009a;
            transform: translateY(-2px);
        }

        .form-errors {
            background-color: #ffe6e6;
            border: 1px solid #ff9999;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .form-errors p {
            color: #cc0000;
            margin: 5px 0;
        }

        /* public/css/components/form-styles.css */

        .profile-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 1rem;
        }

        .profile-content {
            background: #fff;
            padding: 7rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-image-section {
            text-align: center;
            margin-bottom: 1rem;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .profile-form {
            display: grid;
            gap: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 15rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        /* Navbar profile picture styles */
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn.btn-primary {
            background-color: #800080;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
        }

        .btn.btn-danger {
            background-color: #c81313;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
        }

        .btn.btn-cancel {
            background-color: #c81313;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
            }

            .form-image {
                min-height: 200px;
            }
        }
    </style>
</body>

</html>