<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TailoriProduct extends Model
{
    protected $primaryKey = 'tailori_products_id';
    protected $fillable = ['tailori_products_id','tailori_product_code', 'product_name'];

    public $timestamps = true;

    public function productElements(){
        return $this->hasMany(TailoriProductElement::class, 'product_id', 'id')->where('is_active', 1);
    }
    public function tailoriProducts()
    {
        return $this->belongsTo(TailoriProduct::class, 'tailori_products_id');
    }
}
