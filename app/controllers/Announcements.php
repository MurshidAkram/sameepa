<?php
class Announcements extends Controller
{
    protected $announcementModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if user has appropriate role
        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            //flash('error', 'Unauthorized access');
            redirect('users/login');
        }

        $this->announcementModel = $this->model('M_Announcements');
    }

    public function index()
    {
        $announcements = $this->announcementModel->getAllAnnouncements();

        $data = [
            'announcements' => $announcements,
            'is_admin' => in_array($_SESSION['user_role_id'], [2, 3])
        ];

        $this->view('announcements/index', $data);
    }

    public function create()
    {
        // Only admin and superadmin can access this
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('announcements/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'created_by' => $_SESSION['user_id'],
                'title_err' => '',
                'content_err' => ''
            ];

            // Validate title
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            // Validate content
            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter content';
            }

            // Make sure no errors
            if (empty($data['title_err']) && empty($data['content_err'])) {
                // Validated
                if ($this->announcementModel->createAnnouncement($data)) {
                    //flash('announcement_message', 'Announcement Added');
                    redirect('announcements/admin_dashboard');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('announcements/create', $data);
            }
        } else {
            $data = [
                'title' => '',
                'content' => '',
                'title_err' => '',
                'content_err' => ''
            ];

            $this->view('announcements/create', $data);
        }
    }

    public function edit($id)
    {
        // Only admin and superadmin can access this
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('announcements/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'title_err' => '',
                'content_err' => ''
            ];

            // Validate title
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            // Validate content
            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter content';
            }

            // Make sure no errors
            if (empty($data['title_err']) && empty($data['content_err'])) {
                // Validated
                if ($this->announcementModel->updateAnnouncement($data)) {
                    //flash('announcement_message', 'Announcement Updated');
                    redirect('announcements');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('announcements/edit', $data);
            }
        } else {
            // Get announcement from model
            $announcement = $this->announcementModel->getAnnouncementById($id);

            $data = [
                'id' => $id,
                'title' => $announcement['title'],
                'content' => $announcement['content'],
                'title_err' => '',
                'content_err' => ''
            ];

            $this->view('announcements/edit', $data);
        }
    }

    public function delete($id)
    {
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('announcements');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->announcementModel->deleteAnnouncement($id)) {
                //flash('announcement_message', 'Announcement Removed');
                redirect('announcements/admin_dashboard');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('announcements/admin_dashboard');
        }
    }

    public function react($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'announcement_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'reaction_type' => $_POST['reaction_type']
            ];

            if ($this->announcementModel->addReaction($data)) {
                // Return JSON response for AJAX
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function viewannouncement($id)
    {
        $announcement = $this->announcementModel->getAnnouncementById($id);
        $userReaction = $this->announcementModel->getUserReaction($id, $_SESSION['user_id']);

        // Convert the object to array if needed
        $announcementArray = [
            'id' => $announcement['id'],
            'title' => $announcement['title'],
            'content' => $announcement['content'],
            'created_at' => $announcement['created_at'],
            'creator_name' => $announcement['creator_name'],
            'likes' => $announcement['likes'],
            'dislikes' => $announcement['dislikes']
        ];

        $data = [
            'announcement' => $announcementArray,
            'user_reaction' => $userReaction ? (array)$userReaction : []
        ];

        $this->view('announcements/viewannouncement', $data);
    }
    public function admin_dashboard()
    {
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('announcements');
        }
    
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $announcements = $this->announcementModel->getAllAnnouncements2($searchTerm);
        $stats = $this->announcementModel->getAnnouncementStats();
    
        $data = [
            'announcements' => $announcements,
            'stats' => $stats
        ];
    
        $this->view('announcements/admin_dashboard', $data);
    }
    
}
