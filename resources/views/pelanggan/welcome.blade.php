@extends('layouts.app')

@section('content')

{{-- STYLE SCROLLBAR HORISONTAL ORANYE & EFEK GLASSMORPHISM --}}
<style>
    .custom-horizontal-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    .custom-horizontal-scrollbar::-webkit-scrollbar-track {
        background: rgba(31, 41, 55, 0.5);
        border-radius: 8px;
    }
    .custom-horizontal-scrollbar::-webkit-scrollbar-thumb {
        background: #FF6600;
        border-radius: 8px;
    }
    .custom-horizontal-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #e65c00;
    }
</style>

{{-- LOGIKA DETEKSI OTOMATIS KATEGORI & BEST SELLER --}}
@php
    $allMenus   = isset($menus) ? $menus : collect();
    
    // Filter Kategori
    $makananList = $allMenus->filter(fn($m) => str_contains(strtolower($m->kategori ?? ''), 'makanan'));
    $minumanList = $allMenus->filter(fn($m) => str_contains(strtolower($m->kategori ?? ''), 'minuman') || str_contains(strtolower($m->kategori ?? ''), 'drink'));
    $snackList   = $allMenus->filter(fn($m) => str_contains(strtolower($m->kategori ?? ''), 'snack') || str_contains(strtolower($m->kategori ?? ''), 'cemilan'));

    // Best Seller List
    $bestSellerList = isset($bestSellers) && count($bestSellers) > 0 
        ? $bestSellers 
        : $allMenus->take(4);
@endphp

