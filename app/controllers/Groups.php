<?php
class Groups extends Controller
{
    protected $groupsModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if user has appropriate role
        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            redirect('users/login');
        }

        $this->groupsModel = $this->model('M_Groups');
    }

    public function index()
    {
        $groups = $this->groupsModel->getAllGroups();
        $data = ['groups' => $groups];
        $this->view('groups/index', $data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'category' => trim($_POST['category']),
                'description' => trim($_POST['description']),
                'created_by' => $_SESSION['user_id'],
                'image_data' => null,
                'image_type' => null
            ];
    
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                $data['image_type'] = $_FILES['image']['type'];
            }
    
            if ($this->groupsModel->createGroup($data)) {
                if ($_SESSION['user_role_id'] == 2) {
                    redirect('groups/admin_dashboard');
                } else {
                    redirect('groups/index');
                }
            }
        }
        $this->view('groups/create');
    }

      // Add this method to serve images
      public function getImage($id) {
        $group = $this->groupsModel->getGroupById($id);
        if ($group && $group->image_data) {
            header("Content-Type: " . $group->image_type);
            echo $group->image_data;
            exit();
        }
    }
    
      public function viewgroup($id) {
        $group = $this->groupsModel->getGroupById($id);
        $memberCount = $this->groupsModel->getMemberCount($id);
        $isJoined = $group['is_member'] > 0;

        $data = [
            'group' => $group,
            'member_count' => $memberCount,
            'isJoined' => $isJoined,
        ];

        $this->view('groups/viewgroup', $data);
    }
    public function joined() {
        $groups = $this->groupsModel->getJoinedGroups($_SESSION['user_id']);
        $data = ['groups' => $groups];
        $this->view('groups/joined', $data);
    }

    public function join($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $groups = $this->groupsModel->getGroupById($id);

            if (!$groups) {
                die('Group not found');
            }
            if ($this->groupsModel->joinGroup($id, $_SESSION['user_id'])) {
                $newCount = $this->groupsModel->getMemberCount($id);
                echo json_encode(['success' => true, 'memberCount' => $newCount]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to join group']);
            }
            exit;
        }
        redirect('groups/viewgroup/' . $id);
    }

    public function leave($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->groupsModel->leaveGroup($id, $_SESSION['user_id'])) {
                $newCount = $this->groupsModel->getMemberCount($id);
                echo json_encode(['success' => true, 'memberCount' => $newCount]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to leave group']);
            }
            exit;
        }
        redirect('groups/viewgroup/' . $id);
    }
    public function my_groups() {
        $groups = $this->groupsModel->getGroupsByUser($_SESSION['user_id']);
        $data = ['groups' => $groups];
        $this->view('groups/my_groups', $data);
    }
    
    public function getMembers($groupId) {
        $members = $this->groupsModel->getGroupMembers($groupId);
        header('Content-Type: application/json');
        echo json_encode($members);
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'category' => trim($_POST['category']),
                'description' => trim($_POST['description']),
                'image_data' => null,
                'image_type' => null
            ];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                $data['image_type'] = $_FILES['image']['type'];
            }

            if ($this->groupsModel->updateGroup($data)) {
                if ($_SESSION['user_role_id'] == 2) {
                    redirect('groups/admin_dashboard');
                } else {
                    redirect('groups/my_groups');
                }
            }
        } else {
            $group = $this->groupsModel->getGroupById($id);
            
            if (!$group) {
                redirect('groups/my_groups');
            }

            $data = [
                'id' => $id,
                'title' => $group['group_name'],
                'category' => $group['group_category'],
                'description' => $group['group_description']
            ];
        }
        
        $this->view('groups/update', $data);
    }
    public function chat()
    {
        $this->view('groups/chat');
    }
    public function admin_dashboard()
    {
        $groups = $this->groupsModel->getAllGroups();
        $active_members = $this->groupsModel->getTotalMembersCount();
        $total_discussions = $this->groupsModel->getTotalDiscussionsCount();
    
        $data = [
            'groups' => $groups,
            'active_members' => $active_members,
            'total_discussions' => $total_discussions
        ];
    
        $this->view('groups/admin_dashboard', $data);
    }    
      public function delete($id)
      {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              if ($this->groupsModel->deleteGroup($id)) {
                  flash('group_message', 'Group Removed');
                  if ($_SESSION['user_role_id'] == 2) {
                      redirect('groups/admin_dashboard');
                  } else {
                      redirect('groups/my_groups');
                  }
              }
          }
      }
      public function searchGroups()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $searchTerm = trim($_POST['search']);
                $groups = $this->groupsModel->searchGroups($searchTerm);
                
                header('Content-Type: application/json');
                echo json_encode($groups);
            }
        }
        
    public function getMemberCount($groupId) {
        return $this->groupsModel->getMemberCount($groupId);
    }
}
