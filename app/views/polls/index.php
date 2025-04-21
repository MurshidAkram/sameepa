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

    <style>
        .poll-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .poll-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .poll-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            margin-bottom: 10px;
        }

        .status-active {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .status-ended {
            background-color: #ffebee;
            color: #c62828;
        }

        .status-voted {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .poll-stats {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
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

            <?php flash('poll_message'); ?>

            <div class="polls-list">
                <?php if (!empty($data['polls'])) : ?>
                    <?php foreach ($data['polls'] as $poll) : ?>
                        <div class="poll-card">
                            <?php if ($poll->has_ended) : ?>
                                <span class="poll-status status-ended">Ended</span>
                            <?php elseif ($poll->user_has_voted) : ?>
                                <span class="poll-status status-voted">Voted</span>
                            <?php else : ?>
                                <span class="poll-status status-active">Active</span>
                            <?php endif; ?>

                            <h2 class="poll-title"><?php echo $poll->title; ?></h2>
                            <p class="poll-description"><?php echo $poll->description; ?></p>

                            <div class="poll-details">
                                <span class="poll-creator">Created by: <?php echo $poll->creator_name; ?></span>
                                <span class="poll-end-date">Ends: <?php echo date('M d, Y', strtotime($poll->end_date)); ?></span>
                            </div>

                            <div class="poll-stats">
                                <span><?php echo $poll->total_votes; ?> votes</span>
                                <span><?php echo $poll->total_choices; ?> choices</span>
                            </div>

                            <div class="poll-actions">
                                <a href="<?php echo URLROOT; ?>/polls/viewpoll/<?php echo $poll->id; ?>" class="btn-view-poll">
                                    <?php echo $poll->user_has_voted ? 'View Results' : 'Vote Now'; ?>
                                </a>

                                <?php if ($poll->created_by == $_SESSION['user_id'] || $_SESSION['user_role_id'] >= 2) : ?>
                                    <?php if (!$poll->has_ended) : ?>
                                        <!--                                         <a href="<?php echo URLROOT; ?>/polls/edit/<?php echo $poll->id; ?>" class="btn-edit-poll">Edit</a>
 --> <?php endif; ?>
                                    <a href="<?php echo URLROOT; ?>/polls/delete/<?php echo $poll->id; ?>"
                                        class="btn-delete-poll"
                                        onclick="return confirm('Are you sure you want to delete this poll?');">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No polls have been created yet.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>