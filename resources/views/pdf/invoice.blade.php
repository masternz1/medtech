<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #0f766e;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo-title {
            font-size: 22px;
            font-weight: bold;
            color: #0f766e;
        }
        .subtitle {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .meta-table td {
            vertical-align: top;
            width: 50%;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f766e;
            margin-bottom: 6px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f1f5f9;
            color: #334155;
            text-align: left;
            padding: 8px;
            font-size: 9px;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
        }
        .items-table td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table td.center { text-align: center; }
        .items-table td.right { text-align: right; }
        .total-row td {
            font-weight: bold;
            background-color: #f8fafc;
            border-top: 1px solid #cbd5e1;
        }
        .payment-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .terms {
            font-size: 9px;
            color: #64748b;
            margin-top: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="logo-title">MedEquip Pro</div>
                    <div class="subtitle">Tax Invoice &amp; Delivery Document</div>
                    <div style="font-size: 9px; color: #475569; margin-top: 4px;">
                        Victoria Island, Lagos, Nigeria<br>
                        Phone: {{ config('env.COMPANY_PHONE', '+234 000 000 0000') }} | Email: info@medequippro.com
                    </div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div style="font-size: 16px; font-weight: bold; color: #0f766e;">TAX INVOICE</div>
                    <div style="font-size: 11px; font-weight: bold;">INVOICE #: {{ $order->order_number }}</div>
                    <div style="font-size: 9px; color: #64748b;">Date: {{ $order->created_at->format('d M Y') }}</div>
                    <div style="font-size: 9px; color: #64748b;">Payment Status: <strong>{{ strtoupper($order->payment_status) }}</strong></div>
                </td>
            </tr>
        </table>
    </div>

    <table class="meta-table">
        <tr>
            <td>
                <div class="section-title">Billed / Delivered To</div>
                <strong>{{ $order->shipping_snapshot['name'] ?? $order->guest_name }}</strong><br>
                @if(!empty($order->shipping_snapshot['organization']))
                    {{ $order->shipping_snapshot['organization'] }}<br>
                @endif
                {{ $order->shipping_snapshot['address'] ?? '' }}<br>
                {{ $order->shipping_snapshot['city'] ?? '' }}, {{ $order->shipping_snapshot['state'] ?? '' }}, {{ $order->shipping_snapshot['country'] ?? '' }}<br>
                Phone: {{ $order->shipping_snapshot['phone'] ?? $order->guest_phone }}<br>
                Email: {{ $order->guest_email }}
            </td>
            <td>
                <div class="section-title">Order Logistics</div>
                Shipping Method: {{ $order->shippingMethod?->name ?? 'Standard Courier' }}<br>
                Order Status: <strong>{{ strtoupper($order->status) }}</strong><br>
                Currency: {{ $order->currency }}
            </td>
        </tr>
    </table>

    <div class="section-title">Purchased Medical Equipment &amp; Supplies</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 45%;">Description</th>
                <th style="width: 15%;">SKU</th>
                <th style="width: 10%; text-align: center;">Qty</th>
                <th style="width: 12%; text-align: right;">Unit Price</th>
                <th style="width: 13%; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $idx => $item)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td><strong>{{ $item->product_name }}</strong></td>
                    <td>{{ $item->product_sku ?? 'N/A' }}</td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="right"><strong>{{ number_format($item->subtotal, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="right">Subtotal:</td>
                <td class="right">{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</td>
            </tr>
            <tr>
                <td colspan="5" class="right">Shipping &amp; Handling:</td>
                <td class="right">{{ number_format($order->shipping_cost, 2) }} {{ $order->currency }}</td>
            </tr>
            @if($order->tax_amount > 0)
                <tr>
                    <td colspan="5" class="right">VAT:</td>
                    <td class="right">{{ number_format($order->tax_amount, 2) }} {{ $order->currency }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td colspan="5" class="right" style="font-size: 12px;">Total Amount:</td>
                <td class="right" style="color: #0f766e; font-size: 13px;">{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="payment-box">
        <strong>Payment Information:</strong><br>
        Status: <strong>{{ strtoupper($order->payment_status) }}</strong> | Provider: {{ ucfirst($order->payments->first()?->provider ?? 'Bank Transfer') }}
        @if($order->payment_status === 'paid')
            &bull; Verified At: {{ $order->payments->first()?->verified_at?->format('d M Y h:i A') ?? 'Verified' }}
        @endif
    </div>

    <div class="terms">
        <strong>Clinical Device Guarantee:</strong><br>
        All equipment is backed by manufacturer warranty. For questions or biomedical support, quote Order #{{ $order->order_number }} to support@medequippro.com.
    </div>

</body>
</html>
