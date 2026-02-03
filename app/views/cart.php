<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Merchansuki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

<?php include __DIR__ . '/home/partials/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-black mb-6 flex items-center gap-3">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-500 text-white">
            <i class="fas fa-shopping-cart"></i>
        </span>
        Keranjang Belanja
    </h1>

    <?php if (empty($cart['items'])): ?>
        <div class="bg-white border rounded-xl p-8 text-center shadow-sm">
            <div class="text-5xl mb-4 text-gray-300">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <h2 class="text-xl font-bold mb-2">Keranjang kamu masih kosong</h2>
            <p class="text-gray-500 mb-6">
                Yuk mulai belanja dakimakura favoritmu dan tambahkan ke keranjang!
            </p>
            <a href="/"
               class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-orange-500 text-white font-semibold hover:bg-orange-600 transition shadow-md">
                <i class="fas fa-store mr-2"></i> Lihat Koleksi Produk
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- LIST ITEM -->
            <div class="lg:col-span-2 space-y-4">
                <?php foreach ($cart['items'] as $item): ?>
                    <div class="bg-white border rounded-xl p-4 md:p-5 flex gap-4 shadow-sm">
                        <div class="w-24 h-24 md:w-28 md:h-28 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden">
                            <?php if (!empty($item['image'])): ?>
                                <img src="/assets/images/images_save/<?= htmlspecialchars($item['image']) ?>"
                                     alt="<?= htmlspecialchars($item['name']) ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fas fa-image text-gray-300 text-3xl"></i>
                            <?php endif; ?>
                        </div>

                        <div class="flex-1 flex flex-col">
                            <div class="flex justify-between gap-3">
                                <div>
                                    <h2 class="text-base md:text-lg font-bold text-gray-900">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </h2>
                                    <?php if (!empty($item['variant_name'])): ?>
                                        <p class="text-xs md:text-sm text-gray-500 mt-1">
                                            Varian: <?= htmlspecialchars($item['variant_name']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <form method="post" action="/cart/remove"
                                      onsubmit="return confirm('Hapus item ini dari keranjang?');">
                                    <input type="hidden" name="variant_id" value="<?= (int) $item['variant_id'] ?>">
                                    <button type="submit"
                                            class="text-red-500 hover:text-red-600 text-sm md:text-base">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="flex flex-col md:flex-row md:items-center justify-between mt-3 gap-3">
                                <form method="post" action="/cart/update" class="flex items-center gap-2">
                                    <input type="hidden" name="variant_id" value="<?= (int) $item['variant_id'] ?>">
                                    <span class="text-xs text-gray-500">Jumlah</span>
                                    <input type="number"
                                           name="qty"
                                           min="1"
                                           value="<?= (int) $item['qty'] ?>"
                                           class="w-16 border rounded-lg px-2 py-1 text-center text-sm">
                                    <button type="submit"
                                            class="px-3 py-1 rounded-lg border text-xs md:text-sm font-semibold text-gray-700 hover:bg-gray-100">
                                        Update
                                    </button>
                                </form>

                                <div class="text-right">
                                    <div class="text-sm text-gray-500">Harga</div>
                                    <div class="font-bold text-orange-500">
                                        Rp <?= number_format($item['price'], 0, ',', '.') ?>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Subtotal:
                                        <span class="font-semibold text-gray-800">
                                            Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- RINGKASAN -->
            <div class="bg-white border rounded-xl p-5 shadow-sm h-fit">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-receipt text-orange-500"></i>
                    Ringkasan Belanja
                </h2>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Item</span>
                        <span class="font-semibold">
                            <?= (int) ($cart['total_quantity'] ?? 0) ?> pcs
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harga</span>
                        <span class="font-bold text-orange-500 text-base">
                            Rp <?= number_format($cart['total_price'] ?? 0, 0, ',', '.') ?>
                        </span>
                    </div>
                </div>

                <div class="mt-5 space-y-3">
                    <form method="post" action="/cart/clear"
                          onsubmit="return confirm('Yakin ingin mengosongkan keranjang?');">
                        <button type="submit"
                                class="w-full border border-red-200 text-red-600 font-semibold py-2.5 rounded-lg text-sm hover:bg-red-50 transition">
                            <i class="fas fa-trash-alt mr-1"></i> Kosongkan Keranjang
                        </button>
                    </form>

              <a href="/checkout"
        class="w-full block text-center bg-orange-500 text-white font-bold py-3 rounded-lg text-sm hover:bg-orange-600 transition shadow-md">
            <i class="fas fa-credit-card mr-2"></i>
            Checkout
        </a>


                    <a href="/"
                       class="block text-center text-sm text-gray-600 hover:text-gray-900 mt-1">
                        &larr; Lanjut belanja
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/home/partials/footer.php'; ?>

<script>
// Burger menu navbar (copy dari halaman lain supaya konsisten)
document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (burger && menu) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });
        document.addEventListener('click', function(e) {
            if (!burger.contains(e.target) && !menu.contains(e.target) && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    }
});
</script>

</body>
</html>