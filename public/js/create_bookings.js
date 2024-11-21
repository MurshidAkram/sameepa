document.addEventListener('DOMContentLoaded', function() {
    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonthElement = document.getElementById('currentMonth');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');
    const bookingForm = document.getElementById('bookingForm');
    const bookingHistoryTable = document.getElementById('bookingHistoryTable').getElementsByTagName('tbody')[0];

    let currentDate = new Date();
    let bookings = []; // This would be populated from the backend in a real application

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);

        currentMonthElement.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;
        calendarGrid.innerHTML = '';

        for (let i = 0; i < firstDay.getDay(); i++) {
            calendarGrid.appendChild(document.createElement('div'));
        }

        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day');
            dayElement.textContent = day;

            const currentDayDate = new Date(year, month, day);
            if (hasBooking(currentDayDate)) {
                dayElement.classList.add('has-booking');
            }

            dayElement.addEventListener('click', () => selectDate(currentDayDate));
            calendarGrid.appendChild(dayElement);
        }
    }

    function hasBooking(date) {
        return bookings.some(booking => {
            const bookingDate = new Date(booking.date);
            return bookingDate.getFullYear() === date.getFullYear() &&
                   bookingDate.getMonth() === date.getMonth() &&
                   bookingDate.getDate() === date.getDate();
        });
    }

    function selectDate(date) {
        document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected'));
        document.querySelector(`.calendar-day:nth-child(${date.getDate() + firstDay.getDay()})`).classList.add('selected');
        document.getElementById('date').value = date.toISOString().split('T')[0];
    }

    prevMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    renderCalendar();
    
});