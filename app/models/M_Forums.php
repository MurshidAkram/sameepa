<?php

class M_Forums
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Get all forums
    public function getAllForums()
    {
        $this->db->query("SELECT * FROM forums");
        return $this->db->resultSet();
    }

    // Get a specific forum by its ID
    public function getForumById($id)
    {
        $this->db->query("SELECT * FROM forums WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getUserNameById($userId)
    {
        $this->db->query("SELECT name FROM users WHERE id = :id");
        $this->db->bind(':id', $userId);
        $result = $this->db->single();
        return $result['name'];
    }

    // Get all comments for a specific forum
    public function getCommentsByForumId($forum_id)
    {
        $this->db->query("SELECT * FROM forum_comments WHERE forum_id = :forum_id");
        $this->db->bind(':forum_id', $forum_id);
        return $this->db->resultSet();
    }

    // Create a new forum
    public function createForum($data)
    {
        $this->db->query("INSERT INTO forums (title, description, created_by) VALUES (:title, :description, :created_by)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':created_by', $data['created_by']);
        return $this->db->execute();
    }

    // Create a new comment for a forum
    public function createComment($data)
    {
        $this->db->query("INSERT INTO forum_comments (forum_id, user_id, comment) VALUES (:forum_id, :user_id, :comment)");
        $this->db->bind(':forum_id', $data['forum_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':comment', $data['comment']);
        return $this->db->execute();
    }

    // Update a forum
    public function updateForum($id, $data)
    {
        $this->db->query("UPDATE forums SET title = :title, description = :description, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    public function deleteForum($id)
    {
        // Start transaction
        $this->db->beginTransaction();

        try {
            // First delete any reports associated with the forum's comments
            $this->db->query("DELETE fr FROM forum_reports fr 
                             INNER JOIN forum_comments fc ON fr.forum_comment_id = fc.id 
                             WHERE fc.forum_id = :forum_id");
            $this->db->bind(':forum_id', $id);
            $this->db->execute();

            // Then delete all comments for this forum
            $this->db->query("DELETE FROM forum_comments WHERE forum_id = :forum_id");
            $this->db->bind(':forum_id', $id);
            $this->db->execute();

            // Finally delete the forum itself
            $this->db->query("DELETE FROM forums WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // If everything worked, commit the transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // If anything went wrong, rollback the changes
            $this->db->rollBack();
            error_log("Error deleting forum: " . $e->getMessage());
            return false;
        }
    }
    // Report a comment
    public function reportComment($data)
    {
        // Start transaction
        $this->db->beginTransaction();

        try {
            // Insert into forum_reports table
            $this->db->query("INSERT INTO forum_reports (forum_comment_id, reported_by, reason) 
                             VALUES (:forum_comment_id, :reported_by, :reason)");
            $this->db->bind(':forum_comment_id', $data['forum_comment_id']);
            $this->db->bind(':reported_by', $data['reported_by']);
            $this->db->bind(':reason', $data['reason']);
            $this->db->execute();

            // Update the reported flag in forum_comments table
            $this->db->query("UPDATE forum_comments SET reported = 1 
                             WHERE id = :forum_comment_id");
            $this->db->bind(':forum_comment_id', $data['forum_comment_id']);
            $this->db->execute();

            // Commit transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollback();
            return false;
        }
    }

    // Delete a comment
    public function deleteComment($id)
    {
        $this->db->query("DELETE FROM forum_comments WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function ignoreReport($id)
    {
        // Start transaction
        $this->db->beginTransaction();

        try {
            // Update the reported flag in forum_comments
            $this->db->query("UPDATE forum_comments SET reported = 0 WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Delete the report from forum_reports
            $this->db->query("DELETE FROM forum_reports WHERE forum_comment_id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Commit transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollback();
            return false;
        }
    }

    // Get all reported comments for a forum
    public function getReportedCommentsByForumId($forum_id)
    {
        $this->db->query("SELECT fc.*, fr.id AS report_id, fr.reason, fr.reported_by, fr.created_at AS report_date
                         FROM forum_comments fc
                         INNER JOIN forum_reports fr ON fc.id = fr.forum_comment_id
                         WHERE fc.forum_id = :forum_id AND fc.reported = 1
                         ORDER BY fr.created_at DESC");
        $this->db->bind(':forum_id', $forum_id);
        return $this->db->resultSet();
    }

    public function getCommentCountByForumId($forumId)
    {
        $this->db->query("SELECT COUNT(*) as comment_count FROM forum_comments WHERE forum_id = :forum_id");
        $this->db->bind(':forum_id', $forumId);
        $result = $this->db->single();
        return $result['comment_count'];
    }

    public function getCommentById($id)
    {
        $this->db->query("SELECT * FROM forum_comments WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function deleteReportedComment($id)
    {
        // Start transaction
        $this->db->beginTransaction();

        try {
            // Delete from forum_reports first (due to foreign key constraint)
            $this->db->query("DELETE FROM forum_reports WHERE forum_comment_id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Then delete from forum_comments
            $this->db->query("DELETE FROM forum_comments WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Commit transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollback();
            return false;
        }
    }

    public function getForumsByUserId($userId)
    {
        $this->db->query("SELECT * FROM forums WHERE created_by = :user_id ORDER BY created_at DESC");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}
