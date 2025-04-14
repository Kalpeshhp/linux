<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Config, Log;
use App\Models\TailoriProductElementStyleAttributes;

class TailoriStyleImageSyncJob implements ShouldQueue
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
        $prodArr = ['Men-Shirt','Men-Trouser','Men-Jacket','Men-Suit'];
        foreach($prodArr as $val)
        {
            $request = $client->get(Config::get('constants.TAILORI_PRODUCT_ELEMENT_IMAGES').$val.'/'.$this->appKey);
            
            $productImages = json_decode($request->getBody()->getContents(), true);

            foreach($productImages['Product'] as $productImage){
                
                foreach($productImage['Options'] as $image){
                    
                    foreach($image['Features'] as $attributeImages){
                        $updateImage = TailoriProductElementStyleAttributes::where('tailori_attribute_code', $attributeImages['Id'])->update(['image'=> $attributeImages['ImageSource']]);
                    }
                }
            }
            //Monogram Placement
            foreach($productImages['MonogramPlacement'] as $monogramPlacement){
                
                $updateImage = TailoriProductElementStyleAttributes::where('tailori_attribute_code', $monogramPlacement['Id'])->update(['image'=> $monogramPlacement['ImageSource']]);
            }
            // MonogramFont
            foreach($productImages['MonogramFont'] as $monogramFont){
                
                $updateImage = TailoriProductElementStyleAttributes::where('tailori_attribute_code', $monogramFont['Id'])->update(['image'=> $monogramFont['ImageSource']]);
            }
            //MonogramColor
            foreach($productImages['MonogramColor'] as $monogramColor){
                
                $updateImage = TailoriProductElementStyleAttributes::where('tailori_attribute_code', $monogramColor['Id'])->update(['image'=> $monogramColor['ImageSource']]);
            }
        }

    }
}
