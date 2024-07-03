<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class {Module} extends Model
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
     protected $table = '{module}s';

     public function languages()
     {
          return $this->belongsToMany(Language::class, '{module}_language','{module}_id', 'language_id')
               ->withPivot(
                    'name',
                    'canonical',
                    'meta_title',
                    'meta_keyword',
                    'meta_description',
                    'content',
                    'description',
                    '{module}_catalogue_id'
               )->withTimestamps();
     }

     public function {module}_catalogues()
     {
          return $this->belongsToMany( {Module}Catalogue::class, '{module}_catalogue_{module}', '{module}_id', '{module}_catalogue_id');
     }
}
