<?php

class M_maintenance
{
    private $db;

    public function __construct()
    {
        $this->db = new Database; // Assuming Database is a custom class for database interaction
    }

    //*************************************************************************************************************************************************

    // Fetch all maintenance members
    public function getAllMembers()
    {
        $this->db->query("SELECT * FROM maintenance_members");
        return $this->db->resultSet();
    }

    // Add new maintenance member to the database
    public function addMember($data)
    {
        $this->db->query("INSERT INTO maintenance_members (name, specialization, experience,  profile_image,phone_number) 
                      VALUES (:name, :specialization, :experience,  :profile_image,:phone_number)");

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':experience', $data['experience']);
        $this->db->bind(':profile_image', $data['profile_image']);
        $this->db->bind(':phone_number', $data['phone_number']);

        // Execute query
        return $this->db->execute();
    }


    public function updateMember($data)
    {
        $sql = "UPDATE maintenance_members 
            SET name = :name, specialization = :specialization, experience = :experience, phone_number = :phone_number";
        if ($data['profile_image']) {
            $sql .= ", profile_image = :profile_image";
        }
        $sql .= " WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':experience', $data['experience']);
        $this->db->bind(':phone_number', $data['phone_number']);
        if ($data['profile_image']) {
            $this->db->bind(':profile_image', $data['profile_image']);
        }

        return $this->db->execute();
    }



    // Delete a maintenance member from the database
    public function deleteMember($id)
    {
        $this->db->query("DELETE FROM maintenance_members WHERE id = :id");
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }


//**********************************************resident requests****************************************************************************************************************************** */
    
// In your Maintenance model
public function getAllRequests() {
    $this->db->query('
        SELECT 
            mr.*, 
            mt.type_name, 
            rs.status_name, 
            CONCAT(u.first_name, " ", u.last_name) AS resident_name,
            r.unit_number,
            ms.staff_id,
            CONCAT(us.first_name, " ", us.last_name) AS staff_name
        FROM 
            maintenance_requests mr
        JOIN 
            maintenance_types mt ON mr.type_id = mt.type_id
        JOIN 
            request_statuses rs ON mr.status_id = rs.status_id
        JOIN 
            residents r ON mr.resident_id = r.resident_id
        JOIN 
            users u ON r.user_id = u.user_id
        LEFT JOIN 
            request_assignments ra ON mr.request_id = ra.request_id
        LEFT JOIN 
            maintenance_staff ms ON ra.staff_id = ms.staff_id
        LEFT JOIN 
            users us ON ms.user_id = us.user_id
        ORDER BY 
            mr.created_at DESC
    ');
    
    return $this->db->resultSet();
}

public function getMaintenanceTypes() {
    $this->db->query('SELECT * FROM maintenance_types');
    return $this->db->resultSet();
}

public function getRequestStatuses() {
    $this->db->query('SELECT * FROM request_statuses');
    return $this->db->resultSet();
}

public function getMaintenanceStaff() {
    $this->db->query('
        SELECT 
            ms.*, 
            CONCAT(u.first_name, " ", u.last_name) AS staff_name
        FROM 
            maintenance_staff ms
        JOIN 
            users u ON ms.user_id = u.user_id
        WHERE 
            ms.is_active = 1
    ');
    return $this->db->resultSet();
}

public function updateDueDate($requestId, $dueDate) {
    $this->db->query('
        UPDATE request_assignments 
        SET due_date = :due_date 
        WHERE request_id = :request_id
    ');
    
    $this->db->bind(':request_id', $requestId);
    $this->db->bind(':due_date', $dueDate);
    
    return $this->db->execute();
}

public function assignMaintainer($requestId, $staffId, $dueDate) {
    // Check if assignment already exists
    $this->db->query('SELECT * FROM request_assignments WHERE request_id = :request_id');
    $this->db->bind(':request_id', $requestId);
    $assignment = $this->db->single();
    
    if($assignment) {
        // Update existing assignment
        $this->db->query('
            UPDATE request_assignments 
            SET staff_id = :staff_id, 
                due_date = :due_date,
                assigned_date = CURRENT_TIMESTAMP
            WHERE request_id = :request_id
        ');
    } else {
        // Create new assignment
        $this->db->query('
            INSERT INTO request_assignments 
            (request_id, staff_id, due_date) 
            VALUES 
            (:request_id, :staff_id, :due_date)
        ');
    }
    
    $this->db->bind(':request_id', $requestId);
    $this->db->bind(':staff_id', $staffId);
    $this->db->bind(':due_date', $dueDate);
    
    // Update request status to "Assigned"
    if($this->db->execute()) {
        $this->db->query('
            UPDATE maintenance_requests 
            SET status_id = 2 
            WHERE request_id = :request_id
        ');
        $this->db->bind(':request_id', $requestId);
        return $this->db->execute();
    }
    
    return false;
}

public function getRequestHistory() {
    $this->db->query('
        SELECT 
            r.resident_id,
            CONCAT(u.first_name, " ", u.last_name) AS resident_name,
            COUNT(mr.request_id) AS total_requests,
            GROUP_CONCAT(DISTINCT mt.type_name ORDER BY mt.type_name SEPARATOR ", ") AS common_issues,
            AVG(DATEDIFF(ra.completion_date, ra.assigned_date)) AS avg_completion_time
        FROM 
            residents r
        JOIN 
            users u ON r.user_id = u.user_id
        LEFT JOIN 
            maintenance_requests mr ON r.resident_id = mr.resident_id
        LEFT JOIN 
            maintenance_types mt ON mr.type_id = mt.type_id
        LEFT JOIN 
            request_assignments ra ON mr.request_id = ra.request_id
        GROUP BY 
            r.resident_id
        ORDER BY 
            total_requests DESC
    ');
    
    return $this->db->resultSet();
}

    
 //*************************************************************************************************************************************************




}
