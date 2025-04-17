<?php
class Chat extends Controller {
    private $chatModel;
    private $userModel;
    
    public function __construct() {
        // Ensure user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        
        $this->chatModel = $this->model('M_Chat');
        $this->userModel = $this->model('M_Users');
    }
    
    // Display all active chats for the logged-in user
    public function index() {
        // Get all chats for the current user
        $chats = $this->chatModel->getChatsByUserId($_SESSION['user_id']);
        
        // Format data for the view
        $chatData = [];
        
        if ($chats) {
            foreach ($chats as $chat) {
                // Get the ID of the other user in the chat
                $otherUserId = ($chat->user1_id == $_SESSION['user_id']) ? $chat->user2_id : $chat->user1_id;
                
                // Get the other user's details
                $otherUser = $this->userModel->getUserById($otherUserId);
                
                // Get the last message in this chat
                $lastMessage = $this->chatModel->getLastMessageByChatId($chat->id);
                
                // Get unread message count
                $unreadCount = $this->chatModel->getUnreadMessageCount($chat->id, $_SESSION['user_id']);
                
                // Add to chat data array
                $chatData[] = [
                    'chat' => $chat,
                    'otherUser' => $otherUser,
                    'lastMessage' => $lastMessage,
                    'unreadCount' => $unreadCount
                ];
            }
        }
        
        $data = [
            'title' => 'My Chats',
            'chats' => $chatData
        ];
        
        $this->view('chat/index', $data);
    }
    
