<?php

class M_admin_security_duties
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

//********************************************manage duty shedule*********************************************************** */

    // Get all security officers (users with role_id = 5)
    public function getSecurityOfficers() {
        $this->db->query('SELECT id, name FROM users WHERE role_id = 5 ORDER BY name');
        return $this->db->resultSet();
    }

    // Get all duties for a specific officer
    public function getOfficerDuties($officerId) {
        $this->db->query('
            SELECT ds.id, ds.duty_date, s.name as shift_name, s.start_time, s.end_time 
            FROM duty_schedule ds
            JOIN duty_shifts s ON ds.shift_id = s.id
            WHERE ds.user_id = :officerId
            ORDER BY ds.duty_date DESC
        ');
        $this->db->bind(':officerId', $officerId);
        return $this->db->resultSet();
    }

    // Check if officer is already scheduled on a specific date
    public function isOfficerScheduled($officerId, $date) {
        $this->db->query('SELECT id FROM duty_schedule WHERE user_id = :officerId AND duty_date = :date');
        $this->db->bind(':officerId', $officerId);
        $this->db->bind(':date', $date);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Get count of officers assigned to a specific shift on a date
    public function getShiftCount($date, $shiftId) {
        $this->db->query('SELECT COUNT(*) as count FROM duty_schedule WHERE duty_date = :date AND shift_id = :shiftId');
        $this->db->bind(':date', $date);
        $this->db->bind(':shiftId', $shiftId);
        $row = $this->db->single();
        return $row->count;
    }

    // Add a new duty assignment
    public function addDuty($data) {
        $this->db->query('INSERT INTO duty_schedule (user_id, shift_id, duty_date) VALUES (:user_id, :shift_id, :duty_date)');
        $this->db->bind(':user_id', $data['officer_id']);
        $this->db->bind(':shift_id', $data['shift_id']);
        $this->db->bind(':duty_date', $data['duty_date']);

        return $this->db->execute();
    }


    // Update a duty assignment
public function UpdateShift($officer_id, $duty_date, $new_shift_id) {
    $this->db->query('
        UPDATE duty_schedule 
        SET shift_id = :new_shift_id
        WHERE user_id = :officer_id 
        AND duty_date = :duty_date
    ');
    $this->db->bind(':officer_id', $officer_id);
    $this->db->bind(':duty_date', $duty_date);
    $this->db->bind(':new_shift_id', $new_shift_id);

    return $this->db->execute();
}

// Check if shift is full on a specific date
public function isShiftFull($shift_id, $duty_date) {
    $this->db->query('
        SELECT COUNT(*) as count 
        FROM duty_schedule 
        WHERE shift_id = :shift_id 
        AND duty_date = :duty_date
    ');
    $this->db->bind(':shift_id', $shift_id);
    $this->db->bind(':duty_date', $duty_date);
    $row = $this->db->single();
    return $row->count >= 3; // Assuming max 3 officers per shift
}


    // Delete a duty assignment
    public function DeleteDuty($user_id, $duty_date) {
        $this->db->query('DELETE FROM duty_schedule WHERE user_id = :user_id AND duty_date = :duty_date');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':duty_date', $duty_date);
        return $this->db->execute();
    }
    

    // Get today's duty schedule
    public function getTodaySchedule() {
        $today = date('Y-m-d');
        $this->db->query('
            SELECT u.id as officer_id, u.name as officer_name, s.name as shift_name, s.start_time, s.end_time 
            FROM duty_schedule ds
            JOIN users u ON ds.user_id = u.id
            JOIN duty_shifts s ON ds.shift_id = s.id
            WHERE ds.duty_date = :today
            ORDER BY s.start_time, u.name
        ');
        $this->db->bind(':today', $today);
        return $this->db->resultSet();
    }

    // Get duty schedule for a specific date range (for calendar)
    public function getScheduleForPeriod($startDate, $endDate) {
        $this->db->query('
            SELECT ds.duty_date, ds.shift_id, s.name as shift_name, 
                   s.start_time, s.end_time, 
                   GROUP_CONCAT(u.name ORDER BY u.name SEPARATOR ", ") as officers
            FROM duty_schedule ds
            JOIN duty_shifts s ON ds.shift_id = s.id
            JOIN users u ON ds.user_id = u.id
            WHERE ds.duty_date BETWEEN :startDate AND :endDate
            GROUP BY ds.duty_date, ds.shift_id, s.name, s.start_time, s.end_time
            ORDER BY ds.duty_date, s.start_time
        ');
        $this->db->bind(':startDate', $startDate);
        $this->db->bind(':endDate', $endDate);
        return $this->db->resultSet();
    }

    // Get all available shifts
    public function getShifts() {
        $this->db->query('SELECT * FROM duty_shifts ORDER BY start_time');
        return $this->db->resultSet();
    }
}

?>
