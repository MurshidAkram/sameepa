<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Request Assistance | <?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Custom styling for the request form */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group select,
        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .btn-request {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-request:hover {
            background-color: #0056b3;
        }

        /* Custom styling for the assistance dashboard */
        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .dashboard-table th {
            background-color: #f8f9fa;
        }

        .dashboard-table .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .dashboard-table .btn-edit,
        .dashboard-table .btn-delete {
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #17a2b8;
        }

        .btn-edit:hover {
            background-color: #138496;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Notification styling */
        .notification {
            display: none;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Request Assistance</h1>

            <!-- Notification Area -->
            <div id="notification" class="notification"></div>

            <!-- Request Form Component -->
            <div class="card">
                <form action="<?php echo URLROOT; ?>/maintenance/request" method="POST" id="request-form">
                    <div class="form-group">
                        <label for="issue-type">Issue Type:</label>
                        <select id="issue-type" name="issue_type" required>
                            <option value="AC">AC</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Plumbing">Plumbing</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority Level:</label>
                        <select id="priority" name="priority" required>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="requested-time">Requested Time:</label>
                        <input type="text" id="requested-time" name="requested_time" required />
                    </div>

                    <button type="submit" class="btn-request">Request Assistance</button>
                </form>
            </div>

            <!-- Assistance Dashboard -->
            <h2>Assistance Dashboard</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Date Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example rows; replace with dynamic data -->
                    <tr>
                        <td>R001</td>
                        <td>Pending</td>
                        <td>High</td>
                        <td>2024-09-15</td>
                        <td class="action-buttons">
                            <button class="btn-edit">Edit</button>
                            <button class="btn-delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>R002</td>
                        <td>In Progress</td>
                        <td>Medium</td>
                        <td>2024-09-16</td>
                        <td class="action-buttons">
                            <button class="btn-edit">Edit</button>
                            <button class="btn-delete">Delete</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Flatpickr
            flatpickr('#requested-time', {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today"
            });

            // Example Notification Handling
            function showNotification(message, type) {
                var notification = document.getElementById('notification');
                notification.textContent = message;
                notification.className = 'notification ' + type;
                notification.style.display = 'block';
                setTimeout(function () {
                    notification.style.display = 'none';
                }, 5000);
            }

            // Handle form submission
            document.getElementById('request-form').addEventListener('submit', function (e) {
                e.preventDefault();
                // Example success notification
                showNotification('Assistance request submitted successfully!', 'success');
                // Here you would also handle actual form submission via AJAX or similar
            });
        });
    </script>
</body>

</html>
