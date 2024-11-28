<?php

class M_maintenance
{
    private $db;

    public function __construct()
    {
        $this->db = new Database; // Assuming Database is a custom class for database interaction
    }

//*************************************************************************************************************************************************

// Add new maintenance member to the database
public function addMember($data) {
    $this->db->query("INSERT INTO maintenance_members (name, specialization, experience, certifications, profile_image) 
                      VALUES (:name, :specialization, :experience, :certifications, :profile_image)");

    // Bind values
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':specialization', $data['specialization']);
    $this->db->bind(':experience', $data['experience']);
    $this->db->bind(':certifications', $data['certifications']);
    $this->db->bind(':profile_image', $data['profile_image']);

    // Execute query
    return $this->db->execute();
}

// Fetch all maintenance members
public function getAllMembers() {
    $this->db->query("SELECT * FROM maintenance_members");
    return $this->db->resultSet();
}

public function updateMember($data) {
    $sql = "UPDATE maintenance_members 
            SET name = :name, specialization = :specialization, experience = :experience, certifications = :certifications";
    if ($data['profile_image']) {
        $sql .= ", profile_image = :profile_image";
    }
    $sql .= " WHERE id = :id";

    $this->db->query($sql);
    $this->db->bind(':id', $data['id']);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':specialization', $data['specialization']);
    $this->db->bind(':experience', $data['experience']);
    $this->db->bind(':certifications', $data['certifications']);
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


//     // Get all inventory usage logs
//     public function getInventoryUsageLogs()
//     {
//         $this->db->query("SELECT * FROM inventory_usage_log");
//         return $this->db->resultSet(); // Executes the query and returns the results as an array
//     }

//     // Add a new inventory usage log
//     public function addInventoryUsageLog($data)
// {
//     // Prepare the query to insert the new log
//     $this->db->query("INSERT INTO inventory_usage_log (item_id, item_name, usage_date, usage_time, quantity) 
//                       VALUES (:item_id, :item_name, :usage_date, :usage_time, :quantity)");

//     // Bind data
//     $this->db->bind(':item_id', $data['item_id']);
//     $this->db->bind(':item_name', $data['item_name']);
//     $this->db->bind(':usage_date', $data['usage_date']);
//     $this->db->bind(':usage_time', $data['usage_time']);
//     $this->db->bind(':quantity', $data['quantity']);

//     // Execute the query and return the result
//     return $this->db->execute();
// }


// public function updateInventoryUsageLog($data) 
// {
//     $this->db->query("UPDATE inventory_usage_log 
//                       SET quantity = :quantity
//                       WHERE log_id = :log_id AND item_id = :item_id");

//     // Bind only the necessary data for update
//     $this->db->bind(':log_id', $data['log_id']);
//     $this->db->bind(':item_id', $data['item_id']);
//     $this->db->bind(':quantity', $data['quantity']);

//     return $this->db->execute();
// }

//     // Delete an inventory usage log
//     public function deleteInventoryUsageLog($log_id)
//     {
//         // Prepare the query to delete the log entry
//         $this->db->query("DELETE FROM inventory_usage_log WHERE log_id = :log_id");

//         // Bind the log_id to the query
//         $this->db->bind(':log_id', $log_id);

//         // Execute the query and return the result
//         return $this->db->execute();
//     }

//     // Get a specific inventory usage log by log_id
//     public function getInventoryUsageLogById($log_id)
//     {
//         // Prepare the query to get a specific log entry
//         $this->db->query("SELECT * FROM inventory_usage_log WHERE log_id = :log_id");

//         // Bind the log_id parameter
//         $this->db->bind(':log_id', $log_id);

//         // Execute the query and return the result as a single object
//         return $this->db->single();
//     }

//available inventory
// public function getInventoryAvailableLogs()
// {
//     $this->db->query("SELECT * FROM available_store");
//     return $this->db->resultSet(); // Executes the query and returns the results as an array
// }

// //available store

// public function getInventoryAvailableLogById($item_id)
// {
//     // Prepare the query to get a specific log entry
//     $this->db->query("SELECT * FROM available_store WHERE log_id = :log_id");

//     // Bind the log_id parameter
//     $this->db->bind(':log_id', $item_id);

//     // Execute the query and return the result as a single object
//     return $this->db->single();
// }


