<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;
use App\Models\Fabric;
use App\Models\VendorFabric;
use GuzzleHttp\Client;
use Config, Log;
use App\User;
class FabricJobNew 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $requestData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client;

        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'body'=> json_encode($this->requestData)
        ];
        $url = Config::get('constants.API_URL').'MultiDeleteImg';
        $request = $client->request('POST', $url, $options);

        $response = $request->getBody()->getContents();

        $response = json_decode($response, true);
        return true;
        // if($response[0]['IsSave'] == true)
        // {
        //     $requestDataArr = $this->requestData[0];
        //     $fabric = new Fabric;
        //     $fabric->vendor_key = $requestDataArr['key'];
        //     $fabric->tailori_fabric_code =$response[0]['Id'][0];
        //     $fabric->original_image =$response[0]['Id'][1];
        //     $fabric->thumbnail_image =$response[0]['Id'][2];
        //     $fabric->bestfit_image =$response[0]['Id'][3];
        //     $fabric->fabric_name  = $requestDataArr['imageName'];
        //     $fabric->product_type = $requestDataArr['libraryName'];
        //     $fabric->wear_type ='men';
        //     $fabric->color = $requestDataArr['propertyValues']['COLOUR'];
        //     $fabric->brand = $requestDataArr['propertyValues']['brand'];
        //     $fabric->design_pattern = $requestDataArr['propertyValues']['DESIGN'];
        //     $fabric->fabric_blend = $requestDataArr['propertyValues']['blend'];
        //     $fabric->description = $requestDataArr['description'];
        //     $fabric->price = isset($requestDataArr['price'])?$requestDataArr['price']:0;

        //     $fabric->save();

        //     if($fabric->id>0)
        //     {
        //         $vendorFebric = new VendorFabric;
        //         $vendorFebric->vendor_id  = Auth::user()->id;
        //         $vendorFebric->fabric_id  = $fabric->id;
        //         $vendorFebric->fabric_name  = $requestDataArr['imageName'];
        //         $vendorFebric->description  = $requestDataArr['description'];
        //         $vendorFebric->price        = isset($requestDataArr['price'])?$requestDataArr['price']:0;
        //         $vendorFebric->is_active    = 0;

        //         $vendorFebric->save();

        //         User::find(Auth::user()->id)->decrement('fabric_upload_limit');
        //     }
        //     return true;
        // }
        // else
        // {
        //    return false;
        // }
    }
}
