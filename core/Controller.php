<?php
class Controller {
    protected $db;
    protected $view;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    protected function render($view, $data = []) {
        extract($data);
        $viewFile = APP_ROOT . '/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
            
            // Load layout
            require_once APP_ROOT . '/views/layouts/main.php';
        } else {
            throw new Exception("View $view not found");
        }
    }

    protected function redirect($url) {
        header("Location: " . APP_URL . "/" . $url);
        exit;
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('login');
        }
    }

    protected function requireAdmin() {
        if (!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
    }

    protected function getPostData() {
        return $_POST;
    }

    protected function getQueryData() {
        return $_GET;
    }

    protected function validateInput($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            if (strpos($rule, 'required') !== false && empty($data[$field])) {
                $errors[$field] = "This field is required";
            }
            
            if (isset($data[$field])) {
                if (strpos($rule, 'email') !== false && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "Invalid email format";
                }
                
                if (strpos($rule, 'min:') !== false) {
                    preg_match('/min:(\d+)/', $rule, $matches);
                    $min = $matches[1];
                    if (strlen($data[$field]) < $min) {
                        $errors[$field] = "Must be at least $min characters";
                    }
                }
            }
        }
        
        return $errors;
    }
} 