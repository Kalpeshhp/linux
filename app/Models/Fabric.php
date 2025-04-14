<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    // protected $fillable = ['id','vendor_key', 'tailori_fabric_code', 'fabric_name', 'product_type', 'wear_type', 'description', 'price', 'fabric_image', 'color', 'thumbnail_image', 'bestfit_image', 'original_image', 'design_pattern', 'fabric_blend','brand']; // pravesh commented old table
    protected $fillable = ['fabric_id','vendor_key', 'tailori_fabric_code', 'fabric_name', 'product_type','brand','wear_type','color','design_pattern','fabric_blend', 'description','price','sort_order','thumbnail_image', 'bestfit_image', 'original_image'];

    public $timestamps = true;

    public function fabric(){
        return $this->belongsTo(Fabric::class, 'fabric_id', 'fabric_id');
    }

    public function vendorFabrics(){
        return $this->belongsTo(VendorFabric::class, 'fabric_id', 'fabric_id')->where('vendor_id', auth()->user()->vendor_id);
    }
}
