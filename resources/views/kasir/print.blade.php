<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $order->id ?? '0' }} - RM Mak Cik</title>
    <style>
        @page {
            size: 80mm auto; /* Ukuran kertas printer thermal standar */
            margin: 0;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #000;
            background-color: #ffffff;
            margin: 0;
            padding: 15px 20px; /* PADDING AMAN: Agar teks tidak terlalu menempel ke pinggir */
            max-width: 320px;   /* Lebar standar struk agar teratur */
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11px;
        }

        .btn-container {
            margin-top: 15px;
        }
        .btn-pos {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #FF6600;
            color: #ffffff;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
            font-family: sans-serif;
            font-size: 12px;
        }

        /* GAYA KHUSUS SAAT DICETAK PRINTER THERMAL */
        @media print {
            body {
                padding: 5px 10px !important; /* Padding saat masuk ke printer */
                max-width: 100% !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 class="bold uppercase" style="margin: 0; font-size: 14px;">RM MAK CIK</h2>
        <p style="margin: 3px 0 2px 0; font-size: 9px; line-height: 1.3; color: #333;">
            Jl. Abdul Razak, RT 04 RW 02, Desa Tebang, Kec. Palmatak, Kep. Anambas
        </p>
        <p style="margin: 0; font-size: 9px; color: #333;">Telp/WA: +62 812-3456-7890</p>
    </div>

    <div class="divider"></div>

    @php
        use Carbon\Carbon;

        // 1. Format Waktu WIB Realtime
        $waktuOrder = isset($order->created_at) 
            ? Carbon::parse($order->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
            : Carbon::now()->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB';

        // 2. Format Meja Rapi ("Meja 1" / "meja 1" -> "1")
        $rawMeja = $order->table_number ?? '1';
        $mejaNomorSaja = trim(str_ireplace(['meja', 'table'], '', $rawMeja));
        $isTakeaway = str_contains(strtolower($rawMeja), 'takeaway');
    @endphp

    <table>
        <tr>
            <td style="width: 32%;">No. Nota</td>
            <td style="width: 4%;">:</td>
            <td class="bold">TRX-{{ $order->id ?? '0' }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $waktuOrder }}</td>
        </tr>
        <tr>
            <td>{{ $isTakeaway ? 'Tipe' : 'Meja' }}</td>
            <td>:</td>
            <td class="bold">
                {{ $isTakeaway ? 'Takeaway' : $mejaNomorSaja }}
            </td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>:</td>
            <td>{{ $order->user->name ?? $order->kasir_nama ?? 'Kasir Utama' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        @forelse($order->orderDetails ?? [] as $detail)
            @php
                $namaMenu = $detail->menu->nama ?? $detail->nama_menu ?? 'Hidangan';
                $qty      = $detail->quantity ?? 1;
                $harga    = $detail->price ?? 0;
                $subtotal = $qty * $harga;
            @endphp
            <tr>
                <td colspan="3" class="bold" style="padding-top: 2px;">
                    {{ $namaMenu }}
                    @if(!empty($detail->note))
                        <br><span style="font-size: 9px; font-weight: normal; font-style: italic; color: #444;">*Ket: {{ $detail->note }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width: 55%; color: #333;">{{ $qty }} x Rp {{ number_format($harga, 0, ',', '.') }}</td>
                <td></td>
                <td class="text-right bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center" style="font-style: italic; color: #666; padding: 6px 0;">
                    (Tidak ada rincian item pesanan)
                </td>
            </tr>
        @endforelse
    </table>

    <div class="divider"></div>

    @php
        $total = $order->total_price ?? 0;
        $bayar = $order->cash_paid ?? $order->bayar ?? $total;
        $kembali = $order->change ?? $order->kembalian ?? ($bayar - $total);
        if ($kembali < 0) $kembali = 0;
    @endphp

    <table>
        <tr class="bold" style="font-size: 12px;">
            <td>TOTAL</td>
            <td style="width: 4%;">:</td>
            <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>BAYAR (CASH)</td>
            <td>:</td>
            <td class="text-right">Rp {{ number_format($bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KEMBALIAN</td>
            <td>:</td>
            <td class="text-right">Rp {{ number_format($kembali, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center" style="margin-top: 8px;">
        <p style="margin: 0; font-size: 10px; font-weight: bold;">Terima Kasih Atas Kunjungan Anda!</p>
        <p style="margin: 3px 0 0 0; font-size: 8px; color: #555;">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
    </div>

    <div class="btn-container no-print">
        <a href="{{ route('pos.index') }}" class="btn-pos">
            ← Kembali ke Sistem PoS
        </a>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Otomatis memicu dialog print printer
            window.print();

            // Logika navigasi setelah dialog print selesai / dibatalkan
            window.onafterprint = function() {
                const urlParams = new URLSearchParams(window.location.search);
                
                if (urlParams.get('from') === 'laporan' || (window.opener && !window.opener.closed)) {
                    window.close(); // Tutup Tab jika dibuka dari Admin Laporan
                } else {
                    window.location.href = "{{ route('pos.index') }}"; // Kembali ke Kasir jika dari POS
                }
            };
        });
    </script>

</body>
</html>