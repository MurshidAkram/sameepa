<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/polls.css">
    <title>My Polls | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
        switch ($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>

        <main class="polls-main">
            <h1>My Polls</h1>
            <p>Here are the polls you've created</p>

            <div class="polls-actions">
                <a href="<?php echo URLROOT; ?>/polls/create" class="btn-create-poll">Create New Poll</a>
                <a href="<?php echo URLROOT; ?>/polls" class="btn-my-polls">All Polls</a>
            </div>

            <?php
            if (empty($data['polls'])) : ?>
                <div class="no-polls-message">
                    <p>You haven't created any polls yet. <a href="<?php echo URLROOT; ?>/polls/create">Create a poll!</a></p>
                </div>
            <?php else : ?>
                <div class="polls-list">
                    <?php foreach ($data['polls'] as $poll) : ?>
                        <div class="poll-card">
                            <h2 class="poll-title"><?php echo $poll->title; ?></h2>
                            <p class="poll-description"><?php echo $poll->description; ?></p>
                            <div class="poll-details">
                                <span class="poll-votes">Total Votes: <?php echo $poll->total_votes ?? 0; ?></span>
                                <span class="poll-end-date">Ends: <?php echo date('M d, Y', strtotime($poll->end_date)); ?></span>
                            </div>
                            <div class="poll-actions">
                                <a href="<?php echo URLROOT; ?>/polls/viewpoll/<?php echo $poll->id; ?>" class="btn-view-poll">View Results</a>
                                <a href="<?php echo URLROOT; ?>/polls/delete/<?php echo $poll->id; ?>"
                                    class="btn-delete-poll"
                                    onclick="return confirm('Are you sure you want to delete this poll?');">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>