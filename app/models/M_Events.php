<?php
class M_Events {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // In M_Events.php, update the getAllEvents method:
public function getAllEvents($search = '') {
    $sql = 'SELECT e.*, u.name as creator_name 
            FROM events e 
            JOIN users u ON e.created_by = u.id 
            WHERE 1=1 ';
    
    if (!empty($search)) {
        $sql .= 'AND (e.title LIKE :search 
                 OR e.description LIKE :search 
                 OR e.location LIKE :search) ';
    }
    
    $sql .= 'ORDER BY e.updated_at DESC, e.created_at DESC';
    
    $this->db->query($sql);
    
    if (!empty($search)) {
        $this->db->bind(':search', '%' . $search . '%');
    }
    
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

    public function isUserJoined($eventId, $userId) {
        $this->db->query('SELECT * FROM event_participants WHERE event_id = :event_id AND user_id = :user_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);
        
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }
    
    public function joinEvent($eventId, $userId) {
        $this->db->query('INSERT INTO event_participants (event_id, user_id, joined_at) VALUES (:event_id, :user_id, NOW())');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->execute();
    }
    
    public function leaveEvent($eventId, $userId) {
        $this->db->query('DELETE FROM event_participants WHERE event_id = :event_id AND user_id = :user_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->execute();
    }

    public function getEventsByUser($userId) {
        $this->db->query('SELECT e.*, u.name as creator_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         WHERE e.created_by = :user_id 
                         ORDER BY e.date ASC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    
    public function getEventParticipants($eventId) {
        $this->db->query('SELECT u.name, ep.joined_at 
                         FROM event_participants ep 
                         JOIN users u ON ep.user_id = u.id 
                         WHERE ep.event_id = :event_id 
                         ORDER BY ep.joined_at ASC');
        $this->db->bind(':event_id', $eventId);
        return $this->db->resultSet();
    }
    
    public function deleteEvent($eventId) {
        // First delete all participants
        $this->db->query('DELETE FROM event_participants WHERE event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->execute();
        
        // Then delete the event
        $this->db->query('DELETE FROM events WHERE id = :event_id');
        $this->db->bind(':event_id', $eventId);
        return $this->db->execute();
    }

    public function getJoinedEvents($userId) {
        $this->db->query('SELECT e.*, u.name as creator_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         JOIN event_participants ep ON e.id = ep.event_id 
                         WHERE ep.user_id = :user_id 
                         ORDER BY e.date ASC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function updateEvent($data) {
        if (!empty($data['image_data'])) {
            $this->db->query('UPDATE events 
                             SET title = :title, 
                                 description = :description, 
                                 date = :date, 
                                 time = :time, 
                                 location = :location, 
                                 image_data = :image_data, 
                                 image_type = :image_type 
                             WHERE id = :id');
            
            $this->db->bind(':image_data', $data['image_data']);
            $this->db->bind(':image_type', $data['image_type']);
        } else {
            $this->db->query('UPDATE events 
                             SET title = :title, 
                                 description = :description, 
                                 date = :date, 
                                 time = :time, 
                                 location = :location 
                             WHERE id = :id');
        }
        
        // Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':time', $data['time']);
        $this->db->bind(':location', $data['location']);
        $this->db->bind(':id', $data['id']);
    
        // Execute
        return $this->db->execute();
    }
    

}