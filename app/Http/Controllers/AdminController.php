<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * 1. Menampilkan Tabel Daftar Kelola Menu Admin
     */
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->get();
        return view('admin.index', compact('menus'));
    }

    /**
     * 2. Menampilkan Form Tambah Menu Baru
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * 3. Memproses Penyimpanan Data Menu Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'nama'     => 'required',
            'harga'    => 'required',
            'gambar'   => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('menu_images'), $namaGambar);
        }

        Menu::create([
            'kategori' => $request->kategori,
            'nama'     => $request->nama,
            'harga'    => $request->harga,
            'gambar'   => $namaGambar,
            'stok'     => 0 
        ]);

        // 📝 AUDIT LOG: TAMBAH MENU
        ActivityLog::record(
            'MENU_CREATE',
            "Admin menambah menu baru [{$request->nama}] dengan harga Rp " . number_format($request->harga, 0, ',', '.')
        );

        return redirect()->route('admin.menu_list')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * 4. Menampilkan Form Edit Menu Berdasarkan ID
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.edit', compact('menu'));
    }

    /**
     * 5. Memproses Pembaruan Data Menu
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required',
            'nama'     => 'required',
            'harga'    => 'required',
            'gambar'   => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        $namaLama = $menu->nama;
        $namaGambar = $menu->gambar;

        if ($request->hasFile('gambar')) {
            if ($menu->gambar && file_exists(public_path('menu_images/' . $menu->gambar))) {
                unlink(public_path('menu_images/' . $menu->gambar));
            }
            $file = $request->file('gambar');
            $namaGambar = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('menu_images'), $namaGambar);
        }

        $menu->update([
            'kategori' => $request->kategori,
            'nama'     => $request->nama,
            'harga'    => $request->harga,
            'gambar'   => $namaGambar,
        ]);

        // 📝 AUDIT LOG: EDIT MENU
        ActivityLog::record(
            'MENU_EDIT',
            "Admin mengedit menu [{$namaLama}]. Nama baru: '{$request->nama}', Harga: Rp " . number_format($request->harga, 0, ',', '.')
        );

        return redirect()->route('admin.menu_list')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * 6. Menghapus Menu
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $namaMenu = $menu->nama;

        OrderDetail::where('menu_id', $id)->delete();
        
        if ($menu->gambar && file_exists(public_path('menu_images/' . $menu->gambar))) {
            unlink(public_path('menu_images/' . $menu->gambar));
        }
        $menu->delete();

        // 📝 AUDIT LOG: HAPUS MENU
        ActivityLog::record(
            'MENU_DELETE',
            "Admin menghapus menu [{$namaMenu}] dari sistem"
        );

        return redirect()->route('admin.menu_list')->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * 7. LAYAR KASIR OPERASIONAL: Monitoring Status Meja & Waiting List FIFO
     */
    public function manajemenMeja()
    {
        $activeOrders = Order::whereIn('status', ['pending', 'occupied', 'processing', 'active'])
                             ->orderBy('created_at', 'asc')
                             ->get();

        $occupiedTablesMap = [];
        $waitingList = [];

        foreach ($activeOrders as $order) {
            $table = trim($order->table_number);
            if (strpos($table, 'Waiting List') !== false) {
                $waitingList[] = $order;
            } else {
                $occupiedTablesMap[$table] = $order;
            }
        }

        $occupiedTables = array_keys($occupiedTablesMap);
        return view('kasir.meja', compact('occupiedTables', 'occupiedTablesMap', 'waitingList'));
    }

    /**
     * 8. AKSI KASIR: Mengosongkan Meja Fisik
     */
    public function kosongkanMeja($table_number)
    {
        Order::where('table_number', $table_number)
             ->whereIn('status', ['pending', 'occupied', 'processing', 'active'])
             ->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Status ' . $table_number . ' kini telah kosong!');
    }

    /**
     * 9. AKSI KASIR: Memindahkan Antrean Waiting List ke Meja Fisik Kosong
     */
    public function pindahkanMeja(Request $request, $id)
    {
        $request->validate(['table_number' => 'required']);

        $order = Order::findOrFail($id);
        $order->table_number = $request->table_number;
        $order->created_at = now(); 
        $order->save();

        return redirect()->back()->with('success', "Pelanggan [{$order->customer_name}] berhasil dipindahkan ke {$request->table_number}!");
    }

    /**
     * 10. FITUR E-CRM: Khusus Panel Manajemen Admin Utama
     */
    public function indexCrm()
    {
        $customers = Customer::orderBy('poin', 'desc')->get();
        
        $totalMember = $customers->count();
        $platinumCount = $customers->where('tier', 'Platinum')->count();
        $goldCount = $customers->where('tier', 'Gold')->count();

        return view('admin.crm', compact('customers', 'totalMember', 'platinumCount', 'goldCount'));
    }

    /**
     * 11. FITUR MONITORING RESERVASI: Khusus Panel Kasir
     */
    public function daftarReservasi()
    {
        $reservasis = Reservasi::orderBy('id', 'desc')->get();
        return view('kasir.reservasi', compact('reservasis'));
    }

    /**
     * 12. FITUR BATALKAN / HAPUS RESERVASI
     */
    public function destroyReservasi($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->back()->with('success', 'Data reservasi berhasil dibatalkan / dihapus dari sistem!');
    }

    /**
     * 13. Fitur Akuntansi Laporan Keuangan (LENGKAP DENGAN BEST SELLER & VOID LOGS)
     */
    public function laporanPenghasilan(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $query = Order::where('status', '!=', 'void');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            $filter = 'kustom';
        } else {
            if ($filter == 'hari') { $query->whereDate('created_at', Carbon::today()); }
            elseif ($filter == 'bulan') { $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year); }
            elseif ($filter == 'tahun') { $query->whereYear('created_at', Carbon::now()->year); }
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        $totalPenghasilan = $orders->sum('total_price');

        // 🔥 CALCULATE TOP 5 BEST SELLER REALTIME UNTUK WIDGET ATAS LAPORAN
        $bestSellers = OrderDetail::select('menu_id', DB::raw('SUM(quantity) as total_terjual'))
            ->whereHas('order', function($q) {
                $q->where('status', '!=', 'void');
            })
            ->groupBy('menu_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->with('menu')
            ->get();

        // 🚫 QUERY AUDIT LOG VOID (TRANSAKSI YANG DIBATALKAN KASIR)
        $voidLogs = Order::where('status', 'void')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.laporan', compact(
            'orders', 
            'totalPenghasilan', 
            'filter', 
            'startDate', 
            'endDate', 
            'bestSellers', 
            'voidLogs'
        ));
    }

    /**
     * 14. HALAMAN KHUSUS AUDIT LOG KEAMANAN AKSES & MODIFIKASI PRODUK
     */
    public function auditLog(Request $request)
    {
        $search = $request->get('search');
        $type   = $request->get('type'); // 👈 Parameter filter tipe aksi
        
        $query = ActivityLog::latest();

        // Filter berdasarkan kategori tipe aksi
        if ($type) {
            if ($type === 'login') {
                $query->whereIn('action', ['LOGIN_SUCCESS', 'LOGIN_FAILED', 'LOGOUT']);
            } elseif ($type === 'edit_produk') {
                $query->whereIn('action', ['MENU_CREATE', 'MENU_EDIT', 'MENU_DELETE', 'STOK_UPDATE']);
            }
        }

        // Filter berdasarkan teks pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        $activityLogs = $query->paginate(20)->withQueryString();

        return view('admin.audit_log', compact('activityLogs', 'search', 'type'));
    }

    /**
     * 15. Ekspor CSV
     */
    public function exportCsv(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $query = Order::where('status', '!=', 'void');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } else {
            if ($filter == 'hari') { $query->whereDate('created_at', Carbon::today()); }
            elseif ($filter == 'bulan') { $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year); }
            elseif ($filter == 'tahun') { $query->whereYear('created_at', Carbon::now()->year); }
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        $filename = "Laporan_Omzet_MakCik_" . now()->format('Ymd_His') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Transaksi', 'Tanggal Waktu', 'Nomor Meja', 'Tipe Layanan', 'Total Nominal (Rp)'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); 
            fputcsv($file, $columns, ';');

            foreach ($orders as $order) {
                fputcsv($file, [
                    'TRX-' . $order->id,
                    $order->created_at->format('d/m/Y H:i') . ' WIB',
                    $order->table_number,
                    $order->order_type,
                    $order->total_price
                ], ';');
            }
            fputcsv($file, ['', '', '', 'TOTAL OMZET:', $orders->sum('total_price')], ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 16. Cetak PDF
     */
    public function printPdf(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $query = Order::where('status', '!=', 'void');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            $periodeText = "Periode Kustom: " . Carbon::parse($startDate)->format('d M Y') . " - " . Carbon::parse($endDate)->format('d M Y');
        } else {
            $periodeText = "Kategori Periode: " . ucfirst($filter);
            if ($filter == 'hari') { $query->whereDate('created_at', Carbon::today()); }
            elseif ($filter == 'bulan') { $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year); }
            elseif ($filter == 'tahun') { $query->whereYear('created_at', Carbon::now()->year); }
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        $totalPenghasilan = $orders->sum('total_price');

        return view('admin.laporan_print', compact('orders', 'totalPenghasilan', 'periodeText'));
    }

    /**
     * 17. Update Stok Cepat
     */
    public function updateStok(Request $request, $id)
    {
        $request->validate(['stok' => 'required|integer|min:0']);
        $menu = Menu::findOrFail($id);
        $stokLama = $menu->stok;
        $menu->stok = $request->stok;
        $menu->save();

        // 📝 AUDIT LOG: UBAH STOK
        ActivityLog::record(
            'STOK_UPDATE',
            "Admin mengubah stok menu [{$menu->nama}] dari {$stokLama} porsi menjadi {$request->stok} porsi"
        );

        return redirect()->back()->with('success', "Stok hidangan [{$menu->nama}] berhasil diperbarui!");
    }
}