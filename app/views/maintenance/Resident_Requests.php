<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Resident Requests | <?php echo SITENAME; ?></title>
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
    gap: 20px;
    background-color: #f8f9fa;
}

main {
    flex: 1;
    padding: 25px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
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
    padding: 14px;
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
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
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
</head>


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
                    <?php foreach($data['types'] as $type): ?>
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
                    <?php foreach($data['statuses'] as $status): ?>
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
                            <th>Resident Details</th>
                            <th>Type of Request</th>
                            <th>Title</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Assigned Maintainer</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['requests'] as $request): ?>
                        <tr>
                            <td><?php echo $request->request_id; ?></td>
                            <td>
                                <?php echo $request->resident_name; ?><br>
                                <?php echo $request->unit_number; ?>
                            </td>
                            <td><?php echo $request->type_name; ?></td>
                            <td><?php echo $request->title; ?></td>
                            <td>
                                <span class="urgency-<?php echo $request->urgency_level; ?>">
                                    <?php echo ucfirst($request->urgency_level); ?>
                                </span>
                            </td>
                            <td><?php echo $request->status_name; ?></td>
                            <td>
                                <?php if($request->staff_name): ?>
                                    <?php echo $request->staff_name; ?>
                                <?php else: ?>
                                    Not assigned
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($request->due_date): ?>
                                    <?php echo date('Y-m-d', strtotime($request->due_date)); ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="action-buttons">
                                <?php if($request->status_id == 1 || $request->status_id == 2): ?>
                                    <button class="btn-edit" onclick="openEditModal(<?php echo $request->request_id; ?>, '<?php echo $request->due_date; ?>')">
                                        Edit Date
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

            <!-- Modals -->
            <div id="editDateModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Due Date</h2>
                    <form id="editDateForm">
                        <input type="hidden" id="editRequestId">
                        <label for="newDueDate">New Due Date:</label>
                        <input type="date" id="newDueDate" required>
                        <button type="submit" class="btn-edit">Update Date</button>
                    </form>
                </div>
            </div>

            <div id="assignMaintainerModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Assign Maintenance Staff</h2>
                    <form id="assignMaintainerForm">
                        <input type="hidden" id="assignRequestId">
                        <label for="maintenanceStaff">Select Staff:</label>
                        <select id="maintenanceStaff" required>
                            <option value="">Select a maintainer</option>
                            <?php foreach($data['staff'] as $staff): ?>
                                <option value="<?php echo $staff->staff_id; ?>">
                                    <?php echo $staff->staff_name; ?> (<?php echo $staff->specialization; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="assignmentDueDate">Due Date:</label>
                        <input type="date" id="assignmentDueDate" required>
                        <button type="submit" class="btn-urgent">Assign</button>
                    </form>
                </div>
            </div>

            <!-- Request History -->
            <h2>Request History</h2>
            <div class="table-container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Resident</th>
                            <th>Past Requests</th>
                            <th>Common Issues</th>
                            <th>Average Completion Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['history'] as $history): ?>
                        <tr>
                            <td><?php echo $history->resident_name; ?></td>
                            <td><?php echo $history->total_requests; ?></td>
                            <td><?php echo $history->common_issues; ?></td>
                            <td><?php echo $history->avg_completion_time; ?> days</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Modal functions
        function openEditModal(requestId, currentDueDate) {
            document.getElementById('editRequestId').value = requestId;
            document.getElementById('newDueDate').value = currentDueDate || '';
            document.getElementById('editDateModal').style.display = 'block';
        }

        function openAssignModal(requestId) {
            document.getElementById('assignRequestId').value = requestId;
            document.getElementById('assignmentDueDate').value = '';
            document.getElementById('maintenanceStaff').value = '';
            document.getElementById('assignMaintainerModal').style.display = 'block';
        }

        // Close modals when clicking X
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                this.closest('.modal').style.display = 'none';
            });
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        });

        // Form submissions
        document.getElementById('editDateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const requestId = document.getElementById('editRequestId').value;
            const newDueDate = document.getElementById('newDueDate').value;
            
            // AJAX call to update due date
            fetch('<?php echo URLROOT; ?>/maintenance/updateDueDate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    requestId: requestId,
                    dueDate: newDueDate
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('Error updating due date');
                }
            });
        });

        document.getElementById('assignMaintainerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const requestId = document.getElementById('assignRequestId').value;
            const staffId = document.getElementById('maintenanceStaff').value;
            const dueDate = document.getElementById('assignmentDueDate').value;
            
            // AJAX call to assign maintainer
            fetch('<?php echo URLROOT; ?>/maintenance/assignMaintainer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    requestId: requestId,
                    staffId: staffId,
                    dueDate: dueDate
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('Error assigning maintainer');
                }
            });
        });
    </script>
</body>
</html>