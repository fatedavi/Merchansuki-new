<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Order - Admin Merchansuki</title>
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
            background-color: #f3f4f6; /* Gray-100 */
            color: #1f2937; /* Gray-800 */
        }

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card {
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- HEADER -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <a href="/admin/dashboard" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors text-gray-600">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                            Order Management
                        </h1>
                        <p class="text-gray-500 text-xs sm:text-sm">Kelola Data Pesanan</p>
                    </div>
                </div>
                
                <a href="/admin/dashboard" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 text-sm font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 sm:px-6 py-8 lg:py-10">

        <!-- Stats & Actions Bar -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 slide-in">
            <!-- Total Orders -->
            <div class="stat-card bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm border-l-4 border-l-blue-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Orders</p>
                        <p class="text-2xl font-black text-gray-900"><?= count($orders) ?></p>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="stat-card bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm border-l-4 border-l-yellow-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Menunggu Bayar</p>
                        <p class="text-2xl font-black text-gray-900">
                            <?= count(array_filter($orders, fn($o) => $o['status'] === 'pending')) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Paid Orders -->
            <div class="stat-card bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm border-l-4 border-l-green-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Dibayar</p>
                        <p class="text-2xl font-black text-gray-900">
                            <?= count(array_filter($orders, fn($o) => $o['status'] === 'paid' || $o['status'] === 'settlement')) ?>
                        </p>
                    </div>
                </div>
            </div>

             <!-- Cancelled/Expired Orders -->
             <div class="stat-card bg-white rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm border-l-4 border-l-red-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center text-red-600">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Gagal/Batal</p>
                        <p class="text-2xl font-black text-gray-900">
                            <?= count(array_filter($orders, fn($o) => in_array($o['status'], ['expire', 'cancel', 'expired', 'cancelled']))) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-xl p-4 sm:p-6 mb-6 border border-gray-200 shadow-sm slide-in" style="animation-delay: 0.1s;">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="relative w-full sm:w-96">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Cari ID Order atau Nama Customer..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                
                <div class="flex gap-2 sm:gap-3 w-full sm:w-auto">
                    <select id="statusFilter" class="flex-1 sm:flex-none bg-gray-50 px-4 py-2.5 rounded-lg text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all text-sm cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="expired">Expired</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden slide-in" style="animation-delay: 0.2s;">
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID Order</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody" class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="hover:bg-gray-50 transition"
                                data-id="<?= $order['id'] ?>"
                                data-customer="<?= strtolower(htmlspecialchars($order['user_name'])) ?>"
                                data-status="<?= $order['status'] ?>">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">#<?= $order['id'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($order['user_name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= htmlspecialchars($order['user_email']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-right">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    $statusLabel = $order['status'];
                                    switch($order['status']) {
                                        case 'pending': $statusClass = 'bg-yellow-100 text-yellow-800'; break;
                                        case 'paid': 
                                        case 'settlement': $statusClass = 'bg-green-100 text-green-800'; $statusLabel = 'Paid'; break;
                                        case 'expire':
                                        case 'expired': $statusClass = 'bg-red-100 text-red-800'; $statusLabel = 'Expired'; break;
                                        case 'cancel':
                                        case 'cancelled': $statusClass = 'bg-red-100 text-red-800'; $statusLabel = 'Cancelled'; break;
                                    }
                                    ?>
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                        <?= strtoupper($statusLabel) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="/checkout/detail/<?= $order['id'] ?>" class="text-purple-600 hover:text-purple-900 font-medium inline-flex items-center gap-1" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-6 text-gray-500">Belum ada order.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4 p-4" id="orderCards">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm" 
                             data-id="<?= $order['id'] ?>"
                             data-customer="<?= strtolower(htmlspecialchars($order['user_name'])) ?>"
                             data-status="<?= $order['status'] ?>">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center font-bold text-sm text-gray-700">
                                        #<?= $order['id'] ?>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-sm text-gray-900"><?= htmlspecialchars($order['user_name']) ?></h3>
                                        <p class="text-xs text-gray-500"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
                                    </div>
                                </div>
                                <?php
                                $statusClass = 'bg-gray-100 text-gray-800';
                                $statusLabel = $order['status'];
                                switch($order['status']) {
                                    case 'pending': $statusClass = 'bg-yellow-100 text-yellow-800'; break;
                                    case 'paid': 
                                    case 'settlement': $statusClass = 'bg-green-100 text-green-800'; $statusLabel = 'Paid'; break;
                                    case 'expire':
                                    case 'expired': $statusClass = 'bg-red-100 text-red-800'; $statusLabel = 'Expired'; break;
                                    case 'cancel':
                                    case 'cancelled': $statusClass = 'bg-red-100 text-red-800'; $statusLabel = 'Cancelled'; break;
                                }
                                ?>
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                    <?= strtoupper($statusLabel) ?>
                                </span>
                            </div>
                            
                            <div class="space-y-2 mb-3 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500">Total Belanja</span>
                                    <span class="font-bold text-gray-900 text-sm">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="/checkout/detail/<?= $order['id'] ?>" 
                                   class="flex-1 bg-purple-50 hover:bg-purple-100 text-purple-600 py-2 rounded-lg flex items-center justify-center gap-2 transition-all text-sm font-medium border border-purple-200">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-shopping-cart text-6xl text-gray-200 mb-4"></i>
                        <p class="text-gray-500">Belum ada order.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>

    <script>
        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');

        function filterOrders() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatus = statusFilter.value;

            // Table rows (desktop)
            document.querySelectorAll('#orderTableBody tr[data-id]').forEach(row => {
                const id = row.getAttribute('data-id');
                const customer = row.getAttribute('data-customer');
                const status = row.getAttribute('data-status');
                
                const matchesSearch = id.includes(searchTerm) || customer.includes(searchTerm);
                const matchesStatus = !selectedStatus || status === selectedStatus || (selectedStatus === 'paid' && status === 'settlement') || (selectedStatus === 'cancelled' && status === 'cancel') || (selectedStatus === 'expired' && status === 'expire');
                
                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });

            // Card items (mobile)
            document.querySelectorAll('#orderCards > div[data-id]').forEach(card => {
                const id = card.getAttribute('data-id');
                const customer = card.getAttribute('data-customer');
                const status = card.getAttribute('data-status');
                
                const matchesSearch = id.includes(searchTerm) || customer.includes(searchTerm);
                const matchesStatus = !selectedStatus || status === selectedStatus || (selectedStatus === 'paid' && status === 'settlement') || (selectedStatus === 'cancelled' && status === 'cancel') || (selectedStatus === 'expired' && status === 'expire');
                
                card.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        if (searchInput && statusFilter) {
            searchInput.addEventListener('input', filterOrders);
            statusFilter.addEventListener('change', filterOrders);
        }
    </script>

</body>
</html>
