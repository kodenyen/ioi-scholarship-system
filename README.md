# IOI Scholarship Sponsor–Student Communication System

A secure and moderated communication platform built with PHP (MVC), MySQL, and Bootstrap 5.

## Features
- **Admin Dashboard**: Manage sponsors, students, and moderate messages.
- **Sponsor Access**: Secure tokenized access links.
- **Moderated Communication**: All messages (sponsor to student and vice versa) require admin approval.
- **Dynamic Form Builder**: Admins can create custom communication forms.
- **Mobile-First Design**: Optimized for touch devices and small screens.
- **Student Profiles**: Rich profiles with results (PDF) and about section.

## Installation
1. Upload all files to your Hostinger `public_html` (or a subdirectory).
2. Create a MySQL database and import `database/schema.sql`.
3. Update `config/config.php` with your database credentials and `URLROOT`.
4. The default admin login is:
   - Email: `admin@ioi.com`
   - Password: `password123`

## Technology Stack
- **Backend**: Core PHP (MVC)
- **Frontend**: Bootstrap 5, Vanilla JS
- **Database**: MySQL
- **Hosting**: Compatible with Hostinger shared hosting
