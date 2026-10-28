@extends('layouts.app')

@section('content')
<div class="px-10 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold">GALERI <span class="text-orangeMakCik">KAMI</span></h2>
        <p class="text-gray-400 mt-2">Beberapa hidangan spesial kami</p>
    </div>

    <div class="grid grid-cols-4 gap-6">
        <img src="{{ asset('images/ayam-bakar.jpg') }}" alt="Galeri 1" class="w-full h-64 object-cover rounded-2xl hover:scale-105 transition duration-300 cursor-pointer border border-gray-800">
        <img src="{{ asset('images/ayam-bakar.jpg') }}" alt="Galeri 2" class="w-full h-64 object-cover rounded-2xl hover:scale-105 transition duration-300 cursor-pointer border border-gray-800">
        <img src="{{ asset('images/ayam-bakar.jpg') }}" alt="Galeri 3" class="w-full h-64 object-cover rounded-2xl hover:scale-105 transition duration-300 cursor-pointer border border-gray-800">
        <img src="{{ asset('images/ayam-bakar.jpg') }}" alt="Galeri 4" class="w-full h-64 object-cover rounded-2xl hover:scale-105 transition duration-300 cursor-pointer border border-gray-800">
        
        <img src="{{ asset('images/ayam-bakar.jpg') }}" alt="Galeri 5" class="w-full h-64 object-cover rounded-2xl hover:scale-105 transition duration-300 cursor-pointer border border-gray-800">
        <img src="{{ asset('images/ayam-bakar.jpg') }}" alt="Galeri 6" class="w-full h-64 object-cover rounded-2xl hover:scale-105 transition duration-300 cursor-pointer border border-gray-800">
    </div>
</div>
@endsection