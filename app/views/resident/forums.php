<!-- app/views/resident/forums.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/forums.css">
    <title>Community Forums | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="forums-main">
            <h1>Community Forums</h1>
            <p>Engage in open discussions with your community members!</p>

            <div class="forums-actions">
                <a href="<?php echo URLROOT; ?>/resident/create_forum" class="btn-create-forum">Create New Forum</a>
                <a href="<?php echo URLROOT; ?>/resident/my_forums" class="btn-my-forums">My Forums</a>
            </div>

            <div class="forums-list">
                <?php
                // Dummy forums data
                $forums = [
                    [
                        'id' => 1,
                        'title' => 'Community Garden Ideas',
                        'description' => 'Share your ideas for our upcoming community garden project.',
                        'created_by' => 'John Doe',
                        'comment_count' => 15
                    ],
                    [
                        'id' => 2,
                        'title' => 'Neighborhood Watch Program',
                        'description' => 'Discuss strategies for improving our neighborhood watch program.',
                        'created_by' => 'Jane Smith',
                        'comment_count' => 8
                    ],
                    [
                        'id' => 3,
                        'title' => 'Local Business Recommendations',
                        'description' => 'Recommend and discuss local businesses in our area.',
                        'created_by' => 'Mike Johnson',
                        'comment_count' => 22
                    ]
                ];

                foreach ($forums as $forum) :
                ?>
                    <div class="forum-card">
                        <h2 class="forum-title"><?php echo $forum['title']; ?></h2>
                        <p class="forum-description"><?php echo $forum['description']; ?></p>
                        <div class="forum-details">
                            <span class="forum-creator">Created by: <?php echo $forum['created_by']; ?></span>
                            <span class="forum-comments">💬: <?php echo $forum['comment_count']; ?></span>
                        </div>
                        <a href="<?php echo URLROOT; ?>/resident/view_forum/<?php echo $forum['id']; ?>" class="btn-view-forum">View Forum</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>