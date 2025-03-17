
<!-- client/my-orders.blade.php -->
@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Mes Commandes</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Mes Commandes</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Orders Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-burger text-uppercase">Historique</h6>
                <h1 class="mb-5">Vos <span class="text-burger text-uppercase">Commandes</span></h1>
            </div>

            @if($orders->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                    <h3>Vous n'avez pas encore de commande</h3>
                    <p>Passez votre première commande en explorant notre menu de délicieux burgers.</p>
                    <a href="{{ route('client.catalog') }}" class="btn btn-burger mt-3">
                        <i class="fas fa-utensils me-2"></i>Voir notre menu
                    </a>
                </div>
            @else
                <div class="table-responsive wow fadeInUp" data-wow-delay="0.3s">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th>N° Commande</th>
                            <th>Date</th>
                            <th>Produits</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <ul class="mb-0">
                                        @foreach($order->items as $item)
                                            <li>{{ $item['product_name'] }} x {{ $item['quantity'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'en_attente' => 'bg-warning',
                                            'en_préparation' => 'bg-info',
                                            'prête' => 'bg-success',
                                            'payée' => 'bg-primary'
                                        ];
                                        $statusText = [
                                            'en_attente' => 'En attente',
                                            'en_préparation' => 'En préparation',
                                            'prête' => 'Prête',
                                            'payée' => 'Payée'
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusClass[$order->status] ?? 'bg-secondary' }}">
                                        {{ $statusText[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('client.order.show', $order->id) }}" class="btn btn-sm btn-burger">
                                        <i class="fas fa-eye"></i> Détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Orders End -->
@endsection

<!-- client/order-detail.blade.php -->
@extends('layouts.app')

@section('title', 'Détail de la commande')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Détail de la commande</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('client.orders') }}">Mes Commandes</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Commande #{{ $order->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Order Detail Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                        <div class="bg-light rounded p-5">
                            <h4 class="section-title text-start text-burger text-uppercase mb-4">Détails de la commande #{{ $order->id }}</h4>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Informations</h5>
                                    <p class="mb-1"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-1"><strong>Client :</strong> {{ $order->user->name }}</p>
                                    <p class="mb-1"><strong>Email :</strong> {{ $order->user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Statut</h5>
                                    @php
                                        $statusClass = [
                                            'en_attente' => 'bg-warning',
                                            'en_préparation' => 'bg-info',
                                            'prête' => 'bg-success',
                                            'payée' => 'bg-primary'
                                        ];
                                        $statusText = [
                                            'en_attente' => 'En attente',
                                            'en_préparation' => 'En préparation',
                                            'prête' => 'Prête',
                                            'payée' => 'Payée'
                                        ];
                                    @endphp
                                    <div class="d-flex align-items-center">
                                    <span class="badge {{ $statusClass[$order->status] ?? 'bg-secondary' }} p-2">
                                        {{ $statusText[$order->status] ?? $order->status }}
                                    </span>
                                    </div>

                                    <!-- Timeline pour le statut -->
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-circle bg-{{ $order->status == 'en_attente' || $order->status == 'en_préparation' || $order->status == 'prête' || $order->status == 'payée' ? 'success' : 'secondary' }}" style="width: 20px; height: 20px;"></div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <small>Commande reçue</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-circle bg-{{ $order->status == 'en_préparation' || $order->status == 'prête' || $order->status == 'payée' ? 'success' : 'secondary' }}" style="width: 20px; height: 20px;"></div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <small>En préparation</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-circle bg-{{ $order->status == 'prête' || $order->status == 'payée' ? 'success' : 'secondary' }}" style="width: 20px; height: 20px;"></div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <small>Prête</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-circle bg-{{ $order->status == 'payée' ? 'success' : 'secondary' }}" style="width: 20px; height: 20px;"></div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <small>Payée</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3">Produits commandés</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item['product_name'] }}</td>
                                            <td>{{ number_format($item['price'], 0, ',', ' ') }} FCFA</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                                        <td><strong>{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</strong></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('client.orders') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour aux commandes
                                </a>
                                @if($order->status == 'prête')
                                    <div class="alert alert-success mt-3">
                                        <i class="fas fa-info-circle me-2"></i>Votre commande est prête ! Veuillez vous présenter au restaurant pour la récupérer et effectuer votre paiement.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-5 wow fadeInUp" data-wow-delay="0.3s">
                        <h4 class="section-title text-start text-burger text-uppercase mb-4">Aide & Support</h4>
                        <p>Des questions sur votre commande ? N'hésitez pas à nous contacter par téléphone ou par email.</p>
                        <div class="bg-burger text-center p-4 mb-4">
                            <h5 class="text-white m-0">+221 76 123 4567</h5>
                        </div>
                        <p class="mb-2"><i class="fa fa-envelope text-burger me-2"></i>info@isiburger.com</p>
                        <p class="mb-2"><i class="fa fa-map-marker-alt text-burger me-2"></i>123 Avenue Senghor, Dakar, Sénégal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Detail End -->
@endsection
