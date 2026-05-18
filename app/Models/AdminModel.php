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

    public function updateSetting($key, $value) {
        $this->db->query('INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE setting_value = :value2');
        $this->db->bind(':key', $key);
        $this->db->bind(':value', $value);
        $this->db->bind(':value2', $value);
        return $this->db->execute();
    }
}
