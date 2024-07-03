<?php

namespace App\Models;

use App\Models\Attributet;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeCatalogue extends Model
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
          'image', 'icon'
     ];
     protected $table = 'attribute_catalogues';

     public function languages()
     {
          return $this->belongsToMany(Language::class, 'attribute_catalogue_language', 'attribute_catalogue_id', 'language_id')
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

     public function attributeCatalogueLanguage()
     {
          return $this->hasMany(AttributeCatalogueLanguage::class, 'attribute_catalogue_id', 'id');
     }
     public function attributes()
     {
          return $this->belongsToMany(Attribute::class, 'attribute_catalogue_attribute', 'attribute_id', 'attribute_catalogue_id');
     }
     public static function isNodeCheck($id = 0)
     {
          $attributeCatalogue  = AttributeCatalogue::find($id);
          if ($attributeCatalogue->right - $attributeCatalogue->left !== 1) {
               return false;
          }
          return true;
     }
}
