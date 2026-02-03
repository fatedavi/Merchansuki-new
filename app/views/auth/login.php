<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Merchansuki</title>
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .input-glow:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.5);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-white">
    
    <?php include __DIR__ . '/../home/partials/navbar.php'; ?>

    <!-- Login Section -->
    <section class="flex items-center justify-center min-h-screen py-12 px-4">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center">
            
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex flex-col items-center justify-center space-y-6">
                <div class="float-animation">
                    <svg class="w-full max-w-md" viewBox="0 0 400 500">
                        <defs>
                            <linearGradient id="gradLogin" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#fce7f3;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#e9d5ff;stop-opacity:1" />
                            </linearGradient>
                            <filter id="glowLogin">
                                <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                                <feMerge>
                                    <feMergeNode in="coloredBlur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>
                        <rect x="80" y="40" width="240" height="420" rx="25" fill="url(#gradLogin)" stroke="#ec4899" stroke-width="4" filter="url(#glowLogin)"/>
                        <circle cx="200" cy="160" r="50" fill="#ffd8e8"/>
                        <circle cx="185" cy="155" r="10" fill="#1e1b4b"/>
                        <circle cx="215" cy="155" r="10" fill="#1e1b4b"/>
                        <path d="M 180 175 Q 200 185 220 175" stroke="#ec4899" stroke-width="4" fill="none" stroke-linecap="round"/>
                        <ellipse cx="200" cy="120" rx="60" ry="50" fill="#c084fc"/>
                        <circle cx="170" cy="155" r="8" fill="#ec4899" opacity="0.5"/>
                        <circle cx="230" cy="155" r="8" fill="#ec4899" opacity="0.5"/>
                        <text x="120" y="280" font-size="40" fill="#ec4899" opacity="0.7">♥</text>
                        <text x="270" y="220" font-size="30" fill="#fbbf24" opacity="0.7">★</text>
                        <text x="250" y="320" font-size="25" fill="#c084fc" opacity="0.7">✨</text>
                    </svg>
                </div>
                <div class="text-center space-y-3">
                    <h2 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        Welcome Back!
                    </h2>
                    <p class="text-purple-200 text-sm lg:text-base">
                        Login untuk akses koleksi dakimakura premium
                    </p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full max-w-md mx-auto lg:mx-0">
                <div class="glass-effect rounded-2xl shadow-2xl p-6 sm:p-8 lg:p-10">
                    <!-- Logo & Title -->
                    <div class="text-center mb-6 lg:mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full mb-4 glow-effect">
                            <i class="fas fa-heart text-white text-2xl sm:text-3xl"></i>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                            Login to Merchansuki
                        </h2>
                        <p class="text-purple-200 text-xs sm:text-sm">
                            Masuk untuk melanjutkan belanja
                        </p>
                    </div>

                    <!-- Error Message -->
                    <?php if (!empty($error)) : ?>
                        <div class="glass-effect border border-red-500/50 bg-red-500/10 text-red-200 p-3 rounded-lg mb-6 text-center text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?= htmlspecialchars($error) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form action="/auth/login" method="POST" class="space-y-5">
                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-white mb-2 font-medium text-sm sm:text-base">
                                <i class="fas fa-envelope mr-2 text-purple-400"></i>Email
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="w-full px-4 py-3 rounded-lg glass-effect text-white placeholder-purple-300 focus:outline-none border border-purple-500/30 input-glow transition-all duration-300 text-sm sm:text-base" 
                                placeholder="your@email.com"
                                required
                            >
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-white mb-2 font-medium text-sm sm:text-base">
                                <i class="fas fa-lock mr-2 text-purple-400"></i>Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    class="w-full px-4 py-3 rounded-lg glass-effect text-white placeholder-purple-300 focus:outline-none border border-purple-500/30 input-glow transition-all duration-300 text-sm sm:text-base" 
                                    placeholder="••••••••"
                                    required
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword()" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-purple-300 hover:text-white transition-colors"
                                >
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-xs sm:text-sm">
                            <label class="flex items-center text-purple-200 cursor-pointer">
                                <input type="checkbox" name="remember" class="mr-2 rounded">
                                <span>Remember me</span>
                            </label>
                            <a href="/auth/forgot-password" class="text-purple-300 hover:text-white transition-colors">
                                Forgot Password?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 py-3 sm:py-4 rounded-lg font-bold text-white transition-all duration-300 glow-effect text-sm sm:text-base"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t border-purple-500/30"></div>
                        <span class="px-4 text-purple-300 text-xs sm:text-sm">OR</span>
                        <div class="flex-1 border-t border-purple-500/30"></div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <button class="glass-effect hover:bg-white/10 border border-purple-500/30 py-3 rounded-lg font-semibold text-white transition-all duration-300 flex items-center justify-center gap-2 text-sm">
                            <i class="fab fa-google text-red-400"></i>
                            <span class="hidden sm:inline">Google</span>
                        </button>
                        <button class="glass-effect hover:bg-white/10 border border-purple-500/30 py-3 rounded-lg font-semibold text-white transition-all duration-300 flex items-center justify-center gap-2 text-sm">
                            <i class="fab fa-facebook text-blue-400"></i>
                            <span class="hidden sm:inline">Facebook</span>
                        </button>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-purple-200 text-xs sm:text-sm">
                            Belum punya akun? 
                            <a href="/auth/register" class="text-pink-400 hover:text-pink-300 font-semibold transition-colors">
                                Daftar Sekarang
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-6">
                    <a href="/" class="inline-flex items-center gap-2 text-purple-300 hover:text-white transition-colors text-sm sm:text-base">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Homepage</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Mobile Menu Toggle (if navbar has mobile menu)
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>