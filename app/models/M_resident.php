




















<?php
class M_resident {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getResidentIdByUserId($userId) {
        $this->db->query('SELECT id FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
    
        $row = $this->db->single();
    
        if (is_object($row)) {
            return $row->id;
        } elseif (is_array($row)) {
            return $row['id'];
        } else {
            return false;
        }
    }
    

    public function getResidentDetails($residentId) {
        $this->db->query('
            SELECT r.*, u.name, u.email 
            FROM residents r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.id = :resident_id
        ');
        $this->db->bind(':resident_id', $residentId);
        
        return $this->db->single();
    }

    public function getResidentById($userId) {
        $this->db->query('SELECT * FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }
}

   
?>
