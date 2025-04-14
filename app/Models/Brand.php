<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $primaryKey = 'brand_id';
    public $timestamps = true;
    protected $fillable = ['brand_id','brand_name', 'is_active'];
}
