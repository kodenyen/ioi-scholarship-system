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

// Send Email Utility
function sendEmail($to, $subject, $body) {
    $fromName = getSetting('smtp_from_name') ?: SITE_NAME;
    $fromEmail = getSetting('smtp_user') ?: 'no-reply@' . $_SERVER['HTTP_HOST'];
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: '.$fromName.' <'.$fromEmail.'>' . "\r\n";
    
    try {
        return mail($to, $subject, $body, $headers);
    } catch (Exception $e) {
        return false;
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
