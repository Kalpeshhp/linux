<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TailoriProductElement extends Model
{
    // protected $fillable = ['tailori_element_code', 'product_id', 'element_name']; commented for old

    protected $fillable = ['tailori_element_code', 'product_id', 'element_name','image_url','sort_order'];

    public $timestamps = true;

    public function elementStyles(){
        return $this->hasMany(TailoriProductElementStyle::class, 'element_id', 'id')->where('is_active', 1);
    }
}
