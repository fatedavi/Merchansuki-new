<?php

class CartController extends Controller
{
    /**
     * Halaman utama keranjang
     */
    public function index()
    {
        $this->requireLogin();

        $cartModel = $this->model('Cart');
        $cart      = $cartModel->get();

        $this->view('cart', compact('cart'));
    }

    /**
     * Tambah produk ke keranjang
     * Bisa dipanggil via AJAX (homepage) atau form biasa
     */
    public function add()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(false, 'Method tidak diizinkan', 405);
        }

        $productId = (int) ($_POST['product_id'] ?? 0);
        $variantId = isset($_POST['variant_id']) ? (int) $_POST['variant_id'] : null;
        $qty       = isset($_POST['qty']) ? max(1, (int) $_POST['qty']) : 1;

        if ($productId <= 0) {
            $this->jsonResponse(false, 'Produk tidak valid');
        }

        $productModel = $this->model('Product');
        $product      = $productModel->getDetail($productId);

        if (!$product) {
            $this->jsonResponse(false, 'Produk tidak ditemukan');
        }

        if (empty($product['variants'])) {
            $this->jsonResponse(false, 'Produk ini belum memiliki varian yang bisa dibeli');
        }

        // Tentukan variant: dari request, atau default ke variant pertama (termurah)
        $variant = null;

        if ($variantId) {
            foreach ($product['variants'] as $v) {
                if ((int) $v['id'] === $variantId) {
                    $variant = $v;
                    break;
                }
            }

            if (!$variant) {
                $this->jsonResponse(false, 'Varian produk tidak ditemukan');
            }
        } else {
            $variant = $product['variants'][0];
        }

        // Cek stok (jika ada field stock)
        $stock = isset($variant['stock']) ? (int) $variant['stock'] : null;

        $cartModel = $this->model('Cart');
        $cart      = $cartModel->get();
        $current   = 0;

        $key = (int) $variant['id'];
        if (isset($cart['items'][$key])) {
            $current = (int) $cart['items'][$key]['qty'];
        }

        if ($stock !== null && $stock > 0 && ($current + $qty) > $stock) {
            $this->jsonResponse(false, 'Stok tidak mencukupi untuk jumlah yang diminta');
        }

        $cart = $cartModel->addItem($product, $variant, $qty);

        // Jika AJAX, balas JSON. Jika bukan, redirect ke halaman cart
        if ($this->isAjax()) {
            $this->jsonResponse(true, 'Produk berhasil ditambahkan ke keranjang', 200, [
                'cart'           => $cart,
                'total_quantity' => $cart['total_quantity'] ?? 0,
            ]);
        }

        header('Location: /cart');
        exit;
    }

    /**
     * Update jumlah item di keranjang
     */
    public function update()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $variantId = (int) ($_POST['variant_id'] ?? 0);
        $qty       = (int) ($_POST['qty'] ?? 1);

        if ($variantId <= 0) {
            header('Location: /cart');
            exit;
        }

        $qty = max(0, $qty);

        $cartModel = $this->model('Cart');
        $cartModel->updateQuantity($variantId, $qty);

        header('Location: /cart');
        exit;
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $variantId = (int) ($_POST['variant_id'] ?? 0);

        if ($variantId > 0) {
            $cartModel = $this->model('Cart');
            $cartModel->remove($variantId);
        }

        header('Location: /cart');
        exit;
    }

    /**
     * Kosongkan seluruh keranjang
     */
    public function clear()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $cartModel = $this->model('Cart');
        $cartModel->clear();

        header('Location: /cart');
        exit;
    }

    /**
     * Helper: cek AJAX request
     */
    protected function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Helper: respon JSON standar
     */
    protected function jsonResponse(bool $success, string $message, int $status = 200, array $extra = []): void
    {
        http_response_code($status);
        header('Content-Type: application/json');

        echo json_encode(array_merge([
            'success' => $success,
            'message' => $message,
        ], $extra));
        exit;
    }

    /**
     * Helper: pastikan user sudah login sebelum akses keranjang
     */
    protected function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            if ($this->isAjax()) {
                $this->jsonResponse(false, 'Silakan login terlebih dahulu untuk menggunakan keranjang.', 401);
            } else {
                $_SESSION['error'] = 'Silakan login terlebih dahulu untuk menggunakan keranjang.';
                header('Location: /auth/login');
                exit;
            }
        }
    }
}