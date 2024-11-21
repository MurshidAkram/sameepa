<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Inventory Management | Inventory System</title>

    <style>
        /* General Styles */
        /* General Body Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Layout Container */
.container {
    display: flex;
    flex-direction: row-reverse; /* Moves the side panel to the right */
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

/* Side Panel */
.side-panel {
    width: 20%;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
}

/* Main Content */
.main-content {
    width: 80%;
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
}

.section h2 {
    color: #2c3e50;
    margin-bottom: 20px;
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
    font-size: 1rem;
}

.search-bar button:hover {
    background-color: #2980b9;
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
    text-transform: uppercase;
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

.btn-edit {
    background-color: #17a2b8;
    color: white;
}

.btn-edit:hover {
    background-color: #138496;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
}

/* Break Alignment */
.breack {
    justify-content: space-between;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .side-panel,
    .main-content {
        width: 100%;
    }

    .side-panel {
        margin-bottom: 20px;
        box-shadow: none;
    }
}

    </style>
</head>

<body>

<?php require APPROOT . '/views/inc/components/navbar.php'; ?>
<div class="breack">
<div class="container">
    <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>
    </div>
    <h1>Inventory Management</h1>

    <!-- Inventory Usage Log Section -->
     <div>
    <section class="section">
        <h2>Inventory Usage Log</h2>
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
                <tr>
                    <td>INV-001</td>
                    <td>Air Filter</td>
                    <td>2024-09-20</td>
                    <td>10:30 AM</td>
                    <td>2</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>INV-002</td>
                    <td>Light Bulb</td>
                    <td>2024-09-18</td>
                    <td>3:45 PM</td>
                    <td>4</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
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


<script>
    // Function to search tables
    function searchTable(tableId) {
        const input = document.getElementById(`search-${tableId}`);
        const filter = input.value.toLowerCase();
        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            let match = false;
            const cells = rows[i].getElementsByTagName("td");
            for (let j = 0; j < cells.length; j++) {
                if (cells[j] && cells[j].innerText.toLowerCase().includes(filter)) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? "" : "none";
        }
    }

    // Function to clear search input and reset table
    function clearSearch(inputId) {
        document.getElementById(inputId).value = "";
        const event = new Event("keyup");
        document.getElementById(inputId).dispatchEvent(event);
    }
</script>

<?php require APPROOT . '/views/inc/components/footer.php'; ?>

</body>

</html>
