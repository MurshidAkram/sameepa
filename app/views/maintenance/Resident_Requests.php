<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Resident Requests | <?php echo SITENAME; ?></title>
   
</head>
 <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            margin: 0;
            color: #333;
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            padding: 20px;
            gap: 10px;
            background-color: #f8f9fa;
        }

        main {
            flex: 1;
            padding: 25px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            
        }

        /* Content Header */
        .content-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .content-header h1 {
            margin: 0 0 10px;
            font-size: 2.2rem;
            color: #6a3093;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .content-header p {
            margin: 0;
            color: #666;
            font-size: 1.05rem;
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
            align-items: center;
        }

        .filter-section input,
        .filter-section select {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            min-width: 220px;
            background-color: #f8f9fa;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .filter-section input:focus,
        .filter-section select:focus {
            border-color: #9c27b0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(156, 39, 176, 0.1);
            background-color: #fff;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .dashboard-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95rem;
            border-radius: 10px;
            overflow: hidden;
        }

        .dashboard-table th {
            background: linear-gradient(135deg, #6a3093 0%, #a044ff 100%);
            color: #fff;
            padding: 16px;
            font-weight: 600;
            text-align: center;
            position: sticky;
            top: 0;
        }

        .dashboard-table td {
            padding: 4px;
            text-align: center;
            border: 1px solid #e0e0e0;
            color: #555;
            transition: background-color 0.2s;
        }

        .dashboard-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .dashboard-table tbody tr:hover {
            background: #f0e6ff;
        }

        /* Urgency Indicators */
        .urgency-low {
            color: #28a745;
            font-weight: 500;
        }

        .urgency-medium {
            color: #ffc107;
            font-weight: 500;
        }

        .urgency-high {
            color: #dc3545;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-buttons button {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            color: #fff;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .btn-edit {
            background: linear-gradient(135deg, #3498db 0%, #2c80c7 100%);
            box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #2c80c7 0%, #256fb3 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.4);
        }

        .btn-urgent {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            box-shadow: 0 2px 5px rgba(243, 156, 18, 0.3);
        }

        .btn-urgent:hover {
            background: linear-gradient(135deg, #e67e22 0%, #d46a17 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(243, 156, 18, 0.4);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: slideDown 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal h2 {
            margin-top: 0;
            color: #6a3093;
            font-size: 1.5rem;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover {
            color: #333;
        }

        /* Form Elements in Modals */
        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content label {
            font-weight: 500;
            color: #555;
            margin-bottom: -10px;
        }

        .modal-content input[type="date"],
        .modal-content select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            width: 100%;
        }

        .modal-content input[type="date"]:focus,
        .modal-content select:focus {
            border-color: #9c27b0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(156, 39, 176, 0.1);
        }

        /* Request History Section */
        h2 {
            color: #6a3093;
            font-size: 1.8rem;
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
                padding: 10px;
            }

            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-section input,
            .filter-section select {
                min-width: 100%;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }

            .action-buttons button {
                width: 100%;
                justify-content: center;
            }

            .modal-content {
                margin: 20% auto;
                width: 95%;
            }
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #eee;
        }
    </style>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <div class="content-header">
                <h1>Resident Requests</h1>
            </div>

            <!-- Search & Filters -->
            <section class="filter-section">
                <input type="text" id="searchInput" placeholder="Search requests..." />
                <select id="typeFilter">
                    <option value="">All Request Types</option>
                    <?php foreach ($data['types'] as $type): ?>
                        <option value="<?php echo $type->type_id; ?>"><?php echo $type->type_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="urgencyFilter">
                    <option value="">All Urgency Levels</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <select id="statusFilter">
                    <option value="">All Statuses</option>
                    <?php foreach ($data['statuses'] as $status): ?>
                        <option value="<?php echo $status->status_id; ?>"><?php echo $status->status_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </section>

            <!-- Request Table -->
            <div class="table-container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Resident Name</th>
                            <th>Resident Address</th>
                            <th>Resident Phone</th>
                            <th>Request Type</th>
                            <th>Description</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Assigned Maintainer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['requests'] as $request): ?>
                            <tr>
                                <td><?php echo $request->request_id; ?></td>
                                <td><?php echo $request->resident_name; ?></td>
                                <td><?php echo $request->resident_address; ?></td>
                                <td><?php echo $request->resident_phone; ?></td>
                                <td><?php echo $request->type_name; ?></td>
                                <td><?php echo $request->description; ?></td>
                                <td><?php echo $request->urgency_level; ?></td>
                                <td><?php echo $request->status_name; ?></td>  
                                <td> <?php echo $request->maintainer_name ?? 'Not assigned'; ?> </td>
                                
                                <td class="action-buttons">
                                    <?php if ($request->status_id > 0): ?>
                                        <button class="btn-edit" onclick="openStatusModal(<?php echo $request->request_id; ?>)">
                                            Change Status
                                        </button>
                                        <button class="btn-urgent" onclick="openAssignModal(<?php echo $request->request_id; ?>)">
                                            Assign Maintainer
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Status Change Modal -->
            <div id="statusModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Change Request Status</h2>
                    <form id="statusForm">
                        <input type="hidden" id="statusRequestId">
                        <label for="newStatus">New Status:</label>
                        <select id="newStatus" required>
                            <?php foreach ($data['statuses'] as $status): ?>
                                <?php if ($status->status_id == 3 || $status->status_id == 4): ?>
                                    <option value="<?php echo $status->status_id; ?>">
                                        <?php echo $status->status_name; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn-edit">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Assign Maintainer Modal -->
            <div id="assignMaintainerModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Assign Maintenance Staff</h2>
                    <form id="assignMaintainerForm">
                        <input type="hidden" id="assignRequestId">
                        
                        <div class="form-group">
                            <label for="specializationFilter">Specialization:</label>
                            <select id="specializationFilter" required>
                                <option value="">Select a specialization</option>
                                <!-- Will be populated by JavaScript -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="maintenanceStaff">Select Staff:</label>
                            <select id="maintenanceStaff" required disabled>
                                <option value="">First select a specialization</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn-urgent">Assign</button>
                    </form>
                </div>
            </div>

            <!-- Maintenance Task List -->
            <h2>Maintenance Task List</h2>
            <div class="search-container">
                <input type="text" id="task-search" placeholder="Search tasks..." onkeyup="filterTasks()">
            </div>
            <div class="table-container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Resident Name</th>
                            <th>Resident Address</th>
                            <th>Resident Phone</th>
                            <th>Request Type</th>
                            <th>Description</th>
                            <th>Urgency</th>
                            <th>Assigned Maintainer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- This would be populated via JavaScript or additional PHP -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // DOM Elements
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const urgencyFilter = document.getElementById('urgencyFilter');
        const statusFilter = document.getElementById('statusFilter');
        const statusModal = document.getElementById('statusModal');
        const assignMaintainerModal = document.getElementById('assignMaintainerModal');
        const statusForm = document.getElementById('statusForm');
        const assignMaintainerForm = document.getElementById('assignMaintainerForm');

        // Modal functions
        function openStatusModal(requestId) {
            document.getElementById('statusRequestId').value = requestId;
            statusModal.style.display = 'block';
        }

        // Load specializations when assign modal opens
        function openAssignModal(requestId) {
            document.getElementById('assignRequestId').value = requestId;
            document.getElementById('maintenanceStaff').value = '';
            document.getElementById('maintenanceStaff').disabled = true;
            
            // Load specializations
            fetch('<?php echo URLROOT; ?>/maintenance/getSpecializations')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('specializationFilter');
                    select.innerHTML = '<option value="">Select a specialization</option>';
                    data.forEach(spec => {
                        const option = document.createElement('option');
                        option.value = spec.specialization;
                        option.textContent = spec.specialization;
                        select.appendChild(option);
                    });
                });
            
            assignMaintainerModal.style.display = 'block';
        }

        // When specialization is selected, load staff
        document.getElementById('specializationFilter').addEventListener('change', function() {
            const specialization = this.value;
            const staffSelect = document.getElementById('maintenanceStaff');
            
            if (!specialization) {
                staffSelect.innerHTML = '<option value="">First select a specialization</option>';
                staffSelect.disabled = true;
                return;
            }
            
            fetch('<?php echo URLROOT; ?>/maintenance/getStaffBySpecialization', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ specialization: specialization })
            })
            .then(response => response.json())
            .then(data => {
                staffSelect.innerHTML = '<option value="">Select a maintainer</option>';
                data.forEach(staff => {
                    const option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = `${staff.name} (${staff.specialization})`;
                    staffSelect.appendChild(option);
                });
                staffSelect.disabled = false;
            });
        });

        // Close modals when clicking X
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                this.closest('.modal').style.display = 'none';
            });
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });

        // Handle status change form submission
        statusForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const requestId = document.getElementById('statusRequestId').value;
            const statusId = document.getElementById('newStatus').value;
            
            try {
                const response = await fetch('<?php echo URLROOT; ?>/maintenance/updateStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        requestId: requestId,
                        statusId: statusId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Status updated successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error updating status', 'error');
                }
            } catch (error) {
                showToast('Network error: ' + error.message, 'error');
            }
        });

        // Handle assign maintainer form submission
        assignMaintainerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const requestId = document.getElementById('assignRequestId').value;
            const staffId = document.getElementById('maintenanceStaff').value;
            
            if (!staffId) {
                showToast('Please select a maintainer', 'error');
                return;
            }
            
            try {
                const response = await fetch('<?php echo URLROOT; ?>/maintenance/assignMaintainer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        requestId: requestId,
                        staffId: staffId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Maintainer assigned successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error assigning maintainer', 'error');
                }
            } catch (error) {
                showToast('Network error: ' + error.message, 'error');
            }
        });

        // Table filtering functionality
        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const typeValue = typeFilter.value;
            const urgencyValue = urgencyFilter.value;
            const statusValue = statusFilter.value;
            
            const rows = document.querySelectorAll('.dashboard-table tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const typeMatch = typeValue === '' || cells[4].textContent === typeValue;
                const urgencyMatch = urgencyValue === '' || cells[6].querySelector('span').classList.contains(`urgency-${urgencyValue}`);
                const statusMatch = statusValue === '' || cells[7].textContent.toLowerCase() === statusValue.toLowerCase();
                const searchMatch = Array.from(cells).some(cell => 
                    cell.textContent.toLowerCase().includes(searchValue)
                );
                
                if (typeMatch && urgencyMatch && statusMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Event listeners for filters
        searchInput.addEventListener('input', filterTable);
        typeFilter.addEventListener('change', filterTable);
        urgencyFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);

        // Toast notification function
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

    
    </script>
</body>
</html>