<!-- gestionnaire/payments/index.blade.php -->
@extends('layouts.app')

@section('title', 'Gestion des paiements')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Gestion des paiements</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestionnaire.dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Paiements</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Payments Start -->
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
                        <h4 class="mb-4">Historique des paiements</h4>

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
                                    <th>N° Paiement</th>
                                    <th>N° Commande</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Date de paiement</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>#{{ $payment->id }}</td>
                                        <td>#{{ $payment->order_id }}</td>
                                        <td>{{ $payment->order->user->name }}</td>
                                        <td>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $payment->paid_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('gestionnaire.orders.show', $payment->order_id) }}" class="btn btn-sm btn-burger">
                                                <i class="fas fa-eye"></i> Voir la commande
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($payments->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Aucun paiement enregistré</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payments End -->
@endsection
