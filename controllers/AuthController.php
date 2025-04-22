<?php
require_once 'core/Controller.php';

class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $this->db->query("SELECT * FROM users WHERE email = :email");
            $this->db->bind(':email', $email);
            $user = $this->db->single();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                
                $this->redirect('dashboard');
            } else {
                $_SESSION['flash_message'] = 'Invalid email or password';
                $_SESSION['flash_type'] = 'danger';
            }
        }
        
        $this->render('auth/login');
    }
    
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validate input
            $errors = $this->validateInput($_POST, [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'confirm_password' => 'required'
            ]);
            
            if ($password !== $confirmPassword) {
                $errors['confirm_password'] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                // Check if email already exists
                $this->db->query("SELECT id FROM users WHERE email = :email");
                $this->db->bind(':email', $email);
                if ($this->db->single()) {
                    $errors['email'] = 'Email already exists';
                } else {
                    // Create user
                    $this->db->query("INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password, 'player')");
                    $this->db->bind(':name', $name);
                    $this->db->bind(':email', $email);
                    $this->db->bind(':password', password_hash($password, PASSWORD_DEFAULT));
                    
                    if ($this->db->execute()) {
                        $userId = $this->db->lastInsertId();
                        
                        // Create player record
                        $this->db->query("INSERT INTO players (user_id) VALUES (:user_id)");
                        $this->db->bind(':user_id', $userId);
                        $this->db->execute();
                        
                        $_SESSION['flash_message'] = 'Registration successful! Please login.';
                        $_SESSION['flash_type'] = 'success';
                        $this->redirect('login');
                    } else {
                        $_SESSION['flash_message'] = 'Registration failed. Please try again.';
                        $_SESSION['flash_type'] = 'danger';
                    }
                }
            }
            
            if (!empty($errors)) {
                $_SESSION['flash_message'] = 'Please correct the errors below.';
                $_SESSION['flash_type'] = 'danger';
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
            }
        }
        
        $this->render('auth/signup');
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('login');
    }
} 