<!-- Ensure the CSS is loaded correctly -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navbar.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<nav class="navbar">
    <div class="navdiv">
        <!-- Logo image with link to home page -->
        <a href="<?php echo URLROOT; ?>" class="navbar-logo">
            <img src="<?php echo URLROOT; ?>/public/img/sitelogo.svg" alt="Sameepa Logo">
        </a>
        <ul class="navbar-menu">
            <li><a href="<?php echo URLROOT; ?>">Home</a></li>
            <li><a href="<?php echo URLROOT; ?>/pages/about">About Us</a></li>
            <li><a href="<?php echo URLROOT; ?>/pages/contact">Contact Us</a></li>
            <button><a href="<?php echo URLROOT; ?>/users/signup">Sign Up</a></button>
            <button><a href="<?php echo URLROOT; ?>/users/login">Login</a></button>
        </ul>
    </div>
</nav>