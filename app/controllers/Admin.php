<?php

class Admin extends Controller
{
    public function dashboard()
    {
        // Load admin dashboard view
        $this->view('admin/dashboard');
    }

    public function facilities()
    {
        // Load admin dashboard view
        $this->view('admin/facilities');
    }

    public function events()
    {
        // Load admin dashboard view
        $this->view('admin/events');
    }

    public function announcements()
    {
        // Load admin dashboard view
        $this->view('admin/announcements');
    }

    public function payments()
    {
        // Load admin dashboard view
        $this->view('admin/payments');
    }

    public function complaints()
    {
        // Load admin dashboard view
        $this->view('admin/complaints');
    }

    public function forums()
    {
        // Load admin dashboard view
        $this->view('admin/forums');
    }


    public function users()
    {
        // Load admin dashboard view
        $this->view('admin/users');
    }
}
