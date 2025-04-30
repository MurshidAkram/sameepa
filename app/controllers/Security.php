<?php

class Security extends Controller
{

    private $securityModel;

    public function __construct()
    {
        $this->checkSecurityAuth();

        $this->securityModel = $this->model('M_security');
    }

    private function checkSecurityAuth()
    {
       
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

       
        if (!in_array($_SESSION['user_role_id'], [2, 3, 5])) {
            
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }

    //**************************************************dash board********************************************************* */

    public function dashboard()
    {
        // Get data for dashboard
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['user_name'] ?? '',
            'role' => $_SESSION['user_role'],
            'todayPasses' => $this->securityModel->getTodayPasses(),
            'onDutyOfficers' => $this->securityModel->getTodayDutyOfficers(),
            'incidentTrends' => $this->securityModel->getMonthlyIncidentTrends(),
            'visitorFlow' => $this->securityModel->getWeeklyVisitorFlow(),
            'miniOfficer' => $this->getMiniOfficerData() 
        ];

   
        $this->view('security/dashboard', $data);
    }

    public function getChartData()
    {
       
        $data = [
            'success' => true,
            'activePasses' => count($this->securityModel->getTodayPasses()),
            'onDuty' => count($this->securityModel->getTodayDutyOfficers()),
            'data' => [
                'accessLogs' => $this->securityModel->getWeeklyVisitorFlow(),
                'incidentTrends' => $this->securityModel->getMonthlyIncidentTrends(),
                'visitorFlow' => $this->securityModel->getWeeklyVisitorFlow()
            ]
        ];

        echo json_encode($data);
    }

    private function getMiniOfficerData()
    {
        
        $officers = $this->securityModel->getTodayDutyOfficers();
        $labels = [];
        $data = [];

        foreach ($officers as $officer) {
            $labels[] = $officer->name;
            $data[] = 1; 
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }


    //*************************************visitor passes******************************************************** */

    public function Manage_Visitor_Passes()
    {
        
        $passes = $this->securityModel->getVisitorPasses();

     
        if ($this->isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode($passes);
            exit;
        }

       
        $data = [
            'todayPasses' => $passes['todayPasses'],
            'historyPasses' => $passes['historyPasses']
        ];

        $this->view('security/Manage_Visitor_Passes', $data);
    }

    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }


    public function Add_Visitor_Pass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          
            $data = [
                'visitor_name' => trim($_POST['visitor_name']),
                'visitor_count' => trim($_POST['visitor_count']),
                'resident_name' => trim($_POST['resident_name']),
                'visit_date' => trim($_POST['visit_date']),
                'visit_time' => trim($_POST['visit_time']),
                'duration' => trim($_POST['duration']),
                'purpose' => trim($_POST['purpose'])
            ];

          
            $currentDateTime = new DateTime();
            $visitDateTime = new DateTime($data['visit_date'] . ' ' . $data['visit_time']);

          

            if ($visitDateTime < $currentDateTime) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Cannot create visitor pass for past date/time'
                ]);
                exit();
            }

           
            $newPassId = $this->securityModel->addVisitorPass($data);

            if ($newPassId) {
                
                echo json_encode([
                    'success' => true,
                    'id' => $newPassId,
                    'visitor_name' => $data['visitor_name'],
                    'visitor_count' => $data['visitor_count'],
                    'resident_name' => $data['resident_name'],
                    'visit_date' => $data['visit_date'],
                    'visit_time' => $data['visit_time'],
                    'duration' => $data['duration'],
                    'purpose' => $data['purpose']
                ]);
                exit();
            } else {
              
                echo json_encode([
                    'success' => false,
                    'message' => 'Database error: Failed to insert visitor pass.'
                ]);
                exit();
            }
        }

     
        $this->view('security/Manage_Visitor_Passes');
    }


//*******************************************Emergency_Contacts*************************************************************************************************** */


public function Emergency_Contacts() {

    $categories = $this->securityModel->getAllContactCategories();
    $contactsByCategory = [];
    
    foreach ($categories as $category) {
        $contactsByCategory[$category->id] = [
            'category' => $category,
            'contacts' => $this->securityModel->getContactsByCategory($category->id)
        ];
    }
    
    $data = ['contactsByCategory' => $contactsByCategory];
    $this->view('security/Emergency_Contacts', $data);
}


