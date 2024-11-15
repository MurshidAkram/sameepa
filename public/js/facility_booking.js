const facilityId = document.querySelector('input[name="facility_id"]').value;

document.addEventListener('DOMContentLoaded', function() {
    loadUserBookings(); // Load bookings when page loads
    const calendar = new Calendar();
    calendar.init();
    generateTimeSlots();
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
        
            calendarHTML += `
                <div class="calendar-date${isToday ? ' today' : ''}" 
                 data-date="${dateString}">
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
                document.querySelectorAll('.calendar-date').forEach(d => 
                    d.classList.remove('selected'));
                e.target.classList.add('selected');
                const selectedDate = e.target.dataset.date;
                document.getElementById('booking_date').value = selectedDate;
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

function generateTimeSlots() {
    const timeSlotsContainer = document.getElementById('timeSlots');
    timeSlotsContainer.innerHTML = '<p class="select-date-message">Please select a date to view available time slots</p>';
}
  async function showTimeSlots(date) {
      const timeSlotsContainer = document.getElementById('timeSlots');
      const openingHour = 8;
      const closingHour = 22;
      let timeSlotHTML = '';

      for (let hour = openingHour; hour < closingHour; hour++) {
          const formattedHour = hour.toString().padStart(2, '0');
          const timeString = `${formattedHour}:00`;
        
          timeSlotHTML += `
              <div class="time-slot" data-time="${timeString}">
                  <span class="time">${timeString}</span>
                  <span class="status">Available</span>
              </div>
          `;
      }

      timeSlotsContainer.innerHTML = timeSlotHTML;
      await checkAvailability(date);
      addTimeSlotListeners();
  }

  function addTimeSlotListeners() {
      const timeSlots = document.querySelectorAll('.time-slot');
      const timeInput = document.getElementById('booking_time');

      timeSlots.forEach(slot => {
          slot.addEventListener('click', () => {
              if (!slot.classList.contains('booked')) {
                  // Remove selected class from all slots
                  timeSlots.forEach(s => s.classList.remove('selected'));
                  // Add selected class to clicked slot
                  slot.classList.add('selected');
                  // Update time input
                  timeInput.value = slot.dataset.time;
              }
        });
    });
}

async function checkAvailability(date) {
    try {
        const facilityId = document.querySelector('input[name="facility_id"]').value;
        const response = await fetch(`${URLROOT}/Facilities/getBookings/${facilityId}/${date}`);
        const bookings = await response.json();

        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => {
            const slotTime = slot.dataset.time;
            // Make sure the time formats match exactly
            const isBooked = bookings.some(booking => 
                booking.booking_time.trim() === slotTime.trim()
            );
            
            slot.classList.remove('booked', 'available');
            slot.classList.add(isBooked ? 'booked' : 'available');
            slot.querySelector('.status').textContent = isBooked ? 'Booked' : 'Available';
        });
    } catch (error) {
        console.error('Error checking availability:', error);
    }
    
}function updateBookingsTable(bookings) {
    const tbody = document.getElementById('bookingsTableBody');
    
    if (bookings.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="no-bookings-message">No bookings found for this date</td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = bookings.map(booking => `
        <tr>
            <td>${new Date(booking.booking_date).toLocaleDateString()}</td>
            <td>${booking.booking_time}</td>
            <td>${booking.duration} hours</td>
            <td>
                <span class="booking-status ${booking.status.toLowerCase()}">
                    ${booking.status}
                </span>
            </td>
        </tr>
    `).join('');
}
async function loadUserBookings() {
    try {
        const facilityId = document.querySelector('input[name="facility_id"]').value;
        const response = await fetch(`${URLROOT}/Facilities/getUserBookings/${facilityId}`);
        
        if (!response.ok) {
            throw new Error('Failed to fetch bookings');
        }
        
        const bookings = await response.json();
        
        const tbody = document.getElementById('bookingsTableBody');
        if (!tbody) {
            console.error('Bookings table body element not found');
            return;
        }
        
        updateBookingsTable(bookings);
    } catch (error) {
        console.error('Error loading bookings:', error);
    }
}
