<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/request.css">
    <title>Service Requests | <?php echo SITENAME; ?></title>
    
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

        <main>
            <h1>Service Requests</h1>
            <section class="dashboard-content">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example row -->
                        <tr>
                            <td>Request Title 1</td>
                            <td>Type A</td>
                            <td>$100</td>
                            <td>2024-09-15</td>
                            <td>10:30 AM</td>
                            <td>$100</td>
                            <td>
                                <button class="btn accept">Accept</button>
                                <button class="btn reject">Reject</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>



