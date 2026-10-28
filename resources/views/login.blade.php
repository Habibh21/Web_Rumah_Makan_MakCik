<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - RM Mak Cik</title>
    
    <!-- 🖼️ FAVICON LOGO TAB BROWSER -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" onerror="this.href='{{ asset('logo.png') }}';">

    <!-- Tailwind CSS Script CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    colors: { 
                        orangeMakCik: '#FF6600', 
                        darkBg: '#0F0F0F', 
                        cardBg: '#141414' 
                    } 
                } 
            }
        }
    </script>

    <!-- Pustaka Ikon Vektor Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-darkBg text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden font-sans antialiased">

    <!-- Glow Effect Background -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-orange-600/10 blur-[140px] rounded-full pointer-events-none"></div>

    <!-- CARD FORM LOGIN INTERAKTIF (TANPA HEADER NAVBAR UTAMA) -->
    <div class="max-w-md w-full bg-cardBg border border-gray-800/80 rounded-2xl p-6 sm:p-8 shadow-2xl space-y-6 relative z-10 backdrop-blur-md">
        
        <!-- HEADER LOGO & JUDUL UNIVERSAL (ADMIN & KASIR) -->
        <div class="text-center space-y-2">
            <div class="flex justify-center mb-3">
                <img src="{{ asset('images/logo.png') }}" 
                     onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';" 
                     class="w-16 h-16 object-contain drop-shadow-xl" 
                     alt="Logo Mak Cik Resto">
            </div>
            
            <h2 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">
                Masuk <span class="text-orangeMakCik">Sistem</span>
            </h2>
            <p class="text-xs text-gray-400 font-medium max-w-xs mx-auto">
                Silakan masuk menggunakan akun Admin atau Kasir Anda.
            </p>
        </div>

        <!-- ALERT PESAN ERROR -->
        @if(session('error'))
            <div class="bg-red-950/80 border border-red-500/50 text-red-200 p-3 rounded-xl text-xs font-medium text-center">
                {{ session('error') }}
            </div>
        @elseif($errors->any())
            <div class="bg-red-950/80 border border-red-500/50 text-red-200 p-3 rounded-xl text-xs font-medium text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- FORMULIR MASUK -->
        <form action="{{ url('/login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- INPUT EMAIL / USERNAME -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1.5 pl-0.5">Alamat Email / Username</label>
                <div class="relative flex items-center">
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="Ketik email Anda..." 
                           class="w-full bg-[#111827] border border-gray-800 rounded-xl p-3.5 pl-10 text-xs text-white outline-none focus:border-orangeMakCik font-medium transition">
                    <i data-lucide="mail" class="w-4 h-4 text-orange-400 absolute left-3.5 pointer-events-none"></i>
                </div>
            </div>

            <!-- INPUT PASSWORD -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1.5 pl-0.5">Kata Sandi (Password)</label>
                <div class="relative flex items-center">
                    <input type="password" name="password" required placeholder="••••••••" 
                           class="w-full bg-[#111827] border border-gray-800 rounded-xl p-3.5 pl-10 text-xs text-white outline-none focus:border-orangeMakCik font-medium transition">
                    <i data-lucide="lock" class="w-4 h-4 text-orange-400 absolute left-3.5 pointer-events-none"></i>
                </div>
            </div>

            <!-- TOMBOL SUBMIT -->
            <button type="submit" class="w-full bg-orangeMakCik hover:bg-orange-600 active:scale-98 text-white font-black py-3.5 px-4 rounded-xl text-xs uppercase tracking-wider transition-all shadow-lg shadow-orange-600/15 flex items-center justify-center gap-2 mt-2">
                <i data-lucide="log-in" class="w-4 h-4 text-white"></i> Masuk Ke Panel
            </button>
        </form>

        <!-- LINK KEMBALI KE BERANDA UTAMA -->
        <div class="text-center pt-3 border-t border-gray-800/60">
            <a href="{{ url('/') }}" class="text-[11px] font-bold text-gray-500 hover:text-orangeMakCik transition inline-flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Beranda Utama
            </a>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>