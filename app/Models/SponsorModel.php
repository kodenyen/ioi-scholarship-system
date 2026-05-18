<?php

class SponsorModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getSponsors($limit = null, $offset = null) {
        $sql = 'SELECT * FROM sponsors ORDER BY created_at DESC';
        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }
        $this->db->query($sql);
        if ($limit !== null && $offset !== null) {
            $this->db->bind(':limit', $limit);
            $this->db->bind(':offset', $offset);
        }
        return $this->db->resultSet();
    }

    public function getSponsorCount() {
        $this->db->query('SELECT COUNT(*) as count FROM sponsors');
        $row = $this->db->single();
        return $row->count;
    }

    public function addSponsor($data) {
        $this->db->query('INSERT INTO sponsors (name, email, access_token, profile_photo, password) VALUES (:name, :email, :access_token, :profile_photo, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':access_token', $data['access_token']);
        $this->db->bind(':profile_photo', $data['profile_photo']);
        $this->db->bind(':password', $data['password']);

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

    public function getSponsorByEmail($email) {
        $this->db->query('SELECT * FROM sponsors WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function login($email, $password) {
        $row = $this->getSponsorByEmail($email);
        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }

    public function updateSponsor($data) {
        if (!empty($data['password'])) {
            $this->db->query('UPDATE sponsors SET name = :name, email = :email, profile_photo = :profile_photo, password = :password WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            $this->db->query('UPDATE sponsors SET name = :name, email = :email, profile_photo = :profile_photo WHERE id = :id');
        }
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':profile_photo', $data['profile_photo']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteSponsor($id) {
        $sponsor = $this->getSponsorById($id);

        // Delete messages associated with this sponsor
        $this->db->query('DELETE FROM messages WHERE (sender_type = "sponsor" AND sender_id = :id) OR (sender_type = "student" AND receiver_id = :id)');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Delete profile photo from disk
        if(!empty($sponsor->profile_photo) && file_exists(APPROOT . '/' . $sponsor->profile_photo)) {
            unlink(APPROOT . '/' . $sponsor->profile_photo);
        }

        $this->db->query('DELETE FROM sponsors WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
