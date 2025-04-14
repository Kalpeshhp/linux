<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TailoriProductElementStyleAttributes extends Model
{
    protected $fillable = ['style_id', 'tailori_attribute_code', 'attribute_name','image'];

    public $timestamps = true;
}
