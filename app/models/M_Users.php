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
        // Insert user data into the `users` table
        $this->db->query('INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)');
        $this->db->bind(':name', $userData['name']);
        $this->db->bind(':email', $userData['email']);
        $this->db->bind(':password', $userData['password']);
        $this->db->bind(':role_id', $userData['role_id']);

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
        $this->db->query('INSERT INTO super_admins (user_id) VALUES (:user_id)');
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
}