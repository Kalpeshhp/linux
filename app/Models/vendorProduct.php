<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProduct extends Model
{
        protected $fillable = [
        'vendor_id',
        'tailori_products_id',
        'element_limit',
        'style_limit',
        'attribute_limit',
        'fabric_limit',
        'is_active',
    ];

    public $timestamps = true;

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function productElements()
    {
        return $this->belongsTo(TailoriProduct::class);
    }
    public function tailoriProducts(){
        return $this->hasOne(TailoriProduct::class, 'tailori_products_id', 'product_id');
    }
}
