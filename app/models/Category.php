<?php

class Category extends Model
{
    protected $table = 'categories';

    public function getAll()
    {
        $this->db->query("
            SELECT id, name
            FROM categories
            ORDER BY name ASC
        ");
        return $this->db->resultSet();
    }

    public function create($data)
    {
        $this->db->query("
            INSERT INTO categories (name)
            VALUES (:name)
        ");
        $this->db->bind(':name', $data['name']);
        return $this->db->execute();
    }

    public function getAlllist()
    {
        return $this->db->query("SELECT * FROM categories ORDER BY name ASC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM categories WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }


    public function hasProducts($id)
    {
        $this->db->query("SELECT COUNT(*) AS total FROM products WHERE category_id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->single()['total'] > 0;
    }

}
