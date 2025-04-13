<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Security Duty Schedule</title>
    <style>
    :root {
        --primary-color: #800080; /* Updated to purple */
        --secondary-color: #660066;
        --accent-color: #b266ff;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .container {
    max-width: 1200px;
    margin: -320px 0 0 300px; /* Top margin = 50px, Left margin = 250px (side panel width) */
    padding: 20px;
}

    .header {
        background-color: var(--primary-color);
        color: white;
        padding: 15px 0;
        margin-bottom: 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
        text-align: center;
    }

    .card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .card-header {
        background-color: var(--secondary-color);
        color: white;
        padding: 15px 20px;
        font-size: 18px;
        font-weight: 600;
    }

    .card-body {
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
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

    .btn {
        display: inline-block;
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

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        border-radius: 8px;
        width: 500px;
        max-width: 90%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .modal-header {
        padding: 15px 20px;
        background-color: var(--primary-color);
        color: white;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
    }

    .modal-header .close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .modal-footer {
        padding: 15px 20px;
        background-color: #f9f9f9;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        text-align: right;
    }

    .calendar-container {
        margin-top: 30px;
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
    }

    .calendar-day {
        min-height: 100px;
        padding: 10px;
        background-color: white;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        position: relative;
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

    .flash-message {
        padding: 10px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        color: white;
    }

    .alert-success {
        background-color: var(--success-color);
    }

    .alert-danger {
        background-color: var(--danger-color);
    }
    

    @media (max-width: 768px) {
        .calendar {
            grid-template-columns: repeat(1, 1fr);
        }

        .calendar-day-header {
            display: none;
        }

        .container {
            margin-left: 0; /* For small screens, remove margin */
        }
    }
</style>

</head>
<body>
      <!-- Navbar -->
      <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
 <!-- Content Section -->
 <div class="content">
        <!-- Side Panel Section -->
        <div class="side-panel">
            <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>
        </div>

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
                      
                    <?php if(isset($data['officers']) && is_array($data['officers'])): ?>
                        <?php foreach($data['officers'] as $officer): ?>
                            
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
                        <?php if(empty($data['todaySchedule'])): ?>
                            <tr>
                                <td colspan="4" class="text-center">No duties scheduled for today</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($data['todaySchedule'] as $duty): ?>
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
                            <?php foreach($data['shifts'] as $shift): ?>
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
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

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
                const dateStr = date.toISOString().split('T')[0];
                const dayCell = document.createElement('div');
                dayCell.className = 'calendar-day';
                
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
                fetchDutiesForDate(dateStr).then(duties => {
                    duties.forEach(duty => {
                        const shiftItem = document.createElement('div');
                        shiftItem.className = `shift-item shift-${duty.shift_name.toLowerCase()}`;
                        shiftItem.textContent = `${duty.shift_name}: ${duty.officers}`;
                        dayCell.appendChild(shiftItem);
                    });
                });
                
                calendar.appendChild(dayCell);
            }
        }

        function updateCalendarTitle() {
            const options = { year: 'numeric', month: 'long' };
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
                             <button class="btn btn-warning" onclick="EditShift(${officerId}, '${duty.duty_date}')">
    <i class="fas fa-trash"></i> Edit Shift
</button>
                                <button class="btn btn-danger" onclick="deleteDuty(${officerId}, '${duty.duty_date}')">
                                    <i class="fas fa-trash"></i> Remove Duty
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

        // Duty management functions
        function saveDuty() {
            const officerId = document.getElementById('addOfficerId').value;
            const dutyDate = document.getElementById('addDutyDate').value;
            const shiftId = document.getElementById('addShift').value;
            
            // Validate date is not in the past
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const selectedDate = new Date(dutyDate);
            
            if (selectedDate < today) {
                alert('Cannot assign duties for past dates.');
                return;
            }
            
            // Send data to server
            fetch('<?php echo URLROOT; ?>/security/addDuty', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `officer_id=${officerId}&duty_date=${dutyDate}&shift_id=${shiftId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Error adding duty');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding duty');
            });
        }


        function EditShift(officerId, dutyDate, currentShiftId) {
    // Get the new shift ID from user input
    const newShiftId = prompt('Enter new shift ID (1-Morning, 2-Afternoon, 3-Night):', currentShiftId);
    
    if (!newShiftId || newShiftId == currentShiftId) {
        return; // No change or cancelled
    }

    if (!confirm(`Change duty shift from ${getShiftName(currentShiftId)} to ${getShiftName(newShiftId)}?`)) {
        return;
    }
    
    fetch('<?php echo URLROOT; ?>/security/editShift', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `officer_id=${officerId}&duty_date=${dutyDate}&new_shift_id=${newShiftId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Error updating duty');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating duty');
    });
}

// Helper function to get shift name
function getShiftName(shiftId) {
    switch(shiftId) {
        case '1': return 'Morning (8AM-4PM)';
        case '2': return 'Afternoon (4PM-12AM)';
        case '3': return 'Night (12AM-8AM)';
        default: return 'Unknown Shift';
    }
}

        function deleteDuty(officerId, dutyDate) {
            if (!confirm('Are you sure you want to remove this duty assignment?')) {
                return;
            }
            
            fetch('<?php echo URLROOT; ?>/security/deleteDuty', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `officer_id=${officerId}&duty_date=${dutyDate}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Error removing duty');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error removing duty');
            });
        }

        // API functions
        function fetchDutiesForDate(date) {
            return fetch(`<?php echo URLROOT; ?>/security/getCalendarData/${date}/${date}`)
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
            return fetch(`<?php echo URLROOT; ?>/security/getOfficerDuties/${officerId}`)
                .then(response => response.json())
                .catch(error => {
                    console.error('Error fetching officer duties:', error);
                    return [];
                });
        }

        // Helper functions
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }
    </script>
</body>
</html>