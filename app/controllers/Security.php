<?php

class Security extends Controller
{
    // Dashboard view
    public function dashboard()
    {
        $this->view('security/dashboard');
    }

    public function Manage_Visitor_Passes()
    {
        $this->view('security/Manage_Visitor_Passes');
    }

    public function Resident_Contacts()
    {
        $this->view('security/Resident_Contacts');
    }

    public function Manage_Incident_Reports()
    {
        $this->view('security/Manage_Incident_Reports');
    }

    public function Emergency_Contacts()
    {
        $this->view('security/Emergency_Contacts');
    }
    public function Manage_Alerts()
    {
        $this->view('security/Manage_Alerts');
    }

    public function Duty_Schedule()
    {
        $this->view('security/Duty_Schedule');
    }

}
