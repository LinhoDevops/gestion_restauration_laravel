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
                                        @if(isset($order->items) && is_array($order->items) && !empty($order->items))
                                            @foreach($order->items as $item)
                                                <li>{{ $item['product_name'] ?? 'Produit inconnu' }} x {{ $item['quantity'] ?? '1' }}</li>
                                            @endforeach
                                        @else
                                            <li>Détails non disponibles</li>
                                        @endif
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
