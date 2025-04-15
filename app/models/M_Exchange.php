<?php
class M_Exchange {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllListings($search = '') {
        $sql = 'SELECT listings.*, 
                    users.name AS posted_by_name 
             FROM listings 
             INNER JOIN users 
             ON listings.posted_by = users.id';
        
        if (!empty($search)) {
            $sql .= ' WHERE listings.title LIKE :search OR listings.description LIKE :search';
            $this->db->query($sql);
            $searchTerm = '%' . $search . '%';
            $this->db->bind(':search', $searchTerm);
        } else {
            $this->db->query($sql);
        }
    
        return $this->db->resultSet();
    }
    
    public function createListing($data)
    {
        // Prepare SQL query
        $this->db->query("INSERT INTO listings (title, type, description, image_data, image_type, posted_by) VALUES (:title, :type, :description, :image_data, :image_type, :posted_by)");

        // Bind values to query
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image_data', $data['image_data']);
        $this->db->bind(':image_type', $data['image_type']);
        $this->db->bind(':posted_by', $data['posted_by']);

        // Execute query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getListingImage($id)
    {
        $this->db->query('SELECT image_data, image_type FROM listings WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getUserListings($userId) {
        try {
            $this->db->query('SELECT l.*, u.name as posted_by_name 
                             FROM listings l 
                             INNER JOIN users u ON l.posted_by = u.id 
                             WHERE l.posted_by = :user_id
                             ORDER BY l.date_posted DESC');
            $this->db->bind(':user_id', $userId);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log('Error in getUserListings: ' . $e->getMessage());
            return [];
        }
    }

    public function updateListing($data) {
        try {
            $sql = 'UPDATE listings SET 
                    title = :title, 
                    description = :description, 
                    type = :type';
            
            // Add image update if new image provided
            if ($data['image_data'] !== null) {
                $sql .= ', image_data = :image_data, image_type = :image_type';
            }
            
            $sql .= ' WHERE id = :id AND posted_by = :user_id';
            
            $this->db->query($sql);
            
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':type', $data['type']);
            $this->db->bind(':user_id', $data['user_id']);
            
            if ($data['image_data'] !== null) {
                $this->db->bind(':image_data', $data['image_data']);
                $this->db->bind(':image_type', $data['image_type']);
            }
    
            return $this->db->execute();
        } catch (Exception $e) {
            error_log('Error in updateListing: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteListing($id) {
        try {
            $this->db->query('DELETE FROM listings WHERE id = :id');
            $this->db->bind(':id', $id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log('Error in deleteListing: ' . $e->getMessage());
            return false;
        }
    }

    public function isListingOwner($listingId, $userId) {
        $this->db->query('SELECT id FROM listings WHERE id = :id AND posted_by = :user_id');
        $this->db->bind(':id', $listingId);
        $this->db->bind(':user_id', $userId);
        
        return $this->db->single() ? true : false;
    }
    
    public function getListingById($id) {
        $this->db->query('
            SELECT l.*, u.name AS posted_by_name 
            FROM listings l
            JOIN users u ON l.posted_by = u.id
            WHERE l.id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    
    
    public function sendMessage($data) {
        // This is just a placeholder - you would implement message sending logic here
        // For example, you might insert a message into a messages table
        $this->db->query('INSERT INTO messages (listing_id, sender_id, recipient_id, message, sent_at) 
                         VALUES (:listing_id, :sender_id, :recipient_id, :message, NOW())');
        
        $this->db->bind(':listing_id', $data['listing_id']);
        $this->db->bind(':sender_id', $data['sender_id']);
        $this->db->bind(':recipient_id', $data['recipient_id']);
        $this->db->bind(':message', $data['message']);
        
        return $this->db->execute();
    }
}