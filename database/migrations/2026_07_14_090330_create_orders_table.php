<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('table_number')->nullable(); // Nomor meja (bisa dikosongkan jika takeaway)
        $table->integer('total_price');
        $table->enum('order_type', ['online', 'offline'])->default('offline'); // Membedakan PoS vs Web Online
        $table->enum('status', ['pending', 'processing', 'completed'])->default('completed');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
