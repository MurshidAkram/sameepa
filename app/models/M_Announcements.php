<?php
class M_Announcements
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function createAnnouncement($data)
    {
        $this->db->query('INSERT INTO announcements (title, content, created_by) VALUES (:title, :content, :created_by)');

        // Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':created_by', $data['created_by']);

        // Execute
        return $this->db->execute();
    }


    public function updateAnnouncement($data)
    {
        $this->db->query('UPDATE announcements SET title = :title, content = :content WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);

        // Execute
        return $this->db->execute();
    }

    public function deleteAnnouncement($id)
    {
        try {
            $this->db->beginTransaction();

            $this->db->query('DELETE FROM announcement_reactions WHERE announcement_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query('UPDATE announcements SET status = :status WHERE id = :id');
            $this->db->bind(':status', 'deleted');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getAnnouncementById($id)
    {
        $this->db->query('SELECT a.*, u.name as creator_name,
                     (SELECT COUNT(*) FROM announcement_reactions 
                      WHERE announcement_id = a.id AND reaction_type = "like") as likes,
                     (SELECT COUNT(*) FROM announcement_reactions 
                      WHERE announcement_id = a.id AND reaction_type = "dislike") as dislikes
                     FROM announcements a 
                     JOIN users u ON a.created_by = u.id 
                     WHERE a.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }


    public function getAllAnnouncements($searchTerm = '')
    {
        $query = 'SELECT a.*, u.name as creator_name,
                  (SELECT COUNT(*) FROM announcement_reactions WHERE announcement_id = a.id AND reaction_type = "like") as likes,
                  (SELECT COUNT(*) FROM announcement_reactions WHERE announcement_id = a.id AND reaction_type = "dislike") as dislikes
                  FROM announcements a
                  JOIN users u ON a.created_by = u.id
                  WHERE a.status = :status';

        if (!empty($searchTerm)) {
            $query .= ' AND (a.title LIKE :searchTerm OR a.content LIKE :searchTerm)';
        }

        $query .= ' ORDER BY a.updated_at DESC';

        $this->db->query($query);
        $this->db->bind(':status', 'active');

        if (!empty($searchTerm)) {
            $this->db->bind(':searchTerm', '%' . $searchTerm . '%');
        }

        return $this->db->resultSet();
    }

    public function addReaction($data)
    {
        $this->db->query('DELETE FROM announcement_reactions WHERE announcement_id = :announcement_id AND user_id = :user_id');
        $this->db->bind(':announcement_id', $data['announcement_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->execute();

        $this->db->query('INSERT INTO announcement_reactions (announcement_id, user_id, reaction_type) 
                         VALUES (:announcement_id, :user_id, :reaction_type)');
        $this->db->bind(':announcement_id', $data['announcement_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':reaction_type', $data['reaction_type']);
        return $this->db->execute();
    }

    public function getUserReaction($announcementId, $userId)
    {
        $this->db->query('SELECT reaction_type FROM announcement_reactions 
                         WHERE announcement_id = :announcement_id AND user_id = :user_id');
        $this->db->bind(':announcement_id', $announcementId);
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }


    //DONE BY SANKAVI FOR THE ADMIN AND SUPER ADMIN DASHBOARDS
    public function getActiveAnnouncements()
    {
        try {
            $this->db->query('
                SELECT title
                FROM announcements
                WHERE status = :status
                ORDER BY created_at DESC
            ');
            $this->db->bind(':status', 'active');
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error fetching announcements: " . $e->getMessage());
            return [];
        }
    }
}
