<?php

class StudentModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getStudents($search = '', $sort = 'newest', $limit = null, $offset = null) {
        $sql = 'SELECT s.*, (SELECT MAX(assigned_at) FROM sponsor_student WHERE student_id = s.id) as last_assigned 
                FROM students s';
        
        if (!empty($search)) {
            $sql .= ' WHERE s.first_name LIKE :search OR s.surname LIKE :search OR s.email LIKE :search OR s.class LIKE :search';
        }

        switch ($sort) {
            case 'class':
                $sql .= ' ORDER BY s.class ASC';
                break;
            case 'age_asc':
                $sql .= ' ORDER BY s.age ASC';
                break;
            case 'age_desc':
                $sql .= ' ORDER BY s.age DESC';
                break;
            case 'assigned':
                $sql .= ' ORDER BY last_assigned DESC';
                break;
            case 'oldest':
                $sql .= ' ORDER BY s.created_at ASC';
                break;
            default:
                $sql .= ' ORDER BY s.created_at DESC';
        }

        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }

        $this->db->query($sql);
        
        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        
        if ($limit !== null && $offset !== null) {
            $this->db->bind(':limit', $limit);
            $this->db->bind(':offset', $offset);
        }
        
        return $this->db->resultSet();
    }

    public function getStudentCount($search = '') {
        $sql = 'SELECT COUNT(*) as count FROM students';
        if (!empty($search)) {
            $sql .= ' WHERE first_name LIKE :search OR surname LIKE :search OR email LIKE :search OR class LIKE :search';
        }
        $this->db->query($sql);
        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        $row = $this->db->single();
        return $row->count;
    }

    public function addStudent($data) {
        $this->db->query('INSERT INTO students (first_name, surname, age, class, email, about, educational_goals, memory_verse, prayer_needs, profile_photo, access_token, password) VALUES (:first_name, :surname, :age, :class, :email, :about, :educational_goals, :memory_verse, :prayer_needs, :profile_photo, :access_token, :password)');
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':class', $data['class']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':about', $data['about']);
        $this->db->bind(':educational_goals', $data['educational_goals']);
        $this->db->bind(':memory_verse', $data['memory_verse']);
        $this->db->bind(':prayer_needs', $data['prayer_needs']);
        $this->db->bind(':profile_photo', $data['profile_photo']);
        $this->db->bind(':access_token', $data['access_token']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function login($email, $password) {
        $this->db->query('SELECT * FROM students WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }

    public function getStudentById($id) {
        $this->db->query('SELECT * FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getStudentByToken($token) {
        $this->db->query('SELECT * FROM students WHERE access_token = :token');
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function updateStudent($data) {
        if (!empty($data['password'])) {
            $this->db->query('UPDATE students SET first_name = :first_name, surname = :surname, age = :age, class = :class, email = :email, about = :about, educational_goals = :educational_goals, memory_verse = :memory_verse, prayer_needs = :prayer_needs, profile_photo = :profile_photo, password = :password WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            $this->db->query('UPDATE students SET first_name = :first_name, surname = :surname, age = :age, class = :class, email = :email, about = :about, educational_goals = :educational_goals, memory_verse = :memory_verse, prayer_needs = :prayer_needs, profile_photo = :profile_photo WHERE id = :id');
        }
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':class', $data['class']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':about', $data['about']);
        $this->db->bind(':educational_goals', $data['educational_goals']);
        $this->db->bind(':memory_verse', $data['memory_verse']);
        $this->db->bind(':prayer_needs', $data['prayer_needs']);
        $this->db->bind(':profile_photo', $data['profile_photo']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Gallery Methods
    public function addGalleryPhoto($student_id, $path, $caption = '', $type = 'life') {
        $this->db->query('INSERT INTO student_photos (student_id, photo_path, caption, photo_type) VALUES (:student_id, :path, :caption, :type)');
        $this->db->bind(':student_id', $student_id);
        $this->db->bind(':path', $path);
        $this->db->bind(':caption', $caption);
        $this->db->bind(':type', $type);
        return $this->db->execute();
    }

    public function getGallery($student_id, $type = null) {
        if ($type) {
            $this->db->query('SELECT * FROM student_photos WHERE student_id = :id AND photo_type = :type ORDER BY created_at DESC');
            $this->db->bind(':type', $type);
        } else {
            $this->db->query('SELECT * FROM student_photos WHERE student_id = :id ORDER BY created_at DESC');
        }
        $this->db->bind(':id', $student_id);
        return $this->db->resultSet();
    }

    public function deleteGalleryPhoto($id) {
        $this->db->query('SELECT photo_path FROM student_photos WHERE id = :id');
        $this->db->bind(':id', $id);
        $photo = $this->db->single();
        
        if($photo && file_exists(APPROOT . '/public/' . $photo->photo_path)) {
            unlink(APPROOT . '/public/' . $photo->photo_path);
        }

        $this->db->query('DELETE FROM student_photos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteStudent($id) {
        $student = $this->getStudentById($id);
        
        // Delete messages associated with this student
        // Since messages doesn't have FK constraints on sender_id/receiver_id, we do it manually
        $this->db->query('DELETE FROM messages WHERE (sender_type = "student" AND sender_id = :id) OR (sender_type = "sponsor" AND receiver_id = :id)');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Delete profile photo from disk
        if(!empty($student->profile_photo) && file_exists(APPROOT . '/public/' . $student->profile_photo)) {
            unlink(APPROOT . '/public/' . $student->profile_photo);
        }

        $this->db->query('DELETE FROM students WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
