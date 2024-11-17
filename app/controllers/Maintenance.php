<?php

class Maintenance extends Controller
{
    private $maintenanceModel;

    public function __construct()
    {
        $this->checkMaintenanceAuth();

        // Initialize any resident-specific models if needed
        // $this->residentModel = $this->model('M_Resident');
    }

    private function checkMaintenanceAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 4) {
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
        $this->view('maintenance/dashboard', $data);
    }

    public function Inventory()
    {
        // This will load the view to handle maintenance requests
        $this->view('maintenance/Inventory');
    }

    public function Resident_Requests()
    {
        // This will load the view to update or manage duty schedules
        $this->view('maintenance/Resident_Requests');
    }
    public function Notifications()
    {
        $this->view('maintenance/Notifications');
    }
    public function Reports_Analytics()
    {
        $this->view('maintenance/Reports_Analytics');
    }
    public function Scheme_Maintenance()
    {
        $this->view('maintenance/Scheme_Maintenance');
    }
    public function Team_Scheduling()
    {
        $this->view('maintenance/Team_Scheduling');
    }
}
