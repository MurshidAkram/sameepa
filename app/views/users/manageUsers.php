<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/superadmin/manageUsers.css">
    <title>User Management | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <div class="dashboard-overview">
                <section class="settings-section">
                    <div class="section">
                        <h2>Pending Registration Requests</h2>
                        <div class="button-container">
                            <a href="<?php echo URLROOT; ?>/users/createUser" class="btn-create">
                                <i class="fas fa-user-plus"></i> Create
                            </a>
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
                                                <button type="submit" class="btn-accept"><i class="fas fa-check"></i></button>
                                            </form>
                                            <button class="btn-view" onclick="openUserModal(<?php echo $user->id; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form action="<?php echo URLROOT; ?>/users/rejectUser" method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                <button type="submit" class="btn-reject"><i class="fas fa-times"></i></button>
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
                    // 'external' => ['title' => 'External Service Providers', 'icon' => 'fas fa-handshake']
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
                                                        <button type="submit" class="btn-deactivate"><i class="fas fa-power-off"></i></button>
                                                    </form>
                                                    <form action="<?php echo URLROOT; ?>/users/deleteActivatedUser" method="POST" style="display: inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to permanently delete this user?');"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="<?php echo URLROOT; ?>/users/activateUser" method="POST" style="display: inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                        <button type="submit" class="btn-activate"><i class="fas fa-check-circle"></i></button>
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

    <div id="userModal" class="user-modal">
        <div class="user-modal-content">
            <span class="close-btn" onclick="closeUserModal()">×</span>
            <h2>User Details</h2>
            <div id="userDetailsContent"></div>
        </div>
    </div>

    <script>
        function openUserModal(userId) {
            fetch('<?php echo URLROOT; ?>/users/getUserDetails/' + userId)
                .then(response => response.json())
                .then(data => {
                    let userDetails = `
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Email:</strong> ${data.email}</p>
            `;
                    console.log(data);

                    if (data.verification_filename) {
                        userDetails += `
                    <p><strong>Verification Document:</strong> ${data.verification_filename}</p>
                    
                `;

                        if (data.role_verification_document) {
                            userDetails += `
                        <div class="document-preview">
                            <iframe src="data:application/pdf;base64,${data.role_verification_document}" 
                                    width="100%" 
                                    height="300px" 
                                    type="application/pdf">
                                Your browser does not support PDFs. 
                                Please download the PDF to view it.
                            </iframe>
                            
                        </div>
                    `;
                        } else {
                            userDetails += '<p>Document preview unavailable.</p>';
                        }
                    }

                    document.getElementById('userDetailsContent').innerHTML = userDetails;
                    document.getElementById('userModal').style.display = "block";
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                    alert('Failed to fetch user details');
                });
        }

        function closeUserModal() {
            document.getElementById('userModal').style.display = "none";
        }
    </script>

</body>

</html>