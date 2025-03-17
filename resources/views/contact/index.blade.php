@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/contact-banner.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Contactez-nous</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">Contactez-nous</h6>
                <h1 class="mb-5">Une <span class="text-primary text-uppercase">Question</span>? Contactez-nous</h1>
            </div>
            <div class="row g-4">
                <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">Réservation</h6>
                            <div class="bg-light rounded p-3 d-flex align-items-center">
                                <div class="bg-white rounded p-2 me-3">
                                    <i class="fa fa-phone-alt text-primary"></i>
                                </div>
                                <span>+123 456 7890</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">Email</h6>
                            <div class="bg-light rounded p-3 d-flex align-items-center">
                                <div class="bg-white rounded p-2 me-3">
                                    <i class="fa fa-envelope-open text-primary"></i>
                                </div>
                                <span>info@isiburger.com</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">Suivez-nous</h6>
                            <div class="bg-light rounded p-3 d-flex align-items-center">
                                <div class="bg-white rounded p-2 me-3">
                                    <i class="fab fa-facebook-f text-primary"></i>
                                </div>
                                <span>ISI BURGER</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                    <iframe class="position-relative rounded w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                            frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                </div>
                <div class="col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
                                        <label for="name">Votre nom</label>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
                                        <label for="email">Votre email</label>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Sujet" value="{{ old('subject') }}" required>
                                        <label for="subject">Sujet</label>
                                        @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Laissez votre message ici" id="message" name="message" style="height: 150px" required>{{ old('message') }}</textarea>
                                        <label for="message">Message</label>
                                        @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Envoyer le message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Location Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">Nos restaurants</h6>
                <h1 class="mb-5">Nos <span class="text-primary text-uppercase">Emplacements</span></h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="room-item shadow rounded overflow-hidden h-100">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('img/location-1.jpg') }}" alt="Restaurant Paris">
                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">Principal</small>
                        </div>
                        <div class="p-4 mt-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">Paris</h5>
                                <div class="ps-2">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <small class="border-end me-3 pe-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Rue de Paris</small>
                                <small><i class="fa fa-phone-alt text-primary me-2"></i>+33 1 23 45 67 89</small>
                            </div>
                            <p class="text-body mb-3">Notre restaurant principal situé en plein cœur de Paris vous accueille tous les jours de 11h à 23h.</p>
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-sm btn-primary rounded py-2 px-4" href="https://maps.google.com" target="_blank">
                                    <i class="fa fa-map-marker-alt me-2"></i>Itinéraire
                                </a>
                                <a class="btn btn-sm btn-dark rounded py-2 px-4" href="tel:+33123456789">
                                    <i class="fa fa-phone-alt me-2"></i>Appeler
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="room-item shadow rounded overflow-hidden h-100">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('img/location-2.jpg') }}" alt="Restaurant Lyon">
                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">Récent</small>
                        </div>
                        <div class="p-4 mt-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">Lyon</h5>
                                <div class="ps-2">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <small class="border-end me-3 pe-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>456 Avenue de Lyon</small>
                                <small><i class="fa fa-phone-alt text-primary me-2"></i>+33 4 56 78 90 12</small>
                            </div>
                            <p class="text-body mb-3">Notre nouveau restaurant à Lyon vous propose une ambiance moderne et chaleureuse pour déguster nos burgers.</p>
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-sm btn-primary rounded py-2 px-4" href="https://maps.google.com" target="_blank">
                                    <i class="fa fa-map-marker-alt me-2"></i>Itinéraire
                                </a>
                                <a class="btn btn-sm btn-dark rounded py-2 px-4" href="tel:+33456789012">
                                    <i class="fa fa-phone-alt me-2"></i>Appeler
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="room-item shadow rounded overflow-hidden h-100">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('img/location-3.jpg') }}" alt="Restaurant Marseille">
                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">Vue mer</small>
                        </div>
                        <div class="p-4 mt-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">Marseille</h5>
                                <div class="ps-2">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star-half-alt text-primary"></small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <small class="border-end me-3 pe-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>789 Bd du Vieux Port</small>
                                <small><i class="fa fa-phone-alt text-primary me-2"></i>+33 4 91 23 45 67</small>
                            </div>
                            <p class="text-body mb-3">Profitez d'une vue imprenable sur la mer Méditerranée tout en savourant nos délicieux burgers à Marseille.</p>
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-sm btn-primary rounded py-2 px-4" href="https://maps.google.com" target="_blank">
                                    <i class="fa fa-map-marker-alt me-2"></i>Itinéraire
                                </a>
                                <a class="btn btn-sm btn-dark rounded py-2 px-4" href="tel:+33491234567">
                                    <i class="fa fa-phone-alt me-2"></i>Appeler
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Location End -->

    <!-- FAQ Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">FAQ</h6>
                <h1 class="mb-5">Questions <span class="text-primary text-uppercase">Fréquentes</span></h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.1s">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Quels sont vos horaires d'ouverture ?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Nos restaurants sont ouverts tous les jours de 11h à 23h. Le service de commande en ligne est disponible de 11h à 22h30.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Proposez-vous des options végétariennes ?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oui, nous proposons plusieurs options végétariennes dans notre menu. Nos burgers végétariens sont préparés avec des ingrédients frais et de qualité pour offrir une expérience gustative exceptionnelle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.3s">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Comment puis-je passer une commande en ligne ?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Vous pouvez passer une commande en ligne en vous rendant sur notre site web ou en utilisant notre application mobile. Créez un compte, choisissez vos produits, ajoutez-les au panier et finalisez votre commande en suivant les instructions.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Faites-vous des livraisons à domicile ?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oui, nous proposons un service de livraison à domicile dans un rayon de 5 km autour de nos restaurants. Des frais de livraison peuvent s'appliquer en fonction de la distance.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.5s">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Proposez-vous des services de traiteur pour les événements ?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oui, nous proposons des services de traiteur pour différents types d'événements : mariages, anniversaires, séminaires d'entreprise, etc. Contactez-nous pour discuter de vos besoins spécifiques et obtenir un devis personnalisé.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ End -->
@endsection
