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
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .menu-card {
            transition: all 0.2s ease;
        }

        .menu-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- HEADER -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <!-- Logo & Title -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white shadow">
                        <i class="fas fa-crown text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                            Admin Dashboard
                        </h1>
                    </div>
                </div>

                <!-- User Info & Logout -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="px-3 py-1.5 rounded-full bg-gray-100 border border-gray-200 flex items-center gap-2">
                        <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 text-purple-600">
                            <i class="fas fa-user text-xs"></i>
                        </div>
                        <span class="text-gray-600 text-sm font-medium hidden sm:inline">
                            <?= htmlspecialchars($adminName) ?>
                        </span>
                    </div>
                    <a href="/auth/logout"
                       class="bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 border border-red-100 px-4 py-2 rounded-lg text-sm font-semibold transition-all flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 sm:px-6 py-8 lg:py-10">

        <!-- Welcome Section -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 mb-8 lg:mb-10 slide-in border border-gray-200 shadow-sm">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2 text-gray-900">
                        Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600"><?= htmlspecialchars($adminName) ?></span>! 👋
                    </h2>
                    <p class="text-gray-500 text-sm sm:text-base">
                        Kelola seluruh operasional Merchansuki dari sini
                    </p>
                </div>
                <div class="flex items-center gap-2 text-gray-500 bg-gray-50 px-4 py-2 rounded-lg border border-gray-100">
                    <i class="fas fa-calendar-alt text-purple-500"></i>
                    <span class="text-sm font-medium"><?= date('d M Y') ?></span>
                </div>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 lg:mb-10">

            <!-- Total Produk -->
            <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm slide-in" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                        <i class="fas fa-box text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Total Produk</p>
                        <p class="text-3xl font-black text-gray-900">
                            <?= count($products) ?>
                        </p>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-purple-500 h-1.5 rounded-full" style="width: 70%"></div>
                </div>
            </div>

            <!-- Total User -->
            <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm slide-in" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Total User</p>
                        <p class="text-3xl font-black text-gray-900">
                            <?= count($users) ?>
                        </p>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: 45%"></div>
                </div>
            </div>

        </div>

        <!-- MENU MANAGEMENT -->
        <div class="mb-6 lg:mb-8">
            <h3 class="text-xl font-bold mb-4 sm:mb-6 flex items-center gap-3 text-gray-800">
                <i class="fas fa-th-large text-purple-500"></i>
                <span>Management Menu</span>
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

            <!-- Kelola Produk -->
            <a href="/admin/products"
               class="menu-card block bg-white rounded-xl p-6 sm:p-8 border border-gray-200 hover:border-purple-300 transition-all duration-300 group">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i class="fas fa-box-open text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-2 text-gray-900">Kelola Produk</h4>
                        <p class="text-gray-500 text-sm">Manage produk dakimakura & merchandise</p>
                    </div>
                    <div class="flex items-center gap-2 text-purple-600 font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            <!-- Kelola User -->
            <a href="/admin/users"
               class="menu-card block bg-white rounded-xl p-6 sm:p-8 border border-gray-200 hover:border-blue-300 transition-all duration-300 group">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i class="fas fa-users-cog text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-2 text-gray-900">Kelola User</h4>
                        <p class="text-gray-500 text-sm">Manage user & customer data</p>
                    </div>
                    <div class="flex items-center gap-2 text-blue-600 font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            <!-- Kelola Order -->
            <a href="/admin/orders"
               class="menu-card block bg-white rounded-xl p-6 sm:p-8 border border-gray-200 hover:border-green-300 transition-all duration-300 group sm:col-span-2 lg:col-span-1">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i class="fas fa-receipt text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-2 text-gray-900">Kelola Order</h4>
                        <p class="text-gray-500 text-sm">Manage pesanan & transaksi</p>
                    </div>
                    <div class="flex items-center gap-2 text-green-600 font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <p class="text-gray-500 text-sm">
                &copy; 2026 <span class="font-bold text-gray-700">Merchansuki Admin Panel</span>. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>