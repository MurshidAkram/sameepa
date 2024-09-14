<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/facilities.css">
    <title>Facility Booking | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <h1>Your Facility Bookings</h1>
            <p>Here you can view and manage your facility bookings such as gym, pool, halls, and more.</p>

            <section class="facility-bookings-overview">
                <h2>Active Bookings</h2>
                <p>Below is a list of your active facility bookings. You can update or cancel them as necessary.</p>

                <table class="facility-bookings-table">
                    <thead>
                        <tr>
                            <th>Facility Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Community Hall</td>
                            <td>Sept 22, 2024</td>
                            <td>4:00 PM - 6:00 PM</td>
                            <td>Confirmed</td>
                            <td>
                                <a href="#">Update</a> |
                                <a href="#">Cancel</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Swimming Pool</td>
                            <td>Sept 24, 2024</td>
                            <td>10:00 AM - 11:00 AM</td>
                            <td>Pending</td>
                            <td>
                                <a href="#">Update</a> |
                                <a href="#">Cancel</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Gym</td>
                            <td>Sept 27, 2024</td>
                            <td>5:00 PM - 6:00 PM</td>
                            <td>Cancelled</td>
                            <td>
                                <a href="#">Rebook</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="create-facility-booking">
                <h2>Book a New Facility</h2>
                <p>Need to book a facility? Select from the available facilities and choose your preferred date and time.</p>
                <a href="<?php echo URLROOT; ?>/resident/create_facility_booking" class="btn-create">Book Facility</a>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>