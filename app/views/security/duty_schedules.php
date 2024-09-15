<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css"> <!-- Use dashboard styles -->
    <title>Manage Duty Schedules | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Manage Duty Schedules</h1>
            <p>Welcome to the Duty Schedules page. Here, you can view and update duty schedules for security personnel.</p>

            <section class="schedules-overview">
                <h2>Upcoming Schedules</h2>
                <p>Below is a list of upcoming duty schedules. You can view, edit, or update the schedule as needed.</p>

                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Personnel Name</th>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Sept 25, 2024</td>
                            <td>Morning</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Oct 1, 2024</td>
                            <td>Night</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Mike Johnson</td>
                            <td>Oct 3, 2024</td>
                            <td>Afternoon</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="update-schedule">
                <h2>Update Duty Schedule</h2>
                <p>Need to update the duty schedule? Fill in the details and submit the updated schedule.</p>
                <form action="<?php echo URLROOT; ?>/security/updateDutySchedule" method="POST">
                    <div class="form-group">
                        <label for="personnel_name">Personnel Name:</label>
                        <input type="text" id="personnel_name" name="personnel_name" required>
                    </div>
                    <div class="form-group">
                        <label for="duty_date">Duty Date:</label>
                        <input type="date" id="duty_date" name="duty_date" required>
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift:</label>
                        <select id="shift" name="shift" required>
                            <option value="morning">Morning</option>
                            <option value="afternoon">Afternoon</option>
                            <option value="night">Night</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-update">Update Schedule</button>
                </form>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
