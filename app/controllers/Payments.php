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
        redirect('payments/requests');
    }
    public function admin_dashboard($page = 1) {
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        $requests = $this->paymentModel->getAllPaymentRequestsWithResidentNames();
        
        $monthlyData = $this->paymentModel->getMonthlyPaymentData();
        
        $mostActiveDay = $this->paymentModel->getMostActiveDayThisMonth();
        $requestsThisMonth = $this->paymentModel->getRequestCountThisMonth();
        $totalAmountThisMonth = $this->paymentModel->getTotalAmountThisMonth();
        $recentActivity = $this->paymentModel->getRecentRequestActivity();
        
        $data = [
            'requests' => $requests,
            'monthly_data' => $monthlyData,
            'most_active_day' => $mostActiveDay,
            'requests_this_month' => $requestsThisMonth,
            'total_amount_this_month' => $totalAmountThisMonth,
            'recent_activity' => $recentActivity,
        ];
        
        $this->view('payments/admin_dashboard', $data);
    }

    public function checkout($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $paymentRequest = $this->paymentModel->getPaymentRequestById($id);
        
        if (!$paymentRequest) {
            flash('payment_error', 'Payment request not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        $userAddress = $this->paymentModel->getResidentAddress($_SESSION['user_id']);
        if (!$userAddress) {
            flash('payment_error', 'You are not registered as a resident', 'alert alert-danger');
            redirect('payments/requests');
        }

        $userAddressStr = is_object($userAddress) ? $userAddress->address : $userAddress['address'];

        if ($userAddressStr !== $paymentRequest->address) {
            flash('payment_error', 'You are not authorized to pay this request', 'alert alert-danger');
            redirect('payments/requests');
        }

        if ($paymentRequest->status === 'paid') {
            flash('payment_error', 'This payment has already been processed', 'alert alert-danger');
            redirect('payments/requests');
        }

        //amount in cents (Stripe requires amounts in smallest currency unit)
        $amount = $paymentRequest->amount * 100;

        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'lkr',
                'description' => 'Payment for ' . $paymentRequest->description,
                'metadata' => [
                    'payment_request_id' => $paymentRequest->id
                ]
            ]);

            $data = [
                'paymentRequest' => $paymentRequest,
                'clientSecret' => $paymentIntent->client_secret,
                'stripePublicKey' => STRIPE_PUBLIC_KEY
            ];

            $this->view('payments/checkout', $data);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            flash('payment_error', 'Error creating payment: ' . $e->getMessage());
            redirect('payments/requests');
        }
    }
    

    public function success() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $payment_intent_id = $_GET['payment_intent'];
        
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
            
            if ($paymentIntent->status === 'succeeded') {
                $paymentRequestId = $paymentIntent->metadata->payment_request_id;
                $this->paymentModel->updatePaymentRequestStatus(
                    $paymentRequestId,
                    'paid',
                    $paymentIntent->id
                );
                
                flash('payment_success', 'Payment successful!', 'alert alert-success');
                redirect('payments/requests');
            } else {
                flash('payment_error', 'Payment was not successful', 'alert alert-danger');
                redirect('payments/requests');
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            flash('payment_error', 'Error verifying payment: ' . $e->getMessage(), 'alert alert-danger');
            redirect('payments/requests');
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
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }
        
        http_response_code(200);
    }
    
    public function viewPayment($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $payment = $this->paymentModel->getPaymentDetails($id);
        
        if (!$payment) {
            flash('payment_error', 'Payment not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        $data = [
            'payment' => $payment,
            'user' => $user
        ];
        
        $this->view('payments/view', $data);
    }

    public function receipt($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $payment = $this->paymentModel->getPaymentDetails($id);
        
        if (!$payment) {
            flash('payment_error', 'Payment not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        $data = [
            'payment' => $payment,
            'user' => $user
        ];
        
        $this->view('payments/receipt', $data);
    }
    
    public function export() {
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        $payments = $this->paymentModel->getAllPaymentRequestsWithResidentNames();
        
        //headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="payment_requests_export_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        //add CSV headers
        fputcsv($output, ['ID', 'Address', 'Amount', 'Description', 'Due Date', 'Status', 'Created By', 'Created At', 'Paid At','Transaction ID']);
        
        foreach ($payments as $payment) {
            fputcsv($output, [
                $payment->id,
                $payment->address,
                $payment->amount,
                $payment->description,
                $payment->due_date,
                $payment->status,
                $payment->created_by_name,
                $payment->created_at,
                $payment->paid_at,
                $payment->transaction_id
            ]);
        }
        
        fclose($output);
        exit;
    }

    public function delete($id) {
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = $this->paymentModel->getPaymentRequestById($id);
            
            if (!$request) {
                flash('payment_message', 'Payment request not found', 'alert alert-danger');
                redirect('payments/requests');
            }
            
            if ($this->paymentModel->deletePaymentRequest($id)) {
                flash('payment_message', 'Payment request deleted successfully', 'alert alert-success');
            } else {
                flash('payment_message', 'Something went wrong while deleting the request', 'alert alert-danger');
            }
            
            redirect('payments/requests');
        } else {
            redirect('payments/requests');
        }
    }

    public function all() {
        if ($_SESSION['user_role_id'] != 2 && $_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        $requests = $this->paymentModel->getAllPaymentRequestsWithResidentNames();
        
        $data = [
            'requests' => $requests
        ];
        
        $this->view('payments/all', $data);
    }

    public function create_request() {
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }
        
        $residents = $this->userModel->getResidentsWithAddresses();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            
            if (empty($data['address_err']) && empty($data['amount_err']) && 
                empty($data['description_err']) && empty($data['due_date_err'])) {
                
                if ($this->paymentModel->createPaymentRequest($data)) {
                    flash('payment_request_message', 'Payment request created successfully', 'alert alert-success');
                    redirect('payments/requests');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('payments/create_request', $data);
            }
        } else {
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
    
    public function requests() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SESSION['user_role_id'] == 1) {
            $resident = $this->paymentModel->getResidentAddress($_SESSION['user_id']);
            if (!$resident) {
                flash('payment_error', 'You are not registered as a resident', 'alert alert-danger');
                redirect('pages/index');
            }
            $userAddress = is_array($resident) ? $resident['address'] : $resident->address;
            $requests = $this->paymentModel->getPendingRequestsByAddress($userAddress);
        } else {
            $requests = $this->paymentModel->getAllPendingRequests();
        }

        $data = [
            'requests' => $requests
        ];

        $this->view('payments/requests', $data);
    }
    
    public function pay_request($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $request = $this->paymentModel->getPaymentRequestById($id);
        
        if (!$request) {
            flash('payment_error', 'Payment request not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        if ($request->status == 'paid') {
            flash('payment_error', 'This request has already been paid', 'alert alert-warning');
            redirect('payments/requests');
        }


        $data = [
            'request' => $request
        ];

        $this->view('payments/pay_request', $data);
    }
    
    public function request_success($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $request = $this->paymentModel->getPaymentRequestById($id);
        
        if (!$request) {
            flash('payment_error', 'Payment request not found', 'alert alert-danger');
            redirect('payments/requests');
        }

        if (!$this->paymentModel->validatePaymentRequestForCheckout($id, $_SESSION['user_id'])) {
            flash('payment_error', 'You are not authorized to pay this request', 'alert alert-danger');
            redirect('payments/requests');
        }

        //from stripe
        if (isset($_GET['payment_intent'])) {
            try {
                $paymentIntent = \Stripe\PaymentIntent::retrieve($_GET['payment_intent']);
                
                if ($paymentIntent->status === 'succeeded') {
                    $resident = $this->paymentModel->getResidentAddress($_SESSION['user_id']);
                    $userAddress = is_array($resident) ? $resident['address'] : $resident->address;

                    $paymentData = [
                        'user_id' => $_SESSION['user_id'],
                        'home_address' => $userAddress,
                        'amount' => $request->amount,
                        'description' => $request->description,
                        'transaction_id' => $paymentIntent->id,
                        'status' => 'completed',
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    
                    if ($this->paymentModel->addPayment($paymentData)) {
                        $payment = $this->paymentModel->getPaymentByTransactionId($paymentIntent->id);
                        
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
        if ($_SESSION['user_role_id'] != 3) {
            redirect('pages/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = $this->paymentModel->getPaymentRequestById($id);
            
            if (!$request) {
                flash('payment_request_message', 'Payment request not found', 'alert alert-danger');
                redirect('payments/requests');
            }
            
            if ($request->status == 'paid') {
                flash('payment_request_message', 'Cannot delete a paid request', 'alert alert-warning');
                redirect('payments/requests');
            }
            
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

    public function history() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SESSION['user_role_id'] == 1) {
            $resident = $this->paymentModel->getResidentAddress($_SESSION['user_id']);
            if (!$resident) {
                flash('payment_error', 'You are not registered as a resident', 'alert alert-danger');
                redirect('payments/requests');
            }
            $userAddress = is_array($resident) ? $resident['address'] : $resident->address;
            $payments = $this->paymentModel->getPaymentHistoryByAddress($userAddress);
        } else {
            $payments = $this->paymentModel->getAllPaymentHistory();
        }

        $data = [
            'payments' => $payments
        ];

        $this->view('payments/history', $data);
    }
}
