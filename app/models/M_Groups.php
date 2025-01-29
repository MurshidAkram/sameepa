
<?php
class M_Groups
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllGroups()
    {
        $this->db->query('SELECT g.*, u.name as creator_name 
                         FROM groups g 
                         LEFT JOIN users u ON g.created_by = u.id 
                         ORDER BY g.created_date DESC');
        return $this->db->resultSet();
    }
    public function createGroup($data) {
        $this->db->query('INSERT INTO groups (group_name, group_category, group_description, created_by, image_data, image_type) 
                          VALUES (:group_name, :group_category, :group_description, :created_by, :image_data, :image_type)');
        
        $this->db->bind(':group_name', $data['title']);
        $this->db->bind(':group_category', $data['category']);
        $this->db->bind(':group_description', $data['description']);
        $this->db->bind(':created_by', $data['created_by']);
        $this->db->bind(':image_data', $data['image_data']);
        $this->db->bind(':image_type', $data['image_type']);
    
        return $this->db->execute();
    }
    public function getGroupById($id) {
        $this->db->query('SELECT g.*, u.name as creator_name,
                         (SELECT COUNT(*) FROM group_members 
                          WHERE group_id = g.group_id AND user_id = :user_id) as is_member
                         FROM groups g 
                         JOIN users u ON g.created_by = u.id 
                         WHERE g.group_id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        return $this->db->single();
    }
       
    
          public function getGroupImage($id) {
              $this->db->query('SELECT image_data, image_type FROM groups WHERE group_id = :id');
              $this->db->bind(':id', $id);
              return $this->db->single();
          }
    
              public function updateGroup($data) {
                  $sql = 'UPDATE groups SET 
                          group_name = :group_name, 
                          group_category = :group_category, 
                          group_description = :group_description';
                
                  if (!empty($data['image_data'])) {
                      $sql .= ', image_data = :image_data, image_type = :image_type';
                  }
        
                  $sql .= ' WHERE group_id = :group_id';

                  $this->db->query($sql);
        
                  $this->db->bind(':group_name', $data['title']);
                  $this->db->bind(':group_category', $data['category']);
                  $this->db->bind(':group_description', $data['description']);
                  $this->db->bind(':group_id', $data['id']);

                  if (!empty($data['image_data'])) {
                      $this->db->bind(':image_data', $data['image_data']);
                      $this->db->bind(':image_type', $data['image_type']);
                  }

                  return $this->db->execute();
              }
          public function getMemberCount($groupId) {
              $this->db->query('SELECT COUNT(*) as count FROM group_members WHERE group_id = :group_id');
              $this->db->bind(':group_id', $groupId);
              $row = $this->db->single();
              return $row['count'];
          }
    
          public function isUserMember($groupId, $userId) {
              $this->db->query('SELECT 1 FROM group_members WHERE group_id = :group_id AND user_id = :user_id');
              $this->db->bind(':group_id', $groupId);
              $this->db->bind(':user_id', $userId);
              
              return $this->db->rowCount() > 0;
          }
          public function joinGroup($groupId, $userId) {
              $this->db->query('INSERT INTO group_members (group_id, user_id, joined_at) VALUES (:group_id, :user_id, NOW())');
              $this->db->bind(':group_id', $groupId);
              $this->db->bind(':user_id', $userId);
              return $this->db->execute();
          }
        
          public function leaveGroup($groupId, $userId) {
              $this->db->query('DELETE FROM group_members WHERE group_id = :group_id AND user_id = :user_id');
              $this->db->bind(':group_id', $groupId);
              $this->db->bind(':user_id', $userId);
              return $this->db->execute();
          }
        
    public function getTotalMembersCount()
    {
        $this->db->query('SELECT COUNT(*) as member_count FROM group_members');
        $result = $this->db->single();
        return (int)$result['member_count']; // Convert array access to integer return
    }
    
    public function getTotalDiscussionsCount() 
    {
        $this->db->query('SELECT COUNT(*) as discussion_count FROM group_chats');
        $result = $this->db->single();
        return (int)$result['discussion_count'];
    }
    
    public function deleteGroup($id) {
        // First delete related records from group_members
        $this->db->query('DELETE FROM group_members WHERE group_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Then delete related records from groups_report
        $this->db->query('DELETE FROM groups_report WHERE group_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Finally delete the group
        $this->db->query('DELETE FROM groups WHERE group_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    public function getGroupsByUser($userId) {
        $this->db->query('SELECT g.*, u.name as creator_name 
                         FROM groups g 
                         JOIN users u ON g.created_by = u.id 
                         WHERE g.created_by = :user_id 
                         ORDER BY g.created_date DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    
    public function getGroupMembers($groupId) {
        $this->db->query('SELECT u.name, gm.joined_at 
                         FROM group_members gm 
                         JOIN users u ON gm.user_id = u.id 
                         WHERE gm.group_id = :group_id 
                         ORDER BY gm.joined_at ASC');
        $this->db->bind(':group_id', $groupId);
        return $this->db->resultSet();
    }
    
    public function getJoinedGroups($userId) {
        $this->db->query('SELECT g.*, u.name as creator_name 
                         FROM groups g 
                         JOIN users u ON g.created_by = u.id 
                         JOIN group_members gm ON g.group_id = gm.group_id 
                         WHERE gm.user_id = :user_id 
                         ORDER BY g.created_date DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    public function reportGroup($groupId, $userId, $reason) {
        $this->db->query('INSERT INTO groups_report (group_id, reported_by, reason) VALUES (:group_id, :reported_by, :reason)');
        
        $this->db->bind(':group_id', $groupId);
        $this->db->bind(':reported_by', $userId);
        $this->db->bind(':reason', $reason);
        
        return $this->db->execute();
    }
    
    public function getGroupReports($groupId) {
        $this->db->query('SELECT gr.*, u.name as reporter_name 
                          FROM groups_report gr 
                          JOIN users u ON gr.reported_by = u.id 
                          WHERE gr.group_id = :group_id 
                          ORDER BY gr.created_at DESC');
        
        $this->db->bind(':group_id', $groupId);
        return $this->db->resultSet();
    }
    public function getReportedGroups() {
        $this->db->query('SELECT gr.*, g.group_name, g.group_description, u.name as reporter_name 
                          FROM groups_report gr 
                          JOIN groups g ON gr.group_id = g.group_id 
                          JOIN users u ON gr.reported_by = u.id 
                          ORDER BY gr.created_at DESC');
        return $this->db->resultSet();
    }   
    
    public function ignoreReport($reportId) {
        $this->db->query('DELETE FROM groups_report WHERE id = :id');
        $this->db->bind(':id', $reportId);
        return $this->db->execute();
    }
    public function saveMessage($groupId, $userId, $message) {
        $this->db->query('INSERT INTO group_chats (group_id, user_id, message) VALUES (:group_id, :user_id, :message)');
        $this->db->bind(':group_id', $groupId);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':message', $message);
        return $this->db->execute();
    }
    
    public function getGroupMessages($groupId) {
        $this->db->query('SELECT gc.*, u.name as sender_name, u.profile_picture 
                          FROM group_chats gc 
                          JOIN users u ON gc.user_id = u.id 
                          WHERE gc.group_id = :group_id 
                          ORDER BY gc.sent_at ASC');
        $this->db->bind(':group_id', $groupId);
        return $this->db->resultSet();
    }
}
