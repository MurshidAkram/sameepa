<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <title>Inventory Management</title>

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #eef2f3, #ffffff);
            margin: 0;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
            padding: 20px;
            gap: 20px;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Headers */
        h1 {
            margin: 0 0 10px;
            font-size: 2rem;
            color: #3f51b5;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
            min-width: 200px;
            flex-grow: 1;
        }

        .search-bar input:focus {
            border-color: #3f51b5;
            outline: none;
        }

        .search-bar button {
            padding: 10px 15px;
            background: #3f51b5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-bar button:hover {
            background: #303f9f;
        }

        /* Section Styles */
        .section {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .section h2 {
            color: #3f51b5;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        table th {
            background: linear-gradient(to right, #42a5f5, #1e88e5);
            color: #fff;
            padding: 15px;
            font-weight: bold;
            text-align: center;
        }

        table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            color: #555;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tbody tr:hover {
            background: #f1f7ff;
        }

        /* Buttons */
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            color: #fff;
            transition: transform 0.2s, background-color 0.3s;
        }

        .btn-create {
            background: #28a745;
            margin-bottom: 20px;
        }

        .btn-create:hover {
            background: #218838;
        }

        .btn-edit {
            background: #3498db;
            color: white;
            transition: background 0.3s, transform 0.3s;
        }

        .btn-edit:hover {
            background: #2980b9;
            transform: scale(1.1);
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
            transition: background 0.3s, transform 0.3s;
        }

        .btn-delete:hover {
            background: #c0392b;
            transform: scale(1.1);
        }

        /* Form Overlay */
        .form-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            width: 400px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container input,
        .form-container select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #3f51b5;
            outline: none;
        }

        .form-container button {
            margin: 5px 0;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .form-container .btn-submit {
            background-color: #28a745;
            color: white;
        }

        .form-container .btn-submit:hover {
            background-color: #218838;
        }

        .form-container .btn-cancel {
            background-color: #dc3545;
            color: white;
        }

        .form-container .btn-cancel:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <div class="main-content">
            <h1>Inventory Management</h1>

            <!-- Inventory Usage Log Section -->
            <section class="section">
                <h2>Inventory Usage Log</h2>
                <button class="btn btn-create" onclick="showForm()">Create</button>
                <div class="search-bar">
                    <input type="text" id="search-usage" placeholder="Search Inventory Usage Log..." onkeyup="searchTable('usage-log')">
                    <button onclick="clearSearch('search-usage')">Clear Search</button>
                </div>
                <table id="usage-log">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['logs'] as $log) : ?>
                            <tr>
                                <td><?php echo $log->item_id; ?></td>
                                <td><?php echo $log->item_name; ?></td>
                                <td><?php echo $log->usage_date; ?></td>
                                <td><?php echo $log->usage_time; ?></td>
                                <td><?php echo $log->quantity; ?></td>
                                <td>
                                    <button class="btn btn-edit" onclick="editLog(<?php echo $log->log_id; ?>)">Edit</button>
                                    <button class="btn btn-delete" onclick="deleteLog(<?php echo $log->log_id; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </section>

            <!-- Available Store Section -->
            <section class="section">
                <h2>Available Store</h2>
                <div class="search-bar">
                    <input type="text" id="search-store" placeholder="Search Available Store..." onkeyup="searchTable('store')">
                    <button onclick="clearSearch('search-store')">Clear Search</button>
                </div>
                <table id="store">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Purchase Date</th>
                            <th>Available Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </section>
        </div>

    </div>

    <!-- Form Overlay -->
    <div class="form-overlay" id="form-overlay">
        <div class="form-container">
            <h2>Add Inventory Usage</h2>
            <form action="<?php echo URLROOT; ?>/maintenance/addInventoryUsage" method="POST" onsubmit="return validateForm()">
                <!-- Dropdown for Item Name -->

                <select name="item_name" id="item_name" onchange="setItemId()" required>
                    <option value="">Select Item</option>
                    <option value="Air Filter">Air Filter</option>
                    <option value="Light Bulb">Light Bulb</option>
                    <option value="Electrical Cable">Electrical Cable</option>
                    <option value="Paint (White)">Paint (White)</option>
                    <option value="Paint (Black)">Paint (Black)</option>
                    <option value="Hammer">Hammer</option>
                    <option value="Screwdriver Set">Screwdriver Set</option>
                    <option value="Nails (Various Sizes)">Nails (Various Sizes)</option>
                    <option value="Pipe Wrench">Pipe Wrench</option>
                    <option value="Teflon Tape">Teflon Tape</option>
                    <option value="Water Pump">Water Pump</option>
                    <option value="Battery (12V)">Battery (12V)</option>
                    <option value="Fire Extinguisher">Fire Extinguisher</option>
                    <option value="Extension Cord">Extension Cord</option>
                    <option value="Cleaning Cloth">Cleaning Cloth</option>
                    <option value="Duct Tape">Duct Tape</option>
                    <option value="Pipe Insulation">Pipe Insulation</option>
                    <option value="Power Drill">Power Drill</option>
                    <option value="Welding Machine">Welding Machine</option>
                    <option value="Safety Gloves">Safety Gloves</option>
                </select>

                <!-- Hidden Field for Item ID -->

                <input type="text" name="item_id" id="item_id" placeholder="Item ID" readonly required>

                <input type="date" name="usage_date" id="usage_date" readonly required>
                <input type="time" name="usage_time" id="usage_time" required>


                <input type="number" name="quantity" id="quantity" placeholder="Quantity" required>

                <button type="submit" class="btn-submit">Submit</button>
                <button type="button" class="btn-cancel" onclick="closeForm()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        // Automatically populate current date in the 'usage_date' field
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("usage_date").value = today;
            document.getElementById("usage_date").min = today; // Prevent selecting dates in the past
        });

        // Validate that 'usage_time' is the current time or later
        function validateForm() {
            const item_id = document.getElementById("item_id").value;
            const quantity = document.getElementById("quantity").value;
            const usage_date = document.getElementById("usage_date").value;
            const usage_time = document.getElementById("usage_time").value;

            if (!item_id || quantity <= 0) {
                alert("Please fill out all fields with valid data.");
                return false;
            }

            const currentDateTime = new Date();
            const selectedDateTime = new Date(`${usage_date}T${usage_time}`);

            if (selectedDateTime < currentDateTime) {
                alert("Please select the current time or a future time.");
                return false;
            }

            return true;
        }

        // Automatically set item ID based on item name
        function setItemId() {
            const itemName = document.getElementById("item_name").value;
            const itemId = getItemIdByName(itemName);
            document.getElementById("item_id").value = itemId; // Populate the Item ID field
        }

        // Map item names to item IDs
        function getItemIdByName(itemName) {
            const items = {
                "Air Filter": "INV-001",
                "Light Bulb": "INV-002",
                "Electrical Cable": "INV-003",
                "Paint (White)": "INV-004",
                "Paint (Black)": "INV-005",
                "Hammer": "INV-006",
                "Screwdriver Set": "INV-007",
                "Nails (Various Sizes)": "INV-008",
                "Pipe Wrench": "INV-009",
                "Teflon Tape": "INV-010",
                "Water Pump": "INV-011",
                "Battery (12V)": "INV-012",
                "Fire Extinguisher": "INV-013",
                "Extension Cord": "INV-014",
                "Cleaning Cloth": "INV-015",
                "Duct Tape": "INV-016",
                "Pipe Insulation": "INV-017",
                "Power Drill": "INV-018",
                "Welding Machine": "INV-019",
                "Safety Gloves": "INV-020"
            };
            return items[itemName] || ""; // Return the corresponding Item ID or an empty string if not found
        }

        // Open and close form functions
        function showForm() {
            document.getElementById("form-overlay").style.display = "flex";
        }

        function closeForm() {
            document.getElementById("form-overlay").style.display = "none";
        }

        // Edit log function remains unchanged
        function editLog(logId) {
            fetch(`<?php echo URLROOT; ?>/maintenance/getInventoryUsageLogById/${logId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate all form fields
                    document.getElementById("item_id").value = data.item_id || '';
                    document.getElementById("item_name").value = data.item_name || '';
                    document.getElementById("usage_date").value = data.usage_date || '';
                    document.getElementById("usage_time").value = data.usage_time || '';
                    document.getElementById("quantity").value = data.quantity || '';

                    // Make only quantity editable
                    document.getElementById("item_id").readOnly = true;
                    document.getElementById("item_name").readOnly = true;
                    document.getElementById("usage_date").readOnly = true;
                    document.getElementById("usage_time").readOnly = false;
                    document.getElementById("quantity").readOnly = false;
                    document.getElementById("quantity").focus(); // Optional: set focus on quantity

                    // Open the form overlay
                    document.getElementById("form-overlay").style.display = "flex";
                })
                .catch(error => {
                    console.error("Error fetching log data:", error);
                    alert('Failed to load log details. Please try again.');
                });
        }

        function deleteLog(logId) {
            if (confirm("Are you sure you want to delete this log?")) {
                window.location.href = "<?php echo URLROOT; ?>/maintenance/deleteInventoryUsage/" + logId;
            }
        }

        // Search and clear search functions remain unchanged
        function searchTable(tableId) {
            let input = document.getElementById("search-usage");
            let filter = input.value.toUpperCase();
            let table = document.getElementById(tableId);
            let trs = table.getElementsByTagName("tr");

            for (let i = 1; i < trs.length; i++) {
                let td = trs[i].getElementsByTagName("td");
                let found = false;
                for (let j = 0; j < td.length; j++) {
                    if (td[j].textContent.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                trs[i].style.display = found ? "" : "none";
            }
        }

        function clearSearch(inputId) {
            document.getElementById(inputId).value = "";
            searchTable('usage-log');
        }


        //search available store
        // function searchTable(tableId) {
        //     let input = document.getElementById("search-store");
        //     let filter = input.value.toUpperCase();
        //     let table = document.getElementById(tableId);
        //     let trs = table.getElementsByTagName("tr");

        //     for (let i = 1; i < trs.length; i++) {
        //         let td = trs[i].getElementsByTagName("td");
        //         let found = false;
        //         for (let j = 0; j < td.length; j++) {
        //             if (td[j].textContent.toUpperCase().indexOf(filter) > -1) {
        //                 found = true;
        //                 break;
        //             }
        //         }
        //         trs[i].style.display = found ? "" : "none";
        //     }
        // }

        // //available store clear
        // function clearSearch(inputId) {
        //     document.getElementById(inputId).value = "";
        //     searchTable('store');
        // }
    </script>



    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>