const facilityId = document.querySelector('input[name="facility_id"]').value;

document.addEventListener('DOMContentLoaded', function() {
    const calendar = new Calendar();
    calendar.init();
    generateTimeSlots();

    // Update time slots
    dateInput.addEventListener('change', async function() {
        const selectedDate = this.value;
        await showTimeSlots(selectedDate);
    });
});

document.getElementById('duration').addEventListener('change', function() {
    const selectedDate = document.getElementById('booking_date').value;
    const facilityId = document.querySelector('.calendar').dataset.facilityId;
    if(selectedDate) {
        updateTimeSlots(selectedDate, facilityId);
    }
});

class Calendar {
    constructor() {
        this.date = new Date();
        this.currentMonth = this.date.getMonth();
        this.currentYear = this.date.getFullYear();
        this.monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
    }
      generateCalendar() {
          const firstDay = new Date(this.currentYear, this.currentMonth, 1);
          const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
          const startingDay = firstDay.getDay();
          const totalDays = lastDay.getDate();
    
          document.getElementById('currentMonth').textContent = 
              `${this.monthNames[this.currentMonth]} ${this.currentYear}`;
    
          let calendarHTML = '';
    
          for (let i = 0; i < startingDay; i++) {
              calendarHTML += '<div class="empty"></div>';
          }
    
          for (let day = 1; day <= totalDays; day++) {
              const dateString = `${this.currentYear}-${(this.currentMonth + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
              const isToday = this.isToday(day);
              const isPastDate = new Date(dateString) < new Date().setHours(0,0,0,0);
            
              calendarHTML += `
                  <div class="calendar-date${isToday ? ' today' : ''}${isPastDate ? ' past-date' : ''}" 
                 data-date="${dateString}" ${isPastDate ? 'disabled' : ''}>
                      ${day}
                  </div>`;
          }
    
          document.getElementById('calendarDates').innerHTML = calendarHTML;
          this.addDateListeners();
      }
    isToday(day) {
        const today = new Date();
        return day === today.getDate() && 
           this.currentMonth === today.getMonth() && 
           this.currentYear === today.getFullYear();
    }

    addDateListeners() {
        document.querySelectorAll('.calendar-date').forEach(date => {
            date.addEventListener('click', async (e) => {
                if (e.target.classList.contains('past-date')) {
                    return;
                }
                
                document.querySelectorAll('.calendar-date').forEach(d => 
                    d.classList.remove('selected'));
                e.target.classList.add('selected');
                
                const selectedDate = e.target.dataset.date;
                document.getElementById('booking_date').value = selectedDate;
                const facilityId = document.querySelector('.calendar').dataset.facilityId;
                
                await handleDateClick(selectedDate, facilityId);
                await showTimeSlots(selectedDate);
            });
        });
    }

    init() {
        this.generateCalendar();
    
        document.getElementById('prevMonth').addEventListener('click', () => {
            this.currentMonth--;
            if (this.currentMonth < 0) {
                this.currentMonth = 11;
                this.currentYear--;
            }
            this.generateCalendar();
        });
    
        document.getElementById('nextMonth').addEventListener('click', () => {
            this.currentMonth++;
            if (this.currentMonth > 11) {
                this.currentMonth = 0;
                this.currentYear++;
            }
            this.generateCalendar();
        });
    }
}

async function handleDateClick(date) {
    document.getElementById('booking_date').value = date;

    const response = await fetch(`${URLROOT}/facilities/getBookedTimes/${facilityId}/${date}`);
    const bookings = await response.json();
    const currentUserId = document.querySelector('input[name="resident_id"]').value;
    
    const bookedTimesTable = document.getElementById('bookedTimesBody');
    bookedTimesTable.innerHTML = bookings.map(booking => `
        <tr class="${booking.user_id == currentUserId ? 'own-booking' : ''}">
            <td>${booking.booking_time}</td>
            <td>${booking.duration} hours</td>
            <td>${booking.booked_by}</td>
        </tr>
    `).join('');

    try {
        const response = await fetch(`${URLROOT}/facilities/getUserBookings/${facilityId}/${date}`);
        const bookings = await response.json();
        
        const tableBody = document.getElementById('bookingsTableBody');
        if (bookings.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" style="text-align: center;">No bookings found for this date</td>
                </tr>`;
        } else {
            tableBody.innerHTML = bookings.map(booking => `
                <tr>
                    <td>${booking.booking_date}</td>
                    <td>${booking.booking_time}</td>
                    <td>${booking.duration}</td>
                </tr>
            `).join('');
        }
    } catch (error) {
        console.error('Error fetching bookings:', error);
    }
}

const bookingForm = document.querySelector('form');
bookingForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        facilityId: document.querySelector('input[name="facility_id"]').value,
        date: document.getElementById('booking_date').value,
        time: document.getElementById('booking_time').value,
        duration: document.getElementById('duration').value
    };

    // between 9:00 AM and 9:00 PM
    const bookingTime = formData.time;
    const [hours, minutes] = bookingTime.split(':').map(Number);
    const bookingHour = hours;
    
    if (bookingHour < 9 || bookingHour >= 21) {
        document.getElementById('booking-error').textContent = 
            'Bookings can only be made between 9:00 AM and 9:00 PM';
        return;
    }

    //end time  exceed 9:00 PM
    const endHour = bookingHour + parseInt(formData.duration);
    if (endHour > 21) {
        document.getElementById('booking-error').textContent = 
            'Booking duration would extend beyond 9:00 PM. Please adjust your booking time or duration.';
        return;
    }

    //booking is not in the past
    const bookingDateTime = new Date(formData.date + 'T' + formData.time);
    const currentDateTime = new Date();
    
    if (bookingDateTime < currentDateTime) {
        document.getElementById('booking-error').textContent = 
            'Cannot book facilities for past times. Please select a future date and time.';
        return;
    }

    const response = await fetch(`${URLROOT}/facilities/checkOverlap`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    });

    const result = await response.json();
    
    if (result.hasOverlap) {
        document.getElementById('booking-error').textContent = 
            `Booking overlaps with existing booking from ${result.conflictingBooking.booking_time} for ${result.conflictingBooking.duration} hours`;
        return;
    }
    
    this.submit();
});