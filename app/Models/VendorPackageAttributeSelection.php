<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPackageAttributeSelection extends Model
{   
    protected $fillable = ['vendor_id', 'package_id', 'element_id', 'style_id', 'attribute_id', 'style_name', 'price', 'is_active','sort_order'];

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
