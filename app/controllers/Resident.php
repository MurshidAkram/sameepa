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


    public function maintenance()
    {
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



    public function submit_request()
    {
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


    public function request_details($request_id)
    {
        // Only allow access if user is logged in
        // if (!isLoggedIn()) {
        //     redirect('users/login');
        // }

        // Proceed to fetch and return request data
        $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);
        $request = $this->maintenanceModel->getRequestDetails($request_id, $residentId);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'request' => $request
        ]);
    }


    public function update_request($requestId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);

            // Verify the request belongs to the resident and is still editable
            if (!$this->maintenanceModel->isRequestEditable($requestId, $residentId)) {
                echo json_encode(['success' => false, 'message' => 'Request cannot be edited']);
                return;
            }

            $data = [
                'request_id' => $requestId,
                'type_id' => trim($_POST['requestType']),
                'description' => trim($_POST['description']),
                'urgency_level' => trim($_POST['urgency'])
            ];

            if ($this->maintenanceModel->updateRequest($data)) {
                echo json_encode(['success' => true, 'message' => 'Request updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update request']);
            }
        }
    }





    //**********************************************************************************delete request********************************************************************* */


    public function delete_request($requestId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $residentId = $this->residentModel->getResidentIdByUserId($_SESSION['user_id']);

            // Verify the request belongs to the resident and is still deletable
            if (!$this->maintenanceModel->isRequestEditable($requestId, $residentId)) {
                echo json_encode(['success' => false, 'message' => 'Request cannot be deleted']);
                return;
            }

            if ($this->maintenanceModel->deleteRequest($requestId)) {
                echo json_encode(['success' => true, 'message' => 'Request deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete request']);
            }
        }
    }
}
