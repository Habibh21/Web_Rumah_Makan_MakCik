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
                <a href="{{ route('admin.menu_list') }}" class="group flex items-center gap-3 text-slate-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg transition text-xs font-semibold">
                    <i data-lucide="layers" class="w-4 h-4 text-slate-400 group-hover:text-white transition"></i> Kelola Menu
                </a>
                <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 bg-gradient-to-r from-orange-500 to-amber-600 text-white px-4 py-2.5 rounded-lg font-black transition-all duration-200 text-xs shadow-md shadow-orange-500/10 border border-orange-400/20">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Laporan Keuangan
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
                    <h2 class="text-sm sm:text-lg font-black text-white tracking-tight">Buku Jurnal Laporan Keuangan Resto</h2>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5 hidden sm:block">Rekapitulasi total omset masuk tunai berdasarkan filter penanggalan kasir secara akurat.</p>
                </div>
            </div>
            
            <div class="flex items-center gap-1.5 sm:gap-2.5">
                <a href="{{ route('admin.laporan.excel', ['filter' => $filter, 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="bg-[#1F2937] hover:bg-gray-700 text-emerald-400 border border-gray-800 font-extrabold py-1.5 px-2.5 sm:py-2 sm:px-3.5 rounded-lg text-[11px] sm:text-xs transition flex items-center gap-1 shadow-sm">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i> <span class="hidden sm:inline">Unduh Excel (.csv)</span><span class="sm:hidden">Excel</span>
                </a>
                <a href="{{ route('admin.laporan.pdf', ['filter' => $filter, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank"
                   class="bg-orange-500 hover:bg-orange-600 text-white font-black py-1.5 px-2.5 sm:py-2 sm:px-3.5 rounded-lg text-[11px] sm:text-xs transition flex items-center gap-1 shadow-md shadow-orange-500/10">
                    <i data-lucide="printer" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i> <span class="hidden sm:inline">Cetak Dokumen PDF</span><span class="sm:hidden">PDF</span>
                </a>
            </div>
        </header>

        <div class="flex-1 p-3 sm:p-8 overflow-y-auto custom-table-scroll space-y-4 sm:space-y-6">
            
            <!-- 📊 TOP 5 MENU TERLARIS -->
            <div class="bg-[#111827] border border-gray-800/80 rounded-xl p-3.5 sm:p-5 shadow-lg">
                <h3 class="text-xs font-black text-white uppercase tracking-wider mb-3 border-b border-gray-800 pb-2 flex items-center gap-1.5">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 text-emerald-400"></i> Top 5 Menu Terlaris (Best Seller)
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-2.5 sm:gap-4">
                    @forelse($bestSellers ?? [] as $index => $best)
                        <div class="bg-[#1F2937] border border-gray-700/50 rounded-lg p-2.5 text-center relative overflow-hidden group">
                            <span class="absolute top-0 left-0 bg-orange-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-br-lg shadow-sm">#{{ $index + 1 }}</span>
                            <div class="w-9 h-9 sm:w-12 sm:h-12 mx-auto rounded-full bg-gray-800 mb-1 border border-gray-700 overflow-hidden mt-1.5">
                                <img src="{{ asset('menu_images/' . ($best->menu->gambar ?? 'default.jpg')) }}" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" class="w-full h-full object-cover">
                            </div>
                            <h4 class="text-[11px] sm:text-xs font-bold text-white truncate px-1" title="{{ $best->menu->nama ?? 'Menu' }}">{{ $best->menu->nama ?? 'Menu Terlaris' }}</h4>
                            <p class="text-[10px] text-orange-400 font-mono font-black mt-0.5">{{ $best->total_terjual ?? 0 }} Terjual</p>
                        </div>
                    @empty
                        <div class="col-span-full py-2 text-center text-xs text-gray-500 italic">
                            Data penjualan menu terlaris sedang dikalkulasi.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 🔑 PENYARINGAN RENTANG WAKTU & RENTANG TANGGAL -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-3.5 sm:gap-5 shrink-0 items-center bg-[#111827] border border-gray-800/80 p-3.5 sm:p-5 rounded-lg shadow-sm">
                <div class="xl:col-span-2 space-y-2.5">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest block pl-0.5">Penyaringan Rentang Waktu</span>
                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                        <a href="{{ route('admin.laporan', ['filter' => 'semua']) }}" class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-bold border {{ $filter == 'semua' ? 'bg-orange-500 text-white border-orange-600' : 'bg-[#1F2937] text-slate-300 border-gray-800 hover:bg-gray-800' }}">Semua</a>
                        <a href="{{ route('admin.laporan', ['filter' => 'hari']) }}" class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-bold border {{ $filter == 'hari' ? 'bg-orange-500 text-white border-orange-600' : 'bg-[#1F2937] text-slate-300 border-gray-800 hover:bg-gray-800' }}">Hari Ini</a>
                        <a href="{{ route('admin.laporan', ['filter' => 'bulan']) }}" class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-bold border {{ $filter == 'bulan' ? 'bg-orange-500 text-white border-orange-600' : 'bg-[#1F2937] text-slate-300 border-gray-800 hover:bg-gray-800' }}">Bulan Ini</a>
                        <a href="{{ route('admin.laporan', ['filter' => 'tahun']) }}" class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-bold border {{ $filter == 'tahun' ? 'bg-orange-500 text-white border-orange-600' : 'bg-[#1F2937] text-slate-300 border-gray-800 hover:bg-gray-800' }}">Tahun Ini</a>
                        
                        <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-wrap items-center gap-1.5 mt-1 sm:mt-0 sm:ml-2 w-full sm:w-auto">
                            <input type="date" name="start_date" value="{{ $startDate }}" class="bg-[#1F2937] border border-gray-800 text-white px-2 py-1 rounded text-[11px] font-mono outline-none focus:border-orange-500">
                            <span class="text-gray-600 text-xs font-bold">s/d</span>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="bg-[#1F2937] border border-gray-800 text-white px-2 py-1 rounded text-[11px] font-mono outline-none focus:border-orange-500">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-slate-300 px-2.5 py-1 rounded-md font-bold text-[11px] border border-gray-700 transition">Filter Tanggal</button>
                        </form>
                    </div>
                </div>

                <div class="bg-[#0B0F19] border border-gray-800 p-3 rounded-lg border-l-4 border-l-orange-500 flex flex-col justify-between w-full">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total Pendapatan Netto</span>
                    <p class="text-lg sm:text-xl font-black text-white tracking-tight font-mono mt-0.5">Rp {{ number_format($totalPenghasilan ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- 🚫 AUDIT LOG VOID (TRANSAKSI DIBATALKAN) -->
            <div class="bg-[#111827] border border-red-900/40 rounded-lg p-3.5 sm:p-6 shadow-xl relative overflow-hidden">
                <h3 class="text-xs font-black text-red-400 uppercase tracking-wider mb-3 sm:mb-4 border-b border-gray-800 pb-2 flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="shield-alert" class="w-4 h-4 text-rose-500"></i> Audit Log: Transaksi Dibatalkan (Void)
                    </span>
                    <span class="text-[10px] font-mono text-gray-500 font-normal hidden sm:inline">Pengawasan Keuangan Kasir</span>
                </h3>

                <!-- 📱 MOBILE VOID CARDS (RINGKAS & KHUSUS HP) -->
                <div class="block md:hidden space-y-2">
                    @forelse($voidLogs ?? [] as $void)
                        <div class="bg-[#1F2937]/70 border border-gray-800 p-2.5 rounded-lg space-y-1">
                            <div class="flex items-center justify-between font-mono">
                                <span class="line-through text-gray-400 font-bold text-xs">TRX-{{ $void->id }}</span>
                                <span class="text-red-400 font-black text-xs">Rp {{ number_format($void->total_price, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-[11px] italic text-gray-300 leading-snug">{{ $void->alasan_batal ?? 'Salah input' }}</p>
                            <div class="text-[10px] text-gray-500 font-mono">{{ $void->updated_at->format('d M, H:i') }} WIB</div>
                        </div>
                    @empty
                        <div class="text-center py-2 text-emerald-400/80 text-xs italic">Aman. Tidak ada transaksi di-void.</div>
                    @endforelse
                </div>

                <!-- 💻 DESKTOP VOID TABLE (ASLI SEPERTI SEMULA) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-red-950/20 border-b border-gray-800 text-gray-500 font-black text-[10px] uppercase tracking-wider">
                                <th class="py-3 px-4 w-32">ID Transaksi</th>
                                <th class="py-3 px-4 w-40">Waktu Pembatalan</th>
                                <th class="py-3 px-4 w-44 text-right">Potensi Kehilangan</th>
                                <th class="py-3 px-4">Alasan Pembatalan (Kasir)</th>
                                <th class="py-3 px-4 text-center w-36">Pelaku Log</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-xs text-slate-300">
                            @forelse($voidLogs ?? [] as $void)
                                <tr class="hover:bg-gray-800/30 transition">
                                    <td class="py-3 px-4 font-mono font-bold text-gray-400 line-through">TRX-{{ $void->id }}</td>
                                    <td class="py-3 px-4 text-slate-400 font-mono">{{ $void->updated_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3 px-4 text-right font-black font-mono text-red-500">Rp {{ number_format($void->total_price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 italic text-gray-400">{{ $void->alasan_batal ?? 'Salah input menu oleh kasir' }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-block text-[9px] font-black bg-rose-950/80 border border-rose-800/60 text-rose-300 px-2 py-0.5 rounded uppercase">
                                            {{ auth()->user()->name ?? 'Admin / Kasir' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-emerald-500/70 font-medium italic text-[11px]">
                                        Aman. Tidak ada rekam jejak pembatalan transaksi / indikasi fraud dari Kasir.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 🛒 TABEL TRANSAKSI PENJUALAN LUNAS -->
            <div class="bg-[#111827] border border-gray-800 rounded-lg p-3.5 sm:p-6 shadow-xl relative overflow-hidden">
                <h3 class="text-xs font-black text-white uppercase tracking-wider mb-3 sm:mb-4 border-b border-gray-800 pb-2 flex items-center gap-1.5">
                    <i data-lucide="receipt" class="w-4 h-4 text-orange-400"></i> Riwayat Transaksi Penjualan Lunas
                </h3>

                <!-- 📱 MOBILE ORDER CARDS (RINGKAS & KHUSUS HP) -->
                <div class="block md:hidden space-y-2">
                    @forelse($orders as $order)
                        @php $isTakeaway = str_contains(strtolower($order->table_number ?? ''), 'takeaway'); @endphp
                        <div class="bg-[#1F2937]/70 border border-gray-800 p-2.5 rounded-lg space-y-1.5">
                            <div class="flex items-center justify-between border-b border-gray-800/80 pb-1">
                                <span class="font-mono font-bold text-gray-400 text-xs">TRX-{{ $order->id }}</span>
                                <span class="font-mono font-black text-orange-400 text-xs">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-white font-bold">{{ $isTakeaway ? 'Takeaway' : $order->table_number }}</span>
                                <span class="text-[10px] text-gray-400 font-mono">{{ $order->created_at->format('d M H:i') }}</span>
                            </div>
                            <div class="pt-1 flex items-center justify-end gap-1.5 border-t border-gray-800/80">
                                <a href="{{ route('pos.print', $order->id) }}?from=laporan" target="_blank" class="bg-[#1F2937] hover:bg-gray-700 text-amber-400 border border-gray-700 font-bold px-2 py-1 rounded text-[10px]">Struk</a>
                                <form action="{{ route('pos.void', $order->id) }}" method="POST" onsubmit="return confirmVoid(this)">
                                    @csrf
                                    <input type="hidden" name="alasan_batal" value="">
                                    <button type="submit" class="bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 font-bold px-2 py-1 rounded text-[10px]">Void</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 italic text-xs">Belum ada transaksi.</div>
                    @endforelse
                </div>

                <!-- 💻 DESKTOP ORDER TABLE (ASLI SEPERTI SEMULA) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1F2937]/50 border-b border-gray-800 text-gray-500 font-black text-[10px] uppercase tracking-wider">
                                <th class="py-4 px-5 w-32">ID Transaksi</th>
                                <th class="py-4 px-5">Tanggal Pembayaran</th>
                                <th class="py-4 px-5">Alokasi Unit Meja</th>
                                <th class="py-4 px-5 w-36">Tipe Pelayanan</th>
                                <th class="py-4 px-5 text-right w-40">Total Nominal</th>
                                <th class="py-4 px-5 text-center w-48">Aksi Interaktif</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-xs text-slate-300">
                            @forelse($orders as $order)
                                @php
                                    $tblNomor = trim(str_ireplace(['meja', 'table'], '', $order->table_number ?? '1'));
                                    $isTakeawayTbl = str_contains(strtolower($order->table_number ?? ''), 'takeaway');
                                @endphp
                                <tr class="hover:bg-gray-800/30 transition duration-150">
                                    <td class="py-3.5 px-5 font-mono font-bold text-gray-400">TRX-{{ $order->id }}</td>
                                    <td class="py-3.5 px-5 font-sans text-slate-300">{{ $order->created_at->format('d M Y, H:i') }} WIB</td>
                                    <td class="py-3.5 px-5 font-extrabold text-white capitalize">
                                        {{ $isTakeawayTbl ? 'Takeaway' : 'Meja ' . $tblNomor }}
                                    </td>
                                    <td class="py-3.5 px-5">
                                        @if($isTakeawayTbl)
                                            <span class="inline-block text-[9px] font-black bg-purple-950/40 border border-purple-900/50 text-purple-400 px-2 py-0.5 rounded">Takeaway</span>
                                        @else
                                            <span class="inline-block text-[9px] font-black bg-emerald-950/40 border border-emerald-900/50 text-emerald-400 px-2 py-0.5 rounded">Dine-In Area</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-black font-mono text-sm text-orange-400">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="py-3.5 px-5 text-center flex items-center justify-center gap-2">
                                        <a href="{{ route('pos.print', $order->id) }}?from=laporan" target="_blank" 
                                           class="inline-flex items-center gap-1 bg-[#1F2937] hover:bg-gray-700 text-amber-400 border border-gray-700 font-bold px-2 py-1.5 rounded text-[10px] transition shadow-sm">
                                            <i data-lucide="receipt" class="w-3.5 h-3.5"></i> Struk
                                        </a>

                                        <form action="{{ route('pos.void', $order->id) }}" method="POST" onsubmit="return confirmVoid(this)">
                                            @csrf
                                            <input type="hidden" name="alasan_batal" value="">
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 bg-rose-950/60 hover:bg-rose-600 text-rose-300 hover:text-white border border-rose-800/50 font-bold px-2 py-1.5 rounded text-[10px] transition shadow-sm">
                                                <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Batal (Void)
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-500 font-medium italic bg-[#151C2C]/50 rounded-lg">
                                        Belum ada rekapan nota penjualan kasir pada rentang waktu ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    function confirmVoid(form) {
        let alasan = prompt("Masukkan alasan pembatalan transaksi:");
        if (!alasan || !alasan.trim()) { alert("Alasan wajib diisi!"); return false; }
        form.querySelector('input[name="alasan_batal"]').value = alasan;
        return confirm("Konfirmasi Void Transaksi?");
    }
</script>

@endsection