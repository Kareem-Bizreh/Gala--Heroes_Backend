<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $fillable = [
        'more_period',
        'more_percent',
        'between_percent',
        'less_period',
        'less_percent'
    ];
}
