<?php

class Forums extends Controller
{
    protected $forumsModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            exit();
        }

        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            redirect('users/login');
        }

        $this->forumsModel = $this->model('M_Forums');
    }

    public function index()
    {
        $forums = $this->forumsModel->getAllForums();
        $data = ['forums' => $forums];
        $this->view('forums/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'created_by' => $_SESSION['user_id'],
                'errors' => []
            ];

            // Validate input
            if (empty($data['title'])) {
                $data['errors'][] = 'Please enter a forum title.';
            }
            if (empty($data['description'])) {
                $data['errors'][] = 'Please enter a forum description.';
            }

            if (empty($data['errors'])) {
                if ($this->forumsModel->createForum($data)) {
                    if ($_SESSION['user_role_id'] == 2) {
                        redirect('forums/index');
                    } else {
                        redirect('forums/index');
                    }
                } else {
                    die('Something went wrong.');
                }
            } else {
                $this->view('forums/create', $data);
            }
        } else {
            $this->view('forums/create');
        }
    }

    public function getUserNameById($userId)
    {
        return $this->forumsModel->getUserNameById($userId);
    }

    public function getCommentCountByForumId($forumId)
    {
        return $this->forumsModel->getCommentCountByForumId($forumId);
    }

    public function delete($id)
    {
        if ($_SESSION['user_role_id'] >= 2) {
            if ($this->forumsModel->deleteForum($id)) {
                redirect('forums/index');
            } else {
                die('Something went wrong.');
            }
        } else {
            redirect('forums/index');
        }
    }

    public function view_forum($id)
    {
        $forum = $this->forumsModel->getForumById($id);
        $comments = $this->forumsModel->getCommentsByForumId($id);
        $data = [
            'forum' => $forum,
            'comments' => $comments
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            $commentData = [
                'forum_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'comment' => trim($_POST['comment'])
            ];
            if ($this->forumsModel->createComment($commentData)) {
                $comments = $this->forumsModel->getCommentsByForumId($id);
                $data['comments'] = $comments;
            } else {
                error_log("Error creating comment: " . print_r($commentData, true));
                die('Something went wrong.');
            }
        }

        $this->view('forums/view_forum', $data);
    }

    public function reported_comments($forum_id)
    {
        if ($_SESSION['user_role_id'] >= 2) {
            $reported_comments = $this->forumsModel->getReportedCommentsByForumId($forum_id);
            $data = [
                'h' => $forum_id,
                'reported_comments' => $reported_comments
            ];
            $this->view('forums/reported_comments', $data);
        } else {
            redirect('forums/index');
        }
    }

    public function report_comment($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'forum_comment_id' => $id,
                'reported_by' => $_SESSION['user_id'],
                'reason' => trim($_POST['reason'])
            ];

            if ($this->forumsModel->reportComment($data)) {
                $comment = $this->forumsModel->getCommentById($id);
                redirect("forums/view_forum/{$comment['forum_id']}");
            } else {
                die('Something went wrong.');
            }
        } else {
            $data = [
                'comment_id' => $id
            ];
            $this->view('forums/report_comment', $data);
        }
    }

    public function delete_reported_comment($id)
    {
        if ($_SESSION['user_role_id'] >= 2) {
            // Get the forum_id before deleting the comment
            $comment = $this->forumsModel->getCommentById($id);
            if ($comment && $this->forumsModel->deleteReportedComment($id)) {
                redirect('forums/reported_comments/' . $comment['forum_id']);
            } else {
                die('Something went wrong.');
            }
        } else {
            redirect('forums/index');
        }
    }

    public function ignore_report($id)
    {
        // Check if user has admin or super admin role
        if ($_SESSION['user_role_id'] >= 2) {
            if ($this->forumsModel->ignoreReport($id)) {
                if ($_SESSION['user_role_id'] == 2) {
                    redirect('forums/index');
                } else {
                    redirect('forums/index');
                }
            } else {
                die('Something went wrong.');
            }
        } else {
            redirect('forums/index');
        }
    }

    public function delete_comment($id)
    {
        $comment = $this->forumsModel->getCommentById($id);
        $forum_id = $comment['forum_id'];
        if ($comment['user_id'] == $_SESSION['user_id'] || $_SESSION['user_role_id'] >= 2) {
            if ($this->forumsModel->deleteComment($id)) {
                $comments = $this->forumsModel->getCommentsByForumId($forum_id);
                $data = [
                    'forum' => $this->forumsModel->getForumById($forum_id),
                    'comments' => $comments
                ];
                $this->view('forums/view_forum', $data);
            } else {
                die('Something went wrong.');
            }
        } else {
            redirect('forums/index');
        }
    }

    public function myforums()
    {
        $userForums = $this->forumsModel->getForumsByUserId($_SESSION['user_id']);
        $data = ['forums' => $userForums];
        $this->view('forums/myforums', $data);
    }


    public function deletemyForum($id)
    {
        $forum = $this->forumsModel->getForumById($id);

        if ($forum && $forum['created_by'] == $_SESSION['user_id']) {
            try {
                if ($this->forumsModel->deleteForum($id)) {
                    redirect('forums/myforums');
                } else {
                    redirect('forums/myforums');
                }
            } catch (Exception $e) {
                error_log("Error in deletemyForum: " . $e->getMessage());
                redirect('forums/myforums');
            }
        } else {
            redirect('forums/myforums');
        }
    }
}
