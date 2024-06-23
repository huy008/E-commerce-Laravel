<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Router extends Model
{
     use HasFactory;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'canonical',
          'controllers',
          'module_id'
     ];
     protected $table = 'routers';
     protected $primaryKey = 'code';
     public $incrementing = false;
    
}
