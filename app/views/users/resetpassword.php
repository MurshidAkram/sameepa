<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | <?php echo SITENAME; ?></title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            background: linear-gradient(135deg, #e6f0fa 0%, #f4f4f9 100%);
            color: #1a202c;
            overflow-x: hidden;
        }

        /* Form container */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px); /* Adjust for header/footer */
            padding: 30px 15px;
            animation: fadeIn 0.5s ease-in;
        }

        /* Form content */
        .form-content {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            margin-right: 30px;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-content:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Form heading */
        .form-content h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #2d3748;
            text-align: center;
            margin-bottom: 25px;
        }

        /* Form group */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            font-size: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f7fafc;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color:#800080;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.2);
            background: #ffffff;
        }

        /* Submit button */
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background:#800080;
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button[type="submit"]:hover {
            background:#800080;
            transform: translateY(-1px);
        }

        button[type="submit"]:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.3);
        }

        /* Error messages */
        .form-errors {
            background: #fff5f5;
            color: #9b2c2c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideIn 0.3s ease;
        }

        .form-errors::before {
            content: '⚠';
            font-size: 1.2rem;
        }

        .form-errors p {
            margin: 0;
        }

        /* Form image */
        .form-image {
            width: 100%;
            max-width: 420px;
            height: 420px;
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .form-image:hover {
            transform: scale(1.02);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
                padding: 20px 10px;
            }

            .form-content {
                margin-right: 0;
                margin-bottom: 20px;
                padding: 25px;
                max-width: 100%;
            }

            .form-image {
                display: none; /* Hide image on mobile */
            }

            .form-content h2 {
                font-size: 1.8rem;
            }

            button[type="submit"] {
                padding: 12px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .form-content {
                padding: 20px;
            }

            .form-group input {
                padding: 10px;
                font-size: 0.95rem;
            }
        }

        /* Accessibility */
        .form-group input:focus, button[type="submit"]:focus {
            outline: 2px solid#800080;
            outline-offset: 2px;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="form-container">
        <div class="form-content" role="form" aria-labelledby="reset-password-title">
            <?php if (!empty($data['errors'])): ?>
                <div class="form-errors">
                    <?php foreach ($data['errors'] as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo URLROOT; ?>/users/resetpassword" method="post">
                <h2 id="reset-password-title">Reset Password</h2>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($data['token']); ?>">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" id="new_password" required aria-required="true">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required aria-required="true">
                </div>
                <button type="submit">Reset Password</button>
            </form>
        </div>
        <div class="form-image" style="background-image: url('<?php echo URLROOT; ?>/img/forgot.jpg');" aria-hidden="true"></div>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>