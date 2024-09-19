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
        'description',
    ];
    public $discount_rate;
    public $price_with_discount;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
