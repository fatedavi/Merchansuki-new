<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> - Merchansuki</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

<?php include __DIR__ . '/../home/partials/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- IMAGE -->
        <div>
            <div class="bg-white rounded-xl border p-4">
                <img
                    id="mainImage"
                    src="<?= !empty($product['variants'][0]['image'])
                        ? '/assets/images/images_save/' . $product['variants'][0]['image']
                        : '/assets/images/no-image.png' ?>"
                    class="w-full rounded-lg object-contain max-h-[420px]"
                >
            </div>

            <!-- THUMBNAILS -->
            <?php if (!empty($product['variants'])): ?>
                <div class="grid grid-cols-4 gap-3 mt-4">
                    <?php foreach ($product['variants'] as $i => $variant): ?>
                        <div
                            onclick="updateVariantByClick('<?= $variant['id'] ?>','<?= $variant['price'] ?>','<?= $variant['stock'] ?>','<?= $variant['image'] ?>')"
                            class="cursor-pointer border rounded-lg p-2 <?= $i === 0 ? 'border-orange-500' : 'border-gray-200' ?>">
                            <img
                                src="<?= !empty($variant['image'])
                                    ? '/assets/images/images_save/' . $variant['image']
                                    : '/assets/images/no-image.png' ?>"
                                class="w-full h-20 object-contain"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- INFO -->
        <div class="space-y-5">

            <h1 class="text-3xl font-black"><?= htmlspecialchars($product['name']) ?></h1>
            <?php if (!empty($product['category_name'])): ?>
                <span class="inline-block text-sm bg-orange-100 text-orange-600 px-3 py-1 rounded-full font-bold">
                    <?= htmlspecialchars($product['category_name']) ?>
                </span>
            <?php endif; ?>

            <!-- PRICE -->
            <div class="border-y py-4">
                <?php
                    $min = $max = null;
                    if (!empty($product['variants'])) {
                        $prices = array_column($product['variants'], 'price');
                        $min = min($prices);
                        $max = max($prices);
                    }
                ?>
                <div class="text-3xl font-black text-orange-500" id="priceText">
                    <?= $min !== $max
                        ? 'Rp ' . number_format($min, 0, ',', '.') . ' - Rp ' . number_format($max, 0, ',', '.')
                        : 'Rp ' . number_format($min, 0, ',', '.') ?>
                </div>
            </div>

            <!-- FORM ADD TO CART / CHECKOUT -->
            <form method="post" action="/cart/add" id="productForm" class="space-y-4">
                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                <input type="hidden" id="variantIdInput" name="variant_id" value="<?= !empty($product['variants'][0]['id']) ? (int)$product['variants'][0]['id'] : 0 ?>">
                <input type="hidden" id="qtyInput" name="qty" value="1">

                <!-- VARIANT SELECT -->
                <?php if (!empty($product['variants'])): ?>
                    <div>
                        <label class="font-bold mb-2 block">Pilih Variant</label>
                        <select id="variantSelect" onchange="updateVariant(this)"
                            class="w-full border rounded-lg p-3 font-semibold">
                            <?php foreach ($product['variants'] as $variant): ?>
                                <option
                                    value="<?= $variant['id'] ?>"
                                    data-price="<?= $variant['price'] ?>"
                                    data-stock="<?= $variant['stock'] ?>"
                                    data-image="<?= $variant['image'] ?>">
                                    <?= htmlspecialchars($variant['variant_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- STOCK & STATUS -->
                <div class="grid grid-cols-2 gap-4 bg-white border rounded-lg p-4 text-sm">
                    <div>
                        <span class="text-gray-500">Stock</span>
                        <div id="stockText" class="font-bold text-green-600">
                            <?= !empty($product['variants']) ? $product['variants'][0]['stock'].' Item' : '-' ?>
                        </div>
                    </div>
                    <div>
                        <span class="text-gray-500">Status</span>
                        <div class="font-bold"><?= strtoupper($product['status']) ?></div>
                    </div>
                </div>

                <!-- QTY -->
                <div>
                    <label class="font-bold block mb-1">Jumlah</label>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="changeQty(-1)" class="w-10 h-10 bg-gray-200 rounded">−</button>
                        <input id="qty" type="number" value="1" min="1" class="w-16 text-center border rounded-lg font-bold">
                        <button type="button" onclick="changeQty(1)" class="w-10 h-10 bg-gray-200 rounded">+</button>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="space-y-3">
                    <button type="button" onclick="checkoutNow()"
                        class="w-full bg-orange-500 text-white py-3 rounded-lg font-black hover:bg-orange-600">
                        Checkout Sekarang
                    </button>

                    <button type="submit"
                        class="w-full border-2 border-orange-500 text-orange-500 py-3 rounded-lg font-bold hover:bg-orange-50">
                        <i class="fas fa-cart-plus mr-1"></i> Tambah ke Keranjang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DESCRIPTION -->
    <div class="mt-10 bg-white border rounded-xl p-6">
        <h2 class="text-2xl font-black mb-3">Deskripsi Produk</h2>
        <p class="text-gray-600 leading-relaxed">
            <?= nl2br(htmlspecialchars($product['description'] ?? '-')) ?>
        </p>
    </div>

</div>

<?php include __DIR__ . '/../home/partials/footer.php'; ?>

<script>
// --- NAVBAR BURGER BUTTON LOGIC ---
document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (burger && menu) {
        burger.addEventListener('click', e => { e.stopPropagation(); menu.classList.toggle('hidden'); });
        document.addEventListener('click', e => {
            if (!burger.contains(e.target) && !menu.contains(e.target) && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    }
});

// --- IMAGE THUMBNAIL CLICK ---
function updateVariantByClick(id, price, stock, image) {
    document.getElementById('variantIdInput').value = id;
    document.getElementById('priceText').innerText = 'Rp ' + Number(price).toLocaleString('id-ID');
    document.getElementById('stockText').innerText = stock + ' Item';
    document.getElementById('mainImage').src = image ? '/assets/images/images_save/' + image : '/assets/images/no-image.png';
    document.getElementById('variantSelect').value = id;
}

// --- VARIANT SELECT CHANGE ---
function updateVariant(el) {
    const option = el.options[el.selectedIndex];
    document.getElementById('variantIdInput').value = option.value;
    document.getElementById('priceText').innerText = 'Rp ' + Number(option.dataset.price).toLocaleString('id-ID');
    document.getElementById('stockText').innerText = option.dataset.stock + ' Item';
    document.getElementById('mainImage').src = option.dataset.image ? '/assets/images/images_save/' + option.dataset.image : '/assets/images/no-image.png';
}

// --- QTY CHANGE ---
function changeQty(step) {
    const q = document.getElementById('qty');
    let val = parseInt(q.value) || 1;
    val = Math.max(1, val + step);
    q.value = val;
    document.getElementById('qtyInput').value = val;
}

// --- CHECKOUT NOW ---
function checkoutNow() {
    const form = document.getElementById('productForm');
    document.getElementById('qtyInput').value = document.getElementById('qty').value;

    // Submit ke /cart/add, CartController akan redirect ke /cart
    form.action = '/cart/add';
    form.submit();
}

</script>

</body>
</html>
