<nav class="sticky top-0 z-50 bg-blue-600 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-3 lg:py-4">
            <a href="/" class="flex items-center space-x-2 lg:space-x-3 group">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-heart text-blue-600 text-lg lg:text-xl"></i>
                </div>
                <span class="text-xl lg:text-2xl font-bold text-white">
                    Merchansuki
                </span>
            </a>

            <div class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                <a href="/"class="text-blue-50 hover:text-white transition-colors duration-300 font-medium text-sm xl:text-base">Home</a>
                <a href="#" class="text-blue-50 hover:text-white transition-colors duration-300 font-medium text-sm xl:text-base">Dakimakura</a>
                <a href="#" class="text-blue-50 hover:text-white transition-colors duration-300 font-medium text-sm xl:text-base">Custom Print</a>
                <a href="/catalog" class="text-blue-50 hover:text-white transition-colors duration-300 font-medium text-sm xl:text-base">Catalog Produk</a>
                <a href="#" class="text-blue-50 hover:text-white transition-colors duration-300 font-medium text-sm xl:text-base">About</a>
                
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/admin/dashboard"
                    class="bg-white/20 text-white px-3 py-1 rounded font-bold transition-colors duration-300 text-sm">
                        Dashboard Admin
                    </a>
                <?php endif; ?>
            </div>

            <div class="flex items-center space-x-3 lg:space-x-4">
                <button class="hidden md:block text-blue-100 hover:text-white transition-colors">
                    <i class="fas fa-search text-base lg:text-lg"></i>
                </button>

                <a href="/cart" class="relative text-blue-100 hover:text-white transition-colors">
                    <i class="fas fa-shopping-cart text-base lg:text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full
                                 w-4 h-4 lg:w-5 lg:h-5 flex items-center justify-center font-bold cart-count">
                        <?= isset($_SESSION['cart']['total_quantity']) ? (int) $_SESSION['cart']['total_quantity'] : 0 ?>
                    </span>
                </a>
                

       <?php if (isset($_SESSION['user']) && is_array($_SESSION['user'])): ?>
    <?php
    // Cek apakah profile lengkap (hanya jika user login)
    $profileComplete = true;
    if (isset($_SESSION['user']['id'])) {
        try {
            $profileModel = new Profile();
            $profile = $profileModel->findByUserId($_SESSION['user']['id']);
            $profileComplete = $profileModel->isComplete($profile);
        } catch (Exception $e) {
            // Jika error, anggap belum lengkap
            $profileComplete = false;
        }
    }
    ?>
    <div class="relative group hidden md:block">
        <button
            class="flex items-center space-x-2 bg-orange-500 px-4 py-2 rounded-lg font-semibold text-white
                    hover:bg-orange-600 transition-all duration-300 shadow-sm relative">
            <i class="fas fa-user"></i>
            <span><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
            <i class="fas fa-chevron-down text-xs ml-1"></i>
            <?php if (!$profileComplete): ?>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold" title="Profile belum lengkap">
                    !
                </span>
            <?php endif; ?>
        </button>

        <div
            class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-lg shadow-xl
                    opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100
                    transition-all duration-200 z-50 invisible group-hover:visible">

            <a href="/profile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-t-lg transition-colors relative">
                <i class="fas fa-id-card mr-2 opacity-70"></i> Profile
                <?php if (!$profileComplete): ?>
                    <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full font-bold">!</span>
                <?php endif; ?>
            </a>

            <a href="/auth/logout"
                class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-lg transition-colors">
                <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Logout
            </a>
        </div>
    </div>

<?php else: ?>
    <a href="/auth/login"
        class="hidden md:block bg-orange-500 hover:bg-orange-600 px-4 lg:px-6 py-2 rounded-lg font-semibold text-white
                text-sm lg:text-base transition-all duration-300 shadow-md text-center">
        Login
    </a>
<?php endif; ?>

                <button class="lg:hidden text-white" id="mobile-menu-btn">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <div class="lg:hidden hidden pb-6 border-t border-blue-500 mt-2" id="mobile-menu">
            <div class="flex flex-col space-y-4 pt-4">
                <a href="/"class="text-blue-50 hover:text-white transition-colors py-1 text-sm font-medium">Home</a>
                <a href="#" class="text-blue-50 hover:text-white transition-colors py-1 text-sm font-medium">Dakimakura</a>
                <a href="" class="text-blue-50 hover:text-white transition-colors py-1 text-sm font-medium">Custom Print</a>
                <a href="/catalog" class="text-blue-50 hover:text-white transition-colors py-1 text-sm font-medium">Catalog Produk</a>
                <a href="#" class="text-blue-50 hover:text-white transition-colors py-1 text-sm font-medium">About</a>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <?php
                    // Cek profile untuk mobile menu juga
                    $profileCompleteMobile = true;
                    if (isset($_SESSION['user']['id'])) {
                        try {
                            $profileModelMobile = new Profile();
                            $profileMobile = $profileModelMobile->findByUserId($_SESSION['user']['id']);
                            $profileCompleteMobile = $profileModelMobile->isComplete($profileMobile);
                        } catch (Exception $e) {
                            $profileCompleteMobile = false;
                        }
                    }
                    ?>
                    <div class="py-2 border-t border-blue-500/50">
                        <p class="text-white font-bold mb-2">Halo, <?= htmlspecialchars($_SESSION['user']['name']) ?></p>
                        <a href="/profile" class="text-blue-200 text-sm font-semibold mb-2 block">
                            <i class="fas fa-id-card mr-1"></i> Profile
                            <?php if (!$profileCompleteMobile): ?>
                                <span class="ml-2 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">Belum Lengkap</span>
                            <?php endif; ?>
                        </a>
                        <a href="/auth/logout" class="text-red-300 text-sm font-bold">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="/auth/login" class="bg-orange-500 hover:bg-orange-600 px-6 py-2 rounded-lg font-semibold text-sm text-white text-center block shadow-md transition-all">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>