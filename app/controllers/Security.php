<?php

class Security extends Controller
{
    
    private $securityModel;

    public function __construct()
    {
        $this->checkSecurityAuth();
       
        // Initialize the maintenance model
        $this->securityModel = $this->model('M_security');
        
    }

    private function checkSecurityAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 5) {
            // Redirect to unauthorized page
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }

//************************************************************************************************************************************************* */

    public function dashboard()
    {
        // Get any necessary data for the dashboard
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];

        // Load resident dashboard view with data
        $this->view('security/dashboard', $data);
    }

//********************************************************************************************************************************************** */

public function Manage_Visitor_Passes() {
    // Retrieve today's and historical visitor passes from the model
    $pass = $this->securityModel->getVisitorPasses();

    // Prepare the data to be passed to the view
    $data = [
        'todayPasses' => $pass['todayPasses'],  // Data for today's passes
        'historyPasses' => $pass['historyPasses'] // Data for historical passes
    ];

    // Load the view and pass the data to it
    $this->view('security/Manage_Visitor_Passes', $data);
}



public function Add_Visitor_Pass() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Collect form data
        $data = [
            'visitor_name' => trim($_POST['visitor_name']),
            'visitor_count' => trim($_POST['visitor_count']),
            'resident_name' => trim($_POST['resident_name']),
            'visit_date' => trim($_POST['visit_date']),
            'visit_time' => trim($_POST['visit_time']),
            'duration' => trim($_POST['duration']),
            'purpose' => trim($_POST['purpose'])
        ];

        // Add visitor pass to the database
        $newPassId = $this->securityModel->addVisitorPass($data);

        if ($newPassId) {
            // Success JSON Response
            echo json_encode([
                'success' => true,
                'id' => $newPassId, // The unique ID from the database
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
            // Failure JSON Response
            echo json_encode([
                'success' => false,
                'message' => 'Database error: Failed to insert visitor pass.'
            ]);
            exit();
        }
    }

    // If not a POST request, load the form view
    $this->view('security/Add_Visitor_Pass');
}




//********************************************************************************************************************************************** */

    public function Manage_Duty_Schedule()
    {
       // Load the view with the schedule data
        $this->view('security/Manage_Duty_Schedule');
    }


//********************************************************************************************************************************************** */

    public function Emergency_Contacts() {
        $contacts = $this->securityModel->getAllContacts();
        $data = ['contacts' => $contacts];
        $this->view('security/Emergency_Contacts', $data);
    }

// Add a new Contact

public function Add_Contact() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process form data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'name' => trim($_POST['name']),
            'phone' => trim($_POST['phone']),
          
        ];

        // Add to database
        if ($this->securityModel->addContact($data)) {
            header('Location: ' . URLROOT . 'security/Emergency_Contacts');
            exit();
        } else {
            die('Error adding contact');
        }

        if ($this->securityModel->addContact($data)) {
            echo json_encode([
                'success' => true,
                'id' => $newContactId, // Ensure this is a unique database ID
                'name' => $data['name'],
                'phone' => $data['phone']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Database error: Failed to insert contact.'
            ]);
        }
        
        
    }
}

    public function Edit_Contact($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Make sure to handle raw POST data when it's JSON
            $data = json_decode(file_get_contents("php://input"), true);  // Decode JSON to array
    
            // Sanitize and prepare the data
            $name = trim($data['name']);
            $phone = trim($data['phone']);
    
            $contactData = [
                'id' => $id,
                'name' => $name,
                'phone' => $phone
            ];
    
            // Call the model to update the contact
            if ($this->securityModel->updateContact($contactData)) {
                echo json_encode([
                    'success' => true,
                    'name' => $name,
                    'phone' => $phone
                ]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    
    // Delete a Contact
public function Delete_Contact($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        // Call model to delete member
        if ($this->securityModel->deleteContact($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
//********************************************************************************************************************************************** */

    public function Manage_Incident_Reports()
    {
        
        // Load the view with the incident reports data
        $this->view('security/Manage_Incident_Reports', [
       
        ]);
    }

//********************************************************************************************************************************************** */

// View page without loading data
public function residents_contact() {
    $this->view('security/Resident_Contacts');
}

// API endpoint to return JSON search results
public function search_residents() {
    if (isset($_GET['search_query'])) {
        $query = trim($_GET['search_query']);
        $results = $this->securityModel->searchResidentContacts($query);
        echo json_encode($results);
    } else {
        echo json_encode([]);
    }
}

}

?>
