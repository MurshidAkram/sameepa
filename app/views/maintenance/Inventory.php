<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Inventory Management | Inventory System</title>

    <style>
        /* Internal CSS for Inventory Management */

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
        }

        /* Section Styles */
        .section {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .section h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        /* Alerts */
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
        }

        .btn-reorder {
            background-color: #28a745;
        }

        .btn-contact {
            background-color: #17a2b8;
        }
    </style>
</head>

<body>

<?php require APPROOT . '/views/inc/components/navbar.php'; ?>

        
    <div class="container">
    <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <h1>Inventory Management</h1>

        <!-- Detailed Item Profiles -->
        <section class="section">
            <h2>Item Profiles</h2>
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Supplier</th>
                        <th>Purchase Date</th>
                        <th>Cost</th>
                        <th>Storage Location</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>INV-001</td>
                        <td>Air Filter</td>
                        <td>SupplyCo Ltd.</td>
                        <td>2024-09-15</td>
                        <td>$15</td>
                        <td>Aisle 3, Shelf B</td>
                        <td>40</td>
                    </tr>
                    <tr>
                        <td>INV-002</td>
                        <td>Light Bulb</td>
                        <td>BrightLight Corp.</td>
                        <td>2024-08-22</td>
                        <td>$2</td>
                        <td>Aisle 1, Shelf A</td>
                        <td>10</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Low Stock Alerts -->
        <section class="section">
            <h2>Low Stock Alerts</h2>
            <div class="alert">
                ⚠️ Low Stock Alert: Light Bulb - Only 10 remaining. <button class="btn btn-reorder">Reorder</button>
            </div>
        </section>

        <!-- Supplier Information -->
        <section class="section">
            <h2>Supplier Information</h2>
            <table>
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Contact</th>
                        <th>Contract Terms</th>
                        <th>Last Delivery Date</th>
                        <th>Typical Delivery Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SupplyCo Ltd.</td>
                        <td>John Doe, (123) 456-7890</td>
                        <td>Yearly contract</td>
                        <td>2024-09-15</td>
                        <td>5 business days</td>
                    </tr>
                    <tr>
                        <td>BrightLight Corp.</td>
                        <td>Jane Smith, (987) 654-3210</td>
                        <td>On-demand</td>
                        <td>2024-08-22</td>
                        <td>7 business days</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Inventory Usage Log -->
        <section class="section">
            <h2>Inventory Usage Log</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Item</th>
                        <th>Quantity Used</th>
                        <th>Used For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-09-20</td>
                        <td>Air Filter</td>
                        <td>2</td>
                        <td>HVAC Repair</td>
                    </tr>
                    <tr>
                        <td>2024-09-18</td>
                        <td>Light Bulb</td>
                        <td>4</td>
                        <td>Common Area Lighting</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Reorder Management -->
        <section class="section">
            <h2>Reorder Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Expected Delivery</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ORD-1001</td>
                        <td>Air Filter</td>
                        <td>50</td>
                        <td>Pending</td>
                        <td>2024-09-25</td>
                    </tr>
                    <tr>
                        <td>ORD-1002</td>
                        <td>Light Bulb</td>
                        <td>100</td>
                        <td>Shipped</td>
                        <td>2024-09-23</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Cost Tracking -->
        <section class="section">
            <h2>Cost Tracking</h2>
            <table>
                <thead>
                    <tr>
                        <th>Item Type</th>
                        <th>Monthly Cost</th>
                        <th>Quarterly Cost</th>
                        <th>Yearly Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Air Filters</td>
                        <td>$150</td>
                        <td>$450</td>
                        <td>$1800</td>
                    </tr>
                    <tr>
                        <td>Light Bulbs</td>
                        <td>$40</td>
                        <td>$120</td>
                        <td>$480</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
