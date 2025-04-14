<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendAccountActivateEmailJob;
use App\Jobs\SendEmailJob;
use GuzzleHttp\Client;
use Hash;
use Config;
use App\User;
use App\Models\Vendor;
use App\Models\UserPackage;
use App\Models\Package;
use App\Models\Brand;
use App\Models\VendorBrand;
use App\Models\VendorProduct;
use App\Models\TailoriProduct;

class VendorJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $options;
    private $addressParams;
    private $isRegistered;
    private $vendorId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($options, $addressParams, $isRegistered, $vendorId)
    {
        $this->options = $options;
        $this->addressParams = $addressParams;
        $this->isRegistered = $isRegistered;
        $this->vendorId = $vendorId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   

        $userRecord = json_decode($this->options['body'], true);
            
        $client = new Client;

        $url = Config::get('constants.API_URL').'AddUser';
        
        if($this->isRegistered == 0){

            $request = $client->request('POST', $url, $this->options);

            $response = $request->getBody()->getContents();
        
            $response = json_decode($response, true);

            if(array_key_exists('Username', $response) && array_key_exists('Key', $response)){
    
                $userRecord = json_decode($this->options['body'], true);
   
                $vendor = new Vendor;
              
                $vendor->contact_number = $userRecord['phone'];

                $vendor->store_url = $userRecord['StoreURL'];

                $vendor->username = $userRecord['UserName'];
    
                $vendor->user_uid = $response['Key'];
    
                $vendor->city = $this->addressParams['city'];
                
                $vendor->state = $this->addressParams['state'];
                
                $vendor->pincode = $this->addressParams['pincode'];
                
                $vendor->address = $this->addressParams['address'];
    
                $vendor->store_name = $this->addressParams['store_name'];

                $vendor->fabric_upload_limit = 50;

                $vendor -> status = 1;

                $vendor->save();

                $user = new User;

                $user->name = $userRecord['Forename'].' '.$userRecord['Surname'];
    
                $user->email = $userRecord['Email'];

                $user->password = $userRecord['PasswordHash'];
                
                $user->vendor_id = $vendor->vendor_id;

                $user->save();

                $brand = Brand::create([
                    'brand_name' => $vendor-> username,
                    'is_active' => 1
                ]);

                $vendorBrand = VendorBrand::create([
                    'vendor_id' => $user->vendor_id,
                    'brand_id' => $brand-> brand_id,
                    'is_active' => 1
                ]);

                $vendorProductid = TailoriProduct::where('product_name', 'Shirt')->value('tailori_products_id');

                $vendorProducts = VendorProduct::create([
                    'vendor_id' => $user->vendor_id,
                    'tailori_products_id' => $vendorProductid,
                    'is_active' => 1,
                    'element_limit' =>10,
                    'style_limit' => 10,
                    'attribute_limit' => 10,
                    'fabric_limit' => $vendor->fabric_upload_limit
                ]);

                $details= array('email'=> $userRecord['Email'],'name'=>$userRecord['Forename'],'password'=>$userRecord['PasswordHash']);

                dispatch(new SendEmailJob($details));

            }
        }
        else if($this->isRegistered == 1){
            
            $request = $client->request('POST', $url, $this->options);

            $response = $request->getBody()->getContents();
        
            $response = json_decode($response, true);
            
            User::where('id', $this->vendorId)->update(['user_uid' => $response['Key'], 'status' => 1 ]);

            dispatch(new SendAccountActivateEmailJob($this->vendorId));
        }  
    }
}
