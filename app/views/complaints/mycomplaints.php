<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/complaints.css">
    <title>Complaints | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
        $role_panels = [
            1 => '/views/inc/components/side_panel_resident.php',
            4 => '/views/inc/components/side_panel_maintenance.php',
            5 => '/views/inc/components/side_panel_security.php'
        ];
        require APPROOT . ($role_panels[$_SESSION['user_role_id']] ?? $role_panels[1]);
        ?>

        <main>
            <div class="complaints-container">
                <div class="page-header">
                    <h1>My Complaints</h1>
                    <a href="<?php echo URLROOT; ?>/complaints/create" class="btn btn-primary">Create New Complaint</a>
                    <?php
                    if ($_SESSION['user_role_id'] == 2) {
                    ?>

                        <a href="<?php echo URLROOT; ?>/complaints/dashboard" class="btn btn-primary">Dashboard</a>


                    <?php } ?>

                </div>

                <div class="complaints-list">
                    <?php if (!empty($data['complaints'])) : ?>
                        <?php foreach ($data['complaints'] as $complaint) : ?>
                            <div class="announcement-card complaint-card" data-id="<?php echo $complaint->id; ?>">
                                <div class="announcement-content">
                                    <h2><?php echo $complaint->title; ?></h2>
                                    <div class="announcement-meta">
                                        <span>Submitted: <?php echo date('M d, Y', strtotime($complaint->created_at)); ?></span>
                                        <span class="complaint-status status-<?php echo strtolower($complaint->status); ?>">
                                            <?php echo ucfirst($complaint->status); ?>
                                        </span>
                                    </div>
                                    <div class="announcement-preview">
                                        <?php echo substr($complaint->description, 0, 150) . '...'; ?>
                                    </div>
                                    <div class="announcement-actions">
                                        <a href="<?php echo URLROOT; ?>/complaints/viewcomplaint/<?php echo $complaint->id; ?>" class="btn-react">
                                            View Details
                                        </a>
                                        <?php if ($complaint->status === 'pending'): ?>
                                            <form action="<?php echo URLROOT; ?>/complaints/delete/<?php echo $complaint->id; ?>" method="POST" style="display: inline;">
                                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this complaint?');">
                                                    Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No complaints found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

</body>

</html>