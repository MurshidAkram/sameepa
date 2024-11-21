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

    public function history()
    {
        // This will load the view to handle maintenance requests
        $this->view('maintenance/history');
    }

    public function report()
    {
        // This will load the view to update or manage duty schedules
        $this->view('maintenance/report');
    }
    public function request()
    {
        $this->view('maintenance/request');
    }
    public function shedule()
    {
        $this->view('maintenance/shedule');
    }
    public function update()
    {
        $this->view('maintenance/update');
    }
}
