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
        /* Dashboard Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .side-panel {
            width: 300px;
           
        }

        .main-content {
            flex-grow: 1;
            width:95%;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #34495e;
        }

        .section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dfe6e9;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        canvas {
            margin-top: 20px;
        }
        .export {
        display: inline-block;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: bold;
        color: black;
        background: linear-gradient(90deg, yellow, orange);
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
        const { jsPDF } = window.jspdf; // Access jsPDF from the global object
        const doc = new jsPDF();

        // Get the table element
        const table = document.getElementById(tableId);

        // Generate the table as PDF using autoTable
        doc.autoTable({
            html: table,
            theme: 'striped',
            styles: { cellPadding: 2, fontSize: 10 },
            margin: { top: 20 },
            headStyles: { fillColor: [52, 152, 219] }, // Blue color for header
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
