<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'u104465392_ioi_scholars');
define('DB_USER', 'u104465392_messagdb');
define('DB_PASS', 'IOImessage@20253#');

define('SITE_NAME', 'IOI Scholarship');
define('URLROOT', 'https://message.ioiglobal.org'); 
define('APPROOT', dirname(dirname(__FILE__)));

/**
 * Smart PUBROOT detection
 * If the project contents are uploaded directly into public_html, APPROOT is the web root.
 * If the project root is above public_html, it's a subdirectory.
 */
if (basename(APPROOT) === 'public_html') {
    define('PUBROOT', APPROOT);
} else {
    define('PUBROOT', APPROOT . '/public_html');
}

// SMTP Config (for Hostinger)
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_USER', 'your-email@domain.com');
define('SMTP_PASS', 'your-password');
define('SMTP_PORT', 465);
define('SMTP_FROM', 'your-email@domain.com');
define('SMTP_FROM_NAME', 'IOI Scholarship Admin');
