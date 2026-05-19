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

    public function getAdmins() {
        $this->db->query('SELECT * FROM admins ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getAdminById($id) {
        $this->db->query('SELECT * FROM admins WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addAdmin($data) {
        $this->db->query('INSERT INTO admins (name, email, password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();
    }

    public function updateAdmin($data) {
        if (!empty($data['password'])) {
            $this->db->query('UPDATE admins SET name = :name, email = :email, password = :password WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            $this->db->query('UPDATE admins SET name = :name, email = :email WHERE id = :id');
        }
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        return $this->db->execute();
    }

    public function deleteAdmin($id) {
        // Prevent deleting the last admin or the currently logged-in one if needed (logic in controller)
        $this->db->query('DELETE FROM admins WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function updateSetting($key, $value) {
        $this->db->query('INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE setting_value = :value2');
        $this->db->bind(':key', $key);
        $this->db->bind(':value', $value);
        $this->db->bind(':value2', $value);
        return $this->db->execute();
    }
}
