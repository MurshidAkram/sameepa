<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Welcome | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="home-content-wrapper">
        <main>
            <div class="left-section">
                <h1>Welcome to <?php echo SITENAME; ?></h1>
                <p>Your community management system. SAMEEPA is designed to streamline and enhance your community living experience.</p>
            </div>
            <div class="right-section" style="background-image: url('<?php echo URLROOT; ?>/public/img/homelogo.jpg');"></div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>