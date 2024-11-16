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
    
    public function validateUser($userId) {
        $this->db->query('SELECT id FROM users WHERE id = :id');
        $this->db->bind(':id', $userId);
        return $this->db->single();
    }

    public function createBooking($data) {
        $userId = $_SESSION['user_id'];
        $userName = $_SESSION['name'];
        
        $this->db->query('INSERT INTO bookings (facility_id, facility_name, booking_date, booking_time, duration, booked_by, user_id) 
                          VALUES (:facility_id, :facility_name, :booking_date, :booking_time, :duration, :booked_by, :user_id)');
                          
        $this->db->bind(':facility_id', $data['facility_id']);
        $this->db->bind(':facility_name', $data['facility_name']);
        $this->db->bind(':booking_date', $data['booking_date']);
        $this->db->bind(':booking_time', $data['booking_time']);
        $this->db->bind(':duration', $data['duration']);
        $this->db->bind(':booked_by', $userName);
        $this->db->bind(':user_id', $userId);
    
        return $this->db->execute();
    }
    
    
    public function getBookingsByDate($facility_id, $date) {
        $this->db->query('SELECT * FROM bookings WHERE facility_id = :facility_id AND booking_date = :date');
        $this->db->bind(':facility_id', $facility_id);
        $this->db->bind(':date', $date);
        return $this->db->resultSet();
    }
    
    public function getUserBookingsByDate($userId, $facilityId, $date) {
        $this->db->query('SELECT * FROM bookings 
                          WHERE user_id = :userId 
                          AND facility_id = :facilityId 
                          AND booking_date = :date');
        
        $this->db->bind(':userId', $userId);
        $this->db->bind(':facilityId', $facilityId);
        $this->db->bind(':date', $date);
        
        return $this->db->resultSet();
    }
    
    
    public function getResidentId($userId) {
        $this->db->query('SELECT id FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function getallmyBookings($user_id) {
        $this->db->query('SELECT b.*, f.name as facility_name 
                          FROM bookings b 
                          JOIN facilities f ON b.facility_id = f.id 
                          WHERE b.user_id = :user_id 
                          ORDER BY b.booking_date DESC');
        
        $this->db->bind(':user_id', $user_id);
        
        return $this->db->resultSet();
    }
    
    public function getAllBookings() {
        $this->db->query('SELECT b.*, f.name as facility_name 
                          FROM bookings b 
                          JOIN facilities f ON b.facility_id = f.id 
                          ORDER BY b.booking_date DESC');
        return $this->db->resultSet();
    }
    public function updateBooking($data) {
        $this->db->query('UPDATE bookings SET booking_date = :booking_date, 
                          booking_time = :booking_time, duration = :duration 
                          WHERE id = :id');
    
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':booking_date', $data['booking_date']);
        $this->db->bind(':booking_time', $data['booking_time']);
        $this->db->bind(':duration', $data['duration']);
    
        return $this->db->execute();
    }
    public function deleteBooking($id) {
        $this->db->query('DELETE FROM bookings WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
}

