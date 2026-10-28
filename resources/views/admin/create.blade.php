@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0B0F19] text-white px-8 py-10 font-sans flex justify-center items-center">
    
    <div class="max-w-xl w-full bg-[#111827] border border-gray-800 p-8 rounded-2xl shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <div>
                <h1 class="text-xl font-black uppercase tracking-tight text-white">
                    Tambah <span class="text-orangeMakCik">Menu Baru</span>
                </h1>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Formulir pendaftaran hidangan masakan atau minuman baru restoran.</p>
            </div>
            <a href="{{ route('admin.menu_list') }}" class="bg-[#1F2937] hover:bg-gray-800 text-gray-300 border border-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition">Kembali</a>
        </div>

        <form action="{{ route('admin.menu_store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1.5 tracking-wider">Kategori Menu</label>
                <select required name="kategori" class="w-full bg-[#1F2937] text-white rounded-xl p-3 border border-gray-800 text-xs font-bold focus:outline-none focus:border-orangeMakCik cursor-pointer">
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Snack">Snack</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1.5 tracking-wider">Nama Menu Hidangan</label>
                <input type="text" required name="nama" class="w-full bg-[#1F2937] text-white border border-gray-800 rounded-xl p-3 text-xs focus:outline-none focus:border-orangeMakCik font-medium" placeholder="Contoh: Nasi Goreng Spesial">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1.5 tracking-wider">Unggah Foto Hidangan</label>
                <input type="file" name="gambar" class="w-full bg-[#1F2937] text-gray-400 border border-gray-800 rounded-xl p-2 text-xs focus:outline-none focus:border-orangeMakCik file:bg-gray-800 file:text-white file:border-0 file:px-3 file:py-1 file:rounded-lg file:text-xs file:font-bold file:mr-3 file:cursor-pointer">
                <span class="text-[9px] text-gray-500 block mt-1">Format gambar valid: JPG, PNG, JPEG. Maksimum file size: 2MB.</span>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1.5 tracking-wider">Harga Nominal Satuan (Rp)</label>
                <input type="number" required name="harga" class="w-full bg-[#1F2937] text-white border border-gray-800 rounded-xl p-3 text-xs focus:outline-none focus:border-orangeMakCik font-mono font-bold" placeholder="Contoh: 25000">
            </div>

            <div class="pt-4 border-t border-gray-800/80 grid grid-cols-2 gap-3">
                <a href="{{ route('admin.menu_list') }}" class="text-center bg-[#1F2937] hover:bg-gray-800 border border-gray-800 text-gray-400 text-xs font-bold py-3 rounded-xl transition">Batal</a>
                <button type="submit" class="bg-orangeMakCik hover:bg-orange-600 text-white text-xs font-black uppercase tracking-wider py-3 rounded-xl transition shadow-md">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>
@endsection