<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    protected $fillable = ['user_id', 'package_id'];
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function package(){
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
    public function packageProduct(){
        return $this->hasMany(PackageProduct::class, 'package_id', 'id');
    }
}
