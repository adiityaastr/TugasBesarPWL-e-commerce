<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pengiriman {{ $order->order_number ?? '#'.$order->id }} | HerbaMart</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif; color: #111827; background: #f8fafc; }
        .sheet { max-width: 800px; margin: 16px auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.04); }
        h1 { margin: 0; font-size: 22px; color: #0b5c2c; }
        h2 { margin: 0 0 6px 0; font-size: 16px; color: #0b5c2c; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; }
        .muted { color: #6b7280; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { padding: 8px 6px; font-size: 13px; text-align: left; }
        th { background: #f1f5f9; color: #0b5c2c; font-weight: 700; }
        tr:not(:last-child) td { border-bottom: 1px solid #e5e7eb; }
        .right { text-align: right; }
        .btn-print { background: #0b5c2c; color: #fff; padding: 8px 14px; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; }
        @media print {
            .btn-print { display: none; }
            body { background: #fff; }
            .sheet { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
            <div>
                <h1>HerbaMart - Resi Pengiriman</h1>
                <div class="muted">Tempelkan pada paket</div>
            </div>
            <div style="text-align:right; font-size:13px;">
                <div><strong>Order</strong> {{ $order->order_number ?? ('#'.$order->id) }}</div>
                <div>Tanggal: {{ $order->created_at->format('d M Y') }}</div>
                <div>Metode Kirim: {{ ucfirst(str_replace('_',' ', $order->shipping_method)) }}</div>
                <div>Ongkir: Rp{{ number_format($order->shipping_cost ?? 0,0,',','.') }}</div>
            </div>
        </div>

        <div class="grid" style="margin-bottom:12px;">
            <div class="box">
                <h2>Pengirim</h2>
                <div class="muted">{{ config('app.name', 'HerbaMart') }}</div>
                <div class="muted">Herbal Warehouse</div>
                <div class="muted">Jakarta, Indonesia</div>
            </div>
            <div class="box">
                <h2>Penerima</h2>
                <div><strong>{{ $order->user->full_name ?? $order->user->name }}</strong></div>
                <div class="muted">{{ $order->user->email }}</div>
                <div style="margin-top:6px; line-height:1.4;">
                    <div>{{ $order->shipping_address }}</div>
                    @php $alamat = collect([$order->kelurahan, $order->kecamatan, $order->kota, $order->provinsi])->filter()->implode(', '); @endphp
                    @if($alamat)<div>{{ $alamat }}</div>@endif
                    @if($order->kode_pos)<div>Kode Pos: {{ $order->kode_pos }}</div>@endif
                </div>
            </div>
        </div>

        <div class="box">
            <h2>Detail Barang</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="right">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Produk' }}</td>
                            <td class="right">{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px; font-size:13px;">
            <div>Tempelkan resi ini di bagian luar paket.</div>
            <button class="btn-print" onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>

