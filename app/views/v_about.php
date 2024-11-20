<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <title>About Us | <?php echo SITENAME; ?></title>
    <style>
        /* Combined background for title and mission section */
        .about-section {
            background: url('<?php echo URLROOT; ?>/public/img/aboutus.jpg') no-repeat center center/cover;
            background-color: rgba(0, 0, 0, 0.5);
            /* Add a semi-transparent layer */
            background-blend-mode: darken;
            /* Darken the background image */
            color: #fff;
            padding: 150px 100px;
            text-align: right;
            /* Align text to the right */
        }

        .mission-section {
            margin-top: 30px;
        }

        .about-section h1 {
            font-size: 3.5rem;
            margin-bottom: 30px;
            color: #fff;
            text-align: right;
            /* Ensure the heading is aligned to the right */
        }

        .about-section p {
            font-size: 1.5rem;
            line-height: 1.8;
            margin: 30px 0 0 auto;
            /* Adjust margin for right alignment */
            max-width: 1000px;
            color: #f3f3f3;
            text-align: right;
            /* Ensure the paragraph is aligned to the right */
        }

        .mission-section {
            margin-top: 30px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;

        }

        main {
            text-align: center;
            padding: 50px 20px;
        }

        h1 {
            color: #800080;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            margin-bottom: 30px;
            font-size: 18px;
        }


        .team-section {
            margin-top: 50px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            justify-content: center;
        }

        .team-member {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .team-member img {
            width: 150px;
            height: 150px;
            object-fit: scale-down;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .team-member h3 {
            color: #800080;
            margin-bottom: 5px;
        }

        .team-member p {
            color: #777;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <main>
        <section class="about-section">
            <h1>About Us</h1>
            <div class="mission-section">
                <p>
                    Welcome to our community management system. Our goal is to enhance the living experience within housing schemes and apartment complexes. Our system provides event management, facility booking, maintenance requests, and more, making it easier to manage your living community.
                </p>
            </div>
        </section>

        <section class="team-section">
            <h2>Meet the Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="<?php echo URLROOT; ?>/public/img/murshid.jpg" alt="Member 1">
                    <h3>Murshid Akram</h3>
                    <p>Role: Team Member</p>
                </div>
                <div class="team-member">
                    <img src="<?php echo URLROOT; ?>/public/img/sankavi.jpg" alt="Member 2">
                    <h3>Sankavi Thayaparan</h3>
                    <p>Role: Team Member</p>
                </div>
                <div class="team-member">
                    <img src="<?php echo URLROOT; ?>/public/img/senuja.jpg" alt="Member 3">
                    <h3>Senuja Udugampola</h3>
                    <p>Role: Team Member</p>
                </div>
                <div class="team-member">
                    <img src="<?php echo URLROOT; ?>/public/img/malith.jpeg" alt="Member 4">
                    <h3>Malith Damsara</h3>
                    <p>Role: Team Member</p>
                </div>
            </div>
        </section>
    </main>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>