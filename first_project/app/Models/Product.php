<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'seller_id',
        'name',
        'image_url',
        'price',
        'expiration_date',
        'period_id',
        'category_id',
        'count',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
