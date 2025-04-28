<?php
class M_Polls
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function createPoll($data)
    {
        $this->db->beginTransaction();

        try {
            $this->db->query("INSERT INTO polls (title, description, created_by, end_date) 
                             VALUES (:title, :description, :created_by, :end_date)");

            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':created_by', $data['created_by']);
            $this->db->bind(':end_date', $data['end_date']);

            $this->db->execute();

            $pollId = $this->db->lastInsertId();

            foreach ($data['choices'] as $choice) {
                if (!empty(trim($choice))) {
                    $this->db->query("INSERT INTO poll_choices (poll_id, choice_text) 
                                    VALUES (:poll_id, :choice_text)");

                    $this->db->bind(':poll_id', $pollId);
                    $this->db->bind(':choice_text', trim($choice));

                    $this->db->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error creating poll: " . $e->getMessage());
            return false;
        }
    }

    public function getAllPolls()
    {
        $this->db->query("SELECT p.*, 
                         u.name as creator_name,
                         COUNT(DISTINCT pv.id) as total_votes,
                         COUNT(DISTINCT pc.id) as total_choices
                         FROM polls p
                         LEFT JOIN users u ON p.created_by = u.id
                         LEFT JOIN poll_choices pc ON p.id = pc.poll_id
                         LEFT JOIN poll_votes pv ON p.id = pv.poll_id
                         GROUP BY p.id, u.name
                         ORDER BY p.created_at DESC");

        return $this->db->resultSet();
    }

    public function hasPollEnded($endDate)
    {
        return strtotime($endDate) < strtotime('today');
    }

    public function getUserVote($pollId, $userId)
    {
        $this->db->query("SELECT choice_id FROM poll_votes 
                         WHERE poll_id = :poll_id AND user_id = :user_id");
        $this->db->bind(':poll_id', $pollId);
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }


    public function getPollById($id)
    {
        $this->db->query("SELECT p.*, u.name as creator_name 
                      FROM polls p 
                      LEFT JOIN users u ON p.created_by = u.id 
                      WHERE p.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getPollChoices($pollId)
    {
        $this->db->query("SELECT pc.*, 
                      COUNT(pv.id) as vote_count,
                      (SELECT COUNT(*) FROM poll_votes WHERE poll_id = :poll_id) as total_votes
                      FROM poll_choices pc
                      LEFT JOIN poll_votes pv ON pc.id = pv.choice_id
                      WHERE pc.poll_id = :poll_id2
                      GROUP BY pc.id");
        $this->db->bind(':poll_id', $pollId);
        $this->db->bind(':poll_id2', $pollId);
        return $this->db->resultSet();
    }

    public function getVotersByChoice($choiceId)
    {
        $this->db->query("SELECT u.name 
                      FROM poll_votes pv
                      JOIN users u ON pv.user_id = u.id
                      WHERE pv.choice_id = :choice_id
                      ORDER BY u.name");
        $this->db->bind(':choice_id', $choiceId);
        return $this->db->resultSet();
    }

    public function votepoll($pollId, $choiceId, $userId)
    {
        // Start transaction
        $this->db->beginTransaction();

        try {
            $this->db->query("DELETE FROM poll_votes 
                         WHERE poll_id = :poll_id AND user_id = :user_id");
            $this->db->bind(':poll_id', $pollId);
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            $this->db->query("INSERT INTO poll_votes (poll_id, choice_id, user_id) 
                         VALUES (:poll_id, :choice_id, :user_id)");
            $this->db->bind(':poll_id', $pollId);
            $this->db->bind(':choice_id', $choiceId);
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error voting in poll: " . $e->getMessage());
            return false;
        }
    }

    public function getCurrentUserVote($pollId, $userId)
    {
        $this->db->query("SELECT choice_id 
                      FROM poll_votes 
                      WHERE poll_id = :poll_id AND user_id = :user_id");
        $this->db->bind(':poll_id', $pollId);
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result ? $result['choice_id'] : null;
    }

    public function getPollsbyUserID($userId)
    {
        $this->db->query("SELECT p.*, 
                      u.name as creator_name,
                      COUNT(DISTINCT pv.id) as total_votes,
                      COUNT(DISTINCT pc.id) as total_choices
                      FROM polls p
                      LEFT JOIN users u ON p.created_by = u.id
                      LEFT JOIN poll_choices pc ON p.id = pc.poll_id
                      LEFT JOIN poll_votes pv ON p.id = pv.poll_id
                      WHERE p.created_by = :user_id
                      GROUP BY p.id, u.name
                      ORDER BY p.created_at DESC");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function deletePoll($id)
    {
        $this->db->beginTransaction();

        try {
            $this->db->query("DELETE FROM poll_choices WHERE poll_id = :poll_id");
            $this->db->bind(':poll_id', $id);
            $this->db->execute();

            //delete poll votes
            $this->db->query("DELETE FROM poll_votes WHERE poll_id = :poll_id");
            $this->db->bind(':poll_id', $id);
            $this->db->execute();

            //delete poll
            $this->db->query("DELETE FROM polls WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting poll: " . $e->getMessage());
            return false;
        }
    }

    public function unvotedPolls($userID)
    {
        $this->db->query('SELECT p.*, u.name as creator_name 
                     FROM polls p
                     JOIN users u ON p.created_by = u.id
                     WHERE p.id NOT IN (
                         SELECT poll_id FROM poll_votes WHERE user_id = :user_id
                     )
                     AND p.end_date >= CURDATE()
                     ORDER BY p.created_at DESC');
        $this->db->bind(':user_id', $userID);
        return $this->db->resultSet();
    }
}
