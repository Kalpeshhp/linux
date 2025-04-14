<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function packageProducts(){
        return $this->hasMany(PackageProduct::class, 'package_id', 'id');
    }

    public function users(){
        return $this->belongsToMany('App\User')->using('App\Models\UserPackage');
    }
}
