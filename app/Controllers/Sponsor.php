<?php

class Sponsor extends Controller {
    public function __construct() {
        $this->sponsorModel = $this->model('SponsorModel');
        $this->studentModel = $this->model('StudentModel');
        $this->messageModel = $this->model('MessageModel');
        $this->formModel = $this->model('FormModel');
    }

    public function dashboard() {
        if (!isset($_GET['token'])) {
            die('Access Denied: Token required');
        }

        $token = $_GET['token'];
        $sponsor = $this->getSponsorByToken($token);
        if (!$sponsor) {
            die('Access Denied: Invalid Token');
        }

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
