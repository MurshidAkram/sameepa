<?php

class Admin extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->checkAdminAuth();

        // Initialize any resident-specific models if needed
        // $this->residentModel = $this->model('M_Resident');
    }

    private function checkAdminAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 2) {
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
        $this->view('admin/dashboard', $data);
    }

    public function facilities()
    {
        // Load admin dashboard view
        $this->view('admin/facilities');
    }

    

    /*public function announcements()
    {
        // Load admin dashboard view
        $this->view('admin/announcements');
    }*/

    public function payments()
    {
        // Load admin dashboard view
        $this->view('admin/payments');
    }

    public function complaints()
    {
        // Load admin dashboard view
        $this->view('admin/complaints');
    }

    public function forums()
    {
        // Load admin dashboard view
        $this->view('admin/forums');
    }


    public function users()
    {
        // Load admin dashboard view
        $this->view('admin/users');
    }
}
