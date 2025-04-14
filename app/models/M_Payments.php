<?php
class M_Payments
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Get user payments from logs
     * 
     * @param int $userId The user ID
     * @return array Array of payment objects
     */
    public function getUserPayments($userId)
    {
        // Check if there are any payment logs for this user
        $paymentLogs = $this->getPaymentLogsForUser($userId);
        
        if (empty($paymentLogs)) {
            // Return empty array if no payments found
            return [];
        }
        
        return $paymentLogs;
    }

    /**
     * Get payment logs for a specific user from the log file
     * 
     * @param int $userId The user ID
     * @return array Array of payment objects
     */
    private function getPaymentLogsForUser($userId)
    {
        $logFile = APPROOT . '/logs/braintree_payments.log';
        if (!file_exists($logFile)) {
            return [];
        }

        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $payments = [];
        
        foreach ($logs as $log) {
            if (strpos($log, '"user_id":' . $userId) !== false && strpos($log, '"status":"settled"') !== false) {
                // Extract payment data from the log
                if (preg_match('/{.*}/', $log, $matches)) {
                    $data = json_decode($matches[0]);
                    if ($data && isset($data->transaction_id)) {
                        $payment = (object)[
                            'id' => $data->transaction_id,
                            'user_id' => $data->user_id,
                            'amount' => $data->amount,
                            'status' => $data->status,
                            'created_at' => $data->created_at,
                            'payment_type' => $data->payment_type,
                            'description' => $data->description
                        ];
                        
                        $payments[] = $payment;
                    }
                }
            }
        }
        
        return $payments;
    }

    /**
     * Create a payment record
     * 
     * @param array $data Payment data
     * @return string Generated transaction ID
     */
    public function createPayment($data)
    {
        // Generate a unique transaction ID
        $transactionId = 'SAMEEPA_' . uniqid();
        
        // Log the payment creation
        $logFile = APPROOT . '/logs/braintree_payments.log';
        $logDir = dirname($logFile);
        
        // Create logs directory if it doesn't exist
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logData = [
            'transaction_id' => $transactionId,
            'user_id' => $data['user_id'],
            'address' => $data['address'],
            'payment_type' => $data['payment_type'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        file_put_contents(
            $logFile, 
            date('Y-m-d H:i:s') . ' - ' . json_encode($logData) . "\n", 
            FILE_APPEND
        );
        
        return $transactionId;
    }

    /**
     * Update payment status
     * 
     * @param string $transactionId The transaction ID
     * @param string $status The new status
     * @param string $braintreeTransactionId The Braintree transaction ID
     * @return bool True if successful
     */
    public function updatePaymentStatus($transactionId, $status, $braintreeTransactionId)
    {
        // Log the status update
        $logFile = APPROOT . '/logs/braintree_payments.log';
        $logDir = dirname($logFile);
        
        // Create logs directory if it doesn't exist
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logData = [
            'transaction_id' => $transactionId,
            'status' => $status,
            'braintree_transaction_id' => $braintreeTransactionId,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        file_put_contents(
            $logFile, 
            date('Y-m-d H:i:s') . ' - ' . json_encode($logData) . "\n", 
            FILE_APPEND
        );
        
        return true;
    }

    /**
     * Get all payments (for admin dashboard)
     * 
     * @return array Array of payment objects
     */
    public function getAllPayments()
    {
        $logFile = APPROOT . '/logs/braintree_payments.log';
        
        if (!file_exists($logFile)) {
            return [];
        }
        
        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $payments = [];
        $processedIds = [];
        
        // Process logs in reverse order to get the latest status
        $logs = array_reverse($logs);
        
        foreach ($logs as $log) {
            if (preg_match('/{.*}/', $log, $matches)) {
                $data = json_decode($matches[0]);
                
                if ($data && isset($data->transaction_id) && !in_array($data->transaction_id, $processedIds)) {
                    // Only process each transaction once (latest status)
                    $processedIds[] = $data->transaction_id;
                    
                    // If it's a status update, find the original payment
                    if (isset($data->status) && !isset($data->user_id)) {
                        continue; // Skip status updates without full payment info
                    }
                    
                    $payment = (object)[
                        'id' => $data->transaction_id,
                        'user_id' => $data->user_id,
                        'user_name' => $this->getUserName($data->user_id),
                        'amount' => $data->amount,
                        'status' => $data->status,
                        'created_at' => $data->created_at,
                        'payment_type' => $data->payment_type,
                        'description' => $data->description
                    ];
                    
                    $payments[] = $payment;
                }
            }
        }
        
        // Sort by created_at date (newest first)
        usort($payments, function($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });
        
        return $payments;
    }

    /**
     * Get user name by ID
     * 
     * @param int $userId The user ID
     * @return string The user's name
     */
    private function getUserName($userId)
    {
        $this->db->query('SELECT name FROM users WHERE id = :id');
        $this->db->bind(':id', $userId);
        $user = $this->db->single();
        
        return $user ? $user->name : 'Unknown User';
    }

    /**
     * Get total payments amount
     * 
     * @return float Total amount of completed payments
     */
    public function getTotalPaymentsAmount()
    {
        $payments = $this->getAllPayments();
        $total = 0;
        
        foreach ($payments as $payment) {
            if ($payment->status === 'settled') {
                $total += floatval($payment->amount);
            }
        }
        
        return $total;
    }

    /**
     * Get count of pending payments
     * 
     * @return int Number of pending payments
     */
    public function getPendingPaymentsCount()
    {
        $payments = $this->getAllPayments();
        $count = 0;
        
        foreach ($payments as $payment) {
            if ($payment->status === 'pending' || $payment->status === 'authorized') {
                $count++;
            }
        }
        
        return $count;
    }

    /**
     * Get payments by type
     * 
     * @param string $type Payment type
     * @return array Array of payment objects
     */
    public function getPaymentsByType($type)
    {
        $payments = $this->getAllPayments();
        $filtered = [];
        
        foreach ($payments as $payment) {
            if ($payment->payment_type === $type) {
                $filtered[] = $payment;
            }
        }
        
        return $filtered;
    }

    /**
     * Get payments by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array Array of payment objects
     */
    public function getPaymentsByDateRange($startDate, $endDate)
    {
        $payments = $this->getAllPayments();
        $filtered = [];
        
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate) + 86400; // Add one day to include the end date
        
        foreach ($payments as $payment) {
            $paymentTimestamp = strtotime($payment->created_at);
            if ($paymentTimestamp >= $startTimestamp && $paymentTimestamp <= $endTimestamp) {
                $filtered[] = $payment;
            }
        }
        
        return $filtered;
    }
}
