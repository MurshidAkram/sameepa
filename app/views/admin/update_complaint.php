<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/update_complaint.css">
    <title>Update Complaint | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
            <main class="complaint-update-dashboard">
                <a href="<?php echo URLROOT; ?>/admin/view_complaint_history" class="btn-back">Back</a>
                <h1>Update Complaint</h1>
            <section class="complaint-details">
                <table class="complaint-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Complaint ID</td>
                            <td>#12345</td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>Noise Complaint</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>Excessive noise from unit 203 during quiet hours</td>
                        </tr>
                        <tr>
                            <td>Submitted By</td>
                            <td>John Smith</td>
                        </tr>
                        <tr>
                            <td>Submission Date</td>
                            <td>2023-05-15</td>
                        </tr>
                        <tr>
                            <td>Priority</td>
                            <td>High</td>
                        </tr>
                        <tr>
                            <td>Action Taken</td>
                            <td>
                                <textarea name="action_taken" id="action_taken" class="update-field">Warning issued to resident</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <select name="status" id="status" class="update-field">
                                    <option value="Pending">Pending</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Resolved" selected>Resolved</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn-submit">Update Complaint</button>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
