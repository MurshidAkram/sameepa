<?php
class M_Events {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllEvents() {
        $this->db->query('SELECT e.*, u.name as creator_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         ORDER BY e.date ASC');
        return $this->db->resultSet();
    }

    public function createEvent($data) {
        $this->db->query('INSERT INTO events (title, description, date, time, location, image_data, image_type, created_by) 
                         VALUES (:title, :description, :date, :time, :location, :image_data, :image_type, :created_by)');
        
        // Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':time', $data['time']);
        $this->db->bind(':location', $data['location']);
        $this->db->bind(':image_data', $data['image_data']);
        $this->db->bind(':image_type', $data['image_type']);
        $this->db->bind(':created_by', $data['created_by']);

        // Execute
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function getEventById($id) {
        $this->db->query('SELECT e.*, u.name as creator_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         WHERE e.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getEventImage($id) {
        $this->db->query('SELECT image_data, image_type FROM events WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function isEventCreator($eventId, $userId) {
        $this->db->query('SELECT * FROM events WHERE id = :event_id AND created_by = :user_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);
        
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function getParticipantCount($eventId) {
        $this->db->query('SELECT COUNT(*) as count FROM event_participants WHERE event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        $row = $this->db->single();
        return $row['count'];
    }

}