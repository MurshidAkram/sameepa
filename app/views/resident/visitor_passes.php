<!-- app/views/resident/visitor_passes.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/visitor_passes.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">


    <title>Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="visitor-passes-main">
            <h1>Visitor Pass Management</h1>
            <p>Create new visitor passes or manage your existing passes.</p>

            <div class="visitor-pass-container">
                <div class="new-pass-form">
                    <h2>Create New Visitor Pass</h2>
                    <form id="visitorPassForm">
                        <div class="form-group">
                            <label for="visitorName">Visitor Name:</label>
                            <input type="text" id="visitorName" name="visitorName" required>
                        </div>
                        <div class="form-group">
                            <label for="visitorCount">Number of Visitors:</label>
                            <input type="number" id="visitorCount" name="visitorCount" min="1" required>
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

                <div class="pass-history">
                    <h2>Your Visitor Pass History</h2>
                    <div id="passList" class="pass-list"></div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal for editing visitor passes -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Visitor Pass</h2>
            <form id="editForm">
                <input type="hidden" id="editId">
                <div class="form-group">
                    <label for="editVisitorName">Visitor Name:</label>
                    <input type="text" id="editVisitorName" name="editVisitorName" required>
                </div>
                <div class="form-group">
                    <label for="editVisitorCount">Number of Visitors:</label>
                    <input type="number" id="editVisitorCount" name="editVisitorCount" min="1" required>
                </div>
                <div class="form-group">
                    <label for="editVisitDate">Visit Date:</label>
                    <input type="date" id="editVisitDate" name="editVisitDate" required>
                </div>
                <div class="form-group">
                    <label for="editVisitTime">Visit Time:</label>
                    <input type="time" id="editVisitTime" name="editVisitTime" required>
                </div>
                <div class="form-group">
                    <label for="editDuration">Expected Duration (hours):</label>
                    <input type="number" id="editDuration" name="editDuration" min="1" max="24" required>
                </div>
                <div class="form-group">
                    <label for="editPurpose">Purpose of Visit:</label>
                    <textarea id="editPurpose" name="editPurpose" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Update Visitor Pass</button>
            </form>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script src="<?php echo URLROOT; ?>/js/visitor_passes.js"></script>
</body>

</html>