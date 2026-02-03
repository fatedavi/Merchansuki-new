<?php

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    public function getByProduct($productId)
    {
        $this->db->query("
            SELECT * FROM product_variants
            WHERE product_id = :product_id
            ORDER BY id ASC
        ");
        $this->db->bind(':product_id', $productId);
        return $this->db->resultSet();
    }

    public function find($id)
    {
        $this->db->query("SELECT * FROM product_variants WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data)
    {
        $this->db->query("
            INSERT INTO product_variants
            (product_id, variant_name, price, stock, image, status)
            VALUES
            (:product_id, :variant_name, :price, :stock, :image, :status)
        ");

        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':variant_name', $data['variant_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock'] ?? 0);
        $this->db->bind(':image', $data['image'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $this->db->query("
            UPDATE product_variants SET
                variant_name = :variant_name,
                price = :price,
                stock = :stock,
                image = :image,
                status = :status
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);
        $this->db->bind(':variant_name', $data['variant_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock'] ?? 0);
        $this->db->bind(':image', $data['image'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM product_variants WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    /**
 * Ambil variant berdasarkan product & variant (AMAN)
 */
public function findByProduct($variantId, $productId)
{
    $this->db->query("
        SELECT *
        FROM product_variants
        WHERE id = :variant_id
          AND product_id = :product_id
        LIMIT 1
    ");
    $this->db->bind(':variant_id', $variantId);
    $this->db->bind(':product_id', $productId);

    return $this->db->single();
}

/**
 * Delete variant by product (AMAN)
 */
public function deleteByProduct($variantId, $productId)
{
    $this->db->query("
        DELETE FROM product_variants
        WHERE id = :variant_id
          AND product_id = :product_id
    ");
    $this->db->bind(':variant_id', $variantId);
    $this->db->bind(':product_id', $productId);

    return $this->db->execute();
}

}
