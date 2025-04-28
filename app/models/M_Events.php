<?php
class M_Events
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllEvents($search = '')
    {
        $sql = 'SELECT e.*, u.name as creator_name 
        FROM events e 
        JOIN users u ON e.created_by = u.id 
        WHERE e.is_deleted = FALSE ';

        if (!empty($search)) {
            $sql .= 'AND (e.title LIKE :search 
             OR e.description LIKE :search 
             OR e.location LIKE :search) ';
        }

        $sql .= 'ORDER BY e.date DESC, e.time DESC';

        $this->db->query($sql);

        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }

        $events = $this->db->resultSet();

        $today = date('Y-m-d');
        foreach ($events as $event) {
            $event->is_active = ($event->date >= $today);
        }

        return $events;
    }

    public function createEvent($data)
    {
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
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function getEventById($id)
    {
        $this->db->query('SELECT e.*, u.name as creator_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         WHERE e.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();

        if ($event) {
            $today = date('Y-m-d');
            $event['is_active'] = ($event['date'] >= $today);
        }

        return $event;
    }

    public function getEventImage($id)
    {
        $this->db->query('SELECT image_data, image_type FROM events WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function isEventCreator($eventId, $userId)
    {
        $this->db->query('SELECT * FROM events WHERE id = :event_id AND created_by = :user_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);

        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function getParticipantCount($eventId)
    {
        $this->db->query('SELECT COUNT(*) as count FROM event_participants WHERE event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        $row = $this->db->single();
        return $row['count'];
    }

    public function isUserJoined($eventId, $userId)
    {
        $this->db->query('SELECT * FROM event_participants WHERE event_id = :event_id AND user_id = :user_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);

        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function joinEvent($eventId, $userId)
    {
        if (!$this->isEventActive($eventId)) {
            return false;
        }

        $this->db->query('INSERT INTO event_participants (event_id, user_id, joined_at) VALUES (:event_id, :user_id, NOW())');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }

    public function leaveEvent($eventId, $userId)
    {
        $this->db->query('DELETE FROM event_participants WHERE event_id = :event_id AND user_id = :user_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }

    public function getEventsByUser($userId)
    {
        $this->db->query('SELECT e.*, u.name as creator_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         WHERE e.created_by = :user_id AND e.is_deleted = FALSE
                         ORDER BY e.date ASC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getEventParticipants($eventId)
    {
        $this->db->query('SELECT u.name, ep.joined_at 
                         FROM event_participants ep 
                         JOIN users u ON ep.user_id = u.id 
                         WHERE ep.event_id = :event_id 
                         ORDER BY ep.joined_at ASC');
        $this->db->bind(':event_id', $eventId);
        return $this->db->resultSet();
    }

    public function deleteEvent($eventId)
    {
        $this->db->query('DELETE FROM event_participants WHERE event_id = :event_id');
        $this->db->bind(':event_id', $eventId);
        $this->db->execute();

        $this->db->query('UPDATE events SET is_deleted = TRUE WHERE id = :event_id');
        $this->db->bind(':event_id', $eventId);
        return $this->db->execute();
    }

    public function getJoinedEvents($userId)
    {
        $this->db->query('SELECT e.*, u.name as creator_name 
                         FROM events e 
                         JOIN users u ON e.created_by = u.id 
                         JOIN event_participants ep ON e.id = ep.event_id 
                         WHERE ep.user_id = :user_id 
                         ORDER BY e.date ASC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function updateEvent($data)
    {
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
    public function getTotalEvents()
    {
        $this->db->query('SELECT COUNT(*) as total FROM events');
        $result = $this->db->single();
        return $result['total'];
    }

    public function isEventActive($eventId)
    {
        $event = $this->getEventById($eventId);
        if ($event) {
            $today = date('Y-m-d');
            return $event['date'] >= $today;
        }
        return false;
    }

    //SENUJA for admin dashboard
    public function getEventsByStatus($status)
    {
        $today = date('Y-m-d');

        switch ($status) {
            case 'upcoming':
                $sql = "SELECT * FROM events WHERE date > :today";
                break;
            case 'ongoing':
                $sql = "SELECT * FROM events WHERE date = :today";
                break;
            case 'completed':
                $sql = "SELECT * FROM events WHERE date < :today";
                break;
        }

        $this->db->query($sql);
        $this->db->bind(':today', $today);
        return $this->db->resultSet();
    }


    //DONE BY SANKAVI FOR THE SUPER ADMIN DASHBOARD
    public function getTodaysEvents()
    {
        try {
            $specificDate = '2025-04-30';

            $this->db->query('
                SELECT 
                    title AS event_title,
                    time AS event_time
                FROM events
                WHERE DATE(date) = :today
                ORDER BY time
            ');
            $this->db->bind(':today', $specificDate);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error fetching today's events: " . $e->getMessage());
            return [];
        }
    }
}
