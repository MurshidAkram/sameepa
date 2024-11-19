const facilityId = document.querySelector('input[name="facility_id"]').value;

document.addEventListener('DOMContentLoaded', function() {
    const calendar = new Calendar();
    calendar.init();
    generateTimeSlots();

    // Update time slots when date changes
    dateInput.addEventListener('change', async function() {
        const selectedDate = this.value;
        await showTimeSlots(selectedDate);
    });

    // Handle form submission
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

    async handleDateClick(date, facilityId) {
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

    addDateListeners() {
        document.querySelectorAll('.calendar-date').forEach(date => {
            date.addEventListener('click', async (e) => {
                document.querySelectorAll('.calendar-date').forEach(d => 
                    d.classList.remove('selected'));
                e.target.classList.add('selected');
                
                const selectedDate = e.target.dataset.date;
                document.getElementById('booking_date').value = selectedDate;
                const facilityId = document.querySelector('.calendar').dataset.facilityId;
                
                await this.handleDateClick(selectedDate, facilityId);
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
async function showTimeSlots(date) {
    const timeSlotsContainer = document.getElementById('timeSlots');
    const openingHour = 8;
    const closingHour = 22;
    let timeSlotHTML = '';
    const selectedDuration = parseInt(document.getElementById('duration').value);
    const errorMessageDiv = document.createElement('div');
    errorMessageDiv.id = 'booking-error';
    errorMessageDiv.style.color = 'red';
    errorMessageDiv.style.marginTop = '10px';

    try {
        const response = await fetch(`${URLROOT}/Facilities/getBookings/${facilityId}/${date}`);
        const bookings = await response.json();

        for (let hour = openingHour; hour < closingHour; hour++) {
            const timeString = `${hour.toString().padStart(2, '0')}:00`;
            
            const isOverlapping = bookings.some(booking => {
                const bookingHour = parseInt(booking.booking_time.split(':')[0]);
                const bookingDuration = parseInt(booking.duration);
                const newBookingEnd = hour + selectedDuration;
                const existingBookingEnd = bookingHour + bookingDuration;
                
                return (hour >= bookingHour && hour < existingBookingEnd) || 
                       (newBookingEnd > bookingHour && hour < existingBookingEnd);
            });

            timeSlotHTML += `
                <div class="time-slot ${isOverlapping ? 'booked' : 'available'}" 
                     data-time="${timeString}" 
                     onclick="handleTimeSlotClick(this, ${isOverlapping})">
                    <span class="time">${timeString}</span>
                    <span class="status">${isOverlapping ? 'Booked' : 'Available'}</span>
                </div>
            `;
        }

        timeSlotsContainer.innerHTML = timeSlotHTML;
        timeSlotsContainer.appendChild(errorMessageDiv);
        addTimeSlotListeners();

    } catch (error) {
        console.error('Error loading time slots:', error);
    }
}

function handleTimeSlotClick(slot, isOverlapping) {
    const errorDiv = document.getElementById('booking-error');
    if (isOverlapping) {
        errorDiv.textContent = 'This time slot overlaps with an existing booking. Please select a different time.';
        return false;
    }
    errorDiv.textContent = '';
    // Continue with normal slot selection
    const timeSlots = document.querySelectorAll('.time-slot');
    timeSlots.forEach(s => s.classList.remove('selected'));
    slot.classList.add('selected');
    document.getElementById('booking_time').value = slot.dataset.time;
}
 

function updateTimeSlots(date, facilityId) {    
    fetch(`${URLROOT}/facilities/getBookedTimeSlots/${facilityId}/${date}`)
        .then(response => response.json())
        .then(occupiedSlots => {
            const timeSlots = document.getElementById('timeSlots');
            timeSlots.innerHTML = '';
            
            // Generate time slots (e.g., 9 AM to 9 PM)
            for(let hour = 9; hour < 21; hour++) {
                const timeSlot = `${hour.toString().padStart(2, '0')}:00`;
                const duration = document.getElementById('duration').value;
                
                // Check if any slot within the duration is occupied
                let isAvailable = true;
                for(let i = 0; i < duration; i++) {
                    const checkTime = new Date(date);
                    checkTime.setHours(hour + i, 0, 0);
                    const checkTimeString = checkTime.toTimeString().slice(0, 5);
                    
                    if(occupiedSlots.includes(checkTimeString)) {
                        isAvailable = false;
                        break;
                    }
                }
                
                const button = document.createElement('button');
                button.textContent = timeSlot;
                button.className = `time-slot ${isAvailable ? 'available' : 'occupied'}`;
                button.disabled = !isAvailable;
                
                if(isAvailable) {
                    button.onclick = () => selectTimeSlot(timeSlot);
                }
                
                timeSlots.appendChild(button);
            }
        });
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
}

