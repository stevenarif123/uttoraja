<?php
session_start();

// Constants
define('CREDENTIALS_FILE', __DIR__ . '/credentials.json');
define('SESSION_NAME', 'uttoraja_admin');
define('SESSION_LIFETIME', 7200); // 2 hours in seconds
define('LOGIN_ATTEMPTS_LIMIT', 5);
define('LOGIN_ATTEMPTS_TIMEOUT', 1800); // 30 minutes in seconds

/**
 * 🔒 Authentication class for handling admin login
 */
class Auth {
    private $credentials;
    
    /**
     * Constructor - load credentials from JSON file
     */
    public function __construct() {
        if (file_exists(CREDENTIALS_FILE)) {
            $json = file_get_contents(CREDENTIALS_FILE);
            $this->credentials = json_decode($json, true);
        } else {
            $this->credentials = ['users' => []];
            // Create default admin if no file exists
            $this->addUser('admin', 'uttoraja123', 'Administrator', 'admin');
            $this->saveCredentials();
        }
    }
    
    /**
     * Save credentials to JSON file
     */
    private function saveCredentials() {
        $json = json_encode($this->credentials, JSON_PRETTY_PRINT);
        file_put_contents(CREDENTIALS_FILE, $json);
    }
    
    /**
     * Add a new user
     */
    public function addUser($username, $password, $name, $role = 'admin') {
        // Check if username already exists
        foreach ($this->credentials['users'] as $user) {
            if ($user['username'] === $username) {
                return false; // Username already exists
            }
        }
        
        // Add new user
        $this->credentials['users'][] = [
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'name' => $name,
            'role' => $role,
            'last_login' => null
        ];
        
        $this->saveCredentials();
        return true;
    }
    
    /**
     * Check if the login credentials are valid
     */
    public function login($username, $password) {
        // Check for too many login attempts
        if ($this->checkLoginAttempts()) {
            return ['success' => false, 'message' => 'Terlalu banyak percobaan login. Coba lagi nanti.'];
        }
        
        foreach ($this->credentials['users'] as &$user) {
            if ($user['username'] === $username) {
                if (password_verify($password, $user['password_hash'])) {
                    // Update last login
                    $user['last_login'] = date('Y-m-d H:i:s');
                    $this->saveCredentials();
                    
                    // Set session
                    $_SESSION['user'] = [
                        'username' => $user['username'],
                        'name' => $user['name'],
                        'role' => $user['role'],
                        'login_time' => time()
                    ];
                    
                    // Reset login attempts
                    $this->resetLoginAttempts();
                    
                    return ['success' => true, 'user' => $user];
                }
            }
        }
        
        // Login failed - increment attempts
        $this->incrementLoginAttempts();
        
        return ['success' => false, 'message' => 'Username atau password salah.'];
    }
    
    /**
     * Log out the current user
     */
    public function logout() {
        // Unset all session variables
        $_SESSION = [];
        
        // Delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
    }
    
    /**
     * Check if a user is logged in
     */
    public function isLoggedIn() {
        if (!isset($_SESSION['user'])) {
            return false;
        }
        
        // Check if session has expired
        $loginTime = $_SESSION['user']['login_time'];
        if (time() - $loginTime > SESSION_LIFETIME) {
            $this->logout();
            return false;
        }
        
        // Update login time to extend session
        $_SESSION['user']['login_time'] = time();
        return true;
    }
    
    /**
     * Get the current user
     */
    public function currentUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
    
    /**
     * Change password for a user
     */
    public function changePassword($username, $oldPassword, $newPassword) {
        foreach ($this->credentials['users'] as &$user) {
            if ($user['username'] === $username) {
                if (password_verify($oldPassword, $user['password_hash'])) {
                    $user['password_hash'] = password_hash($newPassword, PASSWORD_BCRYPT);
                    $this->saveCredentials();
                    return true;
                }
                return false;
            }
        }
        return false;
    }
    
    /**
     * Check login attempts - prevent brute force attacks
     */
    private function checkLoginAttempts() {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['login_attempts_time'] = time();
            return false;
        }
        
        // Reset attempts if timeout has passed
        if (time() - $_SESSION['login_attempts_time'] > LOGIN_ATTEMPTS_TIMEOUT) {
            $this->resetLoginAttempts();
            return false;
        }
        
        // Too many attempts
        if ($_SESSION['login_attempts'] >= LOGIN_ATTEMPTS_LIMIT) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Increment login attempts
     */
    private function incrementLoginAttempts() {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
            $_SESSION['login_attempts_time'] = time();
        } else {
            $_SESSION['login_attempts']++;
        }
    }
    
    /**
     * Reset login attempts
     */
    private function resetLoginAttempts() {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_attempts_time'] = time();
    }
}

// Create global auth instance
$auth = new Auth();

/**
 * 🔐 Helper function to require login for protected pages
 */
function requireLogin() {
    global $auth;
    
    if (!$auth->isLoggedIn()) {
        // Store the requested URL for redirection after login
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        
        header('Location: /uttoraja/pendaftaran/admin/login.php');
        exit;
    }
}
?>