<!-- CONTAINER UTAMA -->
<div class="w-full max-w-full overflow-x-hidden relative bg-[#0F0F0F]">

    <!-- SECTION 1: HERO BERANDA (#beranda) -->
    <section id="beranda" class="min-h-[calc(100vh-80px)] flex flex-col items-center justify-center text-center px-4 sm:px-6 relative bg-gradient-to-b from-[#0F0F0F] to-[#141414] overflow-hidden scroll-mt-20">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 h-72 sm:h-96 bg-orange-600/10 blur-[120px] rounded-full pointer-events-none"></div>
        
        <span class="text-[10px] sm:text-xs font-black tracking-widest text-orangeMakCik bg-orange-950/40 border border-orange-900/50 px-3 py-1 rounded-full uppercase mb-4 select-none">Cita Rasa Autentik Nusantara</span>
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-white tracking-tight uppercase max-w-4xl leading-tight px-2">
            Kehangatan Kuliner Rumahan <br class="hidden sm:block">Khas <span class="text-orangeMakCik">RM Mak Cik</span>
        </h1>
        <p class="text-gray-400 text-xs sm:text-sm md:text-base max-w-2xl mt-4 font-medium leading-relaxed px-4">
            Menghadirkan kelezatan masakan otentik dengan resep rahasia turun-temurun. Setiap rempah diracik murni untuk menyajikan kenikmatan bersantap yang tak untuk dilupakan bersama keluarga.
        </p>
        <div class="flex flex-col sm:flex-row items-center gap-3 mt-8 w-full sm:w-auto px-6">
            <a href="{{ route('reservasi.index') }}" class="w-full sm:w-auto text-center bg-orange-500 hover:bg-orange-600 font-black text-xs px-6 py-3 rounded-lg uppercase tracking-wider transition shadow-lg shadow-orange-500/20 text-white"> 
                Reservasi Meja Online 
            </a>
            <a href="#menu" class="w-full sm:w-auto text-center border border-gray-800 hover:border-gray-600 bg-[#1A1A1A]/40 font-bold text-xs px-6 py-3 rounded-lg uppercase tracking-wider transition text-white"> 
                Jelajahi Menu 
            </a>
        </div>
    </section>

    <!-- SECTION 2: KATALOG MENU DIGITAL -->
    <section id="menu" class="min-h-screen py-12 sm:py-20 px-3 sm:px-10 bg-[#141414] border-t border-gray-900 flex flex-col justify-center scroll-mt-20 overflow-x-hidden relative">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-orange-600/5 blur-[140px] rounded-full pointer-events-none"></div>

        <div class="text-center mb-10 sm:mb-16 shrink-0 relative z-10">
            <h2 class="text-xl sm:text-4xl font-black text-white uppercase tracking-tight">Katalog Hidangan Masterpiece</h2>
            <p class="text-[11px] sm:text-sm text-gray-500 mt-1 sm:mt-2 font-medium max-w-md mx-auto px-2">Dipilih dari bahan baku pilihan terpopuler demi memanjakan selera bersantap Anda.</p>
        </div>

        <div class="max-w-7xl mx-auto w-full space-y-12 sm:space-y-16 relative z-10">

            <!-- ========================================================= -->
            <!-- 🔥 1. SEKSI BEST SELLER (AESTHETIC & MINIMALIS) -->
            <!-- ========================================================= -->
            @if($bestSellerList->count() > 0)
            <div>
                <!-- JUDUL KATEGORI MINIMALIS & RATA TENGAH -->
                <div class="text-center mb-6 sm:mb-8">
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.25em] text-amber-500 block mb-1">
                        Most Favorite Choices
                    </span>
                    <h3 class="text-base sm:text-2xl font-black uppercase tracking-wider text-white">
                        Menu Terlaris <span class="text-amber-500 font-bold text-xs sm:text-base">(Best Seller)</span>
                    </h3>
                    <div class="w-12 sm:w-16 h-[2px] bg-gradient-to-r from-amber-500 to-orange-500 mx-auto mt-2"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                    @foreach($bestSellerList as $item)
                        @php 
                            $menuItem = isset($item->menu) ? $item->menu : $item; 
                            $hargaAngka = preg_replace('/[^0-9]/', '', $menuItem->harga ?? 0);
                            $hargaFinal = is_numeric($hargaAngka) ? (int)$hargaAngka : 0;
                        @endphp
                        <div class="menu-card bg-[#1A1A1A]/80 backdrop-blur-md border border-amber-500/40 rounded-xl overflow-hidden shadow-md flex flex-col justify-between group hover:border-amber-400 hover:scale-[1.02] transition-all duration-300 relative select-none">
                            
                            <span class="absolute top-2 right-2 bg-amber-500 text-black font-black text-[8px] sm:text-[9px] px-1.5 sm:px-2 py-0.5 rounded shadow z-10 uppercase tracking-widest">
                                Best Seller
                            </span>

                            <div>
                                <div class="w-full h-28 sm:h-44 bg-neutral-900 relative overflow-hidden">
                                    <img src="{{ asset('menu_images/' . ($menuItem->gambar ?? 'default.jpg')) }}" 
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                                         alt="{{ $menuItem->nama }}">
                                    
                                    <span class="absolute top-2 left-2 text-[8px] sm:text-[9px] font-black tracking-wider px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded border backdrop-blur-md uppercase select-none shadow-md bg-orange-950/80 text-orange-400 border-orange-500/40">
                                        {{ $menuItem->kategori ?? 'Favorit' }}
                                    </span>
                                </div>

                                <div class="p-2.5 sm:p-3.5 pb-0 text-center">
                                    <h3 class="font-extrabold text-xs sm:text-base text-white truncate capitalize tracking-tight">{{ $menuItem->nama }}</h3>
                                </div>
                            </div>

                            <div class="p-2.5 sm:p-3.5 pt-1.5 sm:pt-2">
                                <div class="pt-2 border-t border-gray-800/80 flex items-center justify-between">
                                    <span class="text-orangeMakCik font-black text-xs sm:text-base font-mono">Rp {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                                    <span class="text-[9px] sm:text-[10px] bg-neutral-800/70 text-gray-400 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded font-bold uppercase tracking-wider select-none border border-gray-700/50">Ready</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif


            <!-- ========================================================= -->
            <!-- 🍚 2. SEKSI MAKANAN UTAMA (AESTHETIC & MINIMALIS) -->
            <!-- ========================================================= -->
            <div>
                <!-- JUDUL KATEGORI MINIMALIS & RATA TENGAH -->
                <div class="text-center mb-6 sm:mb-8">
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.25em] text-orangeMakCik block mb-1">
                        Main Course
                    </span>
                    <h3 class="text-base sm:text-2xl font-black uppercase tracking-wider text-white">
                        Makanan Utama
                    </h3>
                    <div class="w-12 sm:w-16 h-[2px] bg-orangeMakCik mx-auto mt-2"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                    @forelse($makananList as $menu)
                        @php
                            $hargaAngka = preg_replace('/[^0-9]/', '', $menu->harga);
                            $hargaFinal = is_numeric($hargaAngka) ? (int)$hargaAngka : 0;
                        @endphp
                        <div class="menu-card bg-[#1A1A1A]/60 backdrop-blur-md border border-gray-800/70 rounded-xl overflow-hidden shadow-md flex flex-col justify-between group hover:border-orange-500/50 hover:bg-[#1A1A1A]/80 transition-all duration-300 select-none">
                            <div>
                                <div class="w-full h-28 sm:h-44 bg-neutral-900 relative overflow-hidden">
                                    <img src="{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}" 
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                                         alt="{{ $menu->nama }}">
                                    
                                    <span class="absolute top-2 left-2 text-[8px] sm:text-[9px] font-black tracking-wider px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded border backdrop-blur-md uppercase select-none shadow-md bg-orange-950/80 text-orange-400 border-orange-500/40">
                                        {{ $menu->kategori ?? 'Makanan' }}
                                    </span>
                                </div>

                                <div class="p-2.5 sm:p-3.5 pb-0 text-center">
                                    <h3 class="font-extrabold text-xs sm:text-base text-white truncate capitalize tracking-tight">{{ $menu->nama }}</h3>
                                </div>
                            </div>

                            <div class="p-2.5 sm:p-3.5 pt-1.5 sm:pt-2">
                                <div class="pt-2 border-t border-gray-800/80 flex items-center justify-between">
                                    <span class="text-orangeMakCik font-black text-xs sm:text-base font-mono">Rp {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                                    <span class="text-[9px] sm:text-[10px] bg-neutral-800/70 text-gray-400 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded font-bold uppercase tracking-wider select-none border border-gray-700/50">Ready</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-gray-500 font-medium italic bg-[#1A1A1A]/40 rounded-xl border border-gray-800 text-xs">
                            Belum ada hidangan makanan terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>


            <!-- ========================================================= -->
            <!-- 🍹 3. SEKSI MINUMAN SEGAR (AESTHETIC & MINIMALIS) -->
            <!-- ========================================================= -->
            <div>
                <!-- JUDUL KATEGORI MINIMALIS & RATA TENGAH -->
                <div class="text-center mb-6 sm:mb-8">
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.25em] text-blue-400 block mb-1">
                        Fresh Beverages
                    </span>
                    <h3 class="text-base sm:text-2xl font-black uppercase tracking-wider text-white">
                        Minuman Segar
                    </h3>
                    <div class="w-12 sm:w-16 h-[2px] bg-blue-500 mx-auto mt-2"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                    @forelse($minumanList as $menu)
                        @php
                            $hargaAngka = preg_replace('/[^0-9]/', '', $menu->harga);
                            $hargaFinal = is_numeric($hargaAngka) ? (int)$hargaAngka : 0;
                        @endphp
                        <div class="menu-card bg-[#1A1A1A]/60 backdrop-blur-md border border-gray-800/70 rounded-xl overflow-hidden shadow-md flex flex-col justify-between group hover:border-blue-500/50 hover:bg-[#1A1A1A]/80 transition-all duration-300 select-none">
                            <div>
                                <div class="w-full h-28 sm:h-44 bg-neutral-900 relative overflow-hidden">
                                    <img src="{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}" 
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                                         alt="{{ $menu->nama }}">
                                    
                                    <span class="absolute top-2 left-2 text-[8px] sm:text-[9px] font-black tracking-wider px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded border backdrop-blur-md uppercase select-none shadow-md bg-emerald-950/80 text-emerald-400 border-emerald-500/40">
                                        {{ $menu->kategori ?? 'Minuman' }}
                                    </span>
                                </div>

                                <div class="p-2.5 sm:p-3.5 pb-0 text-center">
                                    <h3 class="font-extrabold text-xs sm:text-base text-white truncate capitalize tracking-tight">{{ $menu->nama }}</h3>
                                </div>
                            </div>

                            <div class="p-2.5 sm:p-3.5 pt-1.5 sm:pt-2">
                                <div class="pt-2 border-t border-gray-800/80 flex items-center justify-between">
                                    <span class="text-orangeMakCik font-black text-xs sm:text-base font-mono">Rp {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                                    <span class="text-[9px] sm:text-[10px] bg-neutral-800/70 text-gray-400 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded font-bold uppercase tracking-wider select-none border border-gray-700/50">Ready</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-gray-500 font-medium italic bg-[#1A1A1A]/40 rounded-xl border border-gray-800 text-xs">
                            Belum ada menu minuman terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>


            <!-- ========================================================= -->
            <!-- 🍿 4. SEKSI SNACK & CAMILAN (AESTHETIC & MINIMALIS) -->
            <!-- ========================================================= -->
            <div>
                <!-- JUDUL KATEGORI MINIMALIS & RATA TENGAH -->
                <div class="text-center mb-6 sm:mb-8">
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.25em] text-amber-400 block mb-1">
                        Side Dishes & Snacks
                    </span>
                    <h3 class="text-base sm:text-2xl font-black uppercase tracking-wider text-white">
                        Snack & Camilan
                    </h3>
                    <div class="w-12 sm:w-16 h-[2px] bg-amber-500 mx-auto mt-2"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                    @forelse($snackList as $menu)
                        @php
                            $hargaAngka = preg_replace('/[^0-9]/', '', $menu->harga);
                            $hargaFinal = is_numeric($hargaAngka) ? (int)$hargaAngka : 0;
                        @endphp
                        <div class="menu-card bg-[#1A1A1A]/60 backdrop-blur-md border border-gray-800/70 rounded-xl overflow-hidden shadow-md flex flex-col justify-between group hover:border-amber-500/50 hover:bg-[#1A1A1A]/80 transition-all duration-300 select-none">
                            <div>
                                <div class="w-full h-28 sm:h-44 bg-neutral-900 relative overflow-hidden">
                                    <img src="{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}" 
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                                         alt="{{ $menu->nama }}">
                                    
                                    <span class="absolute top-2 left-2 text-[8px] sm:text-[9px] font-black tracking-wider px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded border backdrop-blur-md uppercase select-none shadow-md bg-amber-950/80 text-amber-400 border-amber-500/40">
                                        {{ $menu->kategori ?? 'Snack' }}
                                    </span>
                                </div>

                                <div class="p-2.5 sm:p-3.5 pb-0 text-center">
                                    <h3 class="font-extrabold text-xs sm:text-base text-white truncate capitalize tracking-tight">{{ $menu->nama }}</h3>
                                </div>
                            </div>

                            <div class="p-2.5 sm:p-3.5 pt-1.5 sm:pt-2">
                                <div class="pt-2 border-t border-gray-800/80 flex items-center justify-between">
                                    <span class="text-orangeMakCik font-black text-xs sm:text-base font-mono">Rp {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                                    <span class="text-[9px] sm:text-[10px] bg-neutral-800/70 text-gray-400 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded font-bold uppercase tracking-wider select-none border border-gray-700/50">Ready</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-gray-500 font-medium italic bg-[#1A1A1A]/40 rounded-xl border border-gray-800 text-xs">
                            Belum ada menu snack terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    <!-- SECTION 3: TENTANG KAMI (#tentang) -->
    <section id="tentang" class="min-h-screen py-20 px-5 sm:px-10 bg-[#0F0F0F] border-t border-gray-900 flex flex-col justify-center relative overflow-hidden scroll-mt-20">
        <div class="absolute bottom-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-orange-600/5 blur-[120px] rounded-full pointer-events-none"></div>
        
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-12 items-center w-full">
            <div class="space-y-4 text-left">
                <span class="text-[10px] font-black text-orangeMakCik uppercase tracking-widest block">The Legacy Story</span>
                <h2 class="text-xl sm:text-4xl font-black text-white uppercase tracking-tight">Dedikasi Warisan <br class="hidden sm:block">Kuliner Autentik</h2>
                <p class="text-gray-400 text-xs sm:text-sm leading-relaxed font-medium">
                    Berdiri sejak bertahun-tahun lalu, Rumah Makan Mak Cik murni dibangun atas cinta mendalam terhadap masakan khas nusantara. Kami meyakini bahwa hidangan yang lezat lahir dari ketulusan dan ketepatan memilih rempah-rempah segar alami.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full">
                <div class="bg-neutral-900/80 border border-gray-800/80 rounded-lg p-5 flex flex-col justify-center min-h-[120px] shadow-sm">
                    <h4 class="text-2xl sm:text-3xl font-black text-orangeMakCik font-mono">100%</h4>
                    <p class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-1">Bahan Halal Thoyyib</p>
                </div>
                <div class="bg-neutral-900/80 border border-gray-800/80 rounded-lg p-5 flex flex-col justify-center min-h-[120px] shadow-sm">
                    <h4 class="text-2xl sm:text-3xl font-black text-orangeMakCik font-mono">25+</h4>
                    <p class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-1">Resep Rahasia Mak Cik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: GALERI FOTO (#galeri) -->
    <section id="galeri" class="min-h-screen py-20 px-5 sm:px-10 bg-[#141414] border-t border-gray-900 flex flex-col justify-center scroll-mt-20 overflow-hidden">
        <div class="text-center mb-12 sm:mb-16 shrink-0">
            <h2 class="text-xl sm:text-4xl font-black text-white uppercase tracking-tight">Galeri Ruang & Suasana</h2>
            <p class="text-[11px] sm:text-sm text-gray-500 mt-2 font-medium max-w-sm mx-auto px-4">Potret kenyamanan estetika sudut restoran kami untuk kenyamanan santap Anda.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 max-w-6xl mx-auto w-full">
            <div class="h-36 sm:h-48 bg-neutral-900 border border-gray-800/60 rounded-lg flex items-center justify-center text-gray-500 text-xs font-black uppercase tracking-wider shadow-sm">Dine-In Room</div>
            <div class="h-36 sm:h-48 bg-neutral-900 border border-gray-800/60 rounded-lg flex items-center justify-center text-gray-500 text-xs font-black uppercase tracking-wider shadow-sm">Dapur Bersih</div>
            <div class="h-36 sm:h-48 bg-neutral-900 border border-gray-800/60 rounded-lg flex items-center justify-center text-gray-500 text-xs font-black uppercase tracking-wider shadow-sm">Rempah Racik</div>
            <div class="h-36 sm:h-48 bg-neutral-900 border border-gray-800/60 rounded-lg flex items-center justify-center text-gray-500 text-xs font-black uppercase tracking-wider shadow-sm">Sajikan Meja</div>
        </div>
    </section>

    <!-- SECTION 5: FOOTER INFO KONTAK (#kontak) -->
    <footer id="kontak" class="border-t border-gray-900 bg-[#0A0A0A] pt-12 sm:pt-16 pb-8 px-5 sm:px-10 text-gray-400 w-full max-w-full overflow-hidden relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 max-w-5xl mx-auto text-left">
            <div>
                <div class="flex items-center gap-2.5 mb-3 sm:mb-4">
                    <img src="{{ asset('images/logo.png') }}" 
                         onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';" 
                         class="w-9 h-9 object-contain drop-shadow-md" 
                         alt="Logo Mak Cik Resto">
                    <span class="text-orangeMakCik font-black text-xl uppercase tracking-tight">MAK CIK RESTO</span>
                </div>
                <p class="text-xs leading-relaxed font-medium text-gray-400 max-w-md">
                    Rumah Makan Mak Cik menyajikan berbagai hidangan rumahan autentik bercita rasa tinggi dengan harga bersahabat dan jaminan higienis.
                </p>
            </div>

            <div>
                <h4 class="text-white font-black text-xs uppercase tracking-wider mb-3 sm:mb-4">Pusat Informasi Kontak</h4>
                <ul class="text-xs space-y-2.5 font-medium">
                    <li class="text-gray-400">📍 Jl. Abdul Razak, RT 04 RW 02, Desa Tebang, Kec. Palmatak, Kab. Kepulauan Anambas, Kepulauan Riau, 29796</li>
                    <li class="text-gray-400">📞 +62 853-6543-9273</li>
                    <li class="text-gray-400">🕒 09.00 - 22.00 WIB (Buka Setiap Hari)</li>
                </ul>
            </div>
        </div>
        <div class="text-center text-[10px] font-medium border-t border-gray-900 pt-6 mt-10 text-gray-600 select-none">
            &copy; 2026 Rumah Makan Mak Cik. All Rights Reserved.
        </div>
    </footer>

</div>

@endsection