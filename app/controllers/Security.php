<?php

class Security extends Controller
{
    private $securityModel;

    public function __construct()
    {
        $this->checkSecurityAuth();

        
    }

    private function checkSecurityAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 5) {
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
        $this->view('security/dashboard', $data);
    }

    // Manage Visitor Passes view
    public function view_visitor_pass()
    {
        // Load the manage visitor passes view
        $this->view('security/view_visitor_pass');
    }

    // Suspicious Activities view
    public function verify_visitor_details()
    {
        // Load the suspicious activities view
        $this->view('security/verify_visitor_details');
    }

    // Duty Schedules view
    public function log_in_visitor_times()
    {
        // Load the duty schedules view
        $this->view('security/log_in_visitor_times');
    }
    public function update_duty_schedule()
    {
        // Load the duty schedules view
        $this->view('security/update_duty_schedule');
    }
    public function manage_user_incident_report()
    {
        // Load the duty schedules view
        $this->view('security/manage_user_incident_report');
    }
}
