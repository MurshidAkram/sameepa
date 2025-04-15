<?php
class Chat extends Controller
{
    private $chatModel;
    private $userModel;

    public function __construct()
    {
        // Ensure user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->chatModel = $this->model('M_Chat');
        $this->userModel = $this->model('M_Users');
    }

    public function index()
    {
        // Fetch user's active chats
        $user_id = $_SESSION['user_id'];
        $chats = $this->chatModel->getUserChats($user_id);

        $this->view('chat/index', ['chats' => $chats]);
    }

    public function search()
    {
        $user_id = $_SESSION['user_id'];

        // Handle search functionality
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
            $searchTerm = trim($_GET['search']);
            $users = $this->chatModel->searchUsers($user_id, $searchTerm);
        } else {
            // If no search, get recommended users
            $users = $this->chatModel->getRecommendedUsers($user_id);
        }

        $this->view('chat/search', ['users' => $users]);
    }
    public function image($id) {
        $user = $this->chatModel->getProfileById($id); // ✅ use correct method
    
        if ($user && !empty($user->profile_picture)) {
            header("Content-Type: image/jpeg"); // or image/png depending on your data
            echo $user->profile_picture;
        } else {
            header("Location: " . URLROOT . "/img/default-user.png");
            exit;
        }
    }
    

    public function requests()
    {
        $user_id = $_SESSION['user_id'];

        // Fetch pending chat requests
        $requests = $this->chatModel->getPendingChatRequests($user_id);

        $this->view('chat/requests', ['requests' => $requests]);
    }

    public function viewChat($otherUserId)
    {
        $current_user_id = $_SESSION['user_id'];

        // Ensure otherUserId is a valid integer
        $otherUserId = intval($otherUserId);

        // Check if the other user exists
        $otherUser = $this->userModel->getUserById($otherUserId);

        if (!$otherUser) {
            flash('chat_error', 'Invalid user', 'error');
            redirect('chat/search');
            return;
        }

        // Check if chat exists, if not create a new chat
        $chat = $this->chatModel->getChatBetweenUsers($current_user_id, $otherUserId);
        if (!$chat) {
            $chat = $this->chatModel->createChat($current_user_id, $otherUserId);
        }

        // Fetch messages for this chat
        $messages = $this->chatModel->getChatMessages($chat->id);

        $this->view('chat/viewchat', [
            'chat' => $chat,
            'messages' => $messages,
            'otherUser' => $otherUser
        ]);
    }

    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize and validate input
            $message = trim($_POST['message']);
            $chat_id = $_POST['chat_id'];
            $sender_id = $_SESSION['user_id'];

            if (!empty($message)) {
                $result = $this->chatModel->addMessage($chat_id, $sender_id, $message);

                if ($result) {
                    redirect('chat/viewChat/' . $this->chatModel->getOtherUserId($chat_id, $sender_id));
                } else {
                    flash('chat_message', 'Failed to send message', 'error');
                    redirect('chat/index');
                }
            }
        }
    }

    public function acceptRequest($requestId)
    {
        // Debugging step to check if the request reaches here
        error_log("Received request ID: $requestId");

        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        // Check if request exists
        $request = $this->chatModel->getRequestById($requestId);

        if (!$request) {
            echo json_encode(['success' => false, 'message' => 'Request not found']);
            return;
        }

        // Log request status
        error_log("Request status: " . $request->status);

        // Ensure the logged-in user is the recipient
        if ($request->recipient_id != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'You cannot accept this request']);
            return;
        }

        // Proceed to accept the request
        $isUpdated = $this->chatModel->acceptChatRequest($requestId);

        if ($isUpdated) {
            echo json_encode(['success' => true, 'message' => 'Request accepted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update request status']);
        }
    }


    public function declineRequest($requestId)
    {
        if (!$this->checkOwnership($requestId)) {
            echo json_encode(['success' => false]);
            return;
        }

        $result = $this->chatModel->updateRequestStatus($requestId, 'declined');
        echo json_encode(['success' => $result]);
    }

    private function checkOwnership($requestId)
    {
        $request = $this->chatModel->getChatRequestById($requestId);
        return $request && $request->recipient_id == $_SESSION['user_id'];
    }

    public function report()
    {
        // View for reporting inappropriate chat behavior
        $this->view('chat/report');
    }


    public function sendRequest($recipient_id)
    {
        $sender_id = $_SESSION['user_id'];

        // Check if request already exists
        if ($this->chatModel->checkExistingRequest($sender_id, $recipient_id)) {
            flash('chat_request', 'Request already sent or exists', 'warning');
            redirect('chat/search');
            return;
        }

        // Send new request
        $result = $this->chatModel->sendChatRequest($sender_id, $recipient_id);

        if ($result) {
            flash('chat_request', 'Chat request sent successfully');
        } else {
            flash('chat_request', 'Failed to send chat request', 'error');
        }

        redirect('chat/search');
    }

    public function viewreport()
    {
        // View for reporting inappropriate chat behavior
        $this->view('chat/viewreport');
    }
}
