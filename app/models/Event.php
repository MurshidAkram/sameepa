public function createEvent($data) {
    $this->db->query('INSERT INTO events (event_name, date, location, time, by_whom, image) VALUES (:event_name, :date, :location, :time, :by_whom, :image)');
    $this->db->bind(':event_name', $data['event_name']);
    $this->db->bind(':date', $data['date']);
    $this->db->bind(':location', $data['location']);
    $this->db->bind(':time', $data['time']);
    $this->db->bind(':by_whom', $data['by_whom']);
    $this->db->bind(':image', $data['image']);

    return $this->db->execute();
}
