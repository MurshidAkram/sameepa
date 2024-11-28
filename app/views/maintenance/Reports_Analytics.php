<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Reports & Analytics | Maintenance Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- for export to pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #eef2f3, #ffffff);
            margin: 0;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            /* Use flexbox layout */
            gap: 10px;
            /* Small gap between the side panel and main content */
            width: 90%;
            /* Full width of the container */
            /* padding: 20px; */
        }

        .side-panel {
            width: 320px;
            /* Width of the side panel */
            background-color: #f4f4f4;
            /* Light background color */
            /* padding: 15px; */
            border-radius: 8px;
            /* Rounded corners (optional) */
        }

        /* Main content styling */
        .main-content {
            width: 100%;
            /* 95% width of the container */
            background-color: #fff;
            /* White background for main content */
            padding: 15px;
            border-radius: 8px;
            /* Rounded corners (optional) */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Optional shadow */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #800080;
        }


        .section {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .section h2 {
            color: #3f51b5;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        table th {
            background: linear-gradient(to right, #42a5f5, #1e88e5);
            color: #fff;
            padding: 15px;
            font-weight: bold;
            text-align: center;
        }

        th {
            background-color: #800080;
            color: #fff;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tbody tr:hover {
            background: #f1f7ff;
        }

        /* Export Button Styles */
        .export {
            display: inline-block;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: bold;
            color: black;
            background: linear-gradient(90deg, violet, #641975);
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(255, 117, 140, 0.5);

        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <div class="side-panel">
            <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>
        </div>

        <div class="main-content">
            <h1>Reports & Analytics</h1>

            <!-- Resident Feedback Analysis -->
            <section class="section">
                <h2>Resident Feedback Analysis</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Feedback</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-09-15</td>
                            <td>Quick response and professional service.</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>2024-09-18</td>
                            <td>Delay in repair but issue was resolved.</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>2024-09-20</td>
                            <td>Friendly staff and timely resolution.</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>2024-09-22</td>
                            <td>Issue was not fully resolved on first visit.</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>2024-09-25</td>
                            <td>Excellent service, very happy!</td>
                            <td>5</td>
                        </tr>
                    </tbody>
                </table>
                <canvas id="feedbackChart" width="400" height="200"></canvas>
                <button class='export' onclick="exportTableToPDF('feedbackTable', 'Resident Feedback Analysis')">Export to PDF</button>
            </section>

            <!-- Maintenance Frequency Analysis -->
            <section class="section">
                <h2>Maintenance Frequency Analysis</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Location</th>
                            <th>Equipment</th>
                            <th>No.of instances maintained</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Building 1</td>
                            <td>Elevator</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td>Building 2</td>
                            <td>HVAC System</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>Building 1</td>
                            <td>Fire Alarm System</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Building 4</td>
                            <td>Water Pump</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>Building 3</td>
                            <td>Lighting System</td>
                            <td>10</td>
                        </tr>

                    </tbody>
                </table>
                <canvas id="maintenanceChart" width="400" height="200"></canvas>
                <button class='export' onclick="exportTableToPDF('maintenanceTable', 'Maintenance Frequency Analysis')">Export to PDF</button>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Resident Feedback Chart
            const feedbackCtx = document.getElementById('feedbackChart').getContext('2d');
            const feedbackChart = new Chart(feedbackCtx, {
                type: 'bar',
                data: {
                    labels: ['2024-09-15', '2024-09-18', '2024-09-20', '2024-09-22', '2024-09-25'],
                    datasets: [{
                        label: 'Ratings',
                        data: [5, 3, 4, 2, 5],
                        backgroundColor: '#9B26B6',
                        borderColor: 'black',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Maintenance Frequency Chart
            const maintenanceCtx = document.getElementById('maintenanceChart').getContext('2d');
            const maintenanceChart = new Chart(maintenanceCtx, {
                type: 'bar',
                data: {
                    labels: ['Building 1', 'Building 2', 'Building 1', 'Building 4', 'Building 3'],
                    datasets: [{
                        label: 'No.of instances maintained',
                        data: [12, 8, 5, 7, 10],
                        backgroundColor: '#A629C2',
                        borderColor: 'black',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Export Table to PDF Function
            window.exportTableToPDF = (tableId, title) => {
                const {
                    jsPDF
                } = window.jspdf; // Access jsPDF from the global object
                const doc = new jsPDF();

                // Get the table element
                const table = document.getElementById(tableId);

                // Generate the table as PDF using autoTable
                doc.autoTable({
                    html: table,
                    theme: 'striped',
                    styles: {
                        cellPadding: 2,
                        fontSize: 10
                    },
                    margin: {
                        top: 20
                    },
                    headStyles: {
                        fillColor: [52, 152, 219]
                    }, // Blue color for header
                });

                // Add title to the PDF
                doc.text(title, 10, 10);

                // Save the PDF
                doc.save(`${title.replace(/\s+/g, '_')}.pdf`);
            };
        });
    </script>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>