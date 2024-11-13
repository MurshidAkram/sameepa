<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
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
                <h1>Book <?php echo $data['facility']['name']; ?></h1>
                
                <div class="calendar-section">
                    <div id="calendar"></div>
                </div>

                <form action="<?php echo URLROOT; ?>/facilities/book/<?php echo $data['facility']['id']; ?>" method="POST">
                    <input type="hidden" name="facility_id" value="<?php echo $data['facility']['id']; ?>">
                    <input type="hidden" name="facility_name" value="<?php echo $data['facility']['name']; ?>">
                    <div class="form-group">
                        <label for="booking_date">Date:</label>
                        <input type="date" name="booking_date" id="booking_date" required>
                    </div>

                    <div class="time-slots">
                        <h3>Available Time Slots</h3>
                        <div id="timeSlots"></div>
                    </div>

                    <div class="form-group">
                        <label for="booking_time">Time:</label>
                        <input type="time" name="booking_time" id="booking_time" required>
                    </div>

                    <div class="form-group">
                        <label for="duration">Duration (hours):</label>
                        <input type="number" name="duration" id="duration" min="1" max="8" required>
                    </div>
               
                    <!-- Add this inside your existing form, after the facility_id hidden input -->
                    <input type="hidden" name="resident_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <div class="form-group">
                        <label for="booked_by">Your Name:</label>
                        <input type="text" name="booked_by" id="booked_by" value="<?php echo $_SESSION['name']; ?>" required>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Book Facility</button>
                        <a href="<?php echo URLROOT; ?>/facilities" class="btn-cancel">Cancel</a>
                    </div>

                    
                </form>

                <div class="my-bookings">
                    <h2>My Bookings</h2>
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="bookingsTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
                <script>
                    const facilityId = <?php echo $data['facility']['id']; ?>;
                      document.addEventListener('DOMContentLoaded', function() {
                          const bookingForm = document.querySelector('form');
                          const timeInput = document.getElementById('booking_time');
                          const dateInput = document.getElementById('booking_date');

                          // Update time slots when date changes
                          dateInput.addEventListener('change', async function() {
                              const selectedDate = this.value;
                              const response = await fetch(`<?php echo URLROOT; ?>/facilities/getBookings/${facilityId}/${selectedDate}`);
                              const bookings = await response.json();
                              updateTimeSlots(bookings);
                          });

                          // Handle time slot selection
                          document.getElementById('timeSlots').addEventListener('click', function(e) {
                              const timeSlot = e.target.closest('.time-slot');
                              if (timeSlot && timeSlot.classList.contains('available')) {
                                  const selectedTime = timeSlot.querySelector('span').textContent;
                                  timeInput.value = selectedTime;

                                  // Highlight selected time slot
                                  document.querySelectorAll('.time-slot').forEach(slot => {
                                      slot.classList.remove('selected');
                                  });
                                  timeSlot.classList.add('selected');
                              }
                          });

                          // Load user's bookings
                          async function loadUserBookings() {
                              const response = await fetch(`<?php echo URLROOT; ?>/facilities/getUserBookings/${facilityId}`);
                              const bookings = await response.json();
                              updateBookingsTable(bookings);
                          }

                          loadUserBookings();

                          bookingForm.addEventListener('submit', function(e) {
                              e.preventDefault();
        
                              // Get the selected date and format it
                              const selectedDate = document.getElementById('booking_date').value;
                              const formattedDate = new Date(selectedDate).toISOString().split('T')[0];
        
                              // Update the hidden date input before submission
                              document.getElementById('booking_date').value = formattedDate;
        
                              // Submit the form
                              this.submit();
                          });
                      });
                    function updateTimeSlots(bookings) {
                        const timeSlotsDiv = document.getElementById('timeSlots');
                        const openingTime = 8; // 8 AM
                        const closingTime = 22; // 10 PM
      
                        let timeSlotHTML = '';
      
                        for (let hour = openingTime; hour < closingTime; hour++) {
                            const timeString = `${hour.toString().padStart(2, '0')}:00`;
                            const isBooked = bookings.some(booking => {
                                const bookingHour = parseInt(booking.booking_time.split(':')[0]);
                                return bookingHour === hour;
                            });
          
                            const slotClass = isBooked ? 'time-slot booked' : 'time-slot available';
                            timeSlotHTML += `
                                <div class="${slotClass}">
                                    <span>${timeString}</span>
                                    <span>${isBooked ? 'Booked' : 'Available'}</span>
                                </div>
                            `;
                        }
      
                        timeSlotsDiv.innerHTML = timeSlotHTML;
                    }

                    function updateBookingsTable(bookings) {
                        const tbody = document.getElementById('bookingsTableBody');
                        tbody.innerHTML = bookings.map(booking => `
                            <tr>
                                <td>${booking.booking_date}</td>
                                <td>${booking.booking_time}</td>
                                <td>${booking.duration} hours</td>
                                <td>${booking.status}</td>
                            </tr>
                        `).join('');
                    }

                    // Add this JavaScript code after your existing scripts
                    document.addEventListener('DOMContentLoaded', function() {
                        const calendar = document.getElementById('calendar');
                        const dateInput = document.getElementById('booking_date');
                        let currentDate = new Date();
                        
                        function createCalendar(date) {
                            const currentMonth = date.getMonth();
                            const currentYear = date.getFullYear();
                            
                            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
                            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
                            
                            let calendarHTML = `
                                <div class="calendar-header">
                                    <button class="month-nav prev"><</button>
                                    <h3>${new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' })} ${currentYear}</h3>
                                    <button class="month-nav next">></button>
                                </div>
                                <div class="calendar-days">
                                    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                                </div>
                                <div class="calendar-dates">
                            `;
                            
                            for(let i = 0; i < firstDay; i++) {
                                calendarHTML += '<div class="empty"></div>';
                            }
                            
                            const today = new Date();
                            for(let day = 1; day <= daysInMonth; day++) {
                                const date = new Date(currentYear, currentMonth, day);
                                const formattedDate = date.toISOString().split('T')[0];
                                const isToday = day === today.getDate() && 
                                               currentMonth === today.getMonth() && 
                                               currentYear === today.getFullYear();
                                
                                calendarHTML += `
                                    <div class="calendar-date ${isToday ? 'today' : ''}" data-date="${formattedDate}">
                                        ${day}
                                    </div>
                                `;
                            }
                            
                            calendarHTML += '</div>';
                            calendar.innerHTML = calendarHTML;
                            
                            // Add navigation event listeners
                            document.querySelector('.month-nav.prev').addEventListener('click', () => {
                                currentDate.setMonth(currentDate.getMonth() - 1);
                                createCalendar(currentDate);
                            });
                            
                            document.querySelector('.month-nav.next').addEventListener('click', () => {
                                currentDate.setMonth(currentDate.getMonth() + 1);
                                createCalendar(currentDate);
                            });
                            
                            // Add date selection listeners
                            document.querySelectorAll('.calendar-date').forEach(dateElement => {
                                dateElement.addEventListener('click', function() {
                                    document.querySelectorAll('.calendar-date').forEach(el => el.classList.remove('selected'));
                                    this.classList.add('selected');
                                    dateInput.value = this.dataset.date;
                                    dateInput.dispatchEvent(new Event('change'));
                                });
                            });
                        }
                        
                        createCalendar(currentDate);
                    });
                </script>
            </body>
            </html>
