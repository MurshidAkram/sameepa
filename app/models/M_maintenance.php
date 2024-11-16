<?php
class M_maintenance {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get all maintenance members
    public function getAllMembers() {
        $this->db->query("SELECT * FROM maintenance_members");
        return $this->db->resultSet();
    }

    // Get a member by ID
    public function getMemberById($id) {
        $this->db->query("SELECT * FROM maintenance_members WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Add a new member
    public function addMember($data) {
        $this->db->query("INSERT INTO maintenance_members (name, specialization, experience, certifications, profile_image) VALUES (:name, :specialization, :experience, :certifications, :profile_image)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':experience', $data['experience']);
        $this->db->bind(':certifications', $data['certifications']);
        $this->db->bind(':profile_image', $data['profile_image']);
        return $this->db->execute();
    }

    // Update a member
    public function updateMember($data) {
        $this->db->query("UPDATE maintenance_members SET name = :name, specialization = :specialization, experience = :experience, certifications = :certifications, profile_image = :profile_image WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':experience', $data['experience']);
        $this->db->bind(':certifications', $data['certifications']);
        $this->db->bind(':profile_image', $data['profile_image']);
        return $this->db->execute();
    }

    // Delete a member
    public function deleteMember($id) {
        $this->db->query("DELETE FROM maintenance_members WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
