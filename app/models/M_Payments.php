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

    // Update payment status
    public function updatePaymentStatus($id, $status) {
        $this->db->query('UPDATE payments SET status = :status WHERE id = :id');
        
        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
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
}
