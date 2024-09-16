<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/users.css">
    <title>Super Admin Settings | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <h1>Super Admin Settings</h1>

            <!-- System Settings -->
            <section class="settings-section">
                <h2>System Settings</h2>
                <div class="setting-option">
                    <label>Communication:</label>
                    <button class="btn-settings" onclick="toggleSection('communicationSection')">Email & Notifications</button>
                </div>
                <div class="setting-option">
                    <label>Backup & Restore:</label>
                    <button class="btn-settings" onclick="toggleSection('backupRestoreSection')">Backup & Restore</button>
                </div>
                <div class="setting-option">
                    <label>Logs & Reports:</label>
                    <button class="btn-settings" onclick="toggleSection('logsReportsSection')">View Logs & Reports</button>
                </div>
            </section>

            <!-- User Management Section -->
            <section class="settings-section">
                <h2>General Settings</h2>
                <div class="setting-option">
                    <label>User Management:</label>
                    <button class="btn-settings" onclick="toggleSection('userManagementSection')">Manage Users & Roles</button>
                </div>
            </section>

            <!-- User Management Expanded Section -->
            <section id="userManagementSection" class="settings-detail-section">
                <h3>User Management</h3>
                <p>Administer user accounts, assign roles, and manage access permissions.</p>

                <!-- Add New User -->
                <div class="user-management-option">
                    <h4>Create New User</h4>
                    <form id="addUserForm" action="#" method="post">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select id="role" name="role">
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-action">Create User</button>
                    </form>
                </div>

                <!-- Assign Roles -->
                <div class="user-management-option">
                    <h4>Assign Roles</h4>
                    <form id="assignRoleForm" action="#" method="post">
                        <div class="form-group">
                            <label for="user">Select User:</label>
                            <select id="user" name="user">
                                <option value="john_doe">John Doe</option>
                                <option value="jane_doe">Jane Doe</option>
                                <option value="admin_user">Admin User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="role">Assign Role:</label>
                            <select id="assignRole" name="role">
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-action">Assign Role</button>
                    </form>
                </div>

                <!-- Deactivate User -->
                <div class="user-management-option">
                    <h4>Deactivate User</h4>
                    <form id="deactivateUserForm" action="#" method="post">
                        <div class="form-group">
                            <label for="deactivateUser">Select User:</label>
                            <select id="deactivateUser" name="deactivateUser">
                                <option value="john_doe">John Doe</option>
                                <option value="jane_doe">Jane Doe</option>
                                <option value="admin_user">Admin User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-action">Deactivate</button>
                    </form>
                </div>

                <!-- View All Users -->
                <div class="user-management-option">
                    <h4>View All Users</h4>
                    <table class="user-list">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>Admin</td>
                                <td>Active</td>
                            </tr>
                            <tr>
                                <td>Jane Doe</td>
                                <td>jane@example.com</td>
                                <td>Editor</td>
                                <td>Inactive</td>
                            </tr>
                            <tr>
                                <td>Admin User</td>
                                <td>admin@example.com</td>
                                <td>Admin</td>
                                <td>Active</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Toggle the visibility of sections
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section.style.display === 'block') {
                section.style.display = 'none';
            } else {
                section.style.display = 'block';
            }
        }
    </script>
</body>

</html>

