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
                        <li class="breadcrumb-item"><a href="{{ route('gestionnaire.dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestionnaire.orders.index') }}">Commandes</a></li>
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
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('components.sidebar')
                </div>

                <!-- Content -->
                <div class="col-lg-9">
                    <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4>Commande #{{ $order->id }}</h4>
                            <div>
                                @if($order->status != 'payée')
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        <i class="fas fa-money-bill-wave me-2"></i>Enregistrer paiement
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Informations client</h5>
                                <p class="mb-1"><strong>Nom :</strong> {{ $order->user->name }}</p>
                                <p class="mb-1"><strong>Email :</strong> {{ $order->user->email }}</p>
                                <p class="mb-3"><strong>Date de commande :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                                <h5>Mettre à jour le statut</h5>
                                <form action="{{ route('gestionnaire.orders.update-status', $order->id) }}" method="POST" class="d-flex">
                                    @csrf
                                    @method('PUT')
                                    <select class="form-select me-2" name="status" id="status">
                                        <option value="en attente" {{ $order->status == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="en préparation" {{ $order->status == 'en_préparation' ? 'selected' : '' }}>En préparation</option>
                                        <option value="prête" {{ $order->status == 'prête' ? 'selected' : '' }}>Prête</option>
                                        <option value="payée" {{ $order->status == 'payée' ? 'selected' : '' }}>Payée</option>
                                    </select>
                                    <button type="submit" class="btn btn-burger">Mettre à jour</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h5>Statut actuel</h5>
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
                                <div class="d-flex align-items-center mb-3">
                                <span class="badge {{ $statusClass[$order->status] ?? 'bg-secondary' }} p-2">
                                    {{ $statusText[$order->status] ?? $order->status }}
                                </span>
                                </div>

                                <!-- Paiement info -->
                                @if($order->status == 'payée' && isset($payment))
                                    <div class="alert alert-success">
                                        <h6 class="mb-2">Informations de paiement</h6>
                                        <p class="mb-1"><strong>Date :</strong>
                                            @if(is_object($payment->paid_at) && method_exists($payment->paid_at, 'format'))
                                                {{ $payment->paid_at->format('d/m/Y H:i') }}
                                            @else
                                                {{ $payment->paid_at }}
                                            @endif
                                        </p>
                                        <p class="mb-0"><strong>Montant :</strong> {{ number_format($payment->amount, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                @endif
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
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('gestionnaire.orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour aux commandes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Detail End -->

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Enregistrer un paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('gestionnaire.payments.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="form-group mb-3">
                            <label for="amount" class="form-label">Montant</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ $order->total_price }}" min="0" required>
                        </div>
                        <div class="alert alert-info">
                            <p class="mb-0"><small>Le statut de la commande sera automatiquement mis à jour à "Payée" après l'enregistrement du paiement.</small></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Enregistrer le paiement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
