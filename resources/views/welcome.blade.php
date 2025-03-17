<!-- welcome.blade.php -->
@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('img/burger-carousel-1.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 700px;">
                            <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">ISI BURGER</h6>
                            <h1 class="display-3 text-white mb-4 animated slideInDown">Découvrez nos délicieux burgers</h1>
                            <a href="#menu-section" class="btn btn-burger py-md-3 px-md-5 me-3 animated slideInLeft">Voir le menu</a>
                            <a href="{{ route('register') }}" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Rejoignez-nous</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('img/burger-carousel-2.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 700px;">
                            <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">ISI BURGER</h6>
                            <h1 class="display-3 text-white mb-4 animated slideInDown">Qualité et saveur garanties</h1>
                            <a href="#menu-section" class="btn btn-burger py-md-3 px-md-5 me-3 animated slideInLeft">Voir le menu</a>
                            <a href="{{ route('register') }}" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Rejoignez-nous</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Booking Start -->
    <div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="bg-white shadow" style="padding: 35px;">
                <div class="row g-2">
                    <div class="col-md-12 text-center">
                        <h4 class="mb-4">Commandez rapidement vos burgers préférés</h4>
                        <a href="#menu-section" class="btn btn-burger py-3 px-5">Voir notre menu complet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booking End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h6 class="section-title text-start text-burger text-uppercase">À propos de nous</h6>
                    <h1 class="mb-4">Bienvenue à <span class="text-burger text-uppercase">ISI BURGER</span></h1>
                    <p class="mb-4">Chez ISI BURGER, nous préparons des burgers de qualité avec des ingrédients frais et locaux. Notre passion pour la cuisine et notre engagement envers la qualité font de chaque burger une expérience unique.</p>
                    <div class="row g-3 pb-4">
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-hamburger fa-2x text-burger mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">20</h2>
                                    <p class="mb-0">Burgers</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-utensils fa-2x text-burger mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">5</h2>
                                    <p class="mb-0">Accompagnements</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-users fa-2x text-burger mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">1500</h2>
                                    <p class="mb-0">Clients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-burger py-3 px-5 mt-2" href="#menu-section">Explorer notre menu</a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="{{ asset('img/burger-about-1.jpg') }}" style="margin-top: 25%;">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="{{ asset('img/burger-about-2.jpg') }}">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="{{ asset('img/burger-about-3.jpg') }}">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="{{ asset('img/burger-about-4.jpg') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Menu Start -->
    <div id="menu-section" class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-burger text-uppercase">Menu</h6>
                <h1 class="mb-5">Découvrez Nos <span class="text-burger text-uppercase">Burgers</span></h1>
            </div>

            <!-- Search Form -->
            <div class="mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <form action="{{ route('home') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-5">
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
                        <div class="col-md-1">
                            <button class="btn btn-burger w-100 h-100" type="submit">Filtrer</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Menu Items -->
            @php
                // Récupération des produits avec filtres
                $query = \App\Models\Product::where('is_active', true);

                // Filtrage par recherche
                if (request('search')) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                }

                // Filtrage par prix
                if (request('price')) {
                    switch (request('price')) {
                        case '1':
                            $query->where('price', '<', 5000);
                            break;
                        case '2':
                            $query->whereBetween('price', [5000, 8000]);
                            break;
                        case '3':
                            $query->where('price', '>', 8000);
                            break;
                    }
                }

                // Tri
                if (request('sort')) {
                    switch (request('sort')) {
                        case 'name':
                            $query->orderBy('name', 'asc');
                            break;
                        case 'name_desc':
                            $query->orderBy('name', 'desc');
                            break;
                        case 'price_asc':
                            $query->orderBy('price', 'asc');
                            break;
                        case 'price_desc':
                            $query->orderBy('price', 'desc');
                            break;
                        default:
                            $query->orderBy('created_at', 'desc');
                    }
                } else {
                    $query->orderBy('created_at', 'desc');
                }

                $products = $query->paginate(9);
            @endphp

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
                                        <!-- Détails est accessible à tous -->
                                        <a class="btn btn-sm btn-burger rounded py-2 px-4" href="{{ route('product.show', $product->id) }}">Détails</a>

                                        @if($product->stock > 0)
                                            @auth
                                                <!-- Si connecté, ajout au panier -->
                                                <form action="{{ route('client.cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="btn btn-sm btn-dark rounded py-2 px-4">Ajouter au panier</button>
                                                </form>
                                            @else
                                                <!-- Si non connecté, redirection vers login -->
                                                <a href="{{ route('login') }}" class="btn btn-sm btn-dark rounded py-2 px-4">Commander</a>
                                            @endauth
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Menu End -->

    <!-- Testimonial Start -->
    <div class="container-xxl testimonial my-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="owl-carousel testimonial-carousel py-5">
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>Les meilleurs burgers de la ville ! Ingrédients frais, pain moelleux et viande juteuse. Je recommande à tous les amateurs de burgers.</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('img/testimonial-1.jpg') }}" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Abdou Diop</h6>
                            <small>Client fidèle</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-burger position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>Service rapide et burgers délicieux. Le Double Cheese est mon préféré ! ISI BURGER est devenu mon restaurant de référence pour les burgers.</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('img/testimonial-2.jpg') }}" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Aminata Sow</h6>
                            <small>Étudiante</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-burger position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>Le rapport qualité-prix est excellent. Des burgers généreux à des prix raisonnables, que demander de plus ? L'ambiance du restaurant est également agréable.</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('img/testimonial-3.jpg') }}" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Moussa Ndoye</h6>
                            <small>Entrepreneur</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-burger position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Newsletter Start -->
    <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="row justify-content-center">
            <div class="col-lg-10 border rounded p-1">
                <div class="border rounded text-center p-1">
                    <div class="bg-white rounded text-center p-5">
                        <h4 class="mb-4">Abonnez-vous à notre <span class="text-burger text-uppercase">Newsletter</span></h4>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control w-100 py-3 ps-4 pe-5" type="text" placeholder="Entrez votre email">
                            <button type="button" class="btn btn-burger py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">S'abonner</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter End -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.testimonial-carousel').owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                margin: 25,
                loop: true,
                center: true,
                dots: false,
                nav: true,
                navText : [
                    '<i class="bi bi-arrow-left"></i>',
                    '<i class="bi bi-arrow-right"></i>'
                ],
                responsive: {
                    0:{
                        items:1
                    },
                    768:{
                        items:2
                    },
                    992:{
                        items:3
                    }
                }
            });
        });
    </script>
@endpush
