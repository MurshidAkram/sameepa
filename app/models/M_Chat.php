<?php
class M_Chat
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Get all active chats for a user
    public function getUserChats($user_id)
    {
        $this->db->query('
            SELECT c.id, 
                   CASE 
                     WHEN c.user1_id = :user_id THEN u2.name 
                     ELSE u1.name 
                   END AS other_user_name,
                   CASE 
                     WHEN c.user1_id = :user_id THEN u2.id 
                     ELSE u1.id 
                   END AS other_user_id,
                   (SELECT message FROM messages WHERE chat_id = c.id ORDER BY sent_at DESC LIMIT 1) AS last_message,
                   (SELECT sent_at FROM messages WHERE chat_id = c.id ORDER BY sent_at DESC LIMIT 1) AS last_message_time
            FROM chats c
            JOIN users u1 ON c.user1_id = u1.id
            JOIN users u2 ON c.user2_id = u2.id
            WHERE c.user1_id = :user_id OR c.user2_id = :user_id
            ORDER BY last_message_time DESC
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Search for users to start a chat
    // Temporary debugging approach
    public function searchUsers($current_user_id, $searchTerm)
    {
        $this->db->query('
        SELECT id, name, role_id 
        FROM users 
        WHERE id != :current_user_id 
        AND name LIKE :search
    ');
        $this->db->bind(':current_user_id', $current_user_id);
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }

    // Get recommended users to chat with
    public function getRecommendedUsers($current_user_id)
    {
        $this->db->query('
            SELECT id, name, role_id
            FROM users 
            WHERE id != :current_user_id 
            LIMIT 10
        ');
        $this->db->bind(':current_user_id', $current_user_id);
        return $this->db->resultSet();
    }
    public function getProfileById($id)
{
    $this->db->query('SELECT id, name, profile_picture FROM users WHERE id = :id');
    $this->db->bind(':id', $id);
    return $this->db->single(); // ✅ returns a single user object
}

    // Get pending chat requests
    public function getPendingChatRequests($user_id)
    {
        $this->db->query('
            SELECT 
                cr.id,
                cr.sender_id,
                cr.created_at,
                u.name,
                u.id as user_id
            FROM chat_requests cr
            JOIN users u ON cr.sender_id = u.id
            WHERE cr.recipient_id = :user_id 
            AND cr.status = "pending"
            ORDER BY cr.created_at DESC
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
    // Get or create chat between two users
    public function getChatBetweenUsers($user1_id, $user2_id)
    {
        $this->db->query('
            SELECT * FROM chats 
            WHERE (user1_id = :user1 AND user2_id = :user2) 
            OR (user1_id = :user2 AND user2_id = :user1)
        ');
        $this->db->bind(':user1', $user1_id);
        $this->db->bind(':user2', $user2_id);
        $chat = $this->db->single();

        if (!$chat) {
            return $this->createChat($user1_id, $user2_id);
        }
        return $chat;
    }
    public function createChat($user1_id, $user2_id)
    {
        try {
            error_log("Creating chat between users: $user1_id and $user2_id");

            $this->db->query('INSERT INTO chats (user1_id, user2_id) VALUES (:user1_id, :user2_id)');
            $this->db->bind(':user1_id', $user1_id);
            $this->db->bind(':user2_id', $user2_id);

            if ($this->db->execute()) {
                $chatId = $this->db->lastInsertId();
                error_log("Successfully created chat with ID: $chatId");
                return $chatId;
            }

            error_log("Failed to create chat");
            return false;
        } catch (Exception $e) {
            error_log("Error creating chat: " . $e->getMessage());
            return false;
        }
    }

    public function getChatIdForUsers($user1Id, $user2Id)
    {
        $this->db->query('SELECT id FROM chats 
            WHERE (user1_id = :user1_id AND user2_id = :user2_id)
            OR (user1_id = :user2_id AND user2_id = :user1_id)
            LIMIT 1');
        $this->db->bind(':user1_id', $user1Id);
        $this->db->bind(':user2_id', $user2Id);
        $result = $this->db->single();
        return $result ? $result->id : null;
    }
    public function getChatById($chatId)
    {
        $this->db->query('SELECT * FROM chats WHERE id = :id');
        $this->db->bind(':id', $chatId);
        return $this->db->single();
    }

    public function getMessagesByChatId($chatId)
    {
        $this->db->query('SELECT * FROM messages WHERE chat_id = :chat_id ORDER BY sent_at ASC');
        $this->db->bind(':chat_id', $chatId);
        return $this->db->resultSet();
    }
    // In your ChatModel class
    public function getRequestsForUser($userId)
    {
        $this->db->query('SELECT cr.*, u.name, u.id as user_id 
        FROM chat_requests cr
        JOIN users u ON (
            CASE 
                WHEN cr.recipient_id = :user_id THEN cr.sender_id = u.id
                WHEN cr.sender_id = :user_id THEN cr.recipient_id = u.id
            END
        )
        WHERE (cr.recipient_id = :user_id OR cr.sender_id = :user_id)
        AND cr.status = "pending"');

        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Get messages for a specific chat
    public function getChatMessages($chat_id)
    {
        $this->db->query('
            SELECT m.*, u.name as sender_name 
            FROM messages m
            JOIN users u ON m.sender_id = u.id
            WHERE m.chat_id = :chat_id
            ORDER BY m.sent_at ASC
        ');
        $this->db->bind(':chat_id', $chat_id);
        return $this->db->resultSet();
    }

    // Add a new message to a chat
    public function addMessage($chat_id, $sender_id, $message)
    {
        $this->db->query('
            INSERT INTO messages (chat_id, sender_id, message) 
            VALUES (:chat_id, :sender_id, :message)
        ');
        $this->db->bind(':chat_id', $chat_id);
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':message', $message);

        return $this->db->execute();
    }

    // Get the other user in a chat
    public function getOtherUserId($chat_id, $current_user_id)
    {
        $this->db->query('
            SELECT 
                CASE 
                    WHEN user1_id = :current_user THEN user2_id 
                    ELSE user1_id 
                END AS other_user_id
            FROM chats 
            WHERE id = :chat_id
        ');
        $this->db->bind(':chat_id', $chat_id);
        $this->db->bind(':current_user', $current_user_id);

        $result = $this->db->single();
        return $result->other_user_id;
    }

    public function acceptChatRequest($request_id)
    {
        // Begin transaction to ensure data integrity
        $this->db->beginTransaction();

        try {
            // Get request details
            $this->db->query('SELECT sender_id, recipient_id FROM chat_requests WHERE id = :request_id');
            $this->db->bind(':request_id', $request_id);
            $request = $this->db->single();

            // Check if the request exists
            if (!$request) {
                error_log("Chat request not found for request_id: " . $request_id);
                $this->db->rollback();
                return false;
            }

            // Extract sender and recipient IDs
            $sender_id = $request->sender_id;
            $recipient_id = $request->recipient_id;

            // Validate sender and recipient IDs
            if (!$sender_id || !$recipient_id) {
                error_log("Invalid sender or recipient ID for request_id: " . $request_id);
                $this->db->rollback();
                return false;
            }

            // Insert new chat
            $this->db->query('INSERT INTO chats (user1_id, user2_id) VALUES (:user1, :user2)');
            $this->db->bind(':user1', $sender_id);
            $this->db->bind(':user2', $recipient_id);
            $this->db->execute();

            // Check if chat insertion was successful
            if ($this->db->rowCount() === 0) {
                error_log("Failed to insert chat for request_id: " . $request_id);
                $this->db->rollback();
                return false;
            }

            // Update the status of the chat request instead of deleting it
            $this->db->query('UPDATE chat_requests SET status = :status WHERE id = :request_id');
            $this->db->bind(':status', 'accepted'); // Change to the required status
            $this->db->bind(':request_id', $request_id);
            $this->db->execute();

            // Check if status update was successful
            if ($this->db->rowCount() === 0) {
                error_log("Failed to update chat request status for request_id: " . $request_id);
                $this->db->rollback();
                return false;
            }

            // Commit transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Log error and rollback transaction
            error_log("Error accepting chat request: " . $e->getMessage());
            $this->db->rollback();
            return false;
        }
    }

    public function getChatRequestById($id)
    {
        $this->db->query('SELECT * FROM chat_requests WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    public function updateRequestStatus($requestId, $status)
    {
        $this->db->query('UPDATE chat_requests SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $requestId);
        return $this->db->execute();
    }

    public function declineChatRequest($request_id)
    {
        // Simply delete the request
        $this->db->query('DELETE FROM chat_requests WHERE id = :request_id');
        $this->db->bind(':request_id', $request_id);
        return $this->db->execute();
    }


    public function sendChatRequest($sender_id, $recipient_id)
    {
        $this->db->query('
            INSERT INTO chat_requests (sender_id, recipient_id, status) 
            VALUES (:sender_id, :recipient_id, "pending")
        ');
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':recipient_id', $recipient_id);
        return $this->db->execute();
    }



    // Check if a request already exists
    public function checkExistingRequest($sender_id, $recipient_id)
    {
        $this->db->query('
            SELECT COUNT(*) as count 
            FROM chat_requests 
            WHERE (sender_id = :sender_id AND recipient_id = :recipient_id) 
            OR (sender_id = :recipient_id AND recipient_id = :sender_id)
        ');
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':recipient_id', $recipient_id);
        $result = $this->db->single();
        return $result->count > 0;
    }
}
