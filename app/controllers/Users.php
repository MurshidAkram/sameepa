<?php

class Users extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        $this->redirectToDashboard($_SESSION['user_role_id']);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'errors' => []
            ];

            if (empty($data['email']) || empty($data['password'])) {
                $data['errors'][] = 'Please fill in all fields';
            }

            if (empty($data['errors'])) {
                $user = $this->userModel->findUserByEmail($data['email']);

                if ($user) {
                    if (!$user['is_active'] && $user['role_id'] != 3) {
                        $data['errors'][] = 'Your account is pending activation. Please wait for admin approval.';
                    } else if (password_verify($data['password'], $user['password'])) {
                        $this->createUserSession($user);
                        $this->redirectToDashboard($user['role_id']);
                    } else {
                        $data['errors'][] = 'Invalid credentials';
                    }
                } else {
                    $data['errors'][] = 'Invalid credentials';
                }
            }

            $this->view('users/login', $data);
        } else {
            $this->view('users/login');
        }
    }



    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role_id'] = $user['role_id'];
        $_SESSION['name'] = $user['name'];

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
                'role_id' => 1,
                'address' => trim($_POST['address']),
                'phonenumber' => trim($_POST['phonenumber']),
                'errors' => []
            ];
            if (!isset($_FILES['verification_document']) || $_FILES['verification_document']['error'] !== UPLOAD_ERR_OK) {
                $data['errors'][] = 'Verification document is required';
            }

            $file = $_FILES['verification_document'];
            if ($file['type'] != 'application/pdf') {
                $data['errors'][] = 'Only PDF files are allowed';
            }

            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role_id' => $data['role_id'],
                'address' => $data['address'],
                'phonenumber' => $data['phonenumber']
            ];

            $this->validateSignupForm($data, $userData);

            if (empty($data['errors'])) {
                $fileContent = file_get_contents($file['tmp_name']);

                $userData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                    'role_id' => $data['role_id'],
                    'address' => $data['address'],
                    'phonenumber' => $data['phonenumber'],
                    'verification_document' => $fileContent,
                    'verification_filename' => $file['name']
                ];
                if ($this->userModel->registerUser($userData)) {
                    if ($data['role_id'] != 3) {
                        flash('signup_message', 'Your account has been created. Please wait for super admin activation.', 'alert alert-info');
                    }
                    header('Location: ' . URLROOT . '/users/login');
                    exit();
                } else {
                    $data['errors'][] = 'Something went wrong. Please try again.';
                }
            }
            $this->view('users/signup', $data);
        } else {
            $this->view('users/signup');
        }
    }

    private function validateSignupForm(&$data, &$userData)
    {
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
        } else {
            if ($data['address'] < 1 || $data['address'] > 100) {
                $data['errors'][] = 'Please pick your address unit between 1 and 100!';
            }
        }
        if (empty($data['phonenumber'])) {
            $data['errors'][] = 'Phone number is required';
        } else {
            if ($this->userModel->findUserByPhone($data['phonenumber'])) {
                $data['errors'][] = 'Phone number already exists';
            }
            if (!preg_match('/^\d{10}$/', $data['phonenumber'])) {
                $data['errors'][] = 'Phone number must be exactly 10 digits';
            }
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
        if (empty($data['role_id'])) {
            $data['errors'][] = 'Please select a user role';
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

    private function validateAdminSignupForm(&$data, &$userData)
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
        if (empty($data['role_id'])) {
            $data['errors'][] = 'Please select a user role';
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
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        session_destroy();

        header('Location: ' . URLROOT . '/users/login');
        exit();
    }

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        $userData = $this->userModel->getUserById($_SESSION['user_id']);

        $additionalData = [];
        if ($_SESSION['user_role_id'] == 1) { // Resident
            $additionalData = $this->userModel->getResidentByUserId($_SESSION['user_id']);
        }

        $data = array_merge((array)$userData, (array)$additionalData);


        $this->view('users/profile', $data);
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('users/profile');
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'new_password' => trim($_POST['new_password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'address' => isset($_POST['address']) ? trim($_POST['address']) : null,
            'phonenumber' => isset($_POST['phonenumber']) ? trim($_POST['phonenumber']) : null,
            'errors' => []
        ];

        // Validation
        if (empty($data['name'])) {
            $data['errors'][] = 'Name is required';
        }
        if (!empty($data['new_password']) && $data['new_password'] !== $data['confirm_password']) {
            $data['errors'][] = 'Passwords do not match';
        }
        // Validation
        if (empty($data['name'])) {
            $data['errors'][] = 'Name is required';
        }
        if (!empty($data['new_password']) && $data['new_password'] !== $data['confirm_password']) {
            $data['errors'][] = 'Passwords do not match';
        }

        if (empty($data['errors'])) {
            // Update user data
            if ($this->userModel->updateUser($data)) {
            } else {
            }
        } else {
        }

        redirect('users/profile');
    }

    public function updateProfilePicture()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('users/profile');
        }

        if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
            redirect('users/profile');
        }

        $file = $_FILES['profile_picture'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($file['type'], $allowedTypes)) {
            redirect('users/profile');
        }

        // Read file content
        $imageData = file_get_contents($file['tmp_name']);

        if ($this->userModel->updateProfilePicture($_SESSION['user_id'], $imageData)) {
        } else {
        }

        redirect('users/profile');
    }

    public function deleteAccount()
    {
        if ($this->userModel->deleteUser($_SESSION['user_id'])) {
            session_destroy();
            redirect('users/login');
        } else {
            redirect('users/profile');
        }
    }



    public function manageUsers()
    {
        if (!isset($_SESSION['user_role_id']) || $_SESSION['user_role_id'] != 3) {
            header('Location: ' . URLROOT);
            exit();
        }

        $data = [
            'pending_users' => $this->userModel->getPendingUsers(),
            'residents' => $this->userModel->getUsersByRole(1),
            'admins' => $this->userModel->getUsersByRole(2),
            'security' => $this->userModel->getUsersByRole(5),
            'maintenance' => $this->userModel->getUsersByRole(4),
            'external' => $this->userModel->getUsersByRole(6)
        ];

        $this->view('users/manageUsers', $data);
    }

    public function activateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_SESSION['user_role_id']) || $_SESSION['user_role_id'] != 3) {
            header('Location: ' . URLROOT);
            exit();
        }

        $userId = $_POST['user_id'];
        if ($this->userModel->activateUser($userId)) {
            header('Location: ' . URLROOT . '/users/manageUsers?success=activated');
        } else {
            header('Location: ' . URLROOT . '/users/manageUsers?error=activation_failed');
        }
        exit();
    }

    public function deactivateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_SESSION['user_role_id']) || $_SESSION['user_role_id'] != 3) {
            header('Location: ' . URLROOT);
            exit();
        }

        $userId = $_POST['user_id'];
        if ($this->userModel->deactivateUser($userId)) {
            header('Location: ' . URLROOT . '/users/manageUsers?success=deactivated');
        } else {
            header('Location: ' . URLROOT . '/users/manageUsers?error=deactivation_failed');
        }
        exit();
    }

    public function getUserDetails($userId)
    {
        $user = $this->userModel->getUserById($userId);
        $verificationDoc = $this->userModel->getUserVerificationDocument($userId);
        $users = $this->userModel->getResidentAddressAndPhone($userId);

        $response = [
            'name' => $user['name'] ?? '',
            'email' => $user['email'] ?? '',
            'address' => $users['address'] ?? '',
            'phonenumber' => $users['phonenumber'] ?? '',
            'verification_filename' => $verificationDoc['role_verification_filename'] ?? null,
            'role_verification_document' => null
        ];

        if (!empty($verificationDoc['role_verification_document'])) {
            $response['role_verification_document'] = base64_encode($verificationDoc['role_verification_document']);
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    public function rejectUser()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_SESSION['user_role_id']) || $_SESSION['user_role_id'] != 3) {
            header('Location: ' . URLROOT);
            exit();
        }
        $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
        if ($userId && $this->userModel->deletePendingUser($userId)) {
            header('Location: ' . URLROOT . '/users/manageUsers?success=rejected');
        } else {
            header('Location: ' . URLROOT . '/users/manageUsers?error=rejection_failed');
        }
        exit();
    }


    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role_id' => trim($_POST['role']),
                'errors' => []
            ];
            $this->validateAdminSignupForm($data, $userData);
            if (empty($data['errors'])) {
                $userData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT), // Hash the password
                    'role_id' => $data['role_id']
                ];
                if ($this->userModel->registerUser($userData)) {
                    flash('user_created', 'User created successfully!');
                    redirect('users/manageUsers');
                    return;
                } else {
                    $data['errors'][] = 'Something went wrong. Please try again.';
                }
            }
            $this->view('users/createUser', $data);
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'role_id' => '',
                'errors' => []
            ];
            $this->view('users/createUser', $data);
        }
    }

    public function deleteActivatedUser()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_SESSION['user_role_id']) || $_SESSION['user_role_id'] != 3) {
            header('Location: ' . URLROOT);
            exit();
        }

        $userId = $_POST['user_id'];
        if ($this->userModel->deleteActivatedUser($userId)) {
            header('Location: ' . URLROOT . '/users/manageUsers?success=user_deleted');
        } else {
            header('Location: ' . URLROOT . '/users/manageUsers?error=deletion_failed');
        }
        exit();
    }
    public function updateAddress()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $data['user_id'];
        $newAddress = $data['address'];

        if (empty($newAddress)) {
            echo json_encode(['success' => false, 'message' => 'Address cannot be empty']);
            return;
        }

        if ($this->userModel->updateAddress($userId, $newAddress)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update address']);
        }
    }
    public function forgotpassword()
    {
        $data = [
            'errors' => [],
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            if (empty($email)) {
                $data['errors'][] = 'Please enter your email address';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['errors'][] = 'Please enter a valid email address';
            } else {
                $result = $this->userModel->createPasswordResetToken($email);

                if ($result) {
                    if (file_exists(APPROOT . '/vendor/autoload.php')) {
                        require_once APPROOT . '/vendor/autoload.php';
                    } else {
                        require_once dirname(__DIR__) . '/libraries/PHPMailer/src/Exception.php';
                        require_once dirname(__DIR__) . '/libraries/PHPMailer/src/PHPMailer.php';
                        require_once dirname(__DIR__) . '/libraries/PHPMailer/src/SMTP.php';
                    }

                    require_once APPROOT . '/helpers/Email.php';
                    $emailSent = Email::sendPasswordResetEmail($result['user']['email'], $result['user']['name'], $result['token']);

                    if ($emailSent) {
                        $data['success'] = 'A password reset link has been sent to your email address';
                    } else {
                        $data['errors'][] = 'Failed to send the password reset email. Please try again later.';
                    }
                } else {
                    // Don't reveal that the email doesn't exist
                    $data['success'] = 'If your email is registered, a password reset link will be sent to your email address';
                }
            }
        }

        $this->view('users/forgotpassword', $data);
    }

    public function resetpassword($token = null)
    {
        error_log("Reset password function accessed. Token: " . $token);
        if (empty($token) && isset($_POST['token'])) {
            $token = $_POST['token'];
            error_log("Token found in POST data: " . $token);
        }

        if (empty($token)) {
            error_log("No token found, redirecting to forgot password.");
            redirect('users/forgotpassword');
        }

        $tokenData = $this->userModel->verifyPasswordResetToken($token);
        error_log("Token verification result for token " . $token . ": " . ($tokenData ? "Success" : "Failure"));

        $data = [
            'token' => $token,
            'errors' => []
        ];

        if (!$tokenData) {
            $data['errors'][] = 'Invalid or expired token. Please request a new password reset link.';
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $tokenData) {
            $newPassword = trim($_POST['new_password']);
            $confirmPassword = trim($_POST['confirm_password']);

            if (empty($newPassword) || empty($confirmPassword)) {
                $data['errors'][] = 'Please enter and confirm your new password';
            } elseif ($newPassword !== $confirmPassword) {
                $data['errors'][] = 'Passwords do not match';
            } elseif (strlen($newPassword) < 6) {
                $data['errors'][] = 'Password must be at least 6 characters';
            }

            if (empty($data['errors'])) {
                if ($this->userModel->resetPassword($tokenData['user_id'], $newPassword)) {
                    flash('login_message', 'Your password has been reset. You can now log in with your new password.');
                    redirect('users/login');
                } else {
                    $data['errors'][] = 'Failed to reset password. Please try again.';
                }
            }
        }

        $this->view('users/resetpassword', $data);
    }

    public function getResidentAddress($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $user = $this->userModel->getUserById($id);

            if ($user) {
                $userDetails = $this->userModel->getResidentAddressAndPhone($id);

                if ($userDetails) {
                    echo json_encode([
                        'success' => true,
                        'address' => $userDetails['address']
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Address not found'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }
        }
    }
}
