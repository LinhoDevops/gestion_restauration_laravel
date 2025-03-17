<!-- gestionnaire/orders/index.blade.php -->
@extends('layouts.app')

@section('title', 'Gestion des commandes')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Gestion des commandes</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestionnaire.dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Commandes</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Orders Start -->
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
                            <h4>Liste des commandes</h4>
                            <div>
                                <form action="{{ route('gestionnaire.orders.index') }}" method="GET" class="d-flex">
                                    <select class="form-select me-2" name="status">
                                        <option value="">Tous les statuts</option>
                                        <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="en_préparation" {{ request('status') == 'en_préparation' ? 'selected' : '' }}>En préparation</option>
                                        <option value="prête" {{ request('status') == 'prête' ? 'selected' : '' }}>Prête</option>
                                        <option value="payée" {{ request('status') == 'payée' ? 'selected' : '' }}>Payée</option>
                                    </select>
                                    <button type="submit" class="btn btn-burger">Filtrer</button>
                                </form>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
                                            <a href="{{ route('gestionnaire.orders.show', $order->id) }}" class="btn btn-sm btn-burger">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($orders->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune commande trouvée</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Orders End -->
@endsection
