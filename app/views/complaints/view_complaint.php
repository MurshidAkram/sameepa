<!-- APPROOT/views/complaints/view_complaint.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/complaints.css">

    <title>View Complaint | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">

        <main>
            <div class="complaint-details-container">
                <div class="page-header">
                    <h1>Complaint Details</h1>
                    <a href="<?php echo URLROOT; ?>/complaints/<?php echo in_array($_SESSION['user_role_id'], [3]) ? 'dashboard' : 'mycomplaints'; ?>"
                        class="btn btn-secondary">Back</a>
                    <?php
                    $canDelete = ($_SESSION['user_id'] == $data['complaint']->user_id && $data['complaint']->status === 'pending');
                    /* || in_array($_SESSION['user_role_id'], [2, 3]); */

                    if ($canDelete): ?>
                        <form action="<?php echo URLROOT; ?>/complaints/delete/<?php echo $data['complaint']->id; ?>" method="POST" style="display: inline;">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this complaint?');">
                                Delete Complaint
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="complaint-info">
                    <div class="info-section">
                        <div class="form-group">
                            <label>Complaint ID</label>
                            <input type="text" value="#<?php echo $data['complaint']->id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" value="<?php echo $data['complaint']->title; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Submitted By</label>
                            <input type="text" value="<?php echo $data['complaint']->user_name; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Date Submitted</label>
                            <input type="text" value="<?php echo date('M d, Y', strtotime($data['complaint']->created_at)); ?>" readonly>
                        </div>
                    </div>

                    <div class="description-section">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea readonly><?php echo $data['complaint']->description; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <?php if (in_array($_SESSION['user_role_id'], [2, 3]) && $data['complaint']->status !== 'resolved'): ?>
                                <form action="<?php echo URLROOT; ?>/complaints/updateStatus" method="POST">
                                    <input type="hidden" name="complaint_id" value="<?php echo $data['complaint']->id; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $data['complaint']->status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="in_progress" <?php echo $data['complaint']->status === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="resolved" <?php echo $data['complaint']->status === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                    </select>
                                </form>
                            <?php else: ?>
                                <input type="text" value="<?php echo ucfirst($data['complaint']->status); ?>" readonly>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="responses-section">
                        <h2>Responses</h2>
                        <div class="responses-list">
                            <?php if (!empty($data['complaint']->responses)) : ?>
                                <?php foreach ($data['complaint']->responses as $response) : ?>
                                    <div class="response-item">
                                        <div class="response-header">
                                            <span class="response-author"><?php echo $response->admin_name; ?></span>
                                            <span class="response-date"><?php echo date('M d, Y', strtotime($response->created_at)); ?></span>
                                        </div>
                                        <div class="response-content"><?php echo $response->response; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p>No responses yet.</p>
                            <?php endif; ?>
                        </div>

                        <?php if (in_array($_SESSION['user_role_id'], [2, 3]) && $data['complaint']->status !== 'resolved') : ?>
                            <div class="add-response-section">
                                <form action="<?php echo URLROOT; ?>/complaints/addResponse" method="POST">
                                    <input type="hidden" name="complaint_id" value="<?php echo $data['complaint']->id; ?>">

                                    <div class="form-group">
                                        <label>Add Response</label>
                                        <textarea name="response" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Update Status</label>
                                        <select name="status">
                                            <option value="pending" <?php echo $data['complaint']->status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="in_progress" <?php echo $data['complaint']->status === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="resolved" <?php echo $data['complaint']->status === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit Response</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>