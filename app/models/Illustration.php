<?php
// app/models/Illustration.php

require_once __DIR__ . '/BaseModel.php';

class Illustration extends BaseModel
{
    public function findGlobalByCompetence($competenceId)
    {
        $sql  = 'SELECT * FROM illustrations WHERE competence_id = ? AND ac_id IS NULL ORDER BY id';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $competenceId);
        $stmt->execute();
        return $this->fetchAllAssoc($stmt);
    }

    public function findGroupedByAcForCompetence($competenceId)
    {
        $sql  = 'SELECT * FROM illustrations WHERE competence_id = ? AND ac_id IS NOT NULL ORDER BY id';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $competenceId);
        $stmt->execute();
        $rows = $this->fetchAllAssoc($stmt);

        $result = array();
        foreach ($rows as $row) {
            $acId = $row['ac_id'];
            if (!isset($result[$acId])) {
                $result[$acId] = array();
            }
            $result[$acId][] = $row;
        }
        return $result;
    }

    public function findByCompetenceWithAc($competenceId)
    {
        $sql = '
            SELECT i.*, a.code AS ac_code
            FROM illustrations i
            LEFT JOIN acs a ON i.ac_id = a.id
            WHERE i.competence_id = ?
            ORDER BY i.id
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $competenceId);
        $stmt->execute();
        return $this->fetchAllAssoc($stmt);
    }

    public function findById($id)
    {
        $sql  = 'SELECT * FROM illustrations WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $this->fetchOneAssoc($stmt);
    }

    public function create($data)
    {
        $sql = 'INSERT INTO illustrations (competence_id, ac_id, type, path, titre)
                VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);

        $acId = $data['ac_id'] !== null ? (int) $data['ac_id'] : null;

        // "issi" mais ac_id peut être null → bind_param n'accepte pas null typé,
        // on passe par ssi avec cast (ou on gère separate). Pour rester simple ici :
        $stmt->bind_param(
            'issss',
            $data['competence_id'],
            $acId,
            $data['type'],
            $data['path'],
            $data['titre']
        );

        $stmt->execute();
        $stmt->close();
    }

    public function delete($id)
    {
        $sql  = 'DELETE FROM illustrations WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function countAll()
    {
        $sql  = 'SELECT COUNT(*) AS c FROM illustrations';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $this->fetchOneAssoc($stmt);
        return (int) $row['c'];
    }
}
