<?php

class MessageModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addMessage($data) {
        $this->db->query('INSERT INTO messages (sender_type, sender_id, receiver_id, content, status) VALUES (:sender_type, :sender_id, :receiver_id, :content, :status)');
        $this->db->bind(':sender_type', $data['sender_type']);
        $this->db->bind(':sender_id', $data['sender_id']);
        $this->db->bind(':receiver_id', $data['receiver_id']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':status', 'pending');

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function saveFormResponse($message_id, $field_id, $value) {
        $this->db->query('INSERT INTO form_responses (message_id, field_id, value) VALUES (:message_id, :field_id, :value)');
        $this->db->bind(':message_id', $message_id);
        $this->db->bind(':field_id', $field_id);
        $this->db->bind(':value', $value);
        return $this->db->execute();
    }

    public function getPendingMessages() {
        $this->db->query('SELECT m.*, 
                          CASE 
                            WHEN m.sender_type = "sponsor" THEN (SELECT name FROM sponsors WHERE id = m.sender_id)
                            WHEN m.sender_type = "student" THEN (SELECT CONCAT(first_name, " ", surname) FROM students WHERE id = m.sender_id)
                          END as sender_name,
                          CASE 
                            WHEN m.sender_type = "sponsor" THEN (SELECT CONCAT(first_name, " ", surname) FROM students WHERE id = m.receiver_id)
                            WHEN m.sender_type = "student" THEN (SELECT name FROM sponsors WHERE id = m.receiver_id)
                          END as receiver_name
                          FROM messages m WHERE status = "pending" ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function updateStatus($id, $status, $note = '') {
        $this->db->query('UPDATE messages SET status = :status, moderation_note = :note WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->bind(':note', $note);
        return $this->db->execute();
    }

    public function getMessageResponses($message_id) {
        $this->db->query('SELECT fr.value, ff.label 
                          FROM form_responses fr
                          JOIN form_fields ff ON fr.field_id = ff.id
                          WHERE fr.message_id = :message_id');
        $this->db->bind(':message_id', $message_id);
        return $this->db->resultSet();
    }

    public function getMessagesForUser($type, $id) {
        // Get approved messages where user is receiver or approved messages where user is sender
        $this->db->query('SELECT m.*, 
                          CASE 
                            WHEN m.sender_type = "sponsor" THEN (SELECT name FROM sponsors WHERE id = m.sender_id)
                            WHEN m.sender_type = "student" THEN (SELECT CONCAT(first_name, " ", surname) FROM students WHERE id = m.sender_id)
                          END as sender_name
                          FROM messages m 
                          WHERE status = "approved" 
                          AND ((sender_type = :type AND sender_id = :id) OR (sender_type != :type AND receiver_id = :id))
                          ORDER BY created_at DESC');
        $this->db->bind(':type', $type);
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
}
