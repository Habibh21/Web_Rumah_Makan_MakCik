<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Reservasi;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * 1. Menampilkan Halaman Utama Kasir PoS dengan Proteksi Kunci Meja & Auto Best Seller
     */
    public function index()
    {
        // 🔥 LOGIKA BEST SELLER DINAMIS: Ambil 5 ID Menu yang paling banyak terjual dari histori transaksi
        $topMenuIds = OrderDetail::select('menu_id', DB::raw('SUM(quantity) as total_terjual'))
            ->whereHas('order', function($q) {
                $q->where('status', '!=', 'void');
            })
            ->groupBy('menu_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->pluck('menu_id')
            ->toArray();

        // Ambil data menu dan berikan atribut 'is_bestseller' otomatis jika masuk dalam Top 5
        $menus = Menu::orderBy('id', 'desc')->get()->map(function ($menu) use ($topMenuIds) {
            $menu->is_bestseller = in_array($menu->id, $topMenuIds);
            return $menu;
        });

        // Agregasi Data Analisis Restoran di Bagian Atas Dashboard Kasir
        $totalPendapatan = Order::where('status', '!=', 'void')->sum('total_price');
        $totalPesanan = Order::where('status', '!=', 'void')->count();
        $totalReservasi = Reservasi::count();

        // LOGIKA KUNCI MEJA: Mengambil nomor meja dari order yang statusnya belum selesai
        $occupiedTables = Order::whereIn('status', ['pending', 'occupied', 'processing', 'active'])
            ->pluck('table_number')
            ->toArray();

        return view('kasir.pos', compact('menus', 'totalPendapatan', 'totalPesanan', 'totalReservasi', 'occupiedTables'));
    }

    public function printReceipt($id)
    {
        // Memuat data Order beserta rincian orderDetails dan data Menu terkait
        $order = \App\Models\Order::with('orderDetails.menu')->findOrFail($id);

        return view('kasir.print', compact('order'));
    }

    /**
     * 3. Memproses Transaksi & Validasi Ketat Stok + Catatan Menu + Poin E-CRM + Simpan Identitas Antrean
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_number'   => 'required|string',
            'items'          => 'required|array',
            'items.*.menu_id'=> 'required|exists:menus,id',
            'items.*.quantity'=> 'required|integer|min:1',
            'items.*.price'  => 'required|numeric',
            'items.*.note'   => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'customer_name'  => 'nullable|string',
            'cash'           => 'nullable|numeric'
        ]);

        // Validasi stok
        foreach ($request->items as $item) {
            $menuObj = Menu::find($item['menu_id']);
            if ($menuObj && $item['quantity'] > $menuObj->stok) {
                return redirect()->back()->withInput()->with('error', "Transaksi Gagal! Stok untuk menu [{$menuObj->nama}] tidak mencukupi. Sisa stok di dapur saat ini: {$menuObj->stok} porsi.");
            }
        }

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $order = new Order();
        $order->table_number = $request->table_number;
        $order->total_price = $subtotal;
        $order->order_type = 'offline';
        $order->status = 'completed'; 
        
        $order->customer_name = $request->filled('customer_name') ? $request->customer_name : 'Pelanggan Antrean';
        $order->customer_phone = $request->filled('customer_phone') ? $request->customer_phone : '-';
        $order->save();

        // Logika E-CRM
        if ($request->filled('customer_phone')) {
            $phone = $request->customer_phone;
            $name = $request->customer_name ?? 'Pelanggan Setia';
            
            $poinBaru = floor($subtotal / 10000);

            $customer = Customer::firstOrCreate(
                ['no_telp' => $phone],
                ['nama' => $name, 'poin' => 0, 'total_transaksi' => 0]
            ); 

            $customer->total_transaksi += $subtotal;
            $customer->poin += $poinBaru;

            if ($customer->poin > 150) {
                $customer->tier = 'Platinum';
            } elseif ($customer->poin > 50) {
                $customer->tier = 'Gold';
            } else {
                $customer->tier = 'Silver';
            }
            
            $customer->save();
        }

        // Potong stok & simpan detail
        foreach ($request->items as $item) {
            $menuObj = Menu::find($item['menu_id']);
            if ($menuObj) {
                $menuObj->stok = max(0, $menuObj->stok - $item['quantity']);
                $menuObj->save();
            }

            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id'  => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
                'note'     => $item['note'] ?? null,
            ]);
        }

        return redirect()->route('pos.print', $order->id)->with('success', 'Transaksi berhasil, poin CRM tercatat & stok diperbarui!');
    }

    /**
     * 4. AKSI PEMBATALAN TRANSAKSI (VOID LOG)
     */
    public function voidOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Kembalikan stok hidangan jika transaksi dibatalkan
        foreach ($order->orderDetails as $detail) {
            $menu = Menu::find($detail->menu_id);
            if ($menu) {
                $menu->stok += $detail->quantity;
                $menu->save();
            }
        }

        // Ubah status menjadi void dan simpan alasannya
        $order->status = 'void';
        $order->alasan_batal = $request->input('alasan_batal', 'Salah input transaksi oleh kasir');
        $order->save();

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan dan tercatat pada Audit Log Admin.');
    }
}