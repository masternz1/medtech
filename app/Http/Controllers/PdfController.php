<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function quotation(string $quotationNumber): Response
    {
        $quotation = Quotation::where('quotation_number', $quotationNumber)
            ->with(['items.product'])
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.quotation', compact('quotation'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Quotation_{$quotationNumber}.pdf");
    }

    public function invoice(string $orderNumber): Response
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'shippingMethod', 'payments'])
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.invoice', compact('order'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Invoice_{$orderNumber}.pdf");
    }
}

