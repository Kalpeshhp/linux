<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorFabric extends Model
{
    protected $fillable = ['vendor_id', 'fabric_id', 'fabric_name', 'description', 'price', 'is_active','sort_order'];

    public $timestamps = true;

    public function fabric(){
        return $this->belongsTo(Fabric::class, 'fabric_id', 'fabric_id');
    }
}
