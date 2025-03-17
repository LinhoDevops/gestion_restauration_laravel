@extends('layouts.app')

@section('title', 'À propos de nous')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/about-banner.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">À propos de nous</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">À propos</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h6 class="section-title text-start text-primary text-uppercase">À propos de nous</h6>
                    <h1 class="mb-4">Bienvenue chez <span class="text-primary text-uppercase">ISI BURGER</span></h1>
                    <p class="mb-4">ISI BURGER est né de la passion de jeunes entrepreneurs pour la cuisine authentique et gourmande. Notre mission est de vous offrir une expérience culinaire inoubliable à travers des burgers faits maison avec des ingrédients frais et de qualité supérieure.</p>
                    <p class="mb-4">Fondé en 2020, ISI BURGER s'est rapidement imposé comme une référence dans le monde de la restauration rapide de qualité. Notre secret ? Des recettes uniques, un savoir-faire artisanal et une attention particulière portée à chaque détail, de la sélection des ingrédients à la présentation finale de nos burgers.</p>
                    <div class="row g-3 pb-4">
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-hamburger fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">15</h2>
                                    <p class="mb-0">Burgers</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-utensils fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">3</h2>
                                    <p class="mb-0">Restaurants</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">4500</h2>
                                    <p class="mb-0">Clients satisfaits</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="{{ route('contact') }}">Contactez-nous</a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="{{ asset('img/about-burger-1.jpg') }}" style="margin-top: 25%;">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="{{ asset('img/about-burger-2.jpg') }}">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="{{ asset('img/about-burger-3.jpg') }}">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="{{ asset('img/about-burger-4.jpg') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Mission & Vision Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">Notre mission</h6>
                <h1 class="mb-5">Découvrez notre <span class="text-primary text-uppercase">Philosophie</span></h1>
            </div>
            <div class="row g-4 mb-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="h-100 bg-light rounded p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 60px; height: 60px;">
                            <i class="fa fa-bullseye text-white fs-4"></i>
                        </div>
                        <h4 class="mb-3">Notre mission</h4>
                        <p class="mb-4">Notre mission est de redéfinir l'expérience du burger en proposant des créations délicieuses, préparées avec des ingrédients frais et locaux. Nous nous engageons à offrir un service exceptionnel et à créer un environnement accueillant où chaque client se sent comme chez lui.</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Qualité des ingrédients</li>
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Service client irréprochable</li>
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Innovation constante</li>
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Respect de l'environnement</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="h-100 bg-light rounded p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 60px; height: 60px;">
                            <i class="fa fa-eye text-white fs-4"></i>
                        </div>
                        <h4 class="mb-3">Notre vision</h4>
                        <p class="mb-4">Nous aspirons à devenir la référence dans l'univers du burger gourmet, reconnus pour notre savoir-faire, notre créativité et notre engagement envers la satisfaction de nos clients. Nous voulons créer un réseau de restaurants où la qualité des produits va de pair avec une expérience client mémorable.</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Expansion nationale</li>
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Développement durable</li>
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Formation de talents</li>
                            <li><i class="fa fa-check-circle text-primary me-2"></i> Innovation culinaire continue</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mission & Vision End -->

    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">Notre équipe</h6>
                <h1 class="mb-5">Découvrez nos <span class="text-primary text-uppercase">Chefs</span></h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="rounded shadow overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('img/chef-1.jpg') }}" alt="Chef Thomas Martin">
                            <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4 mt-3">
                            <h5 class="fw-bold mb-0">Thomas Martin</h5>
                            <small>Chef Principal</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="rounded shadow overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('img/chef-2.jpg') }}" alt="Chef Sophie Dubois">
                            <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4 mt-3">
                            <h5 class="fw-bold mb-0">Sophie Dubois</h5>
                            <small>Chef Créative</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="rounded shadow overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('img/chef-3.jpg') }}" alt="Chef Lucas Bernard">
                            <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4 mt-3">
                            <h5 class="fw-bold mb-0">Lucas Bernard</h5>
                            <small>Sous-chef</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="rounded shadow overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('img/chef-4.jpg') }}" alt="Chef Emma Laurent">
                            <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4 mt-3">
                            <h5 class="fw-bold mb-0">Emma Laurent</h5>
                            <small>Chef Pâtissière</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->

    <!-- Testimonial Start -->
    <div class="container-xxl testimonial py-5 bg-dark wow zoomIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="owl-carousel testimonial-carousel py-5">
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>ISI BURGER a redéfini mon idée du burger parfait. Les ingrédients sont frais, le pain est fantastique et le service est toujours impeccable. Un vrai coup de cœur !</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('img/testimonial-1.jpg') }}" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Pierre Dupont</h6>
                            <small>Gourmand passionné</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>Je suis cliente régulière d'ISI BURGER et je ne suis jamais déçue. La qualité est constante, les burgers sont savoureux et l'accueil est toujours chaleureux. Bravo à toute l'équipe !</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('img/testimonial-2.jpg') }}" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Marie Lefevre</h6>
                            <small>Cliente fidèle</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>La meilleure expérience de burger de la ville, sans aucun doute. Les saveurs sont exceptionnelles, le service rapide et l'ambiance est géniale. Je recommande sans hésiter !</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('img/testimonial-3.jpg') }}" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Thomas Moreau</h6>
                            <small>Critique culinaire</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 3
                    }
                },
                autoplay: true,
                autoplayTimeout: 5000
            });
        });
    </script>
@endsection
