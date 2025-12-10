<?php
// app/models/Competence.php

require_once __DIR__ . '/BaseModel.php';

class Competence extends BaseModel
{
    public function getAllWithAnnee()
    {
        $sql = '
            SELECT c.*, a.label AS annee_label
            FROM competences c
            JOIN annees a ON c.annee_id = a.id
            ORDER BY a.id, c.code
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $this->fetchAllAssoc($stmt);
    }

    public function findByAnnee($anneeId)
    {
        $sql  = 'SELECT * FROM competences WHERE annee_id = ? ORDER BY code';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $anneeId);
        $stmt->execute();
        return $this->fetchAllAssoc($stmt);
    }

    public function findById($id)
    {
        $sql  = 'SELECT * FROM competences WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $this->fetchOneAssoc($stmt);
    }

    public function create($data)
    {
        $sql  = 'INSERT INTO competences (annee_id, code, titre, description) VALUES (?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'isss',
            $data['annee_id'],
            $data['code'],
            $data['titre'],
            $data['description']
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update($id, $data)
    {
        $sql  = 'UPDATE competences SET annee_id = ?, code = ?, titre = ?, description = ? WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'isssi',
            $data['annee_id'],
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
        $sql  = 'DELETE FROM competences WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function countAll()
    {
        $sql  = 'SELECT COUNT(*) AS c FROM competences';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $this->fetchOneAssoc($stmt);
        return (int) $row['c'];
    }
}
