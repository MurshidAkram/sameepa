<?php

class External extends Controller
{
    private $externalModel;

    public function __construct()
    {
        $this->checkExternalAuth();

        // Initialize any resident-specific models if needed
        // $this->residentModel = $this->model('M_Resident');
    }

    private function checkExternalAuth()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        // Check if user is a resident (role_id = 1)
        if ($_SESSION['user_role_id'] != 6) {
            // Redirect to unauthorized page
            header('Location: ' . URLROOT . '/pages/unauthorized');
            exit();
        }
    }

    public function dashboard()
    {
        // Get any necessary data for the dashboard
        $data = [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];

        // Load resident dashboard view with data
        $this->view('external/dashboard', $data);
    }

    public function requests()
    {
        // Load the service requests view (you might want to add more logic here later)
        $this->view('external/requests');
    }
    public function profile()
    {
        // Load the service requests view (you might want to add more logic here later)
        $this->view('external/profile');
    }
}
