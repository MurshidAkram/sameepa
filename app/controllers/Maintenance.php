<?php

class Maintenance extends Controller
{
   

    public function dashboard()
    {
        // Load the maintenance team dashboard view
        $this->view('maintenance/dashboard');
    }
    public function Inventory()
    {
        $this->view('maintenance/Inventory');
    }
    public function Notifications()
    {
        $this->view('maintenance/Notifications');
    }
    public function Reports_Analytics()
    {
        $this->view('maintenance/Reports_Analytics');
    }
    public function Resident_Requests()
    {
        $this->view('maintenance/Resident_Requests');
    }
    public function Scheme_Maintenance() {
        $this->view('maintenance/Scheme_Maintenance');
    }
    public function Team_Scheduling() {
        $this->view('maintenance/Team_Scheduling');
    }
    
}
