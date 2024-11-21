<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/fullcalendar.min.css">
    <title>Update Duty Schedule | <?php echo SITENAME; ?></title>
    <style>
        /* Custom styles for duty schedule page */
        .calendar-container {
            margin-top: 20px;
        }
        .timeline-container {
            margin-top: 20px;
        }
        .btn-update, .btn-add, .btn-swap {
            margin: 5px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-update:hover, .btn-add:hover, .btn-swap:hover {
            background-color: #45a049;
        }
        .timeline-item {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Update Duty Schedule</h1>
            <form action="<?php echo URLROOT; ?>/security/update_duty_schedule" method="POST">
                <div class="form-group">
                    <label for="schedule-id">Schedule ID:</label>
                    <input type="text" id="schedule-id" name="schedule_id" required>
                </div>
                <div class="form-group">
                    <label for="new-schedule">New Schedule:</label>
                    <input type="datetime-local" id="new-schedule" name="new_schedule" required>
                </div>
                <button type="submit" class="btn-update">Update Schedule</button>
            </form>

            <!-- Duty Schedule View -->
            <section class="calendar-container">
                <h2>Duty Schedule Overview</h2>
                <div id="calendar"></div>
                <button class="btn-add">Add Shift</button>
                <button class="btn-swap">Swap Shifts</button>
            </section>

            <section class="timeline-container">
                <h2>Shift Timeline</h2>
                <div id="timeline">
                    <!-- Example timeline items; replace with actual data -->
                    <div class="timeline-item">
                        <h3>Shift ID: S001</h3>
                        <p>Officer: Officer A</p>
                        <p>Shift Time: 2024-09-15 08:00 - 16:00</p>
                        <p>Status: Completed</p>
                    </div>
                    <div class="timeline-item">
                        <h3>Shift ID: S002</h3>
                        <p>Officer: Officer B</p>
                        <p>Shift Time: 2024-09-15 16:00 - 00:00</p>
                        <p>Status: In Progress</p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- JavaScript for FullCalendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/fullcalendar.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    // Example event data; replace with actual data
                    { title: 'Shift A', start: '2024-09-15T08:00:00', end: '2024-09-15T16:00:00' },
                    { title: 'Shift B', start: '2024-09-15T16:00:00', end: '2024-09-16T00:00:00' }
                ]
            });
            calendar.render();
        });
    </script>
</body>

</html>
