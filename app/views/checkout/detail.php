<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Order #<?= $order['id']; ?> - Merchansuki</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<?php include __DIR__ . '/../home/partials/navbar.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-10">

    <h1 class="text-2xl md:text-3xl font-bold mb-6 flex items-center gap-3">
        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-500 text-white">
            <i class="fas fa-receipt"></i>
        </span>
        Order #<?= $order['id']; ?>
    </h1>

    <!-- ORDER ITEMS -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Detail Produk</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Produk</th>
                        <th class="px-4 py-2 border">Varian</th>
                        <th class="px-4 py-2 border">Qty</th>
                        <th class="px-4 py-2 border">Harga</th>
                        <th class="px-4 py-2 border">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <?php $subtotal = $item['price'] * $item['qty']; ?>
                    <tr class="border-t">
                        <td class="px-4 py-2"><?= htmlspecialchars($item['product_name']); ?></td>
                        <td class="px-4 py-2">
                            <?= !empty($item['variant_name']) ? htmlspecialchars($item['variant_name']) : '-' ?>
                        </td>
                        <td class="px-4 py-2"><?= $item['qty']; ?></td>
                        <td class="px-4 py-2">Rp <?= number_format($item['price'],0,',','.'); ?></td>
                        <td class="px-4 py-2">Rp <?= number_format($subtotal,0,',','.'); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ORDER SUMMARY -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Order</h2>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span>Subtotal Barang</span>
                <span>Rp <?= number_format(array_reduce($order['items'], fn($sum,$i)=>$sum+($i['price']*$i['qty']),0),0,',','.'); ?></span>
            </div>
            <div class="flex justify-between">
                <span>Ongkir</span>
                <span>Rp <?= number_format($order['shipping_cost'],0,',','.'); ?></span>
            </div>
            <div class="flex justify-between font-bold text-base text-orange-500 border-t pt-2">
                <span>Total Bayar</span>
                <span>Rp <?= number_format($order['total_price'],0,',','.'); ?></span>
            </div>
            <div class="mt-2">
                <span class="font-semibold">Status:</span> <?= ucfirst($order['status']); ?>
            </div>
        </div>
    </div>

    <!-- SHIPPING & PAYMENT -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Alamat & Pembayaran</h2>
        <div class="space-y-2 text-sm">
            <div><strong>Kota:</strong> <?= htmlspecialchars($order['city'] ?? '-'); ?></div>
            <div><strong>Provinsi:</strong> <?= htmlspecialchars($order['province'] ?? '-'); ?></div>
            <div><strong>Kode Pos:</strong> <?= htmlspecialchars($order['postal_code'] ?? '-'); ?></div>
            <div><strong>Metode Pembayaran:</strong> <?= htmlspecialchars(strtoupper($order['payment'] ?? '-')); ?></div>

        </div>
    </div>

    <a href="/"
       class="inline-block mt-4 px-6 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600">
       &larr; Kembali ke Beranda
    </a>

</div>

<?php include __DIR__ . '/../home/partials/footer.php'; ?>
</body>
</html>
