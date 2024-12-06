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

            // First delete all reactions associated with this announcement
            $this->db->query('DELETE FROM announcement_reactions WHERE announcement_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Then delete the announcement
            $this->db->query('DELETE FROM announcements WHERE id = :id');
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

    public function getAnnouncementStats()
    {
        // Get total announcements
        $this->db->query('SELECT COUNT(*) as total FROM announcements');
        $total = $this->db->single()['total'];

        // Get active announcements (created within last 30 days)
        $this->db->query('SELECT COUNT(*) as active FROM announcements WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)');
        $active = $this->db->single()['active'];

        // Get this month's announcements
        $this->db->query('SELECT COUNT(*) as monthly FROM announcements WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())');
        $monthly = $this->db->single()['monthly'];

        // Get total reactions
        $this->db->query('SELECT COUNT(*) as total_reactions FROM announcement_reactions');
        $reactions = $this->db->single()['total_reactions'];

        return [
            'total' => $total,
            'active' => $active,
            'monthly' => $monthly,
            'reactions' => $reactions
        ];
    }

// Update getAllAnnouncements to include type and status
public function getAllAnnouncements($searchTerm = '')
{
    $query = 'SELECT a.*, u.name as creator_name,
              CASE 
                WHEN DATEDIFF(NOW(), a.created_at) <= 30 THEN "active"
                ELSE "archived"
              END as status
              FROM announcements a
              JOIN users u ON a.created_by = u.id';

    if (!empty($searchTerm)) {
        $query .= ' WHERE a.title LIKE :searchTerm OR a.content LIKE :searchTerm';
    }

    $query .= ' ORDER BY a.created_at DESC';

    $this->db->query($query);

    if (!empty($searchTerm)) {
        $this->db->bind(':searchTerm', '%' . $searchTerm . '%');
    }

    return $this->db->resultSet();
}

    public function addReaction($data)
    {
        // First remove any existing reaction from this user
        $this->db->query('DELETE FROM announcement_reactions WHERE announcement_id = :announcement_id AND user_id = :user_id');
        $this->db->bind(':announcement_id', $data['announcement_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->execute();

        // Add new reaction
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
}
