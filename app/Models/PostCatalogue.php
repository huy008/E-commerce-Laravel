<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostCatalogue extends Model
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
          'icon'
     ];
     protected $table = 'post_catalogues';

     public function languages()
     {
          return $this->belongsToMany(Language::class, 'post_catalogue_language', 'post_catalogue_id', 'language_id')
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

     public function postCatalogueLanguage()
     {
          return $this->hasMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
     }
     public function posts()
     {
          return $this->belongsToMany(Post::class, 'post_catalogue_post', 'post_id', 'post_catalogue_id');
     }
     public static function isNodeCheck($id = 0)
     {
          $postCatalogue  = PostCatalogue::find($id);
          if ($postCatalogue->right - $postCatalogue->left !== 1) {
               return false;
          }
          return true;
     }
}
