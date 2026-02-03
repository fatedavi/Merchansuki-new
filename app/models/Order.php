<?php

class Order extends Model
{
    protected $table = 'orders';

    /**
     * Buat order dari cart
     */
    public function createFromCart(array $cart, int $userId, int $shippingCost, int $grandTotal, array $alamat): int
    {
        $this->db->query("
            INSERT INTO orders (
                user_id,
                total_quantity,
                subtotal,
                shipping_cost,
                total_price,
                address,
                city,
                province,
                postal_code,
                payment,
                status
            ) VALUES (
                :user_id,
                :total_quantity,
                :subtotal,
                :shipping_cost,
                :total_price,
                :address,
                :city,
                :province,
                :postal_code,
                :payment,
                'pending'
            )
        ");

        $this->db->bind(':user_id', $userId);
        $this->db->bind(':total_quantity', $cart['total_quantity']);
        $this->db->bind(':subtotal', $cart['total_price']);
        $this->db->bind(':shipping_cost', $shippingCost);
        $this->db->bind(':total_price', $grandTotal);
        $this->db->bind(':address', $alamat['address'] ?? '');
        $this->db->bind(':city', $alamat['city'] ?? '');
        $this->db->bind(':province', $alamat['province'] ?? '');
        $this->db->bind(':postal_code', $alamat['postal_code'] ?? '');
        $this->db->bind(':payment', $alamat['payment'] ?? '');
        $this->db->execute();

        $orderId = (int) $this->db->lastInsertId();

        // Insert items
        foreach ($cart['items'] as $item) {
            $this->db->query("
                INSERT INTO order_items (
                    order_id, product_id, variant_id, qty, price
                ) VALUES (
                    :order_id, :product_id, :variant_id, :qty, :price
                )
            ");
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':product_id', $item['product_id']);
            $this->db->bind(':variant_id', $item['variant_id'] ?? null);
            $this->db->bind(':qty', $item['qty']);
            $this->db->bind(':price', $item['price']);
            $this->db->execute();
        }

        return $orderId;
    }

    /**
     * Ambil semua order milik user
     */
    public function getByUser(int $userId): array
    {
        $this->db->query("
            SELECT *
            FROM orders
            WHERE user_id = :user_id
            ORDER BY id DESC
        ");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    /**
     * Ambil detail order + item
     */
    public function findWithItems(int $orderId): ?array
    {
        $this->db->query("
            SELECT *
            FROM orders
            WHERE id = :id
        ");
        $this->db->bind(':id', $orderId);
        $order = $this->db->single();

        if (!$order) {
            return null;
        }

        // Ambil items
        $this->db->query("
            SELECT 
                oi.id,
                oi.product_id,
                oi.variant_id,
                oi.qty,
                oi.price,
                (oi.qty * oi.price) AS subtotal,
                p.name AS product_name,
                pv.variant_name
            FROM order_items oi
            JOIN products p ON p.id = oi.product_id
            LEFT JOIN product_variants pv ON pv.id = oi.variant_id
            WHERE oi.order_id = :order_id
        ");
        $this->db->bind(':order_id', $orderId);
        $order['items'] = $this->db->resultSet();

        // Pastikan semua field penting ada untuk view
        $order['address'] = $order['address'] ?? '-';
        $order['city'] = $order['city'] ?? '-';
        $order['province'] = $order['province'] ?? '-';
        $order['postal_code'] = $order['postal_code'] ?? '-';
        $order['payment'] = $order['payment'] ?? '-';
        $order['shipping_cost'] = $order['shipping_cost'] ?? 0;
        $order['subtotal'] = $order['subtotal'] ?? 0;
        $order['total_price'] = $order['total_price'] ?? 0;

        return $order;
    }
    public function updateStatus($orderId, $status)
{
    $this->db->query(
        "UPDATE orders SET status = :status WHERE id = :id"
    );
    $this->db->bind('status', $status);
    $this->db->bind('id', $orderId);
    $this->db->execute();
}

}
