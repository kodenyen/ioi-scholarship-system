<?php

class AdminModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function findAdminByEmail($email) {
        $this->db->query('SELECT * FROM admins WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function login($email, $password) {
        $row = $this->findAdminByEmail($email);
        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }
}
