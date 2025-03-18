<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;

    protected $fillable = ['order_id', 'amount', 'paid_at'];

    // Ajouter casts pour convertir paid_at en objet Carbon
    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
