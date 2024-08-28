<?php

namespace App\Models;

use App\Models\Productt;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCatalogue extends Model
{
     use HasFactory, SoftDeletes;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'parentid',
          'image',
          'publish',
          'follow',
          'user_id',
          'left',
          'right',
          'level',
          'album',
          'image',
     ];
     protected $table = 'product_catalogues';

     public function languages()
     {
          return $this->belongsToMany(Language::class, 'product_catalogue_language', 'product_catalogue_id', 'language_id')
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

     public function product_catalogue_language()
     {
          return $this->hasMany(ProductCatalogueLanguage::class, 'product_catalogue_id', 'id');
     }
     public function products()
     {
          return $this->belongsToMany(Product::class, 'product_catalogue_product', 'product_id', 'product_catalogue_id');
     }
     public static function isNodeCheck($id = 0)
     {
          $productCatalogue  = ProductCatalogue::find($id);
          if ($productCatalogue->right - $productCatalogue->left !== 1) {
               return false;
          }
          return true;
     }
}
