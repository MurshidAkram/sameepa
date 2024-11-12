<?php
class M_Facilities {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllFacilities() {
        $this->db->query('SELECT f.*, u.name as creator_name 
                         FROM facilities f 
                         JOIN users u ON f.created_by = u.id 
                         ORDER BY f.created_at DESC');
        return $this->db->resultSet();
    }

    public function createFacility($data) {
        $this->db->query('INSERT INTO facilities (name, description, capacity, status, created_by) 
                         VALUES (:name, :description, :capacity, :status, :created_by)');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':capacity', $data['capacity']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':created_by', $data['created_by']);

        return $this->db->execute();
    }

    public function getAdminIdByUserId($userId) {
        $this->db->query('SELECT id FROM admins WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result['id'] ?? null;
    }

    public function getFacilityById($id) {
        $this->db->query('SELECT f.*, u.name as creator_name 
                         FROM facilities f 
                         JOIN users u ON f.created_by = u.id 
                         WHERE f.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function deleteFacility($id) {
        $this->db->query('DELETE FROM facilities WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    public function updateFacility($data) {
        $this->db->query('UPDATE facilities SET name = :name, description = :description, capacity = :capacity, status = :status WHERE id = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':capacity', $data['capacity']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    

}

