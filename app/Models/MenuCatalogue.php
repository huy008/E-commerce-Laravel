<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuCatalogue extends Model
{
     use HasFactory, SoftDeletes;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
          'name',
          'keyword',
          'publish'
     ];
   
}
