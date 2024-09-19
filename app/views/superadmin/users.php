<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/users.css">
    <title>Super Admin User Management | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <h1>User Management</h1>
            <section class="dashboard-overview">

                <!-- Resident Management -->
                <section class="settings-section">
                    <h2>Resident Management</h2>
                    <div class="setting-option">
                        <label>Manage Residents:</label>
                        <button class="btn-settings" onclick="openPopup('residentPopup')">View & Manage Residents</button>
                    </div>
                </section>

                <!-- Admin & Security Management -->
                <section class="settings-section">
                    <h2>Admin & Security Management</h2>
                    <div class="setting-option">
                        <label>Manage Admins & Security:</label>
                        <button class="btn-settings" onclick="openPopup('adminSecurityPopup')">View & Manage Admins/Security</button>
                    </div>
                </section>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- Popup for Resident Management -->
    <div id="residentPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup('residentPopup')">&times;</span>
            <section id="residentSection" class="settings-detail-section">
                <h3>Resident Management</h3>
                <p>View and manage resident accounts, update roles, and handle permissions.</p>

                <!-- Create New Resident -->
                <div class="user-management-option">
                    <h4>Create New Resident</h4>
                    <form id="addResidentForm" action="#" method="post">
                        <div class="form-group">
                            <label for="residentName">Resident Name:</label>
                            <input type="text" id="residentName" name="residentName" placeholder="Enter Resident Name">
                        </div>
                        <div class="form-group">
                            <label for="residentEmail">Email:</label>
                            <input type="email" id="residentEmail" name="residentEmail" placeholder="Enter Email">
                        </div>
                        <button type="submit" class="btn-action">Create Resident</button>
                    </form>
                </div>

                <!-- View Residents -->
                <div class="user-management-option">
                    <h4>View All Residents</h4>
                    <table class="user-list">
                        <thead>
                            <tr>
                                <th>Resident Name</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td class="active">Active</td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td class="inactive">Inactive</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Deactivate Resident -->
                <div class="user-management-option">
                    <h4>Deactivate Resident</h4>
                    <form id="deactivateResidentForm" action="#" method="post">
                        <div class="form-group">
                            <label for="deactivateResident">Select Resident:</label>
                            <select id="deactivateResident" name="deactivateResident">
                                <option value="john_doe">John Doe</option>
                                <option value="jane_smith">Jane Smith</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-action">Deactivate</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <!-- Popup for Admin & Security Management -->
    <div id="adminSecurityPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup('adminSecurityPopup')">&times;</span>
            <section id="adminSecuritySection" class="settings-detail-section">
                <h3>Admin & Security Management</h3>
                <p>View and manage admin and security staff accounts, assign roles, and set permissions.</p>

                <!-- Create New Admin/Security -->
                <div class="user-management-option">
                    <h4>Create New Admin/Security</h4>
                    <form id="addAdminSecurityForm" action="#" method="post">
                        <div class="form-group">
                            <label for="userType">Select User Type:</label>
                            <select id="userType" name="userType">
                                <option value="admin">Admin</option>
                                <option value="security">Security</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="userName">Name:</label>
                            <input type="text" id="userName" name="userName" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email:</label>
                            <input type="email" id="userEmail" name="userEmail" placeholder="Enter Email">
                        </div>
                        <button type="submit" class="btn-action">Create User</button>
                    </form>
                </div>

                <!-- View All Admins and Security -->
                <div class="user-management-option">
                    <h4>View All Admins & Security</h4>
                    <table class="user-list">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Admin User</td>
                                <td>admin@example.com</td>
                                <td>Admin</td>
                                <td class="active">Active</td>
                            </tr>
                            <tr>
                                <td>Security Staff</td>
                                <td>security@example.com</td>
                                <td>Security</td>
                                <td class="inactive">Inactive</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Deactivate Admin/Security -->
                <div class="user-management-option">
                    <h4>Deactivate Admin/Security</h4>
                    <form id="deactivateAdminSecurityForm" action="#" method="post">
                        <div class="form-group">
                            <label for="deactivateUser">Select User:</label>
                            <select id="deactivateUser" name="deactivateUser">
                                <option value="admin_user">Admin User</option>
                                <option value="security_staff">Security Staff</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-action">Deactivate</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script>
        // Open the popup
        function openPopup(popupId) {
            const popup = document.getElementById(popupId);
            if (popup) {
                console.log('Opening popup:', popupId);
                popup.style.display = 'flex'; // Set the display to 'flex' to center the content
            } else {
                console.log('Popup not found:', popupId);
            }
        }

        // Close the popup
        function closePopup(popupId) {
            const popup = document.getElementById(popupId);
            if (popup) {
                console.log('Closing popup:', popupId);
                popup.style.display = 'none'; // Hide the popup when closed
            } else {
                console.log('Popup not found:', popupId);
            }
        }
    </script>
</body>

</html>
