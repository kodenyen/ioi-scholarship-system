<?php
require_once 'app/Core/Database.php';
require_once 'config/config.php';

$db = new Database();
try {
    $db->query("ALTER TABLE messages ADD COLUMN is_archived TINYINT(1) DEFAULT 0");
    if($db->execute()) {
        echo "Column 'is_archived' added successfully.";
    } else {
        echo "Failed to add column.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
