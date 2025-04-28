<?php
class M_Posts
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllPosts($search = '')
    {
        $sql = 'SELECT p.*, u.name as creator_name,
                (SELECT COUNT(*) FROM post_reactions 
                 WHERE post_id = p.id AND reaction_type = "like") as likes,
                (SELECT COUNT(*) FROM post_reactions 
                 WHERE post_id = p.id AND reaction_type = "dislike") as dislikes,
                (SELECT COUNT(*) FROM post_comments 
                 WHERE post_id = p.id) as comment_count
                FROM posts p
                JOIN users u ON p.created_by = u.id';

        if (!empty($search)) {
            $sql .= ' WHERE p.description LIKE :search';
        }

        $sql .= ' ORDER BY p.created_at DESC';

        $this->db->query($sql);

        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }

        return $this->db->resultSet();
    }

    public function createPost($data)
    {
        $this->db->query('INSERT INTO posts (description, date, time, image_data, image_type, created_by) 
                         VALUES (:description, :date, :time, :image_data, :image_type, :created_by)');

        // Bind values
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':time', $data['time']);
        $this->db->bind(':image_data', $data['image_data']);
        $this->db->bind(':image_type', $data['image_type']);
        $this->db->bind(':created_by', $data['created_by']);

        return $this->db->execute();
    }

    public function getPostById($id)
    {
        $this->db->query('SELECT p.*, u.name as creator_name,
                         (SELECT COUNT(*) FROM post_reactions 
                          WHERE post_id = p.id AND reaction_type = "like") as likes,
                         (SELECT COUNT(*) FROM post_reactions 
                          WHERE post_id = p.id AND reaction_type = "dislike") as dislikes
                         FROM posts p
                         JOIN users u ON p.created_by = u.id
                         WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updatePost($data)
    {
        if (!empty($data['image_data'])) {
            $this->db->query('UPDATE posts 
                             SET description = :description, 
                                 date = :date, 
                                 time = :time, 
                                 image_data = :image_data, 
                                 image_type = :image_type 
                             WHERE id = :id');

            $this->db->bind(':image_data', $data['image_data']);
            $this->db->bind(':image_type', $data['image_type']);
        } else {
            $this->db->query('UPDATE posts 
                             SET description = :description, 
                                 date = :date, 
                                 time = :time 
                             WHERE id = :id');
        }

        $this->db->bind(':description', $data['description']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':time', $data['time']);
        $this->db->bind(':id', $data['id']);

        return $this->db->execute();
    }

    public function deletePost($id)
    {
        try {
            $this->db->beginTransaction();

            $this->db->query('DELETE pr FROM post_reports pr
                             INNER JOIN post_comments pc ON pr.post_id = pc.id
                             WHERE pc.post_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query('DELETE FROM post_comments WHERE post_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query('DELETE FROM post_reactions WHERE post_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query('DELETE FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting post: " . $e->getMessage());
            return false;
        }
    }

    public function addReaction($data)
    {
        $this->db->query('DELETE FROM post_reactions WHERE post_id = :post_id AND user_id = :user_id');
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->execute();

        $this->db->query('INSERT INTO post_reactions (post_id, user_id, reaction_type) 
                         VALUES (:post_id, :user_id, :reaction_type)');
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':reaction_type', $data['reaction_type']);
        return $this->db->execute();
    }

    public function getUserReaction($postId, $userId)
    {
        $this->db->query('SELECT reaction_type FROM post_reactions 
                         WHERE post_id = :post_id AND user_id = :user_id');
        $this->db->bind(':post_id', $postId);
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function getPostImage($id)
    {
        $this->db->query('SELECT image_data, image_type FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getPostsByUserId($userId)
    {
        $this->db->query('SELECT p.*, u.name as creator_name,
                         (SELECT COUNT(*) FROM post_reactions 
                          WHERE post_id = p.id AND reaction_type = "like") as likes,
                         (SELECT COUNT(*) FROM post_reactions 
                          WHERE post_id = p.id AND reaction_type = "dislike") as dislikes,
                         (SELECT COUNT(*) FROM post_comments 
                          WHERE post_id = p.id) as comment_count
                         FROM posts p
                         JOIN users u ON p.created_by = u.id
                         WHERE p.created_by = :user_id
                         ORDER BY p.created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function addComment($data)
    {
        $this->db->query('INSERT INTO post_comments (post_id, user_id, comment) 
                         VALUES (:post_id, :user_id, :comment)');
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':comment', $data['comment']);
        return $this->db->execute();
    }

    public function getCommentsByPostId($postId)
    {
        $this->db->query('SELECT pc.*, u.name as user_name 
                         FROM post_comments pc
                         JOIN users u ON pc.user_id = u.id
                         WHERE pc.post_id = :post_id
                         ORDER BY pc.created_at ASC');
        $this->db->bind(':post_id', $postId);
        return $this->db->resultSet();
    }

    public function deleteComment($id)
    {
        try {
            $this->db->beginTransaction();

            // Delete reports first
            $this->db->query('DELETE FROM post_reports WHERE post_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Delete the comment
            $this->db->query('DELETE FROM post_comments WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Comment deletion error: " . $e->getMessage());  // Add this line
            return false;
        }
    }

    public function isPostCreator($postId, $userId)
    {
        $this->db->query('SELECT * FROM posts WHERE id = :post_id AND created_by = :user_id');
        $this->db->bind(':post_id', $postId);
        $this->db->bind(':user_id', $userId);
        return $this->db->rowCount() > 0;
    }


    public function getUserRoleById($userId)
    {
        $this->db->query('SELECT role_id FROM users WHERE id = :user_id');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result ? $result['role_id'] : null;
    }

    public function getCommentById($id)
    {
        $this->db->query('SELECT * FROM post_comments WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }



    public function createReport($data)
    {
        $this->db->beginTransaction();

        try {
            $this->db->query('INSERT INTO post_reports (post_id, reported_by, reason)
                            VALUES(:post_id, :reported_by, :reason)');
            $this->db->bind(':post_id', $data['post_id']);
            $this->db->bind(':reported_by', $data['reported_by']);
            $this->db->bind(':reason', $data['reason']);

            $this->db->execute();

            $this->db->query("UPDATE posts SET is_reported = 1 
                             WHERE id = :post_id");
            $this->db->bind(':post_id', $data['post_id']);
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

    public function getReportedPosts()
    {
        $this->db->query("SELECT p.*, 
                     u1.name AS author_name, 
                     u2.name AS reporter_name,
                     pr.id AS report_id, 
                     pr.reason, 
                     pr.reported_by, 
                     pr.created_at AS report_date
                     FROM posts p
                     INNER JOIN post_reports pr ON p.id = pr.post_id
                     JOIN users u1 ON p.created_by = u1.id
                     JOIN users u2 ON pr.reported_by = u2.id
                     WHERE p.is_reported = 1
                     ORDER BY pr.created_at DESC");
        return $this->db->resultSet();
    }

    public function ignoreReport($id)
    {
        // Start transaction
        $this->db->beginTransaction();

        try {
            $this->db->query("UPDATE posts SET is_reported = 0 WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query("DELETE FROM post_reports WHERE post_id = :id");
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
}
