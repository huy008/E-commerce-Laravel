<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
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
          'attribute_catalogue_id'
     ];
     protected $table = 'attributes';

     public function languages()
     {
          return $this->belongsToMany(Language::class, 'attribute_language', 'attribute_id', 'language_id')
               ->withPivot(
                    'name',
                    'canonical',
                    'meta_title',
                    'meta_keyword',
                    'meta_description',
                    'content',
                    'description',
                    'attribute_catalogue_id'
               )->withTimestamps();
     }

     public function attribute_catalogues()
     {
          return $this->belongsToMany(AttributeCatalogue::class, 'attribute_catalogue_attribute', 'attribute_id', 'attribute_catalogue_id');
     }
     public function attribute_language()
     {
          return $this->hasMany(AttributeLanguage::class, 'attribute_id');
     }
}
