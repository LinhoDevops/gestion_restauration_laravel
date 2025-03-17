<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Liste des paiement
    public function index() {
        return response()->json(Payment::with('order')->get());
    }

    // Enregistrer un paiement
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->status === 'payee') {
            return response()->json(['error' => 'Cette commande est déjà payée'], 400);
        }

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'paid_at' => Carbon::now(),
        ]);

        $order->update(['status' => 'payee']);

        // jenere la facture PDF
        $pdf = PDF::loadView('pdf.invoice', compact('order', 'payment'));
        $pdfPath = storage_path("app/public/invoices/invoice_{$order->id}.pdf");
        $pdf->save($pdfPath);

        // evoyer la facture par email - TEMPORAIREMENT à vous-même pour tester
        Mail::to('aliou.18.ndour@gmail.com')->send(new InvoiceMail($order, $pdfPath));

        return response()->json([
            'message' => 'Paiement enregistré et facture envoyée par email',
            'payment' => $payment,
            'invoice_url' => url("/storage/invoices/invoice_{$order->id}.pdf"),
        ]);
    }
}
