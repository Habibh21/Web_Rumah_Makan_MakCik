@extends('layouts.app')

@section('content')
<div class="px-10 py-12">
    
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold">MENU <span class="text-orangeMakCik">KAMI</span></h2>
        <p class="text-gray-400 mt-2">Aneka pilihan makanan dan minuman terbaik untuk Anda</p>
    </div>

    <div class="grid grid-cols-2 gap-10">
        
        <div>
            
            <div class="mb-6">
                <span class="bg-orangeMakCik text-white font-bold px-6 py-2 rounded-full text-sm">🍴 MAKANAN</span>
            </div>
            <div class="flex flex-col gap-4 mb-10">
                @foreach($makanan as $item)
                <div class="bg-cardBg px-6 py-4 rounded-xl flex justify-between items-center hover:border hover:border-orangeMakCik transition cursor-pointer">
                    <div class="flex items-center gap-4">
                        @if($item->gambar)
                            <img src="{{ asset('menu_images/' . $item->gambar) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-700">
                        @else
                            <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center text-[10px] text-gray-500">No Image</div>
                        @endif
                        <span class="font-medium text-lg">{{ $item->nama }}</span>
                    </div>
                    <span class="text-orangeMakCik font-bold text-lg">{{ $item->harga }}</span>
                </div>
                @endforeach
            </div>

            <div class="mb-6">
                <span class="bg-blue-600 text-white font-bold px-6 py-2 rounded-full text-sm">🍹 MINUMAN</span>
            </div>
            <div class="flex flex-col gap-4">
                @foreach($minuman as $item)
                <div class="bg-cardBg px-6 py-4 rounded-xl flex justify-between items-center hover:border hover:border-blue-500 transition cursor-pointer">
                    <div class="flex items-center gap-4">
                        @if($item->gambar)
                            <img src="{{ asset('menu_images/' . $item->gambar) }}"class="w-12 h-12 rounded-lg object-cover border border-gray-700">
                        @else
                            <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center text-[10px] text-gray-500">No Image</div>
                        @endif
                        <span class="font-medium text-lg">{{ $item->nama }}</span>
                    </div>
                    <span class="text-orangeMakCik font-bold text-lg">{{ $item->harga }}</span>
                </div>
                @endforeach
            </div>

        </div>

        <div class="grid grid-cols-3 gap-6 items-start auto-rows-max">
            @foreach($makanan as $item)
                @if($item->gambar)
                    <img src="{{ asset('menu_images/' . $item->gambar) }}" alt="{{ $item->nama }}" title="{{ $item->nama }}" class="w-32 h-32 rounded-xl object-cover mx-auto transition duration-300 hover:scale-105 shadow-lg">
                @endif
            @endforeach
            
            @foreach($minuman as $item)
                @if($item->gambar)
                    <img src="{{ asset('menu_images/' . $item->gambar) }}" alt="{{ $item->nama }}" title="{{ $item->nama }}" class="w-32 h-32 rounded-xl object-cover mx-auto transition duration-300 hover:scale-105 shadow-lg">
                @endif
            @endforeach
        </div>

    </div>
</div>
@endsection