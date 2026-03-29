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

    public function findById($id)
    {
        $sql  = 'SELECT * FROM culture_items WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $this->fetchOneAssoc($stmt);
    }

    public function create($data)
    {
        $sql  = 'INSERT INTO culture_items (type, titre, description, date_evenement, lien, image) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'ssssss',
            $data['type'],
            $data['titre'],
            $data['description'],
            $data['date_evenement'],
            $data['lien'],
            $data['image']
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update($id, $data)
    {
        $sql  = 'UPDATE culture_items SET type = ?, titre = ?, description = ?, date_evenement = ?, lien = ?, image = ? WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'ssssssi',
            $data['type'],
            $data['titre'],
            $data['description'],
            $data['date_evenement'],
            $data['lien'],
            $data['image'],
            $id
        );
        $stmt->execute();
        $stmt->close();
    }

    public function delete($id)
    {
        $sql  = 'DELETE FROM culture_items WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
