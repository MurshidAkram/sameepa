<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Manage Duty Schedule | <?php echo SITENAME; ?></title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .dashboard-container {
            display: flex;
            justify-content: space-between;
        }

        main {
            padding: 20px;
            width: 70%;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Calendar View */
        .calendar-container {
            width: 100%;
            margin-top: 30px;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr); /* Seven columns for the days */
            gap: 10px;
            grid-auto-rows: 70px;
            font-size: 16px;
        }

        .calendar .day {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            border-radius: 4px;
            cursor: pointer;
            padding: 5px;
            transition: background-color 0.3s;
            min-height: 70px;
            position: relative;
        }

        .calendar .day:hover {
            background-color: #ddd;
        }

        /* Day Status Colors */
        .calendar .day.assigned {
            background-color: #4CAF50;
            color: white;
        }

        .calendar .day.completed {
            background-color: #2196F3;
            color: white;
        }

        .calendar .day.missed {
            background-color: #F44336;
            color: white;
        }

        .calendar .day.empty {
            background-color: #e0e0e0;
            color: #999;
        }

        .calendar .day-header {
            font-weight: bold;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        .calendar .officer-name {
            position: absolute;
            bottom: 5px;
            font-size: 12px;
            color: white;
        }

        .month-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* General Styling for form */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h2 {
            color: #4CAF50;
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }

        /* Form Container */
        .duty-schedule-form {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Form Group */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Input Placeholder */
        .form-group input::placeholder {
            color: #aaa;
        }

        /* Submit Button */
        .btn {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Hover Effect on Inputs */
        .form-group input:hover {
            border-color: #2196F3;
        }

        /* Responsive Design */
        @media screen and (max-width: 600px) {
            .duty-schedule-form {
                padding: 20px;
            }

            .btn {
                font-size: 16px;
                padding: 12px;
            }

            h2 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Duty Schedule</h2>

            <form method="POST" class="duty-schedule-form">
                <div class="form-group">
                    <label for="duty_officer">Duty Officer:</label>
                    <input type="text" id="duty_officer" name="duty_officer" required>
                </div>
                <div class="form-group">
                    <label for="duty_date">Duty Date:</label>
                    <input type="date" id="duty_date" name="duty_date" required>
                </div>
                <div class="form-group">
                    <label for="duty_shift">Shift Time:</label>
                    <input type="text" id="duty_shift" name="duty_shift" placeholder="e.g., 9 AM - 5 PM" required>
                </div>
                <button type="submit" class="btn">Save Schedule</button>
            </form>

            <!-- Calendar View -->
            <div class="calendar-container">
                <h3>Calendar View</h3>

                <!-- Month Navigation -->
                <div class="month-navigation">
                    <button onclick="navigateMonth(-1)">Previous</button>
                    <span id="current-month">November 2024</span>
                    <button onclick="navigateMonth(1)">Next</button>
                </div>

                <div class="calendar" id="calendar">
                    <!-- Days of the week -->
                    <div class="day-header">Sunday</div>
                    <div class="day-header">Monday</div>
                    <div class="day-header">Tuesday</div>
                    <div class="day-header">Wednesday</div>
                    <div class="day-header">Thursday</div>
                    <div class="day-header">Friday</div>
                    <div class="day-header">Saturday</div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        let currentMonth = new Date();
        
        // Example Officer List (you would likely get this dynamically from your backend)
        const officers = [
            'John Doe', 'Jane Smith', 'Mark Lee', 'Sara Khan', 'Tom White', 'Lucy Brown'
        ];

        // Navigate between months
        function navigateMonth(direction) {
            currentMonth.setMonth(currentMonth.getMonth() + direction);
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const month = monthNames[currentMonth.getMonth()];
            const year = currentMonth.getFullYear();
            document.getElementById('current-month').innerText = `${month} ${year}`;
            
            updateCalendar(month, year);
        }

        // Update Calendar Content
        function updateCalendar(month, year) {
            const firstDay = new Date(year, new Date(`${month} 1, ${year}`).getMonth(), 1).getDay();
            const numDays = new Date(year, new Date(`${month} 1, ${year}`).getMonth() + 1, 0).getDate();
            
            let calendarHTML = '';
            for (let i = 0; i < firstDay; i++) {
                calendarHTML += "<div class='day empty'></div>";
            }

            // Generate the calendar days
            for (let day = 1; day <= numDays; day++) {
                const officer = officers[day % officers.length]; // Simple officer assignment
                const status = day % 3 === 0 ? 'assigned' : (day % 3 === 1 ? 'completed' : 'missed');
                
                calendarHTML += `<div class="day ${status}">
                                    <span>${day}</span>
                                    <div class="officer-name">${officer}</div>
                                  </div>`;
            }

            document.getElementById('calendar').innerHTML = calendarHTML;
        }

        // Initialize the calendar with the current month
        updateCalendar(currentMonth.toLocaleString('default', { month: 'long' }), currentMonth.getFullYear());
    </script>
</body>

</html>
