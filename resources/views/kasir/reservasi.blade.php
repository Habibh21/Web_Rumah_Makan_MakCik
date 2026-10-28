@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-[#0B0F19] text-slate-300 font-sans overflow-hidden antialiased">

    <!-- SIDEBAR NAV (OTOMATIS LOGO SAMA DI SEMUA HALAMAN) -->
    @include('layouts.sidebar')

    <!-- HUB INTI KONTEN LOG RESERVASI SISI KASIR -->
    <main class="flex-1 flex flex-col overflow-hidden bg-[#0B0F19]">
        <header class="h-20 bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 px-8 flex items-center justify-between shadow-md z-10 shrink-0">
            <div>
                <h2 class="text-lg font-black text-white tracking-tight">Log Reservasi Via Whatsapp</h2>
                <p class="text-[11px] text-gray-500 font-medium mt-0.5">Daftar booking konsumen online yang membutuhkan respon cepat via WhatsApp.</p>
            </div>
        </header>

        <div class="flex-1 p-8 overflow-y-auto custom-table-scrollbar">
            @if(session('success'))
                <div class="mb-4 bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 p-3 rounded-lg text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#111827] border border-gray-800 rounded-lg p-6 shadow-xl relative overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1F2937]/50 border-b border-gray-800 text-gray-500 font-black text-[10px] uppercase tracking-wider">
                                <th class="py-4 px-5">Nama Pemesan</th>
                                <th class="py-4 px-5">Nomor HP / WhatsApp</th>
                                <th class="py-4 px-5 text-center">Nomor Meja</th>
                                <th class="py-4 px-5 text-center">Tanggal Kedatangan</th>
                                <th class="py-4 px-5 text-center">Jam Booking</th>
                                <th class="py-4 px-5 text-center">Jumlah Pax</th>
                                <th class="py-4 px-5 text-center w-64">Konfirmasi WhatsApp / Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-xs text-slate-300">
                            @forelse($reservasis as $reservasi)
                                @php
                                    $namaPelanggan = $reservasi->nama ?? 'Pelanggan';
                                    $noTelp = $reservasi->no_telp ?? $reservasi->no_hp ?? $reservasi->telepon ?? $reservasi->hp ?? '';
                                    $mejaPilihan = $reservasi->meja ?? $reservasi->nomor_meja ?? $reservasi->meja_id ?? 'Meja 01';
                                    $tanggalText = $reservasi->tanggal ?? '';
                                    $jamText = $reservasi->jam ?? $reservasi->waktu ?? $reservasi->jam_booking ?? '';
                                    $jumlahOrang = $reservasi->jumlah_orang ?? $reservasi->jumlah_pax ?? $reservasi->jumlah ?? 0;
                                    
                                    $pesanWA = "Halo Kak " . $namaPelanggan . ", kami dari Kasir RM Mak Cik mengonfirmasi booking " . $mejaPilihan . " Anda untuk tanggal " . $tanggalText . " jam " . $jamText . " WIB sebanyak " . $jumlahOrang . " orang. Apakah jadwalnya sudah fiks Kak? Terima kasih.";
                                    
                                    $noTelpBersih = preg_replace('/[^0-9]/', '', $noTelp);
                                    if (substr($noTelpBersih, 0, 1) === '0') { $noTelpBersih = '62' . substr($noTelpBersih, 1); }
                                    $linkWhatsApp = "https://wa.me/" . $noTelpBersih . "?text=" . urlencode($pesanWA);
                                @endphp
                                <tr class="hover:bg-gray-800/30 transition duration-150">
                                    <td class="py-4 px-5 text-white font-extrabold capitalize text-sm">{{ $namaPelanggan }}</td>
                                    <td class="py-4 px-5 text-slate-300 font-mono font-bold">{{ $noTelp ?: '-' }}</td>
                                    <td class="py-4 px-5 text-center">
                                        <span class="bg-orange-950/80 text-orange-400 border border-orange-500/30 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">{{ $mejaPilihan }}</span>
                                    </td>
                                    <td class="py-4 px-5 text-center font-medium text-slate-300 font-sans">{{ $tanggalText }}</td>
                                    <td class="py-4 px-5 text-center font-extrabold text-white font-mono">{{ $jamText ? $jamText . ' WIB' : '-' }}</td>
                                    <td class="py-4 px-5 text-center font-black text-orange-400 font-mono text-sm">{{ $jumlahOrang }} Orang</td>
                                    <td class="py-4 px-5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($noTelp && $noTelp !== '-')
                                                <a href="{{ $linkWhatsApp }}" target="_blank" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black py-1.5 px-3 rounded-lg gap-1.5 transition active:scale-95 shadow-md shadow-emerald-950/40">
                                                    <i data-lucide="message-square" class="w-3.5 h-3.5"></i> Chat WA
                                                </a>
                                            @endif

                                            <form action="{{ route('kasir.reservasi.destroy', $reservasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus reservasi ini?')">
                                                @csrf
                                                <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white border border-red-500/30 font-extrabold text-[10px] py-1.5 px-2.5 rounded-lg transition active:scale-95 flex items-center gap-1">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Batalkan
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-500 font-medium italic bg-[#151C2C]/50 rounded-lg">
                                        Belum ada reservasi masuk.
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
@endsection