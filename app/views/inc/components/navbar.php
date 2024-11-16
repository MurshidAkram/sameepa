<?php
// At the top of navbar.php, instantiate the user model
require_once APPROOT . '/models/M_Users.php';
$userModel = new M_Users();
?>

<!-- navbar.php -->
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
            <li><a href="<?php echo URLROOT; ?>">Home</a></li>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <!-- Show different navigation based on user role -->
                <?php switch ($_SESSION['user_role_id']):
                    case 1: // Resident 
                ?>
                        <li><a href="<?php echo URLROOT; ?>/resident/dashboard">Dashboard</a></li>
                    <?php break;
                    case 2: // Admin 
                    ?>
                        <li><a href="<?php echo URLROOT; ?>/admin/dashboard">Dashboard</a></li>
                    <?php break;
                    case 3: // SuperAdmin 
                    ?>
                        <li><a href="<?php echo URLROOT; ?>/superadmin/dashboard">Dashboard</a></li>
                    <?php break;
                    case 4: // Maintenance 
                    ?>
                        <li><a href="<?php echo URLROOT; ?>/maintenance/dashboard">Dashboard</a></li>
                    <?php break;
                    case 5: // Security 
                    ?>
                        <li><a href="<?php echo URLROOT; ?>/security/dashboard">Dashboard</a></li>
                    <?php break;
                    case 6: // External Service Provider 
                    ?>
                        <li><a href="<?php echo URLROOT; ?>/external/dashboard">Dashboard</a></li>
                <?php break;
                endswitch; ?>

                <!-- Profile dropdown -->
                <li class="profile-dropdown">
                    <a href="<?php echo URLROOT; ?>/users/profile" class="profile-link">
                        <?php
                        $user = $userModel->getUserById($_SESSION['user_id']);
                        if (!empty($user['profile_picture'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_picture']); ?>"
                                alt="<?php echo htmlspecialchars($_SESSION['name']); ?>"
                                class="profile-pic">
                        <?php else: ?>
                            <img src="<?php echo URLROOT; ?>/public/img/default-profile.png"
                                alt="Default Profile"
                                class="profile-pic">
                        <?php endif; ?>
                        <span class="profile-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                    </a>
                </li>
                <li><a href="<?php echo URLROOT; ?>/users/logout" class="logout-link">Logout</a></li>
            <?php else : ?>
                <li><a href="<?php echo URLROOT; ?>/pages/about">About Us</a></li>
                <li><a href="<?php echo URLROOT; ?>/pages/contact">Contact Us</a></li>
                <li><a href="<?php echo URLROOT; ?>/users/signup">Sign Up</a></li>
                <li><a href="<?php echo URLROOT; ?>/users/login">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<style>
    /* Add these styles to your navbar.css or include them here */
    .navbar {
        background: rgb(239, 245, 245);
        padding-right: 15px;
        padding-left: 15px;
        font-family: 'Poppins', sans-serif;
    }

    .navdiv {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: 'Poppins', sans-serif;
    }

    .navbar-logo img {
        height: 80px;
    }

    .navbar-menu {
        display: flex;
        align-items: center;
        gap: 2rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .navbar-menu a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .navbar-menu a:hover {
        color: #007bff;
    }

    .profile-dropdown {
        position: relative;
    }

    .profile-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        border-radius: 25px;
        transition: background-color 0.3s ease;
    }

    .profile-link:hover {
        background-color: #f0f0f0;
    }

    .profile-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-name {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .logout-link {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .logout-link:hover {
        background-color: #e9ecef;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .navbar {
            padding: 1rem;
        }

        .navdiv {
            flex-direction: column;
            gap: 1rem;
        }

        .navbar-menu {
            flex-direction: column;
            gap: 1rem;
            width: 100%;
        }

        .profile-name {
            display: none;
        }

        .profile-link {
            justify-content: center;
        }
    }
</style>