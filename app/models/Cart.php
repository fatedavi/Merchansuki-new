<?php

class Cart extends Model
{
    protected string $sessionKey = 'cart';

    /**
     * Ambil data keranjang dari session (auto inisialisasi jika belum ada)
     */
    public function get(): array
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [
                'items'          => [],
                'total_quantity' => 0,
                'total_price'    => 0,
            ];
        }

        // Jika user login dan session cart masih kosong, coba load dari database
        if ($this->getUserId() !== null && empty($_SESSION[$this->sessionKey]['items'])) {
            $fromDb = $this->loadFromDatabase();
            if (!empty($fromDb['items'])) {
                $_SESSION[$this->sessionKey] = $fromDb;
            }
        }

        return $_SESSION[$this->sessionKey];
    }

    /**
     * Tambah item ke keranjang berdasarkan product & variant
     */
    public function addItem(array $product, array $variant, int $qty = 1): array
    {
        $cart = $this->get();

        $key = (int) $variant['id']; // pakai ID variant sebagai key unik

        if (!isset($cart['items'][$key])) {
            $cart['items'][$key] = [
                'product_id'   => (int) $product['id'],
                'variant_id'   => (int) $variant['id'],
                'name'         => $product['name'] ?? '',
                'variant_name' => $variant['variant_name'] ?? '',
                'price'        => (float) ($variant['price'] ?? 0),
                'qty'          => 0,
                'image'        => $variant['image'] ?? null,
            ];
        }

        $cart['items'][$key]['qty'] += max(1, $qty);

        $this->recalculate($cart);

        $_SESSION[$this->sessionKey] = $cart;

        // Sinkronkan ke database jika user login
        $this->syncDatabase($cart);

        return $cart;
    }

    /**
     * Update jumlah item
     */
    public function updateQuantity(int $variantId, int $qty): array
    {
        $cart = $this->get();

        if ($qty <= 0) {
            unset($cart['items'][$variantId]);
        } elseif (isset($cart['items'][$variantId])) {
            $cart['items'][$variantId]['qty'] = $qty;
        }

        $this->recalculate($cart);

        $_SESSION[$this->sessionKey] = $cart;

        // Sinkronkan ke database jika user login
        $this->syncDatabase($cart);

        return $cart;
    }

    /**
     * Hapus 1 item dari keranjang
     */
    public function remove(int $variantId): array
    {
        $cart = $this->get();

        if (isset($cart['items'][$variantId])) {
            unset($cart['items'][$variantId]);
        }

        $this->recalculate($cart);
        $_SESSION[$this->sessionKey] = $cart;

        // Sinkronkan ke database jika user login
        $this->syncDatabase($cart);

        return $cart;
    }

    /**
     * Kosongkan keranjang
     */
    public function clear(): void
    {
        unset($_SESSION[$this->sessionKey]);

        // Kosongkan juga di database (jika user login)
        $this->syncDatabase([
            'items'          => [],
            'total_quantity' => 0,
            'total_price'    => 0,
        ]);
    }

    /**
     * Hitung ulang total qty & total harga
     */
    protected function recalculate(array &$cart): void
    {
        $totalQty   = 0;
        $totalPrice = 0;

        foreach ($cart['items'] as $item) {
            $qty   = (int) ($item['qty'] ?? 0);
            $price = (float) ($item['price'] ?? 0);

            $totalQty   += $qty;
            $totalPrice += $qty * $price;
        }

        $cart['total_quantity'] = $totalQty;
        $cart['total_price']    = $totalPrice;
    }

    /**
     * Ambil ID user yang sedang login (jika ada)
     */
    protected function getUserId(): ?int
    {
        if (isset($_SESSION['user']['id'])) {
            return (int) $_SESSION['user']['id'];
        }

        return null;
    }

    /**
     * Ambil / buat cart ID aktif di database untuk user login
     */
    protected function getActiveCartId(bool $createIfMissing = true): ?int
    {
        $userId = $this->getUserId();
        if ($userId === null) {
            return null;
        }

        // Cari cart aktif
        $this->db->query("
            SELECT id 
            FROM carts 
            WHERE user_id = :user_id 
              AND status = 'active'
            LIMIT 1
        ");
        $this->db->bind(':user_id', $userId);
        $row = $this->db->single();

        if ($row) {
            return (int) $row['id'];
        }

        if (!$createIfMissing) {
            return null;
        }

        // Buat cart baru
        $this->db->query("
            INSERT INTO carts (user_id, status, created_at, updated_at)
            VALUES (:user_id, 'active', NOW(), NOW())
        ");
        $this->db->bind(':user_id', $userId);
        $this->db->execute();

        return (int) $this->db->lastInsertId();
    }

    /**
     * Load data keranjang dari database untuk user login
     */
    protected function loadFromDatabase(): array
    {
        $userId = $this->getUserId();
        if ($userId === null) {
            return [
                'items'          => [],
                'total_quantity' => 0,
                'total_price'    => 0,
            ];
        }

        $cartId = $this->getActiveCartId(false);
        if ($cartId === null) {
            return [
                'items'          => [],
                'total_quantity' => 0,
                'total_price'    => 0,
            ];
        }

        $this->db->query("
            SELECT 
                ci.product_id,
                ci.variant_id,
                ci.qty,
                ci.price,
                p.name,
                pv.variant_name,
                pv.image
            FROM cart_items ci
            JOIN products p ON p.id = ci.product_id
            JOIN product_variants pv ON pv.id = ci.variant_id
            WHERE ci.cart_id = :cart_id
        ");
        $this->db->bind(':cart_id', $cartId);
        $rows = $this->db->resultSet();

        $items       = [];
        $totalQty    = 0;
        $totalPrice  = 0;

        foreach ($rows as $row) {
            $vid = (int) $row['variant_id'];

            $qty   = (int) $row['qty'];
            $price = (float) $row['price'];

            $items[$vid] = [
                'product_id'   => (int) $row['product_id'],
                'variant_id'   => $vid,
                'name'         => $row['name'] ?? '',
                'variant_name' => $row['variant_name'] ?? '',
                'price'        => $price,
                'qty'          => $qty,
                'image'        => $row['image'] ?? null,
            ];

            $totalQty   += $qty;
            $totalPrice += $qty * $price;
        }

        return [
            'items'          => $items,
            'total_quantity' => $totalQty,
            'total_price'    => $totalPrice,
        ];
    }

    /**
     * Sinkronkan isi keranjang di session ke database
     */
    protected function syncDatabase(array $cart): void
    {
        $userId = $this->getUserId();
        if ($userId === null) {
            // Guest: simpan hanya di session
            return;
        }

        $cartId = $this->getActiveCartId(true);
        if ($cartId === null) {
            return;
        }

        // Hapus item lama
        $this->db->query("DELETE FROM cart_items WHERE cart_id = :cart_id");
        $this->db->bind(':cart_id', $cartId);
        $this->db->execute();

        // Jika tidak ada item, selesai
        if (empty($cart['items'])) {
            return;
        }

        // Insert item baru
        foreach ($cart['items'] as $item) {
            $this->db->query("
                INSERT INTO cart_items (
                    cart_id, product_id, variant_id, qty, price, created_at, updated_at
                ) VALUES (
                    :cart_id, :product_id, :variant_id, :qty, :price, NOW(), NOW()
                )
            ");
            $this->db->bind(':cart_id', $cartId);
            $this->db->bind(':product_id', $item['product_id']);
            $this->db->bind(':variant_id', $item['variant_id']);
            $this->db->bind(':qty', $item['qty']);
            $this->db->bind(':price', $item['price']);
            $this->db->execute();
        }
    }
}