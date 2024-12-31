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


}
//**************************************************************************************************************************************************************************** */
    

    
 //*************************************************************************************************************************************************





