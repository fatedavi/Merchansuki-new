<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Merchansuki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%); }
        .glass-effect { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .glow-effect { box-shadow: 0 0 20px rgba(139, 92, 246, 0.3); }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade { animation: fadeIn 0.6s ease-out forwards; }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 text-white">

    <div class="w-full max-w-md animate-fade">
        <a href="/auth/login" class="inline-flex items-center gap-2 text-purple-300 hover:text-white transition-colors mb-6 text-sm group">
            <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Login
        </a>

        <div class="glass-effect rounded-3xl p-6 sm:p-10 shadow-2xl border border-purple-500/30 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-500/20 blur-[80px] rounded-full"></div>
            
            <div class="relative z-10">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center glow-effect mb-6">
                        <i class="fas fa-paper-plane text-xl text-white"></i>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold mb-2">Lupa Password?</h1>
                    <p class="text-purple-300 text-sm leading-relaxed">
                        Jangan khawatir! Masukkan email Anda di bawah ini dan kami akan mengirimkan link untuk mengatur ulang password Anda.
                    </p>
                </div>

                <form method="POST" action="/auth/forgot-password" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-purple-300 ml-1 uppercase tracking-wider">Alamat Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-purple-400"></i>
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="nama@email.com" 
                                required
                                class="w-full pl-11 pr-4 py-4 glass-effect rounded-2xl focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all placeholder:text-purple-300/50"
                            >
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 py-4 rounded-2xl font-bold transition-all glow-effect flex items-center justify-center gap-3 group"
                    >
                        <span>Kirim Link Reset</span>
                        <i class="fas fa-chevron-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-xs text-purple-400">
                        Butuh bantuan lebih lanjut? <a href="#" class="text-purple-300 hover:text-pink-400 underline decoration-purple-500/50">Hubungi Support</a>
                    </p>
                </div>
            </div>
        </div>
        
        <p class="text-center mt-8 text-purple-400/60 text-xs tracking-widest uppercase">
            &copy; 2026 Merchansuki Cloud Access
        </p>
    </div>

</body>
</html>