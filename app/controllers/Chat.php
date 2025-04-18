<?php
class Chat extends Controller {
    private $chatModel;
    private $userModel;
    
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        
        $this->chatModel = $this->model('M_Chat');
        $this->userModel = $this->model('M_Users');
    }
    
    public function index() {
        $chats = $this->chatModel->getChatsByUserId($_SESSION['user_id']);
        $chatData = [];
        
        if ($chats) {
            foreach ($chats as $chat) {
                $otherUserId = ($chat->user1_id == $_SESSION['user_id']) ? $chat->user2_id : $chat->user1_id;
                $otherUser = $this->userModel->getUserById($otherUserId);
                $lastMessage = $this->chatModel->getLastMessageByChatId($chat->id);
                $unreadCount = $this->chatModel->getUnreadMessageCount($chat->id, $_SESSION['user_id']);
                
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
    
    public function search() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        if ($search !== '') {
            $users = $this->userModel->searchUsers($search, $_SESSION['user_id']);
        } else {
            $users = $this->chatModel->getAllUsersExcept($_SESSION['user_id']);
        }
        
        $existingRequests = [];
        if ($users) {
            foreach ($users as $user) {
                $userId = is_object($user) ? $user->id : $user['id'];
                $request = $this->chatModel->getRequestByUsers($_SESSION['user_id'], $userId);
                if ($request) {
                    $existingRequests[$userId] = 'pending';
                    continue;
                }
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
        
        $existingRequest = $this->chatModel->getRequestByUsers($_SESSION['user_id'], $userId);
        if ($existingRequest) {
            flash('chat_message', 'You have already sent a request to this user', 'alert alert-warning');
            redirect('chat/search');
            return;
        }
        
        $existingChat = $this->chatModel->getChatByUsers($_SESSION['user_id'], $userId);
        if ($existingChat) {
            redirect('chat/viewChat/' . $userId);
            return;
        }
        
        if ($this->chatModel->createChatRequest($_SESSION['user_id'], $userId)) {
            flash('chat_message', 'Chat request sent successfully', 'alert alert-success');
        } else {
            flash('chat_message', 'Failed to send chat request', 'alert alert-danger');
        }
        
        redirect('chat/search');
    }
    
    public function requests() {
        $requests = $this->chatModel->getChatRequests($_SESSION['user_id']);
        
        $data = [
            'title' => 'Chat Requests',
            'requests' => $requests
        ];
        
        $this->view('chat/requests', $data);
    }
    
    public function acceptRequest($id) {
        error_log("Accept request called for ID: $id");
        
        $request = $this->chatModel->getRequestById($id);
        
        if (!$request) {
            error_log("Request not found: $id");
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Request not found']);
            return;
        }
        
        if ($request->recipient_id != $_SESSION['user_id']) {
            error_log("Unauthorized: User {$_SESSION['user_id']} trying to accept request for {$request->recipient_id}");
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        try {
            // Create a new chat
            $chatId = $this->chatModel->createChat($request->sender_id, $_SESSION['user_id']);
            
            if (!$chatId) {
                error_log("Failed to create chat for request $id");
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Could not create chat']);
                return;
            }
            
            // Update the request status to 'accepted'
            $updateSuccess = $this->chatModel->updateRequestStatus($id, 'accepted');
            
            if ($updateSuccess) {
                error_log("Successfully accepted request $id, chat ID: $chatId");
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'chat_id' => $chatId, 'user_id' => $request->sender_id]);
            } else {
                error_log("Failed to update status to 'accepted' for request $id");
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Could not update request status']);
            }
        } catch (Exception $e) {
            error_log("Exception in acceptRequest for request $id: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'An error occurred']);
        }
        exit;
    }
    
    public function declineRequest($id) {
        error_log("Decline request called for ID: $id");
        
        $request = $this->chatModel->getRequestById($id);
        
        if (!$request) {
            error_log("Request not found: $id");
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Request not found']);
            return;
        }
        
        if ($request->recipient_id != $_SESSION['user_id']) {
            error_log("Unauthorized: User {$_SESSION['user_id']} trying to decline request for {$request->recipient_id}");
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        try {
            $updateSuccess = $this->chatModel->updateRequestStatus($id, 'declined');
            
            if ($updateSuccess) {
                error_log("Successfully declined request $id");
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Request declined successfully']);
            } else {
                error_log("Failed to update status to 'declined' for request $id");
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Could not decline request']);
            }
        } catch (Exception $e) {
            error_log("Exception in declineRequest for request $id: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'An error occurred']);
        }
        exit;
    }
    
    public function viewChat($userId) {
        $chat = $this->chatModel->getChatByUsers($_SESSION['user_id'], $userId);
        
        if (!$chat) {
            $chatId = $this->chatModel->createChat($_SESSION['user_id'], $userId);
            $chat = $this->chatModel->getChatById($chatId);
        }
        
        $otherUser = $this->userModel->getUserById($userId);
        $chat_id = is_object($chat) ? $chat->id : $chat['id'];
        $messages = $this->chatModel->getMessagesByChatId($chat_id);
        $this->chatModel->markMessagesAsRead($chat_id, $_SESSION['user_id']);
        
        $data = [
            'title' => 'Chat with ' . $otherUser['name'],
            'chat' => $chat,
            'otherUser' => $otherUser,
            'messages' => $messages
        ];
        
        $this->view('chat/viewChat', $data);
    }
    
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
    
    public function image($userId) {
        $user = $this->userModel->getUserById($userId);
        
        if ($user && !empty($user->profile_picture)) {
            header('Content-Type: image/jpeg');
            echo $user->profile_picture;
        } else {
            redirect('img/default.png');
        }
    }
    

    // Update message
public function updateMessage() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        return;
    }
    
    // Get JSON data from request
    $data = json_decode(file_get_contents('php://input'));
    
    if (!$data || !isset($data->messageId) || !isset($data->newMessage)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        return;
    }
    
    // Sanitize data
    $messageId = filter_var($data->messageId, FILTER_SANITIZE_NUMBER_INT);
    $newMessage = filter_var($data->newMessage, FILTER_SANITIZE_STRING);
    
    if (empty($newMessage)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Message cannot be empty']);
        return;
    }
    
    // Update the message
    if ($this->chatModel->updateMessage($messageId, $newMessage, $_SESSION['user_id'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Message updated successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to update message']);
    }
}
public function deleteMessage() {
    // Ensure JSON response, even if errors occur
    header('Content-Type: application/json');
    
    // Log the raw POST data for debugging
    $rawPostData = file_get_contents('php://input');
    error_log('DeleteMessage: Raw POST data: ' . $rawPostData);
    error_log('DeleteMessage: POST array: ' . print_r($_POST, true));
    
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        return;
    }
    
    try {
        $input = $_POST;
if (empty($input)) {
    parse_str(file_get_contents("php://input"), $input);
}
$messageId = isset($input['message_id']) ? filter_var($input['message_id'], FILTER_SANITIZE_NUMBER_INT) : null;

        
        if (!$messageId) {
            error_log('DeleteMessage: Missing message_id in POST data');
            echo json_encode(['success' => false, 'message' => 'Missing message ID']);
            return;
        }
        
        error_log('DeleteMessage: Attempting to delete message ID: ' . $messageId . ' by user: ' . $_SESSION['user_id']);
        
        // Get message to verify it exists and belongs to the user
        $message = $this->chatModel->getMessageById($messageId);
        
        if (!$message) {
            error_log('DeleteMessage: Message not found for ID: ' . $messageId);
            echo json_encode(['success' => false, 'message' => 'Message not found']);
            return;
        }
        if ($message['sender_id'] != $_SESSION['user_id']) {
            error_log('DeleteMessage: Unauthorized deletion attempt by user ' . $_SESSION['user_id'] . ' for message ' . $messageId);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        // Attempt to delete the message
        if ($this->chatModel->deleteMessage($messageId, $_SESSION['user_id'])) {
            error_log('DeleteMessage: Successfully deleted message ID: ' . $messageId);
            echo json_encode(['success' => true, 'message' => 'Message deleted successfully']);
        } else {
            error_log('DeleteMessage: Failed to delete message ID: ' . $messageId);
            echo json_encode(['success' => false, 'message' => 'Failed to delete message']);
        }
    } catch (Exception $e) {
        error_log('DeleteMessage: Exception occurred: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    }
}
}