<?php
/**
 * Router script for the PHP built-in server.
 * This script allows us to use pretty URLs without .htaccess.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// If the file exists in public/ or root, serve it directly
if ($uri !== '/' && (file_exists(__DIR__ . '/public' . $uri) || file_exists(__DIR__ . $uri))) {
    return false;
}

// Otherwise, route everything to the main index.php
require_once __DIR__ . '/index.php';
