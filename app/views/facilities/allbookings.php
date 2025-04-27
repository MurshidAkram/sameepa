<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/bookings.css">
    <title>All Bookings | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main class="bookings-main">
            <div class="header-actions">
                <h1>All Facility Bookings</h1>
                <div class="action-buttons">
                    <a href="<?php echo URLROOT; ?>/facilities/admin_dashboard" class="fac-btn-back">Back</a>
                </div>
            </div>

            <table class="bookings-table">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)" style="cursor: pointer;">Facility Name ↕</th>
                        <th onclick="sortTable(1)" style="cursor: pointer;">Booked By ↕</th>
                        <th onclick="sortTable(2)" style="cursor: pointer;">Booking Date ↕</th>
                        <th onclick="sortTable(3)" style="cursor: pointer;">Booking Time ↕</th>
                        <th onclick="sortTable(4)" style="cursor: pointer;">Duration (hours) ↕</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['bookings'] as $booking): ?>
                        <tr>
                            <td><?php echo $booking->facility_name; ?></td>
                            <td><?php echo $booking->booked_by; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($booking->booking_date)); ?></td>
                            <td><?php echo date('H:i', strtotime($booking->booking_time)); ?></td>
                            <td><?php echo $booking->duration; ?></td>
                            <td>
                                <button class="fac-btn-edit" onclick="editBooking(<?php echo $booking->id; ?>)">Edit</button>
                                <button class="fac-btn-cancel" onclick="removeBooking(<?php echo $booking->id; ?>)">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Edit Booking Modal -->
            <div id="editBookingModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Booking</h2>
                    <form id="editBookingForm">
                        <input type="hidden" id="bookingId">
                        <div class="form-group">
                            <label for="editBookingDate">Booking Date:</label>
                            <input type="date" id="editBookingDate" name="booking_date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="editBookingTime">Booking Time:</label>
                            <input type="time" id="editBookingTime" name="booking_time" required>
                        </div>
                        <div class="form-group">
                            <label for="editDuration">Duration (hours):</label>
                            <input type="number" id="editDuration" name="duration" min="1" max="8" required>
                        </div>
                        <button type="submit" class="fac-btn-submit">Update Booking</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script>
        const URLROOT = '<?php echo URLROOT; ?>';
    </script>
    <script>
        let sortDirections = {
            0: 'asc', //facility name
            1: 'asc', //booked by
            2: 'asc', //booking date
            3: 'asc', //booking time
            4: 'asc' //duration
        };

        function sortTable(n) {
            let table = document.querySelector(".bookings-table");
            let rows = Array.from(table.rows).slice(1);
            let direction = sortDirections[n] === 'asc' ? 1 : -1;

            rows.sort((a, b) => {
                let x = a.cells[n].textContent.trim();
                let y = b.cells[n].textContent.trim();

                switch (n) {
                    case 2:
                        return direction * (new Date(x) - new Date(y));
                    case 3:
                        return direction * (new Date('1970/01/01 ' + x) - new Date('1970/01/01 ' + y));
                    case 4:
                        return direction * (Number(x) - Number(y));
                    default:
                        return direction * x.localeCompare(y);
                }
            });

            //sort direction for next click
            sortDirections[n] = sortDirections[n] === 'asc' ? 'desc' : 'asc';

            //arrow indicators
            let headers = table.getElementsByTagName('th');
            for (let i = 0; i < headers.length - 1; i++) {
                headers[i].textContent = headers[i].textContent.replace(/[↑↓]/, '');
                if (i === n) {
                    headers[i].textContent += sortDirections[i] === 'asc' ? ' ↓' : ' ↑';
                }
            }

            // Reorder the table
            let tbody = table.getElementsByTagName('tbody')[0];
            rows.forEach(row => tbody.appendChild(row));
        }

        const modal = document.getElementById('editBookingModal');
        const span = document.getElementsByClassName('close')[0];

        function editBooking(bookingId) {
            const modal = document.getElementById('editBookingModal');
            document.getElementById('bookingId').value = bookingId;

            const bookingRow = event.target.closest('tr');
            const date = bookingRow.cells[2].textContent;
            const time = bookingRow.cells[3].textContent;
            const duration = bookingRow.cells[4].textContent;

            document.getElementById('editBookingDate').value = date;
            document.getElementById('editBookingTime').value = time;
            document.getElementById('editDuration').value = duration;

            modal.style.display = 'block';
        }

        document.getElementById('editBookingForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const bookingId = document.getElementById('bookingId').value;

            const formData = new FormData();
            formData.append('booking_date', document.getElementById('editBookingDate').value);
            formData.append('booking_time', document.getElementById('editBookingTime').value);
            formData.append('duration', document.getElementById('editDuration').value);

            //between 9:00 AM and 9:00 PM
            const bookingTime = document.getElementById('editBookingTime').value;
            const [hours, minutes] = bookingTime.split(':').map(Number);
            const bookingHour = hours;

            if (bookingHour < 9 || bookingHour >= 21) {
                alert('Bookings can only be made between 9:00 AM and 9:00 PM');
                return;
            }

            //exceed 9:00 PM
            const duration = parseInt(document.getElementById('editDuration').value);
            const endHour = bookingHour + duration;
            if (endHour > 21) {
                alert('Booking duration would extend beyond 9:00 PM. Please adjust your booking time or duration.');
                return;
            }

            // not in the past
            const bookingDate = document.getElementById('editBookingDate').value;
            const bookingDateTime = new Date(bookingDate + 'T' + bookingTime);
            const currentDateTime = new Date();

            if (bookingDateTime < currentDateTime) {
                alert('Cannot book facilities for past times. Please select a future date and time.');
                return;
            }

            try {
                const response = await fetch(`${URLROOT}/facilities/updateBooking/${bookingId}`, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    window.location.reload();
                } else {
                    alert(result.message || 'Failed to update booking');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while updating the booking: ' + error.message);
            }
        });

        async function removeBooking(bookingId) {
            if (confirm('Are you sure you want to remove this booking?')) {
                try {
                    const response = await fetch(`${URLROOT}/facilities/cancelBooking/${bookingId}`, {
                        method: 'POST'
                    });

                    if (response.ok) {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        }

        span.onclick = () => modal.style.display = 'none';
        window.onclick = (event) => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    </script>
</body>

</html>