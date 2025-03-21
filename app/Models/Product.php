<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'image', 'stock', 'is_active'
    ];

    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::url('products/' . basename($this->image))
            : asset('img/placeholder.jpg');
    }
}
