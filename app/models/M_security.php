<?php

class M_security
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Method to create a new visitor pass
    public function createVisitorPass($data)
    {
        $this->db->query("INSERT INTO visitor_passes (visitor_name, visitor_count, visit_date, visit_time, duration, purpose, resident_id, resident_name) 
                          VALUES (:visitor_name, :visitor_count, :visit_date, :visit_time, :duration, :purpose, :resident_name)");

        // Bind parameters
        $this->db->bind(':visitor_name', $data['visitor_name']);
        $this->db->bind(':visitor_count', $data['visitor_count']);
        $this->db->bind(':visit_date', $data['visit_date']);
        $this->db->bind(':visit_time', $data['visit_time']);
        $this->db->bind(':duration', $data['duration']);
        $this->db->bind(':purpose', $data['purpose']);
        $this->db->bind(':resident_name', $data['resident_name']);

        // Execute and return success status
        return $this->db->execute();
    }

    // Retrieve active visitor passes (today's passes)
    public function getTodayPasses()
    {
        $this->db->query("SELECT * FROM visitor_passes WHERE visit_date = CURDATE()");
        return $this->db->resultSet();
    }

    // Retrieve all visitor passes
    public function getAllPasses()
    {
        $this->db->query("SELECT * FROM visitor_passes");
        return $this->db->resultSet();
    }

    // Method to add a new resident contact
    public function addResidentContact($data)
    {
        $this->db->query("INSERT INTO security_resident_details (resident_name, phone_number, fixed_line, email, address) 
                          VALUES (:resident_name, :resident_phone, :fixed_line, :resident_email, :resident_address)");

        // Bind parameters
        $this->db->bind(':resident_name', $data['resident_name']);
        $this->db->bind(':resident_phone', $data['resident_phone']);
        $this->db->bind(':fixed_line', $data['fixed_line']);
        $this->db->bind(':resident_email', $data['resident_email']);
        $this->db->bind(':resident_address', $data['resident_address']);

        // Execute and return success status
        return $this->db->execute();
    }

    // Combined method to retrieve resident details based on name or address
    public function getResidentDetailsByName($name)
    {
        // Perform the query to search for residents by name or address
        $this->db->query("SELECT * FROM security_resident_details WHERE resident_name LIKE :name OR address LIKE :name");
        $this->db->bind(':name', "%$name%");

        // Return the result set
        return $this->db->resultSet();
    }

    // Optionally, you can add other methods to retrieve, update, or delete resident contacts
    public function getAllResidents()
    {
        $this->db->query("SELECT * FROM security_resident_details");
        return $this->db->resultSet();
    }
}
?>