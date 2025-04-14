<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TailoriProductElementStyle extends Model
{
    // protected $fillable = ['tailori_style_code', 'style_name', 'element_id']; commented for old
    protected $fillable = ['tailori_style_code', 'style_name', 'element_id'];

    public $timestamps = true;

    public function styleAttributes(){
        return $this->hasMany(TailoriProductElementStyleAttributes::class, 'style_id', 'id')->where('is_active', 1);
    }
}
