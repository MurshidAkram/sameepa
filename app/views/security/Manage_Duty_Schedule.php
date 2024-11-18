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
    background-color: #f9f9f9;
}

/* Buttons */
.btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #45a049;
}

/* Dashboard Container */
.dashboard-container {
    display: flex;
}

/* Main Content */
main {
    padding: 20px;
    width: 100%;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

table th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #ddd;
}

/* Calendar View */
.calendar-container {
    margin-top: 30px;
}

.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
    grid-auto-rows: 70px;
    font-size: 16px;
    margin-top: 20px;
}

.calendar .day {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #f4f4f4;
    border-radius: 5px;
    position: relative;
    padding: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.calendar .day:hover {
    background-color: #ddd;
    transform: scale(1.05);
}

.calendar .day-header {
    font-weight: bold;
    text-align: center;
    background-color: #4CAF50;
    color: white;
    padding: 5px;
    border-radius: 5px;
}

.calendar .day.empty {
    background-color: #e0e0e0;
    color: #999;
    pointer-events: none;
}

.calendar .day div {
    font-size: 12px;
    font-weight: bold;
    color: white;
}

/* Overlay Form */
#duty-form-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

#duty-form {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: left;
}

#duty-form h3 {
    color: #4CAF50;
    text-align: center;
    margin-bottom: 20px;
}

#duty-form .form-group {
    margin-bottom: 15px;
}

#duty-form label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    color: #333;
}

#duty-form input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 2px solid #ddd;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

#duty-form input:focus {
    border-color: #4CAF50;
    outline: none;
}

/* Month Navigation */
.month-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.month-navigation button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.month-navigation button:hover {
    background-color: #45a049;
}

    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Duty Schedule</h2>

            <!-- Create Duty Button -->
            <button id="create-duty-btn" class="btn">Create Duty</button>

            <!-- Today's Duty Schedule -->
            <h3>Today's Duty Schedule</h3>
            <table border="1" id="duty-schedule-table">
                <thead>
                    <tr>
                        <th>Duty Officer ID</th>
                        <th>Officer Name</th>
                        <th>Shift</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Placeholder for dynamically added rows -->
                </tbody>
            </table>

            <!-- Calendar View -->
            <div class="calendar-container">
                <h3>Calendar View</h3>

                <!-- Month Navigation -->
                <div class="month-navigation">
                    <button onclick="navigateMonth(-1)">Previous</button>
                    <span id="current-month"></span>
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

    <!-- Overlay Form -->
    <div id="duty-form-overlay" style="display: none;">
        <form id="duty-form">
            <h3>Create or Edit Duty Schedule</h3>
            <div class="form-group">
                <label for="duty_officer_id">Duty Officer ID:</label>
                <input type="text" id="duty_officer_id" name="duty_officer_id" required>
            </div>
            <div class="form-group">
                <label for="duty_officer">Duty Officer Name:</label>
                <input type="text" id="duty_officer" name="duty_officer" required>
            </div>
            <div class="form-group">
                <label for="duty_date">Duty Date:</label>
                <input type="date" id="duty_date" name="duty_date" required>
            </div>
            <div class="form-group">
                <label for="duty_shift">Shift Time:</label>
                <select id="duty_shift" name="duty_shift" required>
                    <option value="8-12">8 AM - 12 PM</option>
                    <option value="8-16">8 AM - 4 PM</option>
                    <option value="16-20">4 PM - 8 PM</option>
                    <option value="16-24">4 PM - 12 AM</option>
                    <option value="24-8">12 AM - 8 AM</option>
                </select>
            </div>
            <button type="submit" class="btn">Save Schedule</button>
            <button type="button" id="cancel-btn" class="btn">Cancel</button>
        </form>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
    let currentMonth = new Date();
    const officers = [
        { id: '001', name: 'John Doe', color: '#4CAF50' },
        { id: '002', name: 'Jane Smith', color: '#2196F3' },
        { id: '003', name: 'Mark Lee', color: '#F44336' },
        { id: '004', name: 'Emma Brown', color: '#FF9800' },
        { id: '005', name: 'Alice White', color: '#9C27B0' },
    ];

    function populateSchedule() {
        const table = document.getElementById('duty-schedule-table').getElementsByTagName('tbody')[0];
        table.innerHTML = ''; // Clear existing rows

        const calendarDays = document.querySelectorAll('.calendar .day:not(.empty)');
        calendarDays.forEach((day) => {
            day.style.backgroundColor = '';
            day.innerHTML = day.textContent.trim(); // Reset day square
        });

        officers.forEach((officer, index) => {
            const date = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), index + 1);
            const shift = ['8-12', '8-16', '16-20', '16-24', '24-8'][index % 5];

            const row = table.insertRow();
            row.innerHTML = `
                <td>${officer.id}</td>
                <td>${officer.name}</td>
                <td>${shift}</td>
                <td>
                    <button onclick="editDuty(this)">Edit</button>
                    <button onclick="confirmDelete(this)">Delete</button>
                </td>
            `;

            const dayElement = Array.from(document.getElementsByClassName('day')).find(
                (day) => day.textContent.trim() == date.getDate()
            );
            if (dayElement) {
                const officerBlock = document.createElement('div');
                officerBlock.textContent = officer.name;
                officerBlock.style.backgroundColor = officer.color;
                officerBlock.style.color = '#fff';
                officerBlock.style.margin = '2px 0';
                officerBlock.style.padding = '2px';
                officerBlock.style.borderRadius = '4px';
                officerBlock.style.fontSize = '0.8em';
                dayElement.appendChild(officerBlock);
            }
        });
    }

    function confirmDelete(button) {
        if (confirm('Are you sure you want to delete this schedule?')) {
            button.parentElement.parentElement.remove();
            populateSchedule(); // Refresh the calendar and table
        }
    }

    function editDuty(button) {
        const row = button.parentElement.parentElement;
        document.getElementById('duty_officer_id').value = row.cells[0].textContent;
        document.getElementById('duty_officer').value = row.cells[1].textContent;
        document.getElementById('duty_shift').value = row.cells[2].textContent;
        document.getElementById('duty_date').value = ''; // Placeholder; requires a real date input
        document.getElementById('duty-form-overlay').style.display = 'block';
    }

    function updateCalendar(month, year) {
        const firstDay = new Date(year, month, 1).getDay();
        const numDays = new Date(year, month + 1, 0).getDate();

        let calendarHTML = '';
        for (let i = 0; i < firstDay; i++) {
            calendarHTML += "<div class='day empty'></div>";
        }

        for (let day = 1; day <= numDays; day++) {
            calendarHTML += `<div class="day">${day}</div>`;
        }

        document.getElementById('calendar').innerHTML = calendarHTML;
        document.getElementById('current-month').textContent = new Date(year, month).toLocaleString('default', {
            month: 'long',
            year: 'numeric',
        });

        populateSchedule(); // Populate duty schedules dynamically
    }

    // Initialize Calendar on Load
    updateCalendar(currentMonth.getMonth(), currentMonth.getFullYear());
</script>

</body>

</html>
