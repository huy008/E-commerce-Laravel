<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
     use HasFactory, SoftDeletes;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'product_id',
          'code',
          'quantity',
          'sku',
          'price',
          'barcode',
          'file_name',
          'file_url',
          'album',
          'publish',
          'user_id',
     ];
     protected $table = 'product_variants';

     public function languages()
     {
          return $this->belongsToMany(Language::class, 'product_variant_language', 'product_variant_id', 'language_id')
          ->withPivot(
               'name',
          )->withTimestamps();
     }

     public function products()
     {
          return $this->belongsTo(Product::class, 'product_id', 'id');
     }
}
