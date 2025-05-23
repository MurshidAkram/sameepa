<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/calendar.css">
    <title>Book Facility | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    
    <div class="dashboard-container">
        <?php 
            // Load appropriate side panel based on user role
            switch($_SESSION['user_role_id']) {
                case 1:
                    require APPROOT . '/views/inc/components/side_panel_resident.php';
                    break;
                case 2:
                    require APPROOT . '/views/inc/components/side_panel_admin.php';
                    break;
                case 3:
                    require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                    break;
            }
        ?>

        <main class="content">
            <div class="booking-container">
                <div class="booking-left-panel">
                    <div class="calendar" data-facility-id="<?php echo $data['facility']['id']; ?>">
                        <div class="calendar-header">
                            <button class="month-nav" id="prevMonth"><</button>
                            <h2 id="currentMonth">August 2023</h2>
                            <button class="month-nav" id="nextMonth">></button>
                        </div>
                        <div class="calendar-days">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>
                        <div class="calendar-dates" id="calendarDates">
                            <!-- Dates will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="booked-times-container">
                     <div class="bookedtimes">
                        <h2>Booked Times</h2>
                        <table class="booked-times-table">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Duration</th>
                                    <th>Booked By</th>
                                </tr>
                            </thead>
                            <tbody id="bookedTimesBody">
                                <?php if(isset($data['booked_times'])): ?>
                                    <?php foreach($data['booked_times'] as $booking): ?>
                                        <tr class="<?php echo ($booking->user_id == $_SESSION['user_id']) ? 'own-booking' : ''; ?>">
                                            <td><?php echo $booking->booking_time; ?></td>
                                            <td><?php echo $booking->duration; ?> hours</td>
                                            <td><?php echo $booking->booked_by; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3">Select a date to view bookings</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                     </div>
                    </div>
                    <div id="booking-error"></div>
                </div>
                  <div class="booking-right-panel">
                      <div class="booking-form-container">
                          <h1>Book <?php echo $data['facility']['name']; ?></h1>
                          <script>
                          function validateBookingForm() {
                              const bookingDate = new Date(document.getElementById('booking_date').value);
                              const today = new Date();
                              today.setHours(0,0,0,0);
                              const duration = document.getElementById('duration').value;
                            
                              if (bookingDate < today) {
                                  alert('Cannot book dates in the past');
                                  return false;
                              }

                              if (duration < 1 || duration > 8) {
                                  alert('Duration must be between 1 and 8 hours');
                                  return false;
                              }

                              return true;
                          }
                          </script>
                          <form action="<?php echo URLROOT; ?>/facilities/book/<?php echo $data['facility']['id']; ?>" method="POST" onsubmit="return validateBookingForm()">

                              <input type="hidden" name="facility_id" value="<?php echo $data['facility']['id']; ?>">
                              <input type="hidden" name="facility_name" value="<?php echo $data['facility']['name']; ?>">
                            
                              <div class="form-group">
                                  <label for="booking_date">Date:</label>
                                  <input type="date" name="booking_date" id="booking_date" required>
                              </div>
                              <div class="form-group">
                                  <label for="booking_time">Selected Time:</label>
                                  <input type="time" name="booking_time" id="booking_time" required>
                              </div>
                              <div class="form-group">
                                  <label for="duration">Duration (hours):</label>
                                  <input type="number" name="duration" id="duration" min="1" max="8" required>
                              </div>
                       
                              <input type="hidden" name="resident_id" value="<?php echo $_SESSION['user_id']; ?>">

                              <div class="form-group">
                                  <label for="booked_by">Your Name:</label>
                                  <input type="text" name="booked_by" id="booked_by" value="<?php echo $_SESSION['name']; ?>" required>
                              </div>

                              <div class="form-buttons">
                                  <button type="submit" class="btn btn-primary">Book Facility</button>
                                  <?php if ($_SESSION['user_role_id'] == 1): ?>
                                        <a href="<?php echo URLROOT; ?>/facilities/index" class="btn btn-cancel">Cancel</a>
                                    <?php elseif ($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3): ?>
                                        <a href="<?php echo URLROOT; ?>/facilities/allmybookings" class="btn btn-cancel">Cancel</a>
                                    <?php else: ?>
                                        <a href="<?php echo URLROOT; ?>/" class="btn btn-cancel">Cancel</a>
                                    <?php endif; ?>
                              </div>
                          </form>
                      </div>

                      <div class="bookings-table-container">
                        <div class="my-bookings">
                            <h2>My Bookings</h2>
                            <table class="bookings-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody id="bookingsTableBody">
                                    <?php if(isset($data['my_bookings'])): ?>
                                        <?php foreach($data['my_bookings'] as $booking): ?>
                                            <tr>
                                                <td><?php echo $booking->booking_date; ?></td>
                                                <td><?php echo $booking->booking_time; ?></td>
                                                <td><?php echo $booking->duration; ?> hours</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                      </div>
                  </div>
              </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script>
        const URLROOT = '<?php echo URLROOT; ?>';
    </script>
    <script src="<?php echo URLROOT; ?>/js/facility_booking.js"></script>
</body>
</html>
