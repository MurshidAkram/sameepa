<?php

class Resident extends Controller
{
    public function dashboard()
    {
        // Load resident dashboard view
        $this->view('resident/dashboard');
    }

    public function announcements()
    {
        // Load resident dashboard view
        $this->view('resident/announcements');
    }

    public function events()
    {
        // Load resident dashboard view
        $this->view('resident/events');
    }

    public function visitor_passes()
    {
        $this->view('resident/visitor_passes');
    }

    public function facilities()
    {
        $this->view('resident/facilities');
    }

    public function groups()
    {
        $this->view('resident/groups');
    }

    public function exchange()
    {
        $this->view('resident/exchange');
    }

    public function forums()
    {
        $this->view('resident/forums');
    }

    public function maintenance()
    {
        $this->view('resident/maintenance');
    }

    public function external_services()
    {
        $this->view('resident/external_services');
    }

    public function payments()
    {
        $this->view('resident/payments');
    }

    public function reports()
    {
        $this->view('resident/reports');
    }



    public function complaints()
    {
        $this->view('resident/complaints');
    }
}
