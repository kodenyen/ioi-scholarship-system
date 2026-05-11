<?php

class Student extends Controller {
    public function __construct() {
        $this->studentModel = $this->model('StudentModel');
        $this->messageModel = $this->model('MessageModel');
        $this->formModel = $this->model('FormModel');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $email = trim($_POST['email']);
            $this->db = new Database();
            $this->db->query('SELECT * FROM students WHERE email = :email');
            $this->db->bind(':email', $email);
            $student = $this->db->single();

            if ($student) {
                $_SESSION['student_id'] = $student->id;
                $_SESSION['student_name'] = $student->first_name;
                redirect('student/dashboard');
            } else {
                $data = ['email_err' => 'Email not found'];
                $this->view('student/login', $data);
            }
        } else {
            $data = ['email_err' => ''];
            $this->view('student/login', $data);
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['student_id'])) redirect('student/login');
        
        $student = $this->studentModel->getStudentById($_SESSION['student_id']);
        $messages = $this->messageModel->getMessagesForUser('student', $student->id);

        $data = [
            'student' => $student,
            'messages' => $messages
        ];
        $this->view('student/dashboard', $data);
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
