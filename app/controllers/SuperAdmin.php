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

    public function users() {
        $this->view('superadmin/users');
    }

    // public function index() {
    //     // Fetch all users from the model
    //     $users = $this->superAdminModel->getAllUsers();
    
    //     // Prepare data to pass to the view
    //     $data = [
    //         'users' => $users,
    //         'is_admin' => in_array($_SESSION['user_role_id'], [2, 3]) // Adjust roles as necessary
    //     ];
    
    //     // Load the view with the data
    //     $this->view('superadmin/users', $data);
    // }
    

    public function approveUserRegistration($userId) {
        if ($this->superAdminModel->approveUser($userId)) {
            flash('user_message', 'User registration approved successfully');
            redirect('superadmin/users');
        } else {
            flash('user_message', 'Something went wrong', 'alert alert-danger');
            redirect('superadmin/users');
        }
    }

    public function rejectUserRegistration($userId) {
        if ($this->superAdminModel->rejectUser($userId)) {
            flash('user_message', 'User registration rejected');
            redirect('superadmin/users');
        } else {
            flash('user_message', 'Something went wrong', 'alert alert-danger');
            redirect('superadmin/users');
        }
    }
    public function reports()
    {
        // Load the Settings view
        $this->view('superadmin/reports');
    }
    // public function announcements()
    // {
    //     // Load the Settings view
    //     $this->view('superadmin/announcements');
    // }
}
