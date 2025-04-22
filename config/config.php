<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fc_football_stats');

// Application configuration
define('APP_NAME', 'FCFootballStats');
define('APP_URL', 'http://localhost/FCFootballStats');
define('APP_ROOT', dirname(dirname(__FILE__)));

// Session configuration
define('SESSION_NAME', 'fcstats_session');
define('SESSION_LIFETIME', 3600); // 1 hour

// File upload configuration
define('UPLOAD_DIR', APP_ROOT . '/public/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png']);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Time zone
date_default_timezone_set('UTC');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
} 