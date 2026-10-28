<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            
            // Tambahkan 6 baris ini untuk data pemesanan:
            $table->string('nama');
            $table->string('no_hp');
            $table->date('tanggal');
            $table->time('waktu');
            $table->integer('jumlah_orang');
            $table->text('catatan')->nullable(); // nullable() berarti boleh dikosongkan
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
