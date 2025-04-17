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
        if (is_object($result)) {
            return $result->count;
        } elseif (is_array($result)) {
            return $result['count'];
        } else {
            return 0;
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
        // Validate status
        if (!in_array($status, ['pending', 'accepted', 'declined'])) {
            error_log("Invalid status: $status for request ID: $id");
            return false;
        }
        
        // Log the attempt
        error_log("Attempting to update request $id to status: $status");
        
        try {
            // Prepare and execute the update
            $this->db->query('UPDATE chat_requests SET status = :status WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->bind(':status', $status);
            
            $result = $this->db->execute();
            
            if ($result) {
                // Verify the update
                $verified = $this->verifyRequestStatus($id, $status);
                if ($verified) {
                    error_log("Successfully updated request $id to status: $status");
                    return true;
                } else {
                    error_log("Verification failed for request $id: Status did not update to $status");
                    // Fallback: Attempt a direct update without transaction
                    $this->db->query('UPDATE chat_requests SET status = :status WHERE id = :id');
                    $this->db->bind(':id', $id);
                    $this->db->bind(':status', $status);
                    $fallbackResult = $this->db->execute();
                    if ($fallbackResult && $this->verifyRequestStatus($id, $status)) {
                        error_log("Fallback update successful for request $id to status: $status");
                        return true;
                    } else {
                        error_log("Fallback update failed for request $id");
                        return false;
                    }
                }
            } else {
                error_log("Failed to execute update query for request $id");
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception during status update for request $id: " . $e->getMessage());
            return false;
        }
    }
    
    // Verify database update
    public function verifyRequestStatus($id, $expectedStatus) {
        $this->db->query('SELECT status FROM chat_requests WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $result = $this->db->single();
        $actualStatus = is_object($result) ? $result->status : (is_array($result) ? $result['status'] : null);
        
        error_log("Verifying status for request $id: Expected $expectedStatus, Actual $actualStatus");
        
        return $actualStatus === $expectedStatus;
    }
    
    // Create a new chat between two users
    public function createChat($user1Id, $user2Id) {
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

    // Update a message
public function updateMessage($messageId, $newMessage, $userId) {
    // First verify the user owns this message
    $this->db->query('SELECT * FROM messages WHERE id = :id AND sender_id = :sender_id');
    $this->db->bind(':id', $messageId);
    $this->db->bind(':sender_id', $userId);
    $message = $this->db->single();
    
    if (!$message) {
        return false; // Message not found or user doesn't own it
    }
    
    // Update the message
    $this->db->query('UPDATE messages SET message = :message WHERE id = :id');
    $this->db->bind(':id', $messageId);
    $this->db->bind(':message', $newMessage);
    
    return $this->db->execute();
}

public function deleteMessage($messageId, $userId) {
    // First verify the user owns this message
    $this->db->query('SELECT * FROM messages WHERE id = :id AND sender_id = :sender_id');
    $this->db->bind(':id', $messageId);
    $this->db->bind(':sender_id', $userId);
    $message = $this->db->single();
    
    if (!$message) {
        error_log('DeleteMessage: Message ID ' . $messageId . ' not found or not owned by user ' . $userId);
        return false;
    }
    
    // Delete the message
    $this->db->query('DELETE FROM messages WHERE id = :id');
    $this->db->bind(':id', $messageId);
    
    if ($this->db->execute()) {
        error_log('DeleteMessage: Successfully deleted message ID ' . $messageId);
        return true;
    } else {
        error_log('DeleteMessage: Failed to delete message ID ' . $messageId);
        return false;
    }
}

// Get a specific message by ID
public function getMessageById($messageId) {
    $this->db->query('SELECT * FROM messages WHERE id = :id');
    $this->db->bind(':id', $messageId);
    
    return $this->db->single();
}
}