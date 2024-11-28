<?php
class M_Facilities {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllFacilities() {
        $this->db->query('SELECT f.*, a.user_id, u.name as creator_name 
                         FROM facilities f 
                         JOIN admins a ON f.created_by = a.id
                         JOIN users u ON a.user_id = u.id 
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
        $this->db->query('SELECT id FROM admins WHERE user_id = :user_id 
                          UNION 
                          SELECT id FROM superadmins WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result['id'] ?? null;
    }
    

    public function getFacilityById($id) {
        $this->db->query('SELECT f.*, a.user_id, u.name as creator_name 
                         FROM facilities f 
                         JOIN admins a ON f.created_by = a.id
                         JOIN users u ON a.user_id = u.id 
                         WHERE f.id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result ? $result : null;
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
    public function findFacilityByName($name) {
        $this->db->query('SELECT * FROM facilities WHERE name = :name');
        $this->db->bind(':name', $name);
        return $this->db->single();
    }
    public function findFacilityByNameExcept($name, $currentId) {
        $this->db->query('SELECT * FROM facilities WHERE name = :name AND id != :current_id');
        $this->db->bind(':name', $name);
        $this->db->bind(':current_id', $currentId);
        return $this->db->single();
    }
    public function checkOverlappingBookings($facilityId, $date, $startTime, $duration) {
        $this->db->query('SELECT * FROM bookings 
                          WHERE facility_id = :facility_id 
                          AND booking_date = :date 
                          AND (
                              (TIME_TO_SEC(:start_time) BETWEEN 
                                  TIME_TO_SEC(booking_time) 
                                  AND TIME_TO_SEC(booking_time) + (duration * 3600))
                              OR 
                              (TIME_TO_SEC(:start_time) + (:duration * 3600) BETWEEN 
                                  TIME_TO_SEC(booking_time) 
                                  AND TIME_TO_SEC(booking_time) + (duration * 3600))
                              OR 
                              (TIME_TO_SEC(:start_time) <= TIME_TO_SEC(booking_time) 
                               AND TIME_TO_SEC(:start_time) + (:duration * 3600) >= TIME_TO_SEC(booking_time) + (duration * 3600))
                          )');
        
        $this->db->bind(':facility_id', $facilityId);
        $this->db->bind(':date', $date);
        $this->db->bind(':start_time', $startTime);
        $this->db->bind(':duration', $duration);
        
        return $this->db->resultSet();
    }    
    
}

