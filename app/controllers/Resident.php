<?php

class Resident extends Controller
{
    public function dashboard()
    {
        // Load resident dashboard view
        $this->view('resident/dashboard');
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
}
