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
        $this->db->query('INSERT INTO payments (user_id, home_address, amount, description, transaction_id, status, created_at) 
                          VALUES (:user_id, :home_address, :amount, :description, :transaction_id, :status, NOW())');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':home_address', $data['home_address']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':transaction_id', $data['transaction_id']);
        $this->db->bind(':status', $data['status']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
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
    
    // Get all payments with pagination and user information
    public function getAllPaymentsPaginated($offset, $limit) {
        $this->db->query('SELECT p.*, u.name as user_name 
                          FROM payments p 
                          LEFT JOIN users u ON p.user_id = u.id 
                          ORDER BY p.created_at DESC 
                          LIMIT :offset, :limit');
        
        $this->db->bind(':offset', $offset);
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
                          MONTH(created_at) as month, 
                          SUM(amount) as total 
                          FROM payments 
                          WHERE status = "completed" 
                          AND YEAR(created_at) = YEAR(CURDATE()) 
                          GROUP BY MONTH(created_at)');
        
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
                          DAYNAME(created_at) as day_name, 
                          COUNT(*) as payment_count
                          FROM payments 
                          WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
                          AND YEAR(created_at) = YEAR(CURRENT_DATE())
                          GROUP BY DAYNAME(created_at)
                          ORDER BY payment_count DESC
                          LIMIT 1');
        
        $result = $this->db->single();
        // Check if result is an array and access it accordingly
        if ($result && is_array($result)) {
            return $result['day_name'] ?? 'N/A';
        } elseif ($result && is_object($result)) {
            return $result->day_name ?? 'N/A';
        }
        return 'N/A';
    }

    // Get payment count for the current month
    public function getPaymentCountThisMonth() {
        $this->db->query('SELECT 
                          COUNT(*) as count
                          FROM payments 
                          WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
                          AND YEAR(created_at) = YEAR(CURRENT_DATE())');
        
        $result = $this->db->single();
        // Check if result is an array and access it accordingly
        if ($result && is_array($result)) {
            return $result['count'] ?? 0;
        } elseif ($result && is_object($result)) {
            return $result->count ?? 0;
        }
        return 0;
    }

    // Get total payment amount for the current month
    public function getTotalAmountThisMonth() {
        $this->db->query('SELECT 
                          SUM(amount) as total
                          FROM payments 
                          WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
                          AND YEAR(created_at) = YEAR(CURRENT_DATE())
                          AND status = "completed"');
        
        $result = $this->db->single();
        // Check if result is an array and access it accordingly
        if ($result && is_array($result)) {
            return $result['total'] ?? 0;
        } elseif ($result && is_object($result)) {
            return $result->total ?? 0;
        }
        return 0;
    }

    // Get recent payment activity (last 7 days)
    public function getRecentPaymentActivity() {
        $this->db->query('SELECT 
                          COUNT(*) as count
                          FROM payments 
                          WHERE created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)');
        
        $result = $this->db->single();
        // Check if result is an array and access it accordingly
        if ($result && is_array($result)) {
            return $result['count'] ?? 0;
        } elseif ($result && is_object($result)) {
            return $result->count ?? 0;
        }
        return 0;
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

}
