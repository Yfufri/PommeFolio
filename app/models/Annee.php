<?php
// app/models/Annee.php

require_once __DIR__ . '/BaseModel.php';

class Annee extends BaseModel
{
    public function findAll()
    {
        $sql  = 'SELECT * FROM annees ORDER BY id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $this->fetchAllAssoc($stmt);
    }

    public function findById($id)
    {
        $sql  = 'SELECT * FROM annees WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $this->fetchOneAssoc($stmt);
    }

    // années avec compétences (pour explorateur BUT)
    public function getAllWithCompetences()
    {
        $sql = '
            SELECT a.id AS annee_id, a.label,
                   c.id AS comp_id, c.code, c.titre
            FROM annees a
            LEFT JOIN competences c ON c.annee_id = a.id
            ORDER BY a.id, c.code
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $this->fetchAllAssoc($stmt);

        $result = array();
        foreach ($rows as $row) {
            $id = $row['annee_id'];
            if (!isset($result[$id])) {
                $result[$id] = array(
                    'id'          => $row['annee_id'],
                    'label'       => $row['label'],
                    'competences' => array(),
                );
            }
            if (!empty($row['comp_id'])) {
                $result[$id]['competences'][] = array(
                    'id'    => $row['comp_id'],
                    'code'  => $row['code'],
                    'titre' => $row['titre'],
                );
            }
        }
        return array_values($result);
    }
}
