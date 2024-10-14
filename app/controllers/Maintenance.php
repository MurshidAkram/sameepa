<?php

class Maintenance extends Controller
{
   

    public function dashboard()
    {
        // Load the maintenance team dashboard view
        $this->view('maintenance/dashboard');
    }

    public function history()
    {
        // This will load the view to handle maintenance requests
        $this->view('maintenance/history');
    }

    public function report()
    {
        // This will load the view to update or manage duty schedules
        $this->view('maintenance/report');
    }
    public function request()
    {
        $this->view('maintenance/request');
    }
    public function shedule()
    {
        $this->view('maintenance/shedule');
    }
    public function update() {
        $this->view('maintenance/update');
    }
    
}
