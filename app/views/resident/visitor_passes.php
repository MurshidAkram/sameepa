<!-- app/views/resident/visitor_passes.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/visitor_passes.css">
    <title>Manage Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <h1>Your Visitor Passes</h1>
            <p>Here you can view, create, update, or delete visitor passes for guests entering the community.</p>

            <section class="visitor-passes-overview">
                <h2>Active Visitor Passes</h2>
                <p>Below is a list of your active visitor passes. You can update or delete them as necessary.</p>

                <table class="visitor-passes-table">
                    <thead>
                        <tr>
                            <th>Visitor Name</th>
                            <th>Date of Visit</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Sept 18, 2024</td>
                            <td>2:00 PM - 4:00 PM</td>
                            <td>Active</td>
                            <td>
                                <a href="#">Update</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Sept 20, 2024</td>
                            <td>10:00 AM - 12:00 PM</td>
                            <td>Pending</td>
                            <td>
                                <a href="#">Update</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Michael Lee</td>
                            <td>Sept 25, 2024</td>
                            <td>5:00 PM - 7:00 PM</td>
                            <td>Expired</td>
                            <td>
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="create-visitor-pass">
                <h2>Create a New Visitor Pass</h2>
                <p>Need to create a visitor pass for a guest? Fill out the necessary details and get a new pass generated quickly!</p>
                <a href="<?php echo URLROOT; ?>/resident/create_visitor_pass" class="btn-create">Create Visitor Pass</a>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>