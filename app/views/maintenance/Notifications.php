<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Notifications | <?php echo SITENAME; ?></title>
    <style>
        /* Internal CSS for Notifications */

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #ffffff;
        }

        h1, h2 {
            color: #2c3e50;
        }

        .notification-category, .message-template, .feedback-prompt, .bulk-message, .tracking-table {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            padding: 15px;
        }

        .notification-category h3, .message-template h3, .feedback-prompt h3, .bulk-message h3, .tracking-table h3 {
            margin-top: 0;
            font-size: 1.2em;
            color: #3498db;
        }

        /* Category Labels */
        .alert, .update, .reminder, .urgent {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }

        .alert { background-color: #e74c3c; }
        .update { background-color: #3498db; }
        .reminder { background-color: #f39c12; }
        .urgent { background-color: #d9534f; }

        /* Notification Templates */
        .template-option {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        /* Feedback Prompt */
        .feedback-rating {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .feedback-rating label {
            cursor: pointer;
            color: #666;
        }

        .feedback-rating input {
            display: none;
        }

        .feedback-rating input:checked + label {
            color: #ffbc00;
            font-weight: bold;
        }

        /* Bulk Messaging */
        .bulk-message-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .bulk-message input[type="checkbox"] {
            margin-right: 8px;
        }

        /* Notification Tracking */
        .tracking-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .tracking-table th, .tracking-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .tracking-table th {
            background-color: #f0f0f0;
        }

        .status-read { color: green; font-weight: bold; }
        .status-unread { color: red; font-weight: bold; }
    </style>
</head>

<body>

<?php require APPROOT . '/views/inc/components/navbar.php'; ?>
<div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>
  
        <!-- Main Content -->
        <main class="main-content">
            <h1>Notifications</h1>

            <!-- Notification Types -->
            <div class="notification-category">
                <h3>Notification Types</h3>
                <p><span class="alert">System Alert</span> - Power outage notification</p>
                <p><span class="update">Resident Update</span> - Updates on repair status</p>
                <p><span class="reminder">Reminder</span> - Routine maintenance reminders</p>
                <p><span class="urgent">Urgent Message</span> - Immediate attention required</p>
            </div>

            <!-- Message Templates -->
            <div class="message-template">
                <h3>Message Templates</h3>
                <div class="template-option">
                    <p><strong>Water Shut-off Notice:</strong> "Dear residents, water will be temporarily shut off on [DATE] from [TIME] to [TIME] due to maintenance work."</p>
                </div>
                <div class="template-option">
                    <p><strong>Emergency Alert:</strong> "Attention: Due to unforeseen circumstances, an evacuation may be necessary. Please follow the emergency exits as indicated."</p>
                </div>
                <div class="template-option">
                    <p><strong>Repair Status Update:</strong> "Your maintenance request [REQUEST ID] is currently being processed. Expected completion: [DATE]."</p>
                </div>
            </div>

            <!-- Resident Feedback Prompt -->
            <div class="feedback-prompt">
                <h3>Feedback Prompt</h3>
                <p>Did this notification provide clear information?</p>
                <div class="feedback-rating">
                    <input type="radio" id="rating-1" name="feedback-rating" value="1">
                    <label for="rating-1">1</label>
                    <input type="radio" id="rating-2" name="feedback-rating" value="2">
                    <label for="rating-2">2</label>
                    <input type="radio" id="rating-3" name="feedback-rating" value="3">
                    <label for="rating-3">3</label>
                    <input type="radio" id="rating-4" name="feedback-rating" value="4">
                    <label for="rating-4">4</label>
                    <input type="radio" id="rating-5" name="feedback-rating" value="5">
                    <label for="rating-5">5</label>
                </div>
            </div>

            <!-- Bulk Messaging -->
            <div class="bulk-message">
                <h3>Bulk Messaging</h3>
                <div class="bulk-message-group">
                    <label><input type="checkbox" name="group[]" value="North Wing"> North Wing</label>
                    <label><input type="checkbox" name="group[]" value="South Tower"> South Tower</label>
                    <label><input type="checkbox" name="group[]" value="Floor 1 Residents"> Floor 1 Residents</label>
                    <label><input type="checkbox" name="group[]" value="Floor 2 Residents"> Floor 2 Residents</label>
                    <label><input type="checkbox" name="group[]" value="Entire Building"> Entire Building</label>
                </div>
            </div>

            <!-- Notification Tracking -->
            <div class="tracking-table">
                <h3>Notification Tracking</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Resident ID</th>
                            <th>Notification</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R001</td>
                            <td>Power Outage Alert</td>
                            <td class="status-read">Read</td>
                        </tr>
                        <tr>
                            <td>R002</td>
                            <td>Repair Status Update</td>
                            <td class="status-unread">Unread</td>
                        </tr>
                        <tr>
                            <td>R003</td>
                            <td>Routine Maintenance Reminder</td>
                            <td class="status-read">Read</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    
</body>

</html>
