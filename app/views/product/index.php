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
        background-color: #f9fafb; /* Light Gray */
        color: #1f2937; /* Gray-800 */
    }

    /* Glass Effect (Opsional untuk light theme, bisa dibuat putih solid) */
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(229, 231, 235, 0.5); /* Gray-200 */
    }

    .glow-effect {
        transition: all 0.3s ease;
    }

    .glow-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Animations */
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
        transition: all 0.2s ease;
    }

    .table-row:hover {
        background-color: #f9fafb; /* Gray-50 */
    }

    /* Modal Styling */
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
<body class="bg-gray-50 min-h-screen text-gray-800">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <a href="/admin/dashboard" class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                            Product Management
                        </h1>
                        <p class="text-gray-500 text-xs sm:text-sm">Kelola Produk Dakimakura</p>
                    </div>
                </div>
                
                <a href="/admin/dashboard" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition-all flex items-center gap-2">
                    <i class="fas fa-home text-purple-500"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 sm:px-6 py-8 lg:py-12">
      
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 slide-in">
            <div class="bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
                        <i class="fas fa-box text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Total</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900"><?= count($products) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                        <i class="fas fa-check-circle text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Active</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">
                            <?= count(array_filter($products, fn($p) => $p['status'] === 'active')) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-500">
                        <i class="fas fa-star text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Highlight</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">
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

            <div class="bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                        <i class="fas fa-layer-group text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Total Variant</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">
                            <?= $totalVariant ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-xl p-4 sm:p-6 mb-6 border border-gray-200 shadow-sm slide-in" style="animation-delay: 0.1s;">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">

                <!-- Search -->
                <div class="relative w-full lg:w-80">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Cari produk..." 
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Filter & Actions -->
                <div class="flex flex-wrap sm:flex-nowrap gap-2 sm:gap-3 w-full lg:w-auto">

                    <!-- Status Filter -->
                    <select
                        id="statusFilter"
                        class="flex-1 sm:flex-none bg-gray-50 border border-gray-300 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all text-sm cursor-pointer"
                    >
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="preorder">Pre-Order</option>
                    </select>

                    <!-- Add Categories & Harga Grosir -->
                    <div class="relative z-[10] pointer-events-auto">
                        <button
                            type="button"
                            onclick="openCategoryModal()"
                            class="px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium text-sm transition-all h-full">
                            Add Category
                        </button>
                    </div>
                    <div class="relative z-[10] pointer-events-auto">
                        <button onclick="openCategoryListModal()" 
                            class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition h-full border border-gray-300">
                            List Categories
                        </button>
                    </div>

                    <a href="/admin/variant-wholesale"
                    class="flex-1 sm:flex-none border border-emerald-500/50 hover:bg-emerald-50 text-emerald-600 px-4 sm:px-5 py-3 rounded-lg font-semibold transition-all 
                            flex items-center justify-center gap-2 text-sm whitespace-nowrap bg-white">
                        <i class="fas fa-tags"></i>
                        <span>Harga Grosir</span>
                    </a>

                    <!-- Add Product -->
                    <button
                        onclick="openAddModal()"
                        class="flex-1 sm:flex-none bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 px-4 sm:px-6 py-3 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg text-white flex items-center justify-center gap-2 text-sm whitespace-nowrap"
                    >
                        <i class="fas fa-plus"></i>
                        <span>Add Product</span>
                    </button>
                    
                </div>
            </div>
        </div>


        <!-- Products Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden slide-in" style="animation-delay: 0.2s;">
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold border-b border-gray-200">
                            <th class="px-6 py-3 text-left">Product</th>
                            <th class="px-6 py-3 text-left">Variant Name</th>
                            <th class="px-6 py-3 text-center">Category</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr
                                class="border-b border-gray-100 hover:bg-gray-50 transition-colors product-row"
                                data-name="<?= strtolower($product['name']) ?>"
                                data-status="<?= $product['status'] ?>"
                            >

                                <!-- PRODUCT -->
                                <td class="px-6 py-4 align-top">
                                    <h3 class="font-semibold text-gray-900 text-sm">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h3>

                                    <p class="text-xs text-gray-500 line-clamp-2 mt-1">
                                        <?= htmlspecialchars($product['description'] ?? '-') ?>
                                    </p>

                                    <?php if (!empty($product['highlight'])): ?>
                                        <span class="inline-block mt-2 px-2 py-0.5 bg-yellow-100 text-yellow-700 text-[10px] font-semibold rounded-full border border-yellow-200">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i> Featured
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- VARIANTS -->
                                <td class="px-6 py-4 align-top">
                                    <?php if (!empty($product['variants'])): ?>
                                        <?php foreach ($product['variants'] as $variant): ?>
                                            <div class="flex items-center gap-4 p-2 mb-2 rounded bg-gray-50 border border-gray-200">

                                                <!-- IMAGE -->
                                                <?php if (!empty($variant['image'])): ?>
                                                    <img
                                                        src="/assets/images/images_save/<?= htmlspecialchars($variant['image']) ?>"
                                                        class="w-10 h-10 rounded object-cover border border-gray-200 bg-white"
                                                    >
                                                <?php else: ?>
                                                    <div class="w-10 h-10 flex items-center justify-center
                                                                rounded border border-gray-200 bg-white
                                                                text-[9px] text-gray-400 text-center">
                                                        No Img
                                                    </div>
                                                <?php endif; ?>

                                                <!-- NAME -->
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-800">
                                                        <?= htmlspecialchars($variant['variant_name']) ?>
                                                    </p>
                                                </div>

                                                <!-- PRICE -->
                                                <div class="min-w-[100px] text-right">
                                                    <p class="text-[10px] text-gray-400 uppercase">Price</p>
                                                    <p class="font-medium text-gray-900 text-sm">
                                                        Rp <?= number_format((int)$variant['price'], 0, ',', '.') ?>
                                                    </p>
                                                </div>

                                                <!-- STOCK -->
                                                <div class="min-w-[70px] text-center">
                                                    <p class="text-[10px] text-gray-400 uppercase">Stock</p>
                                                    <p class="font-medium text-gray-900 text-sm">
                                                        <?= (int)$variant['stock'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="italic text-gray-400 text-sm">Belum ada varian</span>
                                    <?php endif; ?>
                                </td>

                                <!-- CATEGORY -->
                                <td class="px-6 py-4 text-center align-top text-sm text-gray-600">
                                    <?= htmlspecialchars($product['category_name'] ?? '-') ?>
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-4 text-center align-top">
                                    <?php
                                        $statusClass = 'bg-gray-100 text-gray-600';
                                        if ($product['status'] === 'active') $statusClass = 'bg-green-100 text-green-700 border border-green-200';
                                        elseif ($product['status'] === 'inactive') $statusClass = 'bg-red-100 text-red-700 border border-red-200';
                                        elseif ($product['status'] === 'preorder') $statusClass = 'bg-blue-100 text-blue-700 border border-blue-200';
                                    ?>
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                        <?= ucfirst($product['status']) ?>
                                    </span>
                                </td>

                                <!-- ACTION -->
                                <td class="px-6 py-4 align-top">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            onclick='openEditModal(<?= json_encode($product) ?>)'
                                            class="w-8 h-8 rounded-lg flex items-center justify-center border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                            title="Edit"
                                        >
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </button>

                                        <a
                                            href="/admin/products/delete/<?= $product['id'] ?>"
                                            onclick="return confirm('Yakin hapus produk ini?')"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Delete"
                                        >
                                            <i class="fas fa-trash text-xs"></i>
                                        </a>
                                    
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-10 text-gray-500">Belum ada produk</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="lg:hidden space-y-4 p-4" id="productCards">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm"
                             data-name="<?= strtolower($product['name']) ?>"
                             data-status="<?= $product['status'] ?>">

                            <div class="flex gap-3 mb-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-1">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h3>

                                    <p class="text-xs text-gray-500 line-clamp-2 mb-2">
                                        <?= htmlspecialchars($product['description'] ?? '-') ?>
                                    </p>

                                    <div class="flex items-center gap-2 flex-wrap">
                                        <?php
                                            $mobileStatusClass = $product['status'] === 'active' 
                                                ? 'bg-green-100 text-green-700 border-green-200' 
                                                : ($product['status'] === 'preorder' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-red-100 text-red-700 border-red-200');
                                        ?>
                                        <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold border <?= $mobileStatusClass ?>">
                                            <?= $product['status'] ?>
                                        </span>

                                        <?php if (!empty($product['highlight'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-yellow-100 text-yellow-700 border border-yellow-200 text-[10px] rounded">
                                                <i class="fas fa-star text-[8px]"></i> Featured
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- VARIANTS -->
                            <?php if (!empty($product['variants'])): ?>
                                <?php foreach ($product['variants'] as $variant): ?>
                                    <div class="grid grid-cols-4 gap-2 mb-2 text-xs bg-gray-50 rounded p-2 border border-gray-200">
                                        <div class="flex items-center justify-center">
                                            <?php if (!empty($variant['image'])): ?>
                                                <img
                                                    src="/assets/images/images_save/<?= htmlspecialchars($variant['image']) ?>"
                                                    class="w-10 h-10 rounded object-cover border border-gray-200"
                                                    onerror="this.style.display='none'"
                                                >
                                            <?php else: ?>
                                                <span class="text-[9px] text-gray-400 text-center">No Img</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-gray-400 mb-0.5 text-[10px]">Variant</p>
                                            <p class="font-semibold text-gray-900 truncate">
                                                <?= htmlspecialchars($variant['variant_name']) ?>
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-gray-400 mb-0.5 text-[10px]">Price</p>
                                            <p class="font-semibold text-gray-900">
                                                <?= number_format($variant['price'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-gray-400 mb-0.5 text-[10px]">Stock</p>
                                            <p class="font-semibold <?= $variant['stock'] < 10 ? 'text-red-600' : 'text-green-600' ?>">
                                                <?= $variant['stock'] ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-xs text-gray-400 py-2 italic font-light">No variants available</p>
                            <?php endif; ?>

                            <!-- ACTIONS -->
                            <div class="grid grid-cols-3 gap-2 mt-3">
                                <button
                                    onclick='openEditModal(<?= json_encode($product) ?>)'
                                    class="bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-600 py-2 rounded-lg transition-all flex items-center justify-center gap-1 text-xs font-medium">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <button
                                    onclick='viewProduct(<?= json_encode($product) ?>)'
                                    class="bg-green-50 border border-green-200 hover:bg-green-100 text-green-600 py-2 rounded-lg transition-all flex items-center justify-center gap-1 text-xs font-medium">
                                    <i class="fas fa-eye"></i> View
                                </button>

                                <a
                                    href="/admin/products/delete/<?= $product['id'] ?>"
                                    class="bg-red-50 border border-red-200 hover:bg-red-100 text-red-600 py-2 rounded-lg transition-all flex items-center justify-center gap-1 text-xs font-medium"
                                    onclick="return confirm('Yakin hapus produk ini?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-box-open text-6xl text-gray-200 mb-4"></i>
                        <p class="text-gray-500">Belum ada produk</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>

    <!-- ADD CATEGORY MODAL -->
    <div id="categoryModal"
         class="fixed inset-0 bg-gray-900/50 hidden items-center justify-center z-[100] backdrop-blur-sm">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-gray-200 p-6 transform scale-100 transition-all">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-900">
                    Add New Category
                </h2>
                <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600 rounded-lg p-1 hover:bg-gray-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- FORM -->
            <form id="categoryForm" onsubmit="saveCategory(event)">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="categoryName"
                        required
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                        placeholder="e.g. Dakimakura"
                    >
                </div>

                <!-- ACTION -->
                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        onclick="closeCategoryModal()"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium text-sm transition-colors">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white font-medium text-sm transition-colors shadow-sm">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div id="categoryListModal" class="fixed inset-0 bg-gray-900/50 hidden items-center justify-center z-[100] backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-gray-200 p-6 relative">
            <button onclick="closeCategoryListModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-1 w-8 h-8 flex items-center justify-center transition-all">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-lg font-bold text-gray-900 mb-4">List Categories</h3>
            <div class="max-h-[60vh] overflow-y-auto pr-2">
                <ul id="categoryList" class="space-y-2">
                    <!-- Categories loaded here -->
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit Product -->
    <div id="productModal" class="fixed inset-0 z-[90] hidden overflow-y-auto">
        <div class="modal-backdrop fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeProductModal()"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="modal-content bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-200 overflow-hidden transform transition-all">
                
                <div class="bg-gray-50 border-b border-gray-100 p-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center shadow-sm">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900" id="modalTitle">Product Information</h2>
                            <p class="text-xs text-gray-500 font-medium">Manage product details</p>
                        </div>
                    </div>
                    <button onclick="closeProductModal()" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="productForm" class="p-6 space-y-6">
                    <input type="hidden" name="id" id="productId">

                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Product Name</label>
                            <input type="text" name="name" id="productName" required placeholder="Enter product name..." 
                                   class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                                <div class="relative">
                                    <select name="category_id" id="productCategory" required
                                        class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none cursor-pointer">
                                        <option value="" class="text-gray-400">Select Category</option>
                                        <?php if (!empty($categories)): ?>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>">
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                                </div>
                            </div>
                            <!-- Status -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                                <div class="relative">
                                    <select name="status" id="productStatus" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none cursor-pointer">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="preorder">Pre-Order</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                            <textarea name="description" id="productDescription" rows="4" placeholder="Product details..."
                                      class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"></textarea>
                        </div>

                        <!-- Highlights -->
                        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-100 cursor-pointer hover:bg-yellow-100/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-yellow-200 flex items-center justify-center text-yellow-700">
                                    <i class="fas fa-star text-sm"></i>
                                </div>
                                <label for="productHighlight" class="text-sm font-semibold text-gray-800 cursor-pointer pointer-events-none">Featured Product</label>
                            </div>
                            <input type="checkbox" name="highlight" id="productHighlight" value="1" 
                                   class="w-5 h-5 rounded border-gray-300 text-yellow-500 focus:ring-yellow-500 cursor-pointer bg-white">
                        </div>
                    </div>

                    <!-- VARIANT SECTION -->
                    <div id="variantSection" class="border-t border-gray-100 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">
                                Variants
                            </h3>
                            <button onclick="openAddVariantForm()" type="button"
                                class="px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-xs font-bold transition-colors border border-indigo-200 flex items-center gap-2">
                                <i class="fas fa-plus"></i> Add Variant
                            </button>
                        </div>

                        <!-- Add Variant Form (Inline) -->
                        <div id="addVariantForm" class="hidden mb-4 p-4 rounded-xl bg-gray-50 border border-gray-200">
                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">New Variant Details</h4>
                            
                            <input type="hidden" id="variantId"> <!-- Hidden ID for edit mode -->

                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Name</label>
                                    <input type="text" id="variantName" placeholder="e.g. XXL - Red"
                                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Price</label>
                                    <input type="number" id="variantPrice" placeholder="0"
                                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Stock</label>
                                    <input type="number" id="variantStock" placeholder="0"
                                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Status</label>
                                    <select id="variantStatus" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-900 outline-none">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Image</label>
                                <input type="file" id="variantImage" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
                                <img id="variantPreview" class="hidden mt-3 w-full h-32 object-contain rounded-lg border border-gray-300 bg-white p-2">
                            </div>

                            <div class="flex gap-2 mt-4">
                                <button onclick="closeAddVariantForm()" type="button"
                                    class="flex-1 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-xs font-semibold">
                                    Cancel
                                </button>
                                <button onclick="saveVariant()" type="button"
                                    class="flex-1 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm">
                                    Save Variant
                                </button>
                            </div>
                        </div>

                        <!-- ID LIST Container -->
                        <div id="variantList" class="space-y-2">
                            <p class="text-center text-gray-400 text-xs py-2">Loading variants...</p>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="pt-4 flex gap-3 border-t border-gray-100">
                        <button type="button" onclick="closeProductModal()" 
                                class="flex-1 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button type="submit" id="btnSave"
                                class="flex-[2] px-4 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm shadow-md hover:shadow-lg transform active:scale-95 transition-all">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Additional Scripts -->
    <script>
        // Konfigurasi Elemen Global
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');

        // Modal Category Logic
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
            if (!name) { alert('Nama category wajib diisi'); return; }

            const formData = new FormData();
            formData.append('name', name);

            fetch('/admin/categories/store', { method: 'POST', body: formData })
                .then(res => res.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            alert('✅ Category berhasil ditambahkan');
                            closeCategoryModal();
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal menambahkan category');
                        }
                    } catch { alert('Server response invalid'); }
                })
                .catch(console.error);
        }

        function openCategoryListModal() {
            document.getElementById('categoryListModal').classList.remove('hidden');
            document.getElementById('categoryListModal').classList.add('flex');
            loadCategories();
        }

        function closeCategoryListModal() {
            document.getElementById('categoryListModal').classList.add('hidden');
            document.getElementById('categoryListModal').classList.remove('flex');
        }

        function loadCategories() {
            const ul = document.getElementById('categoryList');
            ul.innerHTML = '<li class="text-gray-400 text-xs text-center">Loading...</li>';
            
            fetch('/admin/categories/all')
                .then(res => res.json())
                .then(data => {
                    ul.innerHTML = '';
                    if(data.length > 0){
                        data.forEach(cat => {
                            const li = document.createElement('li');
                            li.className = "flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors";
                            li.innerHTML = `
                                <span class="text-sm text-gray-700 font-medium">${cat.name}</span>
                                <button onclick="deleteCategory(${cat.id})" class="text-red-500 hover:text-red-700 text-xs font-semibold px-2 py-1 rounded hover:bg-red-50 transition-colors">Delete</button>
                            `;
                            ul.appendChild(li);
                        });
                    } else {
                        ul.innerHTML = '<li class="text-gray-400 text-xs text-center py-2">Belum ada kategori</li>';
                    }
                })
                .catch(() => ul.innerHTML = '<li class="text-red-500 text-xs text-center">Gagal load kategori</li>');
        }

        function deleteCategory(id) {
            if (!confirm('Yakin hapus kategori ini?')) return;
            fetch(`/admin/categories/delete/${id}`, { method: 'POST' })
                .then(res => res.json())
                .then(res => {
                    if(res.success){ loadCategories(); } 
                    else { alert(res.message); }
                })
                .catch(alert);
        }

        // --- PRODUCT MODAL LOGIC ---

        function openAddModal() {
            if (!modal || !form) return;
            modalTitle.innerText = "Add New Product";
            form.reset();
            document.getElementById('productId').value = '';
            
            // Hide Variant Section on Add
            document.getElementById('variantSection').classList.add('hidden');
            document.getElementById('variantList').innerHTML = '';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function openEditModal(product) {
            if (!product) return;
            modalTitle.innerText = "Edit Product";
            form.reset();

            document.getElementById('productId').value          = product.id;
            document.getElementById('productName').value        = product.name ?? '';
            document.getElementById('productCategory').value    = product.category_id ?? '';
            document.getElementById('productStatus').value      = product.status ?? 'active';
            document.getElementById('productDescription').value = product.description ?? '';
            
            const hl = document.getElementById('productHighlight');
            if(hl) hl.checked = (product.highlight == 1);

            // Show variant section
            document.getElementById('variantSection').classList.remove('hidden');
            loadVariants(product.id);

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeProductModal() {
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                location.reload(); // Refresh to reflect changes
            }
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const productId = document.getElementById('productId').value;
                const btnSave = document.getElementById('btnSave');
                const formData = new FormData(this);
                const targetUrl = productId ? `/admin/products/update/${productId}` : `/admin/products/store`;

                btnSave.innerText = "Saving...";
                btnSave.disabled = true;

                fetch(targetUrl, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        alert(data.message);
                        if(!productId) closeProductModal(); // If add, close. If edit, maybe stay open? User preference usually close.
                        // Let's rely on closeProductModal()'s location.reload() 
                    } else {
                        alert("Gagal: " + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Error Request");
                })
                .finally(() => {
                    btnSave.innerText = "Save Product";
                    btnSave.disabled = false;
                });
            });
        }

        // --- VARIANT LOGIC (Inside Product Modal) ---

        function openAddVariantForm() {
            const formDiv = document.getElementById('addVariantForm');
            formDiv.classList.remove('hidden');
            // Reset fields
            document.getElementById('variantId').value = '';
            document.getElementById('variantName').value = '';
            document.getElementById('variantPrice').value = '';
            document.getElementById('variantStock').value = '';
            document.getElementById('variantStatus').value = 'active';
            document.getElementById('variantImage').value = '';
            document.getElementById('variantPreview').classList.add('hidden');
        }

        function closeAddVariantForm() {
            document.getElementById('addVariantForm').classList.add('hidden');
        }

        document.getElementById('variantImage')?.addEventListener('change', function () {
            const preview = document.getElementById('variantPreview');
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });

        function loadVariants(productId) {
            const list = document.getElementById('variantList');
            list.innerHTML = '<p class="text-center text-gray-400 text-xs py-2">Loading variants...</p>';

            fetch(`/admin/products/${productId}/variants`)
            .then(res => res.json())
            .then(data => {
                list.innerHTML = '';
                if(!Array.isArray(data) || data.length === 0) {
                    list.innerHTML = '<p class="text-center text-gray-400 text-xs py-2 border border-dashed border-gray-300 rounded-lg">No variants found</p>';
                    return;
                }

                data.forEach(v => {
                    const imgUrl = v.image ? `/assets/images/images_save/${v.image}` : '/assets/images/no-image.png';
                    const div = document.createElement('div');
                    div.className = "flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-200 hover:border-gray-300 transition-all shadow-sm";
                    div.innerHTML = `
                        <img src="${imgUrl}" class="w-10 h-10 rounded object-cover border border-gray-100 bg-gray-50 flex-shrink-0" onerror="this.src='/assets/images/no-image.png'">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">${v.variant_name}</p>
                            <div class="text-xs text-gray-500 flex gap-2">
                                <span>Rp ${Number(v.price).toLocaleString()}</span>
                                <span class="text-gray-300">|</span>
                                <span>Stok: ${v.stock}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick='editVariant(${JSON.stringify(v)})' class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition-colors"><i class="fas fa-pencil-alt text-xs"></i></button>
                            <button onclick="deleteVariant(${v.id}, ${productId})" class="text-red-500 hover:bg-red-50 p-1.5 rounded-md transition-colors"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    `;
                    list.appendChild(div);
                });
            })
            .catch(err => {
                console.error(err);
                list.innerHTML = '<p class="text-red-500 text-xs text-center">Failed to load variants</p>';
            });
        }

        function editVariant(v) {
            openAddVariantForm();
            // Fill Data
            document.getElementById('variantId').value = v.id;
            document.getElementById('variantName').value = v.variant_name;
            document.getElementById('variantPrice').value = v.price;
            document.getElementById('variantStock').value = v.stock;
            document.getElementById('variantStatus').value = v.status;
            
            // Image Preview
            const preview = document.getElementById('variantPreview');
            if(v.image) {
                preview.src = `/assets/images/images_save/${v.image}`;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        function saveVariant() {
            const productId = document.getElementById('productId').value;
            const variantId = document.getElementById('variantId').value;
            
            if(!productId) { alert('Product ID missing'); return; }

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('variant_name', document.getElementById('variantName').value);
            formData.append('price', document.getElementById('variantPrice').value);
            formData.append('stock', document.getElementById('variantStock').value);
            formData.append('status', document.getElementById('variantStatus').value);
            
            const fileInput = document.getElementById('variantImage');
            if(fileInput.files[0]) formData.append('image', fileInput.files[0]);

            const url = variantId ? `/admin/variants/update/${variantId}` : `/admin/variants/store`;

            fetch(url, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert(variantId ? '✅ Variant Updated' : '✅ Variant Added');
                    closeAddVariantForm();
                    loadVariants(productId);
                } else {
                    alert(data.message || 'Error saving variant');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error Connection');
            });
        }

        function deleteVariant(variantId, productId) {
            if(!confirm('Hapus variant ini?')) return;
            fetch(`/admin/products/variants/delete/${variantId}`, { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if(data.success) loadVariants(productId);
                else alert(data.message);
            })
            .catch(alert);
        }

        // --- FILTER ---
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('searchInput');
            if(input) {
                input.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    // Table Rows
                    document.querySelectorAll('.product-row').forEach(row => {
                        const name = row.dataset.name || '';
                        row.style.display = name.includes(term) ? '' : 'none';
                    });
                    // Mobile Cards
                    document.querySelectorAll('#productCards > div').forEach(card => {
                        const name = card.dataset.name || '';
                        card.style.display = name.includes(term) ? '' : 'none';
                    });
                });
            }
        });

        if(statusFilter) {
            statusFilter.addEventListener('change', function() {
                const term = this.value;
                document.querySelectorAll('.product-row').forEach(row => {
                    if(!term || row.dataset.status === term) row.style.display = '';
                    else row.style.display = 'none';
                });
            });
        }

    </script>
</body>
</html>