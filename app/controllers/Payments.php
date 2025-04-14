<?php
require_once APPROOT . '/helpers/BraintreeHelper.php';

class Payments extends Controller
{
    private $paymentModel;
    private $userModel;
    private $residentModel;
    
    public function __construct()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        // Load models
        $this->paymentModel = $this->model('M_Payments');
        $this->userModel = $this->model('M_Users');
        $this->residentModel = $this->model('M_Resident');
    }

    public function index()
    {
        $payments = $this->paymentModel->getUserPayments($_SESSION['user_id']);
        $data = [
            'payments' => $payments,
            'title' => 'My Payments'
        ];
        $this->view('payment/index', $data);
    }
    
    public function create() {
        // Get resident information for the logged-in user
        $resident = $this->residentModel->getResidentByUserId($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'address' => trim($_POST['address']),
                'payment_type' => trim($_POST['payment_type']),
                'amount' => trim($_POST['amount']),
                'description' => trim($_POST['description']),
                'payment_types' => [
                    'maintenance' => 'Maintenance Fee',
                    'utility' => 'Utility Bill',
                    'event' => 'Event Fee',
                    'other' => 'Other Payment'
                ],
                'errors' => []
            ];

            // Validate address
            if (empty($data['address'])) {
                $data['errors'][] = 'Please enter your residence address';
            }

            // Validate payment type
            if (empty($data['payment_type'])) {
                $data['errors'][] = 'Please select a payment type';
            }

            // Validate amount
            if (empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
                $data['errors'][] = 'Please enter a valid amount';
            }

            // Validate description
            if (empty($data['description'])) {
                $data['errors'][] = 'Please enter a description';
            }

            // If no errors, create payment
            if (empty($data['errors'])) {
                // Create payment record
                $transaction_id = $this->paymentModel->createPayment($data);
                
                if ($transaction_id) {
                    // Redirect to checkout page
                    redirect('payments/checkout/' . $transaction_id);
                } else {
                    $data['errors'][] = 'Something went wrong. Please try again.';
                    $this->view('payment/create', $data);
                }
            } else {
                // Load view with errors
                $this->view('payment/create', $data);
            }
        } else {
            // Initialize data with resident's address if available
            $data = [
                'address' => $resident ? $resident['address'] : '',
                'payment_type' => '',
                'amount' => '',
                'description' => '',
                'payment_types' => [
                    'maintenance' => 'Maintenance Fee',
                    'utility' => 'Utility Bill',
                    'event' => 'Event Fee',
                    'other' => 'Other Payment'
                ],
                'errors' => []
            ];

            // Load view
            $this->view('payment/create', $data);
        }
    }
    
    public function checkout($transactionId)
    {
        // Get the payment details
        $payment = $this->getPaymentByTransactionId($transactionId);
        
        if (!$payment || $payment->user_id != $_SESSION['user_id']) {
            flash('payment_message', 'Invalid payment request', 'alert alert-danger');
            redirect('payments');
        }
        
        // Generate a client token for Braintree
        $clientToken = BraintreeHelper::generateClientToken();
        
        $data = [
            'payment' => $payment,
            'client_token' => $clientToken,
            'amount' => $payment->amount,
            'transaction_id' => $transactionId
        ];
        
        $this->view('payment/checkout', $data);
    }
    
    // Helper method to get payment by transaction ID from logs
    private function getPaymentByTransactionId($transactionId)
    {
        $logFile = APPROOT . '/logs/braintree_payments.log';
        
        if (!file_exists($logFile)) {
            return null;
        }
        
        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($logs as $log) {
            if (strpos($log, '"transaction_id":"' . $transactionId . '"') !== false) {
                if (preg_match('/{.*}/', $log, $matches)) {
                    $data = json_decode($matches[0]);
                    if ($data && isset($data->transaction_id) && $data->transaction_id === $transactionId) {
                        return $data;
                    }
                }
            }
        }
        
        return null;
    }
    
    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('payments');
        }
        
        $nonce = $_POST['payment_method_nonce'];
        $amount = $_POST['amount'];
        $transactionId = $_POST['transaction_id'];
        
        // Get the payment details
        $payment = $this->getPaymentByTransactionId($transactionId);
        
        if (!$payment || $payment->user_id != $_SESSION['user_id']) {
            flash('payment_message', 'Invalid payment request', 'alert alert-danger');
            redirect('payments');
        }
        
        try {
            // Create a transaction using Braintree
            $gateway = BraintreeHelper::getGateway();
            $result = $gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ],
                'customFields' => [
                    'transaction_id' => $transactionId,
                    'user_id' => $_SESSION['user_id'],
                    'payment_type' => $payment->payment_type
                ]
            ]);
            
            if ($result->success) {
                // Update payment status
                $this->paymentModel->updatePaymentStatus(
                    $transactionId, 
                    'settled', 
                    $result->transaction->id
                );
                
                // Log the successful transaction
                $logFile = APPROOT . '/logs/braintree_transactions.log';
                $logDir = dirname($logFile);
                
                if (!file_exists($logDir)) {
                    mkdir($logDir, 0755, true);
                }
                
                $logData = [
                    'transaction_id' => $transactionId,
                    'braintree_transaction_id' => $result->transaction->id,
                    'status' => $result->transaction->status,
                    'amount' => $result->transaction->amount,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                file_put_contents(
                    $logFile, 
                    date('Y-m-d H:i:s') . ' - ' . json_encode($logData) . "\n", 
                    FILE_APPEND
                );
                
                // Redirect to success page
                redirect('payments/success');
            } else {
                // Payment failed
                $errorString = "";
                foreach($result->errors->deepAll() as $error) {
                    $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                }
                
                // Log the error
                $logFile = APPROOT . '/logs/braintree_errors.log';
                $logDir = dirname($logFile);
                
                if (!file_exists($logDir)) {
                    mkdir($logDir, 0755, true);
                }
                
                file_put_contents(
                    $logFile, 
                    date('Y-m-d H:i:s') . ' - ' . $errorString . "\n", 
                    FILE_APPEND
                );
                
                // Update payment status
                $this->paymentModel->updatePaymentStatus(
                    $transactionId, 
                    'failed', 
                    null
                );
                
                flash('payment_message', 'Payment failed: ' . $errorString, 'alert alert-danger');
                redirect('payments/cancel');
            }
        } catch (Exception $e) {
            // Log the exception
            $logFile = APPROOT . '/logs/braintree_exceptions.log';
            $logDir = dirname($logFile);
            
            if (!file_exists($logDir)) {
                mkdir($logDir, 0755, true);
            }
            
            file_put_contents(
                $logFile, 
                date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n", 
                FILE_APPEND
            );
            
            // Update payment status
            $this->paymentModel->updatePaymentStatus(
                $transactionId, 
                'failed', 
                null
            );
            
            flash('payment_message', 'An error occurred: ' . $e->getMessage(), 'alert alert-danger');
            redirect('payments/cancel');
        }
    }
    
    public function success()
    {
        // Handle successful payment return
        flash('payment_message', 'Payment completed successfully', 'alert alert-success');
        $this->view('payment/success');
    }
    
    public function cancel()
    {
        // Handle cancelled payment
        $this->view('payment/cancel');
    }
    
    public function webhook()
    {
        // This endpoint will receive Braintree webhooks
        // You need to configure this in your Braintree dashboard
        
        $gateway = BraintreeHelper::getGateway();
        
        // Get the webhook notification
        $webhookNotification = null;
        
        try {
            if(isset($_POST["bt_signature"]) && isset($_POST["bt_payload"])) {
                $webhookNotification = $gateway->webhookNotification()->parse(
                    $_POST["bt_signature"], $_POST["bt_payload"]
                );
            }
        } catch (Exception $e) {
            // Log the exception
            $logFile = APPROOT . '/logs/braintree_webhook_errors.log';
            $logDir = dirname($logFile);
            
            if (!file_exists($logDir)) {
                mkdir($logDir, 0755, true);
            }
            
            file_put_contents(
                $logFile, 
                date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n", 
                FILE_APPEND
            );
            
            http_response_code(500);
            exit;
        }
        
        // Log the webhook
        $logFile = APPROOT . '/logs/braintree_webhooks.log';
        $logDir = dirname($logFile);
        
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logData = [
            'kind' => $webhookNotification->kind,
            'timestamp' => date('Y-m-d H:i:s'),
            'transaction' => null
        ];
        
        if (isset($webhookNotification->subject->transaction)) {
            $transaction = $webhookNotification->subject->transaction;
            $logData['transaction'] = [
                'id' => $transaction->id,
                'status' => $transaction->status,
                'amount' => $transaction->amount,
                'custom_fields' => $transaction->customFields
            ];
            
            // Update payment status if we have a transaction ID in custom fields
            if (isset($transaction->customFields['transaction_id'])) {
                $this->paymentModel->updatePaymentStatus(
                    $transaction->customFields['transaction_id'],
                    $transaction->status,
                    $transaction->id
                );
            }
        }
        
        file_put_contents(
            $logFile, 
            date('Y-m-d H:i:s') . ' - ' . json_encode($logData) . "\n", 
            FILE_APPEND
        );
        
        http_response_code(200);
    }
    
    public function admin_dashboard()
    {
        // Check if user is admin
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('users/login');
        }
        
        $payments = $this->paymentModel->getAllPayments();
        $totalAmount = $this->paymentModel->getTotalPaymentsAmount();
        $pendingPayments = $this->paymentModel->getPendingPaymentsCount();
        
        $data = [
            'payments' => $payments,
            'total_amount' => $totalAmount,
            'pending_payments' => $pendingPayments
        ];
        
        $this->view('payment/admin_dashboard', $data);
    }
    
    public function filter()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
            $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
            
            if (!empty($type)) {
                $payments = $this->paymentModel->getPaymentsByType($type);
            } elseif (!empty($startDate) && !empty($endDate)) {
                $payments = $this->paymentModel->getPaymentsByDateRange($startDate, $endDate);
            } else {
                $payments = $this->paymentModel->getAllPayments();
            }
            
            $data = [
                'payments' => $payments
            ];
            
            $this->view('payment/filtered_results', $data);
        } else {
            redirect('payments/admin_dashboard');
        }
    }
}
