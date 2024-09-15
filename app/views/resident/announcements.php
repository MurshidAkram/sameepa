<!-- app/views/resident/announcements.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/announcements.css">
    <title>Community Announcements | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <h1>Community Announcements</h1>
            <p>Stay updated with the latest news and information from your community.</p>

            <div class="announcements-list">
                <?php
                // Dummy announcements data
                $announcements = [
                    [
                        'id' => 1,
                        'title' => 'Change in Garbage Disposal Time',
                        'content' => 'Please note that starting next week, garbage disposal time will be changed from 8 PM to 9 PM. This change is to accommodate...',
                        'date' => '2023-05-15',
                        'likes' => 24,
                        'dislikes' => 3
                    ],
                    [
                        'id' => 2,
                        'title' => 'Scheduled Power Cut',
                        'content' => 'We would like to inform you that there will be a scheduled power cut on Saturday, May 20th, from 10 AM to 2 PM due to essential maintenance work...',
                        'date' => '2023-05-14',
                        'likes' => 18,
                        'dislikes' => 7
                    ],
                    [
                        'id' => 3,
                        'title' => 'Community Pool Opening',
                        'content' => 'Great news! Our community pool will be opening for the summer season on June 1st we have made several improvements...',
                        'date' => '2023-05-13',
                        'likes' => 56,
                        'dislikes' => 0
                    ],

                    [
                        'id' => 4,
                        'title' => 'Raise in Rent rates',
                        'content' => 'Rent rates have been increased for the first time since 10 years...',
                        'date' => '2023-05-13',
                        'likes' => 0,
                        'dislikes' => 100
                    ],
                    [
                        'id' => 5,
                        'title' => 'Free eye clinic to be held for all residents above 65 years old in area',
                        'content' => 'Rent rates have been increased for the first time since 10 years...',
                        'date' => '2023-05-13',
                        'likes' => 0,
                        'dislikes' => 100
                    ],
                    [
                        'id' => 6,
                        'title' => 'Maintenance Team Unavailability next week',
                        'content' => 'Great news! Our community pool will be opening for the summer season on June 1st we have made several improvements...',
                        'date' => '2023-05-13',
                        'likes' => 0,
                        'dislikes' => 100
                    ],
                    [
                        'id' => 7,
                        'title' => 'Change in the paint scheme of the community building and wall',
                        'content' => 'Great news! Our community pool will be opening for the summer season on June 1st we have made several improvements...',
                        'date' => '2023-05-13',
                        'likes' => 20,
                        'dislikes' => 100
                    ]

                ];

                foreach ($announcements as $announcement) :
                ?>
                    <div class="announcement-card">
                        <h2><?php echo $announcement['title']; ?></h2>
                        <p class="announcement-date"><?php echo $announcement['date']; ?></p>
                        <p class="announcement-preview"><?php echo substr($announcement['content'], 0, 100) . '...'; ?></p>
                        <div class="announcement-actions">
                            <div class="reaction-buttons">
                                <button class="btn-react btn-like" data-announcement-id="<?php echo $announcement['id']; ?>">
                                    👍 <span class="like-count"><?php echo $announcement['likes']; ?></span>
                                </button>
                                <button class="btn-react btn-dislike" data-announcement-id="<?php echo $announcement['id']; ?>">
                                    👎 <span class="dislike-count"><?php echo $announcement['dislikes']; ?></span>
                                </button>
                            </div>
                            <a href="<?php echo URLROOT; ?>/resident/announcement/<?php echo $announcement['id']; ?>" class="btn-view-full">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script src="<?php echo URLROOT; ?>/js/announcements.js"></script>
</body>

</html>