<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        // 📊 Mengambil 4 Menu Terlaris secara otomatis dari histori transaksi lunas
        $bestSellers = OrderDetail::select('menu_id', DB::raw('SUM(quantity) as total_terjual'))
            ->groupBy('menu_id')
            ->orderByDesc('total_terjual')
            ->with('menu')
            ->take(4)
            ->get();

        // Jika dipanggil untuk landing page 'welcome':
        return view('welcome', compact('menus', 'bestSellers'));
        
        // Atau jika untuk halaman khusus pelanggan:
        // return view('pelanggan.menu', compact('menus', 'bestSellers'));
    }
}