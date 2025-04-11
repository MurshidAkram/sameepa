<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/polls.css">
    <title><?php echo $data['poll']['title']; ?> | <?php echo SITENAME; ?></title>

    <style>
        .poll-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            max-width: 800px;
            margin: 20px auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .poll-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .poll-meta {
            display: flex;
            justify-content: space-between;
            color: #666;
            font-size: 0.9em;
            margin: 10px 0;
        }

        .poll-choices {
            margin: 20px 0;
        }

        .choice-item {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .choice-item:hover {
            border-color: #ddd;
            background: #f9f9f9;
        }

        .choice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .progress-bar {
            height: 8px;
            background: #eee;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #800080;
            transition: width 0.3s ease;
        }

        .voters-list {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .choice-item.selected {
            border-color: #800080;
            background: #faf5fa;
        }

        .poll-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-vote {
            background: #800080;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-vote:hover {
            background: #660066;
        }

        .btn-vote:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .poll-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .status-active {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-ended {
            background: #ffebee;
            color: #c62828;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_' .
            ($_SESSION['user_role_id'] == 1 ? 'resident' : ($_SESSION['user_role_id'] == 2 ? 'admin' : 'superadmin')) . '.php'; ?>

        <main class="polls-main">
            <div class="poll-container">
                <?php flash('poll_message'); ?>
                <?php flash('poll_error'); ?>

                <div class="poll-header">
                    <span class="poll-status <?php echo $data['has_ended'] ? 'status-ended' : 'status-active'; ?>">
                        <?php echo $data['has_ended'] ? 'Ended' : 'Active'; ?>
                    </span>
                    <h1><?php echo $data['poll']['title']; ?></h1>
                    <p><?php echo $data['poll']['description']; ?></p>

                    <div class="poll-meta">
                        <span>Created by: <?php echo $data['poll']['creator_name']; ?></span>
                        <span>Ends: <?php echo date('M d, Y', strtotime($data['poll']['end_date'])); ?></span>
                        <span>Total Votes: <?php echo $data['total_votes']; ?></span>
                    </div>
                </div>

                <form action="<?php echo URLROOT; ?>/polls/vote/<?php echo $data['poll']['id']; ?>" method="POST">
                    <div class="poll-choices">
                        <?php foreach ($data['choices'] as $choice) : ?>
                            <div class="choice-item <?php echo ($data['user_vote'] == $choice->id) ? 'selected' : ''; ?>">
                                <div class="choice-header">
                                    <label>
                                        <?php if (!$data['has_ended'] && !$data['user_vote']) : ?>
                                            <input type="radio" name="choice_id" value="<?php echo $choice->id; ?>"
                                                <?php echo ($data['user_vote'] == $choice->id) ? 'checked' : ''; ?>>
                                        <?php endif; ?>
                                        <?php echo $choice->choice_text; ?>
                                    </label>
                                    <span><?php echo $choice->percentage; ?>% (<?php echo $choice->vote_count; ?> votes)</span>
                                </div>

                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $choice->percentage; ?>%"></div>
                                </div>

                                <?php if ($data['poll']['created_by'] == $_SESSION['user_id'] || $_SESSION['user_role_id'] >= 2) : ?>
                                    <div class="voters-list">
                                        <strong>Voters:</strong>
                                        <?php if (!empty($choice->voters)) : ?>
                                            <?php echo implode(', ', array_column($choice->voters, 'name')); ?>
                                        <?php else : ?>
                                            No votes yet
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!$data['has_ended'] && !$data['user_vote']) : ?>
                        <div class="poll-actions">
                            <a href="<?php echo URLROOT; ?>/polls" class="btn btn-back">Back to Polls</a>
                            <button type="submit" class="btn-vote">Submit Vote</button>
                        </div>
                    <?php elseif ($data['user_vote']) : ?>
                        <p class="text-center">You have already voted in this poll.</p>
                    <?php else : ?>
                        <p class="text-center">This poll has ended.</p>
                    <?php endif; ?>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Toggle voters list for poll creator/admin
        <?php if ($data['poll']->created_by == $_SESSION['user_id'] || $_SESSION['user_role_id'] >= 2) : ?>
            document.querySelectorAll('.choice-item').forEach(item => {
                item.addEventListener('click', () => {
                    const votersList = item.querySelector('.voters-list');
                    if (votersList) {
                        votersList.style.display = votersList.style.display === 'none' ? 'block' : 'none';
                    }
                });
            });
        <?php endif; ?>
    </script>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>