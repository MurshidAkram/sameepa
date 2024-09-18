<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/request.css">
    <title>Request Assistance | <?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <div class="content-header">
                <h1>Request Assistance</h1>
                <p>Fill out the form below to request maintenance assistance. Please ensure all details are accurate.</p>
            </div>

            <!-- Notification Area -->
            <div id="notification" class="notification"></div>

            <!-- Request Form Component -->
            <div class="card form-card">
                <form action="<?php echo URLROOT; ?>/maintenance/request" method="POST" id="request-form">
                    <div class="form-group">
                        <label for="issue-type">Issue Type:</label>
                        <select id="issue-type" name="issue_type" required>
                            <option value="" disabled selected>Select an issue</option>
                            <option value="AC">AC</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Plumbing">Plumbing</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" placeholder="Describe the issue in detail" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority Level:</label>
                        <select id="priority" name="priority" required>
                            <option value="" disabled selected>Select priority</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="requested-time">Requested Time:</label>
                        <input type="text" id="requested-time" name="requested_time" placeholder="Pick a date and time" required />
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-request">Request Assistance</button>
                    </div>
                </form>
            </div>

            <!-- Assistance Dashboard -->
            <h2 class="dashboard-title">Assistance Dashboard</h2>
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
                </tbody>
            </table>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('#requested-time', {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today"
            });

            function showNotification(message, type) {
                var notification = document.getElementById('notification');
                notification.textContent = message;
                notification.className = 'notification ' + type;
                notification.style.display = 'block';
                setTimeout(function () {
                    notification.style.display = 'none';
                }, 5000);
            }

            document.getElementById('request-form').addEventListener('submit', function (e) {
                e.preventDefault();
                showNotification('Assistance request submitted successfully!', 'success');
            });
        });
    </script>
</body>

</html>
