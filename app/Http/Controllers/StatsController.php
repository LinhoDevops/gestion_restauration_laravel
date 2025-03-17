<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
  // Nombre de commandes par jour
    public function dailyOrders()
    {
        $stats = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($stats);
    }

    // Nombre de commandes par mois
    public function monthlyOrders()
    {
        $stats = Order::select(DB::raw('YEAR(created_at) as annee'), DB::raw('MONTH(created_at) as mois'), DB::raw('count(*) as total'))
            ->groupBy('annee', 'mois')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

        return response()->json($stats);
    }

    public function dailyRevenue()
    {
        $stats = Payment::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($stats);
    }

    public function monthlyRevenue()
    {
        $stats = Payment::select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return response()->json($stats);
    }
}
