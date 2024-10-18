<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/users.css"> <!-- Link to the new CSS file -->
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
                                    <td>Active</td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td>Inactive</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Deactivate Resident -->
                    <div class="user-management-option deactivate-section">
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

                <!-- Admin & Security Management -->
                <section class="settings-section">
                    <h2>Admin & Security Management</h2>
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
                                    <td>Active</td>
                                </tr>
                                <tr>
                                    <td>Security Staff</td>
                                    <td>security@example.com</td>
                                    <td>Security</td>
                                    <td>Inactive</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Deactivate Admin/Security -->
                    <div class="user-management-option deactivate-section">
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
            </section>
           
        </main>
        
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

</body>

</html>
