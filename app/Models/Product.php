<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'description', 
        'price', 
        'discount', 
        'quantity', 
        'product_image_path'
    ];

}
