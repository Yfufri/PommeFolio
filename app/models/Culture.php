<?php

require_once __DIR__ . '/BaseModel.php';

class Culture extends BaseModel
{
    public function findAll()
    {
        $sql  = 'SELECT * FROM culture_items ORDER BY date_evenement DESC, id DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $this->fetchAllAssoc($stmt);
    }
}
