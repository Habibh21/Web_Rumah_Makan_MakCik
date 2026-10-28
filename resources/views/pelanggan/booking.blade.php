@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0F0F0F] text-white py-6 sm:py-12 px-3.5 sm:px-8 relative overflow-hidden flex flex-col justify-between">
    <!-- Glow Effect Background -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 h-72 sm:h-96 bg-orange-600/10 blur-[120px] sm:blur-[140px] rounded-full pointer-events-none"></div>

    <div class="max-w-4xl mx-auto space-y-6 sm:space-y-10 relative z-10 w-full mb-10 sm:mb-16">
        
        <!-- HEADER HALAMAN + LOGO UTAMA RESTORAN -->
        <div class="text-center space-y-2 sm:space-y-3">
            <div class="flex justify-center mb-1 sm:mb-2">
                <img src="{{ asset('images/logo.png') }}" 
                     onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';" 
                     class="w-14 h-14 sm:w-24 sm:h-24 object-contain drop-shadow-2xl" 
                     alt="Logo Mak Cik Resto">
            </div>

            <div>
                <span class="text-[9px] sm:text-xs font-black tracking-widest text-orangeMakCik bg-orange-950/40 border border-orange-900/50 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full uppercase select-none">
                    Online Table Booking
                </span>
            </div>

            <h1 class="text-xl sm:text-4xl font-black uppercase tracking-tight">
                Reservasi Meja Makan <span class="text-orangeMakCik">RM Mak Cik</span>
            </h1>
            <p class="text-gray-400 text-[11px] sm:text-sm max-w-xl mx-auto font-medium px-2">
                Nikmati kenyamanan santap bersama keluarga tanpa perlu mengantre. Silakan pelajari tata cara booking di bawah ini sebelum mengisi formulir.
            </p>
        </div>

        <!-- PANEL TATA CARA RESERVASI VIA WHATSAPP (MOBILE 2x2 GRID RINGKAS, DESKTOP 4 KOLOM) -->
        <div class="bg-[#141414] border border-orange-500/30 rounded-xl p-3.5 sm:p-8 shadow-2xl space-y-3.5 sm:space-y-6">
            <div class="flex items-center gap-2.5 border-b border-gray-800 pb-3 sm:pb-4">
                <div class="bg-orange-600/20 text-orange-400 p-1.5 sm:p-2 rounded-lg border border-orange-500/30 shrink-0">
                    <i data-lucide="help-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-base font-black uppercase tracking-wider text-white">Tata Cara Reservasi via WhatsApp</h3>
                    <p class="text-[10px] sm:text-[11px] text-gray-400 font-medium">Ikuti 4 langkah praktis ini untuk mengunci meja pilihan Anda.</p>
                </div>
            </div>

            <!-- GRID 2x2 DI MOBILE, 4 KOLOM DI DESKTOP -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4">
                <div class="bg-[#1A1A1A] border border-gray-800 p-2.5 sm:p-4 rounded-lg space-y-1 sm:space-y-2 relative">
                    <span class="text-orangeMakCik font-black text-sm sm:text-xl font-mono">01.</span>
                    <h4 class="text-[11px] sm:text-xs font-extrabold text-white">Lengkapi Form</h4>
                    <p class="text-[9px] sm:text-[10px] text-gray-400 leading-tight sm:leading-relaxed font-medium">
                        Isi nama, WA, meja, & jadwal di form bawah.
                    </p>
                </div>

                <div class="bg-[#1A1A1A] border border-gray-800 p-2.5 sm:p-4 rounded-lg space-y-1 sm:space-y-2 relative">
                    <span class="text-orangeMakCik font-black text-sm sm:text-xl font-mono">02.</span>
                    <h4 class="text-[11px] sm:text-xs font-extrabold text-white">Kirim Booking</h4>
                    <p class="text-[9px] sm:text-[10px] text-gray-400 leading-tight sm:leading-relaxed font-medium">
                        Klik simpan. Data reservasi masuk ke sistem kasir.
                    </p>
                </div>

                <div class="bg-[#1A1A1A] border border-gray-800 p-2.5 sm:p-4 rounded-lg space-y-1 sm:space-y-2 relative">
                    <span class="text-orangeMakCik font-black text-sm sm:text-xl font-mono">03.</span>
                    <h4 class="text-[11px] sm:text-xs font-extrabold text-white">Konfirmasi WA</h4>
                    <p class="text-[9px] sm:text-[10px] text-gray-400 leading-tight sm:leading-relaxed font-medium">
                        Kirimkan draf pesan otomatis yang terbuka ke Kasir.
                    </p>
                </div>

                <div class="bg-[#1A1A1A] border border-gray-800 p-2.5 sm:p-4 rounded-lg space-y-1 sm:space-y-2 relative">
                    <span class="text-orangeMakCik font-black text-sm sm:text-xl font-mono">04.</span>
                    <h4 class="text-[11px] sm:text-xs font-extrabold text-white">Tiba & Tunjukkan</h4>
                    <p class="text-[9px] sm:text-[10px] text-gray-400 leading-tight sm:leading-relaxed font-medium">
                        Datang tepat waktu & tunjukkan bukti chat ke kasir.
                    </p>
                </div>
            </div>
        </div>

        <!-- FORMULIR RESERVASI MEJA ONLINE -->
        <div class="bg-cardBg border border-gray-800 p-4 sm:p-10 rounded-xl shadow-2xl space-y-4 sm:space-y-6">
            <div class="border-b border-gray-800 pb-3 sm:pb-4">
                <h3 class="text-sm sm:text-lg font-black uppercase tracking-wider text-white">Formulir Booking Meja</h3>
                <p class="text-[10px] sm:text-[11px] text-gray-500 font-medium mt-0.5">Area Indoor nyaman dengan kapasitas maksimal 4 orang per meja.</p>
            </div>

            <!-- Alert Error Validasi -->
            @if($errors->any())
                <div class="bg-red-950/80 border border-red-500/50 text-red-200 p-3 rounded-lg text-xs font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="booking-form" action="{{ route('reservasi.store') }}" method="POST" class="space-y-3.5 sm:space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1 pl-0.5">Nama Lengkap Pemesan</label>
                    <div class="relative flex items-center">
                        <input type="text" name="nama" required value="{{ old('nama') }}" placeholder="Ketik nama lengkap Anda..." 
                               class="w-full bg-[#111827] border border-gray-800 rounded-lg p-2.5 sm:p-3 pl-9 sm:pl-10 text-xs text-white outline-none focus:border-orange-500 font-medium">
                        <i data-lucide="user" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-orange-400 absolute left-3 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1 pl-0.5">Nomor WhatsApp Aktif</label>
                    <div class="relative flex items-center">
                        <input type="text" name="no_telp" required value="{{ old('no_telp') }}" placeholder="Contoh: 082138255060" 
                               class="w-full bg-[#111827] border border-gray-800 rounded-lg p-2.5 sm:p-3 pl-9 sm:pl-10 text-xs text-white outline-none focus:border-orange-500 font-mono font-bold">
                        <i data-lucide="phone" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-orange-400 absolute left-3 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Pilih Unit Meja Makan -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1 pl-0.5">Pilih Unit Meja Makan</label>
                    <div class="relative flex items-center">
                        <select id="select-meja" name="meja" required class="w-full bg-[#111827] border border-gray-800 rounded-lg p-2.5 sm:p-3 pl-9 sm:pl-10 text-xs text-white outline-none focus:border-orange-500 font-bold">
                            <option value="" disabled selected>-- Pilih Nomor Meja --</option>
                            <option value="Meja 01" data-pax="4">Meja 01 (Indoor - 4 Pax)</option>
                            <option value="Meja 02" data-pax="4">Meja 02 (Indoor - 4 Pax)</option>
                            <option value="Meja 03" data-pax="4">Meja 03 (Indoor - 4 Pax)</option>
                            <option value="Meja 04" data-pax="4">Meja 04 (Indoor - 4 Pax)</option>
                            <option value="Meja 05" data-pax="4">Meja 05 (Indoor - 4 Pax)</option>
                            <option value="Meja 06" data-pax="4">Meja 06 (Indoor - 4 Pax)</option>
                            <option value="Meja 07" data-pax="4">Meja 07 (Indoor - 4 Pax)</option>
                            <option value="Meja 08" data-pax="4">Meja 08 (Indoor - 4 Pax)</option>
                            <option value="Meja 09" data-pax="4">Meja 09 (Indoor - 4 Pax)</option>
                            <option value="Meja 10" data-pax="4">Meja 10 (Indoor - 4 Pax)</option>
                        </select>
                        <i data-lucide="layout-grid" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-orange-400 absolute left-3 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Tanggal & Jam Kedatangan (BERDAMPINGAN DI MOBILE & DESKTOP) -->
                <div class="grid grid-cols-2 gap-2.5 sm:gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1 pl-0.5">Tanggal</label>
                        <div class="relative flex items-center">
                            <input type="date" id="input-tanggal" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}" 
                                   class="w-full bg-[#111827] border border-gray-800 rounded-lg p-2.5 sm:p-3 pl-8 sm:pl-10 text-xs text-white outline-none focus:border-orange-500 font-sans font-bold">
                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-orange-400 absolute left-2.5 sm:left-3 pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1 pl-0.5">Jam (09:00 - 22:00)</label>
                        <div class="relative flex items-center">
                            <input type="time" id="input-jam" name="jam" min="09:00" max="22:00" required value="{{ old('jam') }}" 
                                   class="w-full bg-[#111827] border border-gray-800 rounded-lg p-2.5 sm:p-3 pl-8 sm:pl-10 text-xs text-white outline-none focus:border-orange-500 font-mono font-bold">
                            <i data-lucide="clock-3" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-orange-400 absolute left-2.5 sm:left-3 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <!-- Jumlah Pax -->
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1 pl-0.5">Jumlah Anggota Rombongan (Maks. 4 Pax)</label>
                    <div class="relative flex items-center">
                        <input type="number" id="input-jumlah-orang" name="jumlah_orang" min="1" max="4" required value="{{ old('jumlah_orang') }}" placeholder="Pilih meja..." 
                               class="w-full bg-[#111827] border border-gray-800 rounded-lg p-2.5 sm:p-3 pl-9 sm:pl-10 text-xs text-white outline-none focus:border-orange-500 font-mono font-bold">
                        <i data-lucide="users-2" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-orange-400 absolute left-3 pointer-events-none"></i>
                    </div>
                    <span class="text-[9px] sm:text-[10px] text-gray-500 font-medium mt-1 block pl-0.5">*Disesuaikan jika kurang dari 4 orang.</span>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 active:scale-98 text-white font-black py-3 sm:py-4 px-4 rounded-lg text-xs uppercase tracking-wider transition-all shadow-lg shadow-orange-600/10 flex items-center justify-center gap-2 mt-3 sm:mt-4">
                    <i data-lucide="send" class="w-4 h-4 text-white"></i> Kunci Jadwal & Ke WhatsApp
                </button>
            </form>
        </div>

    </div>

    <!-- FOOTER RAPI 2 KOLOM -->
    <footer id="kontak" class="border-t border-gray-900 bg-[#0A0A0A] pt-10 sm:pt-16 pb-8 px-5 sm:px-10 text-gray-400 w-full max-w-full overflow-hidden relative z-10 -mx-3.5 sm:-mx-8 -mb-6 sm:-mb-12">
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
                    <li class="text-gray-400">📞 +62 812-3456-7890</li>
                    <li class="text-gray-400">🕒 09.00 - 22.00 WIB (Buka Setiap Hari)</li>
                </ul>
            </div>
        </div>
        <div class="text-center text-[10px] font-medium border-t border-gray-900 pt-6 mt-10 text-gray-600 select-none">
            &copy; 2026 Rumah Makan Mak Cik. All Rights Reserved.
        </div>
    </footer>
