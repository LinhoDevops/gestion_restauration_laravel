<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'items', 'total_price', 'status'];

    // Permet de convertir automatiquement le champ items de JSON à tableau et vice-versa
    protected $casts = [
        'items' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
