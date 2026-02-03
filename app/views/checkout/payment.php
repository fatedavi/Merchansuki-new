<?php
$order = $data['order'];
$snapToken = $data['snap_token'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan #<?= $order['id'] ?> - Merchansuki</title>
    <link rel="preconnect" href="https://app.sandbox.midtrans.com">
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="Mid-client-6mAxHeOww8g1AUs5"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<?php include __DIR__ . '/../home/partials/navbar.php'; ?>

<div class="max-w-3xl mx-auto px-4 py-8 md:py-12">
    <h1 class="text-2xl md:text-3xl font-black mb-8 flex items-center gap-3">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-500 text-white shadow-md">
            <i class="fas fa-credit-card"></i>
        </span>
        Konfirmasi Pembayaran
    </h1>

    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between border-b pb-6 mb-6 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Nomor Pesanan</p>
                    <h2 class="text-xl font-bold text-gray-900">#<?= $order['id'] ?></h2>
                </div>
                <div class="md:text-right">
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Total Pembayaran</p>
                    <h2 class="text-2xl font-black text-orange-500">
                        Rp <?= number_format($order['total_price'],0,',','.') ?>
                    </h2>
                </div>
            </div>

            <div class="space-y-4 text-sm">
                <div class="flex items-start gap-3">
                    <i class="fas fa-wallet mt-1 text-gray-400"></i>
                    <div>
                        <p class="font-bold text-gray-700">Metode Pembayaran</p>
                        <p class="text-gray-600 uppercase"><?= strtoupper($order['payment'] ?? '-') ?></p>
                    </div>
                </div>
                <div class="flex items-start gap-3 border-t pt-4">
                    <i class="fas fa-map-marker-alt mt-1 text-gray-400"></i>
                    <div>
                        <p class="font-bold text-gray-700">Alamat Pengiriman</p>
                        <p class="text-gray-600 leading-relaxed">
                            <?= htmlspecialchars($order['address'] ?? '-') ?>, <?= htmlspecialchars($order['city'] ?? '-') ?>, 
                            <?= htmlspecialchars($order['province'] ?? '-') ?>, <?= htmlspecialchars($order['postal_code'] ?? '-') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-list text-orange-500"></i>
                Ringkasan Pesanan
            </h3>
            
            <div class="overflow-hidden border rounded-lg">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 border-b italic">
                            <th class="p-3 text-left font-semibold">Produk</th>
                            <th class="p-3 text-center font-semibold">Qty</th>
                            <th class="p-3 text-right font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td class="p-3">
                                <div class="font-bold text-gray-900"><?= htmlspecialchars($item['product_name']) ?></div>
                                <div class="text-xs text-gray-500"><?= htmlspecialchars($item['variant_name'] ?? '-') ?></div>
                            </td>
                            <td class="p-3 text-center font-medium"><?= $item['qty'] ?></td>
                            <td class="p-3 text-right font-bold text-gray-800">
                                Rp <?= number_format($item['subtotal'],0,',','.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php $itemsSubtotal = array_reduce($order['items'], fn($sum,$i)=>$sum + ($i['subtotal'] ?? ($i['price']*$i['qty'])), 0); ?>
            <div class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal Barang</span>
                    <span>Rp <?= number_format($itemsSubtotal,0,',','.'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Ongkir</span>
                    <span>Rp <?= number_format($order['shipping_cost'],0,',','.'); ?></span>
                </div>
                <div class="flex justify-between font-bold text-base text-orange-500 border-t pt-2">
                    <span>Total Bayar</span>
                    <span>Rp <?= number_format($order['total_price'],0,',','.'); ?></span>
                </div>
            </div>

            <div class="mt-8">
                <button id="pay-button" class="w-full px-6 py-4 bg-orange-500 text-white rounded-xl font-black uppercase tracking-widest hover:bg-orange-600 transition shadow-lg flex items-center justify-center gap-3">
                    <i class="fas fa-lock"></i>
                    Bayar Sekarang
                </button>
                <p class="text-center text-[10px] text-gray-400 mt-4 uppercase tracking-widest">
                    <i class="fas fa-shield-alt mr-1"></i> Transaksi Aman & Terenkripsi
                </p>
            </div>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="/" class="text-sm text-gray-500 hover:text-orange-600 font-semibold transition">
            &larr; Kembali ke Beranda
        </a>
    </div>
</div>

<?php include __DIR__ . '/../home/partials/footer.php'; ?>


<script>
const payButton = document.getElementById('pay-button');

payButton.addEventListener('click', function () {
    payButton.disabled = true;
    payButton.innerHTML = `
        <i class="fas fa-spinner fa-spin"></i>
        Memuat Pembayaran...
    `;

    snap.pay('<?= $snapToken ?>', {
        onSuccess: function(){
            window.location.href = "/checkout/detail/<?= $order['id'] ?>";
        },
        onPending: function(){
            window.location.href = "/checkout/detail/<?= $order['id'] ?>";
        },
        onError: function(){
            alert("Pembayaran gagal!");
            payButton.disabled = false;
            payButton.innerHTML = `
                <i class="fas fa-lock"></i>
                Bayar Sekarang
            `;
        }
    });
});
</script>


</body>
</html>