<?php

class StudentModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getStudents() {
        $this->db->query('SELECT * FROM students ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function addStudent($data) {
        $this->db->query('INSERT INTO students (first_name, surname, age, class, email, about) VALUES (:first_name, :surname, :age, :class, :email, :about)');
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':class', $data['class']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':about', $data['about']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function getStudentById($id) {
        $this->db->query('SELECT * FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateStudent($data) {
        $this->db->query('UPDATE students SET first_name = :first_name, surname = :surname, age = :age, class = :class, email = :email, about = :about WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':class', $data['class']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':about', $data['about']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteStudent($id) {
        $this->db->query('DELETE FROM students WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
