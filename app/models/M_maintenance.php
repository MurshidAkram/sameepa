<?php

class M_maintenance
{
    private $db;

    public function __construct()
    {
        $this->db = new Database; // Assuming Database is a custom class for database interaction
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


//**********************************************resident requests****************************************************************************************************************************** */
// Submit a new maintenance request
    public function submitRequest($data) {
        $this->db->query('INSERT INTO maintenance_requests 
                          (resident_id, type_id, description, urgency_level) 
                          VALUES (:resident_id, :type_id, :description, :urgency_level)');
        
        // Bind values
        $this->db->bind(':resident_id', $data['resident_id']);
        $this->db->bind(':type_id', $data['requestType']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':urgency_level', $data['urgency']);
        
        // Execute
        return $this->db->execute();
    }

    // Get all active maintenance requests
    public function getAllRequests() {
        $this->db->query('SELECT 
                            r.request_id,
                            u.name AS resident_name,
                            res.address AS resident_address,
                            res.phonenumber AS resident_phone,
                            t.type_name,
                            r.description,
                            r.urgency_level,
                            s.status_name,
                            s.status_id,
                            m.id AS maintainer_id,
                            m.name AS maintainer_name,
                            r.due_date,
                            r.created_at
                          FROM maintenance_requests r
                          JOIN users u ON r.resident_id = u.id
                          JOIN residents res ON u.id = res.user_id
                          JOIN maintenance_types t ON r.type_id = t.type_id
                          JOIN maintenance_statuses s ON r.status_id = s.status_id
                          LEFT JOIN maintenance_members m ON r.maintainer_id = m.id
                          WHERE r.status_id IN (1, 2) -- Pending or In Progress
                          ORDER BY 
                            CASE r.urgency_level 
                              WHEN "high" THEN 1 
                              WHEN "medium" THEN 2 
                              WHEN "low" THEN 3 
                            END,
                            r.created_at DESC');
        
        return $this->db->resultSet();
    }

    // Get maintenance request history (completed/cancelled)
    public function getRequestHistory() {
        $this->db->query('SELECT 
                            r.request_id,
                            u.name AS resident_name,
                            res.address AS resident_address,
                            res.phonenumber AS resident_phone,
                            t.type_name,
                            r.description,
                            r.urgency_level,
                            s.status_name,
                            s.status_id,
                            m.id AS maintainer_id,
                            m.name AS maintainer_name,
                            r.due_date,
                            r.created_at,
                            r.completed_at
                          FROM maintenance_requests r
                          JOIN users u ON r.resident_id = u.id
                          JOIN residents res ON u.id = res.user_id
                          JOIN maintenance_types t ON r.type_id = t.type_id
                          JOIN maintenance_statuses s ON r.status_id = s.status_id
                          LEFT JOIN maintenance_members m ON r.maintainer_id = m.id
                          WHERE r.status_id IN (3, 4) -- Completed or Cancelled
                          ORDER BY r.completed_at DESC');
        
        return $this->db->resultSet();
    }

    // Get maintenance types
    public function getMaintenanceTypes() {
        $this->db->query('SELECT * FROM maintenance_types ORDER BY type_name');
        return $this->db->resultSet();
    }

    // Get maintenance statuses
    public function getMaintenanceStatuses() {
        $this->db->query('SELECT * FROM maintenance_statuses ORDER BY status_id');
        return $this->db->resultSet();
    }

    // Get maintenance staff
    public function getMaintenanceStaff() {
        $this->db->query('SELECT 
                            m.id, 
                            m.name, 
                            m.specialization 
                          FROM maintenance_members m
                          ORDER BY m.name');
        return $this->db->resultSet();
    }

    // Update request due date
    public function updateRequestDueDate($requestId, $dueDate) {
        $this->db->query('UPDATE maintenance_requests SET due_date = :due_date WHERE request_id = :request_id');
        $this->db->bind(':due_date', $dueDate);
        $this->db->bind(':request_id', $requestId);
        return $this->db->execute();
    }



    // Update request status
    public function updateRequestStatus($requestId, $statusId) {
        $this->db->query('UPDATE maintenance_requests 
                          SET status_id = :status_id,
                              completed_at = CASE WHEN :status_id = 3 THEN NOW() ELSE NULL END
                          WHERE request_id = :request_id');
        $this->db->bind(':status_id', $statusId);
        $this->db->bind(':request_id', $requestId);
        return $this->db->execute();
    }

    // Get requests assigned to a specific staff member
    public function getStaffAssignedRequests($staffId) {
        $this->db->query('SELECT 
                            r.request_id,
                            u.name AS resident_name,
                            res.address AS resident_address,
                            res.phonenumber AS resident_phone,
                            t.type_name,
                            r.description,
                            r.urgency_level,
                            r.due_date
                          FROM maintenance_requests r
                          JOIN users u ON r.resident_id = u.id
                          JOIN residents res ON u.id = res.user_id
                          JOIN maintenance_types t ON r.type_id = t.type_id
                          WHERE r.maintainer_id = :staff_id
                          AND r.status_id = 2 -- In Progress
                          ORDER BY r.due_date, r.urgency_level');
        $this->db->bind(':staff_id', $staffId);
        return $this->db->resultSet();
    }

    // In your MaintenanceModel class

// Get maintenance staff by specialization
public function getMaintenanceStaffBySpecialization($specialization) {
    $this->db->query('SELECT 
                        m.id, 
                        m.name, 
                        m.specialization 
                      FROM maintenance_members m
                      WHERE m.specialization = :specialization
                      ORDER BY m.name');
    $this->db->bind(':specialization', $specialization);
    return $this->db->resultSet();
}

// Get all unique specializations
public function getMaintenanceSpecializations() {
    $this->db->query('SELECT DISTINCT specialization FROM maintenance_members ORDER BY specialization');
    return $this->db->resultSet();
}

// Update to remove due date from assignment
public function assignMaintainerToRequest($requestId, $staffId) {
    $this->db->query('UPDATE maintenance_requests 
                      SET maintainer_id = :maintainer_id,
                          status_id = 2 -- In Progress
                      WHERE request_id = :request_id');
    $this->db->bind(':maintainer_id', $staffId);
    $this->db->bind(':request_id', $requestId);
    return $this->db->execute();
}
    //*************************************************************************************************************************************************


}
