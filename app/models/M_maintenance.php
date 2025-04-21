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
public function getAllMembers() {
    $this->db->query("SELECT * FROM maintenance_members");
    return $this->db->resultSet();
}

// Add new maintenance member to the database
public function addMember($data) {
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


public function updateMember($data) {
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
public function deleteMember($id) {
    $this->db->query("DELETE FROM maintenance_members WHERE id = :id");
    $this->db->bind(':id', $id);

    return $this->db->execute();
}


//**********************************************resident requests****************************************************************************************************************************** */

public function createRequest($data) {
    $this->db->query('INSERT INTO maintenance_requests 
                      (resident_id, type_id, title, description, urgency_level) 
                      VALUES (:resident_id, :type_id, :title, :description, :urgency_level)');
    
    $this->db->bind(':resident_id', $data['resident_id']);
    $this->db->bind(':type_id', $data['type_id']);
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':description', $data['description']);
    $this->db->bind(':urgency_level', $data['urgency_level']);

    return $this->db->execute();
}

public function getRequestsByResident($residentId) {
    $this->db->query('SELECT mr.*, rt.type_name, rs.status_name, u.name as resident_name, 
                     r.unit_number, st.name as staff_name
                     FROM maintenance_requests mr
                     JOIN request_types rt ON mr.type_id = rt.type_id
                     JOIN request_statuses rs ON mr.status_id = rs.status_id
                     JOIN users u ON mr.resident_id = u.user_id
                     JOIN residents r ON u.user_id = r.user_id
                     LEFT JOIN users st ON mr.assigned_staff_id = st.user_id
                     WHERE mr.resident_id = :resident_id
                     ORDER BY mr.created_at DESC');
    
    $this->db->bind(':resident_id', $residentId);
    return $this->db->resultSet();
}

public function getAllRequests() {
    $this->db->query('SELECT mr.*, rt.type_name, rs.status_name, u.name as resident_name, 
                     r.unit_number, st.name as staff_name
                     FROM maintenance_requests mr
                     JOIN request_types rt ON mr.type_id = rt.type_id
                     JOIN request_statuses rs ON mr.status_id = rs.status_id
                     JOIN users u ON mr.resident_id = u.user_id
                     JOIN residents r ON u.user_id = r.user_id
                     LEFT JOIN users st ON mr.assigned_staff_id = st.user_id
                     ORDER BY mr.created_at DESC');
    
    return $this->db->resultSet();
}

public function updateRequestDueDate($requestId, $dueDate) {
    $this->db->query('UPDATE maintenance_requests SET due_date = :due_date WHERE request_id = :request_id');
    $this->db->bind(':due_date', $dueDate);
    $this->db->bind(':request_id', $requestId);
    return $this->db->execute();
}

public function assignMaintainer($requestId, $staffId, $dueDate) {
    $this->db->query('UPDATE maintenance_requests 
                     SET assigned_staff_id = :staff_id, 
                         due_date = :due_date,
                         status_id = 2 
                     WHERE request_id = :request_id');
    
    $this->db->bind(':staff_id', $staffId);
    $this->db->bind(':due_date', $dueDate);
    $this->db->bind(':request_id', $requestId);
    return $this->db->execute();
}

public function getRequestTypes() {
    $this->db->query('SELECT * FROM request_types');
    return $this->db->resultSet();
}

public function getRequestStatuses() {
    $this->db->query('SELECT * FROM request_statuses');
    return $this->db->resultSet();
}



}
