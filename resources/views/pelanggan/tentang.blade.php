@extends('layouts.app')

@section('content')
<div class="px-10 py-20">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-bold">TENTANG <span class="text-orangeMakCik">KAMI</span></h2>
        <p class="text-gray-400 mt-3 max-w-2xl mx-auto">Kami berdedikasi untuk menghidangkan masakan rumahan terbaik dengan resep warisan keluarga yang diolah sepenuh hati.</p>
    </div>

    <div class="grid grid-cols-3 gap-8">
        <div class="bg-cardBg p-8 rounded-2xl border border-gray-800 hover:border-orangeMakCik transition duration-300">
            <div class="bg-orangeMakCik w-12 h-12 rounded-full flex items-center justify-center text-2xl mb-6 shadow-[0_0_15px_rgba(255,102,0,0.5)]">
                🍴
            </div>
            <h3 class="text-xl font-bold mb-3">Masakan Rumahan</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Rasa autentik masakan rumahan yang lezat dengan resep turun-temurun yang khas dan penuh cinta.</p>
        </div>

        <div class="bg-cardBg p-8 rounded-2xl border border-gray-800 hover:border-orangeMakCik transition duration-300">
            <div class="bg-orangeMakCik w-12 h-12 rounded-full flex items-center justify-center text-2xl mb-6 shadow-[0_0_15px_rgba(255,102,0,0.5)]">
                ❤️
            </div>
            <h3 class="text-xl font-bold mb-3">Bahan Segar</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Menggunakan bahan-bahan segar pilihan setiap hari untuk menjaga kualitas dan kelezatan makanan.</p>
        </div>

        <div class="bg-cardBg p-8 rounded-2xl border border-gray-800 hover:border-orangeMakCik transition duration-300">
            <div class="bg-orangeMakCik w-12 h-12 rounded-full flex items-center justify-center text-2xl mb-6 shadow-[0_0_15px_rgba(255,102,0,0.5)]">
                💲
            </div>
            <h3 class="text-xl font-bold mb-3">Harga Bersahabat</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Harga yang terjangkau untuk semua kalangan tanpa mengurangi kualitas dan porsi yang memuaskan.</p>
        </div>
    </div>
</div>
@endsection