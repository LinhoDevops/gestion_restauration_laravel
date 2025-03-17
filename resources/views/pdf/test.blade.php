<!-- pdf/test.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ff6b35;
            padding-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #ff6b35;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="title">{{ $title }}</div>
    <p>Test de génération de PDF avec Laravel</p>
</div>

<div class="content">
    <p>Ce document est un test pour vérifier que la génération de PDF fonctionne correctement.</p>
    <p>Date de génération: {{ date('d/m/Y H:i:s') }}</p>
</div>

<div class="footer">
    <p>© {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
</div>
</body>
</html>
