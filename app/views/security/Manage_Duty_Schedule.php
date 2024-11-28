<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Security Duty Schedule</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: white;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        footer {
            background-color: #2d3436;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            font-size: 14px;
        }

        .content {
            display: flex;
            flex-grow: 1;
            flex-direction: row;
            margin: 0;
        }

        .side-panel {
            width: 350px;
            background-color: white;
            color: #800080;
            padding-left: 100px;
            padding-top: 20px;
            box-sizing: border-box;
            flex-shrink: 0;
            height: auto;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        h1 {
            text-align: center;
            color: #800080;
            margin: 0;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #800080;
            color: white;
        }

        td {
            background-color: #f7f7f7;
        }

        button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn{
            width: 25%;
    padding: 15px;
    background-color: #336699;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
        }

        .btn-edit {
            background-color: #ffa502;
            color: white;
        }

        .btn-delete {
            background-color: #d63031;
            color: white;
        }

        .btn-edit:hover {
            background-color: #e17e01;
        }

        .btn-delete:hover {
            background-color: #c62828;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 40%;
            text-align: center;
        }

        .modal-content input, .modal-content select {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-content button {
            width: 45%;
            margin: 10px;
        }

        .btn-cancel {
            justify-content: space-between;
            background-color: #636e72;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #555;
        }

        
        /* Calendar Container css*/
.calendar-container {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

h3 {
    font-size: 1.8em;
    color: #800080;
    margin-bottom: 15px;
    text-align: center;
}

/* Month Navigation */
.month-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.month-navigation button {
    padding: 10px 20px;
    background-color: #4A90E2;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
    transition: background-color 0.5s ease;
}

.month-navigation button:hover {
    background-color: #357ABD;
}

#current-month {
    font-size: 1.2em;
    font-weight: bold;
    color: #333;
}

/* Calendar Grid */
.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    grid-gap: 5px;
    padding: 10px;
    text-align: center;
    font-size: 1.1em;
}

/* Days of the Week Header */
.day-header {
    font-weight: bold;
    color: #4A90E2;
    padding: 10px;
}

/* Day Cells */
.day {
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 6px;
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.day:hover {
    background-color: #e0f2ff;
}

.day.empty {
    visibility: hidden;
}

/* Officer Shifts within each day */
.day div {
    margin-top: 5px;
    font-size: 0.85em;
    border-radius: 4px;
    padding: 5px;
    color: #fff;
    background-color: #7f8c8d;
    text-align: left;
}

/* Calendar Day Cell: If day has shifts assigned */
.day:not(.empty) {
    position: relative;
}

.day div {
    position: absolute;
    bottom: 5px;
    left: 5px;
    right: 5px;
}

/* Officer Shift Color Indicator */
.day div {
    font-size: 0.9em;
    padding: 4px 8px;
    background-color: #4A90E2;
    color: #fff;
    border-radius: 6px;
}

/* Add custom colors to shifts */
.day div:nth-child(1) {
    background-color: #4CAF50; /* Green */
}

.day div:nth-child(2) {
    background-color: #2196F3; /* Blue */
}

.day div:nth-child(3) {
    background-color: #F44336; /* Red */
}

.day div:nth-child(4) {
    background-color: #FF9800; /* Orange */
}

.day div:nth-child(5) {
    background-color: #9C27B0; /* Purple */
}
.today{
    padding-top: 30px;
    color: #800080;
    font-size: 30px;
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <header>
        <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    </header>

    <!-- Content Section -->
    <div class="content">
        <!-- Side Panel Section -->
        <div class="side-panel">
            <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>
        </div>

        <!-- Main Content Section -->
        <div class="container">
            <h1 >Duty Schedule</h1>

            <button class="btn" onclick="openModal()">Create Schedule</button>

            <div class="today">Today Duty Shedule</div>
            <!-- Table Section -->
            <table>
                <thead>
                    <tr>
                        <th>Duty Officer ID</th>
                        <th>Officer Name</th>
                        <th>Duty Date</th>
                        <th>Shift</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="dutyTable">
                    <tr>
                        <td>S001</td>
                        <td>Vishwa Nimsara</td>
                        <td>2024-11-20</td>
                        <td>8 AM - 12 PM</td>
                        <td>
                            <button class="btn-edit" onclick="editDuty(this)">Edit</button>
                            <button class="btn-delete" onclick="deleteDuty(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody id="dutyTable">
                    <tr>
                        <td>S002</td>
                        <td>Malith Damsara</td>
                        <td>2024-11-21</td>
                        <td>8 AM - 12 PM</td>
                        <td>
                            <button class="btn-edit" onclick="editDuty(this)">Edit</button>
                            <button class="btn-delete" onclick="deleteDuty(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody id="dutyTable">
                    <tr>
                        <td>S003</td>
                        <td>Sasila Sadamsara</td>
                        <td>2023-11-21</td>
                        <td>4 PM - 00 AM</td>
                        <td>
                            <button class="btn-edit" onclick="editDuty(this)">Edit</button>
                            <button class="btn-delete" onclick="deleteDuty(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody id="dutyTable">
                    <tr>
                        <td>S004</td>
                        <td>Geeth Pasida</td>
                        <td>2024-11-22</td>
                        <td>00 AM - 8 AM</td>
                        <td>
                            <button class="btn-edit" onclick="editDuty(this)">Edit</button>
                            <button class="btn-delete" onclick="deleteDuty(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Section -->
    <div class="modal" id="scheduleModal">
        <div class="modal-content">
            <h3>Create/Edit Schedule</h3>
            <form id="dutyForm">
                <input type="text" id="officer_id" placeholder="Officer ID" required>
                <input type="text" id="officer_name" placeholder="Officer Name" required>
                <input type="date" id="duty_date" required>
                <select id="shift" required>
                    <option value="8-12">8 AM - 12 PM</option>
                    <option value="8-16">8 AM - 4 PM</option>
                    <option value="16-20">4 PM - 8 PM</option>
                    <option value="16-24">4 PM - 12 AM</option>
                    <option value="24-8">00 AM - 8 AM</option>
                </select>
                <button type="button" class="btn-cancel"  onclick="saveDuty()">Save</button>
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- calender part -->
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

    <!-- Footer -->
    <footer>
        <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    </footer>

    <script>
        const modal = document.getElementById('scheduleModal');
        let editingRow = null;

        function openModal() {
            modal.classList.add('active');
        }

        function closeModal() {
            modal.classList.remove('active');
            resetForm();
        }

        function resetForm() {
            document.getElementById('dutyForm').reset();
            editingRow = null;
        }

        function saveDuty() {
            const officerId = document.getElementById('officer_id').value;
            const officerName = document.getElementById('officer_name').value;
            const dutyDate = document.getElementById('duty_date').value;
            const shift = document.getElementById('shift').value;

            if (editingRow) {
                editingRow.cells[0].innerText = officerId;
                editingRow.cells[1].innerText = officerName;
                editingRow.cells[2].innerText = dutyDate;
                editingRow.cells[3].innerText = shift;
            } else {
                const table = document.getElementById('dutyTable');
                const row = table.insertRow();
                row.innerHTML = `
                    <td>${officerId}</td>
                    <td>${officerName}</td>
                    <td>${dutyDate}</td>
                    <td>${shift}</td>
                    <td>
                        <button class="btn-edit" onclick="editDuty(this)">Edit</button>
                        <button class="btn-delete" onclick="deleteDuty(this)">Delete</button>
                    </td>
                `;
            }

            closeModal();
        }

function editDuty(button) {
    const row = button.parentElement.parentElement;
    editingRow = row;

    document.getElementById('officer_id').value = row.cells[0].innerText;
    document.getElementById('officer_name').value = row.cells[1].innerText;
    document.getElementById('duty_date').value = row.cells[2].innerText;
    document.getElementById('shift').value = row.cells[3].innerText;

    openModal();
}

function deleteDuty(button) {
    const row = button.parentElement.parentElement;
    row.remove();
}

// calender part

let currentMonth = new Date();
        const officers = [
            { id: '001', name: 'John Doe', color: '#4CAF50' },
            { id: '002', name: 'Jane Smith', color: '#2196F3' },
            { id: '003', name: 'Mark Lee', color: '#F44336' },
            { id: '004', name: 'Emma Brown', color: '#FF9800' },
            { id: '005', name: 'Alice White', color: '#9C27B0' },
        ];
        const shifts = ['8-12', '8-16', '16-20', '16-24', '24-8']; // Shift timings
        let schedule = {}; // Store schedule by date

        // Generate monthly schedule
        function generateMonthlySchedule(month, year) {
            schedule = {}; // Reset schedule
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let day = 1; day <= daysInMonth; day++) {
                schedule[day] = [];
                // Randomly assign between 3 and 5 officers to work each day
                const numOfficers = Math.floor(Math.random() * 3) + 3; // 3 to 5 officers
                const selectedOfficers = shuffle(officers).slice(0, numOfficers); // Shuffle and select officers
                selectedOfficers.forEach((officer, index) => {
                    const shiftIndex = (day + index) % shifts.length; // Rotate shifts
                    schedule[day].push({
                        officer,
                        shift: shifts[shiftIndex],
                    });
                });
            }

            populateSchedule();
        }

        // Shuffle function to randomize officer order
        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        // Populate today's schedule in the table
        function populateTodaySchedule() {
            const table = document.getElementById('duty-schedule-table').getElementsByTagName('tbody')[0];
            table.innerHTML = ''; // Clear table

            const today = new Date().getDate();
            if (schedule[today]) {
                schedule[today].forEach((entry) => {
                    const { officer, shift } = entry;

                    const row = table.insertRow();
                    row.innerHTML = `
                        <td>${officer.id}</td>
                        <td>${officer.name}</td>
                        <td>${shift}</td>
                        <td>
                            <button onclick="editDuty(${today}, '${officer.id}')">Edit</button>
                            <button onclick="confirmDelete(${today}, '${officer.id}')">Delete</button>
                        </td>
                    `;
                });
            }
        }

        // Populate calendar with the schedule
        function populateSchedule() {
            const calendarDays = document.querySelectorAll('.calendar .day:not(.empty)');
            calendarDays.forEach((day) => {
                day.style.backgroundColor = '';
                day.innerHTML = day.textContent.trim(); // Reset day square
            });

            for (const day in schedule) {
                const dayElement = Array.from(document.getElementsByClassName('day')).find(
                    (el) => el.textContent.trim() == day
                );
                if (dayElement) {
                    dayElement.innerHTML = day; // Set the day number

                    // Add each officer's shift to the day
                    schedule[day].forEach((entry) => {
                        const { officer, shift } = entry;
                        const officerBlock = document.createElement('div');
                        officerBlock.textContent = `${officer.name} (${shift})`;
                        officerBlock.style.backgroundColor = officer.color;
                        officerBlock.style.color = '#fff';
                        officerBlock.style.margin = '2px 0';
                        officerBlock.style.padding = '5px';
                        officerBlock.style.borderRadius = '4px';
                        officerBlock.style.fontSize = '0.8em';
                        dayElement.appendChild(officerBlock);
                    });
                }
            }

            // Populate today's schedule
            populateTodaySchedule();
        }

        // Update calendar view
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

            populateSchedule();
        }

        // Navigate through months
        function navigateMonth(direction) {
            currentMonth.setMonth(currentMonth.getMonth() + direction);
            updateCalendar(currentMonth.getMonth(), currentMonth.getFullYear());
            generateMonthlySchedule(currentMonth.getMonth(), currentMonth.getFullYear());
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function () {
            updateCalendar(currentMonth.getMonth(), currentMonth.getFullYear());
            generateMonthlySchedule(currentMonth.getMonth(), currentMonth.getFullYear());
        });



</script>
</body> </html> 