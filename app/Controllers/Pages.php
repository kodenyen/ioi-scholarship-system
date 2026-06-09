<?php

class Pages extends Controller {
    private $studentModel;
    private $adminModel;
    private $db;

    public function __construct() {
        $this->studentModel = $this->model('StudentModel');
        $this->adminModel = $this->model('AdminModel');
        $this->db = new Database();
    }

    public function index() {
        $data = [
            'title' => 'Welcome to IOI Scholarship'
        ];
        $this->view('pages/index', $data);
    }

    public function scholarships() {
        // Pagination
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalUnassigned = $this->studentModel->getUnassignedStudentCount();
        $totalPages = ceil($totalUnassigned / $limit);

        $students = $this->studentModel->getUnassignedStudents($limit, $offset);

        $data = [
            'students' => $students,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalUnassigned
        ];
        $this->view('pages/scholarships', $data);
    }

    public function requests() {
        // Pagination
        $limit = 12;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalUnassigned = $this->studentModel->getUnassignedStudentCount();
        $totalPages = ceil($totalUnassigned / $limit);

        $students = $this->studentModel->getUnassignedStudents($limit, $offset);

        $data = [
            'students' => $students,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalUnassigned
        ];
        $this->view('admin/students/scholarship_requests', $data);
    }

    public function portfolio($id) {
        $student = $this->studentModel->getStudentById($id);
        if (!$student) redirect('pages/scholarships');

        // Get student uploads/results
        $this->db->query('SELECT * FROM student_uploads WHERE student_id = :id');
        $this->db->bind(':id', $id);
        $uploads = $this->db->resultSet();

        // Get gallery
        $gallery = $this->studentModel->getGallery($id);

        $data = [
            'student' => $student,
            'uploads' => $uploads,
            'gallery' => $gallery
        ];
        $this->view('pages/portfolio', $data);
    }

    public function interested_sponsorship() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'student_id' => $_POST['student_id'],
                'sponsor_name' => trim($_POST['sponsor_name']),
                'sponsor_email' => trim($_POST['sponsor_email']),
                'message' => trim($_POST['message']),
            ];

            $this->db->query('INSERT INTO interested_sponsorships (student_id, sponsor_name, sponsor_email, message) VALUES (:student_id, :sponsor_name, :sponsor_email, :message)');
            $this->db->bind(':student_id', $data['student_id']);
            $this->db->bind(':sponsor_name', $data['sponsor_name']);
            $this->db->bind(':sponsor_email', $data['sponsor_email']);
            $this->db->bind(':message', $data['message']);

            if ($this->db->execute()) {
                // Notify All Admins
                $student = $this->studentModel->getStudentById($data['student_id']);
                $admins = $this->adminModel->getAdmins();
                
                $subject = "New Interested Sponsor for " . $student->first_name . " " . $student->surname;
                $body = "
                    <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
                        <h2 style='color: #2b9348;'>New Scholarship Interest</h2>
                        <p>A potential sponsor has expressed interest in <strong>{$student->first_name} {$student->surname}</strong>.</p>
                        <hr>
                        <p><strong>Sponsor Details:</strong></p>
                        <ul>
                            <li><strong>Name:</strong> {$data['sponsor_name']}</li>
                            <li><strong>Email:</strong> {$data['sponsor_email']}</li>
                        </ul>
                        <p><strong>Message:</strong></p>
                        <div style='background: #f9f9f9; padding: 15px; border-left: 4px solid #2b9348;'>
                            " . nl2br($data['message']) . "
                        </div>
                        <p style='margin-top: 20px;'>
                            <a href=\"" . URLROOT . "/admin/dashboard\" style='background: #2b9348; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View in Admin Dashboard</a>
                        </p>
                    </div>
                ";

                // Gather all valid recipients
                $recipients = [];

                // 1. Add all system admins
                if(!empty($admins)) {
                    foreach($admins as $admin) {
                        // Skip the default dummy email from the README
                        if($admin->email !== 'admin@ioi.com' && filter_var($admin->email, FILTER_VALIDATE_EMAIL)) {
                            $recipients[] = $admin->email;
                        }
                    }
                }

                // 2. Add the public contact email from settings
                $contactEmail = getSetting('contact_email');
                if($contactEmail && filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
                    $recipients[] = $contactEmail;
                }

                // 3. Ultimate Fallback: The authenticated SMTP User account
                if(defined('SMTP_USER') && filter_var(SMTP_USER, FILTER_VALIDATE_EMAIL)) {
                    $recipients[] = SMTP_USER;
                }

                // Remove duplicates to prevent spamming the same address
                $recipients = array_unique($recipients);

                // Send the email to all unique recipients
                foreach($recipients as $email) {
                    sendEmail($email, $subject, $body);
                }

                flash('scholarship_message', 'Thank you for your interest! The admin will contact you shortly.');
                redirect('pages/scholarships');
            } else {
                die('Something went wrong');
            }
        }
    }
}
