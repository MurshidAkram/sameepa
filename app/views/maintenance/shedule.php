<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/schedule.css">

    
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css' rel='stylesheet' />

    <title>View Maintenance Schedule | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Side Panel -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <!-- Main Content -->
        <main>
            <h1>Maintenance Schedule</h1>

            <!-- Search Bar with Suggestions -->
            <section class="search-bar">
                <input type="text" id="search-date" placeholder="Search by date (YYYY-MM-DD)" list="date-suggestions" />
                <datalist id="date-suggestions">
                    <option value="2024-09-18"></option>
                    <option value="2024-09-20"></option>
                    <option value="2024-09-22"></option>
                </datalist>
                <button id="search-btn" class="btn-search">Search</button>
            </section>

            <!-- FullCalendar Component -->
            <section class="calendar-section">
                <div id='calendar'></div>
            </section>

            <!-- Filters Section with Tooltips -->
            <section class="filters">
                <h2>Filters</h2>
                <form id="filter-form">
                    <label for="priority" class="tooltip">
                        Sort by Priority:
                        <span class="tooltiptext">Filter tasks based on their priority level</span>
                    </label>
                    <select id="priority" name="priority">
                        <option value="all">All</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>

                    <label for="location" class="tooltip">
                        Filter by Location:
                        <span class="tooltiptext">Narrow tasks by building or location</span>
                    </label>
                    <select id="location" name="location">
                        <option value="all">All</option>
                        <option value="building1">Building 1</option>
                        <option value="building2">Building 2</option>
                    </select>

                    <button type="submit" class="btn-filter">Apply Filters</button>
                </form>
            </section>

            <!-- Task Summary Section with Color-Coding and Hover Effects -->
            <section class="task-summary">
                <h2>Task Summary (Week View)</h2>
                <ul class="task-list">
                    <li class="task-item pending" title="Pending - AC unit repair on 2024-09-20">AC unit repair - Pending</li>
                    <li class="task-item in-progress" title="In Progress - Light fixture replacement on 2024-09-22">Light fixture replacement - In Progress</li>
                    <li class="task-item completed" title="Completed - Elevator check on 2024-09-18">Elevator check - Completed</li>
                </ul>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'AC unit repair',
                        start: '2024-09-20',
                        description: 'AC unit repair for building 1',
                        status: 'Pending',
                        priority: 'High',
                        location: 'Building 1'
                    },
                    {
                        title: 'Light fixture replacement',
                        start: '2024-09-22',
                        description: 'Light replacement in building 2',
                        status: 'In Progress',
                        priority: 'Medium',
                        location: 'Building 2'
                    },
                    {
                        title: 'Elevator check',
                        start: '2024-09-18',
                        description: 'Elevator maintenance check',
                        status: 'Completed',
                        priority: 'Low',
                        location: 'Building 1'
                    }
                ],
                eventClick: function (info) {
                    alert('Event: ' + info.event.title + '\n' +
                        'Description: ' + info.event.extendedProps.description + '\n' +
                        'Status: ' + info.event.extendedProps.status);
                }
            });

            calendar.render();

            // Search functionality
            document.getElementById('search-btn').addEventListener('click', function () {
                var searchDate = document.getElementById('search-date').value;

                if (searchDate) {
                    calendar.gotoDate(searchDate);
                    calendar.getEvents().forEach(function (event) {
                        if (event.startStr === searchDate) {
                            event.setProp('backgroundColor', '#ff9f89');
                        } else {
                            event.setProp('backgroundColor', '');
                        }
                    });
                }
            });

            // Filter functionality
            document.getElementById('filter-form').addEventListener('submit', function (e) {
                e.preventDefault();
                var priorityFilter = document.getElementById('priority').value;
                var locationFilter = document.getElementById('location').value;

                calendar.getEvents().forEach(function (event) {
                    var matchesPriority = priorityFilter === 'all' || event.extendedProps.priority === priorityFilter;
                    var matchesLocation = locationFilter === 'all' || event.extendedProps.location === locationFilter;

                    if (matchesPriority && matchesLocation) {
                        event.setProp('display', 'block');
                    } else {
                        event.setProp('display', 'none');
                    }
                });
            });
        });
    </script>
</body>

</html>
