<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Inventory Management</title>

    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
            box-sizing: border-box;
            position: relative;
        }

        /* Layout Container */
        .container {
            display: flex;
            flex-direction: row;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        /* Side Panel */
        .side-panel {
    width:100%;
    background-color: #34495e;
    color: #fff;
 
    height: 100vh;
    box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
}

        /* Main Content */
        .main-content {
            width: 95%;
            padding: 20px;
        }

        /* Header Styles */
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .section {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 70%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px 15px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Buttons */
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            margin: 0 5px;
        }

        .btn-create {
            background-color: #28a745;
            color: white;
            margin-bottom: 20px;
        }

        .btn-create:hover {
            background-color: #218838;
        }

        .btn-edit {
            background-color: #17a2b8;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
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
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container input {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-container button {
            margin: 5px 0;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container .btn-submit {
            background-color: #28a745;
            color: white;
        }

        .form-container .btn-cancel {
            background-color: #dc3545;
            color: white;
        }

        /* Style for the container */
.form-container select {
    width: 100%; /* Full width */
    padding: 10px; /* Add padding for better usability */
    margin: 10px 0; /* Add spacing between elements */
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Increase font size for readability */
    background-color: #f9f9f9; /* Light background color */
    color: #333; /* Text color */
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); /* Slight inner shadow */
    transition: border-color 0.3s, box-shadow 0.3s; /* Smooth transition */
}

/* Add focus effect */
.form-container select:focus {
    border-color: #007bff; /* Highlight border */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Outer glow */
    outline: none; /* Remove default outline */
}

/* Style for the dropdown arrow */
.form-container select {
    -webkit-appearance: none; /* Remove default arrow for webkit browsers */
    -moz-appearance: none; /* Remove default arrow for Firefox */
    appearance: none; /* Remove default arrow */
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6"><path fill="%23333" d="M0 0l5 6 5-6z"/></svg>'); /* Custom arrow */
    background-repeat: no-repeat; /* Prevent repeat of arrow */
    background-position: right 10px center; /* Position arrow */
    background-size: 10px 6px; /* Size of the arrow */
}

/* Style the placeholder option */
.form-container select option[value=""] {
    color: #aaa; /* Light gray for placeholder */
}

/* Ensure the dropdown works well on smaller screens */
@media (max-width: 600px) {
    .form-container select {
        font-size: 14px; /* Smaller font size on smaller screens */
    }
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
                <tr>
                    <td>INV-001</td>
                    <td>Air Filter</td>
                    <td>2024-09-15</td>
                    <td>40</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>INV-002</td>
                    <td>Light Bulb</td>
                    <td>2024-08-22</td>
                    <td>10</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
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
            
            <input type="date" name="usage_date" id="usage_date" required>
            
            <input type="time" name="usage_time" id="usage_time" required>
            
            <input type="number" name="quantity" id="quantity" placeholder="Quantity" required>
            
            <button type="submit" class="btn-submit">Submit</button>
            <button type="button" class="btn-cancel" onclick="closeForm()">Cancel</button>
        </form>
    </div>
</div>



      <script>
    function showForm() {
        document.getElementById("form-overlay").style.display = "flex";
    }

    function closeForm() {
        document.getElementById("form-overlay").style.display = "none";
    }

  function editLog(logId) {
    // Make an AJAX request to fetch the log data by its ID
    fetch("<?php echo URLROOT; ?>/maintenance/getInventoryUsageLogById/" + logId)
        .then(response => response.json())
        .then(data => {
            // Populate the form fields with the existing log data
            document.getElementById("item_id").value = data.item_id;
            document.getElementById("item_name").value = data.item_name;
            document.getElementById("usage_date").value = data.usage_date;
            document.getElementById("usage_time").value = data.usage_time;
            document.getElementById("quantity").value = data.quantity;

            // Disable all fields except the quantity field
            document.getElementById("item_id").disabled = true;
            document.getElementById("item_name").disabled = true;
            document.getElementById("usage_date").disabled = true;
            document.getElementById("usage_time").disabled = true;
            document.getElementById("quantity").disabled = false;

            // Open the form overlay
            document.getElementById("form-overlay").style.display = "flex";
        })
        .catch(error => console.error("Error fetching log data:", error));
}



    function deleteLog(logId) {
        if (confirm("Are you sure you want to delete this log?")) {
            window.location.href = "<?php echo URLROOT; ?>/maintenance/deleteInventoryUsage/" + logId;
        }
    }
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

    function validateForm() {
        let item_id = document.getElementById("item_id").value;
        let quantity = document.getElementById("quantity").value;

        if (item_id == "" || quantity <= 0) {
            alert("Please fill out all fields with valid data.");
            return false;
        }

        return true;
    }

    function setItemId() {
    const itemName = document.getElementById("item_name").value;
    const itemId = getItemIdByName(itemName);
    document.getElementById("item_id").value = itemId; // Populate the Item ID field
}

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

</script>


    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
