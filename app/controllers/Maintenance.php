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
        $this->view('maintenance/Team_Scheduling', $data);
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

                'phone_number' => trim($_POST['phone_number']),
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
                header('Location: ' . URLROOT . 'maintenance/Team_Scheduling');
                exit();
            } else {
                die('Error adding member');
            }

            if ($this->maintenanceModel->addMember($data)) {
                echo json_encode([
                    'success' => true,
                    'name' => $data['name'],
                    'specialization' => $data['specialization'],
                    'phone_number' => $data['phone_number'],
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
                'phone_number' => trim($_POST['phone_number']),
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
                    'phone_number' => $data['phone_number'],
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






    public function Reports_Analytics()
    {
        $this->view('maintenance/Reports_Analytics');
    }
    public function Scheme_Maintenance()
    {
        $this->view('maintenance/Scheme_Maintenance');
    }






    //*****************************************resident requests****************************************************************************************************************** */


    public function Resident_Requests()
    {
        // This will load the view to update or manage duty schedules
        $this->view('maintenance/Resident_Requests');
    }



    // In your Maintenance controller
    public function requests()
    {
        // Get all maintenance requests with related data
        $requests = $this->maintenanceModel->getAllRequests();

        // Get maintenance types for filter
        $types = $this->maintenanceModel->getMaintenanceTypes();

        // Get statuses for filter
        $statuses = $this->maintenanceModel->getRequestStatuses();

        // Get maintenance staff for assignment
        $staff = $this->maintenanceModel->getMaintenanceStaff();

        // Get request history stats
        $history = $this->maintenanceModel->getRequestHistory();

        $data = [
            'requests' => $requests,
            'types' => $types,
            'statuses' => $statuses,
            'staff' => $staff,
            'history' => $history
        ];

        $this->view('maintenance/requests', $data);
    }

    public function updateDueDate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if ($this->maintenanceModel->updateDueDate($data['requestId'], $data['dueDate'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function assignMaintainer()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if ($this->maintenanceModel->assignMaintainer(
                $data['requestId'],
                $data['staffId'],
                $data['dueDate']
            )) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }


    //************************************************************************************************************************************************** */
}
