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
        .team-profile,
        .shift-allocation,
        .availability,
        .overtime-tracking,
        .performance-metrics {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            padding: 15px;
            margin-bottom: 20px;
        }

        h2,
        h3 {
            color: #2c3e50;
        }

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
            overflow: hidden;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-details {
            font-size: 0.9em;
        }

        .button-container {
            margin-bottom: 20px;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            z-index: 1000;
        }

        .modal.active {
            display: block;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-header .close {
            font-size: 1.5em;
            cursor: pointer;
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .modal-form input,
        .modal-form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-form label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
            color: #2c3e50;
        }

        .shift-allocation {
            padding: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Alerts Section */
        .alerts {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            color: #fff;
        }

        .alert.critical {
            background-color: #e74c3c;
        }

        .alert.warning {
            background-color: #f1c40f;
            color: #2c3e50;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit-btn,
        .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #f1c40f;
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
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

            <!-- Add New Maintenance Member -->
            <div class="button-container">
                <button class="btn" id="addMemberBtn">Add New Maintenance Member</button>
            </div>

            <!-- Comprehensive Team Profiles -->
            <section class="team-profile">
                <h2>Team Profiles</h2>
                <div class="team-profile-card">
                    <div class="profile-img">
                        <img src="path/to/profile1.jpg" alt="John Doe">
                    </div>
                    <div class="profile-details">
                        <p><strong>Name:</strong> John Doe</p>
                        <p><strong>Specialization:</strong> HVAC</p>
                        <p><strong>Experience:</strong> 8 years</p>
                        <p><strong>Certifications:</strong> HVAC Pro, Safety</p>
                        <div class="action-buttons">
                            <button class="edit-btn" onclick="editMember('John Doe')">Edit</button>
                            <button class="delete-btn" onclick="deleteMember('John Doe')">Delete</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Other Sections (Shift Allocation, Availability, etc.) -->
        </main>
    </div>

    <!-- Modal for Adding/Editing Member -->
    <div class="modal" id="memberModal">
        <div class="modal-header">
            <h2 id="modalTitle">Add New Member</h2>
            <span class="close" id="closeModal">&times;</span>
        </div>
        <form class="modal-form" id="memberForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="specialization">Specialization:</label>
            <select id="specialization" name="specialization" required>
                <option value="HVAC">HVAC</option>
                <option value="Electrical">Electrical</option>
                <option value="Plumbing">Plumbing</option>
            </select>

            <label for="experience">Experience (Years):</label>
            <input type="number" id="experience" name="experience" required>

            <label for="certifications">Certifications:</label>
            <input type="text" id="certifications" name="certifications">

            <label for="profileImage">Profile Image:</label>
            <input type="file" id="profileImage" name="profileImage" accept="image/*">

            <button type="submit" class="btn">Save</button>
        </form>
    </div>
     <!-- Main Content -->
     <main>
            <h1>Team Scheduling</h1>

            <!-- Shift Allocation Section -->
            <section class="shift-allocation">
                <h2>Shift Allocation Metrics</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Team Member</th>
                            <th>Assigned Shifts</th>
                            <th>Completed Tasks</th>
                            <th>Hours Worked</th>
                            <th>Overtime Hours</th>
                            <th>Performance Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>5</td>
                            <td>15</td>
                            <td>40</td>
                            <td>5</td>
                            <td>4.5 / 5</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>6</td>
                            <td>20</td>
                            <td>38</td>
                            <td>2</td>
                            <td>4.8 / 5</td>
                        </tr>
                        <tr>
                            <td>Mike Johnson</td>
                            <td>4</td>
                            <td>12</td>
                            <td>32</td>
                            <td>3</td>
                            <td>4.2 / 5</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Alerts Section -->
            <section class="alerts">
                <h2>Scheduling Alerts</h2>
                <div class="alert critical">
                    ⚠️ Critical: Overlapping shift detected between John Doe and Jane Smith on 2024-09-20!
                </div>
                <div class="alert warning">
                    ⚠️ Warning: Unassigned high-priority task scheduled for 2024-09-22.
                </div>
                <div class="alert warning">
                    ⚠️ Warning: Mike Johnson has pending task reviews for this week.
                </div>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        const addMemberBtn = document.getElementById('addMemberBtn');
        const memberModal = document.getElementById('memberModal');
        const closeModal = document.getElementById('closeModal');
        const memberForm = document.getElementById('memberForm');

        addMemberBtn.addEventListener('click', () => {
            memberModal.classList.add('active');
            document.getElementById('modalTitle').textContent = 'Add New Member';
            memberForm.reset();
        });

        closeModal.addEventListener('click', () => {
            memberModal.classList.remove('active');
        });

        memberForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Member saved successfully!');
            memberModal.classList.remove('active');
        });

        function editMember(name) {
            memberModal.classList.add('active');
            document.getElementById('modalTitle').textContent = `Edit Member - ${name}`;
        }

        function deleteMember(name) {
            if (confirm(`Are you sure you want to delete ${name}?`)) {
                alert(`${name} deleted successfully!`);
            }
        }
    </script>
</body>

</html>
