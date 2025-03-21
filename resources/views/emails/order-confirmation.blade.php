<!-- emails/order-confirmation.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande - ISI BURGER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff6b35;
        }
        .title {
            font-size: 20px;
            margin: 20px 0;
        }
        .item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .summary {
            margin: 20px 0;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .btn {
            display: inline-block;
            background-color: #ff6b35;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">ISI BURGER</div>
        <p>Avenue Blaise DIAGNE, Dakar, Sénégal</p>
    </div>

    <div class="content">
        <p>Bonjour {{ $order->user->name }},</p>

        <p>Merci pour votre commande chez ISI BURGER. Votre commande a bien été reçue et est en cours de traitement.</p>

        <div class="title">Détails de la commande #{{ $order->id }}</div>

        <table>
            <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p><strong>Total :</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</p>
            <p><strong>Date de commande :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Statut :</strong> En attente</p>
        </div>

        <p>Vous recevrez un email lorsque votre commande sera prête.</p>

        <a href="{{ route('client.orders') }}" class="btn">Suivre ma commande</a>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
        <p>Pour toute question, contactez-nous au +221 76 561 68 68 ou par email à info@isiburger.com</p>
    </div>
</div>
</body>
</html>
