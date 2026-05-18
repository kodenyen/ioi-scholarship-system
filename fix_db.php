<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

echo "<h2>Database Migration: Adding 'assigned_at' column...</h2>";

try {
    $db = new Database();
    $db->query("ALTER TABLE sponsor_student ADD COLUMN assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    if ($db->execute()) {
        echo "<p style='color: green;'>Success! The 'assigned_at' column has been added to the 'sponsor_student' table.</p>";
    } else {
        echo "<p style='color: orange;'>Column might already exist or another issue occurred.</p>";
    }
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "<p style='color: blue;'>The column already exists.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}

echo "<br><a href='" . URLROOT . "/admin/students'>Back to Students List</a>";
unlink(__FILE__); // Delete this script after running
?>
