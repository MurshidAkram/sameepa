<?php

class Resident extends Controller
{
    private $residentModel;
    private $listingModel;


    public function __construct()
    {
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


    //***************************************resident request********************************** */

    // public function maintenance() {
    //     // Get the resident's maintenance requests
    //     $requests = $this->residentModel->getResidentRequests($_SESSION['user_id']);
        
    //     $data = [
    //         'requests' => $requests
    //     ];
        
    //     $this->view('resident/maintenance', $data);
    // }

     public function maintenance()
    {
        $this->view('resident/maintenance');
    }

    public function submit_request() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'resident_id' => $_SESSION['user_id'],
                'requestType' => trim($_POST['requestType']),
                'description' => trim($_POST['description']),
                'urgency' => trim($_POST['urgency']),
                'errors' => []
            ];
            
            // Validate data
            if (empty($data['requestType'])) {
                $data['errors']['requestType'] = 'Please select a request type';
            }
            
            if (empty($data['description'])) {
                $data['errors']['description'] = 'Please enter a description';
            }
            
            if (empty($data['urgency'])) {
                $data['errors']['urgency'] = 'Please select an urgency level';
            }
            
            // If no errors, submit request
            if (empty($data['errors'])) {
                if ($this->residentModel->submitMaintenanceRequest($data)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Maintenance request submitted successfully',
                        'redirect' => URLROOT . '/resident/maintenance'
                    ]);
                    exit;
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to submit request. Please try again.'
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fix the errors',
                    'errors' => $data['errors']
                ]);
                exit;
            }
        } else {
            redirect('resident/maintenance');
        }
    }

    public function request_details($request_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $request = $this->residentModel->getRequestDetails($request_id, $_SESSION['user_id']);
            
            if ($request) {
                echo json_encode([
                    'success' => true,
                    'request' => $request
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Request not found or not authorized'
                ]);
            }
        } else {
            redirect('resident/maintenance');
        }
    }





}
