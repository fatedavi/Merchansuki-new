<?php

class MidtransController extends Controller
{
    public function notification()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        // 🔑 CONFIG
        \Midtrans\Config::$serverKey    = $_ENV['MIDTRANS_SERVER_KEY'];
        \Midtrans\Config::$isProduction = false;

        try {
            $notif = new \Midtrans\Notification();
        } catch (Exception $e) {
            http_response_code(400);
            echo 'Invalid notification';
            return;
        }

        // ORDER-23 → 23
        $midtransOrderId = $notif->order_id ?? '';
        if (strpos($midtransOrderId, 'ORDER-') !== 0) {
            http_response_code(400);
            echo 'Invalid order id';
            return;
        }

        $orderId = (int) str_replace('ORDER-', '', $midtransOrderId);

        $transactionStatus = $notif->transaction_status;
        $paymentType       = $notif->payment_type;
        $fraudStatus       = $notif->fraud_status;

        $newStatus = 'pending';

        switch ($transactionStatus) {
            case 'capture':
                if ($paymentType === 'credit_card') {
                    $newStatus = ($fraudStatus === 'challenge') ? 'challenge' : 'paid';
                } else {
                    $newStatus = 'paid';
                }
                break;

            case 'settlement':
                $newStatus = 'paid';
                break;

            case 'pending':
                $newStatus = 'pending';
                break;

            case 'deny':
            case 'cancel':
                $newStatus = 'failed';
                break;

            case 'expire':
                $newStatus = 'expired';
                break;
        }

        // UPDATE DB
        $this->model('Order')->updateStatus($orderId, $newStatus);

        http_response_code(200);
        echo 'OK';
    }
}
