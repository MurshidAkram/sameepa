<?php

class M_security
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

//************************************************************************************************************************* */

   // Fetch all contacts
public function getAllContacts() {
    $this->db->query("SELECT * FROM emergency_contacts");
    return $this->db->resultSet();
}

// Add new contact to the database
public function addContact($data) {
    $this->db->query("INSERT INTO emergency_contacts (name,phone) 
                      VALUES (:name,:phone)");

    // Bind values
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':phone', $data['phone']);

    // Execute query
    return $this->db->execute();
}


public function updateContact($data) {
    $sql = "UPDATE emergency_contacts 
            SET name = :name, phone = :phone";
    $sql .= " WHERE id = :id";

    $this->db->query($sql);
    $this->db->bind(':id', $data['id']);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':phone', $data['phone']);

    return $this->db->execute();
}
// Delete a maintenance member from the database
public function deleteContact($id) {
    $this->db->query("DELETE FROM emergency_contacts WHERE id = :id");
    $this->db->bind(':id', $id);

    return $this->db->execute();
}


   
}
?>
