<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/facilities.css">
    <title>Manage Facilities | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main>
            <div class="time-card">
                <span class="time">12:30 PM</span>
                <span class="date">June 15, 2023</span>
            </div>

            <h1>Manage Facilities</h1>
            <p>Welcome to the Facilities Management page. Here, you can add, edit, or remove community facilities.</p>
              <section class="facility-bookings-overview">
                <div class="header-container">
                    <h1>Existing Facilities</h1>
                    <a href="#" class="btn btn-create">Create New Facility</a>
                </div>
                  <table class="facility-bookings-table">
                      <thead>
                          <tr>
                              <th>Facility Name</th>
                              <th>Capacity</th>
                              <th>Status</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>Community Pool</td>
                              <td>50</td>
                              <td>Available</td>
                              <td>
                                  <a href="#">View</a> |
                                  <a href="#">Edit</a> |
                                  <a href="#">Delete</a> 
                              </td>
                          </tr>
                          <tr>
                              <td>Tennis Court</td>
                              <td>4</td>
                              <td>Unavailable</td>
                              <td>
                                  <a href="#">View</a> |
                                  <a href="#">Edit</a> |
                                  <a href="#">Delete</a>
                              </td>
                          </tr>
                          <tr>
                              <td>Gym</td>
                              <td>30</td>
                              <td>Available</td>
                              <td>
                                  <a href="#">View</a> |
                                  <a href="#">Edit</a> |
                                  <a href="#">Delete</a>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </section>

            <section class="facility-booking-requests">
                <!-- <h2>Facility Booking Requests</h2> -->
                <div class="header-container">
                    <h1>Manage Bookings</h1>
                    <div class="button-container">
                        <a href="<?php echo URLROOT; ?>/admin/create_booking" class="btn-create">Create New Booking</a>
                        <a href="#" class="btn-history">View Booking History</a>
                    </div>
                </div>

                <table class="facility-bookings-table">
                    <thead>
                        <tr>
                            <th>Resident Name</th>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Permisson</th>
                            <th>More Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Community Pool</td>
                            <td>June 20, 2023</td>
                            <td>2:00 PM - 4:00 PM</td>
                            <td>Confirmed</td>
                            <td>
                                <a href="#" class="btn-accept">Accept</a> |
                                <a href="#" class="btn-decline">Decline</a>                     
                            </td>
                            <td>
                                <a href="#" class="btn-view">View Details</a> 
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Tennis Court</td>
                            <td>June 21, 2023</td>
                            <td>10:00 AM - 12:00 PM</td>
                            <td>Pending</td>
                            <td>
                                <a href="#" class="btn-accept">Accept</a> |
                                <a href="#" class="btn-decline">Decline</a> 
                            </td>
                            <td>
                                <a href="#" class="btn-view">View Details</a> 
                            </td>
                        </tr>
                        <tr>
                            <td>Mike Johnson</td>
                            <td>Gym</td>
                            <td>June 22, 2023</td>
                            <td>6:00 PM - 8:00 PM</td>
                            <td>Cancelled</td>
                            <td>
                                <a href="#" class="btn-accept">Accept</a> |
                                <a href="#" class="btn-decline">Decline</a> 
                            </td>
                            <td>
                                <a href="#" class="btn-view">View Details</a> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
</html>
