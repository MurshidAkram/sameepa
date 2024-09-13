<?php

class External extends Controller
{
    public function __construct()
    {
        // Initialize any models or dependencies here if needed
    }

    public function dashboard()
    {
        // Load the dashboard view for external service providers
        $this->view('external/dashboard');
    }

    public function requests()
    {
        // Load the service requests view (you might want to add more logic here later)
        $this->view('external/requests');
    }
}
