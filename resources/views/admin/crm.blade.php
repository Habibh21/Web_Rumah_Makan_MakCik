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
                <a href="{{ route('admin.crm') }}" class="flex items-center gap-3 bg-gradient-to-r from-orange-500 to-amber-600 text-white px-4 py-2.5 rounded-lg font-black transition-all duration-200 text-xs shadow-md shadow-orange-500/10 border border-orange-400/20">
                    <i data-lucide="users" class="w-4 h-4"></i> Manajemen Pelanggan
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
                    <h2 class="text-sm sm:text-lg font-black text-white tracking-tight">Sistem E-CRM Pelanggan</h2>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5 hidden sm:block">Analisis pertumbuhan omzet transaksi member dan integrasi WhatsApp Blast promo.</p>
                </div>
            </div>
        </header>

        <div class="flex-1 p-3 sm:p-8 overflow-y-auto custom-table-scroll space-y-4 sm:space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-5 shrink-0">
                <div class="bg-[#111827] border border-gray-800/60 p-3.5 sm:p-5 rounded-lg border-l-4 border-l-zinc-500 flex flex-col justify-between">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total Member Terdaftar</span>
                    <p class="text-lg sm:text-xl font-black text-white tracking-tight mt-0.5 sm:mt-1">{{ $totalMember ?? 0 }} <span class="text-xs font-bold text-gray-500">User</span></p>
                </div>
                <div class="bg-[#111827] border border-gray-800/60 p-3.5 sm:p-5 rounded-lg border-l-4 border-l-purple-500 flex flex-col justify-between">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Elite Member (Platinum)</span>
                    <p class="text-lg sm:text-xl font-black text-white tracking-tight mt-0.5 sm:mt-1">{{ $platinumCount ?? 0 }} <span class="text-xs font-bold text-gray-500">Jiwa</span></p>
                </div>
                <div class="bg-[#111827] border border-gray-800/60 p-3.5 sm:p-5 rounded-lg border-l-4 border-l-orange-500 flex flex-col justify-between">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Growth Member (Gold)</span>
                    <p class="text-lg sm:text-xl font-black text-white tracking-tight mt-0.5 sm:mt-1">{{ $goldCount ?? 0 }} <span class="text-xs font-bold text-gray-500">Jiwa</span></p>
                </div>
            </div>

            <div class="bg-[#111827] border border-gray-800 rounded-lg p-3.5 sm:p-6 shadow-xl relative overflow-hidden space-y-2">
                
                <!-- 📱 MOBILE CUSTOMER CARDS (RINGKAS & KHUSUS HP) -->
                <div class="block md:hidden space-y-2">
                    @forelse($customers as $customer)
                        @php
                            $noTelp = $customer->no_telp ?? '';
                            $namaUser = $customer->nama ?? 'Pelanggan Setia';
                            $tier = $customer->tier ?? 'Silver';
                            $pesanWA = "Halo Kak " . $namaUser . ", terima kasih telah berkunjung ke Mak Cik Resto! Poin reward Anda: " . ($customer->poin ?? 0) . " Pts (" . $tier . "). Pantau terus promo kami!";
                            $noTelpBersih = preg_replace('/[^0-9]/', '', $noTelp);
                            if (substr($noTelpBersih, 0, 1) === '0') { $noTelpBersih = '62' . substr($noTelpBersih, 1); }
                            $linkWhatsApp = "https://wa.me/" . $noTelpBersih . "?text=" . urlencode($pesanWA);
                        @endphp
                        <div class="bg-[#1F2937]/70 border border-gray-800 p-2.5 rounded-lg space-y-1.5">
                            <div class="flex items-center justify-between border-b border-gray-800/80 pb-1">
                                <div>
                                    <h4 class="text-xs font-bold text-white capitalize leading-tight">{{ $namaUser }}</h4>
                                    <span class="text-[10px] text-gray-400 font-mono">{{ $noTelp ?: '-' }}</span>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded uppercase {{ $tier === 'Platinum' ? 'bg-purple-950 text-purple-400 border border-purple-900' : ($tier === 'Gold' ? 'bg-amber-950 text-amber-400 border border-amber-900' : 'bg-zinc-800 text-zinc-400 border border-gray-700') }}">
                                    {{ $tier }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-400 text-[11px]">Total TRX: <strong class="text-white font-mono">Rp {{ number_format($customer->total_transaksi ?? 0, 0, ',', '.') }}</strong></span>
                                <span class="bg-orange-950/60 text-orange-400 font-black px-2 py-0.5 rounded text-[10px] font-mono border border-orange-900/60">{{ $customer->poin ?? 0 }} Pts</span>
                            </div>

                            @if($noTelp && $noTelp !== '-')
                                <a href="{{ $linkWhatsApp }}" target="_blank" class="w-full bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-black py-1.5 rounded-md flex items-center justify-center gap-1 mt-1">
                                    <i data-lucide="megaphone" class="w-3 h-3"></i> Kirim Promo WA Blast
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 italic text-xs">Belum ada member terdaftar.</div>
                    @endforelse
                </div>

                <!-- 💻 DESKTOP CUSTOMER TABLE (ASLI SEPERTI SEMULA) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1F2937]/50 border-b border-gray-800 text-gray-500 font-black text-[10px] uppercase tracking-wider">
                                <th class="py-4 px-5">Nama Pelanggan</th>
                                <th class="py-4 px-5">Nomor WhatsApp</th>
                                <th class="py-4 px-5 text-center">Akumulasi Transaksi</th>
                                <th class="py-4 px-5 text-center">Poin Reward</th>
                                <th class="py-4 px-5 text-center">Peringkat Tier</th>
                                <th class="py-4 px-5 text-center w-48">WhatsApp Blast</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-xs text-slate-300">
                            @forelse($customers as $customer)
                                @php
                                    $noTelp = $customer->no_telp ?? '';
                                    $namaUser = $customer->nama ?? 'Pelanggan Setia';
                                    $tier = $customer->tier ?? 'Silver';
                                    $pesanWA = "Halo Kak " . $namaUser . ", terima kasih banyak telah berkunjung ke Mak Cik Resto! Poin reward Anda saat ini terkumpul sebanyak: " . ($customer->poin ?? 0) . " Poin dengan peringkat member " . $tier . ". Pantau terus info promo pas dari kami ya Kak!";
                                    $noTelpBersih = preg_replace('/[^0-9]/', '', $noTelp);
                                    if (substr($noTelpBersih, 0, 1) === '0') { $noTelpBersih = '62' . substr($noTelpBersih, 1); }
                                    $linkWhatsApp = "https://wa.me/" . $noTelpBersih . "?text=" . urlencode($pesanWA);
                                @endphp
                                <tr class="hover:bg-gray-800/30 transition duration-150">
                                    <td class="py-4 px-5 text-white font-extrabold capitalize text-sm">{{ $namaUser }}</td>
                                    <td class="py-4 px-5 text-slate-400 font-mono font-medium">{{ $noTelp ?: '-' }}</td>
                                    <td class="py-4 px-5 text-center font-extrabold text-slate-300 font-mono">Rp {{ number_format($customer->total_transaksi ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-4 px-5 text-center"><span class="bg-orange-950/40 text-orange-400 font-black px-2.5 py-1 rounded border border-orange-900/50 font-mono">{{ $customer->poin ?? 0 }} Pts</span></td>
                                    <td class="py-4 px-5 text-center">
                                        @if($tier === 'Platinum') <span class="bg-purple-950/50 text-purple-400 font-black px-2.5 py-0.5 rounded border border-purple-900/50 text-[10px]">Platinum</span>
                                        @elseif($tier === 'Gold') <span class="bg-amber-950/50 text-amber-400 font-black px-2.5 py-0.5 rounded border border-amber-900/50 text-[10px]">Gold</span>
                                        @else <span class="bg-zinc-800/60 text-zinc-400 font-bold px-2.5 py-0.5 rounded border border-gray-700 text-[10px]">Silver</span> @endif
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        @if($noTelp && $noTelp !== '-')
                                            <a href="{{ $linkWhatsApp }}" target="_blank" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 active:scale-95 text-white text-[10px] font-black py-1.5 px-3 rounded-lg transition-all duration-150 shadow-md shadow-orange-500/20 gap-1">
                                                <i data-lucide="megaphone" class="w-3 h-3"></i> Kirim Promo Blast
                                            </a>
                                        @else
                                            <span class="text-gray-500 italic text-[11px] font-medium">Nomor Kosong</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-500 font-medium italic bg-[#151C2C]/50 rounded-lg">
                                        Belum ada data member terekam.
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
</script>

@endsection