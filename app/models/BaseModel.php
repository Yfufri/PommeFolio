<?php
// app/models/BaseModel.php

class BaseModel
{
    protected $db;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php'; // doit définir $mysqli
        $this->db = $mysqli;
    }

    protected function fetchAllAssoc($stmt)
    {
        $result = $stmt->get_result();
        $rows   = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    protected function fetchOneAssoc($stmt)
    {
        $result = $stmt->get_result();
        $row    = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }
}
