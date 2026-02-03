<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Admin DakiShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8b5cf6',
                        secondary: '#a78bfa',
                        accent: '#c084fc',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glow-effect {
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
        }

        .glow-effect:hover {
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.8);
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1e1b4b;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #8b5cf6, #a78bfa);
            border-radius: 10px;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: rgba(139, 92, 246, 0.1);
            transform: scale(1.01);
        }

        .modal-backdrop {
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content {
            animation: slideUp 0.3s ease-out;
        }

        @media (min-width: 640px) {
            .modal-content {
                animation: slideIn 0.3s ease-out;
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-white">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 glass-effect border-b border-purple-500/30 shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <a href="/admin/dashboard" class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center glow-effect hover:scale-110 transition-transform">
                        <i class="fas fa-arrow-left text-white"></i>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                            Product Management
                        </h1>
                        <p class="text-purple-300 text-xs sm:text-sm">Kelola Produk Dakimakura</p>
                    </div>
                </div>
                
                <a href="/admin/dashboard" class="glass-effect px-4 py-2 rounded-full text-sm font-medium hover:bg-white/10 transition-all flex items-center gap-2">
                    <i class="fas fa-home text-purple-400"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 sm:px-6 py-8 lg:py-12">
      

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 slide-in">
            <div class="glass-effect rounded-xl p-4 sm:p-6 border border-purple-500/30">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center glow-effect">
                        <i class="fas fa-box text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-300 text-xs">Total</p>
                        <p class="text-xl sm:text-2xl font-bold"><?= count($products) ?></p>
                    </div>
                </div>
            </div>

            <div class="glass-effect rounded-xl p-4 sm:p-6 border border-green-500/30">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center glow-effect">
                        <i class="fas fa-check-circle text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-300 text-xs">Active</p>
                        <p class="text-xl sm:text-2xl font-bold">
                            <?= count(array_filter($products, fn($p) => $p['status'] === 'active')) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="glass-effect rounded-xl p-4 sm:p-6 border border-yellow-500/30">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center glow-effect">
                        <i class="fas fa-star text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-300 text-xs">Highlight</p>
                        <p class="text-xl sm:text-2xl font-bold">
                            <?= count(array_filter($products, fn($p) => $p['highlight'] == 1)) ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php
            $totalVariant = 0;

            foreach ($products as $product) {
                if (!empty($product['variants'])) {
                    $totalVariant += count($product['variants']);
                }
            }
            ?>

<div class="glass-effect rounded-xl p-4 sm:p-6 border border-purple-500/30">
    <div class="flex items-center gap-3 mb-2">
        <div class="w-10 h-10 sm:w-12 sm:h-12
                    bg-gradient-to-br from-purple-500 to-indigo-500
                    rounded-lg flex items-center justify-center glow-effect">
            <i class="fas fa-layer-group text-white text-lg sm:text-xl"></i>
        </div>
        <div>
            <p class="text-purple-300 text-xs">Total Variant</p>
            <p class="text-xl sm:text-2xl font-bold">
                <?= $totalVariant ?>
            </p>
        </div>
    </div>
</div>

        </div>

<!-- Search & Filter Bar -->
<div class="glass-effect rounded-xl p-4 sm:p-6 mb-6 border border-purple-500/30 slide-in" style="animation-delay: 0.1s;">
    <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">

        <!-- Search -->
        <div class="relative w-full lg:w-80">
            <input 
                type="text" 
                id="searchInput"
                placeholder="Cari produk..." 
                class="w-full pl-10 pr-4 py-3 glass-effect rounded-lg text-white placeholder-purple-300 focus:outline-none border border-purple-500/30 focus:border-purple-500 transition-all text-sm"
            >
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-purple-400"></i>
        </div>

        <!-- Filter & Actions -->
        <div class="flex flex-wrap sm:flex-nowrap gap-2 sm:gap-3 w-full lg:w-auto">

            <!-- Status Filter -->
            <select
                id="statusFilter"
                class="flex-1 sm:flex-none bg-[#1a0b2e] glass-effect px-4 py-3 rounded-lg text-white border border-purple-500/30 focus:outline-none focus:border-purple-500 transition-all text-sm cursor-pointer"
            >
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="preorder">Pre-Order</option>
            </select>

            <!-- Add Harga Grosir -->

        <div class="relative z-[9999] pointer-events-auto">
            <button
                type="button"
                onclick="openCategoryModal()"
                class="px-4 py-2 bg-purple-600 text-white rounded-xl">
                Add Category
            </button>
        </div>
        <div class="relative z-[9999] pointer-events-auto">

            <button onclick="openCategoryListModal()" 
        class="px-4 py-2 bg-purple-600 text-white text-xs font-bold rounded-lg hover:bg-purple-700 transition">
    List Categories
</button>
        </div>


            <a href="/admin/variant-wholesale"
            class="flex-1 sm:flex-none border border-emerald-500/50 hover:bg-emerald-500/10 
                    text-emerald-400 px-4 sm:px-5 py-3 rounded-lg font-semibold transition-all 
                    flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                <i class="fas fa-tags"></i>
                <span>Harga Grosir</span>
            </a>

            <!-- Add Product -->
            <button
                onclick="openAddModal()"
                class="flex-1 sm:flex-none bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 px-4 sm:px-6 py-3 rounded-lg font-semibold transition-all glow-effect flex items-center justify-center gap-2 text-sm whitespace-nowrap text-white"
            >
                <i class="fas fa-plus"></i>
                <span>Add Product</span>
            </button>
            

        </div>
    </div>
</div>


        <!-- Products Table -->
        <div class="glass-effect rounded-xl border border-purple-500/30 overflow-hidden slide-in" style="animation-delay: 0.2s;">
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full border-collapse border border-purple-500 text-sm">
    <thead>
                <tr class="bg-purple-900 text-purple-200 uppercase text-xs font-semibold">
            <th class="px-4 py-2 border border-purple-500">Product</th>
            <th class="px-4 py-2 border border-purple-500">Variant Name</th>
            <th class="px-4 py-2 border border-purple-500">Category</th>
            <th class="px-4 py-2 border border-purple-500">Status</th>
           
            <th class="px-4 py-2 border border-purple-500">Actions</th>
        </tr>

    </thead>
    
<tbody>
<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <tr
            class="border border-purple-500 align-top product-row"
            data-name="<?= strtolower($product['name']) ?>"
            data-status="<?= $product['status'] ?>"
        >



            <!-- PRODUCT -->
            <td class="px-4 py-2 border border-purple-500 align-top">
                <h3 class="font-semibold text-white">
                    <?= htmlspecialchars($product['name']) ?>
                </h3>

                <p class="text-xs text-purple-300 line-clamp-2">
                    <?= htmlspecialchars($product['description'] ?? '-') ?>
                </p>

                <?php if (!empty($product['highlight'])): ?>
                    <span class="inline-block mt-1 px-2 py-0.5 bg-yellow-500/20 text-yellow-400 text-xs rounded-full">
                        <i class="fas fa-star"></i> Featured
                    </span>
                <?php endif; ?>
            </td>

            <!-- VARIANTS (IMAGE + NAME + PRICE + STOCK) -->
     <td class="px-4 py-2 border border-purple-500 align-top">
    <?php if (!empty($product['variants'])): ?>
        <?php foreach ($product['variants'] as $variant): ?>
            <div class="flex items-center gap-4 p-2 mb-2 rounded
                        bg-purple-900/10 border border-purple-500/20">

                <!-- IMAGE -->
                <?php if (!empty($variant['image'])): ?>
                    <img
                        src="/assets/images/images_save/<?= htmlspecialchars($variant['image']) ?>"
                        class="w-12 h-12 rounded-md object-cover border border-purple-500/30"
                    >
                <?php else: ?>
                    <div class="w-12 h-12 flex items-center justify-center
                                rounded-md border border-purple-500/30
                                text-[10px] text-purple-300 text-center">
                        No Image
                    </div>
                <?php endif; ?>

                <!-- NAME -->
                <div class="flex-1">
                    <p class="text-sm font-semibold text-white">
                        <?= htmlspecialchars($variant['variant_name']) ?>
                    </p>
                </div>

                <!-- PRICE -->
                <div class="min-w-[120px] text-right">
                    <p class="text-xs text-purple-300">Price</p>
                    <p class="font-semibold text-purple-400">
                        Rp <?= number_format((int)$variant['price'], 0, ',', '.') ?>
                    </p>
                </div>

                <!-- STOCK -->
                <div class="min-w-[90px] text-center">
                    <p class="text-xs text-purple-300">Stock</p>
                    <p class="font-semibold text-white">
                        <?= (int)$variant['stock'] ?> pcs
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <span class="italic text-purple-300">Belum ada varian</span>
    <?php endif; ?>
</td>
      <td class="px-4 py-2 text-center border border-purple-500">
            <?= htmlspecialchars($product['category_name'] ?? '-') ?>
        </td>
                    <td class="px-4 py-2 text-center border border-purple-500">
                <?php
                    $statusColors = [
                        'active' => 'from-green-500 to-emerald-500',
                        'inactive' => 'from-red-500 to-rose-500',
                        'preorder' => 'from-blue-500 to-indigo-500'
                    ];
                ?>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r <?= $statusColors[$product['status']] ?>">
                    <?= ucfirst($product['status']) ?>
                </span>
            </td>

            <!-- ACTION -->
            <td class="px-4 py-2 border border-purple-500">
                <div class="flex justify-center gap-2">
                    <button
                        onclick='openEditModal(<?= json_encode($product) ?>)'
                        class="w-9 h-9 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg flex items-center justify-center"
                    >
                        <i class="fas fa-edit text-blue-400"></i>
                    </button>

                    <a
                        href="/admin/products/delete/<?= $product['id'] ?>"
                        onclick="return confirm('Yakin hapus produk ini?')"
                        class="w-9 h-9 bg-red-500/20 hover:bg-red-500/30 rounded-lg flex items-center justify-center"
                    >
                        <i class="fas fa-trash text-red-400"></i>
                    </a>
                   
                </div>
            </td>

        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="text-center py-10 text-purple-300">
            Belum ada produk
        </td>
    </tr>
<?php endif; ?>


</tbody>
</table>
</div>

       
            

            <!-- Mobile Cards -->
<div class="lg:hidden space-y-4 p-4" id="productCards">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="glass-effect rounded-xl p-4 border border-purple-500/30"
                 data-name="<?= strtolower($product['name']) ?>"
                 data-status="<?= $product['status'] ?>">

                <!-- Header: Product Info -->
                <div class="flex gap-3 mb-3">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm mb-1 line-clamp-1">
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>

                        <p class="text-xs text-purple-300 line-clamp-2 mb-2">
                            <?= htmlspecialchars($product['description'] ?? '-') ?>
                        </p>

                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-1 rounded-full text-[10px] uppercase font-bold border 
                                <?= $product['status'] === 'active'
                                    ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30'
                                    : 'bg-rose-500/20 text-rose-400 border-rose-500/30' ?>">
                                <?= $product['status'] ?>
                            </span>

                            <?php if (!empty($product['highlight'])): ?>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-yellow-500/20 text-yellow-400 text-xs rounded-full">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- VARIANTS -->
                <?php if (!empty($product['variants'])): ?>
                    <?php foreach ($product['variants'] as $variant): ?>
                        <div class="grid grid-cols-4 gap-2 mb-2 text-xs bg-purple-900/5 rounded p-2 border border-purple-500/20">

                            <!-- IMAGE -->
                            <div class="flex items-center justify-center">
                                <?php if (!empty($variant['image'])): ?>
                                    <img
                                        src="/assets/images/images_save/<?= htmlspecialchars($variant['image']) ?>"
                                        class="w-12 h-12 rounded-md object-cover border border-purple-500/30"
                                        onerror="this.style.display='none'"
                                    >
                                <?php else: ?>
                                    <span class="text-[10px] text-purple-300 text-center">
                                        Tidak ada<br>gambar
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- VARIANT NAME -->
                            <div class="text-center">
                                <p class="text-purple-300 mb-1">Variant</p>
                                <p class="font-bold text-purple-400">
                                    <?= htmlspecialchars($variant['variant_name']) ?>
                                </p>
                            </div>

                            <!-- PRICE -->
                            <div class="text-center">
                                <p class="text-purple-300 mb-1">Price</p>
                                <p class="font-bold text-purple-400">
                                    Rp <?= number_format($variant['price'], 0, ',', '.') ?>
                                </p>
                            </div>

                            <!-- STOCK -->
                            <div class="text-center">
                                <p class="text-purple-300 mb-1">Stock</p>
                                <p class="font-bold <?= $variant['stock'] < 10 ? 'text-red-400' : 'text-green-400' ?>">
                                    <?= $variant['stock'] ?> pcs
                                </p>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="grid grid-cols-3 gap-2 mb-3 text-xs">
                        <div class="glass-effect p-2 rounded-lg text-center">
                            <p class="text-purple-300 mb-1">Price</p>
                            <p class="italic text-purple-300">-</p>
                        </div>
                        <div class="glass-effect p-2 rounded-lg text-center">
                            <p class="text-purple-300 mb-1">Stock</p>
                            <p class="italic text-purple-300">-</p>
                        </div>
                        <div class="glass-effect p-2 rounded-lg text-center">
                            <p class="text-purple-300 mb-1">Rating</p>
                            <p class="font-bold text-yellow-400">
                                <i class="fas fa-star"></i> <?= $product['rating'] ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ACTIONS -->
                <div class="grid grid-cols-3 gap-2">
                    <button
                        onclick='openEditModal(<?= json_encode($product) ?>)'
                        class="bg-blue-500/20 hover:bg-blue-500/30 py-2 rounded-lg transition-all flex items-center justify-center gap-1 text-sm">
                        <i class="fas fa-edit text-blue-400"></i>
                    </button>

                    <button
                        onclick='viewProduct(<?= json_encode($product) ?>)'
                        class="bg-green-500/20 hover:bg-green-500/30 py-2 rounded-lg transition-all flex items-center justify-center gap-1 text-sm">
                        <i class="fas fa-eye text-green-400"></i>
                    </button>

                    <a
                        href="/admin/products/delete/<?= $product['id'] ?>"
                        class="bg-red-500/20 hover:bg-red-500/30 py-2 rounded-lg transition-all flex items-center justify-center gap-1 text-sm"
                        onclick="return confirm('Yakin hapus produk ini?')">
                        <i class="fas fa-trash text-red-400"></i>
                    </a>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-12">
            <i class="fas fa-box-open text-6xl text-purple-400/30 mb-4"></i>
            <p class="text-purple-200">Belum ada produk</p>
        </div>
    <?php endif; ?>
</div>



    </main>

<!-- ADD CATEGORY MODAL -->
<div id="categoryModal"
     class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">

    <div class="bg-[#150e20] w-full max-w-md rounded-2xl
                border border-purple-500/30 p-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-white">
                Add New Category
            </h2>
            <button onclick="closeCategoryModal()" class="text-purple-300 hover:text-white">
                ✕
            </button>
        </div>

        <!-- FORM -->
        <form id="categoryForm" onsubmit="saveCategory(event)">
            <div class="mb-4">
                <label class="block text-sm text-purple-300 mb-1">
                    Category Name
                </label>
                <input
                    type="text"
                    name="name"
                    id="categoryName"
                    required
                    class="w-full px-4 py-3 rounded-xl
                           bg-white/5 border border-purple-500/20
                           text-white focus:border-purple-500 outline-none"
                    placeholder="e.g. Dakimakura"
                >
            </div>

            <!-- ACTION -->
            <div class="flex justify-end gap-2 mt-6">
                <button
                    type="button"
                    onclick="closeCategoryModal()"
                    class="px-4 py-2 rounded-xl
                           bg-gray-500/20 text-gray-300">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-xl
                           bg-purple-600 text-white hover:bg-purple-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>


<div id="categoryListModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="bg-[#150e20] p-6 rounded-xl max-w-md w-full relative">
        <button onclick="closeCategoryListModal()" class="absolute top-2 right-2 text-white">&times;</button>
        <h3 class="text-white font-bold mb-4">List Categories</h3>
        <ul id="categoryList" class="text-purple-200 space-y-2">
            <!-- Categories akan di-load di sini -->
        </ul>
    </div>
</div>

<!-- Button -->




    <!-- Modal Add/Edit Product -->
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="modal-backdrop fixed inset-0 bg-[#0a0510]/80 backdrop-blur-md transition-opacity" onclick="closeProductModal()"></div>
    
    <div class="relative min-h-screen flex items-center justify-center p-4 text-white">
        <div class="modal-content glass-effect w-full max-w-lg rounded-2xl border border-purple-500/30 shadow-2xl bg-[#150e20] overflow-hidden">
            
            <div class="bg-purple-900/20 border-b border-purple-500/20 p-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-edit text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold tracking-tight" id="modalTitle">Product Information</h2>
                        <p class="text-[10px] text-purple-400 uppercase tracking-widest font-semibold">Data Management</p>
                    </div>
                </div>
                <button onclick="closeProductModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-500/20 text-purple-300 hover:text-red-400 transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="productForm" class="p-6 space-y-5">
                <input type="hidden" name="id" id="productId">

                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-purple-400 font-bold mb-1.5 ml-1">Product Name</label>
                        <input type="text" name="name" id="productName" required placeholder="Enter product name..." 
                               class="w-full bg-white/5 border border-purple-500/20 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-purple-400 font-bold mb-1.5 ml-1">Category</label>
                            <div class="relative">
                                <select name="category_id" id="productCategory" required
                                    class="w-full bg-white/5 border border-purple-500/20 rounded-xl px-4 py-3 text-white focus:border-purple-500 outline-none appearance-none cursor-pointer">

                                    <option value="" class="bg-[#150e20]">Select</option>

                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option 
                                                value="<?= $category['id'] ?>" 
                                                class="bg-[#150e20]">
                                                <?= htmlspecialchars($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </select>

                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-purple-500 text-[10px] pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-purple-400 font-bold mb-1.5 ml-1">Status</label>
                            <div class="relative">
                                <select name="status" id="productStatus" required
                                        class="w-full bg-white/5 border border-purple-500/20 rounded-xl px-4 py-3 text-white focus:border-purple-500 outline-none appearance-none cursor-pointer">
                                    <option value="active" class="bg-[#150e20]">Active</option>
                                    <option value="inactive" class="bg-[#150e20]">Inactive</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-purple-500 text-[10px] pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-purple-400 font-bold mb-1.5 ml-1">Description</label>
                        <textarea name="description" id="productDescription" rows="5" placeholder="Enter product details..."
                                  class="w-full bg-white/5 border border-purple-500/20 rounded-xl px-4 py-3 text-white focus:border-purple-500 outline-none resize-none transition-all"></textarea>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-purple-500/5 rounded-xl border border-purple-500/10 group hover:border-purple-500/30 transition-all">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-star text-yellow-500 group-hover:scale-110 transition-transform"></i>
                            <label for="productHighlight" class="text-sm text-purple-200 font-medium cursor-pointer">Mark as Featured Product</label>
                        </div>
                        <input type="checkbox" name="highlight" id="productHighlight" value="1" 
                               class="w-5 h-5 rounded border-purple-500/30 bg-transparent text-purple-600 focus:ring-purple-500 cursor-pointer">
                    </div>
                </div>
<!-- VARIANT SECTION -->
<div id="variantSection" class="border-t border-purple-500/20 px-6 py-5 bg-purple-900/10">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-bold tracking-widest text-purple-300 uppercase">
            Product Variants
        </h3>

        <button onclick="openAddVariantForm()" type="button"
            class="px-3 py-2 rounded-lg border border-pink-500/40 text-pink-400 text-xs font-bold hover:bg-pink-500/10 transition">
            <i class="fas fa-plus"></i> Add Variant
        </button>
    </div>

    <div id="addVariantForm" class="hidden mb-4 p-4 rounded-xl bg-[#120a1c] border border-purple-500/20">
        <div class="grid grid-cols-2 gap-3 mb-3">
            <input type="text" id="variantName" placeholder="Variant name"
                class="bg-white/5 border border-purple-500/20 rounded-lg px-3 py-2 text-xs text-white">

            <input type="number" id="variantPrice" placeholder="Price"
                class="bg-white/5 border border-purple-500/20 rounded-lg px-3 py-2 text-xs text-white">
        </div>

        <div class="grid grid-cols-2 gap-3 mb-3">
            <input type="number" id="variantStock" placeholder="Stock"
                class="bg-white/5 border border-purple-500/20 rounded-lg px-3 py-2 text-xs text-white">
            
            <select id="variantStatus"
                class="bg-white/5 border border-purple-500/20 rounded-lg px-3 py-2 text-xs text-white">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <input type="file" id="variantImage" accept="image/*"
            class="bg-white/5 border border-purple-500/20 rounded-lg px-3 py-2 text-xs text-white">

        <img id="variantPreview"
            class="hidden mt-2 w-full h-32 object-cover rounded-lg border border-purple-500/30"
            alt="Preview Image">

        <div class="flex gap-2">
            <button onclick="saveVariant()" type="button"
                class="flex-1 bg-pink-600 py-2 rounded-lg text-xs font-bold">
                Save Variant
            </button>
            <button onclick="closeAddVariantForm()" type="button"
                class="flex-1 border border-purple-500/20 py-2 rounded-lg text-xs">
                Cancel
            </button>
        </div>
    </div> <div id="variantList" class="space-y-2 text-sm text-purple-200">
        <p class="text-purple-400 text-xs">Loading variants...</p>
    </div>
</div> <div class="pt-4 flex gap-3">
    <button type="button" onclick="closeProductModal()" 
            class="flex-1 px-4 py-3 rounded-xl border border-purple-500/20 text-purple-400 text-xs font-bold uppercase tracking-widest hover:bg-white/5 transition-all">
        Cancel
    </button>
    <button type="submit" id="btnSave"
            class="flex-[2] px-4 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-black uppercase tracking-widest shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all">
        Save Product
    </button>
</div>
            </form>
        </div>
    </div>

<div id="variantModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeVariantModal()"></div>

    <div class="relative h-full flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="glass-effect w-full sm:max-w-lg rounded-t-3xl sm:rounded-2xl border border-pink-500/30 shadow-2xl">

            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-pink-500/30">
                <h3 class="text-lg font-bold text-pink-400 flex items-center gap-2">
                    <i class="fas fa-layer-group"></i>
                    Add Variant
                </h3>
                <button onclick="closeVariantModal()" class="text-pink-400 hover:text-red-400">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="variantForm"
                  action="/admin/variants/store"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-4 space-y-4">

                <!-- 🔗 PRODUCT ID (SET VIA JS) -->
                <input type="hidden" name="product_id" id="variantProductId">

                <!-- Variant Name -->
                <div>
                    <label class="block mb-1 text-sm font-semibold">Variant Name</label>
                    <input type="text" name="variant_name"
                        class="w-full px-4 py-3 glass-effect rounded-lg border border-pink-500/30"
                        placeholder="Example: Hitam - XL"
                        required>
                </div>

                <!-- Price -->
                <div>
                    <label class="block mb-1 text-sm font-semibold">Price</label>
                    <input type="number" name="price"
                        class="w-full px-4 py-3 glass-effect rounded-lg border border-pink-500/30"
                        placeholder="150000"
                        required>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block mb-1 text-sm font-semibold">Stock</label>
                    <input type="number" name="stock"
                        class="w-full px-4 py-3 glass-effect rounded-lg border border-pink-500/30"
                        value="0">
                </div>

                <!-- Variant Image -->
                <div>
                    <label class="block mb-1 text-sm font-semibold">Variant Image</label>
                    <input type="file" name="image"
                        class="w-full text-sm
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:bg-pink-600 file:text-white
                        hover:file:bg-pink-700">
                </div>

                <!-- Status -->
                <div>
                    <label class="block mb-1 text-sm font-semibold">Status</label>
                    <select name="status"
                        class="w-full px-4 py-3 glass-effect rounded-lg border border-pink-500/30">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeVariantModal()"
                        class="flex-1 py-3 rounded-lg border border-gray-500/40 hover:bg-white/5">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 rounded-lg bg-gradient-to-r from-pink-600 to-rose-500 font-bold">
                        Save Variant
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>






    <script>
                /// Ambil elemen-elemen yang dibutuhkan
      // Konfigurasi Elemen
const modal = document.getElementById('productModal');
const form = document.getElementById('productForm');
const modalTitle = document.getElementById('modalTitle');
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');
const variantModal = document.getElementById('variantModal');

function openVariantModal() {
    const productId = document.getElementById('productId').value;

    if (!productId) {
        alert('Save product first!');
        return;
    }

    document.getElementById('variantProductId').value = productId;
    document.getElementById('variantForm').reset();

    document.getElementById('variantModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeVariantModal() {
    document.getElementById('variantModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}


document.getElementById('variantImage')?.addEventListener('change', function () {
    const preview = document.getElementById('variantPreview');
    const file = this.files[0];

    if (!file) {
        preview.classList.add('hidden');
        preview.src = '';
        return;
    }

    // Validasi sederhana (opsional)
    if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar');
        this.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});
function renderVariantItem(v) {
    return `
        <div class="flex justify-between items-center p-3 rounded-xl
                    bg-purple-900/30 border border-purple-500/20">

            <div>
                <p class="text-sm font-semibold text-white">
                    ${v.variant_name}
                </p>
                <p class="text-xs text-purple-300">
                    Rp ${v.price} • Stock ${v.stock}
                </p>
            </div>

            <button onclick="deleteVariant(${v.id})"
                class="text-red-400 hover:text-red-500 transition">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
}
function deleteVariant(id) {
    if (!confirm('Hapus variant ini?')) return;

    fetch(`/admin/variants/delete/${id}`, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            const productId = document.getElementById('variantProductId').value;
            loadVariantList(productId);
        } else {
            alert(res.message || 'Gagal menghapus variant');
        }
    });
}

/**
 * Membuka Modal Tambah
 */
function openAddModal() {
    if (!modal || !form) return;

    modalTitle.innerText = "Add New Product";
    form.reset();

    const productIdInput  = document.getElementById('productId');
    const variantSection  = document.getElementById('variantSection');
    const variantList     = document.getElementById('variantList');

    // Kosongkan ID (karena product baru)
    if (productIdInput) productIdInput.value = '';

    // MODE ADD → SEMBUNYIKAN VARIANT
    if (variantSection) variantSection.classList.add('hidden');
    if (variantList) variantList.innerHTML = '';

    // Tampilkan modal product
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}



/**
 * Membuka Modal Edit
 * @param {Object} product - Data objek produk dari database
 */
function openEditModal(product) {
    console.log('OPEN EDIT MODAL', product);

    if (!product) return;

    const modal = document.getElementById('productModal');
    const form  = document.getElementById('productForm');
    const variantSection = document.getElementById('variantSection');

    if (!modal || !form) return;

    modalTitle.innerText = "Edit Product";
    form.reset();

    // Set product data
    document.getElementById('productId').value          = product.id;
    document.getElementById('productName').value        = product.name ?? '';
    document.getElementById('productCategory').value    = product.category_id ?? '';
    document.getElementById('productStatus').value      = product.status ?? 'active';
    document.getElementById('productDescription').value = product.description ?? '';

    const highlightCheck = document.getElementById('productHighlight');
    if (highlightCheck) {
        highlightCheck.checked = Number(product.highlight) === 1;
    }

    // 🔓 tampilkan section variant
    if (variantSection) {
        variantSection.classList.remove('hidden');
    }

    // 🔥 SATU-SATUNYA SUMBER VARIANT
    loadVariants(product.id);

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}




function openAddVariantForm() {
    document.getElementById('addVariantForm').classList.remove('hidden');
}

function closeAddVariantForm() {
    document.getElementById('addVariantForm').classList.add('hidden');
}

function loadVariants(productId) {
    const variantList = document.getElementById('variantList');
    if (!variantList) return;

    console.log('🔥 loadVariants MASUK, productId =', productId);

    variantList.innerHTML =
        '<p class="text-purple-400 text-xs">Loading variants...</p>';

    fetch(`/admin/products/${productId}/variants`)
        .then(res => res.json())
        .then(data => {
            console.log('📦 VARIANT DATA:', data);

            variantList.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
                variantList.innerHTML =
                    '<p class="text-purple-400 text-xs">No variant found</p>';
                return;
            }

            data.forEach(v => {
                const imageUrl = v.image
                    ? `${window.location.origin}/assets/images/images_save/${v.image}`
                    : `${window.location.origin}/assets/images/no-image.png`;

                const item = document.createElement('div');
                item.className =
                    'flex items-center gap-3 p-3 rounded-lg bg-purple-500/5 border border-purple-500/20';

                item.innerHTML = `
                    <!-- IMAGE -->
                    <div class="w-12 h-12 rounded-md overflow-hidden border border-purple-500/30 bg-black/20 flex-shrink-0">
                        <img
                            src="${imageUrl}"
                            alt="${v.variant_name}"
                            class="w-full h-full object-cover"
                            onerror="this.onerror=null;this.src='${window.location.origin}/assets/images/no-image.png'"
                        />
                    </div>

                    <!-- INFO -->
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate">${v.variant_name}</p>
                        <p class="text-xs text-purple-400">
                            Rp ${Number(v.price).toLocaleString()} • Stock ${v.stock}
                        </p>
                    </div>

                    <!-- ACTION -->
                    <div class="flex gap-2">
                        <button
                        type= "button"
                            onclick='editVariant(${JSON.stringify(v)})'
                            class="px-3 py-1 text-xs rounded-md border border-blue-500/40 text-blue-400 hover:bg-blue-500/10">
                            Edit
                        </button>

                        <button
                            onclick="deleteVariant(${v.id}, ${productId})"
                            class="px-3 py-1 text-xs rounded-md border border-red-500/40 text-red-400 hover:bg-red-500/10">
                            Delete
                        </button>
                    </div>
                `;

                variantList.appendChild(item);
            });
        })
        .catch(err => {
            console.error('❌ LOAD VARIANTS ERROR:', err);
            variantList.innerHTML =
                '<p class="text-red-400 text-xs">Failed to load variants</p>';
        });
}

function editVariant(variant) {
    console.log('✏️ EDIT VARIANT:', variant);

    const form = document.getElementById('addVariantForm');
    if (!form) return;

    form.classList.remove('hidden');

    // INPUT TEXT
    document.getElementById('variantName').value  = variant.variant_name ?? '';
    document.getElementById('variantPrice').value = variant.price ?? '';
    document.getElementById('variantStock').value = variant.stock ?? '';
    document.getElementById('variantStatus').value =
        variant.status ?? 'active';

    // 🔥 HIDDEN VARIANT ID
    let variantIdInput = document.getElementById('variantId');
    if (!variantIdInput) {
        variantIdInput = document.createElement('input');
        variantIdInput.type = 'hidden';
        variantIdInput.id = 'variantId';
        variantIdInput.name = 'variantId';
        form.appendChild(variantIdInput);
    }
    variantIdInput.value = variant.id;

    // 🔥 IMAGE PREVIEW (PAKAI YANG SUDAH ADA)
    const previewImg = document.getElementById('variantPreview');

    if (variant.image) {
        previewImg.src =
            `${window.location.origin}/assets/images/images_save/${variant.image}`;
        previewImg.classList.remove('hidden');
    } else {
        previewImg.src = '';
        previewImg.classList.add('hidden');
    }
}



function saveVariant() {
    const productId = document.getElementById('productId')?.value;
    const variantId = document.getElementById('variantId')?.value;

    if (!productId) {
        alert('Product ID tidak ditemukan');
        return;
    }

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('variant_name', document.getElementById('variantName').value);
    formData.append('price', document.getElementById('variantPrice').value);
    formData.append('stock', document.getElementById('variantStock').value);
    formData.append('status', document.getElementById('variantStatus').value);

    const imageInput = document.getElementById('variantImage');
    if (imageInput && imageInput.files.length > 0) {
        formData.append('image', imageInput.files[0]);
    }

    // 🔥 TENTUKAN MODE
    const isEdit = !!variantId;
    const url = isEdit
        ? `/admin/variants/update/${variantId}`
        : `/admin/variants/store`;

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(text => {
        console.log('Response:', text);

        let data;
        try {
            data = JSON.parse(text);
        } catch {
            alert('❌ Server tidak mengirim JSON');
            return;
        }

        if (data.success) {
            alert(isEdit ? '✅ Variant berhasil diupdate' : '✅ Variant berhasil ditambahkan');

            // 🔥 RESET MODE KE CREATE
            

            closeAddVariantForm();
            loadVariants(productId);
        } else {
            alert(data.message || 'Gagal menyimpan variant');
        }
    })
    .catch(err => {
        console.error(err);
        
    });
}



function deleteVariant(variantId, productId) {
    if (!confirm('Hapus variant ini?')) return;

    fetch(`/admin/products/variants/delete/${variantId}`, {
        method: 'POST'
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            console.log('✅ Variant deleted, reload list');
            
            // 🔥 REFRESH LIST VARIANT
            loadVariants(productId);

        } else {
            alert(res.message || 'Gagal menghapus variant');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Gagal menghapus variant');
    });
}


/**
 * Menutup Modal
 */
function closeProductModal() {
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';

        // 🔥 Refresh halaman otomatis
        location.reload();
    }
}


if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const productId = document.getElementById('productId').value;
        const btnSave = document.getElementById('btnSave');
        const formData = new FormData(this);

        // Tentukan URL sesuai ada/tidaknya ID
        const targetUrl = productId 
            ? `/admin/products/update/${productId}` 
            : `/admin/products/store`;

        btnSave.innerText = "SAVING...";
        btnSave.disabled = true;

        fetch(targetUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);

                // 🔥 Modal tetap terbuka
                // Jika ingin, update row / list produk di DOM tanpa reload
                if (productId) {
                    // Misal update nama produk di tabel
                    const row = document.getElementById(`product-${productId}`);
                    if (row) {
                        row.querySelector('.product-name').innerText = formData.get('name');
                        row.querySelector('.product-price').innerText = formData.get('price');
                    }
                } else {
                    // Jika produk baru, bisa append ke tabel
                   
                }

            } else {
                alert("Gagal: " + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error Koneksi: Pastikan Route " + targetUrl + " sudah benar.");
        })
        .finally(() => {
            btnSave.innerText = "Save Product";
            btnSave.disabled = false;
        });
    });
}


function openCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('categoryModal').classList.add('flex');
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('categoryModal').classList.remove('flex');
}

function saveCategory(e) {
    e.preventDefault();

    const name = document.getElementById('categoryName').value.trim();

    if (!name) {
        alert('Nama category wajib diisi');
        return;
    }

    const formData = new FormData();
    formData.append('name', name);

    fetch('/admin/categories/store', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(text => {
        console.log('Response:', text);

        let data;
        try {
            data = JSON.parse(text);
        } catch {
            alert('Server tidak mengirim JSON');
            return;
        }

        if (data.success) {
           alert('✅ Category berhasil ditambahkan');
        closeCategoryModal();
            location.reload(); // atau refresh dropdown
        } else {
            alert(data.message || 'Gagal menambahkan category');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error koneksi');
    });
}
function openCategoryListModal() {
    document.getElementById('categoryListModal').classList.remove('hidden');
    loadCategories();
}

function closeCategoryListModal() {
    document.getElementById('categoryListModal').classList.add('hidden');
}

// Contoh load category dari server
function loadCategories() {
    const ul = document.getElementById('categoryList');
    ul.innerHTML = '<li>Loading...</li>';
    
    fetch('/admin/categories/all') // pastikan route ini ada
        .then(res => res.json())
        .then(data => {
            ul.innerHTML = '';
            if(data.length > 0){
                data.forEach(cat => {
                    const li = document.createElement('li');
                    li.className = "flex justify-between items-center bg-purple-900/10 p-2 rounded";
                    li.innerHTML = `
                        <span>${cat.name}</span>
                        <button onclick="deleteCategory(${cat.id})" class="text-red-500 text-xs">Delete</button>
                    `;
                    ul.appendChild(li);
                });
            } else {
                ul.innerHTML = '<li class="text-purple-300 text-xs">Belum ada kategori</li>';
            }
        })
        .catch(() => ul.innerHTML = '<li class="text-red-500 text-xs">Gagal load kategori</li>');
}

// Delete category
function deleteCategory(id) {
    if (!confirm('Yakin hapus kategori ini?')) return;

    fetch(`/admin/categories/delete/${id}`, { method: 'POST' })
        .then(res => res.json()) // Harus valid JSON
        .then(res => {
            if(res.success){
                alert(res.message);
                loadCategories(); // reload list kategori
            } else {
                alert(res.message || 'Gagal menghapus kategori');
            }
        })
        .catch(err => {
            console.error(err);
            alert('❌ Error koneksi / JSON tidak valid');
        });
}

/**
 * Filter Pencarian Real-time
 */
function filterProducts() {
  
    
    // Filter Tabel (Desktop)


    // Filter Cards (Mobile)
    const cardContainer = document.getElementById('productCards');
    if (cardContainer) {
        Array.from(cardContainer.children).forEach(card => {
            const name = (card.getAttribute('data-name') || "").toLowerCase();
            const status = card.getAttribute('data-status') || "";
            const matchesSearch = name.includes(searchTerm);
            const matchesStatus = statusTerm === "" || status === statusTerm;
            card.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();

        // DESKTOP TABLE
        document.querySelectorAll('.product-row').forEach(row => {
            const name = row.dataset.name || '';
            row.style.display = name.includes(keyword) ? '' : 'none';
        });

        // MOBILE CARDS
        document.querySelectorAll('#productCards > div').forEach(card => {
            const name = card.dataset.name || '';
            card.style.display = name.includes(keyword) ? '' : 'none';
        });
    });
});


statusFilter.addEventListener('change', function () {
    const selectedStatus = this.value;

    document.querySelectorAll('.product-row').forEach(row => {
        const rowStatus = row.dataset.status;

        if (!selectedStatus || rowStatus === selectedStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

document.getElementById('wholesaleForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    fetch('/admin/wholesale/store', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(text => {
        console.log('RESP:', text);

        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            alert('Server tidak mengirim JSON');
            return;
        }

        if (data.success) {
            alert('✅ Harga grosir berhasil disimpan');
            form.reset();
            closeWholesaleModal();
        } else {
            alert(data.message || 'Gagal menyimpan');
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Koneksi gagal');
    });
});
// Pasang Event Listeners Filter
searchInput?.addEventListener('input', filterProducts);
statusFilter?.addEventListener('change', filterProducts);
    </script>
</body>
</html>