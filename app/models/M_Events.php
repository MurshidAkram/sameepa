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
        $this->db->query('INSERT INTO events (title, description, date, time, location,  created_by) 
                         VALUES (:title, :description, :date, :time, :location,  :created_by)');

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':time', $data['time']);
        $this->db->bind(':location', $data['location']);
        $this->db->bind(':created_by', $data['created_by']);

        return $this->db->execute();
    }

    public function getAllEvents()
    {
        $this->db->query('SELECT * FROM events');
        return $this->db->resultSet();
    }

    public function getEventsByUserId($userId)
    {
        $this->db->query('SELECT * FROM events WHERE created_by = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}
