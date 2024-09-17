<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Manage User Incident Reports | <?php echo SITENAME; ?></title>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Upload feature styles */
        .upload-section {
            margin-top: 20px;
        }
        .upload-btn {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .upload-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Manage User Incident Reports</h1>

            <!-- Incident Report Form -->
            <form action="<?php echo URLROOT; ?>/security/manage_user_incident_report" method="POST">
                <div class="form-group">
                    <label for="incident-id">Incident ID:</label>
                    <input type="text" id="incident-id" name="incident_id" required>
                </div>
                <div class="form-group">
                    <label for="report-details">Incident Details:</label>
                    <textarea id="report-details" name="details" required></textarea>
                </div>
                <button type="submit" class="btn-report">Submit Report</button>
            </form>

            <!-- Incident Report Table -->
            <section class="incident-reports">
                <h2>Incident Reports</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>Category</th>
                            <th>Officer Assigned</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example dynamic content; replace with actual data -->
                        <tr data-id="IR001">
                            <td>IR001</td>
                            <td>Security Breach</td>
                            <td>Officer A</td>
                            <td>In Progress</td>
                            <td>
                                <button class="btn-view">View Details</button>
                                <button class="btn-resolve">Resolve</button>
                                <button class="btn-update">Update Status</button>
                                <button class="btn-assign">Assign to Officer</button>
                            </td>
                        </tr>
                        <tr data-id="IR002">
                            <td>IR002</td>
                            <td>Theft</td>
                            <td>Officer B</td>
                            <td>Resolved</td>
                            <td>
                                <button class="btn-view">View Details</button>
                                <button class="btn-resolve">Resolve</button>
                                <button class="btn-update">Update Status</button>
                                <button class="btn-assign">Assign to Officer</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </section>

            <!-- Upload Feature -->
            <section class="upload-section">
                <h2>Upload Evidence</h2>
                <form action="<?php echo URLROOT; ?>/security/upload_evidence" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="evidence-file">Choose file:</label>
                        <input type="file" id="evidence-file" name="evidence_file" accept="image/*,video/*" required>
                    </div>
                    <button type="submit" class="upload-btn">Upload</button>
                </form>
            </section>
        </main>
    </div>

    <!-- Modal for Incident Details -->
    <div id="incident-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Incident Details</h2>
            <div id="incident-details">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // JavaScript for opening and closing the modal
        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', function () {
                var incidentId = this.closest('tr').dataset.id;
                // Fetch incident details (this is just a placeholder; implement as needed)
                document.getElementById('incident-details').innerHTML = 'Loading details for incident ' + incidentId + '...';
                var modal = document.getElementById('incident-modal');
                modal.style.display = 'block';
            });
        });

        document.querySelector('.close').addEventListener('click', function () {
            document.getElementById('incident-modal').style.display = 'none';
        });

        window.onclick = function (event) {
            if (event.target == document.getElementById('incident-modal')) {
                document.getElementById('incident-modal').style.display = 'none';
            }
        }
    </script>
</body>

</html>
