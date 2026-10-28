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
                <a href="{{ route('admin.laporan') }}" class="group flex items-center gap-3 text-slate-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg transition text-xs font-semibold">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-slate-400 group-hover:text-white transition"></i> Laporan Keuangan
                </a>
                <a href="{{ route('admin.crm') }}" class="group flex items-center gap-3 text-slate-400 hover:bg-gray-800/50 hover:text-white px-4 py-2.5 rounded-lg transition text-xs font-semibold">
                    <i data-lucide="users" class="w-4 h-4 text-slate-400 group-hover:text-white transition"></i> Manajemen Pelanggan
                </a>

                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mt-6 mb-3 pl-2">Keamanan & Sistem</p>
                <a href="{{ route('admin.audit_log') }}" class="flex items-center gap-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-4 py-2.5 rounded-lg font-black transition-all duration-200 text-xs shadow-md shadow-blue-500/10 border border-blue-400/20">
                    <i data-lucide="shield-check" class="w-4 h-4"></i> Audit Log Sistem
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
                        <i data-lucide="shield-check" class="w-4 h-4 text-cyan-400 hidden sm:inline"></i> Audit Log: Keamanan & Aktivitas
                    </h2>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5 hidden sm:block">Pemantauan riwayat login/logout, percobaan akses ilegal, dan perubahan harga/stok produk secara akurat.</p>
                </div>
            </div>
        </header>

        <div class="flex-1 p-3 sm:p-8 overflow-y-auto custom-table-scroll space-y-3.5 sm:space-y-6">
            
            <!-- FORM PENCARIAN & SORTING KATEGORI AKSI -->
            <div class="bg-[#111827] border border-gray-800 p-3 sm:p-4 rounded-lg flex flex-col md:flex-row items-center justify-between gap-2.5 sm:gap-4">
                <div class="flex items-center gap-1.5 sm:gap-2 w-full md:w-auto overflow-x-auto pb-1 md:pb-0">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest mr-0.5 shrink-0">Filter:</span>
                    <a href="{{ route('admin.audit_log') }}" 
                       class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-bold transition whitespace-nowrap {{ !($type ?? null) ? 'bg-cyan-600 text-white shadow-md shadow-cyan-500/20' : 'bg-[#1F2937] text-slate-300 hover:bg-gray-800 border border-gray-800' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.audit_log', ['type' => 'login']) }}" 
                       class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-bold transition whitespace-nowrap {{ ($type ?? null) === 'login' ? 'bg-cyan-600 text-white shadow-md shadow-cyan-500/20' : 'bg-[#1F2937] text-slate-300 hover:bg-gray-800 border border-gray-800' }}">
                        Login
                    </a>
                    <a href="{{ route('admin.audit_log', ['type' => 'edit_produk']) }}" 
                       class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-bold transition whitespace-nowrap {{ ($type ?? null) === 'edit_produk' ? 'bg-cyan-600 text-white shadow-md shadow-cyan-500/20' : 'bg-[#1F2937] text-slate-300 hover:bg-gray-800 border border-gray-800' }}">
                        Edit Produk
                    </a>
                </div>

                <form action="{{ route('admin.audit_log') }}" method="GET" class="flex items-center gap-1.5 w-full md:w-80">
                    @if($type ?? null) <input type="hidden" name="type" value="{{ $type }}"> @endif
                    <div class="relative w-full">
                        <i data-lucide="search" class="w-3.5 h-3.5 absolute left-2.5 top-2 text-gray-500"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari aktivitas..." class="w-full bg-[#1F2937] border border-gray-800 text-white pl-8 pr-3 py-1 rounded-md text-xs outline-none focus:border-cyan-500">
                    </div>
                    <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white px-2.5 py-1 rounded-md font-bold text-xs transition shrink-0">Cari</button>
                    @if(($search ?? null) || ($type ?? null))
                        <a href="{{ route('admin.audit_log') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-400 px-2 py-1 rounded-md font-bold text-xs shrink-0">Reset</a>
                    @endif
                </form>
            </div>

            <!-- 📱 MOBILE CARD VIEW (PAS & RINGKAS KHUSUS HP) -->
            <div class="block md:hidden space-y-2">
                @forelse($activityLogs as $log)
                    <div class="bg-[#111827] border border-gray-800 rounded-lg p-2.5 space-y-1.5 shadow-sm">
                        <div class="flex items-center justify-between border-b border-gray-800/80 pb-1">
                            <div>
                                <span class="font-bold text-xs text-white block leading-tight">{{ $log->user_name }}</span>
                                <span class="text-[9px] font-black uppercase {{ $log->role === 'admin' ? 'text-amber-400' : ($log->role === 'kasir' ? 'text-cyan-400' : 'text-gray-500') }}">
                                    {{ $log->role }}
                                </span>
                            </div>
                            <span class="text-[10px] font-mono text-gray-400 bg-[#1F2937] px-1.5 py-0.5 rounded border border-gray-800">
                                {{ $log->created_at->format('d M H:i') }} WIB
                            </span>
                        </div>

                        <div class="space-y-1">
                            <div>
                                @if($log->action === 'LOGIN_SUCCESS')
                                    <span class="inline-block text-[9px] font-black bg-emerald-950/60 text-emerald-400 border border-emerald-800/60 px-1.5 py-0.5 rounded">LOGIN</span>
                                @elseif($log->action === 'LOGIN_FAILED')
                                    <span class="inline-block text-[9px] font-black bg-rose-950/60 text-rose-400 border border-rose-800/60 px-1.5 py-0.5 rounded animate-pulse">GAGAL LOGIN</span>
                                @elseif($log->action === 'LOGOUT')
                                    <span class="inline-block text-[9px] font-black bg-gray-800 text-gray-400 border border-gray-700 px-1.5 py-0.5 rounded">LOGOUT</span>
                                @elseif(str_contains($log->action, 'MENU') || str_contains($log->action, 'STOK'))
                                    <span class="inline-block text-[9px] font-black bg-amber-950/60 text-amber-400 border border-amber-800/60 px-1.5 py-0.5 rounded">EDIT PRODUK</span>
                                @else
                                    <span class="inline-block text-[9px] font-black bg-blue-950/60 text-blue-400 border border-blue-800/60 px-1.5 py-0.5 rounded">{{ $log->action }}</span>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-300 font-medium leading-snug">
                                {{ $log->description }}
                            </p>
                        </div>

                        <div class="pt-1 border-t border-gray-800/80 flex items-center justify-between text-[10px] font-mono text-gray-500">
                            <span>IP:</span>
                            <span class="text-slate-400">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-[#111827] border border-gray-800 rounded-lg p-4 text-center text-gray-500 text-xs italic">
                        Belum ada rekaman aktivitas sistem.
                    </div>
                @endforelse

                <div class="mt-2">
                    {{ $activityLogs->links() }}
                </div>
            </div>

            <!-- 💻 DESKTOP TABEL (ASLI SEPERTI SEMULA) -->
            <div class="hidden md:block bg-[#111827] border border-blue-900/40 rounded-lg p-6 shadow-xl relative overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-950/20 border-b border-gray-800 text-gray-500 font-black text-[10px] uppercase tracking-wider">
                                <th class="py-3 px-4 w-40">Waktu Kejadian</th>
                                <th class="py-3 px-4 w-36">Pengguna</th>
                                <th class="py-3 px-4 w-32">Tipe Aksi</th>
                                <th class="py-3 px-4">Deskripsi Aktivitas</th>
                                <th class="py-3 px-4 text-center w-32">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-xs text-slate-300">
                            @forelse($activityLogs as $log)
                                <tr class="hover:bg-gray-800/30 transition">
                                    <td class="py-3.5 px-4 text-slate-400 font-mono text-[11px]">
                                        {{ $log->created_at->format('d M Y, H:i:s') }} WIB
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-white">
                                        {{ $log->user_name }}
                                        <span class="block text-[9px] font-extrabold uppercase {{ $log->role === 'admin' ? 'text-amber-400' : ($log->role === 'kasir' ? 'text-cyan-400' : 'text-gray-500') }}">
                                            {{ $log->role }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if($log->action === 'LOGIN_SUCCESS')
                                            <span class="inline-block text-[9px] font-black bg-emerald-950/60 text-emerald-400 border border-emerald-800/60 px-2 py-0.5 rounded">LOGIN</span>
                                        @elseif($log->action === 'LOGIN_FAILED')
                                            <span class="inline-block text-[9px] font-black bg-rose-950/60 text-rose-400 border border-rose-800/60 px-2 py-0.5 rounded animate-pulse">GAGAL LOGIN</span>
                                        @elseif($log->action === 'LOGOUT')
                                            <span class="inline-block text-[9px] font-black bg-gray-800 text-gray-400 border border-gray-700 px-2 py-0.5 rounded">LOGOUT</span>
                                        @elseif(str_contains($log->action, 'MENU') || str_contains($log->action, 'STOK'))
                                            <span class="inline-block text-[9px] font-black bg-amber-950/60 text-amber-400 border border-amber-800/60 px-2 py-0.5 rounded">EDIT PRODUK</span>
                                        @else
                                            <span class="inline-block text-[9px] font-black bg-blue-950/60 text-blue-400 border border-blue-800/60 px-2 py-0.5 rounded">{{ $log->action }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-300 font-medium text-[11px]">
                                        {{ $log->description }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-mono text-[10px] text-gray-500">
                                        {{ $log->ip_address ?? '127.0.0.1' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500 font-medium italic text-[11px]">
                                        Belum ada rekaman aktivitas sistem yang sesuai dengan pencarian Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $activityLogs->links() }}
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