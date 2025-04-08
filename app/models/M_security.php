<?php

class M_security
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

//****************************************************** Emergency contact******************************************************************* */

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
        return $this->db->lastInsertId(); // Return the unique ID
    } else {
        return false;
    }
}

//***************************************************resident contact*********************************** */

public function searchResidentContacts($query)
{
    $this->db->query("SELECT 
                        resident_name,
                        address,
                        phonenumber AS phone_number,
                        fixed_line,
                        email
                      FROM residents_contact
                      WHERE resident_name LIKE :q 
                         OR address LIKE :q 
                         OR phonenumber LIKE :q
                         OR fixed_line LIKE :q
                         OR email LIKE :q");
    
    $this->db->bind(':q', '%' . $query . '%');
    return $this->db->resultSet();
} 

}
?>
