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
        $this->db->query('INSERT INTO payments (user_id, amount, description, transaction_id, status, created_at) 
                          VALUES (:user_id, :amount, :description, :transaction_id, :status, NOW())');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
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
    
    public function getPaymentById($id) {
        $this->db->query('SELECT * FROM payments WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
}
