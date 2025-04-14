<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $primaryKey = 'subscription_id'; 
    protected $fillable = ['vendor_id','fabric_limit', 'start_date', 'end_date', 'duration_in_months', 'islatest', 'version'];
    protected $table = 'subscription';
    public $timestamps = true;
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id','vendor_id');
    }
}
