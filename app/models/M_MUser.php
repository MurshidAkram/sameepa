<?php

class M_MUser {
    private $db;

    public function __construct() {
        // Initialize the database connection
        $this->db = new Database;
    }

    /**
     * Get all users
     */
    public function getAllUsers() {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultSet();
    }

    /**
     * Get user by ID
     */
    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Approve user registration
     */
    public function approveUser($userId) {
        $this->db->query("UPDATE users SET status = 'approved' WHERE id = :id");
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    /**
     * Reject user registration
     */
    public function rejectUser($userId) {
        $this->db->query("UPDATE users SET status = 'rejected' WHERE id = :id");
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    /**
     * Delete user by ID
     */
    public function deleteUser($userId) {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    /**
     * Search users based on criteria
     */
    // public function searchUsers($criteria) {
    //     $this->db->query("SELECT * FROM users WHERE name LIKE :criteria OR email LIKE :criteria");
    //     $this->db->bind(':criteria', '%' . $criteria . '%');
    //     return $this->db->resultSet();
    // }
}
