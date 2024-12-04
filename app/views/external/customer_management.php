<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/customer.css">
    <title>Service Requests | <?php echo SITENAME; ?></title>

</head>

<body>

    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

        <main>
            <section id="customer-contacts">
                <h1>Customer Contacts</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jane Doe</td>
                            <td>jane.doe@example.com</td>
                            <td>+123456789</td>
                            <td>
                                <button class="btn view-feedback" data-id="1">View Feedback</button>
                            </td>
                        </tr>
                        <tr>
                            <td>John Smith</td>
                            <td>john.smith@example.com</td>
                            <td>+987654321</td>
                            <td>
                                <button class="btn view-feedback" data-id="2">View Feedback</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Emily Johnson</td>
                            <td>emily.johnson@example.com</td>
                            <td>+192837465</td>
                            <td>
                                <button class="btn view-feedback" data-id="3">View Feedback</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section id="ratings-feedback">
                <h1>Ratings & Feedback</h1>
                <div id="feedback-content">
                    <p>Select a customer to view feedback.</p>
                </div>
            </section>

            <section id="customer-history">
                <h1>Customer History</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jane Doe</td>
                            <td>Service A</td>
                            <td>2024-09-15</td>
                            <td>$150</td>
                        </tr>
                        <tr>
                            <td>John Smith</td>
                            <td>Service B</td>
                            <td>2024-08-22</td>
                            <td>$200</td>
                        </tr>
                        <tr>
                            <td>Emily Johnson</td>
                            <td>Service C</td>
                            <td>2024-07-10</td>
                            <td>$100</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        // JavaScript to handle feedback viewing
        document.querySelectorAll('.view-feedback').forEach(button => {
            button.addEventListener('click', async (event) => {
                event.preventDefault();
                const customerId = button.dataset.id;
                const response = await fetch(`fetch_feedback.php?customer_id=${customerId}`);
                const feedbackContent = await response.text();
                document.getElementById('feedback-content').innerHTML = feedbackContent;
            });
        });
    </script>
</body>

</html>