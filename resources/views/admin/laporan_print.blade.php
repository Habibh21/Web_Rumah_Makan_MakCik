<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Keuangan_MakCikResto</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; padding: 20px; font-size: 13px; background-color: #fff; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .subtitle { font-size: 11px; color: #555; margin: 5px 0 0 0; }
        .meta-info { margin-bottom: 15px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #666; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; font-size: 12px; }
        .text-right { text-align: right; }
        .total-row { font-size: 14px; font-weight: bold; background-color: #f9f9f9; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <!-- KOP SURAT FORMAL MAKCIK RESTO -->
    <div class="header">
        <p class="title">MAK CIK RESTO</p>
        <p class="subtitle">Laporan Dokumen Rekapitulasi Penghasilan Omzet Penjualan</p>
        <p style="margin: 2px 0 0 0; font-size: 10px; color: #777;">Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>

    <!-- Informasi rentang tanggal laporan -->
    <div class="meta-info">
        📄 Status {{ $periodeText }}
    </div>

    <!-- TABEL DATA UTAMA LAPORAN -->
    <table>
        <thead>
            <tr>
                <th>No. Nota</th>
                <th>Tanggal Pembayaran</th>
                <th>Nomor Meja</th>
                <th>Tipe Pembayaran</th>
                <th class="text-right">Total Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td style="font-family: monospace;">TRX-{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }} WIB</td>
                <td>{{ ucfirst($order->table_number) }}</td>
                <td style="text-transform: uppercase;">{{ $order->order_type }}</td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            <!-- Baris Total Akhir -->
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL OMZET BERSIH MASUK:</td>
                <td class="text-right">Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- JAVASCRIPT AUTO PRINT & AUTO CLOSE TAB -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        });
    </script>

</body>
</html>