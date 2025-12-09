<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_number ?? '#'.$order->id }} | HerbaMart</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #1f2937; background: #f8fafc; }
        .invoice-box { max-width: 900px; margin: 20px auto; padding: 28px; border: 1px solid #e5e7eb; box-shadow: 0 10px 25px rgba(0,0,0,.05); background: #fff; border-radius: 14px; }
        h1,h2,h3,h4 { margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 8px 6px; vertical-align: top; }
        .top { margin-bottom: 18px; }
        .title { font-size: 28px; font-weight: 800; color: #0b5c2c; letter-spacing: 0.4px; }
        .muted { color: #6b7280; font-size: 13px; }
        .section-title { background: #f1f5f9; color: #0b5c2c; padding: 10px 8px; border-radius: 8px; font-weight: 700; }
        .box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; }
        .heading { background: #f8fafc; font-weight: 700; }
        .item-row { border-bottom: 1px solid #e5e7eb; }
        .totals td { font-weight: 700; }
        .right { text-align: right; }
        .btn-print { background-color: #0b5c2c; border: none; color: white; padding: 10px 16px; font-size: 14px; border-radius: 8px; cursor: pointer; }
        @media print { .btn-print { display: none; } .invoice-box { box-shadow: none; border: none; } }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;" class="top">
            <div>
                <div class="title">HerbaMart</div>
                <div class="muted">Invoice Pembelian</div>
            </div>
            <div style="text-align:right;">
                <div><strong>Invoice</strong> {{ $order->order_number ?? ('#'.$order->id) }}</div>
                <div class="muted">Tanggal: {{ $order->created_at->format('d M Y') }}</div>
                <div class="muted">Status Pesanan: {{ ucfirst(str_replace('_',' ', $order->status)) }}</div>
                <div class="muted">Status Pembayaran: {{ ucfirst(str_replace('_',' ', $order->payment_status)) }}</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:18px;">
            <div class="box">
                <div class="section-title">Kepada</div>
                <div style="margin-top:8px;">
                    <div><strong>{{ $order->user->name }}</strong></div>
                    <div class="muted">{{ $order->user->email }}</div>
                </div>
            </div>
            <div class="box">
                <div class="section-title">Pengiriman</div>
                <div style="margin-top:8px; line-height:1.4;">
                    <div>{{ $order->shipping_address }}</div>
                    @php
                        $alamat = collect([$order->kelurahan, $order->kecamatan, $order->kota, $order->provinsi])->filter()->implode(', ');
                    @endphp
                    @if($alamat)<div>{{ $alamat }}</div>@endif
                    @if($order->kode_pos)<div>Kode Pos: {{ $order->kode_pos }}</div>@endif
                    <div class="muted">Metode: {{ ucfirst(str_replace('_',' ', $order->shipping_method)) }}</div>
                </div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:18px;">
            <div class="box">
                <div class="section-title">Pembayaran</div>
                <div style="margin-top:8px;">
                    <div>Metode: {{ ucfirst(str_replace('_',' ', $order->payment_method)) }}</div>
                    <div class="muted">Status: {{ ucfirst(str_replace('_',' ', $order->payment_status)) }}</div>
                </div>
            </div>
            <div class="box">
                <div class="section-title">Ringkasan</div>
                @php
                    $subtotal = $order->items->sum(function($i){ return $i->price * $i->quantity; });
                    $shippingCost = $order->shipping_cost ?? 0;
                @endphp
                <table>
                    <tr><td>Subtotal Produk</td><td class="right">Rp{{ number_format($subtotal,0,',','.') }}</td></tr>
                    <tr><td>Ongkir ({{ ucfirst(str_replace('_',' ', $order->shipping_method)) }})</td><td class="right">Rp{{ number_format($shippingCost,0,',','.') }}</td></tr>
                    <tr class="totals"><td>Total</td><td class="right">Rp{{ number_format($order->total_price,0,',','.') }}</td></tr>
                </table>
            </div>
        </div>

        <div class="section-title" style="margin-bottom:8px;">Detail Item</div>
        <table>
            <tr class="heading">
                <td>Produk</td>
                <td class="right">Qty</td>
                <td class="right">Harga Satuan</td>
                <td class="right">Subtotal</td>
            </tr>
            @foreach($order->items as $item)
            <tr class="item-row">
                <td>{{ $item->product->name ?? 'Produk' }}</td>
                <td class="right">{{ $item->quantity }}x</td>
                <td class="right">Rp{{ number_format($item->price,0,',','.') }}</td>
                <td class="right">Rp{{ number_format($item->price * $item->quantity,0,',','.') }}</td>
            </tr>
            @endforeach
        </table>

        <div style="text-align:right; margin-top:18px;">
            <button onclick="window.print()" class="btn-print">Print Invoice</button>
        </div>
    </div>
</body>
</html>
