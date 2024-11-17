<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <style>
        .dashboard-overview {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .settings-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .settings-section h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .user-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .user-list th,
        .user-list td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .user-list th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .user-list tr:hover {
            background-color: #f5f5f5;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .status-active {
            background-color: #e6f4ea;
            color: #1e7e34;
        }

        .status-inactive {
            background-color: #feeced;
            color: #dc3545;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-activate {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-deactivate {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
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
                    <h2>Pending Registration Requests</h2>
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
                                                <button type="submit" class="btn-activate">Activate</button>
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

                <!-- Active Users Sections -->
                <?php
                $userTypes = [
                    'residents' => ['title' => 'Residents', 'icon' => '🏠'],
                    'admins' => ['title' => 'Administrators', 'icon' => '👨‍💼'],
                    'security' => ['title' => 'Security Staff', 'icon' => '🛡️'],
                    'maintenance' => ['title' => 'Maintenance Staff', 'icon' => '🔧'],
                    'external' => ['title' => 'External Service Providers', 'icon' => '🤝']
                ];

                foreach ($userTypes as $key => $type) : ?>
                    <section class="settings-section">
                        <h2><?php echo $type['icon'] . ' ' . $type['title']; ?></h2>
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
</body>

</html>