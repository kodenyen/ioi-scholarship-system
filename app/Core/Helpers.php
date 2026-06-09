<?php
session_start();

// Flash message helper
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function redirect($page) {
    header('location: ' . URLROOT . '/' . $page);
}

// Get system setting
function getSetting($key) {
    $db = new Database();
    $db->query('SELECT setting_value FROM settings WHERE setting_key = :key');
    $db->bind(':key', $key);
    $row = $db->single();
    return $row ? $row->setting_value : null;
}

// Send Email Utility using SMTP
function sendEmail($to, $subject, $body) {
    // Get config from database settings first, then fallback to constants
    $host = getSetting('smtp_host') ?: (defined('SMTP_HOST') && SMTP_HOST !== 'smtp.hostinger.com' ? SMTP_HOST : 'smtp.hostinger.com');
    $port = getSetting('smtp_port') ?: (defined('SMTP_PORT') ? SMTP_PORT : 465);
    $user = getSetting('smtp_user') ?: (defined('SMTP_USER') && SMTP_USER !== 'your-email@domain.com' ? SMTP_USER : '');
    $pass = getSetting('smtp_pass') ?: (defined('SMTP_PASS') && SMTP_PASS !== 'your-password' ? SMTP_PASS : '');
    $fromName = getSetting('smtp_from_name') ?: (defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : SITE_NAME);
    
    // Hostinger strictly requires the FROM address to match the authenticated USER
    $fromEmail = $user;

    // Fallback mail function
    $sendViaMail = function() use ($to, $subject, $body, $fromName, $fromEmail) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: '.$fromName.' <'.$fromEmail.'>' . "\r\n";
        return mail($to, $subject, $body, $headers);
    };

    // Check if we have minimum requirements for SMTP
    if (empty($host) || empty($user) || empty($pass)) {
        return $sendViaMail();
    }

    $timeout = 30;
    $localhost = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $newLine = "\r\n";

    try {
        // Connect to server
        $socket = @fsockopen(($port == 465 ? 'ssl://' : '') . $host, $port, $errno, $errstr, $timeout);
        if (!$socket) return $sendViaMail();

        $getResponse = function($socket) use ($newLine) {
            $response = "";
            while ($line = fgets($socket, 515)) {
                $response .= $line;
                if (substr($line, 3, 1) == " ") break;
            }
            return $response;
        };

        $getResponse($socket); // Connection greeting

        fwrite($socket, "EHLO $localhost" . $newLine);
        $getResponse($socket);

        if ($port != 465) {
            fwrite($socket, "STARTTLS" . $newLine);
            $getResponse($socket);
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            fwrite($socket, "EHLO $localhost" . $newLine);
            $getResponse($socket);
        }

        fwrite($socket, "AUTH LOGIN" . $newLine);
        $getResponse($socket);
        fwrite($socket, base64_encode($user) . $newLine);
        $getResponse($socket);
        fwrite($socket, base64_encode($pass) . $newLine);
        $authResponse = $getResponse($socket);
        
        // If authentication fails, fallback to mail
        if(strpos($authResponse, '235') === false) {
            fclose($socket);
            return $sendViaMail();
        }

        fwrite($socket, "MAIL FROM: <$fromEmail>" . $newLine);
        $getResponse($socket);
        fwrite($socket, "RCPT TO: <$to>" . $newLine);
        $getResponse($socket);
        fwrite($socket, "DATA" . $newLine);
        $getResponse($socket);

        $headerStr = "To: $to" . $newLine;
        $headerStr .= "From: $fromName <$fromEmail>" . $newLine;
        $headerStr .= "Subject: $subject" . $newLine;
        $headerStr .= "MIME-Version: 1.0" . $newLine;
        $headerStr .= "Content-Type: text/html; charset=UTF-8" . $newLine;
        $headerStr .= "Date: " . date('r') . $newLine;

        fwrite($socket, $headerStr . $newLine . $body . $newLine . "." . $newLine);
        $getResponse($socket);

        fwrite($socket, "QUIT" . $newLine);
        fclose($socket);
        return true;
    } catch (Exception $e) {
        return $sendViaMail();
    }
}

// Get hierarchical menu
function getMenuItems($parentId = null) {
    $db = new Database();
    $db->query('SELECT * FROM menu_items WHERE parent_id ' . ($parentId ? '= :pid' : 'IS NULL') . ' ORDER BY sort_order ASC');
    if($parentId) $db->bind(':pid', $parentId);
    $items = $db->resultSet();
    
    foreach($items as $item) {
        $item->children = getMenuItems($item->id);
    }
    
    return $items;
}

/**
 * Robust URL helper for assets and uploads
 */
function asset($path) {
    if (empty($path)) return '';
    // If it's already a full URL, return it
    if (strpos($path, 'http') === 0) return $path;
    
    // Simply prepend URLROOT to ensure paths aren't broken by aggressive encoding
    $path = ltrim($path, '/');
    return URLROOT . '/' . $path;
}

/**
 * Robust File Path helper for server-side checks
 * Detects if public folder is needed or if we are already in it
 */
function storage($path = '') {
    // Check if PUBROOT exists and contains the file
    $fullPath = PUBROOT . '/' . ltrim($path, '/');
    if (file_exists($fullPath)) return $fullPath;
    
    // Fallback: maybe the public folder is the root (common on some hostings)
    $fallbackPath = APPROOT . '/' . ltrim($path, '/');
    if (file_exists($fallbackPath)) return $fallbackPath;
    
    return $fullPath; // Return the standard path if both fail
}
