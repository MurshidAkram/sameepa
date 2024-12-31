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
  color: #d30eed;
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
  color: #dd4cf0;
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
  background-color: #285680;
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

.btn-cancel:hover {
  background-color: #c82333;
}

/* Table styling */
.pass-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  font-family: Arial, sans-serif;
}

.pass-table thead {
  background-color: #3b5998;
  color: #fff;
}

.pass-table th, .pass-table td {
  text-align: left;
  padding: 10px;
  border: 1px solid #ddd;
}

.pass-table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.pass-table tr:hover {
  background-color: #97ebaf;
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

  h2, h3 {
    font-size: 1.5rem;
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
                        <form action="<?php echo URLROOT; ?>/security/Manage_Visitor_Passes" method="POST">
                            <div class="form-group">
                                <label for="visitorName">Visitor Name:</label>
                                <input type="text" id="visitorName" name="visitorName" required>
                            </div>
                            <div class="form-group">
                                <label for="visitorCount">Number of Visitors:</label>
                                <input type="number" id="visitorCount" name="visitorCount" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="residentName">Resident Name to Meet:</label>
                                <input type="text" id="residentName" name="residentName" required>
                            </div>
                            <div class="form-group">
                                <label for="visitDate">Visit Date:</label>
                                <input type="date" id="visitDate" name="visitDate" required>
                            </div>
                            <div class="form-group">
                                <label for="visitTime">Visit Time:</label>
                                <input type="time" id="visitTime" name="visitTime" required>
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
        document.addEventListener('DOMContentLoaded', () => {
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

            // Sample data
            const todayPassesData = [
                { id: 5, visitorName: "Dinuka Sahan", visitorCount: 1, residentName: "Asanka", visitTime: "10:00 AM" },
                { id: 6, visitorName: "Malith Damsara", visitorCount: 1, residentName: "Ramya", visitTime: "11:00 AM" },
                { id: 7, visitorName: "Sasila Sadamsara", visitorCount: 2, residentName: "Lakmali", visitTime: "12:00 AM" },
            
              ];
            const historyPassesData = [
                { id: 1, visitorName: "Geeth Pasida", visitorCount: 6, residentName: "Yasas", visitTime: "09:00 AM", visitDate: "2023-11-20" },
                { id: 2, visitorName: "Sachith", visitorCount: 4, residentName: "Hiranga Sovis", visitTime: "10:00 AM", visitDate: "2023-11-21" },
                { id: 3, visitorName: "Susantha", visitorCount: 1, residentName: "Wishwa Nimsara", visitTime: "11:00 AM", visitDate: "2023-12-26" },
                { id: 4, visitorName: "Tharanga", visitorCount: 3, residentName: "Chanulaya Nimasarani", visitTime: "12:00 AM", visitDate: "2024-01-11" },

            
            
              ];

            // Populate tables dynamically
            const populateTable = (tableBodyId, data) => {
                const tableBody = document.getElementById(tableBodyId);
                if (tableBody) {
                    tableBody.innerHTML = data.map(pass => `
                        <tr>
                            <td>${pass.id}</td>
                            <td>${pass.visitorName}</td>
                            <td>${pass.visitorCount}</td>
                            <td>${pass.residentName}</td>
                            <td>${pass.visitTime}</td>
                            ${pass.visitDate ? `<td>${pass.visitDate}</td>` : ''}
                        </tr>
                    `).join('');
                }
            };

            populateTable('todayPasses', todayPassesData);
            populateTable('historyPasses', historyPassesData);
        });
    </script>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
