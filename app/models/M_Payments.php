<?php
class M_Payments {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPaymentsByUserId($userId) {
        $this->db->query('SELECT * FROM payments WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }

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

    public function getPaymentById($id) {
        $this->db->query('SELECT * FROM payments WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function getPaymentsByHomeAddress($homeAddress) {
        $this->db->query('SELECT * FROM payments WHERE home_address = :home_address ORDER BY created_at DESC');
        $this->db->bind(':home_address', $homeAddress);

        return $this->db->resultSet();
    }

    public function getTotalPaymentsByUser($userId) {
        $this->db->query('SELECT SUM(amount) as total FROM payments WHERE user_id = :user_id AND status = "completed"');
        $this->db->bind(':user_id', $userId);

        $result = $this->db->single();
        return $result->total ?? 0;
    }

    public function getTotalPaymentsByHomeAddress($homeAddress) {
        $this->db->query('SELECT SUM(amount) as total FROM payments WHERE home_address = :home_address AND status = "completed"');
        $this->db->bind(':home_address', $homeAddress);

        $result = $this->db->single();
        return $result->total ?? 0;
    }
    
    public function getRecentPayments($limit = 5) {
        $this->db->query('SELECT p.*, u.name as user_name 
                        FROM payments p 
                        LEFT JOIN users u ON p.user_id = u.id 
                        ORDER BY p.created_at DESC 
                        LIMIT :limit');
        
        $this->db->bind(':limit', $limit);
        
        return $this->db->resultSet();
    }

    public function getTotalPaymentsCount() {
        $this->db->query('SELECT COUNT(*) as count FROM payments');
        
        $result = $this->db->single();
        return $result->count ?? 0;
    }
    
    //export
    public function getAllPayments() {
        $this->db->query('SELECT * FROM payments ORDER BY created_at DESC');
        
        return $this->db->resultSet();
    }
    
    
    //chart
    public function getMonthlyPaymentData() {
        $this->db->query('SELECT 
                          MONTH(paid_at) as month, 
                          SUM(amount) as total 
                          FROM payment_requests 
                          WHERE status = "paid" 
                          AND YEAR(paid_at) = YEAR(CURDATE()) 
                          GROUP BY MONTH(paid_at)');
        
        $results = $this->db->resultSet();
        
        $monthlyData = array_fill(0, 12, 0);
        
        foreach ($results as $row) {
            $monthlyData[$row->month - 1] = (float)$row->total;
        }
        
        return $monthlyData;
    }
    
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

    public function getRecentRequestActivity() {
        $this->db->query('SELECT 
                          COUNT(*) as count
                          FROM payment_requests 
                          WHERE paid_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
                          AND status = "paid"');
        
        $result = $this->db->single();
        return is_array($result) ? ($result['count'] ?? 0) : ($result->count ?? 0);
    }

    public function deletePayment($id) {
        $this->db->query('DELETE FROM payments WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

    public function getAllPaymentsWithUserInfo() {
        $this->db->query('SELECT p.*, u.name as user_name 
                        FROM payments p 
                        LEFT JOIN users u ON p.user_id = u.id 
                        ORDER BY p.created_at DESC');
        
        return $this->db->resultSet();
    }

    public function createPaymentRequest($data) {
        $this->db->query('INSERT INTO payment_requests (address, amount, description, due_date, created_by) VALUES (:address, :amount, :description, :due_date, :created_by)');
        
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':due_date', $data['due_date']);
        $this->db->bind(':created_by', $data['created_by']);
        
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllPaymentRequests() {
        $this->db->query('SELECT pr.*, u.name as user_name, cb.name as created_by_name 
                         FROM payment_requests pr 
                         LEFT JOIN users u ON pr.user_id = u.id 
                         LEFT JOIN users cb ON pr.created_by = cb.id 
                         ORDER BY pr.created_at DESC');
        
        return $this->db->resultSet();
    }

    public function getPaymentRequestsByUserId($user_id) {
        $this->db->query('SELECT address FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $resident = $this->db->single();
        
        if (!$resident) {
            return [];
        }
        
        $address = is_array($resident) ? $resident['address'] : $resident->address;
        
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
        
        if (is_array($result)) {
            $result = (object)$result;
        }
        
        return $result;
    }

    public function updatePaymentRequestStatus($id, $status, $transaction_id = null) {
        $this->db->query('UPDATE payment_requests SET status = :status, paid_at = CURRENT_TIMESTAMP, transaction_id = :transaction_id WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->bind(':transaction_id', $transaction_id);
        
        return $this->db->execute();
    }

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

    public function getResidentAddress($user_id) {
        $this->db->query('SELECT address FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function validatePaymentRequestForCheckout($request_id, $user_id) {
        $request = $this->getPaymentRequestById($request_id);
        if (!$request) {
            return false;
        }

        $resident = $this->getResidentAddress($user_id);
        if (!$resident) {
            return false;
        }

        $userAddress = is_array($resident) ? $resident['address'] : $resident->address;

        return $request->address === $userAddress;
    }

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

    //for view/receipt
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
