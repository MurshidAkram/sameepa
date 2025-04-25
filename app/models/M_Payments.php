<?php
class M_Payments {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get all payments for a specific user
    public function getPaymentsByUserId($userId) {
        $this->db->query('SELECT * FROM payments WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }

    // Add a new payment record
    public function addPayment($data) {
        $this->db->query('INSERT INTO payments (user_id, amount, description, transaction_id, status, created_at) VALUES (:user_id, :amount, :description, :transaction_id, :status, :created_at)');
        
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':transaction_id', $data['transaction_id']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':created_at', $data['created_at']);
        
        return $this->db->execute();
    }

    // Get a specific payment by ID
    public function getPaymentById($id) {
        $this->db->query('SELECT * FROM payments WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    // Get payments by home address
    public function getPaymentsByHomeAddress($homeAddress) {
        $this->db->query('SELECT * FROM payments WHERE home_address = :home_address ORDER BY created_at DESC');
        $this->db->bind(':home_address', $homeAddress);

        return $this->db->resultSet();
    }

    // Get total payments amount for a user
    public function getTotalPaymentsByUser($userId) {
        $this->db->query('SELECT SUM(amount) as total FROM payments WHERE user_id = :user_id AND status = "completed"');
        $this->db->bind(':user_id', $userId);

        $result = $this->db->single();
        return $result->total ?? 0;
    }

    // Get total payments amount by home address
    public function getTotalPaymentsByHomeAddress($homeAddress) {
        $this->db->query('SELECT SUM(amount) as total FROM payments WHERE home_address = :home_address AND status = "completed"');
        $this->db->bind(':home_address', $homeAddress);

        $result = $this->db->single();
        return $result->total ?? 0;
    }
    
    // Get most recent payments with user information
    public function getRecentPayments($limit = 5) {
        $this->db->query('SELECT p.*, u.name as user_name 
                        FROM payments p 
                        LEFT JOIN users u ON p.user_id = u.id 
                        ORDER BY p.created_at DESC 
                        LIMIT :limit');
        
        $this->db->bind(':limit', $limit);
        
        return $this->db->resultSet();
    }

    // Get total count of payments
    public function getTotalPaymentsCount() {
        $this->db->query('SELECT COUNT(*) as count FROM payments');
        
        $result = $this->db->single();
        return $result->count ?? 0;
    }
    
    // Get all payments (for export)
    public function getAllPayments() {
        $this->db->query('SELECT * FROM payments ORDER BY created_at DESC');
        
        return $this->db->resultSet();
    }
    
    
    // Get monthly payment data for chart
    public function getMonthlyPaymentData() {
        $this->db->query('SELECT 
                          MONTH(paid_at) as month, 
                          SUM(amount) as total 
                          FROM payment_requests 
                          WHERE status = "paid" 
                          AND YEAR(paid_at) = YEAR(CURDATE()) 
                          GROUP BY MONTH(paid_at)');
        
        $results = $this->db->resultSet();
        
        // Initialize array with zeros for all months
        $monthlyData = array_fill(0, 12, 0);
        
        // Fill in the data we have
        foreach ($results as $row) {
            $monthlyData[$row->month - 1] = (float)$row->total;
        }
        
        return $monthlyData;
    }
    
    // Get payments by address data for reports
    public function getPaymentsByAddressData() {
        $this->db->query('SELECT 
                          home_address, 
                          COUNT(*) as count, 
                          SUM(amount) as total 
                          FROM payments 
                          WHERE status = "completed" 
                          GROUP BY home_address 
                          ORDER BY total DESC 
                          LIMIT 10');
        
        return $this->db->resultSet();
    }

    // Get most active day of the current month
    public function getMostActiveDayThisMonth() {
        $this->db->query('SELECT 
                          DAYNAME(paid_at) as day_name, 
                          COUNT(*) as request_count
                          FROM payment_requests 
                          WHERE MONTH(paid_at) = MONTH(CURRENT_DATE()) 
                          AND YEAR(paid_at) = YEAR(CURRENT_DATE())
                          AND status = "paid"
                          GROUP BY DAYNAME(paid_at)
                          ORDER BY request_count DESC
                          LIMIT 1');
        
        $result = $this->db->single();
        return is_array($result) ? ($result['day_name'] ?? 'N/A') : ($result->day_name ?? 'N/A');
    }

    // Get request count for the current month
    public function getRequestCountThisMonth() {
        $this->db->query('SELECT 
                          COUNT(*) as count
                          FROM payment_requests 
                          WHERE MONTH(paid_at) = MONTH(CURRENT_DATE()) 
                          AND YEAR(paid_at) = YEAR(CURRENT_DATE())
                          AND status = "paid"');
        
        $result = $this->db->single();
        return is_array($result) ? ($result['count'] ?? 0) : ($result->count ?? 0);
    }

    // Get total amount for the current month
    public function getTotalAmountThisMonth() {
        $this->db->query('SELECT 
                          SUM(amount) as total
                          FROM payment_requests 
                          WHERE MONTH(paid_at) = MONTH(CURRENT_DATE()) 
                          AND YEAR(paid_at) = YEAR(CURRENT_DATE())
                          AND status = "paid"');
        
        $result = $this->db->single();
        return is_array($result) ? ($result['total'] ?? 0) : ($result->total ?? 0);
    }

    // Get recent request activity (last 7 days)
    public function getRecentRequestActivity() {
        $this->db->query('SELECT 
                          COUNT(*) as count
                          FROM payment_requests 
                          WHERE paid_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
                          AND status = "paid"');
        
        $result = $this->db->single();
        return is_array($result) ? ($result['count'] ?? 0) : ($result->count ?? 0);
    }

    // Get payment statistics for reports
    public function getPaymentStatistics() {
        $this->db->query('SELECT 
                        SUM(amount) as total_amount,
                        COUNT(*) as total_count,
                        SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count,
                        SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count,
                        SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed_count,
                        COUNT(DISTINCT home_address) as unique_addresses
                        FROM payments');
        
        $result = $this->db->single();
        
        // Handle both object and array return types
        if ($result) {
            if (is_array($result)) {
                return [
                    'total_amount' => $result['total_amount'] ?? 0,
                    'total_count' => $result['total_count'] ?? 0,
                    'completed_count' => $result['completed_count'] ?? 0,
                    'pending_count' => $result['pending_count'] ?? 0,
                    'failed_count' => $result['failed_count'] ?? 0,
                    'unique_addresses' => $result['unique_addresses'] ?? 0
                ];
            } else {
                return [
                    'total_amount' => $result->total_amount ?? 0,
                    'total_count' => $result->total_count ?? 0,
                    'completed_count' => $result->completed_count ?? 0,
                    'pending_count' => $result->pending_count ?? 0,
                    'failed_count' => $result->failed_count ?? 0,
                    'unique_addresses' => $result->unique_addresses ?? 0
                ];
            }
        }
        
        // Return default values if query fails
        return [
            'total_amount' => 0,
            'total_count' => 0,
            'completed_count' => 0,
            'pending_count' => 0,
            'failed_count' => 0,
            'unique_addresses' => 0
        ];
    }

    // Delete a payment
    public function deletePayment($id) {
        $this->db->query('DELETE FROM payments WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

    // Get all payments with user information
    public function getAllPaymentsWithUserInfo() {
        $this->db->query('SELECT p.*, u.name as user_name 
                        FROM payments p 
                        LEFT JOIN users u ON p.user_id = u.id 
                        ORDER BY p.created_at DESC');
        
        return $this->db->resultSet();
    }

    // Create a new payment request
    public function createPaymentRequest($data) {
        $this->db->query('INSERT INTO payment_requests (address, amount, description, due_date, created_by) VALUES (:address, :amount, :description, :due_date, :created_by)');
        
        // Bind values
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':due_date', $data['due_date']);
        $this->db->bind(':created_by', $data['created_by']);
        
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get all payment requests
    public function getAllPaymentRequests() {
        $this->db->query('SELECT pr.*, u.name as user_name, cb.name as created_by_name 
                         FROM payment_requests pr 
                         LEFT JOIN users u ON pr.user_id = u.id 
                         LEFT JOIN users cb ON pr.created_by = cb.id 
                         ORDER BY pr.created_at DESC');
        
        return $this->db->resultSet();
    }

    // Get payment requests for a specific user
    public function getPaymentRequestsByUserId($user_id) {
        // First get the user's address
        $this->db->query('SELECT address FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $resident = $this->db->single();
        
        if (!$resident) {
            return [];
        }
        
        // Handle both array and object return types
        $address = is_array($resident) ? $resident['address'] : $resident->address;
        
        // Then get payment requests for that address
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.address = :address
            AND pr.status = "paid"
            ORDER BY pr.paid_at DESC
        ');
        
        $this->db->bind(':address', $address);
        return $this->db->resultSet();
    }

    // Get a specific payment request by ID
    public function getPaymentRequestById($id) {
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.id = :id
        ');
        
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        
        // Convert array to object if needed
        if (is_array($result)) {
            $result = (object)$result;
        }
        
        return $result;
    }

    // Update payment request status
    public function updatePaymentRequestStatus($id, $status, $transaction_id = null) {
        $this->db->query('UPDATE payment_requests SET status = :status, paid_at = CURRENT_TIMESTAMP, transaction_id = :transaction_id WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->bind(':transaction_id', $transaction_id);
        
        return $this->db->execute();
    }

    // Get payment by transaction ID
    public function getPaymentByTransactionId($transaction_id) {
        $this->db->query('SELECT * FROM payment_requests WHERE transaction_id = :transaction_id');
        $this->db->bind(':transaction_id', $transaction_id);
        return $this->db->single();
    }

    public function deletePaymentRequest($id) {
        $this->db->query('DELETE FROM payment_requests WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

    // Get all payment requests with resident names (only paid)
    public function getAllPaymentRequestsWithResidentNames() {
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.status = "paid"
            ORDER BY pr.paid_at DESC
        ');
        
        return $this->db->resultSet();
    }

    // Validate payment request
    public function validatePaymentRequest($request_id, $address) {
        $this->db->query('
            SELECT COUNT(*) as count 
            FROM payment_requests 
            WHERE id = :request_id 
            AND address = :address 
            AND status != "paid"
            AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ');
        
        $this->db->bind(':request_id', $request_id);
        $this->db->bind(':address', $address);
        
        $result = $this->db->single();
        return $result->count > 0;
    }

    // Get resident address by user ID
    public function getResidentAddress($user_id) {
        $this->db->query('SELECT address FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    // Validate payment request for checkout
    public function validatePaymentRequestForCheckout($request_id, $user_id) {
        // Get payment request
        $request = $this->getPaymentRequestById($request_id);
        if (!$request) {
            return false;
        }

        // Get resident address
        $resident = $this->getResidentAddress($user_id);
        if (!$resident) {
            return false;
        }

        // Handle both array and object return types
        $userAddress = is_array($resident) ? $resident['address'] : $resident->address;

        // Check if addresses match
        return $request->address === $userAddress;
    }

    // Get payment history for a specific address (only paid)
    public function getPaymentHistoryByAddress($address) {
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.address = :address
            AND pr.status = "paid"
            ORDER BY pr.paid_at DESC
        ');
        
        $this->db->bind(':address', $address);
        return $this->db->resultSet();
    }

    // Get all payment history (for admins, only paid)
    public function getAllPaymentHistory() {
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.status = "paid"
            ORDER BY pr.paid_at DESC
        ');
        
        return $this->db->resultSet();
    }

    // Get payment details for view/receipt (only paid)
    public function getPaymentDetails($id) {
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name,
                   cb.email as created_by_email
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.id = :id
            AND pr.status = "paid"
        ');
        
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Get pending requests for a specific address
    public function getPendingRequestsByAddress($address) {
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.address = :address
            AND pr.status = "pending"
            ORDER BY pr.created_at DESC
        ');
        
        $this->db->bind(':address', $address);
        return $this->db->resultSet();
    }

    // Get all pending requests (for admins)
    public function getAllPendingRequests() {
        $this->db->query('
            SELECT pr.*, 
                   cb.name as created_by_name
            FROM payment_requests pr
            JOIN users cb ON pr.created_by = cb.id
            WHERE pr.status = "pending"
            ORDER BY pr.created_at DESC
        ');
        
        return $this->db->resultSet();
    }

}
