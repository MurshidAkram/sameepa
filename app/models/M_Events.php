<?php
class M_Events
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function createEvent($data)
    {
        $this->db->query('INSERT INTO events (title, description, date, time, location, image, created_by) 
                         VALUES (:title, :description, :date, :time, :location, :image, :created_by)');

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':time', $data['time']);
        $this->db->bind(':location', $data['location']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':created_by', $data['created_by']);

        return $this->db->execute();
    }

    public function getAllEvents()
    {
        $this->db->query('SELECT e.*, u.name as created_by_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         ORDER BY e.date ASC, e.time ASC');
        return $this->db->resultSet();
    }

    public function getEventsByUserId($userId)
    {
        $this->db->query('SELECT * FROM events WHERE created_by = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function deleteEvent($eventId, $userId, $isAdmin)
    {
        // Check if user is admin or event creator
        if ($isAdmin) {
            $this->db->query('DELETE FROM events WHERE id = :event_id');
            $this->db->bind(':event_id', $eventId);
        } else {
            $this->db->query('DELETE FROM events WHERE id = :event_id AND created_by = :user_id');
            $this->db->bind(':event_id', $eventId);
            $this->db->bind(':user_id', $userId);
        }
        return $this->db->execute();
    }

    public function isUserJoined($eventId, $userId)
    {
        $this->db->query('SELECT * FROM event_participants WHERE event_id = :event_id AND user_id = :user_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);

        return $this->db->rowCount() > 0;
    }

    public function joinEvent($eventId, $userId)
    {
        // Check if the user has already joined the event
        if ($this->isUserJoined($eventId, $userId)) {
            return false; // User has already joined the event
        }

        $this->db->query('INSERT INTO event_participants (event_id, user_id) VALUES (:event_id, :user_id)');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }

    public function getEventById($id)
    {
        $this->db->query('SELECT e.*, u.name as created_by_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         WHERE e.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getParticipantCount($eventId)
    {
        $this->db->query('SELECT COUNT(*) as count FROM event_participants WHERE event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        $result = $this->db->single();
        return $result['count'];
    }
}
