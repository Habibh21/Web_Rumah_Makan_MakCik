<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Makan Mak Cik</title>
    
    <!-- 🖼️ FAVICON LOGO DI TAB BROWSER -->
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
                        cardBg: '#1A1A1A'
                    }
                }
            }
        }
    </script>

    <!-- Pustaka Ikon Vektor Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-darkBg text-white font-sans antialiased w-full relative">

    {{-- SAKELAR NAVBAR: Otomatis sembunyi di halaman operasional Kasir atau Admin --}}
    @if(!request()->is('admin*') && !request()->is('kasir*'))
    <!-- 📌 NAVBAR FIXED (KUNCI DI ATAS SAAT SCROLL) -->
    <nav class="w-full bg-[#0F0F0F]/95 fixed top-0 left-0 right-0 z-50 backdrop-blur-md border-b border-gray-800/60 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 h-20 md:h-24 flex items-center justify-between md:grid md:grid-cols-3">
            
            <!-- POROS 1 (KIRI): Identitas Brand Resto + LOGO RESMI -->
            <div class="flex justify-start">
                <a href="{{ route('home') }}#beranda" class="flex items-center gap-3 md:gap-4 hover:opacity-90 transition select-none">
                    <img src="{{ asset('images/logo.png') }}" 
                         onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';" 
                         class="w-10 h-10 md:w-14 md:h-14 lg:w-16 lg:h-16 object-contain drop-shadow-md" 
                         alt="Logo Mak Cik Resto">
                    <span class="text-orangeMakCik font-black text-xl sm:text-2xl md:text-3xl tracking-tighter uppercase leading-none">
                        MAK CIK
                    </span>
                </a>
            </div>
            
            <!-- POROS 2 (TENGAH): Navigasi Anchor Presisi -->
            <div class="hidden md:flex justify-center">
                <ul class="flex items-center gap-5 lg:gap-7 text-xs lg:text-sm font-bold uppercase tracking-wider text-gray-400">
                    <li class="relative group py-2">
                        <a href="{{ route('home') }}#beranda" class="group-hover:text-orangeMakCik transition duration-200">Beranda</a>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-orangeMakCik transition-all duration-300 group-hover:w-full"></span>
                    </li>
                    <li class="relative group py-2">
                        <a href="{{ route('home') }}#menu" class="group-hover:text-orangeMakCik transition duration-200">Menu</a>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-orangeMakCik transition-all duration-300 group-hover:w-full"></span>
                    </li>
                    <li class="relative group py-2">
                        <a href="{{ route('home') }}#tentang" class="group-hover:text-orangeMakCik transition duration-200">Tentang</a>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-orangeMakCik transition-all duration-300 group-hover:w-full"></span>
                    </li>
                    <li class="relative group py-2">
                        <a href="{{ route('home') }}#galeri" class="group-hover:text-orangeMakCik transition duration-200">Galeri</a>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-orangeMakCik transition-all duration-300 group-hover:w-full"></span>
                    </li>
                    <li class="relative group py-2">
                        <a href="{{ route('home') }}#kontak" class="group-hover:text-orangeMakCik transition duration-200">Kontak</a>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-orangeMakCik transition-all duration-300 group-hover:w-full"></span>
                    </li>
                </ul>
            </div>
            
            <!-- POROS 3 (KANAN): Tombol Login & Reservasi -->
            <div class="hidden md:flex justify-end items-center gap-3">
                <a href="{{ url('/login') }}" class="border border-gray-800 hover:border-gray-600 bg-neutral-900/40 text-gray-300 hover:text-white px-4 py-2.5 rounded-lg transition-all duration-200 flex items-center gap-2 text-xs font-extrabold group">
                    <i data-lucide="log-in" class="w-3.5 h-3.5 text-gray-500 group-hover:text-white transition"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('reservasi.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2.5 rounded-lg transition-all duration-150 flex items-center gap-2 text-xs font-black shadow-lg shadow-orange-600/10 active:scale-98">
                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    <span>Reservasi Meja</span>
                </a>
            </div>

            <!-- TOMBOL HAMBURGER MOBILE -->
            <div class="flex md:hidden">
                <button type="button" onclick="toggleMobileMenu()" class="text-gray-400 hover:text-white focus:outline-none transition p-1">
                    <i id="menu-icon" data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>

        </div>

        <!-- PANEL DROPDOWN MENU MOBILE -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-800/80 bg-[#0F0F0F] px-5 py-5 space-y-4 shadow-xl">
            <ul class="space-y-3 text-xs font-bold uppercase tracking-widest text-gray-400">
                <li><a href="{{ route('home') }}#beranda" onclick="toggleMobileMenu()" class="block hover:text-orangeMakCik py-1 transition">Beranda Utama</a></li>
                <li><a href="{{ route('home') }}#menu" onclick="toggleMobileMenu()" class="block hover:text-orangeMakCik py-1 transition">Katalog Menu</a></li>
                <li><a href="{{ route('home') }}#tentang" onclick="toggleMobileMenu()" class="block hover:text-orangeMakCik py-1 transition">Tentang Kami</a></li>
                <li><a href="{{ route('home') }}#galeri" onclick="toggleMobileMenu()" class="block hover:text-orangeMakCik py-1 transition">Galeri Resto</a></li>
                <li><a href="{{ route('home') }}#kontak" onclick="toggleMobileMenu()" class="block hover:text-orangeMakCik py-1 transition">Kontak Info</a></li>
            </ul>
            <div class="pt-4 border-t border-gray-800/60 flex flex-col gap-2.5">
                <a href="{{ url('/login') }}" class="w-full justify-center border border-gray-800 bg-neutral-900/40 text-gray-300 py-2.5 rounded-lg flex items-center gap-2 text-xs font-extrabold">
                    <i data-lucide="log-in" class="w-4 h-4 text-gray-500"></i><span>Login Kasir / Admin</span>
                </a>
                <a href="{{ route('reservasi.index') }}" onclick="toggleMobileMenu()" class="w-full justify-center bg-orange-600 text-white py-2.5 rounded-lg flex items-center gap-2 text-xs font-black shadow-md shadow-orange-600/10">
                    <i data-lucide="calendar" class="w-4 h-4"></i><span>Booking Reservasi</span>
                </a>
            </div>
        </div>
    </nav>
    @endif

    <main class="w-full @if(!request()->is('admin*') && !request()->is('kasir*')) pt-20 md:pt-24 @endif">
        @yield('content')
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.setAttribute('data-lucide', 'x');
            } else {
                menu.classList.add('hidden');
                icon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>