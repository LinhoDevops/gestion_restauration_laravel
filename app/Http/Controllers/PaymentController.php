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
        $payments = Payment::with('order.user')->paginate(10);
        return view('gestionnaire.payments.index', compact('payments'));
    }

    // Enregistrer un paiement
// Enregistrer un paiement
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->status === 'payée') {
            return redirect()->back()->with('error', 'Cette commande est déjà payée');
        }

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'paid_at' => Carbon::now(),
        ]);

        // Mise à jour du statut de la commande
        $order->update(['status' => 'payée']);

        try {
            // Créer le répertoire s'il n'existe pas
            if (!file_exists(storage_path('app/public/invoices'))) {
                mkdir(storage_path('app/public/invoices'), 0755, true);
            }

            // Générer la facture PDF
            $pdf = PDF::loadView('pdf.invoice', compact('order', 'payment'));
            $pdfPath = storage_path("app/public/invoices/invoice_{$order->id}.pdf");
            $pdf->save($pdfPath);

            // Envoyer la facture par email
            Mail::to('aliou.18.ndour@gmail.com')->send(new InvoiceMail($order, $pdfPath));

            return redirect()->back()->with('success', 'Paiement enregistré et facture envoyée par email');
        } catch (\Exception $e) {
            // Log l'erreur
            Log::error('Erreur lors de la génération de la facture', [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);

            return redirect()->back()->with('success', 'Paiement enregistré mais une erreur est survenue lors de la génération de la facture');
        }
    }
}
