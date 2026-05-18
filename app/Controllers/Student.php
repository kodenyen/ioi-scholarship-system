<?php

class Student extends Controller {
    public function __construct() {
        $this->studentModel = $this->model('StudentModel');
        $this->messageModel = $this->model('MessageModel');
        $this->formModel = $this->model('FormModel');
    }

    public function index() {
        $this->dashboard();
    }

    public function login() {
        if (isset($_SESSION['student_id'])) {
            redirect('student/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            $loggedInStudent = $this->studentModel->login($data['email'], $data['password']);

            if ($loggedInStudent) {
                $_SESSION['student_id'] = $loggedInStudent->id;
                $_SESSION['student_name'] = $loggedInStudent->first_name;
                redirect('student/dashboard');
            } else {
                $data['password_err'] = 'Invalid email or password';
                $this->view('student/login', $data);
            }
        } else {
            $data = ['email' => '', 'email_err' => '', 'password_err' => ''];
            $this->view('student/login', $data);
        }
    }

    public function logout() {
        unset($_SESSION['student_id']);
        unset($_SESSION['student_name']);
        session_destroy();
        redirect('student/login');
    }

    public function dashboard() {
        if (isset($_GET['token'])) {
            $student = $this->studentModel->getStudentByToken($_GET['token']);
            if ($student) {
                $_SESSION['student_id'] = $student->id;
                $_SESSION['student_name'] = $student->first_name;
            } else {
                die('Access Denied: Invalid Token');
            }
        }

        if (!isset($_SESSION['student_id'])) redirect('student/login');
        
        $student = $this->studentModel->getStudentById($_SESSION['student_id']);
        $messages = $this->messageModel->getMessagesForUser('student', $student->id);

        // Get assigned sponsors
        $this->db = new Database();
        $this->db->query('SELECT s.* FROM sponsors s JOIN sponsor_student ss ON s.id = ss.sponsor_id WHERE ss.student_id = :id');
        $this->db->bind(':id', $student->id);
        $sponsors = $this->db->resultSet();

        $data = [
            'student' => $student,
            'messages' => $messages,
            'sponsors' => $sponsors
        ];
        $this->view('student/dashboard', $data);
    }

    public function send_message($sponsor_id) {
        if (!isset($_SESSION['student_id'])) redirect('student/login');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $messageData = [
                'sender_type' => 'student',
                'sender_id' => $_SESSION['student_id'],
                'receiver_id' => $sponsor_id,
                'content' => trim($_POST['content'])
            ];

            $message_id = $this->messageModel->addMessage($messageData);
            if ($message_id) {
                $fields = $this->formModel->getFields('student');
                foreach($fields as $field) {
                    if (isset($_POST['field_' . $field->id])) {
                        $this->messageModel->saveFormResponse($message_id, $field->id, $_POST['field_' . $field->id]);
                    }
                }
                flash('student_message', 'Message Sent Successfully. Waiting for Admin approval.');
                redirect('student/dashboard');
            }
        } else {
            $this->db = new Database();
            $this->db->query('SELECT * FROM sponsors WHERE id = :id');
            $this->db->bind(':id', $sponsor_id);
            $sponsor = $this->db->single();
            $fields = $this->formModel->getFields('student');
            
            $data = [
                'sponsor' => $sponsor,
                'fields' => $fields
            ];
            $this->view('student/send_message', $data);
        }
    }

    public function reply($sponsor_id) {
        if (!isset($_SESSION['student_id'])) redirect('student/login');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $messageData = [
                'sender_type' => 'student',
                'sender_id' => $_SESSION['student_id'],
                'receiver_id' => $sponsor_id,
                'content' => trim($_POST['content'])
            ];

            $message_id = $this->messageModel->addMessage($messageData);
            if ($message_id) {
                $fields = $this->formModel->getFields('student');
                foreach($fields as $field) {
                    if (isset($_POST['field_' . $field->id])) {
                        $this->messageModel->saveFormResponse($message_id, $field->id, $_POST['field_' . $field->id]);
                    }
                }
                flash('student_message', 'Reply Sent Successfully');
                redirect('student/dashboard');
            }
        } else {
            $this->db = new Database();
            $this->db->query('SELECT * FROM sponsors WHERE id = :id');
            $this->db->bind(':id', $sponsor_id);
            $sponsor = $this->db->single();
            $fields = $this->formModel->getFields('student');
            
            $data = [
                'sponsor' => $sponsor,
                'fields' => $fields
            ];
            $this->view('student/reply', $data);
        }
    }
}
