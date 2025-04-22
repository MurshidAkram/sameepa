<?php
class M_resident
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMaintenanceRequests($resident_id)
    {
        $this->db->query('
            SELECT mr.*, mt.type_name as type, ms.status_name as status 
            FROM maintenance_requests mr
            JOIN maintenance_types mt ON mr.type_id = mt.type_id
            JOIN maintenance_statuses ms ON mr.status_id = ms.status_id
            WHERE mr.resident_id = :resident_id
            ORDER BY mr.created_at DESC
        ');
        $this->db->bind(':resident_id', $resident_id);
        return $this->db->resultSet();
    }

    public function getMaintenanceTypes()
    {
        $this->db->query('SELECT * FROM maintenance_types');
        return $this->db->resultSet();
    }

    public function submitMaintenanceRequest($data)
    {
        $this->db->query('
            INSERT INTO maintenance_requests 
            (resident_id, type_id, description, urgency_level, status_id) 
            VALUES (:resident_id, :type_id, :description, :urgency_level, 1)
        ');
        
        $this->db->bind(':resident_id', $data['resident_id']);
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':urgency_level', $data['urgency_level']);

        return $this->db->execute();
    }

    public function getMaintenanceRequestDetails($request_id, $resident_id)
    {
        $this->db->query('
            SELECT mr.*, mt.type_name as type, ms.status_name as status 
            FROM maintenance_requests mr
            JOIN maintenance_types mt ON mr.type_id = mt.type_id
            JOIN maintenance_statuses ms ON mr.status_id = ms.status_id
            WHERE mr.request_id = :request_id AND mr.resident_id = :resident_id
        ');
        $this->db->bind(':request_id', $request_id);
        $this->db->bind(':resident_id', $resident_id);
        
        $row = $this->db->single();
        return $row;
    }

    public function canEditRequest($request_id, $resident_id)
    {
        $this->db->query('
            SELECT created_at 
            FROM maintenance_requests 
            WHERE request_id = :request_id AND resident_id = :resident_id
            AND status_id = 1
            AND TIMESTAMPDIFF(HOUR, created_at, NOW()) <= 24
        ');
        $this->db->bind(':request_id', $request_id);
        $this->db->bind(':resident_id', $resident_id);
        
        $row = $this->db->single();
        return ($row) ? true : false;
    }

    public function updateMaintenanceRequest($data)
    {
        $this->db->query('
            UPDATE maintenance_requests 
            SET type_id = :type_id, 
                description = :description, 
                urgency_level = :urgency_level,
                updated_at = NOW()
            WHERE request_id = :request_id
        ');
        
        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':urgency_level', $data['urgency_level']);
        $this->db->bind(':request_id', $data['request_id']);

        return $this->db->execute();
    }

    public function deleteMaintenanceRequest($request_id, $resident_id)
    {
        $this->db->query('
            DELETE FROM maintenance_requests 
            WHERE request_id = :request_id AND resident_id = :resident_id
        ');
        
        $this->db->bind(':request_id', $request_id);
        $this->db->bind(':resident_id', $resident_id);

        return $this->db->execute();
    }
}