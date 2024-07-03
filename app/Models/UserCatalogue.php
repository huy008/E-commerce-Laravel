<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCatalogue extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'publish'
    ];
    public function users()
    {
        return $this->hasMany(User::class,  'user_catalogue_id', 'id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_catalogue_permission', 'user_catalogue_id', 'permission_id');
    }
}