</div>

<!-- SCRIPT PENGUNCI ELEMEN UI -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bookingForm = document.getElementById('booking-form');
        const inputTanggal = document.getElementById('input-tanggal');
        const inputJam = document.getElementById('input-jam');
        const selectMeja = document.getElementById('select-meja');
        const inputJumlah = document.getElementById('input-jumlah-orang');

        function getTodayString(d) {
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${y}-${m}-${day}`;
        }

        function getTimeString(d) {
            const h = String(d.getHours()).padStart(2, '0');
            const m = String(d.getMinutes()).padStart(2, '0');
            return `${h}:${m}`;
        }

        function updatePickerLimits() {
            if (!inputTanggal) return;

            const now = new Date();
            const todayStr = getTodayString(now);
            const currentTimeStr = getTimeString(now);

            if (currentTimeStr >= "22:00") {
                const tomorrow = new Date(now);
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowStr = getTodayString(tomorrow);

                inputTanggal.min = tomorrowStr;

                if (!inputTanggal.value || inputTanggal.value < tomorrowStr) {
                    inputTanggal.value = tomorrowStr;
                }

                inputJam.min = "09:00";
                inputJam.max = "22:00";
                return;
            }

            inputTanggal.min = todayStr;

            if (inputTanggal.value === todayStr) {
                const minTime = currentTimeStr > "09:00" ? currentTimeStr : "09:00";
                
                inputJam.min = minTime; 
                inputJam.max = "22:00";

                if (inputJam.value && inputJam.value < minTime) {
                    inputJam.value = "";
                }
            } else {
                inputJam.min = "09:00";
                inputJam.max = "22:00";
            }
        }

        updatePickerLimits();

        if (inputTanggal) {
            inputTanggal.addEventListener('change', updatePickerLimits);
        }

        if (inputJam) {
            inputJam.addEventListener('change', function() {
                const now = new Date();
                const todayStr = getTodayString(now);
                const currentTimeStr = getTimeString(now);

                if (inputTanggal.value === todayStr && this.value < currentTimeStr) {
                    alert(`⚠️ Aksi Ditolak! Pilihan jam ${this.value} WIB sudah berlalu.`);
                    this.value = "";
                }
            });
        }

        if (selectMeja && inputJumlah) {
            selectMeja.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const pax = selectedOption.getAttribute('data-pax');
                inputJumlah.value = pax ? pax : '';
            });
        }
    });
</script>
@endsection