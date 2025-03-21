<!-- pdf/invoice.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture - ISI BURGER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ff6b35;
            padding-bottom: 10px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff6b35;
        }
        .invoice-info {
            margin-bottom: 20px;
        }
        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #ff6b35;
        }
        .client-info, .order-info {
            float: left;
            width: 50%;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">ISI BURGER</div>
        <p>Avenue Blaise DIAGNE , Dakar, Sénégal<br>
            Tél: +221 76 561 68 68 | Email: info@isiburger.com</p>
    </div>

    <div class="invoice-title">FACTURE</div>

    <div class="invoice-info clearfix">
        <div class="client-info">
            <strong>Client:</strong><br>
            {{ $order->user->name }}<br>
            {{ $order->user->email }}
        </div>

        <div class="order-info">
            <strong>Facture #:</strong> {{ $order->id }}<br>
            <strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}<br>
            <strong>Statut:</strong> Payée
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($order->items) && is_array($order->items) && !empty($order->items))
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item['product_name'] ?? 'Produit inconnu' }}</td>
                    <td>{{ number_format($item['price'] ?? 0, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $item['quantity'] ?? 1 }}</td>
                    <td>{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">Détails des produits non disponibles</td>
            </tr>
        @endif
        </tbody>
    </table>

    <div class="total-section">
        <p><strong>Sous-total:</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</p>
        <p><strong>Livraison:</strong> 0 FCFA</p>
        <p class="total"><strong>Total:</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</p>
        <p><strong>Date de paiement:</strong>
            @if(is_object($payment->paid_at) && method_exists($payment->paid_at, 'format'))
                {{ $payment->paid_at->format('d/m/Y') }}
            @else
                {{ $payment->paid_at }}
            @endif
        </p>
        <p><strong>Méthode de paiement:</strong> Espèces</p>
    </div>

    <div class="footer">
        <p>Merci pour votre commande et à bientôt chez ISI BURGER!</p>
        <p>© {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>
