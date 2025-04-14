<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorBrand extends Model
{
	public $timestamps = false;
    protected $fillable = ['id','vendor_id', 'brand_id', 'is_active'];
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id', 'brand_id');
    }
}
