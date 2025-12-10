<?php
// app/models/Ac.php

require_once __DIR__ . '/BaseModel.php';

class Ac extends BaseModel
{
    public function findByCompetence($competenceId)
    {
        $sql  = 'SELECT * FROM acs WHERE competence_id = ? ORDER BY code';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $competenceId);
        $stmt->execute();
        return $this->fetchAllAssoc($stmt);
    }

    public function findById($id)
    {
        $sql  = 'SELECT * FROM acs WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $this->fetchOneAssoc($stmt);
    }

    public function create($data)
    {
        $sql  = 'INSERT INTO acs (competence_id, code, titre, description) VALUES (?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'isss',
            $data['competence_id'],
            $data['code'],
            $data['titre'],
            $data['description']
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update($id, $data)
    {
        $sql  = 'UPDATE acs SET code = ?, titre = ?, description = ? WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'sssi',
            $data['code'],
            $data['titre'],
            $data['description'],
            $id
        );
        $stmt->execute();
        $stmt->close();
    }

    public function delete($id)
    {
        $sql  = 'DELETE FROM acs WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function countAll()
    {
        $sql  = 'SELECT COUNT(*) AS c FROM acs';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $this->fetchOneAssoc($stmt);
        return (int) $row['c'];
    }
}
