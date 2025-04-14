<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Fabric;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Config, Log;

class TailoriFabricSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $appKey;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appKey)
    {
        $this->appKey = $appKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $client = new Client;
        $request = $client->get(Config::get('constants.SWATCH_API_URL').'Key='. $this->appKey);
        $fabrics = json_decode($request->getBody()->getContents(), true);

        foreach($fabrics as $fabric){
            
            if( $fabric['LibraryName'] == 'SHIRT' || $fabric['LibraryName'] == 'SHIRT SPECIFIC' ){
                $fabric['LibraryName'] = 'Shirt';
                $fabricWearType = 'men';
            }
            else if( $fabric['LibraryName'] == 'ARAB JACKET' || $fabric['LibraryName'] == 'JACKET SPECIFIC' ){
                $fabric['LibraryName'] = 'Jacket';
                $fabricWearType = 'men';
            }
            else if( $fabric['LibraryName'] == 'SUIT' || $fabric['LibraryName'] == 'SUIT SPECIFIC'){
                $fabric['LibraryName'] = 'Suit';
                $fabricWearType = 'men';
            }
            else if( $fabric['LibraryName'] == 'TROUSER' ){
                $fabric['LibraryName'] = 'Trouser';
                $fabricWearType = 'men';
            }
            else if( $fabric['LibraryName'] == 'WOMENSHIRT' ){
                $fabric['LibraryName'] = 'Women Shirt';
                $fabricWearType = 'women';
            }
            else if( $fabric['LibraryName'] == 'WOMENSUIT' ){
                $fabric['LibraryName'] = 'Women Suit';
                $fabricWearType = 'women';
            }
            else if( $fabric['LibraryName'] == 'POLO SHIRT' ){
                $fabric['LibraryName'] = 'Polo Shirt';
                $fabricWearType = 'men';
            }
            else if( $fabric['LibraryName'] == 'INNERLINING' ){
                $fabric['LibraryName'] = 'Innerlining';
                $fabricWearType = NULL;
            }
            else if( $fabric['LibraryName'] == 'JACKET' ){
                $fabric['LibraryName'] = 'Jacket';
                $fabricWearType = 'men';
            }
            else if( $fabric['LibraryName'] == 'TIE' ){
                $fabric['LibraryName'] = 'Tie';
                $fabricWearType = NULL;
            }
            else if( $fabric['LibraryName'] == 'SHIRT_CONTRAST' ){
                $fabric['LibraryName'] = 'shirt-contrast';
                $fabricWearType = NULL;
            }
            else{
                $fabric['LibraryName'] = NULL;
                $fabricWearType = NULL;
            }
           
            Fabric::updateOrCreate([ 'tailori_fabric_code' => $fabric['Id']], [
                'tailori_fabric_code' => $fabric['Id'],
                'fabric_name' => $fabric['Name'],
                'product_type' => $fabric['LibraryName'],
                'brand' => isset($fabric['BRAND'])?$fabric['BRAND']:'',
                'wear_type' => $fabricWearType,
                'color' => isset($fabric['COLOUR'])?$fabric['COLOUR']:'',
                'fabric_blend' => array_key_exists("BLEND",$fabric)?$fabric['BLEND']:NULL,
                'design_pattern' => array_key_exists("DESIGN",$fabric)?$fabric['DESIGN']:NULL,
                'price' => 0,
                'thumbnail_image' => $fabric['ThumbPath'],
                'bestfit_image' => $fabric['BestfitPath'],
                'original_image' => $fabric['FabricPath']
            ]);
        }
    }
}
