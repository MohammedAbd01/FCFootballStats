<?php
require_once 'core/Controller.php';

class PlayerController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireLogin();
    }
    
    public function profile($id) {
        // Get player details
        $this->db->query("
            SELECT p.*, u.name, u.email, u.photo_url
            FROM players p
            JOIN users u ON p.user_id = u.id
            WHERE p.id = :id
        ");
        $this->db->bind(':id', $id);
        $player = $this->db->single();
        
        if (!$player) {
            $_SESSION['flash_message'] = 'Player not found.';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('dashboard');
        }
        
        // Get player's match history
        $this->db->query("
            SELECT ms.*, m.date, m.time, m.opponent, m.result
            FROM match_stats ms
            JOIN matches m ON ms.match_id = m.id
            WHERE ms.player_id = :player_id
            ORDER BY m.date DESC, m.time DESC
        ");
        $this->db->bind(':player_id', $id);
        $matchHistory = $this->db->resultSet();
        
        // Get player's performance stats
        $this->db->query("
            SELECT 
                COUNT(DISTINCT match_id) as total_matches,
                SUM(goals) as total_goals,
                SUM(assists) as total_assists,
                AVG(goals) as avg_goals,
                AVG(assists) as avg_assists
            FROM match_stats
            WHERE player_id = :player_id
        ");
        $this->db->bind(':player_id', $id);
        $performanceStats = $this->db->single();
        
        // Get player's recent form (last 5 matches)
        $this->db->query("
            SELECT ms.*, m.date, m.opponent
            FROM match_stats ms
            JOIN matches m ON ms.match_id = m.id
            WHERE ms.player_id = :player_id
            ORDER BY m.date DESC, m.time DESC
            LIMIT 5
        ");
        $this->db->bind(':player_id', $id);
        $recentForm = $this->db->resultSet();
        
        $this->render('players/profile', [
            'player' => $player,
            'matchHistory' => $matchHistory,
            'performanceStats' => $performanceStats,
            'recentForm' => $recentForm
        ]);
    }
    
    public function editProfile() {
        // Get player details
        $this->db->query("
            SELECT p.*, u.name, u.email, u.photo_url
            FROM players p
            JOIN users u ON p.user_id = u.id
            WHERE p.user_id = :user_id
        ");
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $player = $this->db->single();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validate input
            $errors = $this->validateInput($_POST, [
                'name' => 'required|min:3',
                'email' => 'required|email'
            ]);
            
            if (!empty($newPassword)) {
                if (strlen($newPassword) < 6) {
                    $errors['new_password'] = 'Password must be at least 6 characters';
                }
                if ($newPassword !== $confirmPassword) {
                    $errors['confirm_password'] = 'Passwords do not match';
                }
            }
            
            if (empty($errors)) {
                // Check if email is already taken by another user
                $this->db->query("
                    SELECT id FROM users 
                    WHERE email = :email AND id != :user_id
                ");
                $this->db->bind(':email', $email);
                $this->db->bind(':user_id', $_SESSION['user_id']);
                if ($this->db->single()) {
                    $errors['email'] = 'Email already exists';
                } else {
                    // Update user details
                    $this->db->query("
                        UPDATE users 
                        SET name = :name, email = :email
                        WHERE id = :user_id
                    ");
                    $this->db->bind(':name', $name);
                    $this->db->bind(':email', $email);
                    $this->db->bind(':user_id', $_SESSION['user_id']);
                    
                    if ($this->db->execute()) {
                        // Update password if provided
                        if (!empty($newPassword)) {
                            // Verify current password
                            $this->db->query("SELECT password_hash FROM users WHERE id = :user_id");
                            $this->db->bind(':user_id', $_SESSION['user_id']);
                            $user = $this->db->single();
                            
                            if (password_verify($currentPassword, $user['password_hash'])) {
                                $this->db->query("
                                    UPDATE users 
                                    SET password_hash = :password
                                    WHERE id = :user_id
                                ");
                                $this->db->bind(':password', password_hash($newPassword, PASSWORD_DEFAULT));
                                $this->db->bind(':user_id', $_SESSION['user_id']);
                                $this->db->execute();
                            } else {
                                $errors['current_password'] = 'Current password is incorrect';
                            }
                        }
                        
                        if (empty($errors)) {
                            $_SESSION['flash_message'] = 'Profile updated successfully!';
                            $_SESSION['flash_type'] = 'success';
                            $this->redirect('player/' . $player['id']);
                        }
                    } else {
                        $_SESSION['flash_message'] = 'Failed to update profile. Please try again.';
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
        
        $this->render('players/edit_profile', [
            'player' => $player
        ]);
    }
    
    public function uploadPhoto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
            $file = $_FILES['photo'];
            $errors = [];
            
            // Validate file
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors['photo'] = 'Failed to upload file';
            } else {
                $allowedTypes = ['image/jpeg', 'image/png'];
                if (!in_array($file['type'], $allowedTypes)) {
                    $errors['photo'] = 'Only JPEG and PNG files are allowed';
                }
                
                if ($file['size'] > MAX_FILE_SIZE) {
                    $errors['photo'] = 'File size exceeds limit';
                }
            }
            
            if (empty($errors)) {
                // Generate unique filename
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $filepath = UPLOAD_DIR . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    // Update user's photo URL
                    $this->db->query("
                        UPDATE users 
                        SET photo_url = :photo_url
                        WHERE id = :user_id
                    ");
                    $this->db->bind(':photo_url', $filename);
                    $this->db->bind(':user_id', $_SESSION['user_id']);
                    
                    if ($this->db->execute()) {
                        $_SESSION['flash_message'] = 'Photo uploaded successfully!';
                        $_SESSION['flash_type'] = 'success';
                    } else {
                        $_SESSION['flash_message'] = 'Failed to update photo. Please try again.';
                        $_SESSION['flash_type'] = 'danger';
                    }
                } else {
                    $_SESSION['flash_message'] = 'Failed to upload photo. Please try again.';
                    $_SESSION['flash_type'] = 'danger';
                }
            } else {
                $_SESSION['flash_message'] = 'Please correct the errors below.';
                $_SESSION['flash_type'] = 'danger';
                $_SESSION['form_errors'] = $errors;
            }
        }
        
        $this->redirect('player/edit-profile');
    }
} 