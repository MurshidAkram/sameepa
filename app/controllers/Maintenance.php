<?php

class Maintenance extends Controller
{
    public function __construct()
    {
        // You can load models here if needed in the future.
    }

    public function dashboard()
    {
        // Load the maintenance team dashboard view
        $this->view('maintenance/dashboard');
    }

    public function requests()
    {
        // This will load the view to handle maintenance requests
        $this->view('maintenance/requests');
    }

    public function schedules()
    {
        // This will load the view to update or manage duty schedules
        $this->view('maintenance/schedules');
    }
}
