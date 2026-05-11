<?php

class AssignmentModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAssignments() {
        $this->db->query('SELECT s.name as sponsor_name, st.first_name, st.surname, ss.sponsor_id, ss.student_id 
                          FROM sponsor_student ss
                          JOIN sponsors s ON ss.sponsor_id = s.id
                          JOIN students st ON ss.student_id = st.id');
        return $this->db->resultSet();
    }

    public function assign($sponsor_id, $student_id) {
        $this->db->query('INSERT IGNORE INTO sponsor_student (sponsor_id, student_id) VALUES (:sponsor_id, :student_id)');
        $this->db->bind(':sponsor_id', $sponsor_id);
        $this->db->bind(':student_id', $student_id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function unassign($sponsor_id, $student_id) {
        $this->db->query('DELETE FROM sponsor_student WHERE sponsor_id = :sponsor_id AND student_id = :student_id');
        $this->db->bind(':sponsor_id', $sponsor_id);
        $this->db->bind(':student_id', $student_id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
