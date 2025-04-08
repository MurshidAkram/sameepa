<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Visitor_Passes.css">
    <title>Manage Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<style>
  
  .modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60%;
    max-width: 400px;
    background-color: #ffffff; /* Dark Violet */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 20px;
    z-index: 1000;
    display: none;
}

/* Modal active state (visible) */
.modal.active {
    display: block;
  
}

/* Modal header */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    color: #fff; /* Light text color */
}

.modal-header .close {
    font-size: 2.5rem;
    cursor: pointer;
    color:rgb(244, 8, 209); /* Light Violet */
    transition: color 0.3s ease;
}



/* Modal form inputs and select */
.modal-form input, .modal-form select {
    width: 90%;
    padding: 10px;
    margin: 5px 0 10px;
    border: 1px solid black; /* Light Violet border */
    border-radius: 5px;
    background-color: #f6e4f7; /* Light Violet background */
    color:  black; /* Dark Violet text */
}

/* Form input and select focus effects */
.modal-form input:focus, .modal-form select:focus {
    outline: none;
    border-color: #e8c8e3; /* Light Violet border on focus */
    box-shadow: 0 0 5px rgba(232, 200, 227, 0.5); /* Subtle shadow */
}

/* Form submit button */
.modal-form button {
    background-color: #7a4d9c; /* Medium Violet */
    color: #fff;
    border: none;
    padding: 12px;
    width: 95%;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-form button:hover {
    background-color: #9b66c9; /* Lighter Violet on hover */
}



.visitor-pass-container {
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(155, 4, 4, 0.1);
  padding: 20px;
  margin-top: 20px;
}

/* Section headings */
h2, h3 {
  color: #800080;
  font-family: Arial, sans-serif;
  position: inherit;
}



.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  color: #333;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input, .form-group textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
  box-sizing: border-box;
}

textarea {
  resize: vertical;
}

input:focus, textarea:focus {
  border-color: #336699;
  box-shadow: 0 0 4px rgba(51, 102, 153, 0.3);
  outline: none;
}

/* Buttons */
.btn-submit, .btn-save, .btn-cancel {
  padding: 10px 20px;
  width:40%;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
}

.btn-submit, .btn-save {
  background-color: #336699;
  color: #fff;
}

.btn-submit:hover, .btn-save:hover {
  background-color: darkblue;
}





/* Table styling */
.pass-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  font-family: Arial, sans-serif;
}

.pass-table thead {
  background-color: #800080;
  color: #fff;
}

.pass-table th, .pass-table td {
  text-align: left;
  padding: 10px;
  border: 1px solid #ddd;
}



/* Search input */
#searchTodayPass, #searchHistoryPass {
  width: 100%;
  padding: 10px;
  margin: 10px 0 20px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

#searchTodayPass:focus, #searchHistoryPass:focus {
  border-color: #E0AAFF;
  box-shadow: 0 0 4px rgba(0, 69, 124, 0.3);
}


</style>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Visitor Pass Management</h2>

            <div class="visitor-pass-container">
                <!-- Create Visitor Pass Button -->
                <button id="openModalBtn" class="btn-submit">Create Visitor Pass</button>

<!-- Modal for Creating Visitor Pass -->
<div class="modal" id="visitorPassModal">
    <div class="modal-header">
        <h2>Create New Visitor Pass</h2>
        <span class="close btn cancel-btn" id="closeVisitorModal">&times;</span>
    </div>
    <form class="modal-form" id="visitorPassForm" action="<?php echo URLROOT; ?>/security/Add_Visitor_Pass" method="POST">
        <label for="visitor_name">Visitor Name:</label>
        <input type="text" id="visitor_name" name="visitor_name" required>

        <label for="visitor_count">Number of Visitors:</label>
        <input type="number" id="visitor_count" name="visitor_count" min="1" required>

        <label for="resident_name">Resident Name to Meet:</label>
        <input type="text" id="resident_name" name="resident_name" required>

        <label for="visit_date">Visit Date:</label>
        <input type="date" id="visit_date" name="visit_date" required>

        <label for="visit_time">Visit Time:</label>
        <input type="time" id="visit_time" name="visit_time" required>

        <label for="duration">Expected Duration (hours):</label>
        <input type="number" id="duration" name="duration" min="1" max="24" required>

        <label for="purpose">Purpose of Visit:</label>
        <textarea id="purpose" name="purpose" rows="3" required></textarea>

        <div class="modal-buttons">
            <button type="submit" class="btn save-btn">Save</button>
        </div>
    </form>
</div>
   

                        
<!-- Current Visitor Passes -->
<section id="current-passes">
    <h3>Today’s Visitor Passes</h3>
    <input type="text" placeholder="Search by visitor name, resident name, or visit time" id="searchTodayPass">
    <table class="pass-table">
        <thead>
            <tr>
                <th>Visitor Name</th>
                <th>Number of Visitors</th>
                <th>Resident Name</th>
                <th>Visit Time</th>
                <th>Visit Date</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody id="todayPasses">
            <!-- Placeholder for dynamic rows -->
        </tbody>
    </table>
