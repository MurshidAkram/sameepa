<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Manage Alerts | <?php echo SITENAME; ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fbfd;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            padding: 20px;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        h2 {
            font-size: 2rem;
            color: #ff5a5f;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .alerts-form, .alerts-list-container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .alerts-form h3, .alerts-list-container h3 {
            font-size: 1.5rem;
            color: #ff5a5f;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            color: #6d6d6d;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .btn, .notify-btn {
            background-color: #ff5a5f;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 30%;
            margin-top: 10px;
        }

        .btn:hover, .notify-btn:hover {
            background-color: #e04448;
        }

        #success-message {
            color: #27ae60;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
        }

        .filter-group {
            margin-bottom: 20px;
        }

        /* CSS animation for alert items */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .alert-item {
            background-color: #f7f9fc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            opacity: 0;
            animation: fadeIn 0.5s forwards; /* Apply fade-in animation */
        }

        /* Transition effect for status change */
        .alert-item .status {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Active status with smooth background transition */
        .alert-item .status.Active {
            background-color: #27ae60;
            color: #fff;
        
            margin-top: 10px;

        }

        /* Resolved status with smooth background transition */
        .alert-item .status.Resolved {
            background-color: #e74c3c;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Alerts</h2>

            <div class="filter-group">
                <label for="alert_filter">Filter by:</label>
                <select id="alert_filter" name="alert_filter">
                    <option value="all">All Alerts</option>
                    <option value="active">Active Alerts</option>
                    <option value="resolved">Resolved Alerts</option>
                    <option value="emergency">Emergency Alerts</option>
                </select>
            </div>

            <form method="POST" class="alerts-form" id="create-alert-form">
                <h3>Create a New Alert</h3>
                <div class="form-group">
                    <label for="alert_title">Alert Title:</label>
                    <input type="text" id="alert_title" name="alert_title" placeholder="Enter the alert title" required>
                </div>
                <div class="form-group">
                    <label for="alert_message">Message:</label>
                    <textarea id="alert_message" name="alert_message" rows="4" placeholder="Enter alert details" required></textarea>
                </div>
                <div class="form-group">
                    <label for="alert_date">Alert Date:</label>
                    <input type="date" id="alert_date" name="alert_date" required>
                </div>
                <button type="submit" class="btn" onclick="createAlert(event)">Create Alert</button>
            </form>

            <p id="success-message" style="display: none;">Alert created and sent to all residents successfully!</p>

            <div class="alerts-list-container">
                <h3>Active and Past Alerts</h3>
                <div id="alerts-list">
                    <div class="alert-item" id="alert-1">
                        <div class="details">
                            <h4>Scheduled Maintenance</h4>
                            <p>Alert Type: Maintenance</p>
                            <p>Date: 2024-11-20</p>
                        </div>
                        <div class="status Active">Active</div>
                        <button class="notify-btn" onclick="notifyResidents('Scheduled Maintenance')">Notify</button>
                    </div>
                    <div class="alert-item" id="alert-2">
                        <div class="details">
                            <h4>Network Downtime</h4>
                            <p>Alert Type: Service</p>
                            <p>Date: 2024-11-15</p>
                        </div>
                        <div class="status Active">Active</div>
                        <button class="notify-btn" onclick="notifyResidents('Network Downtime')">Notify</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function createAlert(event) {
            event.preventDefault();
            const title = document.getElementById('alert_title').value;
            const message = document.getElementById('alert_message').value;
            const date = document.getElementById('alert_date').value;
            notifyResidents(title, message);
            document.getElementById('success-message').style.display = 'block';
        }

        function notifyResidents(title, message = "A new alert has been issued. Please check your dashboard for details.") {
            console.log(`Sending alert "${title}" with message "${message}" to all residents.`);
        }

        // Function to update alert status dynamically (Active -> Resolved)
        function updateAlertStatus(alertId, newStatus) {
            const alertItem = document.getElementById(alertId);
            const statusElement = alertItem.querySelector('.status');
            
            // Update the status text and background color based on the new status
            statusElement.textContent = newStatus;
            
            // Apply the appropriate class based on the new status
            if (newStatus === 'Active') {
                statusElement.classList.remove('Resolved');
                statusElement.classList.add('Active');
            } else if (newStatus === 'Resolved') {
                statusElement.classList.remove('Active');
                statusElement.classList.add('Resolved');
            }

            // Optional: Smoothly animate the transition with a delay
            setTimeout(() => {
                alertItem.classList.add('animated');  // Trigger animation (fade-in effect or transition)
            }, 300);
        }

        // Function to add a new alert dynamically
        function addNewAlert(title, type, date) {
            const alertList = document.getElementById('alerts-list');
            
            // Create new alert item element
            const newAlert = document.createElement('div');
            newAlert.classList.add('alert-item');
            newAlert.innerHTML = `
                <div class="details">
                    <h4>${title}</h4>
                    <p>Alert Type: ${type}</p>
                    <p>Date: ${date}</p>
                </div>
                <div class="status Active">Active</div>
                <button class="notify-btn" onclick="notifyResidents('${title}')">Notify</button>
            `;
            
            // Add it to the list and trigger animation
            alertList.appendChild(newAlert);
            newAlert.classList.add('animated');
        }

        // Example of how to call the functions dynamically
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                addNewAlert('Emergency Alert', 'Emergency', '2024-11-30');
            }, 2000);
        });
    </script>
</body>
</html>
