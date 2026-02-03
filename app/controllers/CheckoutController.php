<?php

class CheckoutController extends Controller
{
    /**
     * Halaman checkout: tampilkan form alamat, metode bayar, dan ringkasan cart
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $cart = $this->model('Cart')->get();
        if (empty($cart['items'])) {
            header('Location: /cart');
            exit;
        }

        $profile = $this->model('Profile')
                        ->findByUserId($_SESSION['user']['id']);

        require_once __DIR__ . '/../helpers/ShippingHelper.php';

        // Hitung ongkir default berdasarkan profile user
        $distance = ShippingHelper::distanceFromSurabaya($profile['city'] ?? '');
        $ongkir   = ShippingHelper::calculateOngkir($distance);

        $this->view('checkout/index', [
            'cart'        => $cart,
            'profile'     => $profile,
            'distance'    => $distance,
            'ongkir'      => $ongkir,
            'grand_total' => $cart['total_price'] + $ongkir
        ]);
    }

    /**
     * Proses checkout: simpan order + redirect ke halaman pembayaran Midtrans
     */
    public function process()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    
        $cart = $this->model('Cart')->get();
        if (empty($cart['items'])) {
            header('Location: /cart');
            exit;
        }
    
        // ===============================
        // AMBIL DATA POST
        // ===============================
        $address     = trim($_POST['address'] ?? '');
        $city        = trim($_POST['city'] ?? '');
        $province    = trim($_POST['province'] ?? '');
        $postal_code = trim($_POST['postal_code'] ?? '');
        $payment     = trim($_POST['payment_method'] ?? '');
    
        // ===============================
        // VALIDASI
        // ===============================
        if (!$address || !$city || !$province || !$postal_code || !$payment) {
            $_SESSION['error'] = 'Lengkapi semua field alamat dan pembayaran';
            header('Location: /checkout');
            exit;
        }
    
        require_once __DIR__ . '/../helpers/ShippingHelper.php';
    
        // ===============================
        // 🔥 ONGKIR FINAL (DARI HELPER)
        // ===============================
        $shippingCost = (int) ShippingHelper::getOngkirByCity($city);
    
        if ($shippingCost < 0) {
            $_SESSION['error'] = 'Ongkir tidak valid';
            header('Location: /checkout');
            exit;
        }
    
        // ===============================
        // 🔥 TOTAL FINAL (ANTI MANIPULASI VIEW)
        // ===============================
        $subtotal   = (int) $cart['total_price'];
        $grandTotal = $subtotal + $shippingCost;
    
        // ===============================
        // DATA ALAMAT
        // ===============================
        $alamat = [
            'address'     => $address,
            'city'        => $city,
            'province'    => $province,
            'postal_code' => $postal_code,
            'payment'     => $payment
        ];
    
        // ===============================
        // 🔥 DEBUG (Cek sebelum simpan)
        // ===============================
        echo '<pre>';
        var_dump([
            'city'          => $city,
            'subtotal'      => $subtotal,
            'shippingCost'  => $shippingCost,
            'grandTotal'    => $grandTotal,
            'alamat'        => $alamat
        ]);
        exit;
    
        // ===============================
        // SIMPAN ORDER
        // ===============================
        $orderId = $this->model('Order')->createFromCart(
            $cart,
            (int) $_SESSION['user']['id'],
            $shippingCost,
            $grandTotal,
            $alamat
        );
    
        // ===============================
        // SIMPAN KE SESSION UNTUK PAYMENT
        // ===============================
        $_SESSION['checkout'] = [
            'order_id'    => $orderId,
            'subtotal'    => $subtotal,
            'shipping'    => $shippingCost,
            'grand_total' => $grandTotal
        ];
    
        // ===============================
        // KOSONGKAN CART
        // ===============================
        $this->model('Cart')->clear();
    
        // ===============================
        // REDIRECT KE PAYMENT
        // ===============================
        header('Location: /checkout/payment/' . $orderId);
        exit;
    }
    

    /**
     * Halaman detail order
     */
    public function detail($id)
    {
        $order = $this->model('Order')->findWithItems((int)$id);

        if (!$order) {
            http_response_code(404);
            echo 'Order tidak ditemukan';
            return;
        }

        $this->view('checkout/detail', [
            'order' => $order
        ]);
    }

    /**
     * Halaman pembayaran Midtrans
     */
public function payment($orderId)
{
    $order = $this->model('Order')->findWithItems((int)$orderId);

    if (!$order) {
        http_response_code(404);
        echo "Order tidak ditemukan";
        return;
    }

    require_once __DIR__ . '/../helpers/MidtransHelper.php';

    $itemDetails  = [];
    $grossAmount = 0;

    foreach ($order['items'] as $item) {

        // ✅ AMAN dari undefined key
        $productName = $item['name']
            ?? $item['product_name']
            ?? $item['title']
            ?? 'Produk';

        $itemDetails[] = [
            'id'       => 'PROD-' . $item['product_id'],
            'price'    => (int) $item['price'],
            'quantity' => (int) $item['qty'],
            'name'     => $productName
                . (!empty($item['variant_name']) ? ' - ' . $item['variant_name'] : ''),
        ];

        $grossAmount += (int)$item['price'] * (int)$item['qty'];
    }

    // ✅ ONGKIR sebagai ITEM
    if (!empty($order['shipping_cost'])) {
        $itemDetails[] = [
            'id'       => 'SHIPPING',
            'price'    => (int) $order['shipping_cost'],
            'quantity' => 1,
            'name'     => 'Ongkos Kirim',
        ];

        $grossAmount += (int) $order['shipping_cost'];
    }

    // ✅ CREATE TRANSACTION
    $snapToken = MidtransHelper::createTransaction([
        'order_id'     => 'ORDER-' . $order['id'], // wajib unik
        'gross_amount' => (int) $order['total_price'],
        'items'        => $itemDetails,
        'customer'     => [
            'name'        => $_SESSION['user']['name'] ?? 'Guest',
            'email'       => $_SESSION['user']['email'] ?? 'guest@example.com',
            'phone'       => $_SESSION['user']['phone'] ?? '08123456789',
            'address'     => $order['address'] ?? '',
            'city'        => $order['city'] ?? '',
            'postal_code' => $order['postal_code'] ?? '',
        ],
    ]);

    $this->view('checkout/payment', [
        'order'      => $order,
        'snap_token' => $snapToken,
    ]);
}

public function notification()
{
    require_once __DIR__ . '/../../vendor/autoload.php';

    \Midtrans\Config::$serverKey = 'MIDTRANS_SERVER_KEY_KAMU';
    \Midtrans\Config::$isProduction = false;

    $notif = new \Midtrans\Notification();

    $orderId = $notif->order_id;
    $status  = $notif->transaction_status;

    $orderModel = $this->model('Order');

    switch ($status) {
        case 'capture':
        case 'settlement':
            $orderModel->updateStatus($orderId, 'paid');
            break;

        case 'pending':
            $orderModel->updateStatus($orderId, 'pending');
            break;

        case 'expire':
            $orderModel->updateStatus($orderId, 'expired');
            break;

        case 'cancel':
            $orderModel->updateStatus($orderId, 'cancelled');
            break;
    }

    http_response_code(200);
    echo 'OK';
}
public function getOngkir()
{
    require_once __DIR__ . '/../helpers/ShippingHelper.php';

    $city = $_POST['city'] ?? '';
    $ongkir = (int) ShippingHelper::getOngkirByCity($city);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ongkir' => $ongkir]);
    exit; // stop eksekusi supaya tidak ikut footer/navbar
}




}
