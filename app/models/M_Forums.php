<?php

class M_Forums
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllForums()
    {
        $this->db->query("SELECT * FROM forums");
        return $this->db->resultSet();
    }

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

    public function getCommentsByForumId($forum_id)
    {
        $this->db->query("SELECT * FROM forum_comments WHERE forum_id = :forum_id");
        $this->db->bind(':forum_id', $forum_id);
        return $this->db->resultSet();
    }

    public function createForum($data)
    {
        $this->db->query("INSERT INTO forums (title, description, created_by) VALUES (:title, :description, :created_by)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':created_by', $data['created_by']);
        return $this->db->execute();
    }

    public function createComment($data)
    {
        $this->db->query("INSERT INTO forum_comments (forum_id, user_id, comment) VALUES (:forum_id, :user_id, :comment)");
        $this->db->bind(':forum_id', $data['forum_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':comment', $data['comment']);
        return $this->db->execute();
    }

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
            $this->db->query("DELETE fr FROM forum_reports fr 
                             INNER JOIN forum_comments fc ON fr.forum_comment_id = fc.id 
                             WHERE fc.forum_id = :forum_id");
            $this->db->bind(':forum_id', $id);
            $this->db->execute();

            $this->db->query("DELETE FROM forum_comments WHERE forum_id = :forum_id");
            $this->db->bind(':forum_id', $id);
            $this->db->execute();

            $this->db->query("DELETE FROM forums WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting forum: " . $e->getMessage());
            return false;
        }
    }

    public function reportComment($data)
    {
        $this->db->beginTransaction();

        try {
            $this->db->query("INSERT INTO forum_reports (forum_comment_id, reported_by, reason) 
                             VALUES (:forum_comment_id, :reported_by, :reason)");
            $this->db->bind(':forum_comment_id', $data['forum_comment_id']);
            $this->db->bind(':reported_by', $data['reported_by']);
            $this->db->bind(':reason', $data['reason']);
            $this->db->execute();

            $this->db->query("UPDATE forum_comments SET reported = 1 
                             WHERE id = :forum_comment_id");
            $this->db->bind(':forum_comment_id', $data['forum_comment_id']);
            $this->db->execute();

            // Commit transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function deleteComment($id)
    {
        $this->db->query("DELETE FROM forum_comments WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function ignoreReport($id)
    {
        $this->db->beginTransaction();

        try {
            $this->db->query("UPDATE forum_comments SET reported = 0 WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query("DELETE FROM forum_reports WHERE forum_comment_id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

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
            $this->db->query("DELETE FROM forum_reports WHERE forum_comment_id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query("DELETE FROM forum_comments WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
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
