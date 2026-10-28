<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'status')) {
            $table->string('status')->default('completed')->after('total_price');
        }
        if (!Schema::hasColumn('orders', 'alasan_batal')) {
            $table->text('alasan_batal')->nullable()->after('status');
        }
    });
}

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status', 'alasan_batal']);
        });
    }
};