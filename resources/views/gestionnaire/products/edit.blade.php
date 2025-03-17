<!-- gestionnaire/products/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Modifier un produit')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Modifier un produit</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestionnaire.dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestionnaire.products.index') }}">Produits</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Modifier</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Edit Product Start -->
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
                        <h4 class="mb-4">Modifier le produit: {{ $product->name }}</h4>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('gestionnaire.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit" value="{{ old('name', $product->name) }}" required>
                                        <label for="name">Nom du produit</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="{{ old('price', $product->price) }}" required min="0">
                                        <label for="price">Prix (FCFA)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" value="{{ old('stock', $product->stock) }}" required min="0">
                                        <label for="stock">Stock</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="is_active" name="is_active" required>
                                            <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Actif</option>
                                            <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                        <label for="is_active">Statut</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 150px">{{ old('description', $product->description) }}</textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Image actuelle</label>
                                        <div>
                                            @if($product->image)
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 200px">
                                            @else
                                                <p>Aucune image</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="form-label">Nouvelle image (laisser vide pour conserver l'image actuelle)</label>
                                        <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <a href="{{ route('gestionnaire.products.index') }}" class="btn btn-secondary">Annuler</a>
                                    <button class="btn btn-burger" type="submit">Mettre à jour le produit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Product End -->
@endsection
