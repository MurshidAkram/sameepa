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
                case '6':
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

    public function findUserByPhone($phone)
    {
        $this->db->query('SELECT * FROM residents r  WHERE phonenumber = :phonenumber');
        $this->db->bind(':phonenumber', $phone);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function getResidentIDByUserId($userId)
    {
        $this->db->query('SELECT * FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
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
            $roleId = $_SESSION['user_role_id'];
            switch ($roleId) {
                case 1:
                    $this->db->query('DELETE FROM residents WHERE user_id = :user_id');
                    break;
                case 2:
                    $this->db->query('DELETE FROM admins WHERE user_id = :user_id');
                    break;
                case 4:
                    $this->db->query('DELETE FROM maintenance WHERE user_id = :user_id');
                    break;
                case 5:
                    $this->db->query('DELETE FROM security WHERE user_id = :user_id');
                    break;
            }
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

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
                      WHERE u.is_active = 0 AND u.is_rejected= 0
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
                      WHERE u.role_id = :role_id AND u.is_rejected = 0');
        $this->db->bind(':role_id', $roleId);
        return $this->db->resultSet();
    }

    public function deletePendingUser($userId)
    {
        try {
            $this->db->beginTransaction();

            $this->db->query("UPDATE users SET is_rejected = 1 WHERE id = :user_id");
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            $this->db->commit();

            return true;
        } catch (Exception $e) {
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

            $this->db->query("SELECT role_id FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $userId);
            $userRole = $this->db->single();

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


    public function getResidentAddressAndPhone($userId)
    {
        $this->db->query('SELECT address, phonenumber FROM residents WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    //DONE BY SANKAVI TO GET THE ACTIVE USERS FOR THE SUPER ADMIN DASHBOARD
    public function getActiveUsers()
    {
        try {
            $this->db->query('SELECT COUNT(*) AS activeUsersCount FROM users WHERE is_active = 1');
            $result = $this->db->single();

            if (!$result) {
                error_log("Database query failed or returned empty result.");
                return 0;
            }

            error_log("Fetched Active Users: " . print_r($result, true));

            return (int) $result['activeUsersCount'];
        } catch (Exception $e) {
            error_log("Error fetching active users: " . $e->getMessage());
            return 0;
        }
    }

    public function createPasswordResetToken($email)
    {
        $user = $this->findUserByEmail($email);
        if (!$user) {
            return false;
        }

        $token = bin2hex(random_bytes(32));
        $token = bin2hex(random_bytes(32));

        $this->db->query('SELECT * FROM password_resets WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user['id']);
        $existingToken = $this->db->single();

        if ($existingToken) {
            $this->db->query('UPDATE password_resets SET token = :token, expires_at = NOW() + INTERVAL 1 HOUR WHERE user_id = :user_id');
        } else {
            $this->db->query('INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, NOW() + INTERVAL 1 HOUR)');
        }

        $this->db->bind(':user_id', $user['id']);
        $this->db->bind(':token', $token);

        if ($this->db->execute()) {
            return [
                'token' => $token,
                'user' => $user
            ];
        } else {
            return false;
        }
    }

    public function verifyPasswordResetToken($token)
    {
        $this->db->query('SELECT pr.*, u.email, u.id as user_id
                         FROM password_resets pr
                         JOIN users u ON pr.user_id = u.id
                         WHERE pr.token = :token AND pr.expires_at > NOW()');
        $this->db->bind(':token', $token);

        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function resetPassword($userId, $newPassword)
    {
        $this->db->query('UPDATE users SET password = :password WHERE id = :id');
        $this->db->bind(':password', password_hash($newPassword, PASSWORD_DEFAULT));
        $this->db->bind(':id', $userId);

        $success = $this->db->execute();

        if ($success) {
            $this->db->query('DELETE FROM password_resets WHERE user_id = :user_id');
            $this->db->bind(':user_id', $userId);
            $this->db->execute();
        }

        return $success;
    }

    public function getResidentsWithAddresses()
    {
        $this->db->query('
            SELECT u.id, u.name, r.address 
            FROM users u 
            JOIN residents r ON u.id = r.user_id 
            WHERE u.role_id = 1 AND u.is_active = 1 
            ORDER BY u.name
        ');
        return $this->db->resultSet();
    }


    public function getActiveUsersCount()
    {
        try {
            $this->db->query('SELECT COUNT(*) AS activeUsersCount FROM users WHERE is_active = 1');
            $result = $this->db->single();
            if (!$result) {
                error_log("Database query failed or returned empty result.");
                return 0;
            }
            return (int) $result['activeUsersCount'];
        } catch (Exception $e) {
            error_log("Error fetching active users: " . $e->getMessage());
            return 0;
        }
    }
}
