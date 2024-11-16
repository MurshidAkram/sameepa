<?php

class Forums extends Controller
{
    protected $forumsModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            exit();
        }

        // Check if user has appropriate role (1: Resident, 2: Admin, 3: SuperAdmin)
        if (!in_array($_SESSION['user_role_id'], [1, 2, 3])) {
            //flash('error', 'Unauthorized access');
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

            // If no errors, create the forum
            if (empty($data['errors'])) {
                if ($this->forumsModel->createForum($data)) {
                    //flash('forum_message', 'Forum created successfully.');
                    redirect('forums/index');
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
        // Check if user has admin or super admin role
        if ($_SESSION['user_role_id'] >= 2) {
            if ($this->forumsModel->deleteForum($id)) {
                //flash('forum_message', 'Forum deleted successfully.');
                redirect('forums/index');
            } else {
                die('Something went wrong.');
            }
        } else {
            //flash('error', 'Unauthorized access');
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
                // flash('comment_message', 'Comment posted successfully.');
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
        // Check if user has admin or super admin role
        if ($_SESSION['user_role_id'] >= 2) {
            $reported_comments = $this->forumsModel->getReportedCommentsByForumId($forum_id);
            $data = [
                'forum_id' => $forum_id,
                'reported_comments' => $reported_comments
            ];
            $this->view('forums/reported_comments', $data);
        } else {
            // flash('error', 'Unauthorized access');
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
                // flash('comment_message', 'Comment reported successfully.');
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

    // In Forums.php controller, update the delete_reported_comment method:
    public function delete_reported_comment($id)
    {
        // Check if user has admin or super admin role
        if ($_SESSION['user_role_id'] >= 2) {
            // Get the forum_id before deleting the comment
            $comment = $this->forumsModel->getCommentById($id);
            if ($comment && $this->forumsModel->deleteReportedComment($id)) {
                //flash('comment_message', 'Reported comment deleted successfully.');
                redirect('forums/reported_comments/' . $comment['forum_id']); // Redirect back to reported comments page
            } else {
                die('Something went wrong.');
            }
        } else {
            //flash('error', 'Unauthorized access');
            redirect('forums/index');
        }
    }

    public function ignore_report($id)
    {
        // Check if user has admin or super admin role
        if ($_SESSION['user_role_id'] >= 2) {
            if ($this->forumsModel->ignoreReport($id)) {
                //flash('comment_message', 'Report ignored successfully.');
                redirect('forums/index');
            } else {
                die('Something went wrong.');
            }
        } else {
            //flash('error', 'Unauthorized access');
            redirect('forums/index');
        }
    }

    public function delete_comment($id)
    {
        $comment = $this->forumsModel->getCommentById($id);
        $forum_id = $comment['forum_id'];
        if ($comment['user_id'] == $_SESSION['user_id'] || $_SESSION['user_role_id'] >= 2) {
            if ($this->forumsModel->deleteComment($id)) {
                // flash('comment_message', 'Comment deleted successfully.');
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
            // flash('error', 'Unauthorized access');
            redirect('forums/index');
        }
    }

    public function myforums()
    {
        $userForums = $this->forumsModel->getForumsByUserId($_SESSION['user_id']);
        $data = ['forums' => $userForums];
        $this->view('forums/myforums', $data);
    }

    // In Forums.php controller, add this method:

    public function deletemyForum($id)
    {
        // First get the forum to check ownership
        $forum = $this->forumsModel->getForumById($id);

        // Check if forum exists and belongs to the current user
        if ($forum && $forum['created_by'] == $_SESSION['user_id']) {
            try {
                if ($this->forumsModel->deleteForum($id)) {
                    //flash('forum_message', 'Forum deleted successfully.');
                    redirect('forums/myforums');
                } else {
                    //flash('error', 'Unable to delete forum. Please try again.');
                    redirect('forums/myforums');
                }
            } catch (Exception $e) {
                error_log("Error in deletemyForum: " . $e->getMessage());
                //flash('error', 'An error occurred while deleting the forum.');
                redirect('forums/myforums');
            }
        } else {
            //flash('error', 'Unauthorized access');
            redirect('forums/myforums');
        }
    }
}
