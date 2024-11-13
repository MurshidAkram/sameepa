<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Emergency_Contacts.css">
    <title>Manage Emergency Contacts | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <div class="form-and-list">
                <!-- Emergency Contact Form -->
                <div class="form-container">
                    <h2>Manage Emergency Contacts</h2>
                    <form method="POST" class="emergency-contacts-form">
                        <div class="form-group">
                            <label for="contact_name">Contact Name:</label>
                            <input type="text" id="contact_name" name="contact_name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_phone">Phone Number:</label>
                            <input type="text" id="contact_phone" name="contact_phone" required>
                        </div>
                        <div class="form-group">
                            <label for="relationship">Relationship:</label>
                            <input type="text" id="relationship" name="relationship" required>
                        </div>
                        <button type="submit" class="btn" onclick="manageEmergencyContact(event)">Save Contact</button>
                    </form>
                </div>

                <!-- Emergency Contacts List -->
                <div class="contacts-list-container">
                    <h3>Emergency Contacts List</h3>
                    <div class="contacts-list">
                        <!-- More contacts added here -->
                        <div class="contact-item">
                            <h4>Local Police</h4>
                            <p>Phone: 123-456-7890</p>
                            <p>Location: 123 Police St, City</p>
                            <button class="btn call-btn">Call</button>
                            <button class="btn message-btn">Message</button>
                            <button class="btn navigate-btn">Navigate</button>
                        </div>
                        <div class="contact-item">
                            <h4>Fire Department</h4>
                            <p>Phone: 234-567-8901</p>
                            <p>Location: 456 Fire Ave, City</p>
                            <button class="btn call-btn">Call</button>
                            <button class="btn message-btn">Message</button>
                            <button class="btn navigate-btn">Navigate</button>
                        </div>
                        <div class="contact-item">
                            <h4>Ambulance</h4>
                            <p>Phone: 345-678-9012</p>
                            <p>Location: 789 Ambulance Rd, City</p>
                            <button class="btn call-btn">Call</button>
                            <button class="btn message-btn">Message</button>
                            <button class="btn navigate-btn">Navigate</button>
                        </div>
                        <div class="contact-item">
                            <h4>Gas Leak Emergency</h4>
                            <p>Phone: 456-789-0123</p>
                            <p>Location: 101 Gas St, City</p>
                            <button class="btn call-btn">Call</button>
                            <button class="btn message-btn">Message</button>
                            <button class="btn navigate-btn">Navigate</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function manageEmergencyContact(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
        }
    </script>

    <style>
        /* Layout for form and list */
        .form-and-list {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        /* Form container */
        .form-container {
            flex: 1;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Emergency Contacts List container */
        .contacts-list-container {
            flex: 1;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .contacts-list-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .contacts-list {
            margin-top: 20px;
            animation: fadeIn 0.6s ease-out;
        }

        .contact-item {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .contact-item h4 {
            color: #e74c3c;
            font-size: 1.5rem;
        }

        .contact-item p {
            font-size: 1rem;
            color: #333;
        }

        .contact-item button {
            margin-right: 10px;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .call-btn {
            background-color: #27ae60;
        }

        .call-btn:hover {
            background-color: #2ecc71;
        }

        .message-btn {
            background-color: #3498db;
        }

        .message-btn:hover {
            background-color: #2980b9;
        }

        .navigate-btn {
            background-color: #f39c12;
        }

        .navigate-btn:hover {
            background-color: #e67e22;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>
