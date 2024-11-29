<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/polls.css">
    <title>Community Garden Location | Community Site</title>
    <style>
        .poll-view-container {
            max-width: 800px;
            margin: 2rem auto;
            background: linear-gradient(135deg, #f6f8f9 0%, #e5ebee 100%);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .poll-details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 1rem;
        }

        .poll-choices {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .poll-choice {
            display: flex;
            align-items: center;
            background-color: white;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .poll-choice:hover {
            border-color: #800080;
            box-shadow: 0 0 0 3px rgba(128, 0, 128, 0.1);
        }

        .poll-choice-vote-btn {
            background-color: #800080;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            margin-left: auto;
            transition: background-color 0.3s ease;
        }

        .poll-choice-vote-btn:hover {
            background-color: #660066;
        }
    </style>
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
            <div class="poll-view-container">
                <div class="poll-details-header">
                    <div>
                        <h1>Community Garden Location</h1>
                        <p>Help us decide the best location for our new community garden. Your input matters!</p>
                    </div>
                    <div>
                        <small>Ends: <?php echo date('M d, Y', strtotime('+2 weeks')); ?></small>
                    </div>
                </div>

                <form action="#" method="POST" class="poll-choices">
                    <?php
                    $choices = [
                        ['id' => 1, 'text' => 'North Side Park'],
                        ['id' => 2, 'text' => 'Community Center Grounds'],
                        ['id' => 3, 'text' => 'Vacant Lot on Main Street'],
                        ['id' => 4, 'text' => 'Behind the Library']
                    ];

                    foreach ($choices as $choice): ?>
                        <div class="poll-choice">
                            <span><?php echo $choice['text']; ?></span>
                            <button type="submit" name="choice_id" value="<?php echo $choice['id']; ?>" class="poll-choice-vote-btn">
                                Vote
                            </button>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>