<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Merchansuki</title>
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

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- NAVBAR SEDERHANA UNTUK PAGE INI -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="text-2xl font-black text-orange-500 hover:text-orange-600 transition">
                    Merchansuki
                </a>
                <a href="/profile" class="flex items-center gap-2 text-gray-600 hover:text-orange-500 transition-colors font-medium">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Profil</span>
                </a>
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="container mx-auto px-4 sm:px-6 py-8 lg:py-12">
        <div class="flex items-center gap-4 mb-8 slide-in">
            <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-shopping-bag text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
                <p class="text-gray-500 text-sm">Daftar semua transaksi yang pernah kamu lakukan</p>
            </div>
        </div>

        <div class="space-y-4 slide-in" style="animation-delay: 0.1s;">
            <?php if (empty($orders)): ?>
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-200 shadow-sm">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                         <i class="fas fa-shopping-cart text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Belum ada pesanan</h3>
                    <p class="text-gray-500 mb-6">Kamu belum pernah belanja nih. Yuk cari barang impianmu!</p>
                    <a href="/catalog" class="inline-flex items-center gap-2 bg-orange-500 text-white px-8 py-3 rounded-full font-bold hover:bg-orange-600 hover:shadow-lg transition-all transform hover:-translate-y-1">
                        <i class="fas fa-search"></i> Cari Produk
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="bg-white rounded-xl p-5 sm:p-6 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                            
                            <!-- Kiri: Info Utama -->
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 border border-gray-100 text-gray-400">
                                    <i class="fas fa-receipt text-lg"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <h3 class="font-bold text-lg text-gray-900">Order #<?= $order['id'] ?></h3>
                                        <!-- Status Badge -->
                                        <?php
                                        $statusClass = 'bg-gray-100 text-gray-600';
                                        $statusText = $order['status'];
                                        $statusIcon = 'fa-question';
                                        
                                        switch ($order['status']) {
                                            case 'pending': 
                                                $statusClass = 'bg-yellow-100 text-yellow-700 border border-yellow-200'; 
                                                $statusText = 'Menunggu Pembayaran'; 
                                                $statusIcon = 'fa-clock';
                                                break;
                                            case 'paid': 
                                            case 'settlement': 
                                                $statusClass = 'bg-green-100 text-green-700 border border-green-200'; 
                                                $statusText = 'Lunas / Diproses'; 
                                                $statusIcon = 'fa-check';
                                                break;
                                            case 'expire':
                                            case 'expired':
                                                $statusClass = 'bg-red-100 text-red-700 border border-red-200'; 
                                                $statusText = 'Kadaluarsa';
                                                $statusIcon = 'fa-times';
                                                break;
                                            case 'cancel':
                                            case 'cancelled':
                                                $statusClass = 'bg-red-100 text-red-700 border border-red-200'; 
                                                $statusText = 'Dibatalkan';
                                                $statusIcon = 'fa-ban';
                                                break;
                                        }
                                        ?>
                                        <span class="text-[10px] sm:text-xs px-2.5 py-1 rounded-full font-semibold flex items-center gap-1.5 <?= $statusClass ?>">
                                            <i class="fas <?= $statusIcon ?> text-[10px]"></i> <?= strtoupper($statusText) ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 font-medium">
                                        <i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Kanan: Total & Action -->
                            <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-2 w-full md:w-auto mt-2 md:mt-0 pt-3 md:pt-0 border-t border-gray-100 md:border-t-0">
                                <div class="text-left md:text-right">
                                    <p class="text-xs text-gray-500 mb-0.5">Total Belanja</p>
                                    <p class="font-bold text-lg text-gray-900">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></p>
                                </div>
                                <a href="/checkout/detail/<?= $order['id'] ?>" class="px-5 py-2 bg-white border border-gray-300 hover:border-orange-500 text-gray-700 hover:text-orange-500 rounded-lg text-sm font-semibold transition-all flex items-center gap-2 shadow-sm hover:shadow">
                                    <span>Detail</span>
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
