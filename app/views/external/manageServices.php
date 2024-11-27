<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/manageservices.css">
    <title>Service Requests | <?php echo SITENAME; ?></title>

</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>
        <main>
            <section id="add-service">
                <h1>Add New Service</h1>
                <form method="POST" action="services.php" class="service-form">
                    <label for="title">Service Title:</label>
                    <input type="text" name="title" id="title" required>

                    <label for="category">Category:</label>
                    <input type="text" name="category" id="category" required>

                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" required>

                    <label for="availability">Availability:</label>
                    <input type="text" name="availability" id="availability" required>

                    <button type="submit" name="add_service" onclick="" showSuccessMessage(event)"">Add Service</button>
                </form>
            </section>

            <section id="view-services">
                <h1>Service List</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Plumbing</td>
                            <td>Home Repair</td>
                            <td>2000</td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>Car Wash</td>
                            <td>Vehicle Services</td>
                            <td>1500</td>
                            <td>Not Available</td>
                        </tr>
                        <tr>
                            <td>Electrician</td>
                            <td>Home Repair</td>
                            <td>2500</td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>Gardening</td>
                            <td>Outdoor Services</td>
                            <td>1800</td>
                            <td>Available</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script>
        function showSuccessMessage(event) {
            event.preventDefault(); // Prevent form submission
            alert('Service added successfully!');
        }
    </script>
</body>

</html>