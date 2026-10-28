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
    Schema::table('orders', function (Blueprint $table) {
        // Menambahkan kolom baru dengan aman jika belum ada
        if (!Schema::hasColumn('orders', 'customer_name')) {
            $table->string('customer_name')->nullable()->after('status');
        }
        if (!Schema::hasColumn('orders', 'customer_phone')) {
            $table->string('customer_phone')->nullable()->after('customer_name');
        }
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['customer_name', 'customer_phone']);
    });
}
};
