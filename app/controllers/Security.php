<?php

class Security extends Controller
{
    private $securityModel;

    public function __construct()
    {
        // Initialize the model
        $this->securityModel = $this->model('M_security');
    }

    // Dashboard method that fetches data for the dashboard view
    public function Dashboard()
    {
        // Fetch necessary data for the dashboard
       

        // Load the dashboard view with the fetched data
        $this->view('security/dashboard');
    }

    // Manage Visitor Passes method
    public function Manage_Visitor_Passes()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect data from the form submission
            $data = [
                'visitor_name' => trim($_POST['visitorName']),
                'visitor_count' => trim($_POST['visitorCount']),
                'visit_date' => trim($_POST['visitDate']),
                'visit_time' => trim($_POST['visitTime']),
                'duration' => trim($_POST['duration']),
                'purpose' => trim($_POST['purpose']),
                'resident_name' => trim($_POST['residentName']),
            ];

            // Call the model to create the visitor pass
            if ($this->securityModel->createVisitorPass($data)) {
                // On success, refresh the visitor pass list
                header("Location: " . URLROOT . "/security/Manage_Visitor_Passes");
            } else {
                die("Something went wrong, please try again!");
            }
        }

        // Fetch data for today’s active passes and pass history
        $activePasses = $this->securityModel->getTodayPasses();
        $passHistory = $this->securityModel->getAllPasses();
        
        // Load the view with the fetched data
        $this->view('security/Manage_Visitor_Passes', [
            'activePasses' => $activePasses,
            'passHistory' => $passHistory
        ]);
    }

    // Manage Duty Schedule
    public function Manage_Duty_Schedule()
    {
        // Logic to manage duty schedules (e.g., fetch, update, delete duty schedule)
       
        
        // Load the view with the schedule data
        $this->view('security/Manage_Duty_Schedule');
    }

    // Manage Emergency Contacts
    public function Emergency_Contacts()
    {
        // Logic to manage emergency contacts (e.g., view, add, edit, delete contacts)
       
        
        // Load the view with the contacts data
        $this->view('security/Emergency_Contacts');
    }

    // Manage Alerts (e.g., view and manage security alerts)
    public function Manage_Alerts()
    {
        // Fetch alert data
      
        
        // Load the view with alert data
        $this->view('security/Manage_Alerts', [
           
        ]);
    }

    // Manage Incident Reports
    public function Manage_Incident_Reports()
    {
        // Logic to manage incident reports (e.g., view, update, resolve incidents)
       
        
        // Load the view with the incident reports data
        $this->view('security/Manage_Incident_Reports', [
       
        ]);
    }

    // Resident Contacts Management (including searching functionality)
    public function Resident_Contacts()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_query'])) {
            $searchQuery = trim($_GET['search_query']);
            
            // Fetch matching resident details based on the search query
            $residentDetails = $this->securityModel->getResidentDetailsByName($searchQuery);
            
            // Return the search results as JSON
            echo json_encode($residentDetails);
            return;
        }

        // Handle form submission for adding a new resident contact
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'resident_name' => trim($_POST['resident_name']),
                'resident_address' => trim($_POST['resident_address']),
                'resident_phone' => trim($_POST['resident_phone']),
                'fixed_line' => trim($_POST['fixed_line']),
                'resident_email' => trim($_POST['resident_email'])
            ];

            // Add new resident contact
            if ($this->securityModel->addResidentContact($data)) {
                // On success, redirect to the same page to refresh the contacts list
                header("Location: " . URLROOT . "/security/Resident_Contacts");
            } else {
                die("Something went wrong, please try again.");
            }
        }

        // Load the view for managing resident contacts
        $this->view('security/Resident_Contacts');
    }
}

?>
