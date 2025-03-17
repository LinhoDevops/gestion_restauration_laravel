<!-- auth/register.blade.php -->
@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Inscription</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Inscription</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Register Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 offset-lg-3">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <div class="bg-light rounded p-5">
                            <h4 class="section-title text-center text-burger text-uppercase mb-4">Créez votre compte</h4>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('register.post') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
                                            <label for="name">Nom complet</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
                                            <label for="email">Adresse Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required>
                                            <label for="password">Mot de passe</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmez votre mot de passe" required>
                                            <label for="password_confirmation">Confirmer le mot de passe</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="role" value="client">
                                    <div class="col-12">
                                        <button class="btn btn-burger w-100 py-3" type="submit">S'inscrire</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="mb-0">Vous avez déjà un compte? <a href="{{ route('login') }}" class="text-burger">Connectez-vous</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register End -->
@endsection
