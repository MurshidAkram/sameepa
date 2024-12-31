<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/polls.css">
    <title>Community Polls | <?php echo SITENAME; ?></title>
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
            <h1>Community Polls</h1>
            <p>Share your opinion and help shape our community!</p>

            <div class="polls-actions">
                <a href="<?php echo URLROOT; ?>/polls/create" class="btn-create-poll">Create New Poll</a>
                <a href="<?php echo URLROOT; ?>/polls/mypolls" class="btn-my-polls">My Polls</a>
            </div>

            <div class="polls-list">
                <?php
                $samplePolls = [
                    (object)[
                        'id' => 1,
                        'title' => 'Community Garden Location',
                        'description' => 'Help us decide the best location for our new community garden. Your input matters!',
                        'created_by' => 5,
                        'end_date' => date('Y-m-d', strtotime('+2 weeks'))
                    ],
                    (object)[
                        'id' => 2,
                        'title' => 'Weekend Community Event',
                        'description' => 'Vote for the type of community event you\'d like to see this summer.',
                        'created_by' => 3,
                        'end_date' => date('Y-m-d', strtotime('+1 month'))
                    ],
                    (object)[
                        'id' => 3,
                        'title' => 'Playground Renovation',
                        'description' => 'We want to improve our community playground. Share your thoughts on what upgrades are needed most.',
                        'created_by' => 1,
                        'end_date' => date('Y-m-d', strtotime('+3 weeks'))
                    ],
                    (object)[
                        'id' => 4,
                        'title' => 'New Recycling Program',
                        'description' => 'Should we implement a more comprehensive recycling program in our community?',
                        'created_by' => 2,
                        'end_date' => date('Y-m-d', strtotime('+1 week'))
                    ]
                ];
                $data['polls'] = $samplePolls;

                foreach ($data['polls'] as $poll) : ?>
                    <div class="poll-card">
                        <h2 class="poll-title"><?php echo $poll->title; ?></h2>
                        <p class="poll-description"><?php echo $poll->description; ?></p>
                        <div class="poll-details">
                            <span class="poll-creator">Created by: Resident</span>
                            <span class="poll-end-date">Ends: <?php echo date('M d, Y', strtotime($poll->end_date)); ?></span>
                        </div>
                        <div class="poll-actions">
                            <a href="<?php echo URLROOT; ?>/polls/view_poll/<?php echo $poll->id; ?>" class="btn-view-poll">View Poll</a>
                            <?php if ($poll->created_by == $_SESSION['user_id'] || $_SESSION['user_role_id'] >= 2) : ?>
                                <a href="<?php echo URLROOT; ?>/polls/edit/<?php echo $poll->id; ?>" class="btn-edit-poll">Edit</a>
                                <a href="<?php echo URLROOT; ?>/polls/delete/<?php echo $poll->id; ?>" class="btn-delete-poll">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>