<?php
class M_Facilities
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllFacilities()
    {
        $this->db->query('SELECT f.*, a.user_id, u.name as creator_name 
                         FROM facilities f 
                         JOIN admins a ON f.created_by = a.id
                         JOIN users u ON a.user_id = u.id 
                         ORDER BY f.created_at DESC');
        return $this->db->resultSet();
    }

    public function createFacility($data)
    {
        $this->db->query('INSERT INTO facilities (name, description, capacity, status, image_data, image_type, created_by) 
                     VALUES (:name, :description, :capacity, :status, :image_data, :image_type, :created_by)');

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':capacity', $data['capacity']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':image_data', $data['image_data']);
        $this->db->bind(':image_type', $data['image_type']);
        $this->db->bind(':created_by', $data['created_by']);

        return $this->db->execute();
    }

    public function getAdminIdByUserId($userId)
    {
        $this->db->query('SELECT id FROM admins WHERE user_id = :user_id 
                          UNION 
                          SELECT id FROM superadmins WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result['id'] ?? null;
    }


    public function getFacilityById($id)
    {
        $this->db->query('SELECT f.*, a.user_id, u.name as creator_name 
                         FROM facilities f 
                         JOIN admins a ON f.created_by = a.id
                         JOIN users u ON a.user_id = u.id 
                         WHERE f.id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result ? $result : null;
    }


    public function deleteFacility($id)
    {
        $this->db->query('DELETE FROM facilities WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function updateFacility($data)
    {
        // Start with the base SQL without image fields
        $sql = 'UPDATE facilities SET 
            name = :name, 
            description = :description, 
            capacity = :capacity, 
            status = :status';

        // If there's a new image, add image fields to the SQL
        if (!empty($data['image_data'])) {
            $sql .= ', image_data = :image_data, image_type = :image_type';
        }

        // Complete the SQL
        $sql .= ' WHERE id = :id';

        $this->db->query($sql);

        // Bind the standard values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':capacity', $data['capacity']);
        $this->db->bind(':status', $data['status']);

        // If there's a new image, bind the image values
        if (!empty($data['image_data'])) {
            $this->db->bind(':image_data', $data['image_data']);
            $this->db->bind(':image_type', $data['image_type']);
        }

        // Execute
        return $this->db->execute();
    }

    public function getFacilityImage($id)
    {
        $this->db->query('SELECT image_data, image_type FROM facilities WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function validateUser($userId)
    {
        $this->db->query('SELECT id FROM users WHERE id = :id');
        $this->db->bind(':id', $userId);
        return $this->db->single();
    }

    public function createBooking($data)
    {
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


    public function getBookingsByDate($facility_id, $date)
    {
        $this->db->query('SELECT * FROM bookings WHERE facility_id = :facility_id AND booking_date = :date');
        $this->db->bind(':facility_id', $facility_id);
        $this->db->bind(':date', $date);
        return $this->db->resultSet();
    }

    public function getUserBookingsByDate($userId, $facilityId, $date)
    {
        $this->db->query('SELECT * FROM bookings 
                          WHERE user_id = :userId 
                          AND facility_id = :facilityId 
                          AND booking_date = :date');

        $this->db->bind(':userId', $userId);
        $this->db->bind(':facilityId', $facilityId);
        $this->db->bind(':date', $date);

        return $this->db->resultSet();
    }


    public function getResidentId($userId)
    {
        $this->db->query('SELECT id FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function getallmyBookings($user_id)
    {
        $this->db->query('SELECT b.*, f.name as facility_name 
                          FROM bookings b 
                          JOIN facilities f ON b.facility_id = f.id 
                          WHERE b.user_id = :user_id 
                          ORDER BY b.booking_date DESC');

        $this->db->bind(':user_id', $user_id);

        return $this->db->resultSet();
    }

    public function getAllBookings()
    {
        $this->db->query('SELECT b.*, f.name as facility_name 
                          FROM bookings b 
                          JOIN facilities f ON b.facility_id = f.id 
                          ORDER BY b.booking_date DESC');
        return $this->db->resultSet();
    }
    public function updateBooking($data)
    {
        $this->db->query('UPDATE bookings SET 
                          booking_date = :booking_date, 
                          booking_time = :booking_time, 
                          duration = :duration
                          WHERE id = :id');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':booking_date', $data['booking_date']);
        $this->db->bind(':booking_time', $data['booking_time']);
        $this->db->bind(':duration', $data['duration']);

        return $this->db->execute();
    }

    public function deleteBooking($id)
    {
        $this->db->query('DELETE FROM bookings WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    public function findFacilityByName($name)
    {
        $this->db->query('SELECT * FROM facilities WHERE name = :name');
        $this->db->bind(':name', $name);
        return $this->db->single();
    }
    public function findFacilityByNameExcept($name, $id)
    {
        $this->db->query('SELECT * FROM facilities WHERE name = :name AND id != :id');
        $this->db->bind(':name', $name);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function getBookedTimesByDate($facilityId, $date)
    {
        $this->db->query('SELECT booking_time, duration, booked_by, user_id 
                          FROM bookings 
                          WHERE facility_id = :facility_id 
                          AND booking_date = :date
                          ORDER BY booking_time ASC');

        $this->db->bind(':facility_id', $facilityId);
        $this->db->bind(':date', $date);

        return $this->db->resultSet();
    }

    public function checkBookingOverlap($facilityId, $date, $startTime, $duration, $excludeBookingId = null)
    {
        $query = 'SELECT * FROM bookings 
                  WHERE facility_id = :facility_id 
                  AND booking_date = :date 
                  AND id != :exclude_id
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
                      )';

        $this->db->query($query);

        $this->db->bind(':facility_id', $facilityId);
        $this->db->bind(':date', $date);
        $this->db->bind(':start_time', $startTime);
        $this->db->bind(':duration', $duration);
        $this->db->bind(':exclude_id', $excludeBookingId ?? 0);

        return $this->db->single();
    }

    public function getActiveBookingsCount()
    {
        $this->db->query("SELECT COUNT(*) as count FROM bookings 
                          WHERE booking_date >= CURDATE() 
                          OR (booking_date = CURDATE() AND booking_time >= CURTIME())");

        $result = $this->db->single();
        return $result['count'];
    }


    public function hasActiveBookings($facilityId)
    {
        $this->db->query('SELECT COUNT(*) as count FROM bookings 
                        WHERE facility_id = :facility_id 
                        AND booking_date >= CURDATE()');
        $this->db->bind(':facility_id', $facilityId);
        $result = $this->db->single();
        return $result['count'] > 0;
    }

    public function searchFacilities($searchTerm)
    {
        $this->db->query('SELECT * FROM facilities 
                        WHERE name LIKE :search 
                        OR description LIKE :search');
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }

    public function filterFacilitiesByStatus($status)
    {
        if ($status === 'all') {
            return $this->getAllFacilities();
        }

        $this->db->query('SELECT * FROM facilities WHERE status = :status');
        $this->db->bind(':status', $status);
        return $this->db->resultSet();
    }

    public function getTodaysBookings()
    {
        $today = date('2025-04-24');

        $this->db->query("SELECT 
                            booking_time as time,
                            facility_name,
                            duration,
                            booked_by
                          FROM bookings 
                          WHERE booking_date = :today
                          ORDER BY booking_time ASC");

        $this->db->bind(':today', $today);
    }

    public function getBookingById($id)
    {
        $this->db->query('SELECT * FROM bookings WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getTodayBookings()
    {
        $this->db->query('SELECT b.*, f.name as facility_name 
                          FROM bookings b 
                          JOIN facilities f ON b.facility_id = f.id 
                          WHERE b.booking_date = CURDATE()
                          ORDER BY b.booking_time ASC');
        return $this->db->resultSet();
    }
}
