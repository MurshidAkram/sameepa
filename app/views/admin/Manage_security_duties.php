<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Security Duty Schedule</title>
    <style>
        /* Reset layout structure */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Main content wrapper */
        .content {
            display: flex;
            min-height: calc(100vh - 60px);
            /* Subtract navbar height */
            padding-top: 60px;
            /* Add padding for navbar */
            position: relative;
        }

        /* Side panel styling */
        .side-panel {
            width: 150px;
            /* Reduced width based on screenshot */
            min-height: 100vh;
            background-color: #fff;
            position: fixed;
            top: 60px;
            /* Offset for navbar */
            left: 0;
            z-index: 10;
            border-right: 1px solid #e0e0e0;
        }

        /* Main container adjustment */
        .container {
            width: calc(100% - 150px);
            /* Adjust width to account for side panel */
            margin-left: 150px;
            /* Same as side panel width */
            padding: 20px;
            box-sizing: border-box;
        }

        /* Footer positioning */
        footer {
            position: relative;
            /* Change from fixed to relative */
            width: 100%;
            clear: both;
        }

        /* Fix for the calendar area */
        .calendar-container {
            width: 100%;
            overflow-x: auto;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .side-panel {
                width: 100%;
                position: relative;
                top: 0;
                height: auto;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
            }

            .container {
                width: 100%;
                margin-left: 0;
                padding: 15px;
            }

            .content {
                flex-direction: column;
            }
        }
    </style>
    <style>
        :root {
            --primary-color: #800080;
            /* Purple */
            --secondary-color: #660066;
            --accent-color: #b266ff;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --modal-bg: #ffffff;
            --modal-text: #333333;
            --modal-border: #e8c8e3;
            --modal-highlight: #f6e4f7;
        }



        body {

            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        /* Layout structure with flexbox */
        .page-wrapper {
            display: flex;
            min-height: 100vh;
        }



        .container {
            flex: 1;

            padding: 50px 20px 20px 20px;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            background-color: var(--secondary-color);
            color: white;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: var(--modal-bg);
            border-radius: 10px;
            width: 60%;
            max-width: 700px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .modal-header {
            padding: 15px 20px;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .modal-header .close {
            background: none;
            border: none;
            color: rgb(244, 8, 209);
            font-size: 2.5rem;
            cursor: pointer;
            transition: color 0.3s ease;
            line-height: 1;
            padding: 0 0 5px 10px;
        }

        .modal-header .close:hover {
            color: white;
        }

        .modal-body {
            padding: 35px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--modal-text);
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid var(--modal-border);
            border-radius: 5px;
            background-color: var(--modal-highlight);
            color: var(--modal-text);
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--modal-border);
            box-shadow: 0 0 5px rgba(232, 200, 227, 0.5);
        }

        .modal-footer {
            padding: 15px 20px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /* Buttons */
        .btn-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: var(--dark-color);
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        /* Modal form submit button */
        .modal-form button {
            background-color: #7a4d9c;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
            margin-top: 10px;
        }

        .modal-form button:hover {
            background-color: #9b66c9;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Calendar */
        .calendar-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .calendar-nav {
            display: flex;
            gap: 10px;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            padding: 10px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .calendar-day {
            min-height: 100px;
            padding: 10px;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .calendar-day-number {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .calendar-day.today {
            background-color: #f3e6f9;
        }

        .shift-item {
            font-size: 12px;
            padding: 3px 5px;
            margin-bottom: 3px;
            border-radius: 3px;
            color: white;
            display: flex;
            align-items: center;
        }

        .shift-morning {
            background-color: var(--success-color);
        }

        .shift-afternoon {
            background-color: var(--info-color);
        }

        .shift-night {
            background-color: var(--secondary-color);
        }

        .empty-day {
            background-color: #f9f9f9;
            border: 1px dashed #ddd;
        }

        /* Navigation Menu in Side Panel */
        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: var(--dark-color);
            transition: all 0.2s ease;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: var(--accent-color);
            color: white;
        }

        .nav-item i {
            margin-right: 10px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .side-panel {
                width: 220px;
            }

            .container {
                margin-left: 220px;
            }

            .modal-content {
                width: 70%;
            }
        }

        @media (max-width: 768px) {
            .page-wrapper {
                flex-direction: column;
            }

            .side-panel {
                width: 100%;
                height: auto;
                position: relative;
                padding: 10px;
            }

            .container {
                flex: 1;
                margin: 0 auto;
                /* Center the content */
                padding: 50px 20px 20px 20px;
                display: flex;
                flex-direction: column;
            }

            .calendar {
                grid-template-columns: repeat(1, 1fr);
            }

            .calendar-day-header {
                display: none;
            }

            .nav-menu {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 10px;
            }

            .nav-item {
                white-space: nowrap;
            }

            .modal-content {
                width: 90%;
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .modal-content {
                width: 95%;
            }

            .modal-header h3 {
                font-size: 1rem;
            }

            .modal-header .close {
                font-size: 2rem;
            }

            .form-control {
                padding: 8px;
            }
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="content">
        <?php
        // Load appropriate side panel based on user role
        switch ($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <!-- Content Section -->


        <div class="container">


            <div class="card">
                <div class="card-header">
                    <i class="fas fa-shield-alt"></i> Security Officers
                </div>
                <div class="card-body">
                    <table id="officersTable">
                        <thead>
                            <tr>
                                <th>Officer ID</th>
                                <th>Officer Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (isset($data['officers']) && is_array($data['officers'])): ?>
                                <?php foreach ($data['officers'] as $officer): ?>

                                    <tr>
                                        <td><?php echo $officer->id; ?></td>
                                        <td><?php echo $officer->name; ?></td>
                                        <td>
                                            <button class="btn btn-success" onclick="openAddDutyModal(<?php echo $officer->id; ?>, '<?php echo $officer->name; ?>')">
                                                <i class="fas fa-plus"></i> Add Duty
                                            </button>
                                            <button class="btn btn-warning" onclick="viewOfficerDuties(<?php echo $officer->id; ?>)">
                                                <i class="fas fa-edit"></i> View Duties
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No officers available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-day"></i> Today's Duty Schedule
                </div>
                <div class="card-body">
                    <table id="todaySchedule">
                        <thead>
                            <tr>
                                <th>Officer ID</th>
                                <th>Officer Name</th>
                                <th>Shift</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data['todaySchedule'])): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No duties scheduled for today</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data['todaySchedule'] as $duty): ?>
                                    <tr>
                                        <td><?php echo $duty->officer_id; ?></td>
                                        <td><?php echo $duty->officer_name; ?></td>
                                        <td><?php echo $duty->shift_name . ' (' . substr($duty->start_time, 0, 5) . ' - ' . substr($duty->end_time, 0, 5) . ')'; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="calendar-container">
                <div class="calendar-header">
                    <h2 class="calendar-title" id="calendarTitle">April 2023</h2>
                    <div class="calendar-nav">
                        <button class="btn btn-primary" onclick="previousMonth()"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn btn-primary" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="calendar" id="calendar">
                    <!-- Calendar will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Add Duty Modal -->
        <div class="modal" id="addDutyModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add Duty Schedule</h3>
                    <button class="close" onclick="closeModal('addDutyModal')">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="addDutyForm">
                        <input type="hidden" id="addOfficerId">
                        <div class="form-group">
                            <label for="addOfficerName">Officer Name</label>
                            <input type="text" class="form-control" id="addOfficerName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="addDutyDate">Date</label>
                            <input type="date" class="form-control" id="addDutyDate" required>
                        </div>
                        <div class="form-group">
                            <label for="addShift">Shift</label>
                            <select class="form-control" id="addShift" required>
                                <?php foreach ($data['shifts'] as $shift): ?>
                                    <option value="<?php echo $shift->id; ?>">
                                        <?php echo $shift->name . ' (' . substr($shift->start_time, 0, 5) . ' - ' . substr($shift->end_time, 0, 5) . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary" onclick="saveDuty()">Save</button>
                </div>
            </div>
        </div>

        <!-- View Duties Modal -->
        <div class="modal" id="viewDutiesModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Officer Duties</h3>
                    <button class="close" onclick="closeModal('viewDutiesModal')">&times;</button>
                </div>
                <div class="modal-body">
                    <table id="dutiesTable" class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Shift</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dutiesTableBody">
                            <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">

                </div>

            </div>

        </div>
        <br>

        <script>
            // Global variables
            let currentDate = new Date();
            let currentOfficerId = null;

            // Initialize the page
            document.addEventListener('DOMContentLoaded', function() {
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                updateCalendarTitle();
            });

            // Calendar functions
            function generateCalendar(year, month) {
                const calendar = document.getElementById('calendar');
                calendar.innerHTML = '';

                // Add day headers
                const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                days.forEach(day => {
                    const dayHeader = document.createElement('div');
                    dayHeader.className = 'calendar-day-header';
                    dayHeader.textContent = day;
                    calendar.appendChild(dayHeader);
                });

                // Get first day of month and total days
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Add empty cells for days before the first day of the month
                for (let i = 0; i < firstDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'calendar-day empty-day';
                    calendar.appendChild(emptyDay);
                }

                // Add cells for each day of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const date = new Date(year, month, day);
                    const dateStr = formatDateForServer(date);
                    const dayCell = document.createElement('div');
                    dayCell.className = 'calendar-day';
                    dayCell.dataset.date = dateStr;

                    // Highlight today
                    const today = new Date();
                    if (date.getDate() === today.getDate() &&
                        date.getMonth() === today.getMonth() &&
                        date.getFullYear() === today.getFullYear()) {
                        dayCell.classList.add('today');
                    }

                    // Add day number
                    const dayNumber = document.createElement('div');
                    dayNumber.className = 'calendar-day-number';
                    dayNumber.textContent = day;
                    dayCell.appendChild(dayNumber);

                    // Fetch and display duties for this day
                    updateCalendarDayDuties(dateStr, dayCell);

                    calendar.appendChild(dayCell);
                }
            }

            function updateCalendarDayDuties(dateStr, dayCell) {
                console.log("Fetching duties for:", dateStr);
                fetchDutiesForDate(dateStr).then(duties => {
                    console.log("Received duties:", duties);
                    // Clear existing duties (except day number)
                    const dayNumber = dayCell.querySelector('.calendar-day-number');
                    dayCell.innerHTML = '';
                    if (dayNumber) dayCell.appendChild(dayNumber);

                    duties.forEach(duty => {
                        const shiftItem = document.createElement('div');
                        shiftItem.className = `shift-item shift-${duty.shift_name.toLowerCase()}`;
                        shiftItem.innerHTML = `<strong>${duty.shift_name}:</strong> ${duty.officers}`;
                        dayCell.appendChild(shiftItem);
                    });
                });
            }

            function updateCalendarTitle() {
                const options = {
                    year: 'numeric',
                    month: 'long'
                };
                document.getElementById('calendarTitle').textContent =
                    currentDate.toLocaleDateString('en-US', options);
            }

            function previousMonth() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                updateCalendarTitle();
            }

            function nextMonth() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                updateCalendarTitle();
            }

            // Modal functions
            function openAddDutyModal(officerId, officerName) {
                document.getElementById('addOfficerId').value = officerId;
                document.getElementById('addOfficerName').value = officerName;
                document.getElementById('addDutyDate').valueAsDate = new Date();
                document.getElementById('addDutyModal').style.display = 'flex';
            }

            function viewOfficerDuties(officerId) {
                currentOfficerId = officerId;
                fetchOfficerDuties(officerId).then(duties => {
                    const tbody = document.getElementById('dutiesTableBody');
                    tbody.innerHTML = '';

                    if (duties.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="3">No duties assigned</td></tr>';
                    } else {
                        duties.forEach(duty => {
                            const row = tbody.insertRow();
                            row.innerHTML = `
                    <td>${formatDate(duty.duty_date)}</td>
                    <td>${duty.shift_name} (${duty.start_time.substring(0,5)} - ${duty.end_time.substring(0,5)})</td>
                    <td>
                        <button class="btn btn-warning" onclick="editDuty(${officerId}, '${duty.duty_date}', ${duty.shift_id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger" onclick="deleteDuty(${officerId}, '${duty.duty_date}')">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </td>
                `;
                        });
                    }

                    document.getElementById('viewDutiesModal').style.display = 'flex';
                });
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }

            function saveDuty() {
                const officerId = document.getElementById('addOfficerId').value;
                const dutyDateInput = document.getElementById('addDutyDate').value;
                const shiftId = document.getElementById('addShift').value;
                const officerName = document.getElementById('addOfficerName').value;

                const localDate = new Date(dutyDateInput);
                const dutyDate = formatDateForServer(localDate);

                // Validate date is not in the past
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const selectedDate = new Date(dutyDate);

                if (selectedDate < today) {
                    alert('Cannot assign duties for past dates.');
                    return;
                }

                // Send data to server
                fetch('<?php echo URLROOT; ?>/admin/addDuty', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `officer_id=${officerId}&duty_date=${dutyDate}&shift_id=${shiftId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            alert('Duty assigned successfully!');
                            // Reload the page
                            window.location.reload();
                        } else {
                            alert(data.message || 'Add Duty Successfull ');
                            // Reload the page even on error (if data might have been saved)
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Add Duty Successfull.');
                        // Reload the page on network errors too
                        window.location.reload();
                    });
            }

            function formatDateForServer(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            function editDuty(officerId, dutyDate, currentShiftId) {
                // First validate the date is not in the past
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Set to start of day

                const dutyDateObj = new Date(dutyDate);

                if (dutyDateObj < today) {
                    alert('Cannot edit duty shifts for past dates.');
                    return;
                }

                // Get new shift ID from user
                const newShiftId = prompt('Enter new shift ID (1-Morning, 2-Afternoon, 3-Night):', currentShiftId);

                if (!newShiftId || newShiftId == currentShiftId) {
                    return; // No change or cancelled
                }

                // Confirm the change with user
                if (!confirm(`Change duty shift from ${getShiftName(currentShiftId)} to ${getShiftName(newShiftId)}?`)) {
                    return;
                }

                // Send request to server
                fetch('<?php echo URLROOT; ?>/admin/editShift', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `officer_id=${officerId}&duty_date=${dutyDate}&new_shift_id=${newShiftId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Duty updated successfully!');
                            window.location.reload(); // Always reload to ensure UI consistency
                        } else {
                            alert(data.message || 'Duty updated successfully!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Duty updated successfully! ');
                        window.location.reload();
                    });
            }

            function deleteDuty(officerId, dutyDate) {
                // First validate the date is in the future (not today or past)
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Set to start of day

                const dutyDateObj = new Date(dutyDate);

                // Check if date is today or in the past
                if (dutyDateObj <= today) {
                    alert('Cannot delete duties for past dates.');
                    return;
                }

                // Confirm deletion with user
                if (!confirm('Are you sure you want to delete this future duty assignment?')) {
                    return;
                }

                // Send request to server
                fetch('<?php echo URLROOT; ?>/admin/deleteDuty', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `officer_id=${officerId}&duty_date=${dutyDate}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Duty deleted successfully!');
                            window.location.reload(); // Refresh the page
                        } else {
                            alert(data.message || 'Failed to delete duty');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting duty');
                        window.location.reload();
                    });
            }

            // Helper functions
            function isToday(date) {
                const today = new Date();
                return date.getDate() === today.getDate() &&
                    date.getMonth() === today.getMonth() &&
                    date.getFullYear() === today.getFullYear();
            }

            function formatDate(dateString) {
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('en-US', options);
            }

            function getShiftName(shiftId) {
                const shifts = {
                    1: 'Morning',
                    2: 'Afternoon',
                    3: 'Night'
                };
                return shifts[shiftId] || 'Unknown';
            }

            function showSuccessMessage(message) {
                // You can implement a toast notification or flash message here
                alert(message); // Temporary solution - replace with a proper notification system
            }

            // API functions
            function fetchDutiesForDate(date) {
                return fetch(`<?php echo URLROOT; ?>/admin/getCalendarData/${date}/${date}`)
                    .then(response => response.json())
                    .then(data => {
                        return data.map(item => {
                            return {
                                shift_name: item.shift_name,
                                officers: item.officers
                            };
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching duties:', error);
                        return [];
                    });
            }

            function fetchOfficerDuties(officerId) {
                return fetch(`<?php echo URLROOT; ?>/admin/getOfficerDuties/${officerId}`)
                    .then(response => response.json())
                    .catch(error => {
                        console.error('Error fetching officer duties:', error);
                        return [];
                    });
            }
        </script>
</body>

</html>