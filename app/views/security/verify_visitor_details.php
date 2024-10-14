<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Verify Visitor Details | <?php echo SITENAME; ?></title>
    <style>
        /* Custom styles for verification page */
        .table-container {
            margin-top: 20px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table-container th {
            background-color: #f4f4f4;
        }
        .btn-verify {
            margin-top: 20px;
        }
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
        .camera-feed {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Verify Visitor Details</h1>
            
            <!-- Pending Visitor List -->
            <section class="table-container">
                <h2>Pending Visitor List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Visitor ID</th>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Reason</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example rows; replace with actual data -->
                        <tr>
                            <td>V001</td>
                            <td>John Doe</td>
                            <td>2024-09-15 10:00</td>
                            <td>Meeting</td>
                            <td><button class="btn-verify" onclick="openModal('V001')">Verify</button></td>
                        </tr>
                        <tr>
                            <td>V002</td>
                            <td>Jane Smith</td>
                            <td>2024-09-15 11:00</td>
                            <td>Delivery</td>
                            <td><button class="btn-verify" onclick="openModal('V002')">Verify</button></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Visitor Verification Modal -->
            <div id="verificationModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Visitor Details</h2>
                    <div id="visitor-details">
                        <!-- Visitor details will be populated here by JavaScript -->
                    </div>
                    <button class="btn-verify" onclick="approveVisitor()">Approve</button>
                    <button class="btn-verify" onclick="rejectVisitor()">Reject</button>
                </div>
            </div>

            <!-- Real-time Camera Feed -->
            <section class="camera-feed">
                <h2>Real-time Camera Feed (Optional)</h2>
                <!-- Placeholder for real-time camera feed -->
                <div id="cameraFeed">
                    <p>Camera feed not implemented yet.</p>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- JavaScript for modal functionality -->
    <script>
        function openModal(visitorId) {
            // Populate modal with visitor details
            document.getElementById('visitor-details').innerHTML = `
                <p>Visitor ID: ${visitorId}</p>
                <p>Name: [Visitor Name]</p>
                <p>Time: [Visitor Time]</p>
                <p>Reason: [Visitor Reason]</p>
                <p>Additional details...</p>
            `;
            document.getElementById('verificationModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('verificationModal').style.display = "none";
        }

        function approveVisitor() {
            alert('Visitor Approved');
            closeModal();
            // Implement approval logic here
        }

        function rejectVisitor() {
            alert('Visitor Rejected');
            closeModal();
            // Implement rejection logic here
        }
    </script>
</body>

</html>
