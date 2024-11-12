<?php

class Users extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
    }

    public function login()
    {
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

            // Check if the user exists and the password is correct
            if (empty($data['errors'])) {
                $user = $this->userModel->findUserByEmail($data['email']);
                if ($user) {
                    if (password_verify($data['password'], $user['password'])) {
                        // Create a session for the logged-in user
                        $this->createUserSession($user);
                        // Redirect to the appropriate dashboard based on the user's role
                        $this->redirectToDashboard($user['role_id']);
                    } else {
                        $data['errors'][] = 'Invalid email or password';
                    }
                } else {
                    $data['errors'][] = 'Invalid email or password';
                }
            }

            // Load the login view with errors
            $this->view('users/login', $data);
        } else {
            // Load the login form view
            $this->view('users/login');
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role_id'] = $user['role_id'];
        $_SESSION['name'] = $user['name'];

        // Retrieve the user's role name
        $roleName = $this->userModel->getRoleName($user['role_id']);
        $_SESSION['user_role'] = $roleName;
    }

    private function redirectToDashboard($roleId)
    {
        switch ($roleId) {
            case 1: // Resident
                header('Location: ' . URLROOT . '/resident/dashboard');
                break;
            case 2: // Admin
                header('Location: ' . URLROOT . '/admin/dashboard');
                break;
            case 3: // SuperAdmin
                header('Location: ' . URLROOT . '/superadmin/dashboard');
                break;
            case 4: // Maintenance
                header('Location: ' . URLROOT . '/maintenance/dashboard');
                break;
            case 5: // Security
                header('Location: ' . URLROOT . '/security/dashboard');
                break;
            case 6: // External Service Provider
                header('Location: ' . URLROOT . '/external/dashboard');
                break;
            default:
                header('Location: ' . URLROOT);
                break;
        }
        exit();
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role_id' => trim($_POST['role']),
                'address' => trim($_POST['address']),
                'phonenumber' => trim($_POST['phonenumber']),
                'errors' => []
            ];

            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role_id' => $data['role_id'],
                'address' => $data['address'],
                'phonenumber' => $data['phonenumber']
            ];

            // Validate form input based on the selected role
            $this->validateSignupForm($data, $userData);

            if (empty($data['errors'])) {
                $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
                if ($this->userModel->registerUser($userData)) {
                    // Redirect to the login page
                    header('Location: ' . URLROOT . '/users/login');
                    exit();
                } else {
                    $data['errors'][] = 'Something went wrong. Please try again.';
                }
            }
            // Load the view with errors
            $this->view('users/signup', $data);
        } else {
            $this->view('users/signup');
        }
    }

    private function validateSignupForm(&$data, &$userData)
    {
        // Validate form input based on the selected role
        switch ($data['role_id']) {
            case '1': // Resident
                $this->validateResidentFields($data, $userData);
                break;
            default: // Other roles
                $this->validateGenericFields($data, $userData);
                break;
        }
    }

    private function validateResidentFields(&$data, &$userData)
    {
        if (empty($data['address'])) {
            $data['errors'][] = 'Address is required';
        }
        if (empty($data['phonenumber'])) {
            $data['errors'][] = 'Phone number is required';
        }
    }

    private function validateGenericFields(&$data, &$userData)
    {
        if (empty($data['name'])) {
            $data['errors'][] = 'Name is required';
        }
        if (empty($data['email'])) {
            $data['errors'][] = 'Email is required';
        } else {
            if ($this->userModel->findUserByEmail($data['email'])) {
                $data['errors'][] = 'Email already exists';
            }
        }
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['errors'][] = 'Please enter a valid email address';
        }
        if (empty($data['password'])) {
            $data['errors'][] = 'Password is required';
        } elseif (empty($data['confirm_password'])) {
            $data['errors'][] = 'Please confirm your password';
        } elseif ($data['password'] !== $data['confirm_password']) {
            $data['errors'][] = 'Passwords do not match';
        }
        if (!empty($data['password']) && strlen($data['password']) < 6) {
            $data['errors'][] = 'Password must be at least 6 characters long';
        }
        if (strlen($data['name']) > 50) {
            $data['errors'][] = 'Name cannot exceed 50 characters';
        }
        if (strlen($data['address']) > 255) {
            $data['errors'][] = 'Address cannot exceed 255 characters';
        }
    }

    // Users.php
public function logout()
{
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header('Location: ' . URLROOT . '/users/login');
    exit();
}
}