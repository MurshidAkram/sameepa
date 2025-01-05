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
  /* Basic container styling */
.visitor-pass-container {
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-top: 20px;
}

/* Section headings */
h2, h3 {
  color: #800080;
  font-family: Arial, sans-serif;
}

/* Form styling */
.new-pass-form, .modal-content {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
}

.new-pass-form h2, .modal-content h2 {
  color: #800080;
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

.btn-cancel {
  background-color: #dc3545;
  color: #fff;
  
}

.modal-buttons {
  display: flex;
  place-items: center;
  gap: 250px;

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
  border-color: #04f08e;
  box-shadow: 0 0 4px rgba(0, 69, 124, 0.3);
}

/* Modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  position: relative;
  background-color: #fff;
  margin: 10% auto;
  padding: 20px;
  border-radius: 8px;
  width: 50%; /* Set width to 50% */
  height: 60%; /* Set height to 60% */
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  overflow-y: auto; /* Enable scrolling if content overflows */
}

/* Responsive design */
@media (max-width: 768px) {
  .visitor-pass-container, .new-pass-form, .modal-content, .pass-table {
    padding: 15px;
  }


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
                <div id="visitorPassModal" class="modal">
    <div class="modal-content">
        <h2>Create New Visitor Pass</h2>
        <form id="visitorPassForm" action="<?php echo URLROOT; ?>/security/Add_Visitor_Pass" method="POST">
            <div class="form-group">
                <label for="visitor_name">Visitor Name:</label>
                <input type="text" id="visitor_name" name="visitor_name" required>
            </div>
            <div class="form-group">
                <label for="visitor_count">Number of Visitors:</label>
                <input type="number" id="visitor_count" name="visitor_count" min="1" required>
            </div>
            <div class="form-group">
                <label for="resident_name">Resident Name to Meet:</label>
                <input type="text" id="resident_name" name="resident_name" required>
            </div>
            <div class="form-group">
                <label for="visit_date">Visit Date:</label>
                <input type="date" id="visit_date" name="visit_date" required>
            </div>
            <div class="form-group">
                <label for="visit_time">Visit Time:</label>
                <input type="time" id="visit_time" name="visit_time" required>
            </div>
            <div class="form-group">
                <label for="duration">Expected Duration (hours):</label>
                <input type="number" id="duration" name="duration" min="1" max="24" required>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose of Visit:</label>
                <textarea id="purpose" name="purpose" rows="3" required></textarea>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" id="cancelBtn" class="btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>

                        
<!-- Current Visitor Passes -->
<section id="current-passes">
    <h3>Today’s Visitor Passes</h3>
    <input type="text" placeholder="Search by visitor name, resident name, or visit time" id="searchTodayPass">
    <table class="pass-table">
        <thead>
            <tr>
                <th>Pass ID</th>
                <th>Visitor Name</th>
                <th>Number of Visitors</th>
                <th>Resident Name</th>
                <th>Visit Time</th>
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
                <th>Pass ID</th>
                <th>Visitor Name</th>
                <th>Number of Visitors</th>
                <th>Resident Name</th>
                <th>Visit Time</th>
                <th>Visit Date</th>
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
                    window.location.href = '<?php echo URLROOT; ?>/security/Manage_Visitor_Passes';  // Redirect after success
                } else {
                    alert('Error: ' + data.message);  // Show error message if any
                }
            })
            .catch(error => {
                console.error('Error:', error);  // Log any fetch errors
            });
        });
    }
});

// Fetch visitor pass data (today and history) from the server
const fetchVisitorPassData = () => {
    fetch('<?php echo URLROOT; ?>/security/Manage_Visitor_Passes')  // Replace with your actual endpoint
        .then(response => response.json())
        .then(data => {
            if (data.success) {
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
                <td>${pass.pass_id}</td>
                <td>${pass.visitor_name}</td>
                <td>${pass.visitor_count}</td>
                <td>${pass.resident_name}</td>
                <td>${pass.visit_time}</td>
                ${pass.visit_date ? `<td>${pass.visit_date}</td>` : ''}  <!-- Conditionally add the visit date -->
            </tr>
        `).join('');
    } else {
        console.warn('No data available or invalid format');
    }
};
</script>


    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
