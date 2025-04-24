<?php
class Posts extends Controller
{
    private $postModel;

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

        $this->postModel = $this->model('M_Posts');
    }

    public function index()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $posts = $this->postModel->getAllPosts($search);

        // If logged-in user exists, get their reactions to posts
        foreach ($posts as &$post) {
            $userReaction = $this->postModel->getUserReaction($post->id, $_SESSION['user_id']);
            $post->user_reaction = $userReaction ? $userReaction['reaction_type'] : null;
        }

        $data = [
            'posts' => $posts,
            'search' => $search,
            'is_admin' => in_array($_SESSION['user_role_id'], [2, 3])
        ];

        $this->view('posts/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'description' => trim($_POST['description']),
                'date' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'image_data' => null,
                'image_type' => null,
                'created_by' => $_SESSION['user_id'],
                'errors' => []
            ];

            // Handle image upload if present
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];

                if (in_array($_FILES['image']['type'], $allowed)) {
                    // Read image data
                    $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                    $data['image_type'] = $_FILES['image']['type'];
                } else {
                    $data['errors'][] = 'Invalid file type. Only JPG, PNG and GIF are allowed.';
                }
            }

            // Validate data
            $this->validatePostData($data);

            // If no errors, create post
            if (empty($data['errors'])) {
                if ($this->postModel->createPost($data)) {
                    //flash('post_message', 'Post Created Successfully');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('posts/create', $data);
            }
        } else {
            // Init data
            $data = [
                'description' => '',
                'errors' => []
            ];

            $this->view('posts/create', $data);
        }
    }

    private function validatePostData(&$data)
    {
        // Validate Description
        if (empty($data['description'])) {
            $data['errors'][] = 'Please enter post description';
        }
    }

    public function myposts()
    {
        $posts = $this->postModel->getPostsByUserId($_SESSION['user_id']);
        $data = [
            'posts' => $posts,
            'is_admin' => in_array($_SESSION['user_role_id'], [2, 3])
        ];
        $this->view('posts/myposts', $data);
    }

    public function update($id)
    {
        // Check if user is the post creator 
        // OR if an admin/super admin is trying to update a resident's post
        $post = $this->postModel->getPostById($id);

        if (!$post) {
            redirect('posts');
        }

        // Condition for update:
        // 1. User is the post creator 
        if (
            $post['created_by'] == $_SESSION['user_id']
        ) {
            // Existing update logic remains the same
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'id' => $id,
                    'description' => trim($_POST['description']),
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'image_data' => null,
                    'image_type' => null,
                    'errors' => []
                ];

                // Handle image upload if present
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $allowed = ['image/jpeg', 'image/png', 'image/gif'];

                    if (in_array($_FILES['image']['type'], $allowed)) {
                        $data['image_data'] = file_get_contents($_FILES['image']['tmp_name']);
                        $data['image_type'] = $_FILES['image']['type'];
                    } else {
                        $data['errors'][] = 'Invalid file type. Only JPG, PNG and GIF are allowed.';
                    }
                }

                $this->validatePostData($data);

                if (empty($data['errors'])) {
                    if ($this->postModel->updatePost($data)) {
                        redirect('posts/myposts');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    $this->view('posts/update', $data);
                }
            } else {
                $post = $this->postModel->getPostById($id);

                $data = [
                    'id' => $id,
                    'description' => $post['description'],
                    'errors' => []
                ];

                $this->view('posts/update', $data);
            }
        } else {
            // Unauthorized access
            redirect('posts/index');
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->postModel->getPostById($id);

            if (!$post) {
                echo json_encode(['success' => false, 'message' => 'Post not found']);
                exit;
            }


            if ($post['created_by'] == $_SESSION['user_id'] || in_array($_SESSION['user_role_id'], [2, 3])) {
                if ($this->postModel->deletePost($id)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete post']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            }
            exit;
        }
        redirect('posts');
    }

    public function image($id)
    {
        $image = $this->postModel->getPostImage($id);

        if ($image && $image['image_data']) {
            header("Content-Type: " . $image['image_type']);
            echo $image['image_data'];
            exit;
        }

        // Return default image if no image found
        header("Content-Type: image/png");
        readfile(APPROOT . '/public/img/default-post.png');
    }

    public function react($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'post_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'reaction_type' => $_POST['reaction_type']
            ];

            if ($this->postModel->addReaction($data)) {
                // Return JSON response for AJAX
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            exit;
        }
    }

    public function comment($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'post_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'comment' => trim($_POST['comment'])
            ];

            if ($this->postModel->addComment($data)) {
                $comments = $this->postModel->getCommentsByPostId($id);
                echo json_encode(['success' => true, 'comments' => $comments]);
            } else {
                echo json_encode(['success' => false]);
            }
            exit;
        }
    }

    public function viewpost($id)
    {
        $post = $this->postModel->getPostById($id);
        $comments = $this->postModel->getCommentsByPostId($id);
        $userReaction = $this->postModel->getUserReaction($id, $_SESSION['user_id']);

        if (!$post) {
            redirect('posts');
        }

        $data = [
            'post' => $post,
            'comments' => $comments,
            'user_reaction' => $userReaction ? $userReaction['reaction_type'] : null,
            'is_creator' => $this->postModel->isPostCreator($id, $_SESSION['user_id']),
            'is_admin' => in_array($_SESSION['user_role_id'], [2, 3])
        ];

        $this->view('posts/viewpost', $data);
    }

    public function deleteComment($id)
    {
        $comment = $this->postModel->getCommentById($id);

        if (!$comment) {
            echo json_encode(['success' => false, 'message' => 'Comment not found']);
            exit;
        }

        $isCommentOwner = $comment['user_id'] == $_SESSION['user_id'];
        $isAdminOrSuperAdmin = in_array($_SESSION['user_role_id'], [2, 3]);

        if ($comment['user_id'] == $_SESSION['user_id'] || in_array($_SESSION['user_role_id'], [2, 3])) {
            if ($this->postModel->deleteComment($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete comment']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        }
        exit;
    }
}
