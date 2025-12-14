<?php
require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel
{
    public function getUser()
    {
        $sql  = 'SELECT * FROM users LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $this->fetchOneAssoc($stmt);
    }
}
