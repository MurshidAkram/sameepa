<?php

class SuperAdmin extends Controller
{
    private $superadminModel;

    public function __construct()
    {
        $this->checkSuperAdminAuth();

        // Initialize any resident-specific models if needed
        // $this->residentModel = $this->model('M_Resident');
    }

    private function checkSuperAdminAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 3) {
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
        $this->view('superadmin/dashboard', $data);
    }

    public function users()
    {
        // Load the Users management view
        $this->view('superadmin/users');
    }

    public function settings()
    {
        // Load the Settings view
        $this->view('superadmin/settings');
    }
    public function reports()
    {
        // Load the Settings view
        $this->view('superadmin/reports');
    }
    /*public function announcements()
    {
        // Load the Settings view
        $this->view('superadmin/announcements');
    }
        */



    // Add more methods as needed
}
