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
}
