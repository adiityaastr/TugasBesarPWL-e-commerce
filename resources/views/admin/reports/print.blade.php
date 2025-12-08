<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - HerbaMart</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.5;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #0b5c2c;
        }
        .header h1 {
            color: #0b5c2c;
            margin: 0 0 8px 0;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header .subtitle {
            color: #4b5563;
            margin: 4px 0;
            font-size: 13px;
            font-weight: 600;
        }
        .header .date {
            color: #6b7280;
            margin: 4px 0;
            font-size: 10px;
        }
        .info-section {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        .info-title {
            font-weight: bold;
            color: #374151;
            font-size: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            padding: 4px 0;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #4b5563;
            min-width: 100px;
        }
        .info-value {
            color: #1f2937;
            font-weight: 500;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }
        .stat-box {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }
        .stat-label {
            font-size: 9px;
            color: #6b7280;
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            line-height: 1.2;
        }
        .table-container {
            margin-top: 20px;
            overflow: visible;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            background: white;
        }
        thead {
            background: linear-gradient(135deg, #0b5c2c 0%, #09481f 100%);
            color: white;
        }
        th {
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #0b5c2c;
        }
        th.text-right {
            text-align: right;
        }
        td {
            padding: 7px 6px;
            border: 1px solid #e5e7eb;
            font-size: 9px;
            color: #374151;
        }
        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tbody tr:hover {
            background-color: #f3f4f6;
        }
        td.text-right {
            text-align: right;
            font-weight: 600;
            color: #1f2937;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }
        .footer p {
            margin: 3px 0;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-style: italic;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .stat-box {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            thead {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HerbaMart</h1>
        <div class="subtitle">Laporan Penjualan</div>
        <div class="date">Dicetak pada: {{ now()->format('d M Y, H:i:s') }}</div>
    </div>

    <div class="info-section">
        <div class="info-title">Informasi Periode</div>
        <div class="info-row">
            <span class="info-label">Periode:</span>
            <span class="info-value">
                @if(request('start_date') && request('end_date'))
                    {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                @elseif(request('start_date'))
                    Dari {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                @elseif(request('end_date'))
                    Sampai {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                @else
                    Semua Waktu
                @endif
            </span>
        </div>
        @if(request('status') && request('status') !== 'all')
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', request('status'))) }}</span>
            </div>
        @endif
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Pesanan Dikirim</div>
            <div class="stat-value">{{ $totalShipped }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Pesanan Dibatalkan</div>
            <div class="stat-value">{{ $totalCancelled }}</div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Order ID</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 20%;">Pelanggan</th>
                    <th style="width: 10%;">Jumlah Item</th>
                    <th style="width: 20%;" class="text-right">Total</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->items->sum('quantity') }} item</td>
                        <td class="text-right">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($order->status === 'pending_cancellation')
                                Menunggu
                            @elseif($order->status === 'proses')
                                Proses
                            @elseif($order->status === 'pengemasan')
                                Pengemasan
                            @elseif($order->status === 'pengiriman')
                                Pengiriman
                            @elseif($order->status === 'cancelled')
                                Dibatalkan
                            @else
                                {{ ucfirst($order->status) }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">Tidak ada data untuk periode yang dipilih.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><strong>HerbaMart - Sistem E-Commerce Obat Herbal</strong></p>
        <p>Laporan ini dibuat secara otomatis oleh sistem</p>
        <p>Halaman 1</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
