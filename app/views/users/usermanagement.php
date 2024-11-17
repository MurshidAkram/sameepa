<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
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

                <!-- Registration Requests -->
                <section class="settings-section">
                    <h2>Registration Requests</h2>
                    <div class="user-management-option">
                        <h4>Pending Registration Requests</h4>
                        <table class="user-list">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Requested Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Alice Johnson</td>
                                    <td>alice@example.com</td>
                                    <td>Resident</td>
                                    <td>
                                        <form action="#" method="post" class="request-action-form">
                                            <input type="hidden" name="user_id" value="alice_johnson">
                                            <button type="submit" name="action" value="approve" class="btn-approve">Approve</button>
                                            <button type="submit" name="action" value="reject" class="btn-reject">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bob Smith</td>
                                    <td>bob@example.com</td>
                                    <td>Security</td>
                                    <td>
                                        <form action="#" method="post" class="request-action-form">
                                            <input type="hidden" name="user_id" value="bob_smith">
                                            <button type="submit" name="action" value="approve" class="btn-approve">Approve</button>
                                            <button type="submit" name="action" value="reject" class="btn-reject">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

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

                <!-- Admin Management -->
                <section class="settings-section">
                    <h2>Admin Management</h2>
                    <div class="user-management-option">
                        <h4>View All Admins</h4>
                        <table class="user-list">
                            <thead>
                                <tr>
                                    <th>Admin Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Admin User</td>
                                    <td>admin@example.com</td>
                                    <td>Active</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="user-management-option deactivate-section">
                        <h4>Deactivate Admin</h4>
                        <form id="deactivateAdminForm" action="#" method="post">
                            <div class="form-group">
                                <label for="deactivateAdmin">Select Admin:</label>
                                <select id="deactivateAdmin" name="deactivateAdmin">
                                    <option value="admin_user">Admin User</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-action">Deactivate</button>
                        </form>
                    </div>
                </section>

                <!-- Security Management -->
                <section class="settings-section">
                    <h2>Security Management</h2>
                    <div class="user-management-option">
                        <h4>View All Security Staff</h4>
                        <table class="user-list">
                            <thead>
                                <tr>
                                    <th>Security Staff Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Security Staff</td>
                                    <td>security@example.com</td>
                                    <td>Inactive</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="user-management-option deactivate-section">
                        <h4>Deactivate Security Staff</h4>
                        <form id="deactivateSecurityForm" action="#" method="post">
                            <div class="form-group">
                                <label for="deactivateSecurity">Select Security Staff:</label>
                                <select id="deactivateSecurity" name="deactivateSecurity">
                                    <option value="security_staff">Security Staff</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-action">Deactivate</button>
                        </form>
                    </div>
                </section>


                <!-- External Service Providers -->
                <section class="settings-section">
                    <h2>External Service Providers</h2>
                    <div class="user-management-option">
                        <h4>View All Service Providers</h4>
                        <table class="user-list">
                            <thead>
                                <tr>
                                    <th>Provider Name</th>
                                    <th>Service Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cleaning Co.</td>
                                    <td>Cleaning</td>
                                    <td>Active</td>
                                </tr>
                                <tr>
                                    <td>Repair Corp.</td>
                                    <td>Repairs</td>
                                    <td>Inactive</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="user-management-option deactivate-section">
                        <h4>Deactivate Service Provider</h4>
                        <form id="deactivateProviderForm" action="#" method="post">
                            <div class="form-group">
                                <label for="deactivateProvider">Select Provider:</label>
                                <select id="deactivateProvider" name="deactivateProvider">
                                    <option value="cleaning_co">Cleaning Co.</option>
                                    <option value="repair_corp">Repair Corp.</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-action">Deactivate</button>
                        </form>
                    </div>
                </section>

                <!-- Maintenance Team Management -->
                <section class="settings-section">
                    <h2>Maintenance Team</h2>
                    <div class="user-management-option">
                        <h4>View All Maintenance Staff</h4>
                        <table class="user-list">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Maintenance Lead</td>
                                    <td>lead@example.com</td>
                                    <td>Active</td>
                                </tr>
                                <tr>
                                    <td>Technician Smith</td>
                                    <td>tech.smith@example.com</td>
                                    <td>Inactive</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="user-management-option deactivate-section">
                        <h4>Deactivate Maintenance Staff</h4>
                        <form id="deactivateMaintenanceForm" action="#" method="post">
                            <div class="form-group">
                                <label for="deactivateMaintenance">Select Staff:</label>
                                <select id="deactivateMaintenance" name="deactivateMaintenance">
                                    <option value="maintenance_lead">Maintenance Lead</option>
                                    <option value="technician_smith">Technician Smith</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-action">Deactivate</button>
                        </form>
                    </div>
                </section>

            </section>

            <!-- Additional sections for other roles can go here -->

            </section>
        </main>

    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('aside ul li a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    sidebarLinks.forEach(link => link.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>