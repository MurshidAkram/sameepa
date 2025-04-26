<?php
class M_Complaints
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUserComplaints($userId)
    {
        $this->db->query('SELECT c.*, 
                        (SELECT response FROM complaint_responses 
                         WHERE complaint_id = c.id 
                         ORDER BY created_at DESC LIMIT 1) as latest_response
                        FROM complaints c 
                        WHERE c.user_id = :user_id 
                        ORDER BY c.created_at DESC');

        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function createComplaint($data)
    {
        $this->db->query('INSERT INTO complaints (user_id, title, description) 
                         VALUES (:user_id, :title, :description)');

        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    public function getComplaintById($id, $userId = null)
    {
        $query = 'SELECT c.*, u.name as user_name,
                  (SELECT response FROM complaint_responses 
                   WHERE complaint_id = c.id 
                   ORDER BY created_at DESC LIMIT 1) as latest_response
                  FROM complaints c 
                  JOIN users u ON c.user_id = u.id
                  WHERE c.id = :id';

        if ($userId) {
            $query .= ' AND c.user_id = :user_id';
        }

        $this->db->query($query);
        $this->db->bind(':id', $id);
        if ($userId) {
            $this->db->bind(':user_id', $userId);
        }

        return $this->db->single();
    }

    public function getComplaintsByRole($roleId, $adminId = null)
    {
        $query = 'SELECT c.*, u.name as user_name 
                  FROM complaints c 
                  JOIN users u ON c.user_id = u.id 
                  WHERE u.role_id = :role_id';

        if ($adminId) {
            $query .= ' AND (u.role_id != 2 OR c.user_id = :admin_id)';
        }

        $query .= ' ORDER BY c.created_at DESC';

        $this->db->query($query);
        $this->db->bind(':role_id', $roleId);

        if ($adminId) {
            $this->db->bind(':admin_id', $adminId);
        }

        return $this->db->resultSet();
    }

    public function getDashboardStats($adminId = null)
    {
        $baseQuery = 'SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
                        SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved
                      FROM complaints c
                      JOIN users u ON c.user_id = u.id';

        if ($adminId) {
            $baseQuery .= ' WHERE (u.role_id != 2 OR c.user_id = :admin_id)';
            $this->db->query($baseQuery);
            $this->db->bind(':admin_id', $adminId);
        } else {
            $this->db->query($baseQuery);
        }

        return $this->db->single();
    }

    public function getComplaintDetails($complaintId)
    {
        $this->db->query('SELECT c.*, u.name as user_name,
                    (SELECT GROUP_CONCAT(
                        JSON_OBJECT(
                            "id", cr.id,
                            "response", cr.response,
                            "admin_name", admin.name,
                            "created_at", cr.created_at
                        )
                    ) 
                    FROM complaint_responses cr
                    JOIN users admin ON cr.admin_id = admin.id
                    WHERE cr.complaint_id = c.id
                    ORDER BY cr.created_at DESC) as responses
                    FROM complaints c
                    JOIN users u ON c.user_id = u.id
                    WHERE c.id = :id');

        $this->db->bind(':id', $complaintId);
        $result = $this->db->single();

        if ($result) {
            // Convert result to object if it's an array
            $result = (object)$result;
            // Parse the JSON responses string into an array
            $result->responses = $result->responses ? json_decode('[' . $result->responses . ']') : [];
        }

        return $result;
    }

    public function addResponse($data)
    {
        try {
            $this->db->beginTransaction();

            // Add the response
            $this->db->query('INSERT INTO complaint_responses (complaint_id, admin_id, response)
                             VALUES (:complaint_id, :admin_id, :response)');

            $this->db->bind(':complaint_id', $data['complaint_id']);
            $this->db->bind(':admin_id', $data['admin_id']);
            $this->db->bind(':response', $data['response']);

            $responseAdded = $this->db->execute();

            // Update complaint status if provided
            if (isset($data['status'])) {
                $this->db->query('UPDATE complaints 
                                 SET status = :status,
                                     resolved_at = CASE 
                                         WHEN :status = "resolved" THEN CURRENT_TIMESTAMP
                                         ELSE NULL 
                                     END
                                 WHERE id = :complaint_id');

                $this->db->bind(':status', $data['status']);
                $this->db->bind(':complaint_id', $data['complaint_id']);

                $statusUpdated = $this->db->execute();
            } else {
                $statusUpdated = true;
            }

            if ($responseAdded && $statusUpdated) {
                $this->db->commit();
                return true;
            }

            $this->db->rollBack();
            return false;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function canAccessComplaint($userId, $userRoleId, $complaintId)
    {
        if ($userRoleId == 3) { // Superadmin can access all
            return true;
        }

        $this->db->query('SELECT c.*, u.role_id 
                         FROM complaints c
                         JOIN users u ON c.user_id = u.id
                         WHERE c.id = :complaint_id');

        $this->db->bind(':complaint_id', $complaintId);
        $complaint = $this->db->single();

        if (!$complaint) {
            return false;
        }

        // If user is the complaint owner
        if ($complaint['user_id'] == $userId) {
            return true;
        }

        // If user is admin, they can access all except other admin complaints
        if ($userRoleId == 2) {
            return $complaint['role_id'] != 2 || $complaint['user_id'] == $userId;
        }

        return false;
    }

    public function deleteComplaint($complaintId, $userId)
    {
        // First check if complaint exists and is pending
        $this->db->query('SELECT status, user_id FROM complaints WHERE id = :id');
        $this->db->bind(':id', $complaintId);
        $complaint = $this->db->single();

        if (!$complaint || $complaint['status'] !== 'pending' || $complaint['user_id'] !== $userId) {
            return false;
        }

        // If validation passes, delete the complaint
        $this->db->query('DELETE FROM complaints WHERE id = :id AND user_id = :user_id AND status = "pending"');
        $this->db->bind(':id', $complaintId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }
    public function getComplaints()
    {
        try {
            $this->db->query('
                SELECT title,status
                FROM complaints
                where status="pending"
                ORDER BY created_at DESC
            ');
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error fetching complaints: " . $e->getMessage());
            return [];
        }
    }
}
