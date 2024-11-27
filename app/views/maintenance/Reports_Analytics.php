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
            min-height: 100vh;
            padding: 20px;
            gap: 20px;
        }

        .side-panel {
            flex-shrink: 0;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Headers */
        h1 {
            margin: 0 0 10px;
            font-size: 2rem;
            color: #3f51b5;
        }

        /* Section Styles */
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

        table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            color: #555;
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
            padding: 10px 15px;
            background: #3f51b5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .export:hover {
            background: #303f9f;
        }

        /* Canvas Styles */
        canvas {
            margin-top: 20px;
            max-width: 100%;
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
                            <th>Times Serviced</th>
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
                        backgroundColor: '#3498db',
                        borderColor: '#2980b9',
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
                        label: 'Times Serviced',
                        data: [12, 8, 5, 7, 10],
                        backgroundColor: '#e74c3c',
                        borderColor: '#c0392b',
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