<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/pages/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Welcome | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="slider">
            <div class="slide" style="background-image: url('<?php echo URLROOT; ?>/public/img/home1.jpg');"></div>
            <div class="slide" style="background-image: url('<?php echo URLROOT; ?>/public/img/home2.jpg');"></div>
            <div class="slide" style="background-image: url('<?php echo URLROOT; ?>/public/img/home3.jpg');"></div>
        </div>
        <div class="hero-content">
            <h1>Welcome to Sameepa</h1>
            <p>Your community management system. SAMEEPA is designed to streamline and enhance your community living experience.</p>
            <div class="cta-buttons">
                <a href="<?php echo URLROOT; ?>/pages/about" class="btn-primary">About us</a>
                <a href="<?php echo URLROOT; ?>/pages/contact" class="btn-secondary">Contact us</a>
            </div>
        </div>
    </section>


    <section class="about-section">
        <h2 class="section-title">Explore Our Features</h2>
        <div class="about-content">
            <div class="box">
                <img src="<?php echo URLROOT; ?>/public/img/events.jpg" alt="Events and Announcements" class="box-image">
                <h3>Events & Announcements</h3>
                <p>Stay updated with the latest events and announcements tailored for your community and business.</p>
                <!-- <a href="<?php echo URLROOT; ?>/pages/events" class="btn-secondary">View Events</a> -->
            </div>
            <div class="box">
                <img src="<?php echo URLROOT; ?>/public/img/forums.jpg" alt="Forums" class="box-image">
                <h3>Forums</h3>
                <p>Engage with like-minded individuals in our forums to discuss and share knowledge on relevant topics.</p>
                <!-- <a href="<?php echo URLROOT; ?>/pages/forums" class="btn-secondary">Join Forums</a> -->
            </div>
            <div class="box">
                <img src="<?php echo URLROOT; ?>/public/img/services.jpg" alt="External Services" class="box-image">
                <h3>External Services</h3>
                <p>Discover our trusted external services to complement your business needs and enhance productivity.</p>
                <!-- <a href="<?php echo URLROOT; ?>/pages/services" class="btn-secondary">Explore Services</a> -->
            </div>
        </div>
    </section>


    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>




</html>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heroSection = document.querySelector('.hero-section');
        const images = heroSection.getAttribute('data-images').split(',');
        let currentIndex = 0;

        function changeBackgroundImage() {
            heroSection.style.backgroundImage = `url('${images[currentIndex]}')`;
            currentIndex = (currentIndex + 1) % images.length; // Loop through the images
        }

        // Initial background image change
        changeBackgroundImage();

        // Change background image every 5 seconds
        setInterval(changeBackgroundImage, 5000);
    });
</script>