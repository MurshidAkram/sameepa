<?php

class Maintenance extends Controller
{
    private $maintenanceModel;

    public function __construct()
    {
        $this->checkMaintenanceAuth();

        // Initialize the maintenance model
        $this->maintenanceModel = $this->model('M_maintenance'); // Make sure this matches your actual model class
    }

    private function checkMaintenanceAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user has the correct role (role_id = 4 for maintenance)
        if ($_SESSION['user_role_id'] != 4) {
            // Redirect to unauthorized page
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }
    //*************************************************************************************************************************************************** */
    // Dashboard
    public function dashboard()
    {
        // Pass necessary data for the dashboard
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];

        // Load the dashboard view
        $this->view('maintenance/dashboard', $data);
    }
    //*************************************************************************************************************************************************** */

    // Team Scheduling Page
    public function Team_Scheduling()
    {
        $members = $this->maintenanceModel->getAllMembers();
        $data = ['members' => $members];
        $this->view('maintenance/team_scheduling', $data);
    }

    // Add a new member
    public function addMember()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'specialization' => trim($_POST['specialization']),
                'experience' => trim($_POST['experience']),
                'certifications' => trim($_POST['certifications']),
                'profile_image' => $_FILES['profileImage']['name'] // Save image name
            ];

            // Move uploaded file to the server
            if (!empty($_FILES['profileImage']['name'])) {
                $uploadDir = 'img/';
                $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);
                move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile);
            }

            // Add to database
            if ($this->maintenanceModel->addMember($data)) {
                header('Location: ' . URLROOT . '/maintenance/team_scheduling');
                exit();
            } else {
                die('Error adding member');
            }

            if ($this->maintenanceModel->addMember($data)) {
                echo json_encode([
                    'success' => true,
                    'name' => $data['name'],
                    'specialization' => $data['specialization'],
                    'experience' => $data['experience'],
                    'profile_image' => URLROOT . '/img/' . $data['profile_image']
                ]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    public function editMember($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'specialization' => trim($_POST['specialization']),
                'experience' => trim($_POST['experience']),
                'certifications' => trim($_POST['certifications']),
                'profile_image' => !empty($_FILES['profileImage']['name']) ? $_FILES['profileImage']['name'] : null
            ];

            if ($data['profile_image']) {
                $uploadDir = 'img/';
                $uploadFile = $uploadDir . basename($data['profile_image']);
                move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile);
            }

            if ($this->maintenanceModel->updateMember($data)) {
                echo json_encode([
                    'success' => true,
                    'name' => $data['name'],
                    'specialization' => $data['specialization'],
                    'experience' => $data['experience'],
                    'profile_image' => $data['profile_image'] ? URLROOT . '/img/' . $data['profile_image'] : null
                ]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    // Delete a member
    public function deleteMember($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Call model to delete member
            if ($this->maintenanceModel->deleteMember($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }








    //*************************************************************************************************************************************************** */


    public function Resident_Requests()
    {
        // This will load the view to update or manage duty schedules
        $this->view('maintenance/Resident_Requests');
    }

    public function Reports_Analytics()
    {
        $this->view('maintenance/Reports_Analytics');
    }
    public function Scheme_Maintenance()
    {
        $this->view('maintenance/Scheme_Maintenance');
    }
}



//************************************************************************************************************************************************** */
   
//  // Inventory CRUD
//     // Display Inventory Usage Logs
//     public function inventory()
//     {
//         // Fetch all inventory usage logs from the model
//         $logs = $this->maintenanceModel->getInventoryUsageLogs();
    
//         // Check if the logs were retrieved successfully
//         if ($logs === false) {
//             die('Error fetching inventory logs');
//         }
    
//         // Prepare the data to pass to the view
//         $data = [
//             'logs' => $logs
//         ];
    
//         // Load the inventory view with the data
//         $this->view('maintenance/inventory', $data);
//     }

//     // Add an inventory usage log entry
//     public function addInventoryUsage()
//     {
//         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//             // Sanitize and get form data
//             $data = [
//                 'item_id' => trim($_POST['item_id']),
//                 'item_name' => trim($_POST['item_name']),
//                 'usage_date' => trim($_POST['usage_date']),
//                 'usage_time' => trim($_POST['usage_time']),
//                 'quantity' => trim($_POST['quantity'])
//             ];

//             // Insert the log data into the database using the model
//             if ($this->maintenanceModel->addInventoryUsageLog($data)) {
//                 // Redirect back to inventory page
//                 header('Location: ' . URLROOT . '/maintenance/inventory');
//                 exit;
//             } else {
//                 die('Something went wrong');
//             }
//         } else {
//             // Load the view for adding an inventory usage log
//             $this->view('maintenance/add_inventory_usage');
//         }
//     }

//     public function editInventoryUsage($log_id)
//     {
//         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//             $data = [
//                 'log_id' => $log_id,
//                 'item_id' => $_POST['item_id'],
//                 'item_name' => $_POST['item_name'],
//                 'usage_date' => $_POST['usage_date'],
//                 'usage_time' => $_POST['usage_time'],
//                 'quantity' => $_POST['quantity']
//             ];
    
//             // Update only the quantity in the database
//             if ($this->maintenanceModel->updateInventoryUsageLog($data)) {
//                 header('Location: ' . URLROOT . '/maintenance/inventory');
//             } else {
//                 die('Something went wrong');
//             }
//         } else {
//             $log = $this->maintenanceModel->getInventoryUsageLogById($log_id);
//             $data = [
//                 'log' => $log
//             ];
//             $this->view('maintenance/edit_inventory_usage', $data);
//         }
//     }

//     // Delete an inventory usage log
//     public function deleteInventoryUsage($log_id)
//     {
//         if ($this->maintenanceModel->deleteInventoryUsageLog($log_id)) {
//             header('Location: ' . URLROOT . '/maintenance/inventory');
//         } else {
//             die('Error deleting log');
//         }
//     }

//     // Fetch a specific log by ID
//     public function getInventoryUsageLogById($log_id)
//     {
//         $log = $this->maintenanceModel->getInventoryUsageLogById($log_id);
//         echo json_encode($log);
//     }
