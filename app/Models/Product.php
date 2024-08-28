<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
     use HasFactory, SoftDeletes;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'publish',
          'follow',
          'user_id',
          'album',
          'level',
          'image',
     ];
     protected $table = 'products';

     public function languages()
     {
          return $this->belongsToMany(Language::class, 'product_language','product_id', 'language_id')
               ->withPivot(
                    'name',
                    'canonical',
                    'meta_title',
                    'meta_keyword',
                    'meta_description',
                    'content',
                    'description',
               )->withTimestamps();
     }

     public function product_catalogues()
     {
          return $this->belongsToMany( ProductCatalogue::class, 'product_catalogue_product', 'product_id', 'product_catalogue_id');
     }
     public function product_variants()
     {
          return $this->hasMany(ProductVariant::class, 'product_id', 'id');
     }
}
