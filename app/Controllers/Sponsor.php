<?php

class Sponsor extends Controller {
    public function __construct() {
        $this->sponsorModel = $this->model('SponsorModel');
        $this->studentModel = $this->model('StudentModel');
        $this->messageModel = $this->model('MessageModel');
        $this->formModel = $this->model('FormModel');
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        if (isset($_GET['token'])) {
            $sponsor = $this->getSponsorByToken($_GET['token']);
            if ($sponsor) {
                $_SESSION['sponsor_id'] = $sponsor->id;
                $_SESSION['sponsor_name'] = $sponsor->name;
            }
        }

        if (!isset($_SESSION['sponsor_id'])) {
            redirect('sponsor/login');
        }

        $sponsor = $this->sponsorModel->getSponsorById($_SESSION['sponsor_id']);

        // Get assigned students
        $this->db = new Database();
        $this->db->query('SELECT st.* FROM students st JOIN sponsor_student ss ON st.id = ss.student_id WHERE ss.sponsor_id = :id');
        $this->db->bind(':id', $sponsor->id);
        $students = $this->db->resultSet();

        $messages = $this->messageModel->getMessagesForUser('sponsor', $sponsor->id);

        $data = [
            'sponsor' => $sponsor,
            'students' => $students,
            'messages' => $messages
        ];
        $this->view('sponsor/dashboard', $data);
    }

    public function student_profile($id) {
        if (!isset($_GET['token'])) redirect('sponsor/login');
        $token = $_GET['token'];
        $sponsor = $this->getSponsorByToken($token);
        if (!$sponsor) redirect('sponsor/login');

        $student = $this->studentModel->getStudentById($id);
        if (!$student) redirect('sponsor/dashboard?token=' . $token);

        // Check if student is assigned to this sponsor
        $this->db = new Database();
        $this->db->query('SELECT * FROM sponsor_student WHERE sponsor_id = :sponsor_id AND student_id = :student_id');
        $this->db->bind(':sponsor_id', $sponsor->id);
        $this->db->bind(':student_id', $id);
        if (!$this->db->single()) {
            redirect('sponsor/dashboard?token=' . $token);
        }

        // Get student uploads/results
        $this->db->query('SELECT * FROM student_uploads WHERE student_id = :id');
        $this->db->bind(':id', $id);
        $uploads = $this->db->resultSet();

        // Get gallery
        $gallery = $this->studentModel->getGallery($id);

        $data = [
            'sponsor' => $sponsor,
            'student' => $student,
            'uploads' => $uploads,
            'gallery' => $gallery
        ];
        $this->view('sponsor/student_profile', $data);
    }

    public function login() {
        if (isset($_SESSION['sponsor_id'])) {
            redirect('sponsor/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            $loggedInSponsor = $this->sponsorModel->login($data['email'], $data['password']);

            if ($loggedInSponsor) {
                $_SESSION['sponsor_id'] = $loggedInSponsor->id;
                $_SESSION['sponsor_name'] = $loggedInSponsor->name;
                redirect('sponsor/dashboard');
            } else {
                $data['password_err'] = 'Invalid email or password';
                $this->view('sponsor/login', $data);
            }
        } else {
            $data = ['email' => '', 'email_err' => '', 'password_err' => ''];
            $this->view('sponsor/login', $data);
        }
    }

    public function logout() {
        unset($_SESSION['sponsor_id']);
        unset($_SESSION['sponsor_name']);
        session_destroy();
        redirect('sponsor/login');
    }

    public function send_message($student_id) {
        if (!isset($_GET['token'])) die('Access Denied');
        $token = $_GET['token'];
        $sponsor = $this->getSponsorByToken($token);
        if (!$sponsor) die('Access Denied');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $messageData = [
                'sender_type' => 'sponsor',
                'sender_id' => $sponsor->id,
                'receiver_id' => $student_id,
                'content' => trim($_POST['content'])
            ];

            $message_id = $this->messageModel->addMessage($messageData);
            if ($message_id) {
                // Save dynamic form fields
                $fields = $this->formModel->getFields('sponsor');
                foreach($fields as $field) {
                    if (isset($_POST['field_' . $field->id])) {
                        $this->messageModel->saveFormResponse($message_id, $field->id, $_POST['field_' . $field->id]);
                    }
                }
                flash('sponsor_message', 'Message Sent Successfully');
                redirect('sponsor/dashboard?token=' . $token);
            }
        } else {
            $student = $this->studentModel->getStudentById($student_id);
            $fields = $this->formModel->getFields('sponsor');
            $data = [
                'sponsor' => $sponsor,
                'student' => $student,
                'fields' => $fields
            ];
            $this->view('sponsor/send_message', $data);
        }
    }

    private function getSponsorByToken($token) {
        $this->db = new Database();
        $this->db->query('SELECT * FROM sponsors WHERE access_token = :token');
        $this->db->bind(':token', $token);
        return $this->db->single();
    }
}
