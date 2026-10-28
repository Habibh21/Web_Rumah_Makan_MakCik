@extends('layouts.app')

@section('content')

{{-- CUSTOM ERGONOMICS CYBER DARK SCROLLBAR (10PX TOUCH-FRIENDLY & FLOATING) --}}
<style>
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(11, 15, 25, 0.6);
    }
    ::-webkit-scrollbar-thumb {
        background: #374151;
        border: 2px solid #0B0F19;
        border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover, ::-webkit-scrollbar-thumb:active {
        background: #F97316;
        border: 1px solid #0B0F19;
    }

    .custom-table-scrollbar::-webkit-scrollbar {
        width: 10px;
    }
    .custom-table-scrollbar::-webkit-scrollbar-track {
        background: rgba(17, 24, 39, 0.5);
        border-radius: 8px;
    }
    .custom-table-scrollbar::-webkit-scrollbar-thumb {
        background: #4B5563;
        border: 2px solid #111827;
        border-radius: 8px;
    }
    .custom-table-scrollbar::-webkit-scrollbar-thumb:hover, 
    .custom-table-scrollbar::-webkit-scrollbar-thumb:active {
        background: #F97316;
        border: 1px solid #111827;
    }
</style>

{{-- CONTAINER UTAMA POS KASIR --}}
<div class="flex h-screen bg-[#0B0F19] text-slate-300 font-sans overflow-hidden antialiased">

    @include('layouts.sidebar')

    <main class="flex-1 flex flex-col overflow-hidden bg-[#0B0F19] relative">
        <header class="h-20 bg-[#111827]/90 backdrop-blur-md border-b border-gray-800 px-4 xl:px-8 flex items-center justify-between shadow-md z-40 shrink-0 gap-3 relative">
            <div class="flex items-center gap-3 xl:gap-4 flex-1">
                <h2 class="text-base xl:text-lg font-black text-white tracking-tight shrink-0 hidden md:block">Katalog Menu</h2>
                
                <div class="relative flex items-center flex-1 max-w-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input type="text" id="searchInput" onkeyup="filterMenu()" placeholder="Cari nama menu..." 
                           class="w-full py-2 pl-10 pr-4 text-xs border border-gray-800 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all shadow-sm bg-[#1F2937] text-white font-medium">
                </div>

                <div class="relative z-50" id="categoryDropdownWrapper">
                    <button id="categoryDropdownBtn" onclick="toggleCategoryMenu()" type="button" 
                            class="px-3 py-2 text-xs border border-gray-800 rounded-lg bg-[#1F2937] text-white font-extrabold flex items-center gap-1.5 hover:border-orange-500/60 active:scale-98 transition-all shadow-sm">
                        <i id="currentCategoryIcon" data-lucide="layers" class="w-4 h-4 text-orange-400"></i>
                        <span id="currentCategoryLabel" class="text-orange-400 font-black text-xs hidden sm:inline">Semua Kategori</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-400"></i>
                    </button>

                    <input type="hidden" id="categoryFilter" value="semua">

                    <div id="categoryDropdownMenu" class="hidden absolute left-0 mt-2 w-52 bg-[#111827] border border-gray-800 rounded-xl shadow-2xl z-[60] overflow-hidden py-1.5 backdrop-blur-xl">
                        <button type="button" onclick="selectCategory('semua', 'Semua Kategori', 'layers', 'text-orange-400')" class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-slate-300 hover:bg-orange-500/10 hover:text-orange-400 flex items-center gap-2.5 transition">
                            <i data-lucide="layers" class="w-4 h-4 text-orange-400"></i>
                            <span>Semua Kategori</span>
                        </button>
                        <button type="button" onclick="selectCategory('bestseller', 'Best Seller', 'flame', 'text-rose-500')" class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-slate-300 hover:bg-rose-500/10 hover:text-rose-400 flex items-center gap-2.5 transition border-b border-gray-800/60">
                            <i data-lucide="flame" class="w-4 h-4 text-rose-500"></i>
                            <span class="text-rose-400 font-extrabold">Best Seller</span>
                        </button>
                        <button type="button" onclick="selectCategory('makanan', 'Makanan', 'utensils-crossed', 'text-amber-400')" class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-slate-300 hover:bg-orange-500/10 hover:text-amber-400 flex items-center gap-2.5 transition">
                            <i data-lucide="utensils-crossed" class="w-4 h-4 text-amber-400"></i>
                            <span>Makanan</span>
                        </button>
                        <button type="button" onclick="selectCategory('minuman', 'Minuman', 'cup-soda', 'text-cyan-400')" class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-slate-300 hover:bg-orange-500/10 hover:text-cyan-400 flex items-center gap-2.5 transition">
                            <i data-lucide="cup-soda" class="w-4 h-4 text-cyan-400"></i>
                            <span>Minuman</span>
                        </button>
                        <button type="button" onclick="selectCategory('snack', 'Snack / Cemilan', 'cookie', 'text-emerald-400')" class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-slate-300 hover:bg-orange-500/10 hover:text-emerald-400 flex items-center gap-2.5 transition">
                            <i data-lucide="cookie" class="w-4 h-4 text-emerald-400"></i>
                            <span>Snack / Cemilan</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-2 shrink-0">
                @if(session('success')) <div class="bg-emerald-500 text-white px-3 py-1 rounded-lg font-bold text-xs shadow-md">{{ session('success') }}</div> @endif
                @if(session('error')) <div class="bg-rose-500 text-white px-3 py-1 rounded-lg font-bold text-xs shadow-md animate-bounce">{{ session('error') }}</div> @endif
            </div>
        </header>

        <div class="px-4 xl:px-8 pt-4 xl:pt-6 grid grid-cols-3 gap-3 xl:gap-5 shrink-0 z-0">
            <div class="bg-[#111827] border border-gray-800/60 p-3 xl:p-4 rounded-lg border-l-4 border-l-emerald-500 flex flex-col justify-between min-h-[75px] xl:min-h-[85px]">
                <span class="text-[9px] xl:text-[10px] font-black text-gray-500 uppercase tracking-widest truncate">Omset Hari Ini</span>
                <p class="text-sm xl:text-lg font-black text-white tracking-tight mt-0.5">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-[#111827] border border-gray-800/60 p-3 xl:p-4 rounded-lg border-l-4 border-l-orange-500 flex flex-col justify-between min-h-[75px] xl:min-h-[85px]">
                <span class="text-[9px] xl:text-[10px] font-black text-gray-500 uppercase tracking-widest truncate">Total Nota</span>
                <p class="text-sm xl:text-lg font-black text-white tracking-tight mt-0.5">{{ $totalPesanan ?? 0 }} <span class="text-[10px] xl:text-xs font-bold text-gray-500">Sales</span></p>
            </div>
            <div class="bg-[#111827] border border-gray-800/60 p-3 xl:p-4 rounded-lg border-l-4 border-l-purple-500 flex flex-col justify-between min-h-[75px] xl:min-h-[85px]">
                <span class="text-[9px] xl:text-[10px] font-black text-gray-500 uppercase tracking-widest truncate">Reservasi</span>
                <p class="text-sm xl:text-lg font-black text-white tracking-tight mt-0.5">{{ $totalReservasi ?? 0 }} <span class="text-[10px] xl:text-xs font-bold text-gray-500">Reservasi</span></p>
            </div>
        </div>

        <div class="flex-1 p-4 xl:p-8 overflow-y-auto custom-table-scrollbar z-0">
            <div class="grid grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-3.5 xl:gap-5" id="menuGrid">
                @foreach($menus as $menu)
                    @php 
                        $hargaBersih = preg_replace('/[^0-9]/', '', $menu->harga);
                        $hargaSesuai = is_numeric($hargaBersih) ? $hargaBersih : 0;
                        $apakahHabis = $menu->stok <= 0;
                        $isBestSeller = $menu->is_bestseller ?? false;
                    @endphp
                    
                    <div class="menu-card flex flex-col" 
                         data-name="{{ strtolower($menu->nama) }}" 
                         data-category="{{ strtolower($menu->kategori) }}"
                         data-bestseller="{{ $isBestSeller ? 'true' : 'false' }}">
                        
                        @if(!$apakahHabis)
                            <div ontouchstart="handleTouchStart(event)" 
                                 ontouchmove="handleTouchMove(event)" 
                                 onclick="handleCardClick(event, {{ $menu->id }}, '{{ $menu->nama }}', {{ $hargaSesuai }}, {{ $menu->stok }}, '{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}', '{{ $menu->kategori }}')"
                                 class="w-full h-full bg-[#111827] rounded-xl p-0 border border-gray-800/80 hover:border-orange-500 shadow-sm flex flex-col justify-start select-none cursor-pointer group transition-all duration-200 active:scale-[0.98] relative overflow-hidden">
                                
                                <div class="overflow-hidden relative pointer-events-none aspect-square w-full bg-gray-900">
                                    <img src="{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $menu->nama }}">
                                    
                                    @if($isBestSeller)
                                        <div class="absolute top-2 right-2 bg-gradient-to-r from-rose-600 to-orange-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-lg flex items-center gap-1 border border-orange-400/40 z-10">
                                            <i data-lucide="flame" class="w-3 h-3 text-yellow-300"></i>
                                            <span>BEST SELLER</span>
                                        </div>
                                    @endif

                                    <div class="absolute bottom-2 left-2 bg-[#111827]/90 backdrop-blur-sm px-2 py-0.5 rounded border border-gray-800/40 z-10">
                                        <p class="text-[10px] text-emerald-400 font-extrabold">Stock: {{ $menu->stok }}</p>
                                    </div>
                                </div>

                                <div class="p-3 flex flex-col flex-grow justify-between w-full">
                                    <div>
                                        <h3 class="font-extrabold text-xs xl:text-sm text-white truncate capitalize tracking-tight mb-0.5 pointer-events-none">{{ $menu->nama }}</h3>
                                        <p class="text-[10px] xl:text-[11px] text-gray-500 font-medium capitalize pointer-events-none">{{ $menu->kategori }}</p>
                                    </div>
                                    
                                    <div class="mt-2.5 pt-2 flex items-center justify-between gap-2 pointer-events-none">
                                        <span class="text-orange-400 font-black text-xs xl:text-sm font-mono truncate">Rp {{ number_format($hargaSesuai, 0, ',', '.') }}</span>
                                        
                                        <span class="bg-[#1F2937] group-hover:bg-orange-500 group-hover:text-white text-slate-300 text-[10px] xl:text-[11px] px-3 py-1.5 rounded-lg font-black border border-gray-700 group-hover:border-orange-500 transition-all duration-150 shadow-sm flex items-center gap-1 shrink-0">
                                            <i data-lucide="plus" class="w-3 h-3"></i>
                                            <span>Pilih</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full bg-[#111827]/40 rounded-xl border border-gray-900 p-0 opacity-40 cursor-not-allowed flex flex-col justify-start select-none relative overflow-hidden">
                                <div class="absolute top-2 right-2 bg-rose-600 text-white text-[9px] font-black px-2 py-0.5 rounded shadow-sm uppercase tracking-wider z-10">Out of Stock</div>
                                
                                <div class="overflow-hidden aspect-square w-full bg-gray-900">
                                    <img src="{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}" class="w-full h-full object-cover grayscale" alt="{{ $menu->nama }}">
                                </div>
                                
                                <div class="p-3 w-full">
                                    <h3 class="font-bold text-xs xl:text-sm text-gray-600 truncate capitalize mb-0.5">{{ $menu->nama }}</h3>
                                    <p class="text-[10px] text-gray-600 font-medium italic">Stok Habis</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <aside class="w-[360px] xl:w-[430px] bg-[#111827] border-l border-gray-800 flex flex-col shadow-2xl z-20 h-screen overflow-hidden shrink-0 transition-all">
        <form action="{{ route('pos.store') }}" method="POST" class="h-full flex flex-col justify-between overflow-hidden" onsubmit="return validatePayment()">
            @csrf
            <div class="p-3 bg-[#0E131F] shrink-0 space-y-2 border-b border-gray-800/80">
                <div class="flex items-center justify-between">
                    <h2 class="font-black text-white text-xs tracking-wider uppercase">Check-Out Order</h2>
                    <div class="flex items-center gap-2">
                        <button type="button" id="open-draft-modal-btn" onclick="openHeldModal()" 
                                class="hidden bg-amber-500/20 hover:bg-amber-500 border border-amber-500/40 text-amber-400 hover:text-white px-2 py-0.5 rounded text-xs font-black transition active:scale-95 flex items-center gap-1 shadow-sm">
                            <i data-lucide="pause-circle" class="w-3.5 h-3.5"></i>
                            <span>Draf (<span id="held-count-badge">0</span>)</span>
                        </button>
                        <span class="text-[10px] bg-orange-500 text-white px-2 py-0.5 rounded font-mono font-black shadow-sm">ACTIVE BILL</span>
                    </div>
                </div>
                
                <div>
                    <input type="hidden" name="table_number" id="table_number_input" required>
                    <div class="flex items-center justify-between bg-[#1F2937] border border-gray-800 p-1.5 px-2.5 rounded-xl">
                        <div class="flex items-center gap-2 min-w-0 pr-2">
                            <i data-lucide="utensils" class="w-4 h-4 text-orange-400 shrink-0"></i>
                            <span id="selected-table-display" class="font-black text-xs text-white truncate">Belum Pilih Meja / Sajian</span>
                        </div>
                        <button type="button" onclick="openTableModal()" class="bg-orange-500 hover:bg-orange-600 text-white font-black text-xs px-2.5 py-1 rounded-lg transition active:scale-95 shadow-sm shrink-0 flex items-center gap-1">
                            <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
                            <span>Pilih Meja</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-0.5">
                    <div>
                        <label class="block text-[9px] font-black text-gray-400 uppercase tracking-wide mb-0.5">WA Member</label>
                        <input type="text" name="customer_phone" class="w-full bg-[#1F2937] text-white rounded-lg p-1 px-2 border border-gray-800 text-xs font-medium focus:ring-1 focus:ring-orange-500 outline-none" placeholder="08123...">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-gray-400 uppercase tracking-wide mb-0.5">Nama Member</label>
                        <input type="text" name="customer_name" class="w-full bg-[#1F2937] text-white rounded-lg p-1 px-2 border border-gray-800 text-xs font-medium focus:ring-1 focus:ring-orange-500 outline-none" placeholder="Ketik nama...">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between px-3.5 py-2 bg-[#0E131F] border-b border-gray-800 shrink-0">
                <span class="text-xs font-black text-orange-400 uppercase tracking-widest flex items-center gap-1.5">
                    <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i> Detail Pesanan Keranjang
                </span>
                <button type="button" onclick="clearCart()" class="text-rose-400 hover:text-white font-extrabold text-xs flex items-center gap-1 bg-rose-950/40 hover:bg-rose-600 border border-rose-800/50 px-2 py-0.5 rounded-lg transition active:scale-95 shadow-sm">
                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                    <span>Kosongkan</span>
                </button>
            </div>

            <div class="flex-1 p-3 overflow-y-auto space-y-2 bg-[#0E131F]/30 border-b border-gray-800 custom-table-scrollbar" id="cart-items">
                <div class="flex flex-col items-center justify-center h-full text-center py-6 opacity-40">
                    <i data-lucide="shopping-cart" class="w-8 h-8 text-gray-500 mb-1"></i>
                    <p class="text-gray-400 text-xs font-medium">Keranjang PoS Kosong.</p>
                </div>
            </div>

            <div class="p-3 bg-[#0E131F] space-y-2.5 shrink-0">
                <div class="flex justify-between items-center text-xs">
                    <span class="font-bold text-gray-400 text-xs">Total Tagihan Nota:</span>
                    <span class="text-xl font-black text-orange-400 tracking-tight font-mono" id="total-view">Rp 0</span>
                </div>

                <div class="space-y-1.5 bg-[#1F2937] p-2.5 rounded-xl border border-gray-800 shadow-sm">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider">Uang Cash Diterima</label>
                            <span class="text-[9px] font-bold text-gray-500">Shortcut:</span>
                        </div>
                        <input type="number" id="cash-input" class="w-full bg-[#111827] text-white font-extrabold rounded-lg px-2.5 py-1.5 border border-gray-800 text-sm outline-none focus:ring-1 focus:ring-orange-500 font-mono">
                        
                        <div class="grid grid-cols-4 gap-1 mt-1.5">
                            <button type="button" onclick="setQuickCash('pas')" class="bg-[#111827] hover:bg-orange-500 hover:text-white border border-gray-800 text-gray-300 font-black text-xs py-1 rounded-lg transition text-center active:scale-95 shadow-sm">Uang Pas</button>
                            <button type="button" onclick="setQuickCash(20000)" class="bg-[#111827] hover:bg-orange-500 hover:text-white border border-gray-800 text-gray-300 font-black text-xs py-1 rounded-lg transition text-center active:scale-95 shadow-sm">20rb</button>
                            <button type="button" onclick="setQuickCash(50000)" class="bg-[#111827] hover:bg-orange-500 hover:text-white border border-gray-800 text-gray-300 font-black text-xs py-1 rounded-lg transition text-center active:scale-95 shadow-sm">50rb</button>
                            <button type="button" onclick="setQuickCash(100000)" class="bg-[#111827] hover:bg-orange-500 hover:text-white border border-gray-800 text-gray-300 font-black text-xs py-1 rounded-lg transition text-center active:scale-95 shadow-sm">100rb</button>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-xs border-t border-gray-800/80 pt-1.5 mt-1">
                        <span class="font-bold text-gray-400 text-xs">Uang Kembalian:</span>
                        <span id="change-view" class="font-black text-white font-mono text-sm">Rp 0</span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="holdCurrentOrder()" class="col-span-1 bg-amber-600/20 hover:bg-amber-600 text-amber-400 hover:text-white border border-amber-500/30 font-black py-2.5 px-2 rounded-lg text-xs uppercase tracking-wider transition active:scale-95 flex items-center justify-center gap-1 shadow-sm" title="Simpan keranjang ke Draf/Hold">
                        <i data-lucide="pause-circle" class="w-3.5 h-3.5"></i> Tahan Nota
                    </button>
                    <button type="submit" class="col-span-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black py-2.5 px-2 rounded-lg text-xs uppercase tracking-wider transition duration-150 shadow-md shadow-emerald-950/50 flex items-center justify-center gap-1.5 active:scale-95">
                        <i data-lucide="printer" class="w-4 h-4"></i> Proses & Cetak Struk
                    </button>
                </div>
            </div>
        </form>
    </aside>
</div>

<div id="addMenuModal" class="hidden fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#111827] border border-orange-500/40 w-full max-w-md rounded-2xl p-5 shadow-2xl space-y-4 relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-start justify-between border-b border-gray-800 pb-3 gap-3">
            <div class="flex items-center gap-3">
                <img id="modal-menu-img" src="" class="w-14 h-14 object-cover rounded-lg border border-gray-800 shadow-md" alt="">
                <div>
                    <h3 id="modal-menu-name" class="text-sm font-black text-white capitalize leading-tight"></h3>
                    <p id="modal-menu-category" class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5"></p>
                    <p id="modal-menu-price-label" class="text-xs font-black text-orange-400 font-mono mt-0.5"></p>
                </div>
            </div>
            <button type="button" onclick="closeAddModal()" class="text-gray-400 hover:text-white p-1 rounded-lg bg-gray-800/60 hover:bg-gray-800 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="bg-[#1F2937]/70 p-3 rounded-xl border border-gray-800 flex items-center justify-between">
            <span class="text-xs font-extrabold text-gray-300">Jumlah Porsi Pesanan:</span>
            <div class="flex items-center gap-3 bg-[#111827] p-1.5 rounded-lg border border-gray-800">
                <button type="button" onclick="adjustModalQty(-1)" class="w-8 h-8 bg-gray-800 hover:bg-gray-700 active:scale-90 text-white font-black rounded-md flex items-center justify-center transition text-sm shadow-sm">-</button>
                <span id="modal-qty-view" class="w-8 text-center font-black text-white font-mono text-base">1</span>
                <button type="button" onclick="adjustModalQty(1)" class="w-8 h-8 bg-orange-500 hover:bg-orange-600 active:scale-90 text-white font-black rounded-md flex items-center justify-center transition text-sm shadow-sm">+</button>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Pilih Cepat Catatan Dapur:</label>
            <div class="flex flex-wrap gap-1.5">
                <button type="button" onclick="appendQuickNote('Pedas')" class="bg-[#1F2937] hover:bg-rose-500/20 hover:text-rose-400 border border-gray-800 hover:border-rose-500/50 text-gray-300 text-[10px] font-bold px-2.5 py-1 rounded-lg transition active:scale-95">🌶️ Pedas</button>
                <button type="button" onclick="appendQuickNote('Sedang')" class="bg-[#1F2937] hover:bg-amber-500/20 hover:text-amber-400 border border-gray-800 hover:border-amber-500/50 text-gray-300 text-[10px] font-bold px-2.5 py-1 rounded-lg transition active:scale-95">🔥 Sedang</button>
                <button type="button" onclick="appendQuickNote('Tidak Pedas')" class="bg-[#1F2937] hover:bg-emerald-500/20 hover:text-emerald-400 border border-gray-800 hover:border-emerald-500/50 text-gray-300 text-[10px] font-bold px-2.5 py-1 rounded-lg transition active:scale-95">🕊️ Tidak Pedas</button>
                <button type="button" onclick="appendQuickNote('Tanpa Bawang')" class="bg-[#1F2937] hover:bg-orange-500/20 hover:text-orange-400 border border-gray-800 hover:border-orange-500/50 text-gray-300 text-[10px] font-bold px-2.5 py-1 rounded-lg transition active:scale-95">🚫 Tanpa Bawang</button>
                <button type="button" onclick="appendQuickNote('Es Sedikit')" class="bg-[#1F2937] hover:bg-orange-500/20 hover:text-orange-400 border border-gray-800 hover:border-orange-500/50 text-gray-300 text-[10px] font-bold px-2.5 py-1 rounded-lg transition active:scale-95">🧊 Es Sedikit</button>
                <button type="button" onclick="appendQuickNote('Manis Sedang')" class="bg-[#1F2937] hover:bg-orange-500/20 hover:text-orange-400 border border-gray-800 hover:border-orange-500/50 text-gray-300 text-[10px] font-bold px-2.5 py-1 rounded-lg transition active:scale-95">🧪 Manis Sedang</button>
                <button type="button" onclick="appendQuickNote('Bungkus Pisah')" class="bg-[#1F2937] hover:bg-orange-500/20 hover:text-orange-400 border border-gray-800 hover:border-orange-500/50 text-gray-300 text-[10px] font-bold px-2.5 py-1 rounded-lg transition active:scale-95">🥡 Bungkus Pisah</button>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Catatan Kustom Dapur / Pelanggan:</label>
            <input type="text" id="modal-note-input" placeholder="Tuliskan permintaan khusus di sini..." class="w-full bg-[#1F2937] text-white text-xs font-medium rounded-xl p-2.5 border border-gray-800 focus:border-orange-500 outline-none transition shadow-sm">
        </div>

        <div class="pt-2 border-t border-gray-800 flex items-center gap-2">
            <button type="button" onclick="closeAddModal()" class="w-1/3 bg-gray-800 hover:bg-gray-700 text-gray-300 font-extrabold text-xs py-3 rounded-xl transition">Batal</button>
            <button type="button" onclick="confirmAddToCartFromModal()" class="w-2/3 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-black text-xs py-3 rounded-xl transition shadow-lg shadow-orange-500/30 flex items-center justify-center gap-1.5 active:scale-95">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span id="modal-submit-btn-text">Masukkan Keranjang</span>
            </button>
        </div>
    </div>
</div>

<div id="tableSelectModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#111827] border border-orange-500/30 w-full max-w-lg rounded-xl p-5 shadow-2xl space-y-4 relative">
        <div class="flex items-center justify-between border-b border-gray-800 pb-3">
            <h3 class="text-sm font-black text-orange-400 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="layout-grid" class="w-4 h-4"></i> Pilih Jalur Meja / Metode Sajian
            </h3>
            <button type="button" onclick="closeTableModal()" class="text-gray-400 hover:text-white p-1 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="space-y-3">
            <button type="button" type-value="Takeaway" onclick="selectVisualTable(this)"
                    class="table-btn w-full text-left p-3 rounded-xl border flex items-center justify-between text-xs font-black transition duration-150 bg-[#1F2937] border-gray-800 text-white hover:border-orange-500 hover:bg-orange-500/10 shadow-sm select-none">
                <div class="flex items-center gap-2">
                    <i data-lucide="package" class="w-5 h-5 text-orange-400"></i>
                    <span class="text-sm">Takeaway (Bawa Pulang)</span>
                </div>
                <span class="status-indicator text-xs font-black text-emerald-400 bg-emerald-950/60 px-2.5 py-1 rounded-lg border border-emerald-900/60">Ready</span>
            </button>

            <div>
                <span class="text-xs font-black text-gray-400 uppercase tracking-wider block mb-1.5">Dine-In Area</span>
                <div class="grid grid-cols-5 gap-2">
                    @for($i = 1; $i <= 10; $i++)
                        @php 
                            $namaMeja = "Meja " . $i; 
                            $isOccupied = in_array(trim($namaMeja), array_map('trim', $occupiedTables ?? []));
                        @endphp
                        <button type="button" type-value="{{ $namaMeja }}" onclick="selectVisualTable(this)" {{ $isOccupied ? 'disabled' : '' }}
                                class="table-btn p-2 rounded-xl border text-center font-black transition-all duration-150 flex flex-col items-center justify-center min-h-[48px] shadow-sm select-none
                                {{ $isOccupied ? 'bg-rose-950/20 border-rose-900/40 text-rose-800 cursor-not-allowed opacity-40' : 'bg-[#1F2937] border-gray-800 text-white hover:border-orange-500 hover:bg-orange-500/10' }}">
                            <span class="text-xs">M{{ $i }}</span>
                            <span class="status-indicator text-[9px] font-black block leading-none mt-0.5 {{ $isOccupied ? 'text-rose-500' : 'text-emerald-400' }}">
                                {{ $isOccupied ? 'Terisi' : 'Kosong' }}
                            </span>
                        </button>
                    @endfor
                </div>
            </div>

            <div>
                <span class="text-xs font-black text-orange-400 uppercase tracking-wider block mb-1.5">Waiting List</span>
                <div class="grid grid-cols-3 gap-2">
                    @for($w = 1; $w <= 3; $w++)
                        <button type="button" type-value="Waiting List Antrean {{ $w }}" onclick="selectVisualTable(this)"
                                class="table-btn waiting-btn p-2 rounded-xl border text-center font-black transition-all duration-150 flex flex-col items-center justify-center min-h-[45px] shadow-sm bg-[#1F2937] border-gray-800 text-white hover:border-orange-500 hover:bg-orange-500/10 select-none">
                            <span class="text-xs">Slot {{ $w }}</span>
                            <span class="status-indicator text-[9px] font-black block leading-none mt-0.5 text-orange-400 uppercase tracking-wide">Queue</span>
                        </button>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<div id="heldOrdersModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#111827] border border-amber-500/30 w-full max-w-md rounded-xl p-5 shadow-2xl space-y-4 relative">
        <div class="flex items-center justify-between border-b border-gray-800 pb-3">
            <h3 class="text-sm font-black text-amber-400 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="pause-circle" class="w-4 h-4"></i> Daftar Draf Ditahan (Hold Orders)
            </h3>
            <button type="button" onclick="closeHeldModal()" class="text-gray-400 hover:text-white p-1 transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div id="modal-held-orders-list" class="max-h-80 overflow-y-auto custom-table-scrollbar space-y-2"></div>

        <div class="pt-2 border-t border-gray-800 text-right">
            <button type="button" onclick="closeHeldModal()" class="bg-gray-800 hover:bg-gray-700 text-gray-300 font-extrabold text-xs px-4 py-2 rounded-lg transition">Tutup Window</button>
        </div>
    </div>
</div>

<script>
    let cart = [];
    let heldOrders = [];
    let finalTotalGlobal = 0;

    let activeModalMenu = null;
    let activeModalQty = 1;

    let touchStartX = 0;
    let touchStartY = 0;
    let isSwiping = false;

    function handleTouchStart(e) {
        const touch = e.touches ? e.touches[0] : e;
        touchStartX = touch.clientX;
        touchStartY = touch.clientY;
        isSwiping = false;
    }

    function handleTouchMove(e) {
        const touch = e.touches ? e.touches[0] : e;
        const deltaX = Math.abs(touch.clientX - touchStartX);
        const deltaY = Math.abs(touch.clientY - touchStartY);

        if (deltaX > 10 || deltaY > 10) {
            isSwiping = true;
        }
    }

    function handleCardClick(e, id, name, price, maxStock, image, category) {
        if (isSwiping) {
            isSwiping = false;
            return;
        }
        openAddModal(id, name, price, maxStock, image, category);
    }

    function openAddModal(id, name, price, maxStock, image, category) {
        activeModalMenu = { id, name, price, maxStock };
        activeModalQty = 1;

        document.getElementById('modal-menu-img').src = image;
        document.getElementById('modal-menu-name').innerText = name;
        document.getElementById('modal-menu-category').innerText = category;
        document.getElementById('modal-menu-price-label').innerText = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('modal-qty-view').innerText = activeModalQty;
        document.getElementById('modal-note-input').value = '';

        updateModalSubmitBtnText();
        document.getElementById('addMenuModal').classList.remove('hidden');
        lucide.createIcons();
    }

    function closeAddModal() {
        document.getElementById('addMenuModal').classList.add('hidden');
        activeModalMenu = null;
    }

    function adjustModalQty(delta) {
        if (!activeModalMenu) return;
        let newQty = activeModalQty + delta;
        if (newQty < 1) return;

        let currentTotalQty = cart.filter(i => i.id === activeModalMenu.id).reduce((sum, i) => sum + i.quantity, 0);

        if (currentTotalQty + newQty > activeModalMenu.maxStock) {
            alert('Jumlah melebihi stok yang tersedia!');
            return;
        }
        activeModalQty = newQty;
        document.getElementById('modal-qty-view').innerText = activeModalQty;
        updateModalSubmitBtnText();
    }

    const spicinessGroup = ['Pedas', 'Sedang', 'Tidak Pedas'];

    function appendQuickNote(text) {
        let noteInput = document.getElementById('modal-note-input');
        let currentText = noteInput.value.trim();

        let notes = currentText ? currentText.split(',').map(s => s.trim()).filter(Boolean) : [];

        if (spicinessGroup.includes(text)) {
            if (notes.includes(text)) {
                notes = notes.filter(n => n !== text);
            } else {
                notes = notes.filter(n => !spicinessGroup.includes(n));
                notes.unshift(text);
            }
        } else {
            if (notes.includes(text)) {
                notes = notes.filter(n => n !== text);
            } else {
                notes.push(text);
            }
        }

        noteInput.value = notes.join(', ');
    }

    function updateModalSubmitBtnText() {
        if (!activeModalMenu) return;
        let total = activeModalMenu.price * activeModalQty;
        document.getElementById('modal-submit-btn-text').innerText = 'Tambah (' + activeModalQty + 'x) • Rp ' + total.toLocaleString('id-ID');
    }

    function confirmAddToCartFromModal() {
        if (!activeModalMenu) return;

        let note = document.getElementById('modal-note-input').value.trim();

        let totalUsedStock = cart.filter(item => item.id === activeModalMenu.id)
                                 .reduce((sum, item) => sum + item.quantity, 0);

        if (totalUsedStock + activeModalQty > activeModalMenu.maxStock) {
            alert('Stok hidangan dapur tidak mencukupi!');
            return;
        }

        let existingItem = cart.find(item => 
            item.id === activeModalMenu.id && 
            (item.note || '').trim().toLowerCase() === note.toLowerCase()
        );

        if (existingItem) {
            existingItem.quantity += activeModalQty;
        } else {
            cart.push({
                id: activeModalMenu.id,
                name: activeModalMenu.name,
                price: activeModalMenu.price,
                quantity: activeModalQty,
                maxStock: activeModalMenu.maxStock,
                note: note
            });
        }

        closeAddModal();
        updateCartView();
    }

    function toggleCategoryMenu() {
        const menu = document.getElementById('categoryDropdownMenu');
        menu.classList.toggle('hidden');
    }

    function selectCategory(value, label, iconName, colorClass) {
        document.getElementById('categoryFilter').value = value;
        
        const labelEl = document.getElementById('currentCategoryLabel');
        labelEl.innerText = label;
        labelEl.className = 'font-black text-xs hidden sm:inline ' + colorClass;

        const iconEl = document.getElementById('currentCategoryIcon');
        iconEl.setAttribute('data-lucide', iconName);
        iconEl.className = 'w-4 h-4 ' + colorClass;
        
        lucide.createIcons();

        document.getElementById('categoryDropdownMenu').classList.add('hidden');
        filterMenu();
    }

    document.addEventListener('click', function(event) {
        const wrapper = document.getElementById('categoryDropdownWrapper');
        if (wrapper && !wrapper.contains(event.target)) {
            const menu = document.getElementById('categoryDropdownMenu');
            if (menu) menu.classList.add('hidden');
        }
    });

    function openTableModal() {
        document.getElementById('tableSelectModal').classList.remove('hidden');
    }

    function closeTableModal() {
        document.getElementById('tableSelectModal').classList.add('hidden');
    }

    function selectVisualTable(button) {
        const tableValue = button.getAttribute('type-value');
        document.getElementById('table_number_input').value = tableValue;
        document.getElementById('selected-table-display').innerText = tableValue;

        closeTableModal();
    }

    function filterMenu() {
        let searchInput = document.getElementById('searchInput');
        let categoryInput = document.getElementById('categoryFilter');
        
        let searchFilter = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let categoryFilter = categoryInput ? categoryInput.value.toLowerCase().trim() : 'semua';
        
        let menuGrid = document.getElementById('menuGrid');
        let cards = menuGrid.getElementsByClassName('menu-card');

        for (let i = 0; i < cards.length; i++) {
            let menuName = cards[i].getAttribute('data-name') || '';
            let menuCategory = cards[i].getAttribute('data-category') || '';
            let isBestSeller = cards[i].getAttribute('data-bestseller') === 'true';

            let matchSearch = menuName.includes(searchFilter);
            let matchCategory = false;

            if (categoryFilter === 'semua') {
                matchCategory = true;
            } else if (categoryFilter === 'bestseller') {
                matchCategory = isBestSeller;
            } else {
                matchCategory = menuCategory.includes(categoryFilter);
            }

            if (matchSearch && matchCategory) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }

    function increaseQuantity(index) {
        let item = cart[index];
        if (item) {
            let totalUsedStock = cart.filter(i => i.id === item.id)
                                     .reduce((sum, i) => sum + i.quantity, 0);

            if (totalUsedStock + 1 > item.maxStock) { 
                alert('Batas ketersediaan stok dapur tercapai!'); 
                return; 
            }
            item.quantity += 1;
            updateCartView();
        }
    }

    function decreaseQuantity(index) {
        let item = cart[index];
        if (item) {
            item.quantity -= 1;
            if (item.quantity <= 0) {
                cart.splice(index, 1);
            }
            updateCartView();
        }
    }

    function clearCart() {
        if (cart.length === 0) return;
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh item keranjang?')) {
            cart = [];
            updateCartView();
        }
    }

    function setQuickCash(amount) {
        const cashInput = document.getElementById('cash-input');
        if (amount === 'pas') {
            cashInput.value = finalTotalGlobal;
        } else {
            cashInput.value = amount;
        }
        cashInput.dispatchEvent(new Event('input'));
    }

    function openHeldModal() {
        if (heldOrders.length === 0) return;
        document.getElementById('heldOrdersModal').classList.remove('hidden');
    }

    function closeHeldModal() {
        document.getElementById('heldOrdersModal').classList.add('hidden');
    }

    function holdCurrentOrder() {
        if (cart.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }

        let selectedTable = document.getElementById('table_number_input').value || 'Tanpa Meja';
        let custNameInput = document.querySelector('input[name="customer_name"]');
        let custPhoneInput = document.querySelector('input[name="customer_phone"]');
        let custName = custNameInput ? custNameInput.value : 'Pelanggan';

        heldOrders.push({
            id: Date.now(),
            table: selectedTable,
            customer: custName || 'Pelanggan',
            phone: custPhoneInput ? custPhoneInput.value : '',
            time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
            cart: JSON.parse(JSON.stringify(cart))
        });

        cart = [];
        if (custNameInput) custNameInput.value = '';
        if (custPhoneInput) custPhoneInput.value = '';
        
        updateCartView();
        renderHeldOrders();
    }

    function restoreHeldOrder(index) {
        if (cart.length > 0) {
            alert('Aksi ditolak! Tidak bisa membuka draf karena masih ada pesanan di keranjang. Silakan kosongkan atau selesaikan pesanan di keranjang terlebih dahulu.');
            return;
        }
        
        let held = heldOrders[index];
        cart = JSON.parse(JSON.stringify(held.cart));
        
        let custNameInput = document.querySelector('input[name="customer_name"]');
        let custPhoneInput = document.querySelector('input[name="customer_phone"]');
        if (custNameInput) custNameInput.value = held.customer !== 'Pelanggan' ? held.customer : '';
        if (custPhoneInput) custPhoneInput.value = held.phone || '';

        document.getElementById('table_number_input').value = held.table;
        document.getElementById('selected-table-display').innerText = held.table;

        heldOrders.splice(index, 1);
        updateCartView();
        renderHeldOrders();
        closeHeldModal();
    }

    function deleteHeldOrder(index) {
        heldOrders.splice(index, 1);
        renderHeldOrders();
        if (heldOrders.length === 0) closeHeldModal();
    }

    function renderHeldOrders() {
        let modalBtn = document.getElementById('open-draft-modal-btn');
        let badge = document.getElementById('held-count-badge');
        let modalList = document.getElementById('modal-held-orders-list');

        if (heldOrders.length === 0) {
            if (modalBtn) modalBtn.classList.add('hidden');
            return;
        }

        if (modalBtn) modalBtn.classList.remove('hidden');
        if (badge) badge.innerText = heldOrders.length;

        if (modalList) {
            let html = '';
            heldOrders.forEach((held, idx) => {
                html += `
                    <div class="flex items-center justify-between bg-[#1F2937] border border-amber-500/30 p-3 rounded-lg text-xs">
                        <div>
                            <p class="font-black text-amber-400 text-xs mb-0.5">${held.table} • ${held.customer}</p>
                            <p class="text-[11px] text-gray-400">${held.cart.length} Jenis Menu • Pukul ${held.time} WIB</p>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button type="button" onclick="restoreHeldOrder(${idx})" class="bg-amber-500 hover:bg-amber-600 text-white font-black text-xs px-3 py-1.5 rounded transition">Buka Draf</button>
                            <button type="button" onclick="deleteHeldOrder(${idx})" class="bg-rose-950/80 hover:bg-rose-600 text-rose-300 hover:text-white font-bold text-xs px-2.5 py-1.5 rounded transition">Hapus</button>
                        </div>
                    </div>`;
            });
            modalList.innerHTML = html;
        }
    }

    function updateCartView() {
        let cartContainer = document.getElementById('cart-items');
        let totalView = document.getElementById('total-view');
        
        if (cart.length === 0) {
            cartContainer.innerHTML = '<div class="flex flex-col items-center justify-center h-full text-center py-6 opacity-40"><i data-lucide="shopping-cart" class="w-8 h-8 text-gray-500 mb-1"></i><p class="text-gray-400 text-xs font-medium">Keranjang PoS Kosong.</p></div>';
            totalView.innerText = 'Rp 0';
            finalTotalGlobal = 0;
            lucide.createIcons();
            return;
        }

        let html = ''; let subtotal = 0;
        cart.forEach((item, index) => {
            let itemSubtotal = item.price * item.quantity;
            subtotal += itemSubtotal;
            html += `
                <div class="bg-[#1F2937] border border-gray-800 p-2.5 rounded-xl shadow-sm text-xs mb-2 transition">
                    <div class="flex justify-between items-center gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-white text-xs truncate capitalize mb-0.5">${item.name}</p>
                            <p class="text-orange-400/90 font-mono font-bold text-[11px]">Rp ${item.price.toLocaleString('id-ID')}</p>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0 bg-[#111827] border border-gray-800 p-1 rounded-lg">
                            <button type="button" onclick="decreaseQuantity(${index})" class="bg-gray-800 hover:bg-gray-700 text-white w-6 h-6 rounded-md font-black flex items-center justify-center transition active:scale-90 text-xs shadow-sm">-</button>
                            <span class="font-black text-white w-5 text-center font-mono text-xs">${item.quantity}</span>
                            <button type="button" onclick="increaseQuantity(${index})" class="bg-orange-500 hover:bg-orange-600 text-white w-6 h-6 rounded-md font-black flex items-center justify-center transition active:scale-90 text-xs shadow-sm">+</button>
                        </div>
                        <div class="text-right font-black font-mono min-w-[70px] text-white text-xs">
                            Rp ${itemSubtotal.toLocaleString('id-ID')}
                        </div>
                    </div>

                    <div class="mt-2 pt-1.5 border-t border-gray-800/60">
                        <div class="relative flex items-center">
                            <input type="text" 
                                   placeholder="✏️ Catatan khusus (misal: pedas, tanpa bawang)..." 
                                   value="${item.note || ''}" 
                                   oninput="cart[${index}].note = this.value; document.getElementById('note-input-${index}').value = this.value;" 
                                   class="w-full bg-[#111827] text-slate-200 text-[10px] font-medium rounded-md px-2.5 py-1 border border-gray-800 focus:border-orange-500 outline-none placeholder-gray-600 transition">
                        </div>
                    </div>

                    <input type="hidden" name="items[${index}][menu_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    <input type="hidden" name="items[${index}][price]" value="${item.price}">
                    <input type="hidden" id="note-input-${index}" name="items[${index}][note]" value="${item.note || ''}">
                </div>`;
        });

        finalTotalGlobal = subtotal;
        cartContainer.innerHTML = html;
        totalView.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('cash-input').dispatchEvent(new Event('input'));
        lucide.createIcons();
    }

    document.getElementById('cash-input').addEventListener('input', function() {
        let changeView = document.getElementById('change-view');
        if (!this.value || finalTotalGlobal === 0) { 
            changeView.innerText = 'Rp 0'; 
            changeView.className = "font-black text-white font-mono text-sm"; 
            return; 
        }
        let change = parseFloat(this.value) - finalTotalGlobal;
        if (change < 0) {
            changeView.innerText = 'Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
            changeView.className = "font-black text-rose-400 font-mono text-xs";
        } else {
            changeView.innerText = 'Rp ' + change.toLocaleString('id-ID');
            changeView.className = "font-black text-emerald-400 font-mono text-sm";
        }
    });

    function validatePayment() {
        if (cart.length === 0) return false;
        let selectedTable = document.getElementById('table_number_input').value;
        if (!selectedTable) {
            alert('Aksi Ditolak! Silakan pilih nomor meja atau metode takeaway terlebih dahulu melalui tombol [Pilih Meja].');
            openTableModal();
            return false;
        }
        let cash = document.getElementById('cash-input').value;
        if (!cash || parseFloat(cash) < finalTotalGlobal) { 
            alert('Nominal uang tunai cash kurang!'); 
            return false; 
        }
        return confirm('Konfirmasi selesaikan transaksi kasir & cetak draf nota?');
    }
</script>
@endsection