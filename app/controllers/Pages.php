<?php

class Pages extends controller
{
    public function __construct()
    {
        //$this->pagesModel = $this->model('M_Pages');
    }

    public function index()
    {
        // Load the landing page or default view
        $this->view('index');
    }

    public function landing()
    {
        $this->view('landing'); // Load the landing page view
    }

    public function about()
    {
        // Load the about us view
        $this->view('v_about');
    }

    public function contact()
    {
        // Load the contact us view
        $this->view('v_contact');
    }

    public function unauthorized()
    {
        // Load the contact us view
        $this->view('unauthorized');
    }
}
