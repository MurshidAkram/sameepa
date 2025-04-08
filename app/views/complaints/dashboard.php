<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/complaints.css">
    <title>Complaints Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_' . ($_SESSION['user_role_id'] == 3 ? 'superadmin' : 'admin') . '.php'; ?>

        <main>
            <div class="dashboard-header">
                <h1>Complaints Dashboard</h1>
            </div>

            <!-- Dashboard Stats -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <h3>Total Complaints</h3>
                    <p><?php echo $data['stats']['total']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Pending</h3>
                    <p><?php echo $data['stats']['pending']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>In Progress</h3>
                    <p><?php echo $data['stats']['in_progress']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Resolved</h3>
                    <p><?php echo $data['stats']['resolved']; ?></p>
                </div>
                <?php
                if ($_SESSION['user_role_id'] == 2) {
                ?>

                    <a href="<?php echo URLROOT; ?>/complaints/create" class="btn btn-primary">Create New Complaint</a>
                    <a href="<?php echo URLROOT; ?>/complaints/mycomplaints" class="btn btn-primary">My Complaints</a>


                <?php } ?>

            </div>

            <!-- Complaints Tables -->
            <?php
            $sections = [
                'resident' => ['title' => 'Resident Complaints', 'role_id' => 1],
                'maintenance' => ['title' => 'Maintenance Staff Complaints', 'role_id' => 4],
                'security' => ['title' => 'Security Staff Complaints', 'role_id' => 5]
            ];

            // Add admin complaints section for superadmin only
            if ($_SESSION['user_role_id'] == 3) {
                $sections['admin'] = ['title' => 'Admin Complaints', 'role_id' => 2];
            }

            foreach ($sections as $key => $section):
            ?>
                <div class="complaints-section" id="<?php echo $key; ?>-complaints">
                    <h2><?php echo $section['title']; ?></h2>
                    <div class="table-responsive">
                        <table class="complaints-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Submitted By</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['complaints'][$key] as $complaint): ?>
                                    <tr data-complaint-id="<?php echo $complaint->id; ?>">
                                        <td>#<?php echo $complaint->id; ?></td>
                                        <td><?php echo $complaint->title; ?></td>
                                        <td><?php echo $complaint->user_name; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($complaint->created_at)); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $complaint->status; ?>">
                                                <?php echo ucfirst($complaint->status); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo URLROOT; ?>/complaints/viewcomplaint/<?php echo $complaint->id; ?>" class="btn btn-sm btn-view">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </main>
    </div>



    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

</body>

</html>