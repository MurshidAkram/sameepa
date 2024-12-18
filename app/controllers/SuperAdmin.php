<?php

class SuperAdmin extends Controller
{
    public function __construct()
    {
        // Initialize model if needed
        //$this->superAdminModel = $this->model('M_SuperAdmin');
    }

    public function dashboard()
    {
        // Load the Super Admin dashboard view
        $this->view('superadmin/dashboard');
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

    // Add more methods as needed
}
