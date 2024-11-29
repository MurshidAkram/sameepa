<?php

class Resident extends Controller
{
    private $residentModel;

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

    /*public function forums()
    {
        $this->view('resident/forums');
    }
        */

    public function maintenance()
    {
        $this->view('resident/maintenance');
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



    public function complaints()
    {
        $this->view('resident/complaints');
    }

    public function incident()
    {
        $this->view('resident/incident');
    }
}
