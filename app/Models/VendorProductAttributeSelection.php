<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProductAttributeSelection extends Model
{   
    protected $fillable = ['vendor_id', 'vendor_product_id', 'element_id', 'style_id', 'attribute_id','parent_style_name', 'style_name', 'price', 'is_active','sort_order','child_thumb_image','parent_thumb_image'];

    public $timestamps = true;

    public function elements(){
        return $this->belongsTo(TailoriProductElement::class, 'element_id', 'id');
    }

    public function attributes(){
        return $this->belongsTo(TailoriProductElementStyleAttributes::class, 'attribute_id', 'id');
    }

    public function styles(){
        return $this->belongsTo(TailoriProductElementStyle::class, 'style_id', 'id');
    }
}
