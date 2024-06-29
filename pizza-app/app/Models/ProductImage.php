<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'priority',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
