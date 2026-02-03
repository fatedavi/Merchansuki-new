<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Harga Grosir - Admin DakiShop</title>
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

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .wholesale-card {
            transition: all 0.3s ease;
        }

        .wholesale-card:hover {
            background: rgba(139, 92, 246, 0.1);
            transform: translateY(-2px);
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.05);
        }

        .action-btn:active {
            transform: scale(0.95);
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: rgba(139, 92, 246, 0.1);
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
                            Daftar Harga Grosir
                        </h1>
                        <p class="text-purple-300 text-xs sm:text-sm">Kelola Harga Wholesale per Varian</p>
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

    <!-- Search & Filter Bar -->
    <div class="glass-effect rounded-xl p-4 sm:p-6 mb-6 border border-purple-500/30 slide-in">
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="relative w-full sm:w-96">
                <input 
                    type="text" 
                    id="searchInput"
                    placeholder="Cari produk atau varian..." 
                    class="w-full pl-10 pr-4 py-3 glass-effect rounded-lg text-white placeholder-purple-300 focus:outline-none border border-purple-500/30 focus:border-purple-500 transition-all text-sm"
                >
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-purple-400"></i>
            </div>
            
            <div class="flex gap-2 sm:gap-3 w-full sm:w-auto">
                <select id="statusFilter" class="flex-1 sm:flex-none glass-effect px-4 py-3 rounded-lg text-white border border-purple-500/30 focus:outline-none focus:border-purple-500 transition-all text-sm">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="belum">Belum Ada Harga</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block glass-effect rounded-xl border border-purple-500/30 overflow-hidden slide-in">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-purple-900/30 border-b border-purple-500/30">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase">Varian</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-purple-300 uppercase">Min. Unit</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-purple-300 uppercase">Harga Grosir</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-purple-300 uppercase">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-purple-300 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="wholesaleTableBody">
                    <?php if(!empty($wholesales)): ?>
                        <?php foreach($wholesales as $index => $item): 
                            $status = !empty($item['status']) ? $item['status'] : 'belum';
                        ?>
                        <tr class="table-row border-b border-purple-500/20" 
                            data-search="<?= strtolower($item['product_name'].' '.$item['variant_name']) ?>" 
                            data-status="<?= $status ?>">
                            <td class="px-6 py-4 text-white"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-white"><?= htmlspecialchars($item['product_name']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-purple-500/20 text-purple-300 text-xs rounded-full font-semibold">
                                    <?= htmlspecialchars($item['variant_name']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?= !empty($item['min_unit']) ? htmlspecialchars($item['min_unit']) : '<span class="text-purple-300 italic text-sm">-</span>' ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?= !empty($item['wholesale_price']) ? 
                                    '<span class="font-bold text-green-400">Rp '.number_format($item['wholesale_price'],0,',','.').'</span>' : 
                                    '<span class="text-purple-300 italic text-sm">-</span>' ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if($status === 'active'): ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400">Active</span>
                                <?php elseif($status === 'inactive'): ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-400">Inactive</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-400">Belum ada harga</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <?php if($status === 'belum'): ?>
                                       <button 
                                            onclick="openAddModal(<?= $item['variant_id'] ?>)"
                                            class="action-btn px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-lg text-xs font-semibold glow-effect">
                                            <i class="fas fa-plus mr-1"></i> Tambah Harga
                                        </button>

                                    <?php else: ?>
                                      <button 
                                        onclick='openEditModal(<?= json_encode($item) ?>)'
                                        class="action-btn w-9 h-9 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg flex items-center justify-center"
                                        title="Edit">
                                        <i class="fas fa-edit text-blue-400"></i>
                                    </button>

                                      <a href="/product_wholesale/delete/<?= $item['variant_id'] ?>" 
                                        onclick="return confirm('Yakin hapus harga grosir ini?')" 
                                        class="action-btn w-9 h-9 bg-red-500/20 hover:bg-red-500/30 rounded-lg flex items-center justify-center" 
                                        title="Hapus">
                                            <i class="fas fa-trash text-red-400"></i>
                                        </a>


                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-purple-300">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards View -->
    <div class="lg:hidden space-y-4 slide-in" id="wholesaleCards">
        <?php if(!empty($wholesales)): ?>
            <?php foreach($wholesales as $item): 
                $status = !empty($item['status']) ? $item['status'] : 'belum';
            ?>
            <div class="wholesale-card glass-effect rounded-xl p-4 border border-purple-500/30" 
                 data-search="<?= strtolower($item['product_name'].' '.$item['variant_name']) ?>" 
                 data-status="<?= $status ?>">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-semibold text-white mb-1"><?= htmlspecialchars($item['product_name']) ?></h3>
                        <span class="inline-block px-3 py-1 bg-purple-500/20 text-purple-300 text-xs rounded-full font-semibold">
                            <?= htmlspecialchars($item['variant_name']) ?>
                        </span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        <?= $status==='active'?'bg-green-500/20 text-green-400':'' ?>
                        <?= $status==='inactive'?'bg-red-500/20 text-red-400':'' ?>
                        <?= $status==='belum'?'bg-yellow-500/20 text-yellow-400':'' ?>
                    ">
                        <?= $status==='active'?'Active':($status==='inactive'?'Inactive':'Belum Set') ?>
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="glass-effect p-3 rounded-lg text-center">
                        <p class="text-purple-300 text-xs mb-1">Min. Unit</p>
                        <p class="<?= $status==='belum'?'text-purple-300 italic text-sm':'font-bold text-white' ?>">
                            <?= !empty($item['min_unit'])?$item['min_unit']:'-' ?>
                        </p>
                    </div>
                    <div class="glass-effect p-3 rounded-lg text-center">
                        <p class="text-purple-300 text-xs mb-1">Harga Grosir</p>
                        <p class="<?= $status==='belum'?'text-purple-300 italic text-sm':'font-bold text-green-400' ?>">
                            <?= !empty($item['wholesale_price']) ? 'Rp '.number_format($item['wholesale_price'],0,',','.') : '-' ?>
                        </p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <?php if($status==='belum'): ?>
                       <button 
                        onclick="openAddModal(<?= $item['variant_id'] ?>)"
                        class="action-btn w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 py-2.5 rounded-lg transition-all flex items-center justify-center gap-2 text-sm font-semibold glow-effect">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Harga Grosir</span>
                    </button>

                    <?php else: ?>
                       
                        <button 
                            type="button"
                            onclick='openEditModal(<?= json_encode($item) ?>)'
                            class="action-btn w-9 h-9 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg flex items-center justify-center"
                            title="Edit"
                        >
                            <i class="fas fa-edit text-blue-400"></i>
                        </button>
                  

                        <a href="/product_wholesale/delete/<?= $item['variant_id'] ?>" onclick="return confirm('Yakin hapus harga grosir ini?')" class="action-btn flex-1 bg-red-500/20 hover:bg-red-500/30 py-2.5 rounded-lg transition-all flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-trash text-red-400"></i>
                            <span>Hapus</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div id="emptyState" class="text-center py-16 glass-effect rounded-xl border border-purple-500/30">
                <i class="fas fa-search text-6xl text-purple-400/30 mb-4"></i>
                <p class="text-purple-200 text-lg mb-2">Tidak ada data ditemukan</p>
                <p class="text-purple-300 text-sm">Coba ubah filter pencarian Anda</p>
            </div>
        <?php endif; ?>
    </div>

</main>
<!-- Modal Background -->
<div id="wholesaleModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <!-- Modal Card -->
    <div class="bg-gradient-to-br from-purple-800 to-purple-900 rounded-xl w-full max-w-lg p-6 relative">
        <!-- Close Button -->
        <button id="closeModal" class="absolute top-4 right-4 text-white text-xl hover:text-purple-400">
            &times;
        </button>

        <!-- Modal Title -->
        <h2 id="modalTitle" class="text-xl font-semibold text-white mb-4">Tambah Harga Grosir</h2>

        <!-- Form -->
        <form id="wholesaleForm" method="POST" action="/product_wholesale/store">
            <input type="hidden" name="variant_id" id="variant_id">
            <input type="hidden" name="id" id="wholesale_id"> 

            <div class="mb-4">
                <label for="min_unit" class="block text-purple-300 text-sm font-medium mb-1">Min. Unit</label>
                <input type="number" name="min_unit" id="min_unit" placeholder="Contoh: 10"
                    class="w-full px-4 py-2 rounded-lg glass-effect text-white border border-purple-500/30 focus:outline-none focus:border-purple-400" required>
            </div>

            <div class="mb-4">
                <label for="wholesale_price" class="block text-purple-300 text-sm font-medium mb-1">Harga Grosir</label>
                <input type="number" name="wholesale_price" id="wholesale_price" placeholder="Contoh: 120000"
                    class="w-full px-4 py-2 rounded-lg glass-effect text-white border border-purple-500/30 focus:outline-none focus:border-purple-400" required>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-purple-300 text-sm font-medium mb-1">Status</label>
                <select name="status" id="status"
                    class="w-full px-4 py-2 rounded-lg glass-effect text-white border border-purple-500/30 focus:outline-none focus:border-purple-400">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="cancelBtn"
                    class="px-4 py-2 rounded-lg bg-gray-700/50 hover:bg-gray-700 text-white font-medium">Batal</button>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


    <script>
        // Search & Filter Logic
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const tableBody = document.getElementById('wholesaleTableBody');
        const cardsContainer = document.getElementById('wholesaleCards');
        const emptyState = document.getElementById('emptyState');

        function filterData() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();
            
            let visibleCount = 0;

            // Filter Desktop Table
            if (tableBody) {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const searchData = row.getAttribute('data-search') || '';
                    const statusData = row.getAttribute('data-status') || '';
                    
                    const matchesSearch = searchData.includes(searchTerm);
                    const matchesStatus = statusTerm === '' || statusData === statusTerm;
                    
                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Filter Mobile Cards
            if (cardsContainer) {
                const cards = cardsContainer.querySelectorAll('.wholesale-card');
                cards.forEach(card => {
                    const searchData = card.getAttribute('data-search') || '';
                    const statusData = card.getAttribute('data-status') || '';
                    
                    const matchesSearch = searchData.includes(searchTerm);
                    const matchesStatus = statusTerm === '' || statusData === statusTerm;
                    
                    if (matchesSearch && matchesStatus) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Show/Hide Empty State
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        // Event Listeners
        if (searchInput) {
            searchInput.addEventListener('input', filterData);
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', filterData);
        }

         // Elements
    const wholesaleModal = document.getElementById('wholesaleModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const modalTitle = document.getElementById('modalTitle');
    const wholesaleForm = document.getElementById('wholesaleForm');

    // Inputs
    const variantIdInput = document.getElementById('variant_id');
    const minUnitInput = document.getElementById('min_unit');
    const priceInput = document.getElementById('wholesale_price');
    const statusInput = document.getElementById('status');

    // Open Modal (Add)
    function openAddModal(variantId) {
        modalTitle.textContent = 'Tambah Harga Grosir';
        variantIdInput.value = variantId;
        minUnitInput.value = '';
        priceInput.value = '';
        statusInput.value = 'active';
        wholesaleForm.action = '/admin/wholesale-prices';
        wholesaleModal.classList.remove('hidden');
        wholesaleModal.classList.add('flex');
    }

    // Open Modal (Edit)
function openEditModal(item) {
    console.log('ITEM DARI BUTTON:', item); // 🔥 WAJIB

    modalTitle.textContent = 'Edit Harga Grosir';

    document.getElementById('wholesale_id').value = item.wholesale_id;
    variantIdInput.value = item.variant_id;
    minUnitInput.value = item.min_unit;
    priceInput.value = item.wholesale_price;
    statusInput.value = item.status;

    wholesaleForm.action = '/product_wholesale/update';
    wholesaleModal.classList.remove('hidden');
    wholesaleModal.classList.add('flex');
}






    // Close Modal
    function closeModalFunc() {
        wholesaleModal.classList.add('hidden');
        wholesaleModal.classList.remove('flex');
    }

    closeModal.addEventListener('click', closeModalFunc);
    cancelBtn.addEventListener('click', closeModalFunc);

    </script>
</body>
</html>