<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Merchansuki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%); }
        .glass-effect { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .glow-effect { box-shadow: 0 0 20px rgba(139, 92, 246, 0.5); }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade { animation: fadeIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 text-white">

    <div class="w-full max-w-md animate-fade">
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl items-center justify-center glow-effect mb-4">
                <i class="fas fa-key text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                Merchansuki
            </h1>
        </div>

        <div class="glass-effect rounded-3xl p-6 sm:p-8 shadow-2xl border border-purple-500/30">
            <?php if (!empty($error)): ?>
                <div class="text-center space-y-4">
                    <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto">
                        <i class="fas fa-exclamation-circle text-red-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-red-400">Oops! Terjadi Kesalahan</h3>
                    <p class="text-purple-200 text-sm"><?= $error ?></p>
                    <a href="/login" class="block w-full py-3 rounded-xl bg-white/10 hover:bg-white/20 transition-all font-medium">
                        Kembali ke Login
                    </a>
                </div>
            <?php else: ?>
                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-2">Reset Password</h3>
                    <p class="text-purple-300 text-sm">
                        Silakan masukkan password baru Anda. Link ini akan kadaluarsa dalam:
                        <span id="countdown" class="block mt-2 font-mono text-pink-400 font-bold text-lg"></span>
                    </p>
                </div>

                <form method="POST" action="/reset-password" class="space-y-5">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-purple-300 ml-1">Password Baru</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-purple-400"></i>
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="••••••••" 
                                required
                                class="w-full pl-11 pr-4 py-3 glass-effect rounded-xl focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all"
                            >
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-purple-300 ml-1">Konfirmasi Password</label>
                        <div class="relative">
                            <i class="fas fa-shield-alt absolute left-4 top-1/2 -translate-y-1/2 text-purple-400"></i>
                            <input 
                                type="password" 
                                name="confirm_password" 
                                placeholder="••••••••" 
                                required
                                class="w-full pl-11 pr-4 py-3 glass-effect rounded-xl focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all"
                            >
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 py-4 rounded-xl font-bold transition-all glow-effect flex items-center justify-center gap-2 mt-4"
                    >
                        <span>Update Password</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </button>
                </form>

                <script>
                    let remaining = <?= $remainingSeconds ?>;
                    const countdown = document.getElementById('countdown');
                    const submitBtn = document.getElementById('submitBtn');
                    const inputs = document.querySelectorAll('input');

                    function updateCountdown() {
                        let minutes = Math.floor(remaining / 60);
                        let seconds = remaining % 60;
                        
                        // Padding 0 (e.g. 05:09)
                        let displayMins = String(minutes).padStart(2, '0');
                        let displaySecs = String(seconds).padStart(2, '0');
                        
                        countdown.innerHTML = `<i class="fas fa-clock mr-1"></i> ${displayMins}:${displaySecs}`;
                        
                        if (remaining <= 0) {
                            countdown.textContent = "LINK KADALUARSA";
                            countdown.classList.remove('text-pink-400');
                            countdown.classList.add('text-red-500');
                            clearInterval(timer);
                            
                            // Disable Form
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-50', 'cursor-not-allowed', 'grayscale');
                            inputs.forEach(el => el.disabled = true);
                        }
                        remaining--;
                    }

                    updateCountdown();
                    const timer = setInterval(updateCountdown, 1000);
                </script>
            <?php endif; ?>
        </div>
        
        <p class="text-center mt-8 text-purple-400 text-xs">
            &copy; 2026 Merchansuki Admin System. All rights reserved.
        </p>
    </div>

</body>
</html>