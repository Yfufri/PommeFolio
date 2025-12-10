<?php
// app/models/User.php

require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel
{
    public function findByUsername($username)
    {
        $sql  = 'SELECT * FROM users WHERE username = ? LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        return $this->fetchOneAssoc($stmt);
    }
}
