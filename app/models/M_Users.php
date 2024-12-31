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

        $verificationDocument = isset($userData['verification_document']) ? $userData['verification_document'] : null;
        $verificationFilename = isset($userData['verification_filename']) ? $userData['verification_filename'] : null;

        $this->db->query('INSERT INTO users (name, email, password, role_id, is_active, role_verification_document, role_verification_filename) VALUES (:name, :email, :password, :role_id, :is_active, :verification_document, :verification_filename)');
        $this->db->bind(':name', $userData['name']);
        $this->db->bind(':email', $userData['email']);
        $this->db->bind(':password', $userData['password']);
        $this->db->bind(':role_id', $userData['role_id']);
        $this->db->bind(':is_active', $isActive);
        $this->db->bind(':verification_document', $verificationDocument);
        $this->db->bind(':verification_filename', $verificationFilename);


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

    public function activateUser($userId)
    {
        $this->db->query('UPDATE users SET is_active = 1 WHERE id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function deactivateUser($userId)
    {
        $this->db->query('UPDATE users SET is_active = 0 WHERE id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
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

    public function deletePendingUser($userId)
    {
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

    public function getUserVerificationDocument($userId)
    {
        $this->db->query('SELECT role_verification_document, role_verification_filename FROM users WHERE id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function deleteActivatedUser($userId)
    {
        try {
            $this->db->beginTransaction();

            // First, check which role tables to delete from
            $this->db->query("SELECT role_id FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $userId);
            $userRole = $this->db->single();

            // Delete from corresponding role table based on role_id
            switch ($userRole['role_id']) {
                case 1: // Resident
                    $this->db->query("DELETE FROM residents WHERE user_id = :user_id");
                    break;
                case 2: // Admin
                    $this->db->query("DELETE FROM admins WHERE user_id = :user_id");
                    break;
                case 4: // Maintenance
                    $this->db->query("DELETE FROM maintenance WHERE user_id = :user_id");
                    break;
                case 5: // Security
                    $this->db->query("DELETE FROM security WHERE user_id = :user_id");
                    break;
                case 6: // External Service Provider
                    $this->db->query("DELETE FROM external_service_providers WHERE user_id = :user_id");
                    break;
            }

            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            // Then delete from users table
            $this->db->query("DELETE FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Log the actual error
            error_log("User deletion error: " . $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }
    public function getActiveUsers()
    {
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1");
        $result = $this->db->single();
        return $result ? $result->count : 0;
    }
    
}
