<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\User;
class Vendor extends Model
{
   
    protected $fillable = [
        'vendor_id','user_uid','username','contact_number','address','city','state','pincode','store_name', 'store_url', 'plugin_ui', 'store_ui','fabric_upload_limit'
    ];
    public  $timestamps = true;

    protected $table = 'vendors';

	protected  $primaryKey = 'vendor_id';
    protected $connection = 'mysql';

    protected $casts = [
        'status' => 'boolean',
    ];
    protected function getUserUId(){
        return $this->user_uid;
    }

    public function users()
    {
        return $this->hasMany(User::class, 'vendor_id');
    }
}

