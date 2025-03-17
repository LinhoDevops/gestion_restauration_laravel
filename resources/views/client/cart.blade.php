<!-- client/cart.blade.php -->
@extends('layouts.app')

@section('title', 'Panier')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Mon Panier</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Panier</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Cart Start -->
    <div class="container-xxl py-5">
        <div class="container">
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

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                        <h4 class="mb-4">Articles dans votre panier</h4>

                        @if(isset($cart) && count($cart['items']) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cart['items'] as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($item['product']->image ?? 'img/placeholder.jpg') }}" alt="{{ $item['product']->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                                    <a href="{{ route('client.product.show', $item['product']->id) }}">{{ $item['product']->name }}</a>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item['product']->price, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                <form action="{{ route('client.cart.update') }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" style="width: 60px;">
                                                    <button type="submit" class="btn btn-sm btn-burger ms-2">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ number_format($item['quantity'] * $item['product']->price, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                <form action="{{ route('client.cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('client.catalog') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Continuer les achats
                                </a>
                                <form action="{{ route('client.cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Vider le panier
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                                <h3>Votre panier est vide</h3>
                                <p>Ajoutez des produits à votre panier pour passer commande.</p>
                                <a href="{{ route('client.catalog') }}" class="btn btn-burger mt-3">
                                    <i class="fas fa-utensils me-2"></i>Voir notre menu
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                        <h4 class="mb-4">Résumé de commande</h4>

                        @if(isset($cart) && count($cart['items']) > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <h6>Sous-total</h6>
                                <h6>{{ number_format($cart['total'], 0, ',', ' ') }} FCFA</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <h6>Livraison</h6>
                                <h6>Gratuite</h6>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <h5>Total</h5>
                                <h5>{{ number_format($cart['total'], 0, ',', ' ') }} FCFA</h5>
                            </div>

                            <form action="{{ route('client.order.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="total_price" value="{{ $cart['total'] }}">
                                <button type="submit" class="btn btn-burger w-100 py-3">
                                    <i class="fas fa-check-circle me-2"></i>Passer la commande
                                </button>
                            </form>
                        @else
                            <div class="text-center py-4">
                                <p>Ajoutez des produits à votre panier pour voir le résumé de votre commande.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
