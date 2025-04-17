<?php
class M_Chat {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all chats for a specific user
    public function getChatsByUserId($userId) {
        $this->db->query('SELECT * FROM chats
        WHERE user1_id = :user_id OR user2_id = :user_id
        ORDER BY created_at DESC');
        
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }
    public function getAllUsersExcept($userId) {
        $this->db->query('SELECT * FROM users WHERE id != :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    
    public function searchUsers($search, $excludeId) {
        $this->db->query('SELECT * FROM users WHERE id != :id AND name LIKE :search');
        $this->db->bind(':id', $excludeId);
        $this->db->bind(':search', '%' . $search . '%');
        return $this->db->resultSet();
    }
    
    
    
    // Get the last message in a chat
    public function getLastMessageByChatId($chatId) {
        $this->db->query('SELECT * FROM messages 
                         WHERE chat_id = :chat_id 
                         ORDER BY sent_at DESC 
                         LIMIT 1');
        
        $this->db->bind(':chat_id', $chatId);
        
        return $this->db->single();
    }
    
    // Count unread messages for a user in a chat
    public function getUnreadMessageCount($chatId, $userId) {
        $this->db->query('SELECT COUNT(*) as count FROM messages
        WHERE chat_id = :chat_id
        AND sender_id != :user_id
        AND is_read = false');
        $this->db->bind(':chat_id', $chatId);
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        // your database is returning the result as an array.
        // Check if $result is an object or array and access accordingly
        if (is_object($result)) {
            return $result->count;
        } elseif (is_array($result)) {
            return $result['count'];
        } else {
            return 0; // Default fallback value if $result is null or another type
        }
    }
    
    
    // Create a new chat request
    public function createChatRequest($senderId, $recipientId) {
        $this->db->query('INSERT INTO chat_requests (sender_id, recipient_id, status) 
                         VALUES (:sender_id, :recipient_id, "pending")');
        
        $this->db->bind(':sender_id', $senderId);
        $this->db->bind(':recipient_id', $recipientId);
        
        return $this->db->execute();
    }
    
    // Get a chat request by users
    public function getRequestByUsers($senderId, $recipientId) {
        $this->db->query('SELECT * FROM chat_requests 
                         WHERE sender_id = :sender_id 
                         AND recipient_id = :recipient_id 
                         AND status = "pending"');
        
        $this->db->bind(':sender_id', $senderId);
        $this->db->bind(':recipient_id', $recipientId);
        
        return $this->db->single();
    }
    
    // Get all chat requests for a user
    public function getChatRequests($userId) {
        $this->db->query('SELECT cr.*, u.name 
                         FROM chat_requests cr
                         JOIN users u ON cr.sender_id = u.id
                         WHERE cr.recipient_id = :recipient_id 
                         AND cr.status = "pending"
                         ORDER BY cr.created_at DESC');
        
        $this->db->bind(':recipient_id', $userId);
        
        return $this->db->resultSet();
    }
    
    // Get a specific request by ID
    public function getRequestById($id) {
        $this->db->query('SELECT * FROM chat_requests WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Update a request status (accepted/declined)
    public function updateRequestStatus($id, $status) {
        $this->db->query('UPDATE chat_requests SET status = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        
        return $this->db->execute();
    }
    
    // Create a new chat between two users
    public function createChat($user1Id, $user2Id) {
        // First check if a chat already exists
        $existingChat = $this->getChatByUsers($user1Id, $user2Id);
        if ($existingChat) {
            return is_object($existingChat) ? $existingChat->id : $existingChat['id'];
        }
        
        $this->db->query('INSERT INTO chats (user1_id, user2_id, created_at, updated_at) 
                         VALUES (:user1_id, :user2_id, NOW(), NOW())');
        $this->db->bind(':user1_id', $user1Id);
        $this->db->bind(':user2_id', $user2Id);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    // Get a chat by its ID
    public function getChatById($chatId) {
        $this->db->query('SELECT * FROM chats WHERE id = :id');
        $this->db->bind(':id', $chatId);
        
        return $this->db->single();
    }
    
    // Find a chat between two users
    public function getChatByUsers($user1Id, $user2Id) {
        $this->db->query('SELECT * FROM chats 
                         WHERE (user1_id = :user1_id AND user2_id = :user2_id)
                         OR (user1_id = :user2_id AND user2_id = :user1_id)
                         LIMIT 1');
        
        $this->db->bind(':user1_id', $user1Id);
        $this->db->bind(':user2_id', $user2Id);
        
        return $this->db->single();
    }
    
    // Get messages for a specific chat
    public function getMessagesByChatId($chatId) {
        $this->db->query('SELECT * FROM messages 
                         WHERE chat_id = :chat_id 
                         ORDER BY sent_at ASC');
        
        $this->db->bind(':chat_id', $chatId);
        
        return $this->db->resultSet();
    }
    
    // Mark messages as read
    public function markMessagesAsRead($chatId, $recipientId) {
        $this->db->query('UPDATE messages 
                         SET is_read = true 
                         WHERE chat_id = :chat_id 
                         AND sender_id != :recipient_id 
                         AND is_read = false');
        
        $this->db->bind(':chat_id', $chatId);
        $this->db->bind(':recipient_id', $recipientId);
        
        return $this->db->execute();
    }
    
    // Send a new message
    public function sendMessage($data) {
        $this->db->query('INSERT INTO messages (chat_id, sender_id, message, sent_at, is_read)
                          VALUES (:chat_id, :sender_id, :message, NOW(), false)');
        $this->db->bind(':chat_id', $data['chat_id']);
        $this->db->bind(':sender_id', $data['sender_id']);
        $this->db->bind(':message', $data['message']);
    
        if ($this->db->execute()) {
            $this->db->query('UPDATE chats SET created_at = NOW() WHERE id = :chat_id');
            $this->db->bind(':chat_id', $data['chat_id']);
            return $this->db->execute();
        }
    
        return false;
    }
    
    
}