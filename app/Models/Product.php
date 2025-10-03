<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id','pokemon_name','card_name','grader','grade','set_name','card_number',
        'release_year','edition','rarity','holofoil_type','art_style','artist_name',
        'language','collector_info','price','stock','image_url'
    ];

    public function category() {
    // FK is 'category_id' (not the default 'product_category_id')
    return $this->belongsTo(ProductCategory::class, 'category_id');
    }
} 