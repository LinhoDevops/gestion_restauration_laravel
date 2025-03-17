@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Notre Menu</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Search Start -->
    <div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="bg-white shadow" style="padding: 35px;">
                <div class="row g-2">
                    <div class="col-md-12">
                        <form action="{{ route('menu') }}" method="GET">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Rechercher un burger" value="{{ request('search') }}">
                                        <label for="search">Rechercher un burger</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="price" name="price">
                                            <option value="" selected>Tous les prix</option>
                                            <option value="1" {{ request('price') == '1' ? 'selected' : '' }}>Moins de 5000 FCFA</option>
                                            <option value="2" {{ request('price') == '2' ? 'selected' : '' }}>5000 - 8000 FCFA</option>
                                            <option value="3" {{ request('price') == '3' ? 'selected' : '' }}>Plus de 8000 FCFA</option>
                                        </select>
                                        <label for="price">Prix</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="sort" name="sort">
                                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom (A-Z)</option>
                                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix (croissant)</option>
                                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                                        </select>
                                        <label for="sort">Trier par</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-burger w-100 h-100" type="submit">Filtrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search End -->

    <!-- Catalog Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-burger text-uppercase">Nos Spécialités</h6>
                <h1 class="mb-5">Découvrez <span class="text-burger text-uppercase">Nos Burgers</span></h1>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-5">
                    <h3>Aucun produit trouvé</h3>
                    <p>Veuillez modifier vos critères de recherche ou consulter notre menu complet.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration % 3 + 1 }}s">
                            <div class="card product-card shadow rounded overflow-hidden">
                                <div class="position-relative">
                                    <img class="img-fluid" src="{{ asset($product->image ?? 'img/placeholder.jpg') }}" alt="{{ $product->name }}">
                                    <small class="position-absolute start-0 top-100 translate-middle-y bg-burger text-white rounded py-1 px-3 ms-4">{{ number_format($product->price, 0, ',', ' ') }} FCFA</small>
                                </div>
                                <div class="p-4 mt-2">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">{{ $product->name }}</h5>
                                        <div class="ps-2">
                                            @if($product->stock > 0)
                                                <span class="badge bg-success">En stock</span>
                                            @else
                                                <span class="badge bg-danger">Indisponible</span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-body mb-3">{{ Str::limit($product->description, 100) }}</p>
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-sm btn-burger rounded py-2 px-4" href="{{ route('product.show', $product->id) }}">Détails</a>
                                        @if($product->stock > 0)
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-dark rounded py-2 px-4">Commander</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Catalog End -->
@endsection
