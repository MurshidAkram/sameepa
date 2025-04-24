<?php

class M_maintenance
{
    private $db;

    public function __construct()
    {
        $this->db = new Database; // Assuming Database is a custom class for database interaction
    }



    //*******************************************************************dashboard****************************************************************** */

    public function getRequestCountsByStatus()
    {
        $this->db->query('
            SELECT ms.status_name, ms.status_id, COUNT(r.request_id) as count
            FROM maintenance_status ms
            LEFT JOIN requests r ON ms.status_id = r.status_id
            GROUP BY ms.status_id, ms.status_name
            ORDER BY ms.status_id
        ');
        
        return $this->db->resultSet();
    }
    
    public function getRequestCountsByType()
    {
        $this->db->query('
            SELECT mt.type_name, COUNT(r.request_id) as count
            FROM maintenance_types mt
            LEFT JOIN requests r ON mt.type_id = r.type_id
            GROUP BY mt.type_id, mt.type_name
        ');
        
        return $this->db->resultSet();
    }
    
    public function getCompletedRequestCountsByType()
    {
        $this->db->query('
            SELECT mt.type_name, COUNT(r.request_id) as count
            FROM maintenance_types mt
            LEFT JOIN requests r ON mt.type_id = r.type_id
            WHERE r.status_id = 3 -- Assuming 4 is the status_id for "completed"
            GROUP BY mt.type_id, mt.type_name
        ');
        
        return $this->db->resultSet();
    }
    


    
    //***************************************maintenance members**********************************************************************************************************

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

//**********************************************resident requests of resident side******************************************************** */

public function getResidentRequests($residentId) {
    $this->db->query('
        SELECT r.*, mt.type_name as type, ms.status_name as status 
        FROM requests r
        JOIN maintenance_types mt ON r.type_id = mt.type_id
        JOIN maintenance_status ms ON r.status_id = ms.status_id
        WHERE r.resident_id = :resident_id
        ORDER BY r.created_at DESC
    ');
    $this->db->bind(':resident_id', $residentId);
    return $this->db->resultSet();
}

public function getMaintenanceTypes() {
    $this->db->query('SELECT * FROM maintenance_types');
    return $this->db->resultSet();
}

public function submitRequest($data) {
    try {
        $this->db->query('
            INSERT INTO requests 
            (resident_id, type_id, description, urgency_level) 
            VALUES (:resident_id, :type_id, :description, :urgency_level)
        ');
        
        $this->db->bind(':resident_id', $data['resident_id']);
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':urgency_level', $data['urgency_level']);
        
        if ($this->db->execute()) {
            return true;
        } else {
            error_log("Database execute failed");
            return false;
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

public function getLastInsertId() {
    return $this->db->lastInsertId();
}

public function getRequestDetails($requestId, $residentId) {
    $this->db->query('
        SELECT r.*, mt.type_name as type, ms.status_name as status 
        FROM requests r
        JOIN maintenance_types mt ON r.type_id = mt.type_id
        JOIN maintenance_status ms ON r.status_id = ms.status_id
        WHERE r.request_id = :request_id AND r.resident_id = :resident_id
    ');
    $this->db->bind(':request_id', $requestId);
    $this->db->bind(':resident_id', $residentId);
    return $this->db->single();
}

public function isRequestEditable($requestId, $residentId) {
    $this->db->query('
        SELECT status_id FROM requests 
        WHERE request_id = :request_id AND resident_id = :resident_id
    ');
    $this->db->bind(':request_id', $requestId);
    $this->db->bind(':resident_id', $residentId);
    
    $result = $this->db->single();
    return ($result && $result->status_id == 1); // Only editable if status is "Pending"
}

public function updateRequest($data) {
    $this->db->query('
        UPDATE requests SET 
        type_id = :type_id, 
        description = :description, 
        urgency_level = :urgency_level 
        WHERE request_id = :request_id
    ');
    
    $this->db->bind(':type_id', $data['type_id']);
    $this->db->bind(':description', $data['description']);
    $this->db->bind(':urgency_level', $data['urgency_level']);
    $this->db->bind(':request_id', $data['request_id']);
    
    return $this->db->execute();
}

public function deleteRequest($requestId) {
    $this->db->query('DELETE FROM requests WHERE request_id = :request_id');
    $this->db->bind(':request_id', $requestId);
    return $this->db->execute();
}



//**********************************************resident requests of maintenance side****************************************************************************************************************************** */

// Methods used by maintenance side
public function getAllRequests() {
    $this->db->query('
        SELECT 
            r.request_id,
            u.name AS resident_name,
            res.address AS resident_address,
            res.phonenumber AS resident_phone,
            mt.type_name,
            r.description,
            r.urgency_level,
            ms.status_name,
            mm.name AS maintainer_name,
            r.status_id
        FROM requests r
        JOIN residents res ON r.resident_id = res.user_id
        JOIN users u ON res.user_id = u.id
        JOIN maintenance_types mt ON r.type_id = mt.type_id
        JOIN maintenance_status ms ON r.status_id = ms.status_id
        LEFT JOIN maintenance_members mm ON r.assigned_maintainer_id = mm.id
        ORDER BY r.created_at DESC
    ');
    
    return $this->db->resultSet();
}

public function getStatuses() {
    $this->db->query('SELECT * FROM maintenance_status');
    return $this->db->resultSet();
}

public function updateRequestStatus($requestId, $statusId) {
    $this->db->query('
        UPDATE requests 
        SET status_id = :status_id 
        WHERE request_id = :request_id
    ');
    $this->db->bind(':status_id', $statusId);
    $this->db->bind(':request_id', $requestId);
    
    return $this->db->execute();
}

public function assignMaintainer($requestId, $maintainerId) {
    $this->db->query('
        UPDATE requests 
        SET 
            assigned_maintainer_id = :maintainer_id,
            status_id = 2 
        WHERE request_id = :request_id');
    $this->db->bind(':maintainer_id', $maintainerId);
    $this->db->bind(':request_id', $requestId);
    
    return $this->db->execute();
}

public function getSpecializations() {
    $this->db->query('SELECT DISTINCT specialization FROM maintenance_members');
    return $this->db->resultSet();
}

public function getStaffBySpecialization($specialization) {
    $this->db->query('
        SELECT id, name, specialization 
        FROM maintenance_members 
        WHERE specialization = :specialization
    ');
    $this->db->bind(':specialization', $specialization);
    
    return $this->db->resultSet();
}
    //*************************************************************************************************************************************************


}

?>