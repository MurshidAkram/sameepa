<?php

class Security extends Controller
{
    // Dashboard view
    public function dashboard()
    {
        // Load the security dashboard view
        $this->view('security/dashboard');
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
