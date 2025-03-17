<!-- public/product-detail.blade.php -->
@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Détails du Produit</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('home') }}#menu-section">Menu</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Product Detail Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Detail Start -->
                <div class="col-lg-8">
                    <div id="product-carousel" class="carousel slide mb-5 wow fadeIn" data-bs-ride="carousel" data-wow-delay="0.1s">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="w-100" src="{{ asset($product->image ?? 'img/placeholder.jpg') }}" alt="{{ $product->name }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <h1 class="mb-0">{{ $product->name }}</h1>
                        <div class="ps-3">
                            @if($product->stock > 0)
                                <span class="badge bg-success py-2 px-3">En stock</span>
                            @else
                                <span class="badge bg-danger py-2 px-3">Indisponible</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex flex-wrap pb-4 m-n1">
                        <small class="bg-light rounded py-1 px-3 m-1">
                            <i class="fa fa-tag text-burger me-2"></i>{{ number_format($product->price, 0, ',', ' ') }} FCFA
                        </small>
                    </div>

                    <p>{{ $product->description }}</p>

                    @if($product->stock > 0)
                        <a href="{{ route('login') }}" class="btn btn-burger py-3 px-5">Se connecter pour commander</a>
                    @endif
                </div>
                <!-- Detail End -->

                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Other Products Start -->
                    <div class="bg-light mb-5 wow fadeInUp p-4 rounded" data-wow-delay="0.1s">
                        <h4 class="section-title text-start text-burger text-uppercase mb-4">Autres produits</h4>

                        @php
                            $otherProducts = \App\Models\Product::where('id', '!=', $product->id)
                                ->where('is_active', true)
                                ->inRandomOrder()
                                ->take(3)
                                ->get();
                        @endphp

                        @foreach($otherProducts as $otherProduct)
                            <div class="d-flex align-items-center mb-3">
                                <img class="flex-shrink-0 rounded" src="{{ asset($otherProduct->image ?? 'img/placeholder.jpg') }}" alt="{{ $otherProduct->name }}" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="ps-3">
                                    <h6 class="fw-bold mb-1">{{ $otherProduct->name }}</h6>
                                    <small>{{ number_format($otherProduct->price, 0, ',', ' ') }} FCFA</small><br>
                                    <a href="{{ route('product.show', $otherProduct->id) }}" class="text-burger">Voir les détails</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Other Products End -->

                    <!-- Support Start -->
                    <div class="border p-1 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="border p-4">
                            <h4 class="section-title text-start text-burger mb-4">Besoin d'aide ?</h4>
                            <p>Des questions sur nos produits ou sur votre commande ? N'hésitez pas à nous contacter.</p>
                            <div class="bg-burger text-center p-3">
                                <h4 class="text-white m-0">+221 76 123 4567</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Support End -->
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Product Detail End -->
@endsection
