<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/exchange.css">
    <title>Security Duty Schedule | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="exchange-main">
            <h1>Security Duty Schedule</h1>
            <p>View the current security officers on duty and their contact information.</p>

            <div class="exchange-actions">
                <a href="<?php echo URLROOT; ?>/resident/incident" class="btn-create-listing">Report an Incident</a>
            </div>

            <div class="exchange-grid">
                <?php
                // Dummy data - replace with actual data from your database
                $security_officers = [
                    [
                        'id' => '1',
                        'name' => 'Vishwa Nimsara',
                        'shift' => '8 AM - 12 PM',
                        'contact' => '+94 77 123 4567',
                        'photo' => 'security-officer-1.jpg'
                    ],
                    [
                        'id' => '2',
                        'name' => 'Malith Damsara',
                        'shift' => '12 PM - 4 PM',
                        'contact' => '+94 77 987 6543',
                        'photo' => 'security-officer-2.jpg'
                    ],
                    [
                        'id' => '3',
                        'name' => 'Sasila Sadamsara',
                        'shift' => '4 PM - 12 AM',
                        'contact' => '+94 77 456 7890',
                        'photo' => 'security-officer-3.jpg'
                    ],
                    [
                        'id' => '4',
                        'name' => 'Geeth Pasida',
                        'shift' => '12 AM - 8 AM',
                        'contact' => '+94 77 234 5678',
                        'photo' => 'security.jpeg'
                    ]
                ];

                foreach ($security_officers as $officer) :
                ?>
                    <div class="listing-card">
                        <img src="<?php echo URLROOT; ?>/img/security.jpg" alt="<?php echo $officer['name']; ?>" class="listing-image">
                        <h2 class="listing-title"><?php echo $officer['name']; ?></h2>
                        <div class="listing-details">
                            <p>Officer ID: <span class="listing-type"><?php echo $officer['id']; ?></span></p>
                            <p>Shift: <?php echo $officer['shift']; ?></p>
                            <p>Contact: <?php echo $officer['contact']; ?></p>
                        </div>
                        <a href="tel:<?php echo str_replace(' ', '', $officer['contact']); ?>" class="btn-view-listing">Call Officer</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>