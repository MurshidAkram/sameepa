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
        $userId = $_SESSION['user_id'];
        $search = '';
    
        // Handle POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $search = isset($_POST['search']) ? trim($_POST['search']) : '';
            $_SESSION['search_term'] = $search;
    
            // Redirect to clear POST and URL
            header('Location: ' . URLROOT . '/chat/index');
            exit;
        }
    
        // If redirected, use session value
        if (isset($_SESSION['search_term'])) {
            $search = $_SESSION['search_term'];
            unset($_SESSION['search_term']); // clear after using
        }
    
        $chats = $this->chatModel->getChatsByUserId($userId);
        $chatData = [];
    
        if ($chats) {
            foreach ($chats as $chat) {
                $otherUserId = ($chat->user1_id == $userId) ? $chat->user2_id : $chat->user1_id;
                $otherUser = $this->userModel->getUserById($otherUserId);
    
                if (!$otherUser) {
                    continue;
                }
    
                // Filter if search term exists
                if ($search !== '' && stripos($otherUser['name'], $search) === false) {
                    continue;
                }
    
                $lastMessage = $this->chatModel->getLastMessageByChatId($chat->id);
                $unreadCount = $this->chatModel->getUnreadMessageCount($chat->id, $userId);
    
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Store search in session and redirect
            $_SESSION['search_term'] = trim($_POST['search']);
            header('Location: ' . URLROOT . '/chat/search');
            exit;
        }
    
        // GET request — Check if search_term is in session
        if (isset($_SESSION['search_term']) && $_SESSION['search_term'] !== '') {
            $search = $_SESSION['search_term'];
    
            // Get filtered users
            $users = $this->chatModel->searchUsers($search, $_SESSION['user_id']);
    
            // Clear search term after showing results once
            unset($_SESSION['search_term']);
        } else {
            // No search, show all users
            $users = $this->chatModel->getAllUsersExcept($_SESSION['user_id']);
        }
    
        // Build request/chat status
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
    
    // controllers/Chat.php
public function acceptRequest()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $requestId = $_POST['request_id'];
        $senderId = $_POST['sender_id'];

        if ($this->chatModel->acceptChatRequest($requestId)) {
            echo json_encode([
                'success' => true,
                'start_chat_url' => URLROOT . "/chat/viewchat/$senderId"
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}

    
   // controllers/Chat.php
public function declineRequest()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $requestId = $_POST['request_id'];

        if ($this->chatModel->declineChatRequest($requestId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
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
            $filePath = APPROOT . '/public/' . $user->profile_picture;

            if (file_exists($filePath)) {
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                $contentType = 'image/jpeg'; // Default
                switch (strtolower($fileExtension)) {
                    case 'png':
                        $contentType = 'image/png';
                        break;
                    case 'gif':
                        $contentType = 'image/gif';
                        break;
                    // Add other image types if needed
                }
                header('Content-Type: ' . $contentType);
                readfile($filePath);
                exit(); // Stop further execution
            } else {
                // Log the missing file path for debugging
                error_log("Profile picture file not found at path: " . $filePath);
            }
        }
        // If user or profile picture is empty, or file doesn't exist, redirect to default
        redirect('img/default.png');
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
public function viewreport($reportId = null)
{
    if ($reportId === null) {
        redirect('chat/report'); // Redirect if no report ID is provided
        return;
    }

    // Fetch the specific report
    $report = $this->chatModel->getReportById($reportId);

    // Explicitly cast to object if it's an array
    if (is_array($report)) {
        $report = (object) $report;
    }

    if (!$report) {
        flash('report_message', 'Report not found', 'alert alert-danger');
        redirect('chat/report'); // Redirect if report not found
        return;
    }

    // Check if the user is authorized to view this report (superadmin or the reporter)
    if ($_SESSION['user_role_id'] != 3 && $report->reporter_id != $_SESSION['user_id']) {
        flash('report_message', 'You are not authorized to view this report', 'alert alert-danger');
        redirect('chat/myreports'); // Redirect if not authorized
        return;
    }


    $data = [
        'title' => 'Report Details',
        'report' => $report
    ];

    $this->view('chat/viewreport', $data);
}

public function report()
{
    // Check if the user is a superadmin (user_role_id == 3)
    if ($_SESSION['user_role_id'] != 3) {
        redirect('chat/myreports'); // Redirect non-superadmins to their reports
        return;
    }

    // Fetch all reports for superadmin
    $reports = $this->chatModel->getAllReports();
    
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    // Log reports data for debugging
    error_log('Fetched reports for superadmin: ' . print_r($reports, true));

    if ($reports === false) {
        // Handle potential database error
        flash('report_message', 'Error fetching reports', 'alert alert-danger');
        $reports = []; // Ensure $reports is an empty array to prevent view errors
    }

    if (!empty($search)) {
        // Assuming you have a method in your Chat model to search reports
        $reports = $this->chatModel->searchReports($search);
    } else {
        // Fetch all reports if no search term
        $reports = $this->chatModel->getAllReports();
    }

    $data = [
        'title' => 'Chat Reports',
        'reports' => $reports
    ];

    $this->view('chat/report', $data);
}
public function createreport()
{
    // Load the create report view
    $data = [
        'title' => 'Create Chat Report'
    ];
    $this->view('chat/createreport', $data);
}
public function myreports()
{
    // Fetch reports for the current user
    $reports = $this->chatModel->getReportsByUserId($_SESSION['user_id']);

    $data = [
        'title' => 'My Chat Reports',
        'reports' => $reports
    ];
    $this->view('chat/myreports', $data);
}

public function submitreport()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        redirect('chat/createreport');
        return;
    }

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
        'reporter_id' => $_SESSION['user_id'],
        'reported_user_message' => trim($_POST['reported_user_message']),
        'category' => trim($_POST['report_category']),
        'description' => trim($_POST['report_description']),
        'reported_user_message_err' => '',
        'category_err' => '',
        'description_err' => ''
    ];

    // Validate input
    if (empty($data['reported_user_message'])) {
        $data['reported_user_message_err'] = 'Please enter the reported user or message identifier';
    }
    if (empty($data['category'])) {
        $data['category_err'] = 'Please select a report category';
    }
    if (empty($data['description'])) {
        $data['description_err'] = 'Please provide a description';
    }

    // Check for errors
    if (empty($data['reported_user_message_err']) && empty($data['category_err']) && empty($data['description_err'])) {
        // No errors, attempt to create report
        if ($this->chatModel->createReport($data)) {
            flash('report_message', 'Chat report submitted successfully', 'alert alert-success');
            redirect('chat/myreports'); // Redirect to user's reports after submission
        } else {
            flash('report_message', 'Something went wrong, please try again', 'alert alert-danger');
            $this->view('chat/createreport', $data); // Load view with data if creation fails
        }
    } else {
        // Load view with errors
        $this->view('chat/createreport', $data);
    }
}

public function validatereport($reportId = null)
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || $reportId === null) {
        redirect('chat/report');
        return;
    }

    // Check if the user is a superadmin
    if ($_SESSION['user_role_id'] != 3) {
        flash('report_message', 'You are not authorized to perform this action', 'alert alert-danger');
        redirect('chat/report');
        return;
    }

    if ($this->chatModel->updateReportStatus($reportId, 'validated')) {
        flash('report_message', 'Report validated successfully', 'alert alert-success');
    } else {
        flash('report_message', 'Failed to validate report', 'alert alert-danger');
    }

    redirect('chat/viewreport/' . $reportId); // Redirect back to the report details page
}

