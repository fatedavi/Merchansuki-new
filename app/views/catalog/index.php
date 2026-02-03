<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Produk - Merchansuki</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Tambahan CSS kecil untuk transisi halus */
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <?php include __DIR__ . '/../home/partials/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-8 flex-grow w-full">
        
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-gray-900">Katalog Produk</h1>
                <p class="text-gray-500 text-sm mt-1">Temukan merchandise terbaik pilihanmu</p>
            </div>
            
            <button onclick="toggleSidebar()" class="lg:hidden bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md flex items-center gap-2">
                <i class="fas fa-filter"></i> Filter & Cari
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 relative">
            
            <div id="sidebarFilter" class="hidden lg:block lg:col-span-1 z-40">
                <div class="bg-white border rounded-xl p-5 sticky top-24 shadow-sm">
                    
                    <div class="flex justify-between items-center mb-4 lg:hidden border-b pb-2">
                        <span class="font-bold text-lg">Filter Produk</span>
                        <button onclick="toggleSidebar()" class="text-gray-500 hover:text-red-500 text-2xl">&times;</button>
                    </div>

                    <h2 class="text-xl font-bold border-b pb-3 mb-4 hidden lg:block">Filter</h2>

                    <div class="space-y-5">
                        <div>
                            <label class="font-bold text-sm block mb-2 text-gray-700">Cari Produk</label>
                            <div class="relative">
                                <input type="text" id="searchInput" 
                                    placeholder="Nama hoodie, kaos..." 
                                    value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 outline-none pl-9">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
                            </div>
                        </div>

                        <div>
                            <label class="font-bold text-sm block mb-2 text-gray-700">Kategori</label>
                            <select id="categorySelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 outline-none bg-white">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($filters['category'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-sm block mb-2 text-gray-700">Rentang Harga</label>
                            <div class="flex items-center gap-2 mb-2">
                                <input type="number" id="priceMinInput" placeholder="Min"
                                    value="<?= $filters['price_min'] ?>"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <span class="text-gray-400">-</span>
                                <input type="number" id="priceMaxInput" placeholder="Max"
                                    value="<?= $filters['price_max'] ?>"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="font-bold text-sm block mb-2 text-gray-700">Urutkan</label>
                            <select id="sortSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                                <option value="newest" <?= ($filters['sort'] === 'newest') ? 'selected' : '' ?>>Terbaru</option>
                                <option value="oldest" <?= ($filters['sort'] === 'oldest') ? 'selected' : '' ?>>Tertua</option>
                                <option value="price_asc" <?= ($filters['sort'] === 'price_asc') ? 'selected' : '' ?>>Harga Terendah</option>
                                <option value="price_desc" <?= ($filters['sort'] === 'price_desc') ? 'selected' : '' ?>>Harga Tertinggi</option>
                            </select>
                        </div>

                        <button onclick="resetFilters()" class="w-full text-center border border-orange-500 text-orange-500 py-2 rounded-lg text-sm font-bold hover:bg-orange-50 transition">
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 w-full">
                <div class="mb-4 flex justify-between items-center text-sm text-gray-600">
                    <span>Menampilkan <strong id="productCount" class="text-gray-900"><?= count($products) ?></strong> produk</span>
                </div>

                <div id="productsContainer">
                    <?php if (empty($products)): ?>
                        <div class="bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center">
                            <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                                <i class="fas fa-box-open text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Produk tidak ditemukan</h3>
                            <p class="text-gray-500 mb-6">Coba ubah kata kunci atau reset filter.</p>
                            <button onclick="resetFilters()" class="bg-orange-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-orange-600 transition shadow-lg shadow-orange-500/30">
                                Reset Filter
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6" id="productsList">
                            <?php foreach ($products as $product): ?>
                                <?php 
                                    // Hitung logic di PHP dulu untuk data attribute JS
                                    $minP = $product['min_price'];
                                    $maxP = $product['max_price'];
                                    // Created date simulation (if not exists in DB, use ID as proxy)
                                    $created = isset($product['created_at']) ? strtotime($product['created_at']) : $product['id'];
                                ?>
                                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-xl transition duration-300 group product-card"
                                     data-created="<?= $created ?>"
                                     data-price-min="<?= $minP ?>"
                                     data-price-max="<?= $maxP ?>">
                                     
                                    <div class="relative bg-gray-100 aspect-square overflow-hidden">
                                        <?php 
                                            $image = !empty($product['image']) 
                                                ? '/assets/images/images_save/' . $product['image']
                                                : '/assets/images/no-image.png';
                                        ?>
                                        <img src="<?= $image ?>" 
                                             alt="<?= htmlspecialchars($product['name']) ?>"
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        
                                        <?php if (!empty($product['rating']) && $product['rating'] > 0): ?>
                                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm text-orange-500 px-2 py-1 rounded-md text-xs font-bold shadow-sm flex items-center gap-1">
                                                <i class="fas fa-star"></i> <?= number_format($product['rating'], 1) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="p-3 md:p-4">
                                        <?php if (!empty($product['category_name'])): ?>
                                            <span class="inline-block text-[10px] md:text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded mb-2 font-medium" data-id="<?= $product['category_id'] ?>">
                                                <?= htmlspecialchars($product['category_name']) ?>
                                            </span>
                                        <?php endif; ?>

                                        <h3 class="font-bold text-sm md:text-base text-gray-900 mb-1 line-clamp-2 h-10 md:h-12 leading-tight">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </h3>

                                        <div class="mb-3">
                                            <?php if ($minP != $maxP): ?>
                                                <p class="text-orange-600 font-black text-sm md:text-lg">
                                                    Rp <?= number_format($minP, 0, ',', '.') ?>+
                                                </p>
                                            <?php else: ?>
                                                <p class="text-orange-600 font-black text-sm md:text-lg">
                                                    Rp <?= number_format($minP, 0, ',', '.') ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>

                                        <?php 
                                            $totalStock = 0;
                                            if(!empty($product['variants'])) {
                                                foreach ($product['variants'] as $v) $totalStock += $v['stock'];
                                            }
                                        ?>
                                        
                                        <div class="flex items-center justify-between mt-auto">
                                            <?php if ($totalStock > 0): ?>
                                                <span class="text-[10px] md:text-xs text-green-600 font-medium">
                                                    <i class="fas fa-check"></i> Ready
                                                </span>
                                            <?php else: ?>
                                                <span class="text-[10px] md:text-xs text-red-500 font-medium">
                                                    Habis
                                                </span>
                                            <?php endif; ?>
                                            
                                            <a href="/products/detail/<?= $product['id'] ?>" class="bg-gray-900 hover:bg-orange-600 text-white rounded-full w-8 h-8 flex items-center justify-center transition">
                                                <i class="fas fa-arrow-right text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../home/partials/footer.php'; ?>


    <script>
        // --- NAVBAR BURGER BUTTON LOGIC (match navbar.php) ---
        document.addEventListener('DOMContentLoaded', function() {
            const burger = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if (burger && menu) {
                burger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });
                // Optional: close menu if click outside
                document.addEventListener('click', function(e) {
                    if (!burger.contains(e.target) && !menu.contains(e.target) && !menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });

        /**
         * 2. SCRIPT SIDEBAR MOBILE
         */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarFilter');
            
            // Logika untuk menampilkan sidebar seperti Modal/Overlay di Mobile
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('fixed', 'inset-0', 'bg-black/50', 'z-50', 'flex', 'items-center', 'justify-center', 'p-4');
                // Bungkus konten dalam div putih jika belum (agar rapi)
                // Di sini kita asumsikan div anak pertama adalah konten putihnya
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('fixed', 'inset-0', 'bg-black/50', 'z-50', 'flex', 'items-center', 'justify-center', 'p-4');
            }
        }

        /**
         * 3. SCRIPT FILTER PRODUK
         */
        function filterCatalogProducts() {
            // Ambil Value
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const categoryVal = document.getElementById('categorySelect').value;
            const priceMin = parseInt(document.getElementById('priceMinInput').value) || 0;
            const priceMax = parseInt(document.getElementById('priceMaxInput').value) || Infinity;
            const sortVal = document.getElementById('sortSelect').value;

            const grid = document.getElementById('productsList');
            if (!grid) return; // Jika tidak ada produk sama sekali

            // Konversi NodeList ke Array
            let cards = Array.from(grid.children);

            let visibleCount = 0;
            let productsArr = [];

            cards.forEach(card => {
                // Ambil data dari elemen (DOM parsing atau Dataset)
                const name = (card.querySelector('h3')?.textContent || '').toLowerCase();
                const categoryId = card.querySelector('span[data-id]')?.getAttribute('data-id') || '';
                
                // Mengambil harga dari dataset atribut yang kita tambahkan di HTML PHP diatas
                // Ini lebih akurat daripada parsing text Rp...
                const itemMinPrice = parseInt(card.dataset.priceMin) || 0;
                const itemMaxPrice = parseInt(card.dataset.priceMax) || 0;
                const createdDate = parseInt(card.dataset.created) || 0;

                // Logika Filter
                let show = true;

                // 1. Search
                if (searchTerm && !name.includes(searchTerm)) show = false;
                
                // 2. Category
                if (categoryVal && categoryVal !== '' && categoryId !== categoryVal) show = false;
                
                // 3. Price
                // Logika: Tampilkan jika range harga produk beririsan dengan filter
                // Tapi simplenya: Jika harga terendah produk > max filter -> hide
                // Atau harga tertinggi produk < min filter -> hide
                if (priceMax !== Infinity && itemMinPrice > priceMax) show = false;
                if (itemMaxPrice < priceMin && itemMaxPrice !== 0) show = false; // itemMaxPrice bisa 0 kalau single price, handle logic sesuai kebutuhan

                // Terapkan Display
                card.style.display = show ? '' : 'none';
                
                if (show) {
                    visibleCount++;
                    // Simpan ref ke array untuk sorting
                    productsArr.push({
                        element: card,
                        price: itemMinPrice,
                        created: createdDate
                    });
                }
            });

            // Sorting Logic
            if (sortVal === 'price_asc') {
                productsArr.sort((a, b) => a.price - b.price);
            } else if (sortVal === 'price_desc') {
                productsArr.sort((a, b) => b.price - a.price);
            } else if (sortVal === 'oldest') {
                productsArr.sort((a, b) => a.created - b.created);
            } else {
                // Newest (Default)
                productsArr.sort((a, b) => b.created - a.created);
            }

            // Re-append elements in sorted order
            productsArr.forEach(item => {
                grid.appendChild(item.element);
            });

            // Update Counter
            const countEl = document.getElementById('productCount');
            if(countEl) countEl.textContent = visibleCount;
        }

        // Event Listeners
        document.getElementById('searchInput').addEventListener('input', filterCatalogProducts);
        document.getElementById('categorySelect').addEventListener('change', filterCatalogProducts);
        document.getElementById('priceMinInput').addEventListener('input', filterCatalogProducts);
        document.getElementById('priceMaxInput').addEventListener('input', filterCatalogProducts);
        document.getElementById('sortSelect').addEventListener('change', filterCatalogProducts);

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categorySelect').value = '';
            document.getElementById('priceMinInput').value = '';
            document.getElementById('priceMaxInput').value = '';
            document.getElementById('sortSelect').value = 'newest';
            filterCatalogProducts();
        }
    </script>
</body>
</html>