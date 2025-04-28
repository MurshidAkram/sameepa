<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/manageUsers.css">
    <title>User Management | <?php echo SITENAME; ?></title>
</head>
<style>
    .user-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .user-modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #ccc;
        width: 50%;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: #000;
        text-decoration: none;
    }

    .user-modal-content h2 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
        text-align: center;
        border-bottom: 2px solid #800080;
        padding-bottom: 10px;
    }

    .user-modal-content p {
        margin: 10px 0;
        font-size: 16px;
        color: #555;
    }

    .user-modal-content .details-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 15px 0;
    }

    .user-modal-content .details-group span {
        font-weight: bold;
        color: #333;
    }

    .user-modal-content .details-group .detail-value {
        font-style: italic;
        color: #555;
    }



    #editAddressButton {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #0056b3;
    }

    #editAddressButton:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    #editAddressButton:active {
        background-color: #003d80;
        transform: scale(1);
    }

    #saveAddressButton {
        background-color: #800080;
        color: #fff;
        border: 1px solid #1e7e34;
    }

    #saveAddressButton:hover {
        background-color: #800080;
        color: #800080;
        transform: scale(1.05);
    }

    #saveAddressButton:active {
        background-color: #800080;
        transform: scale(1);
    }

    button+button {
        margin-left: 10px;
    }

    .user-modal #editAddressSection {
        margin-top: 20px;
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    #editAddressSection h3 {
        margin-bottom: 10px;
        font-size: 18px;
        color: #444;
    }

    #editAddressInput {
        width: calc(100% - 20px);
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        outline: none;
    }

    #editAddressInput:focus {
        border-color: #800080;
        box-shadow: 0 0 5px rgba(128, 0, 128, 0.5);
    }

    #saveAddressButton {
        display: inline-block;
        background-color: #800080;
        color: #fff;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #saveAddressButton:hover {
        background-color: #660066;
    }
</style>

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

                                            <form action="<?php echo URLROOT; ?>/users/rejectUser" method="POST" style="display: inline;" onsubmit="return confirmReject();">
                                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                <button type="submit" class="btn-reject"><i class="fas fa-times"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">No pending registration requests</div>
                    <?php endif; ?>
                </section>

                <?php
                $userTypes = [
                    'residents' => ['title' => 'Residents', 'icon' => 'fas fa-home'],
                    'admins' => ['title' => 'Administrators', 'icon' => 'fas fa-user-tie'],
                    'security' => ['title' => 'Security Staff', 'icon' => 'fas fa-shield-alt'],
                    'maintenance' => ['title' => 'Maintenance Staff', 'icon' => 'fas fa-wrench']
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
            <div id="userDetailsContent">
            </div>
        </div>
    </div>


    <script>
        function confirmReject() {
            return confirm("Are you sure you want to reject this user?");
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }

        function openUserModal(userId) {
            fetch('<?php echo URLROOT; ?>/users/getUserDetails/' + userId)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('User not found');
                    } else {
                        let userDetails = `
                    <p><strong>Name:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                `;

                        if (data.verification_filename) {
                            userDetails += `

                    <p><strong>Verification Document:</strong> ${data.verification_filename}</p>
                    <p><strong>Address:</strong> <span id="currentAddress">${data.address || 'Not available'}</span></p>
                         <p><strong>Phone Number:</strong> ${data.phonenumber || 'Not available'}</p>
                         
                `;

                            if (data.role_verification_document) {
                                userDetails += `
                        <div class="document-preview">
                            <iframe src="data:application/pdf;base64,${data.role_verification_document}" 
                                    width="100%" 
                                    height="500px" 
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
                    }
                })
                .catch(error => console.log('Error fetching user details:', error));
        }

        function enableAddressEdit(userId, currentAddress) {
            const addressInput = document.getElementById('editAddressInput');
            addressInput.value = currentAddress;
            document.getElementById('editAddressSection').style.display = "block";

            addressInput.dataset.userId = userId;
        }

        function saveAddress() {
            const addressInput = document.getElementById('editAddressInput');
            const newAddress = addressInput.value;
            const userId = addressInput.dataset.userId;

            if (!newAddress.trim()) {
                alert('Address cannot be empty!');
                return;
            }

            fetch('<?php echo URLROOT; ?>/users/updateAddress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        address: newAddress
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Address updated successfully!');
                        document.getElementById('currentAddress').textContent = newAddress;
                        document.getElementById('editAddressSection').style.display = "none";
                    } else {
                        alert('Failed to update address. Please try again.');
                    }
                })
                .catch(error => console.log('Error updating address:', error));
        }

        function closeUserModal() {
            document.getElementById('userModal').style.display = "none";
            document.getElementById('editAddressSection').style.display = "none";
        }
    </script>
</body>

</html>