public function dismissreport($reportId = null)
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || $reportId === null) {
        redirect('chat/report');
        return;
    }

    // Check if the user is a superadmin
    if ($_SESSION['user_role_id'] != 3) {
        flash('report_message', 'You are not authorized to perform this action', 'alert alert-danger');
        redirect('chat/report');
        return;
    }

    if ($this->chatModel->updateReportStatus($reportId, 'dismissed')) {
        flash('report_message', 'Report dismissed successfully', 'alert alert-success');
    } else {
        flash('report_message', 'Failed to dismiss report', 'alert alert-danger');
    }

    redirect('chat/viewreport/' . $reportId); // Redirect back to the report details page
}

public function editreport($reportId = null)
{
    if ($reportId === null) {
        redirect('chat/myreports');
        return;
    }

    // Fetch the report
    $report = $this->chatModel->getReportById($reportId);

    // Explicitly cast to object if it's an array (since Database::single() might return array)
    if (is_array($report)) {
        $report = (object) $report;
    }

    // Check if report exists and the current user is the reporter and not a superadmin
    if (!$report || $report->reporter_id != $_SESSION['user_id'] || $_SESSION['user_role_id'] == 3) {
        flash('report_message', 'You are not authorized to edit this report', 'alert alert-danger');
        redirect('chat/myreports');
        return;
    }

    $data = [
        'title' => 'Edit Chat Report',
        'report' => $report,
        'reported_user_message' => $report->reported_user_message,
        'category' => $report->category,
        'description' => $report->description,
        'reported_user_message_err' => '',
        'category_err' => '',
        'description_err' => ''
    ];

    $this->view('chat/editreport', $data);
}

