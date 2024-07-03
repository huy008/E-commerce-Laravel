<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
     use HasFactory;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'id',
          'name',
          'canonical',
     ];
     protected $table = 'permissions';
     
     public function user_catalogues()
     {
          return $this->belongsToMany(UserCatalogue::class,'user_catalogue_permission', 'permission_id', 'user_catalogue_id');
     }
  
}
