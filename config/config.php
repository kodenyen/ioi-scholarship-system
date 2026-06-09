<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'u104465392_ioi_scholars');
define('DB_USER', 'u104465392_messagdb');
define('DB_PASS', 'IOImessage@20253#');

define('SITE_NAME', 'IOI Scholarship');
define('URLROOT', 'https://message.ioiglobal.org'); 
define('APPROOT', dirname(dirname(__FILE__)));

// Use the physical 'public' folder for uploads, regardless of server folder names
define('PUBROOT', APPROOT . '/public');

// SMTP Config (for Hostinger)
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_USER', 'scholarship@message.ioiglobal.org');
define('SMTP_PASS', 'IOIglobal@20243#');
define('SMTP_PORT', 465);
define('SMTP_FROM', 'scholarship@message.ioiglobal.org');
define('SMTP_FROM_NAME', 'IOI Scholarship Admin');