</section>

<!-- Visitor Pass History -->
<section id="pass-history">
    <h3>Visitor Pass History</h3>
    <input type="text" placeholder="Search by visitor name, resident name, visit date, or time" id="searchHistoryPass">
    <table class="pass-table">
        <thead>
            <tr>
                
                <th>Visitor Name</th>
                <th>Number of Visitors</th>
                <th>Resident Name</th>
                <th>Visit Time</th>
                <th>Visit Date</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody id="historyPasses">
            <!-- Placeholder for dynamic rows -->
        </tbody>
    </table>
</section>

            </div>
        </main>
    </div>

    <script>

//******************************************************Add Visitor pass **************************************** */      

document.addEventListener('DOMContentLoaded', () => {
    // Modal handlers
    const modal = document.getElementById('visitorPassModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('cancelBtn');

    // Open Modal
    if (openModalBtn) {
        openModalBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });
    }

    // Close Modal
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    // Close modal on outside click
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Fetch and populate data for today and history passes
    fetchVisitorPassData();

    // Handle form submission for adding a new visitor pass
    const visitorPassForm = document.getElementById('visitorPassForm');
    if (visitorPassForm) {
        visitorPassForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            let formData = new FormData(this);

            // Sending the form data via POST
            fetch('<?php echo URLROOT; ?>/security/Add_Visitor_Pass', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Visitor Pass Added Successfully! ID: ' + data.id);
                    // Refresh the tables after successful addition
                    fetchVisitorPassData();
                    // Close the modal
                    modal.style.display = 'none';
                    // Reset the form
                    visitorPassForm.reset();
                } else {
                    alert('Error: ' + data.message);  // Show error message if any
                }
            })
            .catch(error => {
                console.error('Error:', error);  // Log any fetch errors
            });
        });
    }

    // Add search functionality for both tables
    const searchTodayPass = document.getElementById('searchTodayPass');
    if (searchTodayPass) {
        searchTodayPass.addEventListener('input', function() {
            filterTable('todayPasses', this.value.toLowerCase());
        });
    }

    const searchHistoryPass = document.getElementById('searchHistoryPass');
    if (searchHistoryPass) {
        searchHistoryPass.addEventListener('input', function() {
            filterTable('historyPasses', this.value.toLowerCase());
        });
    }
});

// Fetch visitor pass data (today and history) from the server
const fetchVisitorPassData = () => {
    fetch('<?php echo URLROOT; ?>/security/Manage_Visitor_Passes', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // Indicate this is an AJAX request
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const todayPassesData = data.todayPasses;  // Data for today's passes
            const historyPassesData = data.historyPasses;  // Data for historical passes

            // Populate both tables with dynamic data
            populateTable('todayPasses', todayPassesData);  // Today's passes
            populateTable('historyPasses', historyPassesData);  // Historical passes
        } else {
            console.error('Error fetching data:', data.message);
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);  // Log any fetch errors
    });
};

// Function to populate a table dynamically
const populateTable = (tableBodyId, data) => {
    const tableBody = document.getElementById(tableBodyId);
    if (tableBody && Array.isArray(data)) {
        // Map through the data and create the table rows dynamically
        tableBody.innerHTML = data.map(pass => `
            <tr>
                
                <td>${pass.visitor_name}</td>
                <td>${pass.visitor_count}</td>
                <td>${pass.resident_name}</td>
                <td>${pass.visit_time}</td>
                <td>${pass.visit_date || pass.formatted_date || ''}</td>
                <td>${pass.purpose}</td>
            </tr>
        `).join('');
    } else {
        console.warn('No data available or invalid format for table:', tableBodyId);
        tableBody.innerHTML = '<tr><td colspan="6">No data available</td></tr>';
    }
};

// Function to filter table rows based on search input
const filterTable = (tableBodyId, searchText) => {
    const tableBody = document.getElementById(tableBodyId);
    if (!tableBody) return;

    const rows = tableBody.getElementsByTagName('tr');
    
    for (let row of rows) {
        const cells = row.getElementsByTagName('td');
        let rowText = '';
        
        // Combine all cell text for searching
        for (let cell of cells) {
            rowText += cell.textContent.toLowerCase() + ' ';
        }
        
        // Show/hide row based on search match
        if (rowText.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
};

//******************************************************close form******************************************************** */

document.addEventListener('DOMContentLoaded', function() {
    // Get the modal and close button elements
    const modal = document.getElementById('visitorPassModal');
    const closeBtn = document.getElementById('closeVisitorModal');
    
    // Close modal when clicking the × button
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            // Optional: Reset the form if needed
            document.getElementById('visitorPassForm').reset();
        });
    }
    
    // Optional: Close when clicking outside the modal
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.getElementById('visitorPassForm').reset();
        }
    });
});
</script>


    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
