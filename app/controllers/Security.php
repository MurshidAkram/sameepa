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
    public function Manage_Visitor_Passes()
    {
        // Load the view with the schedule data
        $this->view('security/Manage_Visitor_Passes');
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

    public function Resident_Contacts()
    {
        // Load the view for managing resident contacts
        $this->view('security/Resident_Contacts');
    }

}

?>
