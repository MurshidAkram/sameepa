<?php
class Announcements extends Controller
{
    protected $announcementModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
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
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('announcements/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'created_by' => $_SESSION['user_id'],
                'title_err' => '',
                'content_err' => ''
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter content';
            }

            if (empty($data['title_err']) && empty($data['content_err'])) {
                if ($this->announcementModel->createAnnouncement($data)) {
                    redirect('announcements/index');
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
        if (!in_array($_SESSION['user_role_id'], [2, 3])) {
            redirect('announcements/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'title_err' => '',
                'content_err' => ''
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter content';
            }

            if (empty($data['title_err']) && empty($data['content_err'])) {
                if ($this->announcementModel->updateAnnouncement($data)) {
                    redirect('announcements/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('announcements/edit', $data);
            }
        } else {
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
            redirect('announcements/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->announcementModel->deleteAnnouncement($id)) {
                redirect('announcements/index');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('announcements/index');
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

        if (!$announcement) {
            redirect('announcements/index');
        } else {
            $this->view('announcements/viewannouncement', $data);
        }
    }
}
