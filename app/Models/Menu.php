<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
     use HasFactory, SoftDeletes;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'menu_catalogue_id',
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
     public function languages()
     {
          return $this->belongsToMany(Language::class, 'menu_language', 'menu_id', 'language_id')
          ->withPivot(
               'menu_id',
               'language_id',
               'name',
               'canonical',
          )->withTimestamps();
     }
}
