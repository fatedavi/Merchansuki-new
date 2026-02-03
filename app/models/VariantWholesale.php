<?php

class VariantWholesale extends Model
{
    protected $table = 'variant_wholesale_prices';

public function getAllVariantsWithWholesale()
{
    $this->db->query("
        SELECT 
            vwp.id AS wholesale_id,          -- 🔥 INI KUNCI UTAMA
            p.id AS product_id,
            p.name AS product_name,
            pv.id AS variant_id,
            pv.variant_name,
            vwp.min_unit,
            vwp.wholesale_price,
            vwp.status
        FROM products p
        JOIN product_variants pv ON pv.product_id = p.id
        LEFT JOIN variant_wholesale_prices vwp 
            ON vwp.variant_id = pv.id
        ORDER BY p.name ASC, pv.variant_name ASC, vwp.min_unit ASC
    ");

    return $this->db->resultSet();
}





    /**
     * Ambil harga grosir berdasarkan variant
     */
    public function getByVariant($variantId)
    {
        $this->db->query("
            SELECT *
            FROM variant_wholesale_prices
            WHERE variant_id = :variant_id
              AND status = 'active'
            ORDER BY min_unit ASC
        ");

        $this->db->bind(':variant_id', $variantId);

        return $this->db->resultSet();
    }

    /**
     * Cari satu data grosir
     */
    public function find($id)
    {
        $this->db->query("
            SELECT *
            FROM variant_wholesale_prices
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    /**
     * Cek apakah variant sudah punya harga grosir
     * (1 variant = 1 harga grosir)
     */
    public function findByVariant($variantId)
    {
        $this->db->query("
            SELECT *
            FROM variant_wholesale_prices
            WHERE variant_id = :variant_id
            LIMIT 1
        ");

        $this->db->bind(':variant_id', $variantId);

        return $this->db->single();
    }

    /**
     * Simpan harga grosir
     */
    public function create($data)
    {
        $this->db->query("
            INSERT INTO variant_wholesale_prices
            (variant_id, min_unit, wholesale_price, status)
            VALUES
            (:variant_id, :min_unit, :wholesale_price, :status)
        ");

        $this->db->bind(':variant_id', $data['variant_id']);
        $this->db->bind(':min_unit', $data['min_unit']);
        $this->db->bind(':wholesale_price', $data['wholesale_price']);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute();
    }

    /**
     * Update harga grosir
     */
public function update($id, $data)
{
    $this->db->query("
        UPDATE variant_wholesale_prices SET
            min_unit = :min_unit,
            wholesale_price = :wholesale_price,
            status = :status
        WHERE id = :id
    ");

    $this->db->bind(':id', $id);
    $this->db->bind(':min_unit', $data['min_unit']);
    $this->db->bind(':wholesale_price', $data['wholesale_price']);
    $this->db->bind(':status', $data['status'] ?? 'active');

    return $this->db->execute();
}

    /**
     * Delete harga grosir
     */
    public function delete($id)
    {
        $this->db->query("
            DELETE FROM variant_wholesale_prices
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    /**
     * Delete grosir berdasarkan variant (AMAN)
     */
    public function deleteByVariant($variantId)
    {
        $this->db->query("
            DELETE FROM variant_wholesale_prices
            WHERE variant_id = :variant_id
        ");

        $this->db->bind(':variant_id', $variantId);

        return $this->db->execute();
    }
}
