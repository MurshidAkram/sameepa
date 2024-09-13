<?php

class Users extends Controller
{
    public function login()
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'errors' => []
            ];

            // Validate form input
            if (empty($data['email'])) {
                $data['errors'][] = 'Email is required';
            }
            if (empty($data['password'])) {
                $data['errors'][] = 'Password is required';
            }

            // Simulate successful login for now
            if (empty($data['errors'])) {
                // Here you can simulate a successful login
                // For example, you can just redirect to a different page
                header('Location: ' . URLROOT . '/index');
                exit();
            }

            // Load the view with errors
            $this->view('users/login', $data);
        } else {
            // Load the login form view
            $this->view('users/login');
        }
    }

    public function signup()
    {
        // Initialize data array with default empty values
        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'errors' => []
        ];

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $data = [
                'username' => isset($_POST['username']) ? trim($_POST['username']) : '',
                'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
                'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
                'confirm_password' => isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '',
                'errors' => []
            ];

            // Validate form input
            if (empty($data['username'])) {
                $data['errors'][] = 'Username is required';
            }
            if (empty($data['email'])) {
                $data['errors'][] = 'Email is required';
            }
            if (empty($data['password'])) {
                $data['errors'][] = 'Password is required';
            }
            if ($data['password'] !== $data['confirm_password']) {
                $data['errors'][] = 'Passwords do not match';
            }

            // Simulate successful registration for now
            if (empty($data['errors'])) {
                // Here you can simulate a successful registration
                // For example, you can just redirect to a different page
                header('Location: ' . URLROOT . '/users/login');
                exit();
            }
        }

        // Load the view with errors
        $this->view('users/signup', $data);
    }
}
