<?php

class Security extends Controller
{
    private $securityModel;

    public function __construct()
    {
        // Initialize the model
        $this->securityModel = $this->model('M_security');
    }

    // Method to manage visitor passes
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
                // On success, redirect to the same page to refresh the visitor pass list
                header("Location: " . URLROOT . "/security/Manage_Visitor_Passes");
            } else {
                die("Something went wrong, please try again!");
            }
        }

        // Fetch today's active visitor passes and all pass history
        $activePasses = $this->securityModel->getTodayPasses();
        $passHistory = $this->securityModel->getAllPasses();
        
        // Load the view with the data
        $this->view('security/Manage_Visitor_Passes', [
            'activePasses' => $activePasses,
            'passHistory' => $passHistory
        ]);
    }

    // Method to handle resident contacts and search functionality
    public function Resident_Contacts()
    {
        // Handle search request if it's a GET request
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_query'])) {
            $searchQuery = trim($_GET['search_query']);
            
            // Fetch matching results based on the search query
            $residentDetails = $this->securityModel->getResidentDetailsByName($searchQuery);
            
            // Return the results as JSON to be used by JavaScript
            echo json_encode($residentDetails);
            return;
        }

        // Handle form submission for adding a new resident contact
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect data from the form submission
            $data = [
                'resident_name' => trim($_POST['resident_name']),
                'resident_address' => trim($_POST['resident_address']),
                'resident_phone' => trim($_POST['resident_phone']),
                'fixed_line' => trim($_POST['fixed_line']),
                'resident_email' => trim($_POST['resident_email'])
            ];

            // Call the model to add a new resident contact
            if ($this->securityModel->addResidentContact($data)) {
                // On success, redirect to the same page to refresh the resident contacts list
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