public function updatereport($reportId = null)
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || $reportId === null) {
        redirect('chat/myreports');
        return;
    }

    // Fetch the report to verify ownership
    $report = $this->chatModel->getReportById($reportId);

    // Explicitly cast to object if it's an array
    if (is_array($report)) {
        $report = (object) $report;
    }

    // Check if report exists and the current user is the reporter and not a superadmin
    if (!$report || $report->reporter_id != $_SESSION['user_id'] || $_SESSION['user_role_id'] == 3) {
        flash('report_message', 'You are not authorized to update this report', 'alert alert-danger');
        redirect('chat/myreports');
        return;
    }

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
        'id' => $reportId,
        'reporter_id' => $_SESSION['user_id'],
        'reported_user_message' => trim($_POST['reported_user_message']),
        'category' => trim($_POST['report_category']),
        'description' => trim($_POST['report_description']),
        'reported_user_message_err' => '',
        'category_err' => '',
        'description_err' => ''
    ];

    // Validate input
    if (empty($data['reported_user_message'])) {
        $data['reported_user_message_err'] = 'Please enter the reported user or message identifier';
    }
    if (empty($data['category'])) {
        $data['category_err'] = 'Please select a report category';
    }
    if (empty($data['description'])) {
        $data['description_err'] = 'Please provide a description';
    }

    // Check for errors
    if (empty($data['reported_user_message_err']) && empty($data['category_err']) && empty($data['description_err'])) {
        // No errors, attempt to update report
        if ($this->chatModel->updateReport($data)) {
            flash('report_message', 'Chat report updated successfully', 'alert alert-success');
            redirect('chat/viewreport/' . $reportId); // Redirect to report details page
        } else {
            flash('report_message', 'Something went wrong, please try again', 'alert alert-danger');
            $this->view('chat/editreport', $data); // Load view with data if update fails
        }
    } else {
        // Load view with errors
        $this->view('chat/editreport', $data);
    }
}

public function deletereport($reportId = null)
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || $reportId === null) {
        redirect('chat/myreports');
        return;
    }

    // Fetch the report to verify ownership
    $report = $this->chatModel->getReportById($reportId);

    // Explicitly cast to object if it's an array
    if (is_array($report)) {
        $report = (object) $report;
    }

    // Check if report exists and the current user is the reporter and not a superadmin
    if (!$report || $report->reporter_id != $_SESSION['user_id'] || $_SESSION['user_role_id'] == 3) {
        flash('report_message', 'You are not authorized to delete this report', 'alert alert-danger');
        redirect('chat/myreports');
        return;
    }

    if ($this->chatModel->deleteReport($reportId, $_SESSION['user_id'])) {
        flash('report_message', 'Chat report deleted successfully', 'alert alert-success');
        redirect('chat/myreports'); // Redirect to user's reports after deletion
    } else {
        flash('report_message', 'Something went wrong, please try again', 'alert alert-danger');
        redirect('chat/viewreport/' . $reportId); // Redirect back to report details page if deletion fails
    }
}

}