    // Search users to chat with
public function search() {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    if ($search !== '') {
        $users = $this->userModel->searchUsers($search, $_SESSION['user_id']);
    } else {
        // Use the method from chatModel instead of userModel
        $users = $this->chatModel->getAllUsersExcept($_SESSION['user_id']);
    }
    
    // Rest of your code...
    $existingRequests = [];
    if ($users) {
        foreach ($users as $user) {
            $userId = is_object($user) ? $user->id : $user['id'];
            
            // Check for pending request
            $request = $this->chatModel->getRequestByUsers($_SESSION['user_id'], $userId);
            if ($request) {
                $existingRequests[$userId] = 'pending';
                continue;
            }
            
            // Check for existing chat
            $chat = $this->chatModel->getChatByUsers($_SESSION['user_id'], $userId);
            if ($chat) {
                $existingRequests[$userId] = 'exists';
            }
        }
    }
    
    $data = [
        'title' => 'Search Users',
        'users' => $users,
        'existingRequests' => $existingRequests
    ];
    
    $this->view('chat/search', $data);
}
    // Send a chat request to another user
    // Send a chat request to another user
public function sendRequest() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        redirect('chat/search');
        return;
    }
    
    $userId = isset($_POST['recipient_id']) ? $_POST['recipient_id'] : null;
    
    if (!$userId) {
        flash('chat_message', 'Invalid user', 'alert alert-danger');
        redirect('chat/search');
        return;
    }
    
    // Check if request already exists
    $existingRequest = $this->chatModel->getRequestByUsers($_SESSION['user_id'], $userId);
    
    if ($existingRequest) {
        flash('chat_message', 'You have already sent a request to this user', 'alert alert-warning');
        redirect('chat/search');
        return;
    }
    
    // Check if chat already exists
    $existingChat = $this->chatModel->getChatByUsers($_SESSION['user_id'], $userId);
    
    if ($existingChat) {
        // Redirect to existing chat
        redirect('chat/viewChat/' . $userId);
        return;
    }
    
    // Create new request
    if ($this->chatModel->createChatRequest($_SESSION['user_id'], $userId)) {
        flash('chat_message', 'Chat request sent successfully', 'alert alert-success');
    } else {
        flash('chat_message', 'Failed to send chat request', 'alert alert-danger');
    }
    
    redirect('chat/search');
}
    // Display chat requests
    public function requests() {
        $requests = $this->chatModel->getChatRequests($_SESSION['user_id']);
        
        $data = [
            'title' => 'Chat Requests',
            'requests' => $requests
        ];
        
        $this->view('chat/requests', $data);
    }
    
    // Accept a chat request
    public function acceptRequest($id) {
        $request = $this->chatModel->getRequestById($id);
        if (!$request) {
            $this->jsonResponse(['success' => false, 'message' => 'Request not found']);
            return;
        }
        if ($request->recipient_id != $_SESSION['user_id']) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        $chatId = $this->chatModel->createChat($request->sender_id, $_SESSION['user_id']);
        if ($chatId) {
            $this->chatModel->updateRequestStatus($id, 'accepted');
            $this->jsonResponse(['success' => true, 'chat_id' => $chatId, 'user_id' => $request->sender_id]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Could not create chat']);
        }
    }
    
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    // Decline a chat request
    public function declineRequest($id) {
        // Get the request details
        $request = $this->chatModel->getRequestById($id);
        
        if (!$request) {
            $response = [
                'success' => false,
                'message' => 'Request not found'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
        
        // Check if request is object or array
        $recipient_id = is_object($request) ? $request->recipient_id : $request['recipient_id'];
        
        if ($recipient_id != $_SESSION['user_id']) {
            $response = [
                'success' => false,
                'message' => 'Unauthorized'
            ];
        } else {
            // Mark the request as declined
            if ($this->chatModel->updateRequestStatus($id, 'declined')) {
                $response = [
                    'success' => true
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Could not decline request'
                ];
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    // View chat with a specific user
    public function viewChat($userId) {
        // Check if a chat already exists between these users
        $chat = $this->chatModel->getChatByUsers($_SESSION['user_id'], $userId);
        
        if (!$chat) {
            // If no chat exists, create one
            $chatId = $this->chatModel->createChat($_SESSION['user_id'], $userId);
            $chat = $this->chatModel->getChatById($chatId);
        }
        
        // Get the other user's details
        $otherUser = $this->userModel->getUserById($userId);
        
        // Check if $chat is object or array and get chat ID
        $chat_id = is_object($chat) ? $chat->id : $chat['id'];
        
        // Get messages for this chat
        $messages = $this->chatModel->getMessagesByChatId($chat_id);
        
        // Mark all messages from the other user as read
        $this->chatModel->markMessagesAsRead($chat_id, $_SESSION['user_id']);
        
        $data = [
            'title' => 'Chat with ' . $otherUser['name'],
            'chat' => $chat,
            'otherUser' => $otherUser,
            'messages' => $messages
        ];
        
        $this->view('chat/viewChat', $data);
    }
    
    // Send a message
    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'chat_id' => trim($_POST['chat_id']),
                'recipient_id' => trim($_POST['recipient_id']),
                'message' => trim($_POST['message']),
                'sender_id' => $_SESSION['user_id']
            ];
    
            if (empty($data['message'])) {
                flash('message_error', 'Message cannot be empty');
                redirect('chat/viewChat/' . $data['recipient_id']);
                return;
            }
    
            if ($this->chatModel->sendMessage($data)) {
                redirect('chat/viewChat/' . $data['recipient_id']);
            } else {
                flash('message_error', 'Something went wrong');
                redirect('chat/viewChat/' . $data['recipient_id']);
            }
        } else {
            redirect('chat/index');
        }
    }
    
    // Display image for a user
    public function image($userId) {
        $user = $this->userModel->getUserById($userId);
        
        if ($user && !empty($user->profile_picture)) {
            // Output the image
            header('Content-Type: image/jpeg'); // Adjust based on your image type
            echo $user->profile_picture;
        } else {
            // Redirect to default image
            redirect('img/default.png');
        }
    }
    
    // Report page/functionality
    public function report() {
        $data = [
            'title' => 'Report a Chat'
            // Add more data as needed
        ];
        
        $this->view('chat/report', $data);
    }
}