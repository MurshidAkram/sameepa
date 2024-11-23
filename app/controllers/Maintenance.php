<?php

class Maintenance extends Controller
{
    private $maintenanceModel;

    public function __construct()
    {
        $this->checkMaintenanceAuth();
        $this->maintenanceModel = $this->model('M_maintenance');
    }

    private function checkMaintenanceAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 4)
        if ($_SESSION['user_role_id'] != 4) {
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }

    // Dashboard
    public function dashboard()
    {
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];
        $this->view('maintenance/dashboard', $data);
    }

    // Display Inventory Usage Logs
    public function inventory()
    {
        // Fetch all inventory usage logs from the model
        $logs = $this->maintenanceModel->getInventoryUsageLogs();
    
        // Prepare the data to pass to the view
        $data = [
            'logs' => $logs
        ];
    
        // Load the inventory view and pass the data
        $this->view('maintenance/inventory', $data);
    }

    // Add an inventory usage log entry
    public function addInventoryUsage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize and get form data
            $data = [
                'item_id' => trim($_POST['item_id']),
                'item_name' => trim($_POST['item_name']),
                'usage_date' => trim($_POST['usage_date']),
                'usage_time' => trim($_POST['usage_time']),
                'quantity' => trim($_POST['quantity'])
            ];

            // Insert the log data into the database using the model
            if ($this->maintenanceModel->addInventoryUsageLog($data)) {
                // Redirect back to inventory page
                header('Location: ' . URLROOT . '/maintenance/inventory');
                exit;
            } else {
                die('Something went wrong');
            }
        } else {
            // Load the view for adding an inventory usage log
            $this->view('maintenance/add_inventory_usage');
        }
    }
    
    // Edit an inventory usage log entry
    public function editInventoryUsage($log_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'log_id' => $log_id,
                'item_id' => $_POST['item_id'],
                'item_name' => $_POST['item_name'],
                'usage_date' => $_POST['usage_date'],
                'usage_time' => $_POST['usage_time'],
                'quantity' => $_POST['quantity']
            ];

            

            // Update the log data in the database
            if ($this->maintenanceModel->updateInventoryUsageLog($data)) {
                // Redirect to inventory page
                header('Location: ' . URLROOT . '/maintenance/inventory');
            } else {
                die('Something went wrong');
            }
        } else {
            // Fetch log data for pre-population
            $log = $this->maintenanceModel->getInventoryUsageLogById($log_id);
            $data = [
                'log' => $log
            ];
            $this->view('maintenance/edit_inventory_usage', $data);
        }
    }

    // Delete an inventory usage log
    public function deleteInventoryUsage($log_id)
    {
        if ($this->maintenanceModel->deleteInventoryUsageLog($log_id)) {
            header('Location: ' . URLROOT . '/maintenance/inventory');
        } else {
            die('Error deleting log');
        }
    }

    // Fetch a specific log by ID
    public function getInventoryUsageLogById($log_id)
    {
        $log = $this->maintenanceModel->getInventoryUsageLogById($log_id);
        echo json_encode($log);
    }
}
