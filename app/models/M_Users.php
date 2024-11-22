<?php

class M_Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function registerUser($userData)
    {
        $isActive = ($userData['role_id'] == 3) ? 1 : 0; // SuperAdmins are active by default

        $this->db->query('INSERT INTO users (name, email, password, role_id, is_active) VALUES (:name, :email, :password, :role_id, :is_active)');
        $this->db->bind(':name', $userData['name']);
        $this->db->bind(':email', $userData['email']);
        $this->db->bind(':password', $userData['password']);
        $this->db->bind(':role_id', $userData['role_id']);
        $this->db->bind(':is_active', $isActive);

        if ($this->db->execute()) {
            $userId = $this->db->lastInsertId();

            // Handle different user types based on the role ID
            switch ($userData['role_id']) {
                case '1': // Resident
                    $residentData = [
                        'user_id' => $userId,
                        'address' => $userData['address'],
                        'phonenumber' => $userData['phonenumber']
                    ];
                    return $this->registerResident($residentData);
                case '2': // Admin
                    $adminData = [
                        'user_id' => $userId
                    ];
                    return $this->registerAdmin($adminData);
                case '3': // SuperAdmin
                    $superAdminData = [
                        'user_id' => $userId
                    ];
                    return $this->registerSuperAdmin($superAdminData);
                case '4': // Maintenance
                    $maintenanceData = [
                        'user_id' => $userId
                    ];
                    return $this->registerMaintenance($maintenanceData);
                case '5': // Security
                    $securityData = [
                        'user_id' => $userId
                    ];
                    return $this->registerSecurity($securityData);
                case '6': // External Service Provider
                    $externalServiceProviderData = [
                        'user_id' => $userId
                    ];
                    return $this->registerExternalServiceProvider($externalServiceProviderData);
                default:
                    return true;
            }
        } else {
            return false;
        }
    }



    private function registerResident($residentData)
    {
        // Insert resident data into the `residents` table
        $this->db->query('INSERT INTO residents (user_id, address, phonenumber) VALUES (:user_id, :address, :phonenumber)');
        $this->db->bind(':user_id', $residentData['user_id']);
        $this->db->bind(':address', $residentData['address']);
        $this->db->bind(':phonenumber', $residentData['phonenumber']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function registerAdmin($adminData)
    {
        // Insert admin data into the `admins` table
        $this->db->query('INSERT INTO admins (user_id) VALUES (:user_id)');
        $this->db->bind(':user_id', $adminData['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function registerSuperAdmin($superAdminData)
    {
        // Insert super admin data into the `super_admins` table
        $this->db->query('INSERT INTO superadmins (user_id) VALUES (:user_id)');
        $this->db->bind(':user_id', $superAdminData['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function registerMaintenance($maintenanceData)
    {
        // Insert maintenance data into the `maintenance` table
        $this->db->query('INSERT INTO maintenance (user_id) VALUES (:user_id)');
        $this->db->bind(':user_id', $maintenanceData['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function registerSecurity($securityData)
    {
        // Insert security data into the `security` table
        $this->db->query('INSERT INTO security (user_id) VALUES (:user_id)');
        $this->db->bind(':user_id', $securityData['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function registerExternalServiceProvider($externalServiceProviderData)
    {
        // Insert external service provider data into the `external_service_providers` table
        $this->db->query('INSERT INTO external_service_providers (user_id) VALUES (:user_id)');
        $this->db->bind(':user_id', $externalServiceProviderData['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function getResidentByUserId($userId)
    {
        $this->db->query('SELECT r.*, u.name, u.email 
                     FROM residents r
                     JOIN users u ON r.user_id = u.id
                     WHERE r.user_id = :userId');
        $this->db->bind(':userId', $userId);

        $row = $this->db->single();
        return $row;
    }

    public function getRoleName($roleId)
    {
        $this->db->query('SELECT name FROM roles WHERE id = :roleId');
        $this->db->bind(':roleId', $roleId);

        $roleName = $this->db->single()->name;
        return $roleName;
    }

    // Add these methods to your existing M_Users model class

    public function getUserById($userId)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $userId);
        return $this->db->single();
    }

    public function updateUser($data)
    {
        $this->db->beginTransaction();

        try {
            // Update basic user information
            $sql = 'UPDATE users SET name = :name, email = :email';
            if (!empty($data['new_password'])) {
                $sql .= ', password = :password';
            }
            $sql .= ' WHERE id = :id';

            $this->db->query($sql);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':id', $data['user_id']);

            if (!empty($data['new_password'])) {
                $this->db->bind(':password', password_hash($data['new_password'], PASSWORD_DEFAULT));
            }

            $this->db->execute();

            // Update role-specific information if user is a resident
            if ($_SESSION['user_role_id'] == 1 && isset($data['address']) && isset($data['phonenumber'])) {
                $this->db->query('UPDATE residents SET address = :address, phonenumber = :phonenumber WHERE user_id = :user_id');
                $this->db->bind(':address', $data['address']);
                $this->db->bind(':phonenumber', $data['phonenumber']);
                $this->db->bind(':user_id', $data['user_id']);
                $this->db->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updateProfilePicture($userId, $imageData)
    {
        $this->db->query('UPDATE users SET profile_picture = :profile_picture WHERE id = :id');
        $this->db->bind(':profile_picture', $imageData);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function deleteUser($userId)
    {
        $this->db->beginTransaction();

        try {
            // Delete role-specific data first
            $roleId = $_SESSION['user_role_id'];
            switch ($roleId) {
                case 1:
                    $this->db->query('DELETE FROM residents WHERE user_id = :user_id');
                    break;
                case 2:
                    $this->db->query('DELETE FROM admins WHERE user_id = :user_id');
                    break;
                    // Add other roles as needed
            }
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            // Delete user record
            $this->db->query('DELETE FROM users WHERE id = :id');
            $this->db->bind(':id', $userId);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getPendingUsers()
    {
        $this->db->query('SELECT u.*, r.name as role_name 
                      FROM users u 
                      JOIN roles r ON u.role_id = r.id 
                      WHERE u.is_active = 0 
                      ORDER BY u.registration_date DESC');
        return $this->db->resultSet();
    }

    public function activateUser($userId, $status)
    {
        $this->db->beginTransaction();
        $this->db->query('UPDATE users SET is_active = :status WHERE id = :user_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':user_id', $userId);
        $this->db->commit();
    
        // Debugging: Check if the query was executed successfully
        if ($this->db->execute()) {
            return true;
        } else {
            // You can use error_log or var_dump to debug
            error_log("Error in activateUser method, query execution failed.");
            return false;
        }
    }
    
    public function deactivateUser($userId, $status)
    {
        $this->db->beginTransaction();
        $this->db->query('UPDATE users SET is_active = :status WHERE id = :user_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':user_id', $userId);
        $this->db->commit();
    
        // Debugging: Check if the query was executed successfully
        if ($this->db->execute()) {
            return true;
        } else {
            // You can use error_log or var_dump to debug
            error_log("Error in deactivateUser method, query execution failed.");
            return false;
        }
    }
    

    public function getUsersByRole($roleId)
    {
        $this->db->query('SELECT u.*, r.name as role_name 
                      FROM users u 
                      JOIN roles r ON u.role_id = r.id 
                      WHERE u.role_id = :role_id');
        $this->db->bind(':role_id', $roleId);
        return $this->db->resultSet();
    }

    
    public function deletePendingUser($userId) {
        try {
            // Start transaction
            $this->db->beginTransaction();
    
            // Delete from child tables first
            $this->db->query("DELETE FROM security WHERE user_id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();
    
            $this->db->query("DELETE FROM residents WHERE user_id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();
            
            $this->db->query("DELETE FROM admins WHERE user_id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            $this->db->query("DELETE FROM maintenance WHERE user_id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            $this->db->query("DELETE FROM external_service_providers WHERE user_id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();
            // Finally, delete from users table
            $this->db->query("DELETE FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();
    
            // Commit transaction
            $this->db->commit();
    
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            return false;
        }
    }
    public function deleteActivatedUser($userId) {
        // Ensure that the user ID is numeric and valid
        if (!is_numeric($userId)) {
            return false;  // Invalid user ID
        }
    
        // Start a database transaction
        
    
        try {

            $this->db->beginTransaction();
            // Delete related user data from the `residents` table by user_id
            // $this->db->query('DELETE FROM residents WHERE user_id = :user_id AND is_active = 1');
            // $this->db->bind(':user_id', $userId);
            // $this->db->execute();
    
            // Remove user from the `admins` table by user_id
            // $this->db->query('DELETE FROM admins WHERE user_id = :user_id AND is_active = 1');
            // $this->db->bind(':user_id', $userId);
            // $this->db->execute();
    
            // Remove user from the `security` table by user_id
            // $this->db->query('DELETE FROM security WHERE user_id = :user_id AND is_active = 1');
            // $this->db->bind(':user_id', $userId);
            // $this->db->execute();
    
            // Finally, delete the user from the `users` table by user_id
            // First, select the user to check if the user exists with is_active = 1
$this->db->query('SELECT * FROM users ');
$this->db->bind(':user_id', $userId, PDO::PARAM_INT);

// Execute the SELECT query and fetch the result
$user = $this->db->single(); // or $this->db->resultSet() if expecting multiple rows

if ($user) {
    // If user exists, print the select query
    var_dump($user);
    echo "Select Query: SELECT * FROM users WHERE id = " . $userId . " AND is_active = 1";
} else {
    echo "No matching user found with id = " . $userId . " and is_active = 1";
}

// Now perform the delete operation

$this->db->query('DELETE FROM users WHERE id = :user_id AND is_active = 1');
$this->db->bind(':user_id', $userId, PDO::PARAM_INT);

if ($this->db->execute()) {
    
    echo "User deleted successfully.";
    $this->db->commit();
} else {
    $this->db->rollBack();
    echo "Error deleting user.";
}

            
    
            // Commit the transaction to finalize all changes
            
    
            return true; // Successful deletion
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $this->db->rollBack();
            // Log the error (optional)
            error_log("Error deleting user: " . $e->getMessage());
            return false; // Deletion failed
        }
    }
    

    public function deleteUserById($user_id) {
        try {
            // Start a transaction to ensure all related changes are done atomically
            $this->db->beginTransaction();
    
            // Check if the user exists and is active (you can also check for related records here if needed)
            $this->db->query('SELECT * FROM users WHERE id = :user_id ');
            $this->db->bind(':user_id', $user_id);
            $user = $this->db->single(); // Retrieve the user data
    
            // If no active user found, return false
            if (!$user) {
                return false;
            }
    
            // Delete associated records from other tables (roles, logs, etc.)
            // Example: Delete associated roles, logs, etc.
            // $this->deleteUserRoles($user_id);
    
            // Delete the user from the `users` table
            $this->db->query('DELETE FROM users WHERE id = :user_id ');
            $this->db->bind(':user_id', $user_id);
            $this->db->execute();
    
            // If you have more related deletions, add them here
            // Example: Delete user from other related tables
            // $this->db->query('DELETE FROM roles WHERE user_id = :user_id');
            // $this->db->bind(':user_id', $user_id);
            // $this->db->execute();
    
            // Commit the transaction if everything was successful
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback if something went wrong and log the error
            $this->db->rollBack();
            error_log('Error deleting user: ' . $e->getMessage());  // Log the error for debugging
            return false;
        }
    }
    // Example: UserController.php
// public function deleteActivatedUser()
// {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $userId = $_POST['user_id']; // Get the user ID from the POST request

//         // Ensure user ID is provided
//         if (!$userId) {
//             header('Content-Type: application/json');
//             echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
//             exit;
//         }

//         // Call the model method to delete the user
//         $result = $this->model('M_Users')->deleteUser($userId);

//         // Return appropriate JSON response
//         header('Content-Type: application/json');
//         if ($result) {
//             echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
//         } else {
//             echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
//         }
//         exit; // Prevent any further output
//     }
// }
    
    
    
}