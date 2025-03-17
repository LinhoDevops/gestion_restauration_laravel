<!-- gestionnaire/stats/index.blade.php -->
@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Statistiques</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestionnaire.dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Statistiques</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Stats Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('components.sidebar')
                </div>

                <!-- Content -->
                <div class="col-lg-9">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                                <h4 class="mb-4">Commandes par mois</h4>
                                <canvas id="monthlyOrdersChart"></canvas>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                                <h4 class="mb-4">Revenus par mois</h4>
                                <canvas id="monthlyRevenueChart"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.5s">
                                <h4 class="mb-4">Commandes par jour (cette semaine)</h4>
                                <canvas id="dailyOrdersChart"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.7s">
                                <h4 class="mb-4">Revenus par jour (cette semaine)</h4>
                                <canvas id="dailyRevenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Stats End -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

            // Charger les données des commandes mensuelles
            $.ajax({
                url: '{{ route("gestionnaire.stats.orders.monthly") }}',
                type: 'GET',
                success: function(data) {
                    const labels = [];
                    const values = [];

                    data.forEach(function(item) {
                        labels.push(months[item.mois - 1] + ' ' + item.annee);
                        values.push(item.total);
                    });

                    createChart('monthlyOrdersChart', 'bar', labels, values, 'Nombre de commandes', 'rgb(255, 107, 53)', 'rgba(255, 107, 53, 0.2)');
                }
            });

            // Charger les données des revenus mensuels
            $.ajax({
                url: '{{ route("gestionnaire.stats.revenue.monthly") }}',
                type: 'GET',
                success: function(data) {
                    const labels = [];
                    const values = [];

                    data.forEach(function(item) {
                        labels.push(months[item.month - 1] + ' ' + item.year);
                        values.push(item.total_revenue);
                    });

                    createChart('monthlyRevenueChart', 'bar', labels, values, 'Revenus (FCFA)', 'rgb(75, 192, 192)', 'rgba(75, 192, 192, 0.2)');
                }
            });

            // Charger les données des commandes quotidiennes
            $.ajax({
                url: '{{ route("gestionnaire.stats.orders.daily") }}',
                type: 'GET',
                success: function(data) {
                    const labels = [];
                    const values = [];

                    // Prendre les 7 derniers jours
                    const recentData = data.slice(0, 7).reverse();

                    recentData.forEach(function(item) {
                        const date = new Date(item.date);
                        labels.push(date.toLocaleDateString('fr-FR'));
                        values.push(item.total);
                    });

                    createChart('dailyOrdersChart', 'line', labels, values, 'Nombre de commandes', 'rgb(255, 107, 53)', 'rgba(255, 107, 53, 0.2)');
                }
            });

            // Charger les données des revenus quotidiens
            $.ajax({
                url: '{{ route("gestionnaire.stats.revenue.daily") }}',
                type: 'GET',
                success: function(data) {
                    const labels = [];
                    const values = [];

                    // Prendre les 7 derniers jours
                    const recentData = data.slice(0, 7).reverse();

                    recentData.forEach(function(item) {
                        const date = new Date(item.date);
                        labels.push(date.toLocaleDateString('fr-FR'));
                        values.push(item.total_revenue);
                    });

                    createChart('dailyRevenueChart', 'line', labels, values, 'Revenus (FCFA)', 'rgb(75, 192, 192)', 'rgba(75, 192, 192, 0.2)');
                }
            });

            function createChart(canvasId, type, labels, values, label, borderColor, backgroundColor) {
                const ctx = document.getElementById(canvasId).getContext('2d');

                new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: values,
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: true
                    }
                });
            }
        });
    </script>
@endpush
