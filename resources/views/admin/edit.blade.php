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

    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity duration-300"></div>

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
                    <h2 class="text-sm sm:text-lg font-black text-white tracking-tight flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4 text-orange-500 hidden sm:inline"></i> Edit Menu Hidangan
                    </h2>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5 hidden sm:block">Perbarui rincian kategori, nama, gambar, atau harga menu hidangan.</p>
                </div>
            </div>

            <a href="{{ route('admin.menu_list') }}" class="bg-[#1F2937] hover:bg-gray-800 text-slate-300 hover:text-white border border-gray-700 font-bold px-2.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1 shadow-sm shrink-0">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> <span>Kembali</span>
            </a>
        </header>

        <div class="flex-1 p-3 sm:p-6 lg:p-8 overflow-y-auto custom-table-scroll flex justify-center items-start">
            
            <!-- CARD EDIT (DESKTOP: max-w-xl p-8, MOBILE: p-4 PAS & RINGKAS) -->
            <div class="bg-[#111827] border border-gray-800 rounded-xl sm:rounded-2xl p-4 sm:p-8 w-full max-w-xl shadow-2xl space-y-4 sm:space-y-6 my-auto">
                <div class="border-b border-gray-800 pb-3 sm:pb-4">
                    <h2 class="text-base sm:text-2xl font-black uppercase tracking-tight text-white">
                        Edit <span class="text-orangeMakCik">Menu Hidangan</span>
                    </h2>
                    <p class="text-[11px] sm:text-xs text-gray-400 font-medium mt-0.5">Perbarui rincian kategori, nama, gambar, atau harga menu.</p>
                </div>

                <form action="{{ route('admin.menu_update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 sm:space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Kategori</label>
                        <select name="kategori" class="w-full bg-[#1F2937] border border-gray-800 rounded-lg sm:rounded-xl px-3 py-2 sm:px-4 sm:py-3 text-xs text-white outline-none focus:border-orangeMakCik font-bold cursor-pointer">
                            <option value="Makanan" {{ $menu->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ $menu->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Snack" {{ $menu->kategori == 'Snack' ? 'selected' : '' }}>Snack</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Nama Menu</label>
                        <input type="text" name="nama" value="{{ $menu->nama }}" class="w-full bg-[#1F2937] border border-gray-800 rounded-lg sm:rounded-xl px-3 py-2 sm:px-4 sm:py-3 text-xs text-white outline-none focus:border-orangeMakCik font-medium" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Foto Produk</label>
                        
                        <div class="flex items-center gap-3 mb-2">
                            @if($menu->gambar)
                                <img id="preview-foto" src="{{ asset('menu_images/' . $menu->gambar) }}" class="w-20 h-20 sm:w-28 sm:h-28 object-cover rounded-lg sm:rounded-xl border border-gray-700 block shrink-0">
                            @else
                                <img id="preview-foto" class="w-20 h-20 sm:w-28 sm:h-28 object-cover rounded-lg sm:rounded-xl border border-gray-700 shrink-0" style="display: none;">
                            @endif
                            <div class="text-[11px] text-gray-400 space-y-0.5">
                                <p class="font-bold text-slate-300">Tips Gambar:</p>
                                <p class="text-[10px] sm:text-[11px] text-gray-500">Format JPG/PNG rasio 1:1 maksimal 2MB.</p>
                            </div>
                        </div>

                        <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage()" class="w-full bg-[#1F2937] border border-gray-800 rounded-lg sm:rounded-xl p-1.5 text-xs text-gray-400 outline-none focus:border-orangeMakCik file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] sm:file:text-xs file:font-bold file:bg-gray-800 file:text-white">
                        <p class="text-[10px] text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengganti foto.</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Harga Satuan (Rp)</label>
                        <input type="text" name="harga" value="{{ $menu->harga }}" class="w-full bg-[#1F2937] border border-gray-800 rounded-lg sm:rounded-xl px-3 py-2 sm:px-4 sm:py-3 text-xs text-white outline-none focus:border-orangeMakCik font-mono font-bold" required>
                    </div>

                    <div class="flex gap-2.5 pt-3 border-t border-gray-800/80">
                        <a href="{{ route('admin.menu_list') }}" class="flex-1 text-center py-2.5 border border-gray-800 bg-[#1F2937] rounded-lg sm:rounded-xl text-xs font-bold text-gray-400 hover:text-white transition">Batal</a>
                        <button type="submit" class="flex-1 bg-orangeMakCik hover:bg-orange-600 py-2.5 rounded-lg sm:rounded-xl text-xs font-black uppercase tracking-wider transition shadow-lg shadow-orange-600/20 text-white">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('sidebar-backdrop').classList.toggle('hidden');
    }
    function previewImage() {
        const image = document.querySelector('#gambar');
        const imgPreview = document.querySelector('#preview-foto');

        if (image.files && image.files[0]) {
            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>

@endsection