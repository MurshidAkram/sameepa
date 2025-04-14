<?php
class M_Resident {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * Get resident information by user ID
     * 
     * @param int $userId The user ID
     * @return object|false Resident object or false if not found
     */
    public function getResidentByUserId($userId) {
        $this->db->query('SELECT * FROM Residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
    
    /**
     * Create a new resident record
     * 
     * @param array $data Resident data
     * @return bool True on success, false on failure
     */
    public function createResident($data) {
        $this->db->query('INSERT INTO Residents (user_id, address, phonenumber) 
                          VALUES (:user_id, :address, :phonenumber)');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':phonenumber', $data['phonenumber']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Update resident information
     * 
     * @param array $data Resident data
     * @return bool True on success, false on failure
     */
    public function updateResident($data) {
        $this->db->query('UPDATE Residents SET 
                          address = :address, 
                          phonenumber = :phonenumber 
                          WHERE user_id = :user_id');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':phonenumber', $data['phonenumber']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Get all residents
     * 
     * @return array Array of resident objects
     */
    public function getAllResidents() {
        $this->db->query('SELECT r.*, u.name, u.email 
                          FROM Residents r 
                          JOIN users u ON r.user_id = u.id 
                          ORDER BY u.name');
        
        return $this->db->resultSet();
    }
    
    /**
     * Delete a resident
     * 
     * @param int $id Resident ID
     * @return bool True on success, false on failure
     */
    public function deleteResident($id) {
        $this->db->query('DELETE FROM Residents WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
}
