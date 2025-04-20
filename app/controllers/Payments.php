<?php
class Payments extends Controller {
    private $paymentModel;
    private $userModel;
    
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        
        $this->paymentModel = $this->model('M_Payments');
        $this->userModel = $this->model('M_Users');
        
        // Load Stripe PHP SDK
        require_once APPROOT . '/../vendor/autoload.php';
        
        // Set Stripe API keys
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    }
    
    public function index() {
        $payments = $this->paymentModel->getPaymentsByUserId($_SESSION['user_id']);
        
        $data = [
            'payments' => $payments
        ];
        
        $this->view('payments/index', $data);
    }
    
    // Admin dashboard method
    public function admin_dashboard($page = 1) {
        // Check if user is admin or superadmin
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        $perPage = 10; // Number of payments per page
        $offset = ($page - 1) * $perPage;
        
        // Get paginated payments with user information
        $payments = $this->paymentModel->getAllPaymentsPaginated($offset, $perPage);
        $totalPayments = $this->paymentModel->getTotalPaymentsCount();
        $totalPages = ceil($totalPayments / $perPage);
        
        // Get statistics for dashboard
        $monthlyData = $this->paymentModel->getMonthlyPaymentData();
        
        // Get new statistics
        $mostActiveDay = $this->paymentModel->getMostActiveDayThisMonth();
        $paymentsThisMonth = $this->paymentModel->getPaymentCountThisMonth();
        $totalAmountThisMonth = $this->paymentModel->getTotalAmountThisMonth();
        $recentActivity = $this->paymentModel->getRecentPaymentActivity();
        
        $data = [
            'payments' => $payments,
            'monthly_data' => $monthlyData,
            'most_active_day' => $mostActiveDay,
            'payments_this_month' => $paymentsThisMonth,
            'total_amount_this_month' => $totalAmountThisMonth,
            'recent_activity' => $recentActivity,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages
            ]
        ];
        
        $this->view('payments/admin_dashboard', $data);
    }
        public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'home_address' => trim($_POST['home_address']),
                'amount' => trim($_POST['amount']),
                'description' => trim($_POST['description']),
                'home_address_err' => '',
                'amount_err' => '',
                'description_err' => ''
            ];

            if (($data['home_address'])== 'No address found.') {
                $data['home_address_err'] = ' ';
            }
            
            // Validate amount
            if (empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
                $data['amount_err'] = 'Please enter a valid amount';
            }
            
            // Validate description
            if (empty($data['description'])) {
                $data['description_err'] = 'Please enter a description';
            }
            
            // Make sure no errors
            if (empty($data['home_address_err']) && empty($data['amount_err']) && empty($data['description_err'])) {
                try {
                    // Create a PaymentIntent with the order amount and currency
                    $paymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $data['amount'] * 100, // Amount in cents
                        'currency' => 'usd',
                        'description' => $data['description'],
                        'metadata' => [
                            'user_id' => $_SESSION['user_id'],
                            'home_address' => $data['home_address']
                        ]
                    ]);
                    
                    $data['client_secret'] = $paymentIntent->client_secret;
                    
                    $this->view('payments/checkout', $data);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $data['error'] = $e->getMessage();
                    $this->view('payments/checkout_form', $data);
                }
            } else {
                // Load view with errors
                $this->view('payments/checkout_form', $data);
            }
        } else {
            $this->checkout_form();
        }
    }

    public function checkout_form()
    {
        // Initialize data
        $data = [
            'home_address' => '',
            'home_address_err' => '',
            'amount' => '',
            'amount_err' => '',
            'description' => '',
            'description_err' => ''
        ];
        
        // Get the resident's address from the database
        $userModel = $this->model('M_Users');
        $resident = $userModel->getResidentIDByUserId($_SESSION['user_id']);
        
        if ($resident && isset($resident['address']) && !empty($resident['address'])) {
            $data['home_address'] = $resident['address'];
        } else {
            $data['home_address'] = '';
        }
        
        $this->view('payments/checkout_form', $data);
    }
    
    public function success() {
        if (isset($_GET['payment_intent'])) {
            $paymentIntentId = $_GET['payment_intent'];
            
            try {
                $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
                
                if ($paymentIntent->status === 'succeeded') {
                    // Record payment in database
                    $paymentData = [
                        'user_id' => $_SESSION['user_id'],
                        'home_address' => $paymentIntent->metadata->home_address,
                        'amount' => $paymentIntent->amount / 100, // Convert from cents
                        'description' => $paymentIntent->description,
                        'transaction_id' => $paymentIntent->id,
                        'status' => 'completed'
                    ];
                    
                    if ($this->paymentModel->addPayment($paymentData)) {
                        flash('payment_success', 'Payment processed successfully');
                        redirect('payments');
                    } else {
                        flash('payment_error', 'Something went wrong recording your payment', 'alert alert-danger');
                        redirect('payments');
                    }
                } else {
                    flash('payment_error', 'Payment was not successful', 'alert alert-danger');
                    redirect('payments');
                }
            } catch (\Stripe\Exception\ApiErrorException $e) {
                flash('payment_error', $e->getMessage(), 'alert alert-danger');
                redirect('payments');
            }
        } else {
            redirect('payments');
        }
    }
    
    public function webhook() {
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, STRIPE_WEBHOOK_SECRET
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
        
        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                // Handle successful payment
                break;
            // Add other event types as needed
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }
        
        http_response_code(200);
    }
    
    // View a specific payment
    // Change this method name from 'view' to 'viewPayment'
    public function viewPayment($id) {
        // Check if user is admin or superadmin
        if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        $payment = $this->paymentModel->getPaymentById($id);
        
        if (!$payment) {
            redirect('payments/admin_dashboard');
        }
        
        // Get user information
        $user = $this->userModel->getUserById(is_array($payment) ? $payment['user_id'] : $payment->user_id);        
        $data = [
            'payment' => $payment,
            'user' => $user
        ];
        
        $this->view('payments/view', $data);
    }   
    // Generate payment receipt
    public function receipt($id) {
        $payment = $this->paymentModel->getPaymentById($id);
        
        if (!$payment) {
            redirect('payments/admin_dashboard');
        }
        
        // Check if user is admin/superadmin or the payment owner
        if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 3 && $payment->user_id != $_SESSION['user_id']) {
            redirect('pages/index');
        }
        
        // Get user information
        $user = $this->userModel->getUserById(is_array($payment) ? $payment['user_id'] : $payment->user_id);

        
        $data = [
            'payment' => $payment,
            'user' => $user
        ];
        
        $this->view('payments/receipt', $data);
    }
    
    // Export payments data
    public function export() {
        // Check if user is admin or superadmin
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        $payments = $this->paymentModel->getAllPayments();
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="payments_export_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($output, ['ID', 'User ID', 'User Name', 'Home Address', 'Amount', 'Description', 'Transaction ID', 'Status', 'Date']);
        
        // Add data rows
        foreach ($payments as $payment) {
            $user = $this->userModel->getUserById($payment->user_id);
            $userName = $user ? $user->name : 'Unknown';
            
            fputcsv($output, [
                $payment->id,
                $payment->user_id,
                $userName,
                $payment->home_address,
                $payment->amount,
                $payment->description,
                $payment->transaction_id,
                $payment->status,
                $payment->created_at
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    // Payment reports page
    public function reports() {
        // Check if user is admin or superadmin
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        // Get statistics for reports
        $stats = $this->paymentModel->getPaymentStatistics();
        $monthlyData = $this->paymentModel->getMonthlyPaymentData();
        $addressData = $this->paymentModel->getPaymentsByAddressData();
        
        $data = [
            'total_amount' => $stats['total_amount'] ?? 0,
            'completed_payments' => $stats['completed_count'] ?? 0,
            'pending_payments' => $stats['pending_count'] ?? 0,
            'failed_payments' => $stats['failed_count'] ?? 0,
            'monthly_data' => $monthlyData,
            'address_data' => $addressData
        ];
        
        $this->view('payments/reports', $data);
    }

    public function delete($id) {
        // Check if user is admin or superadmin
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get payment before deletion to check if it exists
            $payment = $this->paymentModel->getPaymentById($id);
            
            if (!$payment) {
                flash('payment_message', 'Payment not found', 'alert alert-danger');
                redirect('payments/admin_dashboard');
            }
            
            // Delete payment
            if ($this->paymentModel->deletePayment($id)) {
                flash('payment_message', 'Payment record deleted successfully', 'alert alert-success');
            } else {
                flash('payment_message', 'Something went wrong while deleting the payment', 'alert alert-danger');
            }
            
            redirect('payments/admin_dashboard');
        } else {
            redirect('payments/admin_dashboard');
        }
    }
    
}
