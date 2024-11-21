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
      /* General Styles */
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    color: #2c3e50;
}

/* Navbar Styling */
nav {
    background-color: #2c3e50;
    color: #fff;
    padding: 15px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

nav a {
    color: #ecf0f1;
    text-decoration: none;
    margin-right: 20px;
    font-size: 1rem;
}

nav a:hover {
    color: #3498db;
}

/* Dashboard Layout */
.dashboard-container {
    display: flex;
}

/* Side Panel Styling */
.side-panel {
    width: 250px;
    background-color: #34495e;
    color: #fff;
    padding: 20px;
    height: 100vh;
    box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
}

.side-panel a {
    color: #bdc3c7;
    text-decoration: none;
    display: block;
    margin: 10px 0;
}

.side-panel a:hover {
    color: #1abc9c;
}

/* Main Content Styling */
main {
    flex: 1;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin: 20px;
}

h1, h2 {
    color: #2c3e50;
}

/* Profile Cards */
.team-profile {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.team-profile-card {
    flex: 1 1 calc(25% - 20px);
    background-color: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.profile-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 15px;
    border: 4px solid transparent;
    background-clip: padding-box;
}

.profile-details {
    text-align: center;
}

.profile-details h3 {
    font-size: 1.2rem;
    margin: 10px 0;
    color: #34495e;
}

.profile-details p {
    margin: 5px 0;
    font-size: 0.9rem;
    color: #7f8c8d;
}

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 10px;
}

.btn {
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    cursor: pointer;
    font-size: 0.9rem;
}

.edit-btn {
    background-color: #1abc9c;
}

.edit-btn:hover {
    background-color: #16a085;
}

.delete-btn {
    background-color: #e74c3c;
}

.delete-btn:hover {
    background-color: #c0392b;
}

/* Unique Card Styles */
.card-hvac {
    background: linear-gradient(135deg, #3498db, #2ecc71);
}

.card-electrical {
    background: linear-gradient(135deg, #f1c40f, #e67e22);
}

.card-plumbing {
    background: linear-gradient(135deg, #9b59b6, #34495e);
}

.card-general {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.card-hvac .profile-img {
    border-color: #2ecc71;
}

.card-electrical .profile-img {
    border-color: #e67e22;
}

.card-plumbing .profile-img {
    border-color: #9b59b6;
}

.card-general .profile-img {
    border-color: #c0392b;
}

/* Button Styling */
.btn {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
}

.btn:active {
    transform: translateY(1px);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.edit-btn {
    background-color: #1abc9c;
}

.edit-btn:hover {
    background-color: #16a085;
}

.delete-btn {
    background-color: #e74c3c;
}

.delete-btn:hover {
    background-color: #c0392b;
}

/* Profile Card Styles */
.team-profile-card {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    transition: box-shadow 0.3s ease, transform 0.2s ease;
    gap: 20px;
}

.team-profile-card:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

.profile-img img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 3px solid #3498db;
    object-fit: cover;
}

.profile-details {
    flex-grow: 1;
    color: #34495e;
}

.profile-details p {
    margin: 5px 0;
    font-size: 1rem;
    line-height: 1.5;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

/* Alerts */
.alert {
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: bold;
    color: #fff;
}

.alert.critical {
    background-color: #e74c3c;
}

.alert.warning {
    background-color: #f39c12;
    color: #2c3e50;
}

/* Modal */
.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60%;
    max-width: 400px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 20px;
    z-index: 1000;
    display: none;
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

.modal-header .close {
    font-size: 1.5rem;
    cursor: pointer;
}

.modal-form input, .modal-form select {
    width: 100%;
    padding: 10px;
    margin: 5px 0 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.h1position {
    padding-left: 300px;
}
/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: #2c3e50;
    color: #fff;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #f5f5f5;
}

.shift-allocation, .alerts{

    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    padding-left: 300px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    width:80%;
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


            <h2>Team Profiles</h2>
            <!-- Comprehensive Team Profiles -->
            <section class="team-profile">
                
                <!-- HVAC Specialist -->
                <div class="team-profile-card card-hvac">
                    <div class="profile-img">
                        <img src="path/to/hvac.jpg" alt="HVAC Specialist">
                    </div>
                    <div class="profile-details">
                        <h3>John Doe</h3>
                        <p>Specialization: HVAC</p>
                        <p>Experience: 8 years</p>
                    </div>
                    <div class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </div>

                <!-- Electrical Specialist -->
                <div class="team-profile-card card-electrical">
                    <div class="profile-img">
                        <img src="path/to/electrical.jpg" alt="Electrical Specialist">
                    </div>
                    <div class="profile-details">
                        <h3>Jane Smith</h3>
                        <p>Specialization: Electrical</p>
                        <p>Experience: 5 years</p>
                    </div>
                    <div class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </div>

                <!-- Plumbing Specialist -->
                <div class="team-profile-card card-plumbing">
                    <div class="profile-img">
                        <img src="path/to/plumbing.jpg" alt="Plumbing Specialist">
                    </div>
                    <div class="profile-details">
                        <h3>Mike Johnson</h3>
                        <p>Specialization: Plumbing</p>
                        <p>Experience: 6 years</p>
                    </div>
                    <div class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </div>

                <!-- General Maintenance -->
                <div class="team-profile-card card-general">
                    <div class="profile-img">
                        <img src="path/to/general.jpg" alt="General Maintenance">
                    </div>
                    <div class="profile-details">
                        <h3>Sarah Lee</h3>
                        <p>Specialization: General Maintenance</p>
                        <p>Experience: 4 years</p>
                    </div>
                    <div class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
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
        <div class="h1position">
               <h1>Team Scheduling</h1>
        </div>
            

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
