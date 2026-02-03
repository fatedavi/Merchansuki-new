<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Merchansuki</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<?php include __DIR__ . '/../home/partials/navbar.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-2xl md:text-3xl font-black mb-8 flex items-center gap-3">
        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-500 text-white">
            <i class="fas fa-credit-card"></i>
        </span>
        Checkout
    </h1>

<?php if (empty($cart['items'])): ?>
    <div class="bg-white p-8 rounded-xl shadow text-center">
        <i class="fas fa-shopping-basket text-5xl text-gray-300 mb-4"></i>
        <h2 class="text-xl font-bold mb-2">Keranjang kosong</h2>
        <a href="/" class="inline-block mt-4 px-6 py-3 bg-orange-500 text-white rounded-lg font-semibold">
            Belanja Sekarang
        </a>
    </div>
<?php else: ?>

<form action="/checkout/process" method="POST">
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<!-- LIST ITEM -->
<div class="lg:col-span-2 space-y-4">
<?php foreach ($cart['items'] as $item): ?>
    <div class="bg-white border rounded-xl p-4 flex gap-4 shadow-sm">
        <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
            <?php if (!empty($item['image'])): ?>
                <img src="/assets/images/images_save/<?= htmlspecialchars($item['image']) ?>"
                     class="w-full h-full object-cover">
            <?php endif; ?>
        </div>
        <div class="flex-1">
            <h2 class="font-bold"><?= htmlspecialchars($item['name']) ?></h2>
            <?php if (!empty($item['variant_name'])): ?>
                <p class="text-sm text-gray-500">
                    Varian: <?= htmlspecialchars($item['variant_name']) ?>
                </p>
            <?php endif; ?>
            <p class="text-sm mt-2">
                <?= $item['qty'] ?> × Rp <?= number_format($item['price'],0,',','.') ?>
            </p>
            <p class="font-semibold">
                Subtotal: Rp <?= number_format($item['price'] * $item['qty'],0,',','.') ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
</div>

<!-- RINGKASAN -->
<div class="bg-white border rounded-xl p-5 shadow-sm h-fit space-y-5">

<!-- ALAMAT -->
<div>
    <h2 class="font-bold mb-3 flex items-center gap-2">
        <i class="fas fa-map-marker-alt text-orange-500"></i>
        Alamat Pengiriman
    </h2>

    <textarea name="address" required
        class="w-full border rounded-lg p-3 text-sm mb-2"
        placeholder="Alamat lengkap"><?= htmlspecialchars($profile['address'] ?? '') ?></textarea>

    <input type="text" id="city" name="city" required
        class="w-full border rounded-lg p-3 text-sm mb-2"
        placeholder="Kota"
        value="<?= htmlspecialchars($profile['city'] ?? '') ?>">

    <input type="text" name="province" required
        class="w-full border rounded-lg p-3 text-sm mb-2"
        placeholder="Provinsi"
        value="<?= htmlspecialchars($profile['province'] ?? '') ?>">

    <input type="text" name="postal_code" required
        class="w-full border rounded-lg p-3 text-sm"
        placeholder="Kode Pos"
        value="<?= htmlspecialchars($profile['postal_code'] ?? '') ?>">
</div>

<!-- PEMBAYARAN -->
<div>
    <label class="text-sm font-semibold block mb-1">Metode Pembayaran</label>
    <select name="payment_method" required
        class="w-full border rounded-lg p-3 text-sm">
        <option value="">-- Pilih Pembayaran --</option>
        <option value="transfer">Transfer Bank</option>
        <option value="ewallet">E-Wallet</option>
        <option value="cod">COD</option>
    </select>
</div>

<!-- TOTAL -->
<div class="border-t pt-4 space-y-2 text-sm">
    <div class="flex justify-between">
        <span>Subtotal</span>
        <span id="subtotal" data-value="<?= $cart['total_price'] ?>">
            Rp <?= number_format($cart['total_price'],0,',','.') ?>
        </span>
    </div>
    <div class="flex justify-between">
        <span>Ongkir</span>
        <span id="ongkir-text" data-value="0">
            Rp 0
        </span>
    </div>
    <div class="flex justify-between font-bold text-base text-orange-500">
        <span>Total Bayar</span>
        <span id="total-text">
            Rp <?= number_format($cart['total_price'],0,',','.') ?>
        </span>
    </div>
</div>

<button type="submit"
    onclick="return confirm('Yakin ingin checkout sekarang?')"
    class="w-full bg-orange-500 text-white font-bold py-3 rounded-lg hover:bg-orange-600">
    <i class="fas fa-credit-card mr-2"></i>
    Checkout Sekarang
</button>

<a href="/cart" class="block text-center text-sm text-gray-600">
    &larr; Kembali ke Keranjang
</a>

</div>
</div>
</form>

<?php endif; ?>
</div>

<?php include __DIR__ . '/../home/partials/footer.php'; ?>

<!-- ONGKIR REALTIME DENGAN DEBUG -->
<script>
const cityInput   = document.getElementById('city');
const ongkirText  = document.getElementById('ongkir-text');
const subtotalEl  = document.getElementById('subtotal');
const totalText   = document.getElementById('total-text');

function updateTotal(ongkir) {
    const subtotal = parseInt(subtotalEl.dataset.value) || 0;
    const total    = subtotal + (ongkir || 0);

    ongkirText.dataset.value = ongkir || 0;
    ongkirText.innerText     = 'Rp ' + (ongkir || 0).toLocaleString('id-ID');
    totalText.innerText      = 'Rp ' + total.toLocaleString('id-ID');

    console.log('[DEBUG] subtotal:', subtotal, 'ongkir:', ongkir || 0, 'total:', total);
}

function fetchOngkir(kota) {
    if (!kota.trim()) {
        console.log('[DEBUG] Kota kosong, ongkir = 0');
        updateTotal(0);
        return;
    }

    console.log('[DEBUG] Mengirim request ongkir untuk kota:', kota);

    fetch('/checkout/getOngkir', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'city=' + encodeURIComponent(kota)
    })
    .then(res => res.json())
    .then(data => {
        console.log('[DEBUG] Response ongkir:', data);
        updateTotal(parseInt(data.ongkir));
    })
    .catch(err => console.error('[DEBUG] Error fetch ongkir:', err));
}

// 🔥 HITUNG SAAT PAGE LOAD
if (cityInput.value.trim() !== '') {
    fetchOngkir(cityInput.value);
}

// 🔁 HITUNG SAAT KOTA DIUBAH
cityInput.addEventListener('change', function () {
    fetchOngkir(this.value);
});
</script>
</body>
</html>
