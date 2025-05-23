<?php

class M_security
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
//**************************************Dash board************************************************* */
public function getTodayPasses() {
    $today = date('Y-m-d');
    $this->db->query('SELECT * FROM visitor_passes 
                     WHERE visit_date = :today');
    $this->db->bind(':today', $today);
    return $this->db->resultSet();
}

public function getWeeklyVisitorFlow() {
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime('-6 days'));
    
    $this->db->query('
        SELECT 
            visit_date as date, 
            COUNT(*) as count,
            DAYNAME(visit_date) as day_name
        FROM visitor_passes 
        WHERE visit_date BETWEEN :start_date AND :end_date
        GROUP BY visit_date
        ORDER BY visit_date
    ');
    
    $this->db->bind(':start_date', $startDate);
    $this->db->bind(':end_date', $endDate);
    $results = $this->db->resultSet();
    
    // Format for chart
    $labels = [];
    $data = [];
    
    // Fill all 7 days (even if no data)
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $dayName = date('D', strtotime($date));
        
        $found = false;
        foreach ($results as $row) {
            if ($row->date == $date) {
                $labels[] = $dayName;
                $data[] = $row->count;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $labels[] = $dayName;
            $data[] = 0;
        }
    }
    
    return [
        'labels' => $labels,
        'data' => $data
    ];
}

public function getMonthlyIncidentTrends() {
    $startDate = date('Y-m-01'); // First day of current month
    $endDate = date('Y-m-t');   // Last day of current month
    
    $this->db->query('
        SELECT 
            type,
            COUNT(*) as count
        FROM incident_reports
        WHERE date BETWEEN :start_date AND :end_date
        GROUP BY type
        ORDER BY count DESC
    ');
    
    $this->db->bind(':start_date', $startDate);
    $this->db->bind(':end_date', $endDate);
    $results = $this->db->resultSet();
    
    $labels = [];
    $data = [];
    
    foreach ($results as $row) {
        $labels[] = $row->type;
        $data[] = $row->count;
    }
    
    return [
        'labels' => $labels,
        'data' => $data
    ];
}

public function getTodayDutyOfficers() {
    $today = date('Y-m-d');
    
    $this->db->query('
        SELECT 
            u.id, 
            u.name, 
            ds.name as shift_name,
            ds.start_time,
            ds.end_time
        FROM duty_schedule d
        JOIN users u ON d.user_id = u.id
        JOIN duty_shifts ds ON d.shift_id = ds.id
        WHERE d.duty_date = :today
        ORDER BY ds.start_time
    ');
    
    $this->db->bind(':today', $today);
    return $this->db->resultSet();
}

//****************************************************** Emergency contact******************************************************************* */
public function getAllContactCategories() {
    $this->db->query("SELECT * FROM emergency_categories ORDER BY name");
    return $this->db->resultSet();
}

public function getContactsByCategory($category_id) {
    $this->db->query("SELECT * FROM emergency_contacts 
                     WHERE category_id = :category_id 
                     ORDER BY priority, name");
    $this->db->bind(':category_id', $category_id);
    return $this->db->resultSet();
}

public function addContact($data) {
    $this->db->query("INSERT INTO emergency_contacts 
                     (category_id, name, phone, description) 
                     VALUES (:category_id, :name, :phone, :description)");

    $this->db->bind(':category_id', $data['category_id']);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':phone', $data['phone']);
    $this->db->bind(':description', $data['description']);

    return $this->db->execute();
}

public function updateContact($data) {
    $this->db->query("UPDATE emergency_contacts 
                     SET name = :name, 
                         phone = :phone,
                         description = :description
                     WHERE id = :id");

    $this->db->bind(':id', $data['id']);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':phone', $data['phone']);
    $this->db->bind(':description', $data['description']);

    return $this->db->execute();
}

public function deleteContact($id) {
    $this->db->query("DELETE FROM emergency_contacts WHERE id = :id");
    $this->db->bind(':id', $id);
    return $this->db->execute();
}

//**************************************************** Visitor passes************************************************************************************

public function getVisitorPasses() {
    // Query today's visitor passes with formatted time
    $queryToday = "SELECT 
                    visitor_name,
                    visitor_count,
                    resident_name,
                    DATE_FORMAT(visit_date, '%Y-%m-%d') as visit_date,
                    DATE_FORMAT(visit_time, '%H:%i') as visit_time,
                    duration,
                    purpose
                  FROM visitor_passes 
                  WHERE visit_date = CURDATE()
                  ORDER BY visit_time DESC";
    $this->db->query($queryToday);
    $todayResult = $this->db->resultSet();

    // Query historical visitor passes with formatted date
    $queryHistory = "SELECT 
                    visitor_name,
                    visitor_count,
                    resident_name,
                    purpose,
                    DATE_FORMAT(visit_date, '%M %e, %Y') as formatted_date,
                    DATE_FORMAT(visit_time, '%H:%i') as visit_time,
                    DATE_FORMAT(visit_date, '%Y-%m-%d') as visit_date,
                    duration
                  FROM visitor_passes 
                  WHERE visit_date < CURDATE()
                  ORDER BY visit_date DESC, visit_time DESC
                  LIMIT 100"; // Limit to 100 most recent for performance
    $this->db->query($queryHistory);
    $historyResult = $this->db->resultSet();

    return [
        'todayPasses' => $todayResult,
        'historyPasses' => $historyResult,
        'status' => 'success'
    ];
}


public function addVisitorPass($data) {
    // Additional validation at model level
    $currentDateTime = new DateTime();
    $visitDateTime = new DateTime($data['visit_date'] . ' ' . $data['visit_time']);
    
    if ($visitDateTime < $currentDateTime) {
        return false;
    }

    $this->db->query("INSERT INTO Visitor_Passes (visitor_name, visitor_count, resident_name, visit_date, visit_time, duration, purpose) 
                      VALUES (:visitor_name, :visitor_count, :resident_name, :visit_date, :visit_time, :duration, :purpose)");

    // Bind parameters
    $this->db->bind(':visitor_name', $data['visitor_name']);
    $this->db->bind(':visitor_count', $data['visitor_count']);
    $this->db->bind(':resident_name', $data['resident_name']);
    $this->db->bind(':visit_date', $data['visit_date']);
    $this->db->bind(':visit_time', $data['visit_time']);
    $this->db->bind(':duration', $data['duration']);
    $this->db->bind(':purpose', $data['purpose']);

    // Execute the query
    if ($this->db->execute()) {
        return $this->db->lastInsertId();
    } else {
        return false;
    }
}


//***************************************************resident contact*********************************** */
public function searchResidentContacts($query)
{
    $this->db->query("SELECT 
                        u.name,
                        u.email,
                        r.phonenumber,
                        r.address,
                        u.id as user_id
                      FROM users u
                      JOIN residents r ON u.id = r.user_id
                      WHERE (u.name LIKE :q OR r.address LIKE :q)
                        AND u.role_id = 1"); // Assuming role_id 1 is for residents

    $this->db->bind(':q', '%' . $query . '%');
    return $this->db->resultSet();
}



// ************************************manage incident reports**********************************

public function getAllIncidents() {
    $this->db->query('SELECT * FROM incident_reports ORDER BY date DESC, time DESC');
    $results = $this->db->resultSet();
    
    return array_map(function($incident) {
        return [
            'report_id' => $incident->report_id,
            'type' => $incident->type,
            'date' => $incident->date,
            'time' => $incident->time,
            'location' => $incident->location,
            'description' => $incident->description,
            'status' => $incident->status,
            'created_at' => $incident->created_at,
            'updated_at' => $incident->updated_at
        ];
    }, $results);
}

public function addIncident($data) {
    $this->db->query("INSERT INTO incident_reports 
                     (type, date, time, location, description, status)
                     VALUES (:type, :date, :time, :location, :description, :status)");

    $this->db->bind(':type', $data['type']);
    $this->db->bind(':date', $data['date']);
    $this->db->bind(':time', $data['time']);
    $this->db->bind(':location', $data['location']);
    $this->db->bind(':description', $data['description']);
    $this->db->bind(':status', $data['status']);

    if ($this->db->execute()) {
        return $this->db->lastInsertId();
    }
    return false;
}

public function updateIncidentStatus($report_id, $status) {
    $this->db->query('UPDATE incident_reports 
                     SET status = :status
                     WHERE report_id = :report_id');

    $this->db->bind(':report_id', (int)$report_id);
    $this->db->bind(':status', $status);

    return $this->db->execute();
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
