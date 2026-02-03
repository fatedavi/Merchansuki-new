<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchansuki - Premium Anime Dakimakura Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        // Warna disesuaikan dengan karakter (Kuning rambut, Merah mata, Biru baju)
                        primary: '#fbbf24',   
                        secondary: '#3b82f6', 
                        accent: '#ef4444', 
                        darkBg: '#121212',
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
            background-color: #ffffff;
            color: #1f2937;
        }

        .gradient-bg {
            background-color: #ffffff;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #fbbf24;
            border-radius: 10px;
        }

        .carousel-container {
            position: relative;
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            min-width: 100%;
            flex-shrink: 0;
        }

        .carousel-slide img {
            width: 90%;
            height: 90%;
            object-fit: cover;
        }

        .glass-effect {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .badge-pulse {
            animation: pulse-badge 2s ease-in-out infinite;
        }

        .glow-effect {
            box-shadow: 0 4px 10px rgba(251, 191, 36, 0.3);
        }

        .glow-effect:hover {
            box-shadow: 0 6px 20px rgba(251, 191, 36, 0.5);
        }

        .banner-placeholder {
            background: linear-gradient(135deg, #fbbf24 0%, #ef4444 100%);
            position: relative;
            overflow: hidden;
        }

        .banner-placeholder::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            100% { left: 100%; }
        }
    </style>
</head>
<body class="gradient-bg text-gray-800">
  
    <?php include __DIR__ . '/partials/navbar.php'; ?>
    <?php include __DIR__ . '/partials/hero.php'; ?>
    <?php include __DIR__ . '/partials/features.php'; ?>

<section class="max-w-7xl mx-auto px-4 mt-10">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-400 via-orange-500 to-red-500 shadow-xl">

        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_1px_1px,_white_1px,_transparent_0)] bg-[size:24px_24px]"></div>

<div class="relative overflow-hidden rounded-3xl bg-orange-500 shadow-xl">

        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_1px_1px,_white_1px,_transparent_0)] bg-[size:24px_24px]"></div>

        <div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-8 px-8 py-14">

            <div class="flex justify-center lg:justify-start">
                <img 
                    src="/assets/images/Anya_Forger_Anime_png.png"
                    alt="Hero Character"
                    class="max-h-[420px] drop-shadow-2xl">
            </div>

            <div class="text-white space-y-5">

                <span class="inline-block bg-white/20 text-sm px-4 py-1 rounded-full backdrop-blur font-bold">
                    MENERIMA PESANAN
                </span>

                <h1 class="text-3xl md:text-4xl xl:text-5xl font-bold leading-tight">
                    CUSTOM SELURUH DUNIA
                </h1>

                <p class="text-white/90 max-w-xl">
                    Kami menerima pesanan import dari seluruh dunia, dengan Jepang
                    sebagai negara utama. Hubungi kami untuk info lebih lanjut!
                </p>

                <div class="flex items-center gap-4 pt-4">
                    <a href="#"
                       class="bg-white text-orange-500 font-bold px-8 py-3 rounded-full hover:bg-orange-50 transition shadow-lg">
                        Info Lebih Lanjut
                    </a>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>

