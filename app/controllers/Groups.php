<?php
class Groups extends Controller
{
    protected $groupsModel;
    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            $this->userModel = $this->model('User');
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
                'image_type' => null,
                'errors' => []
            ];
    
            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                // Check for upload errors
                if ($_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE || 
                    $_FILES['image']['error'] === UPLOAD_ERR_FORM_SIZE) {
                    $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                } 
                else if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $data['errors'][] = 'There was an error uploading the image. Error code: ' . $_FILES['image']['error'];
                }
                else {
                    // Check file size (1MB limit)
                    $maxSize = 1 * 1024 * 1024; // 1MB in bytes
                    if ($_FILES['image']['size'] > $maxSize) {
                        $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                    } 
                    else {
                        // Check file type
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                            $data['errors'][] = 'Invalid file type. Only JPG, PNG, and GIF images are allowed.';
                        } 
                        else {
                            // All checks passed, process the image
                            try {
                                // Get the file size
                                $fileSize = filesize($_FILES['image']['tmp_name']);
                                
                                // Check if file size is within MySQL's max_allowed_packet limit
                                if ($fileSize > 1048576) { // 1MB in bytes
                                    $data['errors'][] = 'Image is too large for database storage. Please use an image smaller than 1MB.';
                                } else {
                                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                                    $data['image_type'] = $_FILES['image']['type'];
                                }
                            } catch (Exception $e) {
                                $data['errors'][] = 'Error processing image: ' . $e->getMessage();
                            }
                        }
                    }
                }
            }
    
            if (empty($data['errors'])) {
                try {
                    if ($this->groupsModel->createGroup($data)) {
                        if ($_SESSION['user_role_id'] == 2) {
                            redirect('groups/admin_dashboard');
                        } else {
                            redirect('groups/index');
                        }
                    }
                } catch (PDOException $e) {
                    // Handle database errors
                    if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                        $data['errors'][] = 'The image is too large for the database. Please use a smaller image (less than 1MB).';
                    } else {
                        $data['errors'][] = 'Database error: ' . $e->getMessage();
                    }
                    $this->view('groups/create', $data);
                }
            } else {
                // If there are errors, show the form again with error messages
                $this->view('groups/create', $data);
            }
        } else {
            // Initial GET request
            $data = [
                'title' => '',
                'category' => '',
                'description' => '',
                'errors' => []
            ];
            $this->view('groups/create', $data);
        }
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
                'image_type' => null,
                'errors' => []
            ];
    
            // Handle file upload if a new image is provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                // Check for upload errors
                if ($_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE || 
                    $_FILES['image']['error'] === UPLOAD_ERR_FORM_SIZE) {
                    $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                } 
                else if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $data['errors'][] = 'There was an error uploading the image. Error code: ' . $_FILES['image']['error'];
                }
                else {
                    // Check file size (1MB limit)
                    $maxSize = 1 * 1024 * 1024; // 1MB in bytes
                    if ($_FILES['image']['size'] > $maxSize) {
                        $data['errors'][] = 'The uploaded image is too large. Maximum size is 1MB.';
                    } 
                    else {
                        // Check file type
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                            $data['errors'][] = 'Invalid file type. Only JPG, PNG, and GIF images are allowed.';
                        } 
                        else {
                            // All checks passed, process the image
                            try {
                                // Get the file size
                                $fileSize = filesize($_FILES['image']['tmp_name']);
                                
                                // Check if file size is within MySQL's max_allowed_packet limit
                                if ($fileSize > 1048576) { // 1MB in bytes
                                    $data['errors'][] = 'Image is too large for database storage. Please use an image smaller than 1MB.';
                                } else {
                                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                                    $data['image_type'] = $_FILES['image']['type'];
                                }
                            } catch (Exception $e) {
                                $data['errors'][] = 'Error processing image: ' . $e->getMessage();
                            }
                        }
                    }
                }
            }
    
            if (empty($data['errors'])) {
                try {
                    if ($this->groupsModel->updateGroup($data)) {
                        if ($_SESSION['user_role_id'] == 2) {
                            redirect('groups/admin_dashboard');
                        } else {
                            redirect('groups/my_groups');
                        }
                    }
                } catch (PDOException $e) {
                    // Handle database errors
                    if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                        $data['errors'][] = 'The image is too large for the database. Please use a smaller image (less than 1MB).';
                    } else {
                        $data['errors'][] = 'Database error: ' . $e->getMessage();
                    }
                    $this->view('groups/update', $data);
                }
            } else {
                // If there are errors, show the form again with error messages
                $this->view('groups/update', $data);
            }
        } else {
            // GET request - show edit form
            $group = $this->groupsModel->getGroupById($id);
            
            if (!$group) {
                redirect('groups/my_groups');
            }
    
            $data = [
                'id' => $id,
                'title' => $group['group_name'],
                'category' => $group['group_category'],
                'description' => $group['group_description'],
                'errors' => []
            ];
            
            $this->view('groups/update', $data);
        }
    }
    
    public function chat($groupId) {
        $group = $this->groupsModel->getGroupById($groupId);
        $messages = $this->groupsModel->getGroupMessages($groupId);
        $memberCount = $this->groupsModel->getMemberCount($groupId);
        
        $data = [
            'group' => $group,
            'messages' => $messages,
            'member_count' => $memberCount
        ];
        
        $this->view('groups/chat', $data);
    }
    
    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $groupId = $_POST['group_id'];
            $message = trim($_POST['message']);
            
            if (!empty($message)) {
                if ($this->groupsModel->saveMessage($groupId, $_SESSION['user_id'], $message)) {
                    $user = $this->userModel->getUserById($_SESSION['user_id']);
                    $response = [
                        'success' => true,
                        'message' => $message,
                        'sender' => $_SESSION['name'],
                        'timestamp' => date('Y-m-d H:i:s'),
                        'profile_image' => $user->profile_picture ? base64_encode($user->profile_picture) : null
                    ];
                } else {
                    $response = ['success' => false];
                }
                echo json_encode($response);
                //redirect("groups/chat/{$groupId}");
                exit;
            }
        }
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
    public function report($groupId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reason = trim($_POST['reason']);
            
            if (empty($reason)) {
                flash('report_message', 'Please provide a reason for the report', 'alert alert-danger');
                redirect('groups/report/' . $groupId);
            }
            
            if ($this->groupsModel->reportGroup($groupId, $_SESSION['user_id'], $reason)) {
                flash('group_message', 'Group reported successfully');
                redirect('groups/viewgroup/' . $groupId);
            } else {
                flash('report_message', 'Something went wrong', 'alert alert-danger');
                redirect('groups/report/' . $groupId);
            }
        } else {
            $data = [
                'group_id' => $groupId
            ];
            
            $this->view('groups/report', $data);
        }
    }
    public function reported() {
        $reported_groups = $this->groupsModel->getReportedGroups();
        $data = [
            'reported_groups' => $reported_groups
        ];
        $this->view('groups/reported', $data);
    }
    
    public function ignore_report($reportId) {
        if ($this->groupsModel->ignoreReport($reportId)) {
            flash('group_message', 'Report Ignored');
            redirect('groups/reported');
        }
    }

    public function report_message() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $groupId = $_POST['group_id'];
            $messageId = $_POST['message_id'];
            $reason = trim($_POST['reason']);
            
            if (empty($reason)) {
                flash('report_message', 'Please provide a reason for the report', 'alert alert-danger');
                redirect('groups/chat/' . $groupId);
            }
            
            if ($this->groupsModel->reportMessage($groupId, $messageId, $_SESSION['user_id'], $reason)) {
                flash('group_message', 'Message reported successfully');
                redirect('groups/chat/' . $groupId);
            } else {
                flash('report_message', 'Something went wrong', 'alert alert-danger');
                redirect('groups/chat/' . $groupId);
            }
        }
    }
    
    public function reported_messages() {
        $reported_messages = $this->groupsModel->getReportedMessages();
        $data = [
            'reported_messages' => $reported_messages
        ];
        $this->view('groups/reported_messages', $data);
    }
    
    public function ignore_message_report($reportId) {
        if ($this->groupsModel->ignoreMessageReport($reportId)) {
            flash('group_message', 'Report Ignored');
            redirect('groups/reported_messages');
        }
    }
    
    public function delete_message($messageId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->groupsModel->deleteMessage($messageId)) {
                flash('group_message', 'Message Deleted');
                redirect('groups/reported_messages');
            }
        }
    }
    
    public function deleteOwnMessage($messageId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = $this->groupsModel->getMessageById($messageId);

            if ($message && $message->user_id == $_SESSION['user_id']) {
                if ($this->groupsModel->deleteOwnMessage($messageId)) {
                    echo json_encode(['success' => true, 'messageId' => $messageId]);  // Add messageId to response
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete message']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            }
            exit;
        }
    }
    
}
