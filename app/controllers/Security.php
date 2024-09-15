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
    public function manageVisitorPasses()
    {
        // Load the manage visitor passes view
        $this->view('security/manage_visitor_passes');
    }

    // Suspicious Activities view
    public function suspiciousActivities()
    {
        // Load the suspicious activities view
        $this->view('security/suspicious_activities');
    }

    // Duty Schedules view
    public function dutySchedules()
    {
        // Load the duty schedules view
        $this->view('security/duty_schedules');
    }
}
