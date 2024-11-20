<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Other head content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/manageUsers.css">
    <title>User Management | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <div class="dashboard-overview">
                <!-- Pending Users Section -->
                <section class="settings-section">
                    <div class="section">
                        <h2>Pending Registration Requests</h2>
                        <div class="button-container">
                            <a href="<?php echo URLROOT; ?>/users/createUser" class="btn-create"> + Create</a>
                        </div>
                    </div>

                    <?php if (!empty($data['pending_users'])) : ?>
                        <table class="user-list">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registration Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['pending_users'] as $user) : ?>
                                    <tr>
                                        <td><?php echo $user->name; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->role_name; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($user->registration_date)); ?></td>
                                        <td class="action-buttons">
                                            <form action="<?php echo URLROOT; ?>/users/activateUser" method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                <button type="submit" class="btn-accept">Accept</button>
                                            </form>
                                            <button class="btn-view" onclick="openUserModal(<?php echo $user->id; ?>)">View</button>
                                            <form action="<?php echo URLROOT; ?>/users/rejectUser" method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                <button type="submit" class="btn-reject">Reject</button>
                                            </form>

                                            <!-- <button type="ignore"class="btn-ignore">Ignore</button> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">No pending registration requests</div>
                    <?php endif; ?>
                </section>

                <!-- Active Users Sections -->
                <?php
                $userTypes = [
                    'residents' => ['title' => 'Residents', 'icon' => 'fas fa-home'],
                    'admins' => ['title' => 'Administrators', 'icon' => 'fas fa-user-tie'],
                    'security' => ['title' => 'Security Staff', 'icon' => 'fas fa-shield-alt'],
                    'maintenance' => ['title' => 'Maintenance Staff', 'icon' => 'fas fa-wrench'],
                    'external' => ['title' => 'External Service Providers', 'icon' => 'fas fa-handshake']
                ];

                foreach ($userTypes as $key => $type) : ?>
                    <section class="settings-section">
                        <h2><i class="<?php echo $type['icon']; ?>"></i> <?php echo $type['title']; ?></h2>
                        <?php if (!empty($data[$key])) : ?>
                            <table class="user-list">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data[$key] as $user) : ?>
                                        <tr>
                                            <td><?php echo $user->name; ?></td>
                                            <td><?php echo $user->email; ?></td>
                                            <td>
                                                <span class="status-badge <?php echo $user->is_active ? 'status-active' : 'status-inactive'; ?>">
                                                    <?php echo $user->is_active ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td class="action-buttons">
                                                <?php if ($user->is_active) : ?>
                                                    <form action="<?php echo URLROOT; ?>/users/deactivateUser" method="POST" style="display: inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                        <button type="submit" class="btn-deactivate">Deactivate</button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="<?php echo URLROOT; ?>/users/activateUser" method="POST" style="display: inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                        <button type="submit" class="btn-activate">Activate</button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="empty-state">No <?php echo strtolower($type['title']); ?> registered</div>
                        <?php endif; ?>
                    </section>
                <?php endforeach; ?>


            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- Modal for viewing user details -->
    <div id="userModal" class="user-modal">
        <div class="user-modal-content">
            <span class="close-btn" onclick="closeUserModal()">×</span>
            <h2>User Details</h2>
            <div id="userDetailsContent"></div>
        </div>
    </div>

    <!-- Add JavaScript at the bottom of the page -->
    <script>
        function openUserModal(userId) {
            // Fetch user details via AJAX (or PHP) based on user ID
            fetch('<?php echo URLROOT; ?>/users/getUserDetails/' + userId)
                .then(response => response.json())
                .then(data => {
                    // Populate the modal with user details
                    if (data.error) {
                        alert('User not found');
                    } else {
                        let userDetails = `
                    <p><strong>Name:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Address:</strong> ${data.address}</p>
                `;
                        document.getElementById('userDetailsContent').innerHTML = userDetails;
                        // Show the modal (at the bottom)
                        document.getElementById('userModal').style.display = "block";
                    }
                })
                .catch(error => console.log('Error fetching user details:', error));
        }

        // Close the modal
        function closeUserModal() {
            document.getElementById('userModal').style.display = "none";
        }
    </script>

</body>

</html>