<section class="py-12 sm:py-16 lg:py-20 xl:py-24 bg-gray-50">
    <div class="container mx-auto px-4">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 sm:mb-10 lg:mb-12 gap-4">
    <div>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-orange-500">
            Recomended Collection
        </h2>
        <p class="text-gray-500 text-xs sm:text-sm lg:text-base mt-1">
            Koleksi Terbaru & Paling Laris
        </p>
        <div class="h-1 w-20 bg-orange-500 mt-3 rounded-full"></div>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
    <?php foreach ($products as $product): ?>
        <div class="product-card glass-effect rounded-xl lg:rounded-2xl overflow-hidden group relative flex flex-col h-full transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer"
             onclick="window.location.href='/product/<?= $product['id'] ?>'">

            <div class="relative w-full h-40 sm:h-48 lg:h-64 overflow-hidden">
                <?php if (!empty($product['variants'])): ?>
                    <div class="variant-slider relative w-full h-full">
                        <?php foreach ($product['variants'] as $index => $variant): ?>
                            <img 
                                src="<?= !empty($variant['image']) ? "/assets/images/images_save/" . htmlspecialchars($variant['image']) : "/assets/images/no-image.png" ?>" 
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="absolute top-0 left-0 w-full h-full object-cover transition-opacity duration-1000 <?= $index === 0 ? 'opacity-100' : 'opacity-0' ?>"
                            >
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="w-full h-full bg-gray-100 flex flex-col items-center justify-center">
                        <i class="fas fa-image text-gray-300 text-4xl mb-2"></i>
                        <span class="text-[10px] text-gray-400">No Image</span>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($product['highlight']) && $product['highlight']): ?>
                    <div class="absolute top-2 left-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg uppercase tracking-wider">
                        Recomended
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-3 sm:p-4 lg:p-5 flex flex-col flex-grow bg-white">
                <h3 class="text-sm sm:text-base font-bold mb-1 line-clamp-1 text-gray-800 group-hover:text-purple-600 transition-colors">
                    <?= htmlspecialchars($product['name']) ?>
                </h3>

                <p class="text-gray-500 text-[10px] sm:text-xs mb-3 line-clamp-2 leading-relaxed">
                    <?= htmlspecialchars($product['description'] ?? 'Premium quality products for you.') ?>
                </p>

                   <div class="flex items-center justify-between mb-3">
                <?php
                    $price = !empty($product['variants']) ? min(array_column($product['variants'], 'price')) : 0;
                ?>
             <?php
                if (!empty($product['variants'])) {
                    $prices = array_column($product['variants'], 'price');
                    $minPrice = min($prices);
                    $maxPrice = max($prices);
                    $priceText = $minPrice !== $maxPrice
                        ? 'Rp ' . number_format($minPrice, 0, ',', '.') . ' - Rp ' . number_format($maxPrice, 0, ',', '.')
                        : 'Rp ' . number_format($minPrice, 0, ',', '.');
                } else {
                    $priceText = 'Belum ada varian';
                }
                ?>
                        <div class="mt-auto space-y-1">
                <div class="text-[10px] sm:text-xs font-bold uppercase tracking-widest text-gray-400">
                    Price Range
                </div>
                
                <div class="flex items-baseline gap-1">
                    <span class="text-lg sm:text-xl lg:text-2xl font-black text-gray-900 tracking-tight">
                        <?= $priceText ?>
                    </span>
                </div>
            </div>


            </div>

                <button 
                        class="w-full bg-red-500 hover:bg-red-600 py-2.5 rounded-lg font-black text-[10px] sm:text-xs text-white uppercase tracking-widest shadow-md hover:shadow-red-500/40 transition-all active:scale-95">
                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</section>
    
    <?php include __DIR__ . '/partials/footer.php'; ?>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Carousel Logic
        const track = document.getElementById('carousel-track');
        const slides = document.querySelectorAll('.carousel-slide');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const indicators = document.querySelectorAll('.carousel-indicator');
        
        if (track && slides.length > 0) {
            let currentSlide = 0;
            const totalSlides = slides.length;

            function updateCarousel() {
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.add('bg-white');
                        indicator.classList.remove('bg-white/50');
                    } else {
                        indicator.classList.remove('bg-white');
                        indicator.classList.add('bg-white/50');
                    }
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }

            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
            if (prevBtn) prevBtn.addEventListener('click', prevSlide);

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentSlide = index;
                    updateCarousel();
                });
            });

            // Auto-play carousel
            setInterval(nextSlide, 5000);
            updateCarousel();
        }

        // Slider varian gambar
        document.querySelectorAll('.variant-slider').forEach(slider => {
            const slides = slider.querySelectorAll('img');
            let current = 0;

            if (slides.length <= 1) return; // Kalau cuma 1 varian, skip slider

            setInterval(() => {
                slides[current].classList.remove('opacity-100');
                slides[current].classList.add('opacity-0');

                current = (current + 1) % slides.length;

                slides[current].classList.remove('opacity-0');
                slides[current].classList.add('opacity-100');
            }, 3000); // ganti gambar tiap 3 detik
        });
    </script>
</body>
</html>