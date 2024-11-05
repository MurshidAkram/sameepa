<!-- app/views/resident/events.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/forums.css"> <!-- Include the new styles here -->
    <title>Manage Forums | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main>
            <div class="header-container">
                <h1>Manage Forums</h1>
                <div class="button-container">
                    <a href="<?php echo URLROOT; ?>/admin/create_forum" class="btn-create">Create New Forums</a>
                </div>
            </div>
            <p>Welcome to the Forums Management page. Here, you can add, view, or remove forums.</p>

            <section class="events-overview">
                <!-- <h2>Upcoming Events</h2> -->
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>Forum Title</th>
                            <th>Posted by</th>
                            <th>Comments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Community BBQ</td>
                            <td>Jhon</td>
                            <td>12</td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/view_forum">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Monthly Book Club</td>
                            <td>Martin</td>
                            <td>25</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Yoga Class</td>
                            <td>Edward</td>
                            <td>9</td>
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