<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/admin_dashboard.css">
    <title>Facilities Admin Dashboard | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <main class="admin-facilities-main">
            <div class="admin-header">
                <h1>Facility Management Dashboard</h1>
                <div class="search-container">
                    <input type="text" id="searchFacility" placeholder="Search facilities..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/facilities/create" class="btn-create">
                    <i class="fas fa-plus"></i> Create New Facility
                </a>
                <a href="<?php echo URLROOT; ?>/facilities/allbookings" class="btn-view-bookings">
                    <i class="fas fa-calendar-check"></i> View All Bookings
                </a>
                <a href="<?php echo URLROOT; ?>/facilities/allmybookings" class="btn-my-bookings">
                    <i class="fas fa-calendar-alt"></i> My Bookings
                </a>
            </div>

            <div class="facilities-stats">
                <div class="stat-card">
                    <i class="fas fa-building"></i>
                    <div class="stat-info">
                        <h3>Total Facilities</h3>
                        <p><?php echo count($data['facilities']); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-check-circle"></i>
                    <div class="stat-info">
                        <h3>Available Facilities</h3>
                        <p><?php echo count(array_filter($data['facilities'], function($f) { return $f->status === 'available'; })); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calendar"></i>
                    <div class="stat-info">
                        <h3>Active Bookings</h3>
                        <p><?php echo isset($data['active_bookings']) ? $data['active_bookings'] : 0; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <div class="stat-info">
                        <h3>Total Capacity</h3>
                        <p><?php echo array_sum(array_column((array)$data['facilities'], 'capacity')); ?></p>
                    </div>
                </div>
            </div>

            <div class="facilities-table-container">
                <div class="table-header">
                    <h2>All Facilities</h2>
                    <div class="filter-container">
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                </div>

                <table class="facilities-table">
                    <thead>
                        <tr>
                            <th>Facility Name</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['facilities'] as $facility): ?>
                        <tr>
                            <td><?php echo $facility->name; ?></td>
                            <td><?php echo $facility->capacity; ?></td>
                            <td>
                                <span class="status-badge <?php echo $facility->status; ?>">
                                    <?php echo ucfirst($facility->status); ?>
                                </span>
                            </td>
                            <td><?php echo $facility->creator_name; ?></td>
                            <td class="action-buttons">
                                <button onclick="viewFacility(<?php echo $facility->id; ?>)" class="fbtnview">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="editFacility(<?php echo $facility->id; ?>)" class="fbtnedit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="<?php echo URLROOT; ?>/facilities/delete/<?php echo $facility->id; ?>" method="POST" style="display: inline;">
                                    <button type="submit" class="fbtndelete" onclick="return confirm('Are you sure you want to delete this facility?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- View Facility Modal -->
            <div id="viewFacilityModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Facility Details</h2>
                    <div class="facility-details">
                        <p><strong>Name:</strong> <span id="viewName"></span></p>
                        <p><strong>Description:</strong> <span id="viewDescription"></span></p>
                        <p><strong>Capacity:</strong> <span id="viewCapacity"></span></p>
                        <p><strong>Status:</strong> <span id="viewStatus"></span></p>
                        <p><strong>Created By:</strong> <span id="viewCreator"></span></p>
                    </div>
                </div>
            </div>

            <!-- Edit Facility Modal -->
            <div id="editFacilityModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Facility</h2>
                    <form id="editFacilityForm">
                        <input type="hidden" id="editId">
                        <div class="form-group">
                            <label for="editName">Facility Name:</label>
                            <input type="text" id="editName" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description:</label>
                            <textarea id="editDescription" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editCapacity">Capacity:</label>
                            <input type="number" id="editCapacity" required min="1">
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status:</label>
                            <select id="editStatus" required>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit">Update Facility</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="<?php echo URLROOT; ?>/js/facilities_admin.js"></script>
</body>
</html>
