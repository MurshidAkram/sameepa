<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Requests | <?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            margin: 0;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 25px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            margin: 20px;
        }

        .content-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .content-header h1 {
            margin: 0 0 10px;
            font-size: 2.2rem;
            color: #800080;
            font-weight: 700;
        }

        .filter-section {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
            align-items: center;
        }

        .filter-section input,
        .filter-section select {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            min-width: 200px;
        }

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
        }

        .dashboard-table th {
            background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
            color: #fff;
            padding: 12px;
            font-weight: 600;
            text-align: left;
        }

        .dashboard-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .dashboard-table tr:nth-child(even) {
            background: #fafafa;
        }

        .dashboard-table tr:hover {
            background: #f0e6ff;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #9c27b0;
            color: white;
        }

        .btn-edit:hover {
            background: #7b1fa2;
        }

        .btn-assign {
            background: #2196F3;
            color: white;
        }

        .btn-assign:hover {
            background: #0d8bf2;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 25px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .toast.show {
            opacity: 1;
        }

        .toast-success {
            background: #4CAF50;
        }

        .toast-error {
            background: #F44336;
        }

        @media (max-width: 768px) {
            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-section input,
            .filter-section select {
                width: 100%;
            }
            
            .action-buttons {
                flex-direction: column;
            }
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
                <p>Manage all maintenance requests from residents</p>
            </div>

            <section class="filter-section">
                <input type="text" id="searchInput" placeholder="Search requests...">
                <select id="typeFilter">
                    <option value="">All Request Types</option>
                    <?php foreach ($data['types'] as $type): ?>
                        <option value="<?php echo $type->type_id; ?>"><?php echo $type->type_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="statusFilter">
                    <option value="">All Statuses</option>
                    <?php foreach ($data['statuses'] as $status): ?>
                        <option value="<?php echo $status->status_id; ?>"><?php echo $status->status_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </section>

            <div class="table-container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Resident Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Request Type</th>
                            <th>Description</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Maintainer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['requests'] as $request): ?>
                            <tr data-status-id="<?php echo $request->status_id; ?>">
                                <td><?php echo $request->request_id; ?></td>
                                <td><?php echo $request->resident_name; ?></td>
                                <td><?php echo $request->resident_address; ?></td>
                                <td><?php echo $request->resident_phone; ?></td>
                                <td><?php echo $request->type_name; ?></td>
                                <td><?php echo $request->description; ?></td>
                                <td><?php echo ucfirst($request->urgency_level); ?></td>
                                <td><?php echo $request->status_name; ?></td>
                                <td><?php echo $request->maintainer_name ?? 'Not assigned'; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-edit" onclick="openStatusModal(<?php echo $request->request_id; ?>, <?php echo $request->status_id; ?>)">
                                            Change Status
                                        </button>
                                        <button class="btn btn-assign" onclick="openAssignModal(<?php echo $request->request_id; ?>)">
                                            Assign Maintainer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Status Change Modal -->
            <div id="statusModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('statusModal')">&times;</span>
                    <h2>Change Request Status</h2>
                    <form id="statusForm">
                        <input type="hidden" id="statusRequestId" name="requestId">
                        <div class="form-group">
                            <label for="newStatus">New Status:</label>
                            <select id="newStatus" name="statusId" required>
                                <?php foreach ($data['statuses'] as $status): ?>
                                    <option value="<?php echo $status->status_id; ?>"><?php echo $status->status_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-edit">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Assign Maintainer Modal -->
            <div id="assignModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('assignModal')">&times;</span>
                    <h2>Assign Maintenance Staff</h2>
                    <form id="assignForm">
                        <input type="hidden" id="assignRequestId" name="requestId">
                        <div class="form-group">
                            <label for="specialization">Specialization:</label>
                            <select id="specialization" name="specialization" required>
                                <option value="">Select Specialization</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="maintainer">Maintainer:</label>
                            <select id="maintainer" name="staffId" required disabled>
                                <option value="">Select a maintainer</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-assign">Assign Maintainer</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
   <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script>
        // DOM Elements
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const statusFilter = document.getElementById('statusFilter');
        const statusModal = document.getElementById('statusModal');
        const assignModal = document.getElementById('assignModal');
        const statusForm = document.getElementById('statusForm');
        const assignForm = document.getElementById('assignForm');
        const specializationSelect = document.getElementById('specialization');
        const maintainerSelect = document.getElementById('maintainer');

        // Modal functions
        function openStatusModal(requestId, currentStatusId) {
            document.getElementById('statusRequestId').value = requestId;
            document.getElementById('newStatus').value = currentStatusId;
            statusModal.style.display = 'block';
        }

        function openAssignModal(requestId) {
            document.getElementById('assignRequestId').value = requestId;
            loadSpecializations();
            assignModal.style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Load specializations for assign modal
        async function loadSpecializations() {
    try {
        specializationSelect.innerHTML = '<option value="">Loading...</option>';
        const response = await fetch('<?php echo URLROOT; ?>/maintenance/getSpecializations');
        const data = await response.json();
        
        specializationSelect.innerHTML = '<option value="">Select Specialization</option>';
        data.forEach(spec => {
            const option = document.createElement('option');
            option.value = spec.specialization;
            option.textContent = spec.specialization;
            specializationSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading specializations:', error);
        showToast('Failed to load specializations', 'error');
    }
}

// When specialization changes, load maintainers
specializationSelect.addEventListener('change', async function() {
    if (!this.value) {
        maintainerSelect.innerHTML = '<option value="">Select a maintainer</option>';
        maintainerSelect.disabled = true;
        return;
    }

    try {
        maintainerSelect.innerHTML = '<option value="">Loading...</option>';
        maintainerSelect.disabled = true;
        
        const response = await fetch('<?php echo URLROOT; ?>/maintenance/getStaffBySpecialization', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ specialization: this.value })
        });
        const data = await response.json();
        
        maintainerSelect.innerHTML = '<option value="">Select a maintainer</option>';
        data.forEach(staff => {
            const option = document.createElement('option');
            option.value = staff.id;
            option.textContent = `${staff.name} (${staff.specialization})`;
            maintainerSelect.appendChild(option);
        });
        maintainerSelect.disabled = false;
    } catch (error) {
        console.error('Error loading maintainers:', error);
        showToast('Failed to load maintainers', 'error');
    }
});

        // Handle status form submission
statusForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('requestId', document.getElementById('statusRequestId').value);
    formData.append('statusId', document.getElementById('newStatus').value);
    
    fetch('<?php echo URLROOT; ?>/maintenance/updateStatus', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Status updated successfully', 'success');
            setTimeout(() => location.reload());
        } else {
            throw new Error(data.message || 'Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message, 'error');
    });
});

       
// Handle assign form submission
assignForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {
        requestId: document.getElementById('assignRequestId').value,
        staffId: document.getElementById('maintainer').value
    };

    try {
        const response = await fetch('<?php echo URLROOT; ?>/maintenance/assignMaintainer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        const data = await response.json();
        
        if (data.success) {
            showToast('Maintainer assigned successfully', 'success');
            setTimeout(() => location.reload());
        } else {
            throw new Error(data.message || 'Failed to assign maintainer');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast(error.message, 'error');
    }
});

        // Table filtering
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const typeFilterValue = typeFilter.value;
            const statusFilterValue = statusFilter.value;

            document.querySelectorAll('.dashboard-table tbody tr').forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                const typeMatch = !typeFilterValue || cells[4].textContent === typeFilter.options[typeFilter.selectedIndex].text;
                const statusMatch = !statusFilterValue || cells[7].textContent === statusFilter.options[statusFilter.selectedIndex].text;
                const searchMatch = !searchTerm || rowText.includes(searchTerm);

                row.style.display = (typeMatch && statusMatch && searchMatch) ? '' : 'none';
            });
        }

        // Event listeners for filters
        searchInput.addEventListener('input', filterTable);
        typeFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);

        // Toast notification
        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type} show`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === statusModal) statusModal.style.display = 'none';
            if (e.target === assignModal) assignModal.style.display = 'none';
        });
    </script>
</body>
</html>