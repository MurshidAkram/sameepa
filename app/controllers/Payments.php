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
        
        $payments = $this->paymentModel->getRecentPayments(5);
        
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
        ];
        
        $this->view('payments/admin_dashboard', $data);
    }

    public function checkout($id) {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        // Get payment request data
        $request = $this->paymentModel->getPaymentRequestById($id);
        
        if (!$request) {
            flash('payment_error', 'Payment request not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        // Check if request is already paid
        if ($request->status == 'paid') {
            flash('payment_error', 'This request has already been paid', 'alert alert-warning');
            redirect('payments/requests');
        }

        // Check if user is the intended recipient
        if ($request->user_id != $_SESSION['user_id']) {
            flash('payment_error', 'You are not authorized to pay this request', 'alert alert-danger');
            redirect('payments/requests');
        }

        // Check if amount meets minimum requirement (Rs.150)
        if ($request->amount < 150) {
            flash('payment_error', 'Payment amount must be at least Rs.150', 'alert alert-danger');
            redirect('payments/requests');
        }

        // Create payment intent
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $request->amount * 100, // Convert to cents
                'currency' => 'lkr',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'request_id' => $request->id,
                    'user_id' => $request->user_id
                ]
            ]);

            $data = [
                'request' => $request,
                'client_secret' => $paymentIntent->client_secret,
            ];

            $this->view('payments/checkout', $data);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            flash('payment_error', 'Error creating payment: ' . $e->getMessage(), 'alert alert-danger');
            redirect('payments/requests');
        }
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
        fputcsv($output, ['ID', 'User ID', 'User Name', 'Home Address', 'Amount', 'Description', 'Transaction ID', 'Date & Time']);
        
        // Add data rows
        foreach ($payments as $payment) {
            $user = $this->userModel->getUserById($payment->user_id);
            $userName = is_array($user) ? $user['name'] : $user->name;            
            
            fputcsv($output, [
                $payment->id,
                $payment->user_id,
                $userName,
                $payment->home_address,
                $payment->amount,
                $payment->description,
                $payment->transaction_id,
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

    public function all() {
        // Check if user is admin or superadmin
        if ($_SESSION['user_role_id'] != 2 && $_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        // Get all payments with user information
        $payments = $this->paymentModel->getAllPaymentsWithUserInfo();
        
        $data = [
            'payments' => $payments
        ];
        
        $this->view('payments/all', $data);
    }
    // Admin view to create payment requests
    public function create_request() {
        if ($_SESSION['user_role_id'] != 2) {
            redirect('pages/index');
        }
        
        // Get all residents with their addresses
        $residents = $this->userModel->getResidentsWithAddresses();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'address' => trim($_POST['address']),
                'amount' => trim($_POST['amount']),
                'description' => trim($_POST['description']),
                'due_date' => trim($_POST['due_date']),
                'created_by' => $_SESSION['user_id'],
                'residents' => $residents,
                'address_err' => '',
                'amount_err' => '',
                'description_err' => '',
                'due_date_err' => ''
            ];
            
            // Validate data
            if (empty($data['address'])) {
                $data['address_err'] = 'Please select an address';
            }
            
            if (empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] < 150) {
                $data['amount_err'] = 'Please enter a valid amount (minimum Rs.150)';
            }
            
            if (empty($data['description'])) {
                $data['description_err'] = 'Please enter a description';
            }
            
            if (empty($data['due_date'])) {
                $data['due_date_err'] = 'Please select a due date';
            }
            
            // Make sure no errors
            if (empty($data['address_err']) && empty($data['amount_err']) && 
                empty($data['description_err']) && empty($data['due_date_err'])) {
                
                if ($this->paymentModel->createPaymentRequest($data)) {
                    flash('payment_request_message', 'Payment request created successfully', 'alert alert-success');
                    redirect('payments/requests');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('payments/create_request', $data);
            }
        } else {
            // Initialize data for GET request
            $data = [
                'address' => '',
                'amount' => '',
                'description' => '',
                'due_date' => '',
                'residents' => $residents,
                'address_err' => '',
                'amount_err' => '',
                'description_err' => '',
                'due_date_err' => ''
            ];
            
            $this->view('payments/create_request', $data);
        }
    }
    
    // View all payment requests
    public function requests() {
        if ($_SESSION['user_role_id'] == 2) {
            // Admin view - show all requests with resident names
            $requests = $this->paymentModel->getAllPaymentRequestsWithResidentNames();
        } else {
            // Resident view - show only their requests
            $requests = $this->paymentModel->getPaymentRequestsByUserId($_SESSION['user_id']);
        }
        
        $data = [
            'requests' => $requests
        ];
        
        $this->view('payments/requests', $data);
    }
    
    // Process payment for a request
    public function pay_request($id) {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        // Get payment request data
        $request = $this->paymentModel->getPaymentRequestById($id);
        
        if (!$request) {
            flash('payment_error', 'Payment request not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        // Check if request is already paid
        if ($request->status == 'paid') {
            flash('payment_error', 'This request has already been paid', 'alert alert-warning');
            redirect('payments/requests');
        }


        $data = [
            'request' => $request
        ];

        $this->view('payments/pay_request', $data);
    }
    
    // Handle successful payment for a request
    public function request_success($id) {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        // Get payment request data
        $request = $this->paymentModel->getPaymentRequestById($id);
        
        if (!$request) {
            flash('payment_error', 'Payment request not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        // Check if user is the intended recipient
        if ($request->user_id != $_SESSION['user_id']) {
            flash('payment_error', 'You are not authorized to pay this request', 'alert alert-danger');
            redirect('payments/requests');
        }

        // Get payment intent from Stripe
        if (isset($_GET['payment_intent'])) {
            try {
                $paymentIntent = \Stripe\PaymentIntent::retrieve($_GET['payment_intent']);
                
                if ($paymentIntent->status === 'succeeded') {
                    // Record payment in database
                    $paymentData = [
                        'user_id' => $request->user_id,
                        'amount' => $request->amount,
                        'description' => $request->description,
                        'transaction_id' => $paymentIntent->id,
                        'status' => 'completed',
                        'created_at' => date('Y-m-d H:i:s') // Add current timestamp
                    ];
                    
                    if ($this->paymentModel->addPayment($paymentData)) {
                        // Get the payment ID
                        $payment = $this->paymentModel->getPaymentByTransactionId($paymentIntent->id);
                        
                        // Update payment request status
                        if ($this->paymentModel->updatePaymentRequestStatus($id, 'paid', $payment->id)) {
                            flash('payment_success', 'Payment completed successfully!', 'alert alert-success');
                        } else {
                            flash('payment_error', 'Error updating payment status', 'alert alert-danger');
                        }
                    } else {
                        flash('payment_error', 'Error recording payment', 'alert alert-danger');
                    }
                } else {
                    flash('payment_error', 'Payment was not successful', 'alert alert-danger');
                }
            } catch (\Stripe\Exception\ApiErrorException $e) {
                flash('payment_error', $e->getMessage(), 'alert alert-danger');
            }
        }

        redirect('payments/requests');
    }

    public function delete_request($id) {
        // Check if user is admin
        if ($_SESSION['user_role_id'] != 2) {
            redirect('pages/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get request before deletion to check if it exists
            $request = $this->paymentModel->getPaymentRequestById($id);
            
            if (!$request) {
                flash('payment_request_message', 'Payment request not found', 'alert alert-danger');
                redirect('payments/requests');
            }
            
            // Check if request is already paid
            if ($request->status == 'paid') {
                flash('payment_request_message', 'Cannot delete a paid request', 'alert alert-warning');
                redirect('payments/requests');
            }
            
            // Delete request
            if ($this->paymentModel->deletePaymentRequest($id)) {
                flash('payment_request_message', 'Payment request deleted successfully', 'alert alert-success');
            } else {
                flash('payment_request_message', 'Something went wrong while deleting the request', 'alert alert-danger');
            }
            
            redirect('payments/requests');
        } else {
            redirect('payments/requests');
        }
    }
}
