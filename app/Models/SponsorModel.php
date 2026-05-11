<?php

class SponsorModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getSponsors() {
        $this->db->query('SELECT * FROM sponsors ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function addSponsor($data) {
        $this->db->query('INSERT INTO sponsors (name, email, access_token) VALUES (:name, :email, :access_token)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':access_token', $data['access_token']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getSponsorById($id) {
        $this->db->query('SELECT * FROM sponsors WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateSponsor($data) {
        $this->db->query('UPDATE sponsors SET name = :name, email = :email WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteSponsor($id) {
        $this->db->query('DELETE FROM sponsors WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
