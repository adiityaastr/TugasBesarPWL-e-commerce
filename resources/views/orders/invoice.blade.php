<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; text-align: center; color: #777; }
        body h1 { font-weight: 300; margin-bottom: 0px; padding-bottom: 0px; color: #000; }
        body h3 { font-weight: 300; margin-top: 10px; margin-bottom: 20px; font-style: italic; color: #555; }
        body a { color: #06f; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555; text-align: left; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td{ border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        @media only screen and (max-width: 600px) { .invoice-box table tr.top table td { width: 100%; display: block; text-align: center; } .invoice-box table tr.information table td { width: 100%; display: block; text-align: center; } }
        .btn-print { background-color: #4CAF50; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px; }
        @media print { .btn-print { display: none; } }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn-print">Print Invoice</button>
    <br><br>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                Laravel E-commerce
                            </td>
                            <td>
                                Invoice #: {{ $order->id }}<br>
                                Created: {{ $order->created_at->format('M d, Y') }}<br>
                                Status: {{ ucfirst($order->payment_status) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ config('app.name') }}<br>
                                1234 Main Street<br>
                                Jakarta, Indonesia
                            </td>
                            <td>
                                {{ $order->user->name }}<br>
                                {{ $order->user->email }}<br>
                                {{ $order->shipping_address }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Payment Method</td>
                <td>Check #</td>
            </tr>
            <tr class="details">
                <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                <td>-</td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>

            @foreach($order->items as $item)
            <tr class="item">
                <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td>Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
