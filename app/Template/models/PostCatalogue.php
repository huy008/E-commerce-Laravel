<?php

namespace App\Models;

use App\Models\{Module}t;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class {Module}Catalogue extends Model
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
     protected $table = '{module}_catalogues';

     public function languages()
     {
          return $this->belongsToMany(Language::class, '{module}_catalogue_language', '{module}_catalogue_id', 'language_id')
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

     public function {module}CatalogueLanguage()
     {
          return $this->hasMany({Module}CatalogueLanguage::class, '{module}_catalogue_id', 'id');
     }
     public function {module}s()
     {
          return $this->belongsToMany({Module}::class, '{module}_catalogue_{module}', '{module}_id', '{module}_catalogue_id');
     }
     public static function isNodeCheck($id = 0)
     {
          ${module}Catalogue  = {Module}Catalogue::find($id);
          if (${module}Catalogue->right - ${module}Catalogue->left !== 1) {
               return false;
          }
          return true;
     }
}
