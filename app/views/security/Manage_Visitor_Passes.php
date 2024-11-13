<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Visitor_Passes.css">
    <title>Manage Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<body>

<style>




</style>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Visitor Pass Management</h2>

            <div class="visitor-pass-container">
                <!-- Create New Visitor Pass Form -->
                <div class="new-pass-form">
                    <h2>Create New Visitor Pass</h2>
                    <form action="<?php echo URLROOT; ?>/security/Manage_Visitor_Passes" method="POST">
                        <div class="form-group">
                            <label for="visitorName">Visitor Name:</label>
                            <input type="text" id="visitorName" name="visitorName" required>
                        </div>
                        <div class="form-group">
                            <label for="visitorCount">Number of Visitors:</label>
                            <input type="number" id="visitorCount" name="visitorCount" min="1" required>
                        </div>
                        <!-- Resident Name with Search Feature -->
                        <div class="form-group">
                            <label for="residentName">Resident Name to Meet:</label>
                            <input type="text" id="residentName" name="residentName" required>
                        </div>
                        <div class="form-group">
                            <label for="visitDate">Visit Date:</label>
                            <input type="date" id="visitDate" name="visitDate" required>
                        </div>
                        <div class="form-group">
                            <label for="visitTime">Visit Time:</label>
                            <input type="time" id="visitTime" name="visitTime" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Expected Duration (hours):</label>
                            <input type="number" id="duration" name="duration" min="1" max="24" required>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Purpose of Visit:</label>
                            <textarea id="purpose" name="purpose" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Create Visitor Pass</button>
                    </form>
                </div>

                <!-- Current Visitor Passes -->
                <section id="current-passes">
                    <h3>Today’s Visitor Passes</h3>
                    <input type="text" placeholder="Search by visitor name, resident name, or visit time" id="searchTodayPass">
                    <table class="pass-table">
                        <thead>
                            <tr>
                                <th>Pass ID</th>
                                <th>Visitor Name</th>
                                <th>Number of Visitors</th>
                                <th>Resident Name</th>
                                <th>Visit Time</th>
                               
                            </tr>
                        </thead>
                        <tbody id="todayPasses">
                            <?php foreach ($data['activePasses'] as $pass) : ?>
                                <tr>
                                    <td><?php echo $pass->id; ?></td>
                                    <td><?php echo $pass->visitor_name; ?></td>
                                    <td><?php echo $pass->visitor_count; ?></td>
                                    <td><?php echo $pass->resident_name; ?></td>
                                    <td><?php echo $pass->visit_time; ?></td>
                                  
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

                <!-- Visitor Pass History -->
                <section id="pass-history">
                    <h3>Visitor Pass History</h3>
                    <input type="text" placeholder="Search by visitor name, resident name, visit date, or time" id="searchHistoryPass">
                    <table class="pass-table">
                        <thead>
                            <tr>
                                <th>Pass ID</th>
                                <th>Visitor Name</th>
                                <th>Number of Visitors</th>
                                <th>Resident Name</th>
                                <th>Visit Time</th>
                                <th>Visit Date</th>
                               
                            </tr>
                        </thead>
                        <tbody id="historyPasses">
                            <?php foreach ($data['passHistory'] as $pass) : ?>
                                <tr>
                                    <td><?php echo $pass->id; ?></td>
                                    <td><?php echo $pass->visitor_name; ?></td>
                                    <td><?php echo $pass->visitor_count; ?></td>
                                    <td><?php echo $pass->resident_name; ?></td>
                                    <td><?php echo $pass->visit_time; ?></td>
                                    <td><?php echo $pass->visit_date; ?></td>
                                   
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>