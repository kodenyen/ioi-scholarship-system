<?php

class FormModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getFields($assigned_to = null) {
        if ($assigned_to) {
            $this->db->query('SELECT * FROM form_fields WHERE assigned_to = :assigned_to ORDER BY created_at ASC');
            $this->db->bind(':assigned_to', $assigned_to);
        } else {
            $this->db->query('SELECT * FROM form_fields ORDER BY created_at ASC');
        }
        return $this->db->resultSet();
    }

    public function addField($data) {
        $this->db->query('INSERT INTO form_fields (label, type, assigned_to, options) VALUES (:label, :type, :assigned_to, :options)');
        $this->db->bind(':label', $data['label']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':assigned_to', $data['assigned_to']);
        $this->db->bind(':options', $data['options']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteField($id) {
        $this->db->query('DELETE FROM form_fields WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
