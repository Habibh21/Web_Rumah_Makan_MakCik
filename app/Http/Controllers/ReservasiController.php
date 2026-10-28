<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    // Menampilkan Halaman Khusus Reservasi & Tata Cara WA
    public function index()
    {
        return view('pelanggan.booking');
    }

    // Proses Simpan Database & Redirect ke WhatsApp
    public function store(Request $request)
    {
        // Set Waktu Realtime WIB
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->format('Y-m-d');
        $currentTime = $now->format('H:i');

        // 1. Validasi Backend (Tanggal Minimal Hari Ini)
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required',
            'meja' => 'required',
            'tanggal' => 'required|date|after_or_equal:' . $today,
            'jam' => 'required',
            'jumlah_orang' => 'required|numeric|min:1',
        ], [
            'tanggal.after_or_equal' => 'Maaf, Anda tidak dapat melakukan reservasi pada tanggal yang sudah lewat!',
        ]);

        $jamInput = $request->input('jam');
        $tanggalInput = $request->input('tanggal');

        // 2. Validasi Jam Operasional Restoran (09:00 - 22:00 WIB)
        if ($jamInput < '09:00' || $jamInput > '22:00') {
            return redirect()->back()->withErrors([
                'jam' => 'Maaf, resto belum buka / sudah tutup! Jam operasional reservasi adalah pukul 09:00 - 22:00 WIB.'
            ])->withInput();
        }

        // 3. 🛑 VALIDASI WAKTU LAMPAU: Cegah booking jam yang sudah lewat untuk HARI INI
        if ($tanggalInput === $today && $jamInput < $currentTime) {
            return redirect()->back()->withErrors([
                'jam' => "Aksi Ditolak! Saat ini sudah pukul {$currentTime} WIB. Anda tidak dapat melakukan reservasi di jam yang sudah berlalu ({$jamInput} WIB)."
            ])->withInput();
        }

        // Tangkap Input Formulir
        $nama = $request->input('nama');
        $noTelp = $request->input('no_telp');
        $meja = $request->input('meja');
        $tanggal = $tanggalInput;
        $jam = $jamInput;
        $jumlahOrang = $request->input('jumlah_orang');

        // Simpan Fleksibel ke Database
        $columns = Schema::getColumnListing('reservasis');
        $reservasi = new Reservasi();

        $reservasi->nama = $nama;
        $reservasi->tanggal = $tanggal;

        foreach (['no_telp', 'no_hp', 'telepon', 'hp', 'no_whatsapp', 'whatsapp'] as $col) {
            if (in_array($col, $columns)) { $reservasi->$col = $noTelp; }
        }

        foreach (['jam', 'waktu', 'jam_booking', 'time'] as $col) {
            if (in_array($col, $columns)) { $reservasi->$col = $jam; }
        }

        foreach (['meja', 'nomor_meja', 'meja_id', 'no_meja'] as $col) {
            if (in_array($col, $columns)) { $reservasi->$col = $meja; }
        }

        foreach (['jumlah_orang', 'jumlah_pax', 'jumlah', 'pax'] as $col) {
            if (in_array($col, $columns)) { $reservasi->$col = $jumlahOrang; }
        }

        $reservasi->save();

        // Alihkan Otomatis ke WhatsApp Kasir Resto
        $noWaResto = "6285365439273"; // Nomor WA Resto Aktif

        $pesanWA = "Halo Kasir RM Mak Cik, saya *{$nama}* ingin konfirmasi booking meja via website:\n\n"
                 . "🪑 *Pilihan Meja:* {$meja}\n"
                 . "📅 *Tanggal Kedatangan:* {$tanggal}\n"
                 . "⏰ *Jam Kedatangan:* {$jam} WIB\n"
                 . "👥 *Jumlah Rombongan:* {$jumlahOrang} Orang\n"
                 . "📱 *No. WhatsApp Saya:* {$noTelp}\n\n"
                 . "Mohon konfirmasi ketersediaannya Kak. Terima kasih!";

        $linkWA = "https://wa.me/" . $noWaResto . "?text=" . urlencode($pesanWA);

        return redirect()->away($linkWA);
    }
}