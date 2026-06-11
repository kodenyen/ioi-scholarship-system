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
    // Strictly use the verified constants to avoid any database typos
    $host = defined('SMTP_HOST') ? SMTP_HOST : 'smtp.hostinger.com';
    $port = defined('SMTP_PORT') ? SMTP_PORT : 465;
    $user = defined('SMTP_USER') ? SMTP_USER : 'scholarship@message.ioiglobal.org';
    $pass = defined('SMTP_PASS') ? SMTP_PASS : 'IOIglobal@20243#';
    
    // Hostinger strictly requires the FROM address to match the authenticated USER
    $fromEmail = $user;
    $fromName = getSetting('smtp_from_name') ?: (defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : SITE_NAME);

    $logError = function($msg) {
        // Log to the root folder (outside app/) so it's easy to find
        file_put_contents(dirname(APPROOT) . '/smtp_error.log', date('Y-m-d H:i:s') . " - " . $msg . "\n", FILE_APPEND);
    };

    // Fallback mail function
    $sendViaMail = function() use ($to, $subject, $body, $fromName, $fromEmail, $logError) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: '.$fromName.' <'.$fromEmail.'>' . "\r\n";
        $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ">\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        
        // The -f flag is critical for Hostinger to not silently drop the email
        $success = mail($to, $subject, $body, $headers, "-f$fromEmail");
        if(!$success) $logError("Fallback mail() function failed to send to $to");
        return $success;
    };

    if (empty($host) || empty($user) || empty($pass)) {
        $logError("SMTP Credentials missing, using fallback.");
        return $sendViaMail();
    }

    $timeout = 15;
    $localhost = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $newLine = "\r\n";

    try {
        // Connect to server
        $socket = @fsockopen(($port == 465 ? 'ssl://' : '') . $host, $port, $errno, $errstr, $timeout);
        if (!$socket) {
            $logError("Socket connection failed: $errstr ($errno)");
            return $sendViaMail();
        }

        $getResponse = function($socket) {
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
            $logError("SMTP Auth failed: " . trim($authResponse));
            return $sendViaMail();
        }

        fwrite($socket, "MAIL FROM: <$fromEmail>" . $newLine);
        $getResponse($socket);
        
        fwrite($socket, "RCPT TO: <$to>" . $newLine);
        $rcptResponse = $getResponse($socket);
        if(strpos($rcptResponse, '250') === false) {
            fclose($socket);
            $logError("SMTP RCPT failed for $to: " . trim($rcptResponse));
            return $sendViaMail();
        }

        fwrite($socket, "DATA" . $newLine);
        $getResponse($socket);

        $headerStr = "To: $to" . $newLine;
        $headerStr .= "From: $fromName <$fromEmail>" . $newLine;
        $headerStr .= "Subject: $subject" . $newLine;
        $headerStr .= "MIME-Version: 1.0" . $newLine;
        $headerStr .= "Content-Type: text/html; charset=UTF-8" . $newLine;
        $headerStr .= "Date: " . date('r') . $newLine;

        fwrite($socket, $headerStr . $newLine . $body . $newLine . "." . $newLine);
        $dataResponse = $getResponse($socket);

        fwrite($socket, "QUIT" . $newLine);
        fclose($socket);
        
        if(strpos($dataResponse, '250') === false) {
            $logError("SMTP Data phase failed: " . trim($dataResponse));
            return $sendViaMail();
        }
        
        return true;
    } catch (Exception $e) {
        $logError("SMTP Exception: " . $e->getMessage());
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
 * Handles spaces in filenames and ensures correct URL structure
 */
function asset($path) {
    if (empty($path)) return '';
    // If it's already a full URL, return it
    if (strpos($path, 'http') === 0) return $path;
    
    // Clean URLROOT and path
    $root = rtrim(URLROOT, '/');
    $path = ltrim($path, '/');
    
    // Encode parts to handle spaces and special characters while preserving slashes
    $parts = explode('/', $path);
    $encodedParts = array_map('rawurlencode', $parts);
    $encodedPath = implode('/', $encodedParts);
    
    return $root . '/' . $encodedPath;
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
