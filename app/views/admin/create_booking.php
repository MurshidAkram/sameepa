
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/facilities.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/dashboard.css">
    <title>Facility Bookings | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main class="facility-bookings-main">
            <h1>Facility Bookings</h1>
            <p>Book community facilities or view your booking history.</p>

            <div class="facility-booking-container">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button id="prevMonth">&lt;</button>
                        <h2 id="currentMonth"></h2>
                        <button id="nextMonth">&gt;</button>
                    </div>
                    <div class="calendar-grid" id="calendarGrid"></div>
                </div>

                <div class="booking-form-container">
                    <h2>Book a Facility</h2>
                    <form id="bookingForm">
                        <div class="form-group">
                            <label for="facility">Facility:</label>
                            <select id="facility" name="facility" required>
                                <option value="">Select a facility</option>
                                <option value="pool">Swimming Pool</option>
                                <option value="gym">Gym</option>
                                <option value="hall">Community Hall</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time:</label>
                            <input type="time" id="time" name="time" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (hours):</label>
                            <input type="number" id="duration" name="duration" min="1" max="4" required>
                        </div>
                        <button type="submit" class="btn-book">Book Facility</button>
                    </form>
                </div>
            </div>

            <div class="booking-history">
                <h2>Your Booking History</h2>
                <table id="bookingHistoryTable">
                    <thead>
                        <tr>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Booking history will be populated here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script src="<?php echo URLROOT; ?>/js/create_bookings.js"></script>
</body>

</html>