<?php
class M_Exchange {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllListings($search = '') {
        // First, let's do a test query to see all records with is_deleted=1
        $this->db->query('SELECT COUNT(*) as deleted_count FROM listings WHERE is_deleted = 1');
        $deletedCount = $this->db->single();
        error_log('Number of listings with is_deleted=1: ' . $deletedCount['deleted_count']);
        
        // Now build our main query with explicit filtering
        $sql = 'SELECT listings.*, 
                     users.name AS posted_by_name
              FROM listings
              INNER JOIN users
              ON listings.posted_by = users.id
              WHERE listings.is_deleted != 1'; // Explicitly exclude records with is_deleted=1
        
        if (!empty($search)) {
            $sql .= ' AND (listings.title LIKE :search OR listings.description LIKE :search)';
            $this->db->query($sql);
            $searchTerm = '%' . $search . '%';
            $this->db->bind(':search', $searchTerm);
        } else {
            $this->db->query($sql);
        }
        
        $results = $this->db->resultSet();
        error_log('getAllListings returned ' . count($results) . ' records');
        return $results;
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
                              AND (l.is_deleted != 1 OR l.is_deleted IS NULL)
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
    public function softDeleteListing($id) {
        try {
            // Log the before state
            $this->db->query('SELECT * FROM listings WHERE id = :id');
            $this->db->bind(':id', $id);
            $beforeRecord = $this->db->single();
            error_log('Before deletion - Record state: ' . print_r($beforeRecord, true));
            
            // Update is_deleted flag to 1
            $this->db->query('UPDATE listings SET is_deleted = 1 WHERE id = :id');
            $this->db->bind(':id', $id);
            $updateResult = $this->db->execute();
            
            // Verify the update was successful
            $this->db->query('SELECT * FROM listings WHERE id = :id');
            $this->db->bind(':id', $id);
            $afterRecord = $this->db->single();
            error_log('After deletion - Record state: ' . print_r($afterRecord, true));
            
            return $updateResult;
        } catch (Exception $e) {
            error_log('Error in deleteListing: ' . $e->getMessage());
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
            SELECT l.*, u.name AS posted_by_name, r.phonenumber AS number
            FROM listings l
            JOIN users u ON l.posted_by = u.id
            JOIN residents r ON u.id = r.user_id
            WHERE l.id = :id AND l.is_deleted != 1
        ');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        error_log('getListingById for ID ' . $id . ' returned: ' . ($result ? 'record found' : 'no record'));
        return $result;
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

    public function searchListings($search) {
        // Query to search reports by category, status, reporter name, or description, where is_deleted is 0
        $search = '%' . $search . '%';
        $this->db->query('SELECT l.*, u.name AS posted_by_name FROM listings l
                          JOIN users u ON l.posted_by = u.id
                          WHERE l.is_deleted = 0 
                            AND (l.title LIKE :search 
                             OR l.posted_by LIKE :search 
                             OR l.date_posted LIKE :search 
                             OR l.description LIKE :search 
                             OR l.type LIKE :search)
                          ORDER BY l.date_posted DESC');
        $this->db->bind(':search', $search);
        return $this->db->resultSet();
    }
}