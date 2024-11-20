<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Visitor_Passes.css">
    <title>Manage Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<body>

<style>

/* Basic container styling */
.visitor-pass-container {
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 10px;
  margin-top: 20px;
}

/* Section headings */
h2, h3 {
  color: #d30eed;
  font-family: Arial, sans-serif;
}

/* Form styling */
.new-pass-form {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.new-pass-form h2 {
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
  box-sizing: border-box;
  font-size: 1rem;
}

.form-group input:focus, .form-group textarea:focus {
  outline: none;
  border-color: #336699;
  box-shadow: 0 0 4px rgba(51, 102, 153, 0.3);
}

textarea {
  resize: vertical;
}

/* Submit button styling */
.btn-submit {
  background-color: #336699;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
}

.btn-submit:hover {
  background-color: #285680;
}

/* Table styling */
.pass-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-family: Arial, sans-serif;
}

.pass-table thead {
  background-color: hwb(189 3% 22%);
  color: #ffffff;
}

.pass-table th, .pass-table td {
  padding: 10px;
  text-align: left;
  border: 1px solid hwb(189 3% 22%);
}

.pass-table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.pass-table tr:hover {
  background-color: #97ebaf;
}

.pass-table th {
  font-size: 1rem;
  font-weight: bold;
}

.pass-table td {
  font-size: 0.9rem;
  color: #333;
}

/* Search bar styling */
#searchTodayPass, #searchHistoryPass {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin-top: 10px;
  margin-bottom: 20px;
  box-sizing: border-box;
}

#searchTodayPass:focus, #searchHistoryPass:focus {
  border-color: #04f08e;
  box-shadow: 0 0 4px rgba(0, 69, 124, 0.3);
}

/* Responsive design adjustments */
@media (max-width: 768px) {
  .visitor-pass-container, .new-pass-form, .pass-table {
      padding: 15px;
  }

  h2, h3 {
      font-size: 1.5rem;
  }
}



</style>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Visitor Pass Management</h2>

            <div class="visitor-pass-container">
                <!-- Create New Visitor Pass Form -->
                <div class="new-pass-form">
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
                        <!-- Resident Name with Search Feature -->
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
                        <button type="submit" class="btn-submit">Create Visitor Pass</button>
                    </form>
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
                            <?php foreach ($data['activePasses'] as $pass) : ?>
                                <tr>
                                    <td><?php echo $pass->id; ?></td>
                                    <td><?php echo $pass->visitor_name; ?></td>
                                    <td><?php echo $pass->visitor_count; ?></td>
                                    <td><?php echo $pass->resident_name; ?></td>
                                    <td><?php echo $pass->visit_time; ?></td>
                                  
                                </tr>
                            <?php endforeach; ?>
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
                            <?php foreach ($data['passHistory'] as $pass) : ?>
                                <tr>
                                    <td><?php echo $pass->id; ?></td>
                                    <td><?php echo $pass->visitor_name; ?></td>
                                    <td><?php echo $pass->visitor_count; ?></td>
                                    <td><?php echo $pass->resident_name; ?></td>
                                    <td><?php echo $pass->visit_time; ?></td>
                                    <td><?php echo $pass->visit_date; ?></td>
                                   
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>
z
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>