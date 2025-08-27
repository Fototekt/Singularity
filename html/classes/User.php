<?php
/**
 * User Class
 * Handles user authentication and management
 */

class User {
    private $conn;
    private $table_name = "users";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Create new user
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (organization_id, email, password_hash, first_name, last_name, role, verification_token) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        $verification_token = generateToken();
        $password_hash = hashPassword($data['password']);
        
        return $stmt->execute([
            $data['organization_id'],
            $data['email'],
            $password_hash,
            $data['first_name'],
            $data['last_name'],
            $data['role'] ?? 'end_user',
            $verification_token
        ]);
    }
    
    // Authenticate user
    public function authenticate($email, $password) {
        $query = "SELECT u.*, o.name as organization_name, o.subscription_tier 
                 FROM " . $this->table_name . " u 
                 LEFT JOIN organizations o ON u.organization_id = o.id 
                 WHERE u.email = ? AND u.status = 'active' AND u.email_verified = TRUE";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (verifyPassword($password, $user['password_hash'])) {
                // Update last login
                $this->updateLastLogin($user['id']);
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['organization_id'] = $user['organization_id'];
                $_SESSION['subscription_tier'] = $user['subscription_tier'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                
                return $user;
            }
        }
        
        return false;
    }
    
    // Get user by ID
    public function getById($id) {
        $query = "SELECT u.*, o.name as organization_name, o.subscription_tier 
                 FROM " . $this->table_name . " u 
                 LEFT JOIN organizations o ON u.organization_id = o.id 
                 WHERE u.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Get user by email
    public function getByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Verify email
    public function verifyEmail($token) {
        $query = "UPDATE " . $this->table_name . " 
                 SET email_verified = TRUE, status = 'active', verification_token = NULL 
                 WHERE verification_token = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$token]);
    }
    
    // Request password reset
    public function requestPasswordReset($email) {
        $user = $this->getByEmail($email);
        if (!$user) return false;
        
        $reset_token = generateToken();
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $query = "UPDATE " . $this->table_name . " 
                 SET reset_token = ?, reset_expires = ? 
                 WHERE email = ?";
        
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$reset_token, $expires, $email]);
        
        if ($result) {
            // Send reset email
            $reset_link = APP_URL . "/reset-password.php?token=" . $reset_token;
            $subject = "Password Reset - " . APP_NAME;
            $body = "Click the following link to reset your password: " . $reset_link;
            
            sendEmail($email, $subject, $body);
            return true;
        }
        
        return false;
    }
    
    // Reset password
    public function resetPassword($token, $new_password) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE reset_token = ? AND reset_expires > NOW()";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$token]);
        
        if ($stmt->rowCount() == 1) {
            $password_hash = hashPassword($new_password);
            
            $update_query = "UPDATE " . $this->table_name . " 
                           SET password_hash = ?, reset_token = NULL, reset_expires = NULL 
                           WHERE reset_token = ?";
            
            $update_stmt = $this->conn->prepare($update_query);
            return $update_stmt->execute([$password_hash, $token]);
        }
        
        return false;
    }
    
    // Update last login
    private function updateLastLogin($user_id) {
        $query = "UPDATE " . $this->table_name . " SET last_login = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
    }
    
    // Get users by organization
    public function getByOrganization($org_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE organization_id = ? 
                 ORDER BY last_name, first_name";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$org_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Update user role
    public function updateRole($user_id, $new_role) {
        $query = "UPDATE " . $this->table_name . " SET role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$new_role, $user_id]);
    }
    
    // Deactivate user
    public function deactivate($user_id) {
        $query = "UPDATE " . $this->table_name . " SET status = 'inactive' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id]);
    }
}
?>