<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Merchansuki</title>
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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-white">
    
    <?php include __DIR__ . '/../home/partials/navbar.php'; ?>

    <!-- Register Section -->
    <section class="flex items-center justify-center min-h-screen py-12 px-4">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center">
            
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex flex-col items-center justify-center space-y-6">
                <div class="float-animation">
                    <svg class="w-full max-w-md" viewBox="0 0 400 500">
                        <defs>
                            <linearGradient id="gradRegister" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#dbeafe;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#fce7f3;stop-opacity:1" />
                            </linearGradient>
                            <filter id="glowRegister">
                                <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                                <feMerge>
                                    <feMergeNode in="coloredBlur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>
                        <rect x="80" y="40" width="240" height="420" rx="25" fill="url(#gradRegister)" stroke="#3b82f6" stroke-width="4" filter="url(#glowRegister)"/>
                        <circle cx="200" cy="160" r="50" fill="#fff"/>
                        <circle cx="185" cy="155" r="10" fill="#1e1b4b"/>
                        <circle cx="215" cy="155" r="10" fill="#1e1b4b"/>
                        <path d="M 180 175 Q 200 185 220 175" stroke="#3b82f6" stroke-width="4" fill="none" stroke-linecap="round"/>
                        <ellipse cx="200" cy="120" rx="60" ry="50" fill="#60a5fa"/>
                        <circle cx="170" cy="155" r="8" fill="#ec4899" opacity="0.5"/>
                        <circle cx="230" cy="155" r="8" fill="#ec4899" opacity="0.5"/>
                        <text x="120" y="300" font-size="40" fill="#3b82f6" opacity="0.7">✨</text>
                        <text x="250" y="250" font-size="30" fill="#ec4899" opacity="0.7">♥</text>
                        <text x="270" y="350" font-size="25" fill="#fbbf24" opacity="0.7">★</text>
                    </svg>
                </div>
                <div class="text-center space-y-3">
                    <h2 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-400 to-pink-400 bg-clip-text text-transparent">
                        Join Merchansuki!
                    </h2>
                    <p class="text-purple-200 text-sm lg:text-base">
                        Daftar sekarang dan mulai koleksi dakimakura impianmu
                    </p>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="w-full max-w-md mx-auto lg:mx-0">
                <div class="glass-effect rounded-2xl shadow-2xl p-6 sm:p-8 lg:p-10">
                    <!-- Logo & Title -->
                    <div class="text-center mb-6 lg:mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-pink-500 rounded-full mb-4 glow-effect">
                            <i class="fas fa-user-plus text-white text-2xl sm:text-3xl"></i>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-400 to-pink-400 bg-clip-text text-transparent mb-2">
                            Create Account
                        </h2>
                        <p class="text-purple-200 text-xs sm:text-sm">
                            Bergabung dengan komunitas wibu Merchansuki
                        </p>
                    </div>

                    <!-- Error Message -->
                    <?php if (!empty($error)) : ?>
                        <div class="glass-effect border border-red-500/50 bg-red-500/10 text-red-200 p-3 rounded-lg mb-6 text-center text-sm flex items-center justify-center gap-2 fade-in">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?= htmlspecialchars($error) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Register Form -->
                    <form action="/auth/register" method="POST" class="space-y-4">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-white mb-2 font-medium text-sm sm:text-base">
                                <i class="fas fa-user mr-2 text-blue-400"></i>Nama Lengkap
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="w-full px-4 py-3 rounded-lg glass-effect text-white placeholder-purple-300 focus:outline-none border border-purple-500/30 input-glow transition-all duration-300 text-sm sm:text-base" 
                                placeholder="John Doe"
                                required
                            >
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-white mb-2 font-medium text-sm sm:text-base">
                                <i class="fas fa-envelope mr-2 text-blue-400"></i>Email
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
                                <i class="fas fa-lock mr-2 text-blue-400"></i>Password
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
                                    onclick="togglePassword('password', 'toggleIcon1')" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-purple-300 hover:text-white transition-colors"
                                >
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                            <!-- Password Strength Indicator -->
                            <div class="mt-2 hidden" id="password-strength">
                                <div class="flex gap-1">
                                    <div class="h-1 flex-1 rounded bg-white/20" id="strength-1"></div>
                                    <div class="h-1 flex-1 rounded bg-white/20" id="strength-2"></div>
                                    <div class="h-1 flex-1 rounded bg-white/20" id="strength-3"></div>
                                    <div class="h-1 flex-1 rounded bg-white/20" id="strength-4"></div>
                                </div>
                                <p class="text-xs mt-1 text-purple-300" id="strength-text">Password strength</p>
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div>
                            <label for="confirm_password" class="block text-white mb-2 font-medium text-sm sm:text-base">
                                <i class="fas fa-lock mr-2 text-blue-400"></i>Konfirmasi Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="confirm_password" 
                                    id="confirm_password" 
                                    class="w-full px-4 py-3 rounded-lg glass-effect text-white placeholder-purple-300 focus:outline-none border border-purple-500/30 input-glow transition-all duration-300 text-sm sm:text-base" 
                                    placeholder="••••••••"
                                    required
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('confirm_password', 'toggleIcon2')" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-purple-300 hover:text-white transition-colors"
                                >
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                            <!-- Password Match Indicator -->
                            <p class="text-xs mt-1 hidden" id="match-indicator"></p>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="flex items-start">
                            <input 
                                type="checkbox" 
                                name="terms" 
                                id="terms" 
                                class="mt-1 mr-3 rounded"
                                required
                            >
                            <label for="terms" class="text-purple-200 text-xs sm:text-sm">
                                Saya setuju dengan 
                                <a href="/terms" class="text-blue-400 hover:text-blue-300 underline">Terms & Conditions</a> 
                                dan 
                                <a href="/privacy" class="text-blue-400 hover:text-blue-300 underline">Privacy Policy</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-pink-600 hover:from-blue-700 hover:to-pink-700 py-3 sm:py-4 rounded-lg font-bold text-white transition-all duration-300 glow-effect text-sm sm:text-base"
                        >
                            <i class="fas fa-user-plus mr-2"></i>Create Account
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t border-purple-500/30"></div>
                        <span class="px-4 text-purple-300 text-xs sm:text-sm">OR</span>
                        <div class="flex-1 border-t border-purple-500/30"></div>
                    </div>

                    <!-- Social Register -->
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

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-purple-200 text-xs sm:text-sm">
                            Sudah punya akun? 
                            <a href="/auth/login" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">
                                Login Sekarang
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
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
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

        // Password Strength Checker
        const passwordInput = document.getElementById('password');
        const strengthIndicator = document.getElementById('password-strength');
        const strengthText = document.getElementById('strength-text');
        const strengthBars = [
            document.getElementById('strength-1'),
            document.getElementById('strength-2'),
            document.getElementById('strength-3'),
            document.getElementById('strength-4')
        ];

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if (password.length === 0) {
                strengthIndicator.classList.add('hidden');
                return;
            }
            
            strengthIndicator.classList.remove('hidden');
            
            let strength = 0;
            
            // Check length
            if (password.length >= 8) strength++;
            // Check lowercase
            if (/[a-z]/.test(password)) strength++;
            // Check uppercase
            if (/[A-Z]/.test(password)) strength++;
            // Check numbers or special chars
            if (/[0-9]/.test(password) || /[^a-zA-Z0-9]/.test(password)) strength++;
            
            // Reset bars
            strengthBars.forEach(bar => {
                bar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500');
                bar.classList.add('bg-white/20');
            });
            
            // Set strength bars and text
            const colors = ['bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
            const texts = ['Weak', 'Fair', 'Good', 'Strong'];
            
            for (let i = 0; i < strength; i++) {
                strengthBars[i].classList.remove('bg-white/20');
                strengthBars[i].classList.add(colors[strength - 1]);
            }
            
            strengthText.textContent = texts[strength - 1] || 'Weak';
            strengthText.className = 'text-xs mt-1 ' + (strength <= 1 ? 'text-red-400' : strength === 2 ? 'text-yellow-400' : strength === 3 ? 'text-blue-400' : 'text-green-400');
        });

        // Password Match Checker
        const confirmPasswordInput = document.getElementById('confirm_password');
        const matchIndicator = document.getElementById('match-indicator');

        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword.length === 0) {
                matchIndicator.classList.add('hidden');
                return;
            }
            
            matchIndicator.classList.remove('hidden');
            
            if (password === confirmPassword) {
                matchIndicator.textContent = '✓ Password cocok';
                matchIndicator.className = 'text-xs mt-1 text-green-400';
            } else {
                matchIndicator.textContent = '✗ Password tidak cocok';
                matchIndicator.className = 'text-xs mt-1 text-red-400';
            }
        });

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