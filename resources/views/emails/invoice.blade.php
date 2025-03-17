<!-- emails/invoice.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture ISI BURGER</title>
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
        .info {
            margin-bottom: 20px;
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
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">ISI BURGER</div>
        <p>123 Avenue Senghor, Dakar, Sénégal</p>
    </div>

    <div class="content">
        <p>Bonjour {{ $order->user->name }},</p>

        <p>Votre commande #{{ $order->id }} est prête!</p>

        <p>Veuillez trouver ci-joint votre facture. Vous pouvez venir récupérer votre commande au restaurant et effectuer votre paiement.</p>

        <div class="info">
            <p><strong>Numéro de commande:</strong> #{{ $order->id }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Montant total:</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</p>
        </div>

        <p>Merci pour votre commande et à bientôt chez ISI BURGER!</p>

        <a href="{{ route('client.orders') }}" class="btn">Voir mes commandes</a>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
        <p>Pour toute question, contactez-nous au +221 76 123 4567 ou par email à info@isiburger.com</p>
    </div>
</div>
</body>
</html>