public function Edit_Contact($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $contactData = [
            'id' => $id,
            'name' => trim($data['name']),
            'phone' => trim($data['phone']),
            'description' => trim($data['description'] ?? '')
        ];

            if ($this->securityModel->updateContact($contactData)) {
                echo json_encode([
                    'success' => true,
                    'name' => $contactData['name'],
                    'phone' => $contactData['phone'],
                    'description' => $contactData['description']
                ]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function Add_Contact()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'category_id' => trim($_POST['category_id']),
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'description' => trim($_POST['description'] ?? '')
            ];

        if ($this->securityModel->addContact($data)) {
            echo json_encode([
                'success' => true,
                'contact' => [
                    'id' => $this->securityModel->getLastInsertId(),
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'description' => $data['description']
                ]
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}

public function Delete_Contact($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        if ($this->securityModel->deleteContact($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}

    //*****************************************Search Resident_Contacts in Manage_Visitor_Passes***************************************************************************************************** */

    public function Resident_Contacts()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_query'])) {
           
            $query = trim($_GET['search_query']);

            
            if (empty($query)) {
                echo json_encode(['error' => 'Search query cannot be empty']);
                return;
            }

            
            $query = filter_var($query, FILTER_SANITIZE_STRING);

            
            $results = $this->securityModel->searchResidentContacts($query);

            
            header('Content-Type: application/json');
            echo json_encode($results);

            exit;
        }

   
        $this->view('security/Resident_Contacts');
    }
    //******************************************Manage_Incident_Reports******************************************************************************************* */

    public function Manage_Incident_Reports()
    {
        $data = [
            'title' => 'Manage Incident Reports'
        ];
        $this->view('security/Manage_Incident_Reports', $data);
    }

    public function getAllIncidents()
    {
        header('Content-Type: application/json');

        try {
            $incidents = $this->securityModel->getAllIncidents();
            echo json_encode([
                'success' => true,
                'incidents' => $incidents
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
        exit;
    }

    public function Add_Incident()
    {
        header('Content-Type: application/json');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Only POST requests are accepted');
            }

            $rawData = file_get_contents('php://input');
            $postData = json_decode($rawData, true) ?? $_POST;

            // Validate required fields
            $requiredFields = ['type', 'date', 'time', 'location','pri', 'status'];
            foreach ($requiredFields as $field) {
                if (empty($postData[$field])) {
                    throw new Exception("Field '$field' is required");
                }
            }

            $data = [
                'type' => htmlspecialchars(trim($postData['type'])),
                

                'date' => htmlspecialchars(trim($postData['date'])),
                'time' => htmlspecialchars(trim($postData['time'])),
                'location' => htmlspecialchars(trim($postData['location'])),
                'description' => htmlspecialchars(trim($postData['description'] ?? '')),
                'pri' => htmlspecialchars(trim($postData['pri'])),
                'status' => htmlspecialchars(trim($postData['status']))
            ];

            // Validate status
            $allowedStatuses = ['Open', 'In Progress', 'Resolved', 'Closed', 'Pending'];
            if (!in_array($data['status'], $allowedStatuses)) {
                throw new Exception('Invalid status value');
            }

            $incidentId = $this->securityModel->addIncident($data);

            if (!$incidentId) {
                throw new Exception('Failed to save incident to database');
            }

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Incident added successfully',
                'incident_id' => $incidentId
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function updateIncident($report_id = null)
    {
        header('Content-Type: application/json');

        try {
            $rawInput = file_get_contents('php://input');
            $data = json_decode($rawInput, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON input');
            }

            $report_id = $report_id ?? $data['report_id'] ?? null;

            if (empty($report_id) || !isset($data['status'])) {
                throw new Exception('Missing required fields');
            }

            // Validate status
            $allowedStatuses = ['Open', 'In Progress', 'Resolved', 'Closed', 'Pending'];
            if (!in_array($data['status'], $allowedStatuses)) {
                throw new Exception('Invalid status value. Allowed values: ' . implode(', ', $allowedStatuses));
            }

            if (!is_numeric($report_id)) {
                throw new Exception('Invalid report ID');
            }

            
            if ($this->securityModel->updateIncidentStatus($report_id, $data['status'])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Status updated successfully'
                ]);
            } else {
                throw new Exception('Failed to update status. The incident may not exist or no changes were made.');
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }


    //**********************************************Manage_Duty_Schedule************************************************************************************************ */
    
    public function Manage_Duty_Schedule()
    {
        
        $officers = $this->securityModel->getSecurityOfficers();
        $shifts = $this->securityModel->getShifts();
        $todaySchedule = $this->securityModel->getTodaySchedule();

        $data = [
            'officers' => $officers,
            'shifts' => $shifts,
            'todaySchedule' => $todaySchedule
        ];

      
        $this->view('security/Manage_Duty_Schedule', $data);
    }

    public function getOfficerDuties($officerId)
    {
        $duties = $this->securityModel->getOfficerDuties($officerId);

        header('Content-Type: application/json');
        echo json_encode($duties);
        exit;
    }

    public function addDuty()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'officer_id' => trim($_POST['officer_id']),
                'duty_date' => trim($_POST['duty_date']),
                'shift_id' => trim($_POST['shift_id']),
                'officer_id_err' => '',
                'duty_date_err' => '',
                'shift_id_err' => ''
            ];

            
            if (empty($data['officer_id'])) {
                $data['officer_id_err'] = 'Please select an officer';
            }

            if (empty($data['duty_date'])) {
                $data['duty_date_err'] = 'Please select a date';
            } elseif (strtotime($data['duty_date']) < strtotime(date('Y-m-d'))) {
                $data['duty_date_err'] = 'Cannot assign duties for past dates';
            }

            if (empty($data['shift_id'])) {
                $data['shift_id_err'] = 'Please select a shift';
            }

           
            if ($this->securityModel->isOfficerScheduled($data['officer_id'], $data['duty_date'])) {
                $data['duty_date_err'] = 'This officer already has a duty on this date';
            }

           
            if ($this->securityModel->getShiftCount($data['duty_date'], $data['shift_id']) >= 3) {
                $data['shift_id_err'] = 'This shift already has 3 officers assigned';
            }

         
            if (empty($data['officer_id_err']) && empty($data['duty_date_err']) && empty($data['shift_id_err'])) {
               
                if ($this->securityModel->addDuty($data)) {
                   
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Duty added successfully']);
                    exit;
                } else {
                  
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Something went wrong']);
                    exit;
                }
            } else {
             
                $errors = [];
                if (!empty($data['officer_id_err'])) $errors[] = $data['officer_id_err'];
                if (!empty($data['duty_date_err'])) $errors[] = $data['duty_date_err'];
                if (!empty($data['shift_id_err'])) $errors[] = $data['shift_id_err'];

                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
                exit;
            }
        } else {
           
            redirect('security');
        }
    }


    public function editShift()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $officer_id = isset($_POST['officer_id']) ? $_POST['officer_id'] : null;
            $duty_date = isset($_POST['duty_date']) ? $_POST['duty_date'] : null;
            $new_shift_id = isset($_POST['new_shift_id']) ? $_POST['new_shift_id'] : null;

            if (!$officer_id || !$duty_date || !$new_shift_id) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                exit;
            }

           
            if ($this->securityModel->isShiftFull($new_shift_id, $duty_date)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'This shift is already full']);
                exit;
            }

            if ($this->securityModel->UpdateShift($officer_id, $duty_date, $new_shift_id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Duty updated successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Something went wrong']);
            }
            exit;
        } else {
            redirect('security');
        }
    }

    public function deleteDuty()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $officer_id = isset($_POST['officer_id']) ? $_POST['officer_id'] : null;
            $duty_date = isset($_POST['duty_date']) ? $_POST['duty_date'] : null;

            if (!$officer_id || !$duty_date) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                exit;
            }

            if ($this->securityModel->DeleteDuty($officer_id, $duty_date)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Duty removed successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Something went wrong']);
            }
            exit;
        } else {
            redirect('security');
        }
    }


    public function getCalendarData($startDate, $endDate)
    {
        $schedule = $this->securityModel->getScheduleForPeriod($startDate, $endDate);

        header('Content-Type: application/json');
        echo json_encode($schedule);
        exit;
    }
}
