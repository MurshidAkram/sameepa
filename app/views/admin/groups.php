<!-- app/views/resident/events.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/groups.css"> <!-- Include the new styles here -->
    <title>Manage Groups | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main>
            <div class="header-container">
                <h1>Manage Groups</h1>
                <div class="button-container">
                    <a href="<?php echo URLROOT; ?>/admin/create_group" class="btn-create">Create New Groups</a>
                </div>
            </div>
            <p>Welcome to the Groups Management page. Here, you can add, view, or remove groups.</p>

            <section class="events-overview">
                <!-- <h2>Upcoming Events</h2> -->
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>Group Name</th>
                            <th>Created by</th>
                            <th>Number of members</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Book Club</td>
                            <td>Steve</td>
                            <td>15</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Cooking Club</td>
                            <td>Chris</td>
                            <td>20</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Fitness Enthusiasts</td>
                            <td>Tony</td>
                            <td>12</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>