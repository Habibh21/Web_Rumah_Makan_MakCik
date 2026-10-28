@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-[#0B0F19] text-slate-300 font-sans overflow-hidden antialiased">

    <!-- SIDEBAR NAV (OTOMATIS LOGO SAMA DI SEMUA HALAMAN) -->
    @include('layouts.sidebar')

    <main class="flex-1 flex flex-col overflow-hidden bg-[#0B0F19]">
        <header class="h-20 bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 px-8 flex items-center justify-between shadow-sm z-10 shrink-0">
            <div>
                <h2 class="text-lg font-black text-white tracking-tight">Ketersediaan Unit Meja Fisik</h2>
                <p class="text-[11px] text-gray-500 font-medium mt-0.5">Pantau durasi makan pelanggan dine-in secara real-time dan kendalikan daftar tunggu FIFO.</p>
            </div>
            
            @if(session('success'))
                <div class="bg-emerald-500 text-white px-4 py-1.5 rounded-lg font-extrabold text-xs shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                    {{ session('success') }}
                </div>
            @endif
        </header>

        <div class="flex-1 p-8 overflow-y-auto space-y-8 custom-table-scrollbar">
            @php 
                $daftarMejaKosong = [];
                for($m = 1; $m <= 10; $m++) {
                    $namaM = "Meja " . $m;
                    if(!in_array($namaM, array_map('trim', $occupiedTables ?? []))) {
                        $daftarMejaKosong[] = $namaM;
                    }
                }
            @endphp

            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[11px] font-black text-gray-500 uppercase tracking-widest">Peta Lantai Dine-In Restoran</h3>
                    <div class="flex items-center gap-3 text-[10px] font-bold">
                        <span class="flex items-center gap-1.5 text-emerald-400"><span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm"></span> {{ count($daftarMejaKosong) }} Kosong</span>
                        <span class="flex items-center gap-1.5 text-rose-400"><span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse shadow-sm"></span> {{ 10 - count($daftarMejaKosong) }} Terisi</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                    @for($i = 1; $i <= 10; $i++)
                        @php 
                            $namaMeja = "Meja " . $i;
                            $orderAktif = $occupiedTablesMap[$namaMeja] ?? null;
                            $apakahTerisi = !is_null($orderAktif);
                            
                            $durasiMakanText = "-";
                            $sisaWaktuText = "-";
                            $isoTimestamp = "";
                            
                            if($apakahTerisi) {
                                $createdAt = \Carbon\Carbon::parse($orderAktif->created_at);
                                $isoTimestamp = $createdAt->toIso8601String();
                                $durasiTotalDetik = $createdAt->diffInSeconds(now());
                                $menitMakan = floor($durasiTotalDetik / 60);
                                $detikMakan = $durasiTotalDetik % 60;
                                $durasiMakanText = "{$menitMakan} Mnt {$detikMakan} Dtk";

                                $rataRataMakanDetik = 45 * 60;
                                $sisaDetik = max(0, $rataRataMakanDetik - $durasiTotalDetik);
                                $menitSisa = floor($sisaDetik / 60);
                                $detikSisa = $sisaDetik % 60;
                                $sisaWaktuText = "{$menitSisa} Mnt {$detikSisa} Dtk";
                            }
                        @endphp
                        
                        <div class="group relative bg-[#111827] rounded-lg border border-gray-800/80 p-5 flex flex-col justify-between items-center transition-all duration-300 hover:shadow-[0_20px_40px_rgba(0,0,0,0.4)] min-h-[220px] shadow-sm overflow-hidden
                            {{ $apakahTerisi ? 'border-rose-900/50 bg-[#16111E]' : 'hover:border-emerald-500/40' }}">
                            
                            <div class="space-y-3 w-full relative z-10 text-center flex flex-col items-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $apakahTerisi ? 'bg-rose-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                                    <h3 class="text-sm font-black text-white tracking-tight">{{ $namaMeja }}</h3>
                                </div>

                                <span class="inline-block text-[9px] font-black px-2 py-0.5 rounded border
                                    {{ $apakahTerisi ? 'bg-rose-950/40 text-rose-400 border-rose-900/50' : 'bg-emerald-950/40 text-emerald-400 border-emerald-900/50' }}">
                                    {{ $apakahTerisi ? 'Dine-In Active' : 'Available' }}
                                </span>
                                
                                @if($apakahTerisi)
                                    <div class="w-full bg-[#1F2937]/50 border border-gray-800 rounded-lg p-3 mt-3 space-y-1.5 text-[11px] text-left dine-in-timer" data-start-time="{{ $isoTimestamp }}">
                                        <div class="flex justify-between text-slate-400">
                                            <span>Durasi:</span>
                                            <span class="font-extrabold text-white font-mono timer-duration">{{ $durasiMakanText }}</span>
                                        </div>
                                        <div class="border-t border-gray-800 pt-1.5 flex justify-between text-gray-500">
                                            <span>Est. Sisa:</span>
                                            <span class="font-extrabold text-orange-400 font-mono timer-remaining">{{ $sisaWaktuText }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="py-4 flex flex-col items-center justify-center text-gray-500 group-hover:text-emerald-400 transition duration-300">
                                        <i data-lucide="wine" class="w-8 h-8"></i>
                                        <p class="text-[10px] font-medium italic mt-2">Siap Melayani</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="w-full pt-3 mt-4 border-t border-gray-800 relative z-10">
                                @if($apakahTerisi)
                                    <form action="{{ route('kasir.meja.kosongkan', $namaMeja) }}" method="POST" onsubmit="return confirm('Kosongkan {{ $namaMeja }}?')">
                                        @csrf
                                        <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 active:scale-95 text-white text-[11px] font-black py-2 rounded-lg transition-all duration-150">
                                            Kosongkan Meja
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-[#1F2937] border border-gray-800 text-gray-600 text-[11px] font-bold py-2 rounded-lg cursor-not-allowed select-none">
                                        Open Order
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="bg-[#111827] border border-gray-800 rounded-lg p-6 shadow-xl relative overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:justify-between gap-4 mb-6 pb-4 border-b border-gray-800 relative z-10">
                    <div>
                        <h3 class="text-sm font-black text-white tracking-tight">Waiting List</h3>
                        <p class="text-[11px] text-gray-500 font-medium mt-0.5">Daftar tunggu otomatis berurut kronologis. Dahulukan Prioritas Utama.</p>
                    </div>
                    <span class="self-start sm:self-center text-xs bg-orange-950/60 text-orange-400 border border-orange-900/50 px-3 py-1.5 rounded-lg font-black shadow-sm flex items-center gap-1.5">
                        <i data-lucide="alarm-clock" class="w-3.5 h-3.5 text-orange-400 animate-spin"></i> Total Tunggu: {{ count($waitingList) }} Pelanggan
                    </span>
                </div>

                <div class="overflow-x-auto relative z-10">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1F2937]/50 border-b border-gray-800 text-gray-500 font-black text-[10px] uppercase tracking-wider">
                                <th class="py-4 px-5 w-28">Status Antrean</th>
                                <th class="py-4 px-5">Nama Pelanggan</th>
                                <th class="py-4 px-5 w-40">Kontak WhatsApp</th>
                                <th class="py-4 px-5 w-44 text-center">Durasi Menunggu</th>
                                <th class="py-4 px-5 text-center w-44">Aksi Pemberitahuan</th>
                                <th class="py-4 px-5 text-center w-60">Alokasikan Meja Kosong</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-xs text-slate-300">
                            @forelse($waitingList as $index => $antrean)
                                @php
                                    $createdAtAntrean = \Carbon\Carbon::parse($antrean->created_at);
                                    $durasiAntreanDetik = $createdAtAntrean->diffInSeconds(now());
                                    $menitAntrean = floor($durasiAntreanDetik / 60);
                                    $detikAntrean = $durasiAntreanDetik % 60;
                                    $waktuTungguText = "{$menitAntrean} Mnt {$detikAntrean} Dtk";
                                    $isPrioritasUtama = ($index === 0);
                                    $noTelp = $antrean->customer_phone ?? $antrean->no_telp ?? '';
                                    $namaPelanggan = $antrean->customer_name ?? 'Pelanggan';
                                    $pesanWA = "Halo Kak " . $namaPelanggan . ", Meja Anda di Mak Cik Resto sudah siap! Silakan langsung menuju ke kasir ya. Terima kasih.";
                                    $noTelpBersih = preg_replace('/[^0-9]/', '', $noTelp);
                                    if (substr($noTelpBersih, 0, 1) === '0') { $noTelpBersih = '62' . substr($noTelpBersih, 1); }
                                    $linkWhatsApp = "https://wa.me/" . $noTelpBersih . "?text=" . urlencode($pesanWA);
                                @endphp
                                <tr class="{{ $isPrioritasUtama ? 'bg-orange-500/5 font-medium' : '' }} hover:bg-gray-800/30 transition duration-150">
                                    <td class="py-4 px-5">
                                        @if($isPrioritasUtama)
                                            <span class="inline-flex items-center gap-1 text-[9px] font-black bg-orange-500 text-white px-2.5 py-1 rounded uppercase tracking-wider animate-pulse border border-orange-400/20 shadow-sm">★ Top Queue</span>
                                        @else
                                            <span class="inline-block text-[9px] font-extrabold bg-[#1F2937] text-slate-400 px-2 py-0.5 rounded tracking-wide border border-gray-800">Rank #{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 text-white font-extrabold capitalize text-sm">{{ $namaPelanggan }}</td>
                                    <td class="py-4 px-5 text-slate-400 font-mono font-medium">{{ $noTelp ?: '-' }}</td>
                                    <td class="py-4 px-5 text-center font-extrabold text-orange-400 font-mono waiting-timer text-sm" data-start-time="{{ $createdAtAntrean->toIso8601String() }}">{{ $waktuTungguText }}</td>
                                    <td class="py-4 px-5 text-center">
                                        @if($noTelp && $noTelp !== '-')
                                            <a href="{{ $linkWhatsApp }}" target="_blank" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black py-1.5 px-3 rounded-lg gap-1">
                                                <i data-lucide="message-square-text" class="w-3 h-3"></i> WhatsApp Ready
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic text-[11px]">No WA Kosong</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        @if(count($daftarMejaKosong) > 0)
                                            <form action="{{ route('kasir.meja.pindahkan', $antrean->id) }}" method="POST" class="flex items-center gap-2 justify-center">
                                                @csrf
                                                <select required name="table_number" class="bg-[#1F2937] border border-gray-800 text-white text-xs font-bold rounded-lg px-2 py-1.5 outline-none cursor-pointer shadow-sm focus:border-orange-500">
                                                    <option value="" disabled selected>Pilih Unit Meja</option>
                                                    @foreach($daftarMejaKosong as $mejaK)
                                                        <option value="{{ $mejaK }}">{{ $mejaK }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-black py-1.5 px-3 rounded-lg text-[11px]">Dudukkan</button>
                                            </form>
                                        @else
                                            <span class="inline-block text-[10px] font-black bg-rose-950/40 border border-rose-900/50 text-rose-400 px-2 py-0.5 rounded uppercase tracking-wider">Full House</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-500 font-medium italic bg-[#151C2C]/50 rounded-lg flex flex-col items-center justify-center">
                                        <i data-lucide="smile" class="w-8 h-8 text-gray-600 mb-2"></i> Tidak ada antrean dalam daftar tunggu.
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
    function updateRealtimeTimers() {
        document.querySelectorAll('.dine-in-timer').forEach(el => {
            const startTimeStr = el.getAttribute('data-start-time');
            if (!startTimeStr) return;
            const startTime = new Date(startTimeStr);
            const now = new Date();
            const diffSeconds = Math.floor((now - startTime) / 1000);
            const minutes = Math.floor(diffSeconds / 60);
            const seconds = diffSeconds % 60;
            el.querySelector('.timer-duration').innerText = `${minutes} Mnt ${seconds} Dtk`;
            const standardMakanSeconds = 45 * 60;
            const remainingSeconds = Math.max(0, standardMakanSeconds - diffSeconds);
            const remMinutes = Math.floor(remainingSeconds / 60);
            const remSeconds = remainingSeconds % 60;
            el.querySelector('.timer-remaining').innerText = `${remMinutes} Mnt ${remSeconds} Dtk`;
        });
        document.querySelectorAll('.waiting-timer').forEach(el => {
            const startTimeStr = el.getAttribute('data-start-time');
            if (!startTimeStr) return;
            const startTime = new Date(startTimeStr);
            const now = new Date();
            const diffSeconds = Math.floor((now - startTime) / 1000);
            const minutes = Math.floor(diffSeconds / 60);
            const seconds = diffSeconds % 60;
            el.innerText = `${minutes} Mnt ${seconds} Dtk`;
        });
    }
    setInterval(updateRealtimeTimers, 1000);
    window.addEventListener('DOMContentLoaded', updateRealtimeTimers);
</script>
@endsection