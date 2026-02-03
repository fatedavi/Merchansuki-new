<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Merchansuki</title>
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

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
        }

        .menu-card {
            transition: all 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-5px) scale(1.02);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-white">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 glass-effect border-b border-purple-500/30 shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <!-- Logo & Title -->
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center glow-effect">
                        <i class="fas fa-crown text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                            Admin Dashboard
                        </h1>
                        <p class="text-purple-300 text-xs sm:text-sm">Merchansuki Management</p>
                    </div>
                </div>

                <!-- User Info & Logout -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="glass-effect px-4 py-2 rounded-full flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <span class="text-purple-200 text-sm font-medium hidden sm:inline">
                            <?= htmlspecialchars($adminName) ?>
                        </span>
                    </div>
                    <a href="/auth/logout"
                       class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 glow-effect flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 sm:px-6 py-8 lg:py-12">

        <!-- Welcome Section -->
        <div class="glass-effect rounded-2xl p-6 sm:p-8 mb-8 lg:mb-10 slide-in border border-purple-500/30">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2">
                        Welcome back, <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent"><?= htmlspecialchars($adminName) ?></span>! 👋
                    </h2>
                    <p class="text-purple-200 text-sm sm:text-base">
                        Kelola seluruh operasional Merchansuki dari sini
                    </p>
                </div>
                <div class="flex items-center gap-2 text-purple-300">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="text-sm"><?= date('d M Y') ?></span>
                </div>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 lg:mb-10">

            <!-- Total Produk -->
            <div class="stat-card glass-effect rounded-xl sm:rounded-2xl p-6 border border-purple-500/30 slide-in" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center glow-effect">
                        <i class="fas fa-box text-white text-2xl sm:text-3xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-purple-300 text-xs sm:text-sm mb-1">Total Produk</p>
                        <p class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                            <?= count($products) ?>
                        </p>
                    </div>
                </div>
                
            </div>

            <!-- Total User -->
            <div class="stat-card glass-effect rounded-xl sm:rounded-2xl p-6 border border-purple-500/30 slide-in" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center glow-effect">
                        <i class="fas fa-users text-white text-2xl sm:text-3xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-purple-300 text-xs sm:text-sm mb-1">Total User</p>
                        <p class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">
                            <?= count($users) ?>
                        </p>
                    </div>
                </div>
                
            </div>

            <!-- Total Order -->
            <!-- <div class="stat-card glass-effect rounded-xl sm:rounded-2xl p-6 border border-purple-500/30 slide-in sm:col-span-2 lg:col-span-1" style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center glow-effect">
                        <i class="fas fa-shopping-cart text-white text-2xl sm:text-3xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-purple-300 text-xs sm:text-sm mb-1">Total Order</p>
                        <p class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-green-400 to-emerald-400 bg-clip-text text-transparent">
                            <?= $totalOrders ?>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-green-400 text-xs sm:text-sm">
                    <i class="fas fa-arrow-up"></i>
                    <span>+25% dari bulan lalu</span>
                </div>
            </div> -->

        </div>

        <!-- MENU MANAGEMENT -->
        <div class="mb-6 lg:mb-8">
            <h3 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 flex items-center gap-3">
                <i class="fas fa-th-large text-purple-400"></i>
                <span>Management Menu</span>
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

            <!-- Kelola Produk -->
            <a href="/admin/products"
               class="menu-card block glass-effect rounded-xl sm:rounded-2xl p-6 sm:p-8 border border-purple-500/30 hover:border-purple-500/60 transition-all duration-300 group">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center glow-effect group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-box-open text-white text-3xl sm:text-4xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl font-bold mb-2">Kelola Produk</h4>
                        <p class="text-purple-300 text-xs sm:text-sm">Manage produk dakimakura & merchandise</p>
                    </div>
                    <div class="flex items-center gap-2 text-purple-400 group-hover:text-purple-300 transition-colors">
                        <span class="text-sm font-semibold">Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            <!-- Kelola User -->
            <a href="/admin/users"
               class="menu-card block glass-effect rounded-xl sm:rounded-2xl p-6 sm:p-8 border border-blue-500/30 hover:border-blue-500/60 transition-all duration-300 group">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center glow-effect group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users-cog text-white text-3xl sm:text-4xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl font-bold mb-2">Kelola User</h4>
                        <p class="text-purple-300 text-xs sm:text-sm">Manage user & customer data</p>
                    </div>
                    <div class="flex items-center gap-2 text-blue-400 group-hover:text-blue-300 transition-colors">
                        <span class="text-sm font-semibold">Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            <!-- Kelola Order -->
            <a href="/admin/orders"
               class="menu-card block glass-effect rounded-xl sm:rounded-2xl p-6 sm:p-8 border border-green-500/30 hover:border-green-500/60 transition-all duration-300 group sm:col-span-2 lg:col-span-1">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center glow-effect group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-receipt text-white text-3xl sm:text-4xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl font-bold mb-2">Kelola Order</h4>
                        <p class="text-purple-300 text-xs sm:text-sm">Manage pesanan & transaksi</p>
                    </div>
                    <div class="flex items-center gap-2 text-green-400 group-hover:text-green-300 transition-colors">
                        <span class="text-sm font-semibold">Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

        </div>

        <!-- Quick Actions -->
        <div class="mt-8 lg:mt-10">
            <h3 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 flex items-center gap-3">
                <i class="fas fa-bolt text-yellow-400"></i>
                <span>Quick Actions</span>
            </h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                <a href="/admin/products/add" class="glass-effect rounded-xl p-4 border border-purple-500/30 hover:border-purple-500/60 transition-all text-center group">
                    <i class="fas fa-plus-circle text-2xl sm:text-3xl text-purple-400 group-hover:scale-110 transition-transform mb-2"></i>
                    <p class="text-xs sm:text-sm font-medium">Add Product</p>
                </a>
                
                <a href="/admin/categories" class="glass-effect rounded-xl p-4 border border-blue-500/30 hover:border-blue-500/60 transition-all text-center group">
                    <i class="fas fa-tags text-2xl sm:text-3xl text-blue-400 group-hover:scale-110 transition-transform mb-2"></i>
                    <p class="text-xs sm:text-sm font-medium">Categories</p>
                </a>
                
                <a href="/admin/reports" class="glass-effect rounded-xl p-4 border border-green-500/30 hover:border-green-500/60 transition-all text-center group">
                    <i class="fas fa-chart-line text-2xl sm:text-3xl text-green-400 group-hover:scale-110 transition-transform mb-2"></i>
                    <p class="text-xs sm:text-sm font-medium">Reports</p>
                </a>
                
                <a href="/admin/settings" class="glass-effect rounded-xl p-4 border border-yellow-500/30 hover:border-yellow-500/60 transition-all text-center group">
                    <i class="fas fa-cog text-2xl sm:text-3xl text-yellow-400 group-hover:scale-110 transition-transform mb-2"></i>
                    <p class="text-xs sm:text-sm font-medium">Settings</p>
                </a>
                
                <a href="/admin/notifications" class="glass-effect rounded-xl p-4 border border-pink-500/30 hover:border-pink-500/60 transition-all text-center group relative">
                    <i class="fas fa-bell text-2xl sm:text-3xl text-pink-400 group-hover:scale-110 transition-transform mb-2"></i>
                    <p class="text-xs sm:text-sm font-medium">Notifications</p>
                    <span class="absolute top-2 right-2 w-3 h-3 bg-red-500 rounded-full pulse-animation"></span>
                </a>
                
                <a href="/admin/support" class="glass-effect rounded-xl p-4 border border-orange-500/30 hover:border-orange-500/60 transition-all text-center group">
                    <i class="fas fa-life-ring text-2xl sm:text-3xl text-orange-400 group-hover:scale-110 transition-transform mb-2"></i>
                    <p class="text-xs sm:text-sm font-medium">Support</p>
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="glass-effect border-t border-purple-500/30 py-6 mt-12">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <p class="text-purple-200 text-xs sm:text-sm">
                &copy; 2026 Merchansuki Admin Panel. All rights reserved. Made with <i class="fas fa-heart text-pink-400"></i> for Wibu Community
            </p>
        </div>
    </footer>

</body>
</html>