<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
     use HasFactory, SoftDeletes;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'name',
          'canonical',
          'image',
          'description',
          'publish',
          'user_id'
     ];
     protected $table = 'languages';
     protected $primaryKey = 'code';
     public $incrementing = false;
     public function languages()
     {
          return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'language_id', 'post_catalogue_id')
               ->withPivot(
                    'name',
                    'canonical',
                    'meta_title',
                    'meta_keyword',
                    'meta_description',
                    'content',
                    'description'
               )->withTimestamps();
     }
}
