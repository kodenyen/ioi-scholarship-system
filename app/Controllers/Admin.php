<?php

class Admin extends Controller {
    public function __construct() {
        $this->adminModel = $this->model('AdminModel');
        $this->sponsorModel = $this->model('SponsorModel');
        $this->studentModel = $this->model('StudentModel');
    }

    public function sponsors() {
        if (!isLoggedIn()) redirect('admin/login');

        $sponsors = $this->sponsorModel->getSponsors();
        $data = ['sponsors' => $sponsors];
        $this->view('admin/sponsors/index', $data);
    }

    public function add_sponsor() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'access_token' => bin2hex(random_bytes(16)),
                'name_err' => '',
                'email_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Please enter name';
            if (empty($data['email'])) $data['email_err'] = 'Please enter email';

            if (empty($data['name_err']) && empty($data['email_err'])) {
                if ($this->sponsorModel->addSponsor($data)) {
                    flash('sponsor_message', 'Sponsor Added');
                    redirect('admin/sponsors');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('admin/sponsors/add', $data);
            }
        } else {
            $data = ['name' => '', 'email' => '', 'name_err' => '', 'email_err' => ''];
            $this->view('admin/sponsors/add', $data);
        }
    }

    public function students() {
        if (!isLoggedIn()) redirect('admin/login');

        $students = $this->studentModel->getStudents();
        $data = ['students' => $students];
        $this->view('admin/students/index', $data);
    }

    public function add_student() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'first_name' => trim($_POST['first_name']),
                'surname' => trim($_POST['surname']),
                'age' => trim($_POST['age']),
                'class' => trim($_POST['class']),
                'email' => trim($_POST['email']),
                'about' => trim($_POST['about']),
                'first_name_err' => '',
                'surname_err' => ''
            ];

            if (empty($data['first_name'])) $data['first_name_err'] = 'Please enter first name';
            if (empty($data['surname'])) $data['surname_err'] = 'Please enter surname';

            if (empty($data['first_name_err']) && empty($data['surname_err'])) {
                if ($this->studentModel->addStudent($data)) {
                    flash('student_message', 'Student Added');
                    redirect('admin/students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('admin/students/add', $data);
            }
        } else {
            $data = [
                'first_name' => '', 'surname' => '', 'age' => '', 'class' => '', 
                'email' => '', 'about' => '', 'first_name_err' => '', 'surname_err' => ''
            ];
            $this->view('admin/students/add', $data);
        }
    }

    public function dashboard() {
        if (isLoggedIn()) {
            redirect('admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            if (empty($data['email'])) $data['email_err'] = 'Please enter email';
            if (empty($data['password'])) $data['password_err'] = 'Please enter password';

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInAdmin = $this->adminModel->login($data['email'], $data['password']);
                if ($loggedInAdmin) {
                    $this->createAdminSession($loggedInAdmin);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('admin/login', $data);
                }
            } else {
                $this->view('admin/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('admin/login', $data);
        }
    }

    public function createAdminSession($admin) {
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['admin_email'] = $admin->email;
        $_SESSION['admin_name'] = $admin->name;
        redirect('admin/dashboard');
    }

    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_name']);
        session_destroy();
        redirect('admin/login');
    }

    public function dashboard() {
        if (!isLoggedIn()) {
            redirect('admin/login');
        }
        $data = [
            'title' => 'Admin Dashboard'
        ];
        $this->view('admin/dashboard', $data);
    }
}
