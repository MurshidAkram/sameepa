
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/announcements.css">
    <title>Manage Announcements | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
          <main>
              <div class="header-container">
                  <h1>Manage Announcements</h1>
                  <a href="#" class="btn btn-history">View Announcements History</a>
              </div>
              <table class="announcements-table">
                    <tr>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Community Meeting Next Week</td>
                        <td>
                            <a href="#">View</a> |
                            <a href="#" class="btn btn-edit">Edit</a> |
                            <a href="#" class="btn btn-remove">Remove</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Pool Maintenance Schedule</td>
                        <td>
                            <a href="#" class="btn btn-view">View</a> |
                            <a href="#" class="btn btn-edit">Edit</a> |
                            <a href="#" class="btn btn-remove">Remove</a>
                        </td>
                    </tr>
                    <tr>
                        <td>New Recycling Guidelines</td>
                        <td>
                            <a href="#" class="btn btn-view">View</a> |
                            <a href="#" class="btn btn-edit">Edit</a> |
                            <a href="#" class="btn btn-remove">Remove</a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <section class="create-announcement">
                <h2>Create a New Announcement</h2>
                <p>Want to notify a annoouncement ? </p>
                <a href="<?php echo URLROOT; ?>/resident/create_event" class="btn-create">Create Event</a>
            </section>

        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
