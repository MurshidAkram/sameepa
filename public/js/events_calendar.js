// app/public/js/events_calendar.js

document.addEventListener('DOMContentLoaded', function() {
    const calendarGrid = document.getElementById('calendar-grid');
    const currentMonthElement = document.getElementById('current-month');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');

    let currentDate = new Date();

    function renderCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        
        currentMonthElement.textContent = firstDay.toLocaleString('default', { month: 'long', year: 'numeric' });
        
        calendarGrid.innerHTML = '';

        for (let i = 0; i < firstDay.getDay(); i++) {
            calendarGrid.appendChild(document.createElement('div'));
        }

        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day');
            dayElement.textContent = day;

            // Example: Mark some days as having events (you'd replace this with actual event data)
            if (day % 5 === 0) {
                dayElement.classList.add('has-event');
            }

            calendarGrid.appendChild(dayElement);
        }
    }

    renderCalendar(currentDate.getFullYear(), currentDate.getMonth());

    prevMonthButton.addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
    });

    nextMonthButton.addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
    });
});