<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    public function tailoriProducts(){
        return $this->hasOne(TailoriProduct::class, 'tailori_products_id', 'product_id');
    }
}
