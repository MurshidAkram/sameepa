<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Suspicious Activities | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Suspicious Activities</h1>

            <!-- High Priority Incidents Section -->
            <section class="high-priority-incidents">
                <h2>High Priority Incidents</h2>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Incident ID</th>
                                <th>Reported By</th>
                                <th>Date & Time</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>INC003</td>
                                <td>Security Officer</td>
                                <td>2024-09-15 12:30 PM</td>
                                <td>Attempted break-in detected</td>
                                <td>Critical</td>
                            </tr>
                            <tr>
                                <td>INC004</td>
                                <td>Receptionist</td>
                                <td>2024-09-15 01:00 PM</td>
                                <td>Suspicious behavior in parking lot</td>
                                <td>Urgent</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Large Table Card Section -->
            <section class="table-card">
                <h2>Recent Suspicious Activity Reports</h2>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Incident ID</th>
                                <th>Reported By</th>
                                <th>Date & Time</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>INC001</td>
                                <td>Security Officer</td>
                                <td>2024-09-15 10:30 AM</td>
                                <td>Unidentified person near entrance</td>
                                <td>Under Investigation</td>
                            </tr>
                            <tr>
                                <td>INC002</td>
                                <td>Receptionist</td>
                                <td>2024-09-15 11:00 AM</td>
                                <td>Suspicious package in lobby</td>
                                <td>Resolved</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Resolved Incidents Section -->
            <section class="resolved-incidents">
                <h2>Resolved Incidents</h2>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Incident ID</th>
                                <th>Reported By</th>
                                <th>Date & Time</th>
                                <th>Description</th>
                                <th>Resolution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>INC005</td>
                                <td>Security Officer</td>
                                <td>2024-09-14 03:00 PM</td>
                                <td>Suspicious vehicle parked overnight</td>
                                <td>Vehicle towed</td>
                            </tr>
                            <tr>
                                <td>INC006</td>
                                <td>Receptionist</td>
                                <td>2024-09-14 04:30 PM</td>
                                <td>Vandalism in the restroom</td>
                                <td>Restroom repaired</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Existing Content Section -->
            <section class="suspicious-list">
                <h2>Reported Incidents</h2>
                <ul>
                    <!-- Example dynamic content; replace with actual data -->
                    <li><strong>Incident #001:</strong> Unidentified person loitering near the entrance.</li>
                    <li><strong>Incident #002:</strong> Suspicious package left unattended near the lobby.</li>
                </ul>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
