<!-- components/header.blade.php -->
<div class="container-fluid bg-dark px-0">
    <div class="row gx-0">
        <div class="col-lg-3 bg-dark d-none d-lg-block">
            <a href="{{ route('home') }}" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                <h1 class="m-0 text-burger burger-title">ISI BURGER</h1>
            </a>
        </div>
        <div class="col-lg-9">
            <div class="row gx-0 bg-white d-none d-lg-flex">
                <div class="col-lg-7 px-5 text-start">
                    <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                        <i class="fa fa-envelope text-burger me-2"></i>
                        <p class="mb-0">info@isiburger.com</p>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center py-2">
                        <i class="fa fa-phone-alt text-burger me-2"></i>
                        <p class="mb-0">+221 76 123 4567</p>
                    </div>
                </div>
                <div class="col-lg-5 px-5 text-end">
                    <div class="d-inline-flex align-items-center py-2">
                        <a class="me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="me-3" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="me-3" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="" href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                <a href="{{ route('home') }}" class="navbar-brand d-block d-lg-none">
                    <h1 class="m-0 text-burger burger-title">ISI BURGER</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        @guest
                            <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
                        @endguest

                        @auth
                            @if(auth()->user()->hasRole('client'))
                                <a href="{{ route('client.catalog') }}" class="nav-item nav-link {{ request()->routeIs('client.catalog') ? 'active' : '' }}">Menu</a>
                                <a href="{{ route('client.cart') }}" class="nav-item nav-link {{ request()->routeIs('client.cart') ? 'active' : '' }}">Panier</a>
                                <a href="{{ route('client.orders') }}" class="nav-item nav-link {{ request()->routeIs('client.orders') ? 'active' : '' }}">Mes Commandes</a>
                            @elseif(auth()->user()->hasRole('gestionnaire'))
                                <a href="{{ route('gestionnaire.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('gestionnaire.dashboard') ? 'active' : '' }}">Dashboard</a>
                                <a href="{{ route('gestionnaire.products.index') }}" class="nav-item nav-link {{ request()->routeIs('gestionnaire.products.*') ? 'active' : '' }}">Produits</a>
                                <a href="{{ route('gestionnaire.orders.index') }}" class="nav-item nav-link {{ request()->routeIs('gestionnaire.orders.*') ? 'active' : '' }}">Commandes</a>
                                <a href="{{ route('gestionnaire.payments.index') }}" class="nav-item nav-link {{ request()->routeIs('gestionnaire.payments.*') ? 'active' : '' }}">Paiements</a>
                                <a href="{{ route('gestionnaire.stats.index') }}" class="nav-item nav-link {{ request()->routeIs('gestionnaire.stats.*') ? 'active' : '' }}">Statistiques</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="nav-item nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Connexion</a>
                            <a href="{{ route('register') }}" class="nav-item nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Inscription</a>
                        @endauth
                    </div>

                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-burger rounded-0 py-4 px-md-5 d-none d-lg-block">
                                {{ auth()->user()->name }} <i class="fa fa-sign-out-alt ms-3"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-burger rounded-0 py-4 px-md-5 d-none d-lg-block">Connexion <i class="fa fa-arrow-right ms-3"></i></a>
                    @endauth
                </div>
            </nav>
        </div>
    </div>
</div>
