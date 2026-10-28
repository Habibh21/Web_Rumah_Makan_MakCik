<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Menggunakan $guarded = [] untuk mengizinkan semua kolom (termasuk kolom baru
     * seperti customer_name, customer_phone, dan alasan_batal) dapat disimpan 
     * secara Mass Assignment dari PosController tanpa terblokir.
     */
    protected $guarded = [];

    /**
     * Relasi: Satu Order memiliki banyak OrderDetail (hasMany)
     * Nama fungsi ini WAJIB 'orderDetails' (camelCase) agar terbaca oleh PosController & AdminController
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    /**
     * Relasi opsional balik ke User/Kasir (jika sistem menggunakan autentikasi user kasir)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}