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
}
