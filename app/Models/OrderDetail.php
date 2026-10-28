<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 
        'menu_id', 
        'quantity', 
        'price',
        'note',
    ];

    /**
     * Relasi: Setiap detail pesanan tersambung ke satu Menu (belongsTo)
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Relasi Balik: Setiap detail pesanan tersambung ke satu Order utama (belongsTo)
     * Dibutuhkan oleh AdminController untuk query Best Seller: whereHas('order')
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}