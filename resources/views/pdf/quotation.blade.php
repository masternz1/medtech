<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation {{ $quotation->quotation_number }}</title>
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
        .notes-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
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
        .signatures {
            margin-top: 40px;
            width: 100%;
        }
        .signatures td {
            width: 50%;
            padding-top: 40px;
            border-top: 1px dashed #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="logo-title">MedTech Distributions</div>
                    <div class="subtitle">Clinical Systems &amp; Medical Equipment Distributor</div>
                    <div style="font-size: 9px; color: #475569; margin-top: 4px;">
                        {{ $company['address'] ?? 'Akowonjo, Lagos, Nigeria' }}<br>
                        @if(!empty($company['phone'])) Phone: {{ $company['phone'] }} @endif @if(!empty($company['email'])) | Email: {{ $company['email'] }} @endif
                    </div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div style="font-size: 16px; font-weight: bold; color: #0f766e;">FORMAL PROPOSAL</div>
                    <div style="font-size: 11px; font-weight: bold;">RFQ #: {{ $quotation->quotation_number }}</div>
                    <div style="font-size: 9px; color: #64748b;">Date: {{ $quotation->created_at->format('d M Y') }}</div>
                    <div style="font-size: 9px; color: #64748b;">Valid Until: {{ $quotation->valid_until ? $quotation->valid_until->format('d M Y') : $quotation->created_at->addDays(30)->format('d M Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="meta-table">
        <tr>
            <td>
                <div class="section-title">Client / Healthcare Institution</div>
                <strong>{{ $quotation->organization_name }}</strong><br>
                Attn: {{ $quotation->contact_name }}<br>
                Email: {{ $quotation->contact_email }}<br>
                Phone: {{ $quotation->contact_phone }}<br>
                Country: {{ $quotation->country }}
            </td>
            <td>
                <div class="section-title">Proposal Status</div>
                Status: <strong>{{ strtoupper(str_replace('_', ' ', $quotation->status)) }}</strong><br>
                Pricing Currency: {{ config('env.DEFAULT_CURRENCY', 'NGN') }}<br>
                Biomedical Support: Included (Installation &amp; Handover)
            </td>
        </tr>
    </table>

    <div class="section-title">Itemized Equipment &amp; Clinical Systems</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 50%;">Description / Model</th>
                <th style="width: 15%; text-align: center;">Qty</th>
                <th style="width: 15%; text-align: right;">Unit Price</th>
                <th style="width: 15%; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $idx => $item)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->notes)
                            <br><span style="font-size: 8px; color: #64748b;">Specs: {{ $item->notes }}</span>
                        @endif
                    </td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">{{ $item->unit_price ? number_format($item->unit_price, 2) : 'Quote in Review' }}</td>
                    <td class="right"><strong>{{ $item->subtotal ? number_format($item->subtotal, 2) : '—' }}</strong></td>
                </tr>
            @endforeach
        </tbody>
        @if($quotation->subtotal)
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="right">Quoted Total Value ({{ config('env.DEFAULT_CURRENCY', 'NGN') }}):</td>
                    <td class="right" style="color: #0f766e; font-size: 13px;">{{ number_format($quotation->subtotal, 2) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    @if($quotation->requirements)
        <div class="notes-box">
            <strong>Stated Clinical &amp; Delivery Requirements:</strong><br>
            <span style="font-size: 10px; color: #475569;">{{ $quotation->requirements }}</span>
        </div>
    @endif

    <div class="terms">
        <strong>Standard Supply &amp; Clinical Terms:</strong><br>
        1. All devices supplied are genuine OEM products carrying valid CE / FDA / NAFDAC registrations.<br>
        2. Manufacturer warranties (minimum 12–24 months) apply to all clinical equipment.<br>
        3. Professional commissioning and biomedical electrical safety testing are scheduled upon hospital delivery.<br>
        4. Payment terms: 70% advance with Purchase Order, 30% upon clinical handover and calibration sign-off.
    </div>

    <table class="signatures">
        <tr>
            <td>
                <strong>Authorized Signatory</strong><br>
                MedTech Distributions Ltd<br>
                Authorised signatory
            </td>
            <td>
                <strong>Client Acceptance Signature</strong><br>
                For: {{ $quotation->organization_name }}<br>
                Date: ________________________
            </td>
        </tr>
    </table>

</body>
</html>

