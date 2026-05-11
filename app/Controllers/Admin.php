<?php

class Admin extends Controller {
    public function __construct() {
        $this->adminModel = $this->model('AdminModel');
    }

    public function login() {
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
