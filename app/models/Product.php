<?php

class Product extends Model
{
    // Ambil produk yang di-highlight (featured)
    public function getHighlighted()
    {
        $this->db->query("
            SELECT * FROM products 
            WHERE highlight = 1 
            AND status = 'active'
            ORDER BY created_at DESC
        ");
        return $this->db->resultSet();
    }

    // Ambil semua produk, bisa pilih hanya yang aktif
    public function getAll($onlyActive = false)
    {
        if ($onlyActive) {
            $this->db->query("
                SELECT * FROM products 
                WHERE status = 'active' 
                ORDER BY created_at DESC
            ");
        } else {
            $this->db->query("
                SELECT * FROM products 
                ORDER BY created_at DESC
            ");
        }
        return $this->db->resultSet();
    }

    // Cari produk berdasarkan ID
    public function findById($id)
    {
        $this->db->query("SELECT * FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Tambah produk (tanpa price/stock, gambar di varian)
    public function create($data)
    {
        $this->db->query("
            INSERT INTO products 
            (category_id, name, slug, description, rating, highlight, status, created_at) 
            VALUES 
            (:category_id, :name, :slug, :description, :rating, :highlight, :status, NOW())
        ");
        $this->db->bind(':category_id', $data['category_id'] ?? null);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $data['slug'] ?? null);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':rating', $data['rating'] ?? 0.0);
        $this->db->bind(':highlight', $data['highlight'] ?? 0);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute();
    }

    // Update produk
    public function update($id, $data)
    {
        $this->db->query("
            UPDATE products SET 
            category_id = :category_id, 
            name = :name, 
            slug = :slug, 
            description = :description, 
            rating = :rating, 
            highlight = :highlight, 
            status = :status
            WHERE id = :id
        ");
        $this->db->bind(':id', $id);
        $this->db->bind(':category_id', $data['category_id'] ?? null);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $data['slug'] ?? null);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':rating', $data['rating'] ?? 0.0);
        $this->db->bind(':highlight', $data['highlight'] ?? 0);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute();
    }

    // Hapus produk
    public function delete($id)
    {
        $this->db->query("DELETE FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Ambil semua produk beserta varian-nya
    public function getAllWithVariants()
    {
        $products = $this->getAll(); // pakai method yang sudah ada, ambil semua produk

        foreach ($products as &$product) {
            $this->db->query("SELECT id, variant_name, price, stock, image 
                              FROM product_variants 
                              WHERE product_id = :pid");
            $this->db->bind(':pid', $product['id']);
            $product['variants'] = $this->db->resultSet();
        }

        return $products;
    }
    public function getVariants($productId)
    {
        $this->db->query("
            SELECT 
                id,
                variant_name,
                price,
                stock,
                status,
                image
            FROM product_variants
            WHERE product_id = :product_id
            ORDER BY id DESC
        ");

        $this->db->bind(':product_id', $productId);

        return $this->db->resultSet();
    }
    public function getAllWithCategory() {
        $this->db->query("
            SELECT 
                p.*,
                c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            ORDER BY p.created_at DESC
        ");

        return $this->db->resultSet();
    }

    public function getDetail($id)
    {
        // Ambil product + category
        $this->db->query("
            SELECT 
                p.*,
                c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.id = :id
            AND p.status != 'inactive'
            LIMIT 1
        ");
        $this->db->bind(':id', $id);
        $product = $this->db->single();

        if (!$product) {
            return false;
        }

        // Ambil variants
        $this->db->query("
            SELECT *
            FROM product_variants
            WHERE product_id = :pid
            AND status = 'active'
            ORDER BY price ASC
        ");
        $this->db->bind(':pid', $id);
        $product['variants'] = $this->db->resultSet();

        return $product;
    }

        public function getFilteredProducts($filters = [])
    {
        $categoryId = $filters['category_id'] ?? null;
        $priceMin = $filters['price_min'] ?? 0;
        $priceMax = $filters['price_max'] ?? 999999999;
        $search = $filters['search'] ?? '';
        $sort = $filters['sort'] ?? 'newest';

        $query = "
            SELECT DISTINCT
                p.id,
                p.category_id,
                p.name,
                p.description,
                p.rating,
                p.status,
                p.created_at,
                c.name AS category_name,
                COALESCE(MIN(pv.price), 0) AS min_price,
                COALESCE(MAX(pv.price), 0) AS max_price,
                (SELECT image FROM product_variants WHERE product_id = p.id AND status = 'active' LIMIT 1) AS image
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN product_variants pv ON pv.product_id = p.id AND pv.status = 'active'
            WHERE p.status = 'active'
        ";

        $params = [];

        if ($categoryId && $categoryId > 0) {
            $query .= " AND p.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if (!empty($search)) {
            $query .= " AND (p.name LIKE :search OR p.description LIKE :search)";
            $params['search'] = "%{$search}%";
        }

        $query .= " GROUP BY p.id";

        // Filter by price range (after GROUP BY)
        if ($priceMin > 0 || $priceMax < 999999999) {
            $query .= " HAVING min_price >= :price_min AND max_price <= :price_max";
            $params['price_min'] = $priceMin;
            $params['price_max'] = $priceMax;
        }

        if ($sort === 'price_asc') {
            $query .= " ORDER BY min_price ASC";
        } elseif ($sort === 'price_desc') {
            $query .= " ORDER BY max_price DESC";
        } elseif ($sort === 'oldest') {
            $query .= " ORDER BY p.created_at ASC";
        } else {
            $query .= " ORDER BY p.created_at DESC";
        }

        $this->db->query($query);
        foreach ($params as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }

        $products = $this->db->resultSet();

        foreach ($products as &$product) {
            $this->db->query("
                SELECT id, variant_name, price, stock, image
                FROM product_variants
                WHERE product_id = :pid
                AND status = 'active'
                ORDER BY price ASC
            ");
            $this->db->bind(':pid', $product['id']);
            $product['variants'] = $this->db->resultSet();
        }

        return $products;
    }

    public function getPriceRange()
    {
        $this->db->query("
            SELECT 
                COALESCE(MIN(price), 0) AS min_price,
                COALESCE(MAX(price), 0) AS max_price
            FROM product_variants
            WHERE status = 'active'
        ");
        return $this->db->single();
    }
}
