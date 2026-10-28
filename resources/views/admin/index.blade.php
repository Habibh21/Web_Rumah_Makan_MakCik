@extends('layouts.app')

@section('content')

<style>
    .custom-table-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-table-scroll::-webkit-scrollbar-track { background: #111827; border-radius: 8px; }
    .custom-table-scroll::-webkit-scrollbar-thumb { background: #374151; border-radius: 8px; }
    .custom-table-scroll::-webkit-scrollbar-thumb:hover { background: #FF6600; }
    .custom-table-scroll { scrollbar-width: thin; scrollbar-color: #374151 #111827; }
</style>

<div class="flex h-screen bg-[#0B0F19] text-slate-300 font-sans overflow-hidden antialiased relative">

    <!-- BACKDROP MOBILE -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity duration-300"></div>

    <!-- SIDEBAR NAVIGASI DESKTOP & MOBILE -->
    <aside id="sidebar" class="fixed lg:static top-0 left-0 w-66 bg-[#111827] border-r border-gray-800 flex flex-col justify-between shadow-[4px_0_24px_rgba(0,0,0,0.3)] z-40 h-screen transition-transform duration-300 -translate-x-full lg:translate-x-0 shrink-0">
        <div class="p-6 overflow-y-auto custom-table-scroll">
            <div class="flex items-center justify-between mb-8 pb-5 border-b border-gray-800/60">
                <div class="flex items-center gap-3.5">
                    <img src="{{ asset('images/logo.png') }}" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';" class="w-14 h-14 object-contain drop-shadow-lg shrink-0" alt="Logo">
                    <div>
                        <h1 class="text-base font-black tracking-tight text-white uppercase leading-snug">
                            Mak Cik <span class="text-orangeMakCik">Admin</span>
                        </h1>
                        <span class="text-xs text-gray-400 font-medium tracking-wide">Control Panel Center</span>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white p-1.5 rounded-lg bg-gray-800 border border-gray-700">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <nav class="space-y-1.5">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 pl-2">Manajemen Utama</p>
                <a href="{{ route('admin.menu_list') }}" class="flex items-center gap-3 bg-gradient-to-r from-orange-500 to-amber-600 text-white px-4 py-2.5 rounded-lg font-black transition-all duration-200 text-xs shadow-md shadow-orange-500/10 border border-orange-400/20">
                    <i data-lucide="layers" class="w-4 h-4"></i> Kelola Menu
                </a>
                <a href="{{ route('admin.laporan') }}" class="group flex items-center gap-3 text-slate-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg transition text-xs font-semibold">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-slate-400 group-hover:text-white transition"></i> Laporan Keuangan
                </a>
                <a href="{{ route('admin.crm') }}" class="group flex items-center gap-3 text-slate-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg transition text-xs font-semibold">
                    <i data-lucide="users" class="w-4 h-4 text-slate-400 group-hover:text-white transition"></i> Manajemen Pelanggan
                </a>

                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mt-6 mb-3 pl-2">Keamanan & Sistem</p>
                <a href="{{ route('admin.audit_log') }}" class="group flex items-center gap-3 text-slate-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg transition text-xs font-semibold">
                    <i data-lucide="shield-check" class="w-4 h-4 text-slate-400 group-hover:text-cyan-400 transition"></i> Audit Log Sistem
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-gray-800 bg-[#0E131F]">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#1F2937] hover:bg-red-950/40 text-red-400 border border-gray-800 hover:border-red-900/50 font-extrabold py-2.5 px-4 rounded-lg text-xs transition shadow-sm">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i> <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden bg-[#0B0F19]">
        <header class="h-16 sm:h-20 bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 px-3.5 sm:px-8 flex items-center justify-between shadow-md z-10 shrink-0 gap-2">
            <div class="flex items-center gap-2.5">
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-300 hover:text-white p-1.5 rounded-lg bg-[#1F2937] border border-gray-700 active:scale-95 transition">
                    <i data-lucide="menu" class="w-4 h-4"></i>
                </button>
                <div>
                    <h2 class="text-sm sm:text-lg font-black text-white tracking-tight">Kelola Menu Hidangan</h2>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5 hidden sm:block">Manajemen satu layar untuk menambah menu baru, memperbarui kuantitas stok, dan memanipulasi data produk hidangan.</p>
                </div>
            </div>
            
            @if(session('success'))
                <div class="bg-emerald-500 text-white px-2.5 py-1 rounded-md font-bold text-[11px] sm:text-xs shadow-md shrink-0">{{ session('success') }}</div>
            @endif
        </header>

        <div class="flex-1 p-3 sm:p-6 lg:p-8 overflow-y-auto custom-table-scroll flex flex-col lg:flex-row gap-4 sm:gap-6 items-start h-[calc(100vh-80px)]">
            
            <!-- FORM TAMBAH ITEM -->
            <div class="w-full lg:w-80 shrink-0">
                <div class="bg-[#111827] border border-gray-800 rounded-xl p-3.5 sm:p-5 shadow-xl space-y-3">
                    <h3 class="text-xs font-black text-white uppercase tracking-wider border-b border-gray-800 pb-2">Tambah Item Baru</h3>
                    
                    <form action="{{ route('admin.menu_store') }}" method="POST" enctype="multipart/form-data" class="space-y-2.5 sm:space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Kategori</label>
                            <select name="kategori" required class="w-full bg-[#1F2937] border border-gray-800 rounded-lg p-2 text-xs text-white outline-none focus:border-orange-500 cursor-pointer">
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Snack">Snack</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Nama Menu</label>
                            <input type="text" name="nama" required placeholder="Contoh: Ayam Bakar" class="w-full bg-[#1F2937] border border-gray-800 rounded-lg p-2 text-xs text-white placeholder-gray-600 outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Harga Satuan</label>
                            <input type="number" name="harga" required placeholder="Contoh: 20000" class="w-full bg-[#1F2937] border border-gray-800 rounded-lg p-2 text-xs text-white font-mono outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Foto Produk</label>
                            <input type="file" name="gambar" class="w-full bg-[#1F2937] border border-gray-800 rounded-lg p-1 text-[11px] text-slate-400 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-black file:bg-gray-800 file:text-white file:cursor-pointer hover:file:bg-gray-700">
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-black py-2.5 px-4 rounded-lg text-xs uppercase tracking-wider transition shadow-md shadow-orange-500/10">
                            Simpan Ke Sistem
                        </button>
                    </form>
                </div>
            </div>

            <!-- AREA DAFTAR MENU -->
            <div class="flex-1 w-full min-w-0 h-full flex flex-col">
                <div class="bg-[#111827] border border-gray-800 rounded-xl p-3.5 sm:p-5 shadow-xl flex flex-col h-full overflow-hidden">
                    
                    <!-- 📱 TAMPILAN MOBILE (RINGKAS, PRESISI, DAN PAS) -->
                    <div class="block md:hidden space-y-2 overflow-y-auto pr-0.5">
                        @forelse($menus as $menu)
                            <div class="bg-[#1F2937]/70 border border-gray-800/80 rounded-lg p-2.5 space-y-2">
                                <div class="flex items-center justify-between gap-2 border-b border-gray-800/80 pb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-9 h-9 rounded-lg border border-gray-700 overflow-hidden bg-gray-900 shrink-0">
                                            <img src="{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-white capitalize leading-tight">{{ $menu->nama }}</h4>
                                            <span class="text-[11px] font-mono font-black text-orange-400">Rp {{ number_format(preg_replace('/[^0-9]/', '', $menu->harga), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @php $katLower = strtolower($menu->kategori); @endphp
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded uppercase shrink-0 {{ $katLower === 'minuman' ? 'bg-blue-950 text-blue-400 border border-blue-900' : ($katLower === 'snack' ? 'bg-amber-950 text-amber-400 border border-amber-900' : 'bg-orange-950 text-orange-400 border border-orange-900') }}">
                                        {{ $menu->kategori }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-2">
                                    <form action="{{ route('admin.menu_update_stok', $menu->id) }}" method="POST" class="flex items-center gap-1">
                                        @csrf
                                        <span class="text-[10px] text-gray-400 font-bold">Stok:</span>
                                        <input type="number" name="stok" value="{{ $menu->stok }}" min="0" class="w-11 bg-[#111827] border {{ $menu->stok <= 5 ? 'border-red-500 text-red-400 font-black' : 'border-gray-700 text-white font-bold' }} rounded px-1 py-0.5 text-center text-xs font-mono">
                                        <button type="submit" class="bg-gray-800 text-slate-300 px-1.5 py-0.5 rounded text-[10px] font-bold border border-gray-700">Simpan</button>
                                    </form>

                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.menu_edit', $menu->id) }}" class="bg-blue-600 text-white font-bold px-2 py-1 rounded text-[10px]">Edit</a>
                                        <form action="{{ route('admin.menu_destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus hidangan [{{ $menu->nama }}]?')">
                                            @csrf
                                            <button type="submit" class="bg-red-600 text-white font-bold px-2 py-1 rounded text-[10px]">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500 text-xs italic">Belum ada menu terdaftar.</div>
                        @endforelse
                    </div>

                    <!-- 💻 DESKTOP TABEL (TIDAK UBAH APA PUN) -->
                    <div class="hidden md:block overflow-y-auto overflow-x-auto flex-1 max-h-[calc(100vh-170px)] border border-gray-800/80 rounded-lg custom-table-scroll pr-1">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 bg-[#161C2E] border-b border-gray-800 text-gray-400 font-black text-[10px] uppercase tracking-wider z-10 shadow-md">
                                <tr>
                                    <th class="py-3.5 px-4 w-16">Foto</th>
                                    <th class="py-3.5 px-4 w-28">Kategori</th>
                                    <th class="py-3.5 px-4">Nama Menu</th>
                                    <th class="py-3.5 px-4 text-center w-36">Stok Dapur</th>
                                    <th class="py-3.5 px-4 text-center w-36">Harga Satuan</th>
                                    <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/80 text-xs text-slate-300">
                                @forelse($menus as $menu)
                                    <tr class="hover:bg-gray-800/40 transition duration-150">
                                        <td class="py-3 px-4">
                                            <div class="w-9 h-9 rounded-full border border-gray-800 overflow-hidden bg-gray-900 flex items-center justify-center shrink-0 shadow-inner">
                                                <img src="{{ asset('menu_images/' . ($menu->gambar ?? 'default.jpg')) }}" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" class="w-full h-full object-cover">
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            @php $katLower = strtolower($menu->kategori); @endphp
                                            @if($katLower === 'minuman')
                                                <span class="inline-block text-[9px] font-black bg-blue-950/60 border border-blue-900/50 text-blue-400 px-2 py-0.5 rounded uppercase tracking-wide">Minuman</span>
                                            @elseif($katLower === 'snack')
                                                <span class="inline-block text-[9px] font-black bg-amber-950/60 border border-amber-900/50 text-amber-400 px-2 py-0.5 rounded uppercase tracking-wide">Snack</span>
                                            @else
                                                <span class="inline-block text-[9px] font-black bg-orange-950/60 border border-orange-900/50 text-orange-400 px-2 py-0.5 rounded uppercase tracking-wide">Makanan</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-white font-extrabold capitalize text-xs sm:text-sm">{{ $menu->nama }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <form action="{{ route('admin.menu_update_stok', $menu->id) }}" method="POST" class="flex flex-col items-center justify-center gap-1">
                                                @csrf
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <input type="number" name="stok" value="{{ $menu->stok }}" min="0" class="w-12 bg-[#1F2937] border {{ $menu->stok <= 5 ? 'border-red-500/70 text-red-400 bg-red-950/20 font-black' : 'border-gray-800 text-white font-bold' }} rounded px-1.5 py-0.5 text-center font-mono outline-none focus:border-orange-500 text-xs">
                                                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-slate-300 px-2 py-1 rounded transition text-[10px] font-bold border border-gray-700">Simpan</button>
                                                </div>
                                                @if($menu->stok <= 5 && $menu->stok > 0)
                                                    <span class="text-[9px] font-black text-red-400 uppercase tracking-widest animate-pulse mt-0.5"><i data-lucide="alert-triangle" class="w-3 h-3 inline pb-0.5"></i> Stok Kritis</span>
                                                @elseif($menu->stok == 0)
                                                    <span class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-0.5"><i data-lucide="x-circle" class="w-3 h-3 inline pb-0.5"></i> Habis</span>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="py-3 px-4 text-center font-black text-orange-400 font-mono text-xs sm:text-sm">
                                            Rp {{ number_format(preg_replace('/[^0-9]/', '', $menu->harga), 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('admin.menu_edit', $menu->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-2.5 py-1 rounded text-[10px] transition shadow-sm">Edit</a>
                                                <form action="{{ route('admin.menu_destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus hidangan [{{ $menu->nama }}] secara permanen?')">
                                                    @csrf
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-black px-2.5 py-1 rounded text-[10px] transition shadow-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-500 font-medium italic bg-[#151C2C]/50 rounded-lg">
                                            <div class="flex flex-col items-center justify-center">
                                                <i data-lucide="utensils-cross" class="w-8 h-8 text-gray-600 mb-2"></i> Belum ada koleksi menu makanan terdaftar.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('sidebar-backdrop').classList.toggle('hidden');
    }
</script>

@endsection