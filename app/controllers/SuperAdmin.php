<?php

class SuperAdmin extends Controller {
    private $superAdminModel;

    public function __construct() {
        // Initialize model if needed
        $this->superAdminModel = $this->model('M_MUser');
    }

    public function dashboard() {
        $this->view('superadmin/dashboard');
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
