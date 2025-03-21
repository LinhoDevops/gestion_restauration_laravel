@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/burger-bg.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Tableau de bord</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Tableau de bord</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Dashboard Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-light rounded p-4 text-center">
                        <i class="fa fa-clipboard-list fa-3x text-burger mb-3"></i>
                        <h4 id="orderCount">0</h4>
                        <h6 class="mb-0">Commandes aujourd'hui</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-light rounded p-4 text-center">
                        <i class="fa fa-check-circle fa-3x text-burger mb-3"></i>
                        <h4 id="completedOrders">0</h4>
                        <h6 class="mb-0">Commandes finalisées</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded p-4 text-center">
                        <i class="fa fa-hamburger fa-3x text-burger mb-3"></i>
                        <h4 id="productCount">0</h4>
                        <h6 class="mb-0">Produits en stock</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="bg-light rounded p-4 text-center">
                        <i class="fa fa-money-bill-wave fa-3x text-burger mb-3"></i>
                        <h4 id="totalRevenue">0 FCFA</h4>
                        <h6 class="mb-0">Revenus du jour</h6>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                                <h4 class="mb-4">Commandes récentes</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Client</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="recentOrders">
                                        <!-- Chargement dynamique via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ route('gestionnaire.orders.index') }}" class="btn btn-burger">Voir toutes les commandes</a>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                                <h4 class="mb-4">Produits à faible stock</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Prix</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="lowStockProducts">
                                        <!-- Chargement dynamique via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ route('gestionnaire.products.index') }}" class="btn btn-burger">Gérer les produits</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                                <h4 class="mb-4">Notifications</h4>
                                <div id="notificationList" class="overflow-auto" style="max-height: 300px;">
                                    <!-- Chargement dynamique via AJAX -->
                                </div>
                                <button id="markAllAsRead" class="btn btn-burger mt-3">Marquer tout comme lu</button>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                                <h4 class="mb-4">Actions rapides</h4>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('gestionnaire.products.create') }}" class="btn btn-burger py-3">
                                        <i class="fas fa-plus me-2"></i>Ajouter un produit
                                    </a>
                                    <a href="{{ route('gestionnaire.orders.index') }}" class="btn btn-burger py-3">
                                        <i class="fas fa-clipboard-list me-2"></i>Gérer les commandes
                                    </a>
                                    <a href="{{ route('gestionnaire.stats.index') }}" class="btn btn-burger py-3">
                                        <i class="fas fa-chart-bar me-2"></i>Voir les statistiques
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard End -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Charger les données du tableau de bord
            loadDashboardData();

            // Actualiser les données toutes les 60 secondes
            setInterval(loadDashboardData, 60000);

            // Marquer toutes les notifications comme lues
            $('#markAllAsRead').click(function() {
                $.ajax({
                    url: '{{ route("gestionnaire.notifications.read") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        loadDashboardData();
                    }
                });
            });

            function loadDashboardData() {
                // Charger les statistiques
                $.ajax({
                    url: '{{ route("gestionnaire.stats.orders.daily") }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.length > 0) {
                            $('#orderCount').text(response[0].total || 0);
                        }
                    }
                });

                $.ajax({
                    url: '{{ route("gestionnaire.stats.revenue.daily") }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.length > 0) {
                            $('#totalRevenue').text(formatPrice(response[0].total_revenue || 0) + ' FCFA');
                        }
                    }
                });

                // Charger le nombre de produits en stock
                $.ajax({
                    url: '{{ route("gestionnaire.products.index") }}',
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        let inStockCount = 0;
                        let lowStockHtml = '';

                        response.data.forEach(function(product) {
                            if (product.stock > 0) {
                                inStockCount++;
                            }

                            if (product.stock <= 5 && product.stock > 0) {
                                lowStockHtml += `
                                <tr>
                                    <td>${product.name}</td>
                                    <td>${formatPrice(product.price)} FCFA</td>
                                    <td><span class="badge bg-warning">${product.stock}</span></td>
                                    <td>
                                        <a href="{{ url('/gestionnaire/products') }}/${product.id}/edit" class="btn btn-sm btn-burger">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            `;
                            }
                        });

                        $('#productCount').text(inStockCount);

                        if (lowStockHtml === '') {
                            lowStockHtml = '<tr><td colspan="4" class="text-center">Aucun produit en stock faible</td></tr>';
                        }

                        $('#lowStockProducts').html(lowStockHtml);
                    }
                });

                // Charger les commandes récentes
                $.ajax({
                    url: '{{ route("gestionnaire.orders.index") }}',
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        let recentOrdersHtml = '';
                        let completedCount = 0;

                        const recentOrders = response.data.slice(0, 5);

                        recentOrders.forEach(function(order) {
                            if (order.status === 'payée') {
                                completedCount++;
                            }

                            const statusClass = {
                                'en_attente': 'bg-warning',
                                'en_préparation': 'bg-info',
                                'prête': 'bg-success',
                                'payée': 'bg-primary'
                            };

                            const statusText = {
                                'en_attente': 'En attente',
                                'en_préparation': 'En préparation',
                                'prête': 'Prête',
                                'payée': 'Payée'
                            };

                            recentOrdersHtml += `
                            <tr>
                                <td>#${order.id}</td>
                                <td>${order.user.name}</td>
                                <td>${formatPrice(order.total_price)} FCFA</td>
                                <td><span class="badge ${statusClass[order.status] || 'bg-secondary'}">${statusText[order.status] || order.status}</span></td>
                                <td>${formatDate(order.created_at)}</td>
                                <td>
                                    <a href="{{ url('/gestionnaire/orders') }}/${order.id}" class="btn btn-sm btn-burger">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                        });

                        $('#completedOrders').text(completedCount);

                        if (recentOrdersHtml === '') {
                            recentOrdersHtml = '<tr><td colspan="6" class="text-center">Aucune commande récente</td></tr>';
                        }

                        $('#recentOrders').html(recentOrdersHtml);
                    }
                });

                // Charger les notifications
                $.ajax({
                    url: '{{ route("gestionnaire.notifications") }}',
                    type: 'GET',
                    success: function(response) {
                        let notificationsHtml = '';

                        if (response.length === 0) {
                            notificationsHtml = '<div class="text-center py-3">Aucune notification</div>';
                        } else {
                            response.forEach(function(notification) {
                                const readClass = notification.read_at ? 'bg-light' : 'bg-light border-start border-4 border-burger';
                                const dateFormatted = formatDate(notification.created_at);

                                notificationsHtml += `
                                <div class="mb-3 p-3 ${readClass} rounded">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">Nouvelle commande</h6>
                                        <small>${dateFormatted}</small>
                                    </div>
                                    <p class="mb-1">${notification.data.message}</p>
                                    <a href="{{ url('/gestionnaire/orders') }}/${notification.data.order_id}" class="text-burger">Voir la commande</a>
                                </div>
                            `;
                            });
                        }

                        $('#notificationList').html(notificationsHtml);
                    }
                });
            }

            function formatPrice(price) {
                return new Intl.NumberFormat('fr-FR').format(price);
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('fr-FR') + ' ' + date.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'});
            }
        });
    </script>
@endpush
