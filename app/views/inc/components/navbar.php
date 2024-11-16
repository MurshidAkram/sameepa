<!-- Ensure the CSS is loaded correctly -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navbar.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<!-- navbar.php -->
<nav class="navbar">
    <div class="navdiv">
        <!-- Logo image with link to home page -->
        <a href="<?php echo URLROOT; ?>" class="navbar-logo">
            <img src="<?php echo URLROOT; ?>/public/img/sitelogo.svg" alt="Sameepa Logo">
        </a>
        <ul class="navbar-menu">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <li>
                    <a href="<?php echo URLROOT; ?>/users/profile">
                        <img src="<?php echo URLROOT; ?>/public/img/profile.png" alt="Profile" class="profile-pic">
                    </a>
                </li>
                <li><a href="<?php echo URLROOT; ?>/users/logout">Logout</a></li>
            <?php else : ?>
                <li><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li><a href="<?php echo URLROOT; ?>/pages/about">About Us</a></li>
                <li><a href="<?php echo URLROOT; ?>/pages/contact">Contact Us</a></li>
                <li><a href="<?php echo URLROOT; ?>/users/signup">Sign Up</a></li>
                <li><a href="<?php echo URLROOT; ?>/users/login">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>