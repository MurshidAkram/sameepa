<?php

class Resident extends Controller
{
    private $residentModel;
    private $listingModel;
    private $maintenanceModel;

    public function __construct()
    {

        $this->residentModel = $this->model('M_resident');
        $this->maintenanceModel = $this->model('M_maintenance');
        $this->checkResidentAuth();

        // Initialize any resident-specific models if needed
        // $this->residentModel = $this->model('M_Resident');
    }

    private function checkResidentAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 1) {
            // Redirect to unauthorized page
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }

    public function dashboard()
    {
        // Get any necessary data for the dashboard
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];

        // Load resident dashboard view with data
        $this->view('resident/dashboard', $data);
    }

    /*public function announcements()
    {
        // Load resident dashboard view
        $this->view('resident/announcements');
    }*/

    /*public function events()
    {
        // Load resident dashboard view
        $this->view('resident/events');
    }*/

    public function visitor_passes()
    {
        $this->view('resident/visitor_passes');
    }

    public function facilities()
    {
        $this->view('resident/facilities');
    }


    public function external_services()
    {
        $this->view('resident/external_services');
    }

    public function payments()
    {
        $this->view('resident/payments');
    }

    public function reports()
    {
        $this->view('resident/reports');
    }



    /*  public function complaints()
    {
        $this->view('resident/complaints');
    } */

    public function incident()
    {
        $this->view('resident/incident');
    }


    //***********************************************************************************resident request************************************************************************************** */


    public function maintenance() {
        // if (!isLoggedIn() || $_SESSION['user_role'] != 'resident') {
        //     redirect('users/login');
        // }
      
        $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);
        $requests = $this->maintenanceModel->getResidentRequests($residentId);
        $types = $this->maintenanceModel->getMaintenanceTypes();

        $data = [
            'requests' => $requests,
            'types' => $types
        ];

        $this->view('resident/maintenance', $data);
    }



//**********************************************************************create request************************************************************ */



    public function submit_request() {
        header('Content-Type: application/json'); // Ensure JSON response
        
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
    
        try {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);
            if (!$residentId) {
                echo json_encode(['success' => false, 'message' => 'Resident not found']);
                return;
            }
            
            $data = [
                'resident_id' => $residentId,
                'type_id' => isset($_POST['requestType']) ? trim($_POST['requestType']) : '',
                'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
                'urgency_level' => isset($_POST['urgency']) ? trim($_POST['urgency']) : '',
                'type_error' => '',
                'description_error' => '',
                'urgency_error' => ''
            ];
    
            // Validate
            $valid = true;
            
            if (empty($data['type_id'])) {
                $data['type_error'] = 'Please select a request type';
                $valid = false;
            }
            
            if (empty($data['description'])) {
                $data['description_error'] = 'Please enter a description';
                $valid = false;
            }
            
            if (empty($data['urgency_level'])) {
                $data['urgency_error'] = 'Please select an urgency level';
                $valid = false;
            }
    
            if (!$valid) {
                echo json_encode([
                    'success' => false, 
                    'errors' => [
                        'requestType' => $data['type_error'],
                        'description' => $data['description_error'],
                        'urgency' => $data['urgency_error']
                    ],
                    'message' => 'Validation failed'
                ]);
                return;
            }
    
            // Submit to database
            if ($this->maintenanceModel->submitRequest($data)) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Request submitted successfully',
                    'request_id' => $this->maintenanceModel->getLastInsertId()
                ]);
            } else {
                error_log("Failed to submit request - Model returned false");
                echo json_encode([
                    'success' => false, 
                    'message' => 'Failed to save request to database. Please check server logs.'
                ]);
            }
        } catch (Exception $e) {
            error_log("Error in submit_request: " . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }




//*********************************************************************************edit request************************************************************************ */
public function request_details($requestId) {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');

    try {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);
        if (!$residentId) {
            throw new Exception("Resident not found");
        }

        $request = $this->maintenanceModel->getRequestDetails($requestId, $residentId);
        if (!$request) {
            throw new Exception("Request not found");
        }

        echo json_encode(['success' => true, 'request' => $request]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Internal error',
            'error' => $e->getMessage()
        ]);
    }

    exit;
}
public function update_request($requestId) {
    // Clear any existing output
    if (ob_get_length()) ob_clean();
    
    // Set JSON header first
    header('Content-Type: application/json');
    
    try {
        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Invalid request method', 405);
        }

        // Get resident ID
        $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);
        if (!$residentId) {
            throw new Exception('Resident not found or unauthorized', 403);
        }

        // Validate input
        $errors = [];
        $type = trim($_POST['requestType'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $urgency = trim($_POST['urgency'] ?? '');

        if (empty($type)) $errors['requestType'] = 'Request type is required';
        if (empty($desc)) $errors['description'] = 'Description is required';
        if (empty($urgency)) $errors['urgency'] = 'Urgency level is required';

        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ]);
            exit;
        }

        // Update the request
        $updated = $this->maintenanceModel->updateRequest([
            'request_id' => $requestId,
            'resident_id' => $residentId,
            'type_id' => $type,
            'description' => $desc,
            'urgency_level' => $urgency
        ]);

        if ($updated) {
            echo json_encode([
                'success' => true,
                'message' => 'Request updated successfully'
            ]);
        } else {
            throw new Exception('Failed to update request', 500);
        }
    } catch (Exception $e) {
        http_response_code($e->getCode() ?: 500);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}


//**********************************************************************************delete request********************************************************************* */
   
public function delete_request($requestId) {
    // Only allow DELETE requests
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        http_response_code(405); // Method Not Allowed
        echo json_encode([
            'success' => false,
            'message' => 'Only DELETE requests are allowed'
        ]);
        return;
    }

    try {
        $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);
        
        if (empty($residentId)) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Resident not found'
            ]);
            return;
        }

        // Verify the request belongs to the resident and is still deletable
        if (!$this->maintenanceModel->isRequestEditable($requestId, $residentId)) {
            http_response_code(403); // Forbidden
            echo json_encode([
                'success' => false,
                'message' => "Request cannot be deleted (either not yours or not pending)"
            ]);
            return;
        }

        if ($this->maintenanceModel->delete_request($requestId)) {
            echo json_encode([
                'success' => true,
                'message' => 'Request deleted successfully'
            ]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete request'
            ]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
}
   



}

