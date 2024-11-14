<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css' rel='stylesheet' />
    <title>Team Scheduling | <?php echo SITENAME; ?></title>

    <style>
        /* Internal CSS for Team Scheduling */

        .team-profile, .shift-allocation, .availability, .overtime-tracking, .performance-metrics {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            padding: 15px;
            margin-bottom: 20px;
        }

        h2, h3 {
            color: #2c3e50;
        }

        /* Profile and Metrics */
        .team-profile-card {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e0e0e0;
        }

        .profile-details {
            font-size: 0.9em;
        }

        /* Shift Metrics */
        .shift-allocation table, .performance-metrics table {
            width: 100%;
            border-collapse: collapse;
        }

        .shift-allocation th, .shift-allocation td, .performance-metrics th, .performance-metrics td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        /* Alerts */
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Side Panel -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <!-- Main Content -->
        <main>
            <h1>Team Scheduling</h1>

            <!-- Comprehensive Team Profiles -->
            <section class="team-profile">
                <h2>Team Profiles</h2>
                <div class="team-profile-card">
                    <div class="profile-img"></div>
                    <div class="profile-details">
                        <p><strong>Name:</strong> John Doe</p>
                        <p><strong>Specialization:</strong> HVAC</p>
                        <p><strong>Experience:</strong> 8 years</p>
                        <p><strong>Certifications:</strong> HVAC Pro, Safety</p>
                    </div>
                </div>
                <div class="team-profile-card">
                    <div class="profile-img"></div>
                    <div class="profile-details">
                        <p><strong>Name:</strong> Jane Smith</p>
                        <p><strong>Specialization:</strong> Electrical</p>
                        <p><strong>Experience:</strong> 5 years</p>
                        <p><strong>Certifications:</strong> Electrical Safety, Emergency Response</p>
                    </div>
                </div>
            </section>

            <!-- Shift Allocation Metrics -->
            <section class="shift-allocation">
                <h2>Shift Allocation Metrics</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Team Member</th>
                            <th>Current Workload</th>
                            <th>Tasks Completed</th>
                            <th>Performance Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>80%</td>
                            <td>15</td>
                            <td>4.5/5</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>60%</td>
                            <td>20</td>
                            <td>4.8/5</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Availability Management -->
            <section class="availability">
                <h2>Availability Management</h2>
                <div id='calendar'></div>
            </section>

            <!-- Overtime Tracking -->
            <section class="overtime-tracking">
                <h2>Overtime Tracking</h2>
                <p><strong>John Doe:</strong> 5 hours this week</p>
                <p><strong>Jane Smith:</strong> 3 hours this week</p>
            </section>

            <!-- Performance Metrics -->
            <section class="performance-metrics">
                <h2>Performance Metrics</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Team Member</th>
                            <th>Avg. Completion Time (hrs)</th>
                            <th>Resident Feedback</th>
                            <th>Task Completion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>2.3</td>
                            <td>4.7/5</td>
                            <td>92%</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>1.8</td>
                            <td>4.9/5</td>
                            <td>96%</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Scheduling Alerts -->
            <section class="alerts">
                <h2>Scheduling Alerts</h2>
                <div class="alert">
                    <p>⚠️ Alert: Shift overlap detected between John Doe and Jane Smith on 2024-09-20.</p>
                    <p>⚠️ Alert: Unassigned critical tasks scheduled for 2024-09-22.</p>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'John Doe - HVAC maintenance',
                        start: '2024-09-20T10:00:00',
                        end: '2024-09-20T12:00:00',
                        backgroundColor: '#3498db',
                    },
                    {
                        title: 'Jane Smith - Electrical repair',
                        start: '2024-09-20T10:30:00',
                        end: '2024-09-20T11:30:00',
                        backgroundColor: '#e74c3c',
                    }
                ]
            });

            calendar.render();
        });
    </script>
</body>

</html>
