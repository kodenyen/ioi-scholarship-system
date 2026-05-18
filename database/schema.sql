-- IOI Scholarship Sponsor-Student Communication System Schema

CREATE DATABASE IF NOT EXISTS ioi_scholarship;
USE ioi_scholarship;

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sponsors Table
CREATE TABLE IF NOT EXISTS sponsors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255),
    access_token VARCHAR(255) NOT NULL UNIQUE,
    profile_photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Students Table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    age INT,
    class VARCHAR(100),
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255),
    access_token VARCHAR(255) NOT NULL UNIQUE,
    profile_photo VARCHAR(255),
    banner_image VARCHAR(255),
    about TEXT,
    educational_goals TEXT,
    memory_verse TEXT,
    prayer_needs TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Photo Gallery Table
CREATE TABLE IF NOT EXISTS student_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    photo_type ENUM('life', 'result') DEFAULT 'life',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Sponsor-Student Assignment Table (Many-to-Many)
CREATE TABLE IF NOT EXISTS sponsor_student (
    sponsor_id INT,
    student_id INT,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (sponsor_id, student_id),
    FOREIGN KEY (sponsor_id) REFERENCES sponsors(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Messages Table
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_type ENUM('sponsor', 'student') NOT NULL,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    moderation_note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Form Fields Table (Dynamic Form Builder)
CREATE TABLE IF NOT EXISTS form_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    type ENUM('text', 'textarea', 'dropdown', 'file') NOT NULL,
    assigned_to ENUM('sponsor', 'student') NOT NULL,
    options TEXT, -- JSON or comma-separated for dropdowns
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Form Responses Table
CREATE TABLE IF NOT EXISTS form_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_id INT NOT NULL,
    field_id INT NOT NULL,
    value TEXT,
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE,
    FOREIGN KEY (field_id) REFERENCES form_fields(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Student Uploads (PDF Results)
CREATE TABLE IF NOT EXISTS student_uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Settings Table
CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('site_logo', ''),
('top_bar_text', 'Mentoring Leaders to Mobilize Churches for Mercy Mission'),
('contact_phone', '+1 832 930 7166'),
('contact_email', 'contact@irelandoutreach.org'),
('donate_url', 'https://ioiglobal.org/donate/'),
('smtp_host', 'smtp.hostinger.com'),
('smtp_port', '465'),
('smtp_user', 'your-email@domain.com'),
('smtp_pass', ''),
('smtp_encryption', 'ssl'),
('smtp_from_name', 'IOI Scholarship Admin');

-- Menu Items Table
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT DEFAULT NULL,
    label VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL DEFAULT '#',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES menu_items(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Default Menu Structure
INSERT INTO menu_items (id, parent_id, label, url, sort_order) VALUES
(1, NULL, 'HOME', '/', 0),
(2, NULL, 'ABOUT US', '#', 1),
(3, 2, 'ABOUT IOI', '/about', 0),
(4, 2, 'MISSION EXPOSURE', '/mission', 1),
(5, 2, 'STATEMENT OF FAITH', '/faith', 2),
(6, 2, 'HEADQUARTERS', '/hq', 3),
(7, NULL, 'MINISTRIES', '#', 2),
(8, 7, 'UNITED STATE', '#', 0),
(9, 8, 'BES-BIBLETIMES', '/us/bible-times', 0),
(10, 8, 'PRINT MEDIA', '/us/print-media', 1),
(11, 7, 'IRELAND', '/ireland', 1),
(12, 7, 'NIGERIA', '#', 2),
(13, 12, 'THADDEUS SCHOLARSHIP', '/nigeria/scholarship', 0),
(14, 7, 'GHANA', '/ghana', 3),
(15, 7, 'LIBERIA', '/liberia', 4),
(16, NULL, 'IOI UPDATES', '#', 3),
(17, 16, 'MINISTRY UPDATE', '/updates', 0),
(18, 16, 'MISSION EXPOSURE', '/updates/mission', 1),
(19, 16, 'PROJECTS', '/projects', 2),
(20, 16, 'GALLARY', '/gallery', 3),
(21, NULL, 'CONTACT US', '/contact', 4);

-- Default Admin (Password: password123)
INSERT INTO admins (name, email, password) VALUES ('Admin', 'admin@ioi.com', '$2y$10$7R6v.M6W4z/KkX9yXG9uGe7pG1k3Y5xJ0/w9P5XQ2R.v2y1z6zYm.');
