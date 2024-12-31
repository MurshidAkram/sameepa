<?php
class M_Listing {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllListings($search = '') {
        $this->db->query(
            'SELECT listings.*, 
                    users.name AS posted_by_name 
             FROM listings 
             INNER JOIN users 
             ON listings.posted_by = users.id'
        );
    
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
            $this->db->query('UPDATE listings 
                             SET title = :title, 
                                 description = :description, 
                                 type = :type 
                             WHERE id = :id AND posted_by = :user_id');
            
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':type', $data['type']);
            $this->db->bind(':user_id', $data['user_id']);

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
        $this->db->query('SELECT * FROM listings WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}