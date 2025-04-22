<?php

class Maintenance extends Controller
{
    private $maintenanceModel;
    private $userModel;

    public function __construct()
    {
        $this->checkMaintenanceAuth();

        // Initialize the maintenance model
        $this->maintenanceModel = $this->model('M_maintenance'); // Make sure this matches your actual model class
        $this->userModel = $this->model('M_Users'); // Initialize user model
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

public function Resident_Requests() {
        // Get all maintenance requests
        $requests = $this->maintenanceModel->getAllRequests();
        
        // Get request history (completed/cancelled requests)
        $history = $this->maintenanceModel->getRequestHistory();
        
        // Get maintenance types for filter dropdown
        $types = $this->maintenanceModel->getMaintenanceTypes();
        
        // Get statuses for filter dropdown
        $statuses = $this->maintenanceModel->getMaintenanceStatuses();
        
        // Get maintenance staff for assign dropdown
        $staff = $this->maintenanceModel->getMaintenanceStaff();
        
        $data = [
            'requests' => $requests,
            'history' => $history,
            'types' => $types,
            'statuses' => $statuses,
            'staff' => $staff
        ];
        
        $this->view('maintenance/Resident_Requests', $data);
    }

    // public function submit_request() {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         // Sanitize POST data
    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
    //         $data = [
    //             'resident_id' => $_SESSION['user_id'],
    //             'requestType' => trim($_POST['requestType']),
    //             'description' => trim($_POST['description']),
    //             'urgency' => trim($_POST['urgency']),
    //             'errors' => []
    //         ];
            
    //         // Validate data
    //         if (empty($data['requestType'])) {
    //             $data['errors']['requestType'] = 'Please select a request type';
    //         }
            
    //         if (empty($data['description'])) {
    //             $data['errors']['description'] = 'Please enter a description';
    //         }
            
    //         if (empty($data['urgency'])) {
    //             $data['errors']['urgency'] = 'Please select an urgency level';
    //         }
            
    //         // If no errors, submit request
    //         if (empty($data['errors'])) {
    //             if ($this->maintenanceModel->submitRequest($data)) {
    //               //  flash('request_success', 'Maintenance request submitted successfully');
    //                 redirect('residents/dashboard');
    //             } else {
    //                 die('Something went wrong');
    //             }
    //         } else {
    //             // Load view with errors
    //             $this->view('residents/submit_request', $data);
    //         }
    //     } else {
    //         // Load the form
    //         $types = $this->maintenanceModel->getMaintenanceTypes();
            
    //         $data = [
    //             'requestType' => '',
    //             'description' => '',
    //             'urgency' => '',
    //             'types' => $types
    //         ];
            
    //         $this->view('residents/submit_request', $data);
    //     }
    // }

    // public function updateDueDate() {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $requestId = $_POST['requestId'];
    //         $dueDate = $_POST['dueDate'];
            
    //         if ($this->maintenanceModel->updateRequestDueDate($requestId, $dueDate)) {
    //             echo json_encode(['success' => true]);
    //         } else {
    //             echo json_encode(['success' => false]);
    //         }
    //     }
    // }

    

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $requestId = $_POST['requestId'];
            $statusId = $_POST['statusId'];
            
            if ($this->maintenanceModel->updateRequestStatus($requestId, $statusId)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    // In your Maintenance controller

public function getSpecializations() {
    $specializations = $this->maintenanceModel->getMaintenanceSpecializations();
    echo json_encode($specializations);
}

public function getStaffBySpecialization() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $specialization = $_POST['specialization'];
        $staff = $this->maintenanceModel->getMaintenanceStaffBySpecialization($specialization);
        echo json_encode($staff);
    }
}

// Updated assignMaintainer method
public function assignMaintainer() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $requestId = $_POST['requestId'];
        $staffId = $_POST['staffId'];
        
        if ($this->maintenanceModel->assignMaintainerToRequest($requestId, $staffId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}

//*************************************resident side maintainenace requests****************** */

public function submit_request() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'resident_id' => $_SESSION['user_id'],
            'type_id' => $_POST['type_id'],
            'description' => $_POST['description'],
            'urgency_level' => $_POST['urgency_level']
        ];

        // Call your model to insert into DB
        if ($this->maintenanceModel->submitRequest($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}



//************************************************************************************************************************************************** */
}
