<!-- app/views/resident/groups.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/groups.css">
    <title>Community Groups | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="groups-main">
            <aside class="groups-sidebar">
                <h2>Group Navigation</h2>
                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/resident/create_group" class="btn-create-group">Create Group</a>
                    <a href="<?php echo URLROOT; ?>/resident/joined_groups" class="btn-joined-groups">Joined Groups</a>
                    <a href="<?php echo URLROOT; ?>/resident/my_groups" class="btn-my-groups">My Groups</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>Community Groups</h1>
                <p>Discover and join exciting groups in your community!</p>

                <div class="groups-container">
                    <?php
                    // Dummy groups data
                    $groups = [
                        [
                            'id' => 1,
                            'name' => 'Book Club',
                            'description' => 'Join us for monthly book discussions and literary events!',
                            'members' => 15,
                            'created_by' => 'John Doe'
                        ],
                        [
                            'id' => 2,
                            'name' => 'Cooking Club',
                            'description' => 'Share recipes, cooking tips, and enjoy delicious meals together!',
                            'members' => 20,
                            'created_by' => 'Jane Smith'
                        ],
                        [
                            'id' => 3,
                            'name' => 'Fitness Enthusiasts',
                            'description' => 'Stay motivated and achieve your fitness goals with like-minded neighbors!',
                            'members' => 12,
                            'created_by' => 'Mike Johnson'
                        ]
                    ];

                    foreach ($groups as $group) :
                    ?>
                        <div class="group-card">
                            <h2 class="group-name"><?php echo $group['name']; ?></h2>
                            <div class="group-details">
                                <p><?php echo $group['description']; ?></p>
                                <p>Members: <?php echo $group['members']; ?></p>
                                <p>Created by: <?php echo $group['created_by']; ?></p>
                            </div>
                            <div class="group-actions">
                                <a href="<?php echo URLROOT; ?>/resident/join_group/<?php echo $group['id']; ?>" class="btn-join-group">Join Group</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>