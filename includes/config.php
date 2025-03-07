<?php
// Environment configuration
define('ENVIRONMENT', 'development');

// Error reporting
if (ENVIRONMENT === 'development') {
    error_reporting(-1);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
    ini_set('display_errors', 0);
}

// Security headers
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
