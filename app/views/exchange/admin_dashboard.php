<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/admin_dashboard.css">
    <title>Admin Dashboard - Exchange Center | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        switch ($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <main class="admin-exchange-main">
            <div class="admin-header">
                <h1>Exchange Center Management</h1>
                <div class="search-container">
                    <input type="text" placeholder="Search listings..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/exchange/create" class="btn-create">
                    <i class="fas fa-plus"></i> Create New Listing
                </a>
            </div>

            <div class="listings-stats">
                <div class="stat-card">
                    <i class="fas fa-list"></i>
                    <div class="stat-info">
                        <h3>Total Listings</h3>
                        <p>24</p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-exchange-alt"></i>
                    <div class="stat-info">
                        <h3>Active Exchanges</h3>
                        <p>12</p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-tools"></i>
                    <div class="stat-info">
                        <h3>Services</h3>
                        <p>8</p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-shopping-cart"></i>
                    <div class="stat-info">
                        <h3>Items for Sale</h3>
                        <p>4</p>
                    </div>
                </div>
            </div>

            <div class="listings-table-container">
                <div class="table-header">
                    <h2>All Listings</h2>
                    <div class="all-types-container">
                        <span class="filter-label">Type:</span>
                        <div class="filter-container">
                            <select class="filter-select" id="statusFilter">
                                <option value="all">All Types</option>
                                <option value="service">Services</option>
                                <option value="sale">For Sale</option>
                                <option value="exchange">Exchange</option>
                                <option value="lost">Lost & Found</option>
                            </select>
                        </div>
                    </div>
                </div>

                <table class="listings-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Posted By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lawn Mowing Service</td>
                            <td><span class="type-badge service">Service</span></td>
                            <td>John Doe</td>
                            <td>2023-07-10</td>
                            <td><span class="status-badge active">Active</span></td>
                            <td class="action-buttons">
                                <a href="<?php echo URLROOT; ?>/exchange/view_listing" class="ebtnview">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo URLROOT; ?>/exchange/edit_listing" class="ebtnedit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="ebtndelete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Vintage Bicycle</td>
                            <td><span class="type-badge sale">Sale</span></td>
                            <td>Jane Smith</td>
                            <td>2023-07-12</td>
                            <td><span class="status-badge active">Active</span></td>
                            <td class="action-buttons">
                                <a href="<?php echo URLROOT; ?>/exchange/view_listing" class="ebtnview">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo URLROOT; ?>/exchange/edit_listing" class="ebtnedit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="ebtndelete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>