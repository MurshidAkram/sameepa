<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/exchange.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">

    <title>Report an Incident | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="exchange-main">
            <h1>Report an Incident</h1>
            <p>Help us maintain the safety of our community by reporting any incidents or concerns.</p>

            <div class="exchange-actions">
                <a href="<?php echo URLROOT; ?>/resident/reports" class="btn-my-listings">View Duty Schedule</a>
            </div>

            <div class="incident-report-form">
                <form id="residentIncidentForm" method="POST" action="<?php echo URLROOT; ?>/incidents/submit">
                    <div class="form-group">
                        <label for="incident_type">Incident Type</label>
                        <select id="incident_type" name="incident_type" required>
                            <option value="">Select Incident Type</option>
                            <option value="safety">Safety Concern</option>
                            <option value="theft">Theft</option>
                            <option value="vandalism">Vandalism</option>
                            <option value="disturbance">Disturbance</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="incident_location">Location</label>
                        <input type="text" id="incident_location" name="incident_location" placeholder="Where did the incident occur?" required>
                    </div>

                    <div class="form-group">
                        <label for="incident_description">Description</label>
                        <textarea id="incident_description" name="incident_description" placeholder="Provide details about the incident" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="incident_datetime">Date and Time</label>
                        <input type="datetime-local" id="incident_datetime" name="incident_datetime" required>
                    </div>

                    <div class="form-group">
                        <label for="reporter_contact">Your Contact Information (Optional)</label>
                        <input type="tel" id="reporter_contact" name="reporter_contact" placeholder="Phone number">
                    </div>

                    <div class="form-group">
                        <label for="anonymity">
                            <input type="checkbox" id="anonymity" name="anonymity" value="1">
                            Submit anonymously
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-create-listing">Submit Incident Report</button>
                        <button type="reset" class="btn-my-listings">Reset Form</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        document.getElementById('anonymity').addEventListener('change', function() {
            const contactField = document.getElementById('reporter_contact');
            contactField.disabled = this.checked;
            if (this.checked) {
                contactField.value = '';
            }
        });

        document.getElementById('residentIncidentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add client-side validation or AJAX submission logic here
            alert('Incident report submitted successfully!');
            this.reset();
        });
    </script>
</body>

</html>