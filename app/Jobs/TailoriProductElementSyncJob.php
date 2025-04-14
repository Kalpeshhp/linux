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
use App\Models\TailoriProduct;
use App\Models\TailoriProductElement;
use App\Models\TailoriProductElementStyle;
use App\Models\TailoriProductElementStyleAttributes;
use GuzzleHttp\Exception\ClientException;

class TailoriProductElementSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $appKey;
    private $tailoriProductCode;
    private $productId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appKey, $tailoriProductCode, $productId)
    {
        $this->appKey = $appKey;
        $this->tailoriProductCode = $tailoriProductCode;
        $this->productId = $productId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client;

        try{
            $request = $client->get(Config::get( 'constants.TAILORI_PRODUCT_ELEMENT_API_URL') . 'Key=' . $this->appKey . '&' . $this->tailoriProductCode);
            $productElements = json_decode($request->getBody()->getContents(), true);
            if ( $productElements ) {
                foreach ( $productElements as $key => $value ) {
                    TailoriProductElement::updateOrCreate(['tailori_element_code' => $value], [
                        'tailori_element_code' => $value,
                        'product_id' => $this->productId,
                        'element_name' => $key,
                    ]);
                }
            }
            $placementUrl = Config::get( 'constants.TAILORI_Monogram_Placement_API_URL');
            $fontUrl      = Config::get( 'constants.TAILORI_Monogram_Font_API_URL');
            $colorUrl     = Config::get( 'constants.TAILORI_Monogram_Color_API_URL');
            $placementArr = [1 =>'MONPS',2 => 'MONPSU',3 => 'MONPJ'];
            $fontArr      = [1 =>'MONFS',2 => 'MONFSU',3 => 'MONFJ'];
            $colorArr     = [1 =>'MONCS',2 => 'MONCSU',3 => 'MONCJ'];
            $this->getMonogramData($this->appKey,$this->tailoriProductCode,$placementUrl,$placementArr[$this->productId],'MonogramPlacement',$this->productId);
            $this->getMonogramData($this->appKey,$this->tailoriProductCode,$fontUrl,$fontArr[$this->productId],'MonogramFont',$this->productId);
            $this->getMonogramData($this->appKey,$this->tailoriProductCode,$colorUrl,$colorArr[$this->productId],'MonogramColor',$this->productId);
        }
        catch(ClientException $e){
            Log::error($e);
        }
    }
    public function getMonogramData($appKey,$tailoriProductCode,$url,$code,$name,$productId)
    {
        $client = new Client;
        $request = $client->get($url . 'Key=' . $appKey . '&' . $tailoriProductCode);
        $productElements = json_decode($request->getBody()->getContents(), true);
        // echo '<pre>';
        // print_r($productElements);die;
        if ( $productElements ) 
        {
            $returnData = TailoriProductElement::updateOrCreate(['tailori_element_code' => $code], [
                    'tailori_element_code' => $code,
                    'product_id' => $productId,
                    'element_name' => $name,
                ]);

            $styleData = TailoriProductElementStyle::updateOrCreate(['tailori_style_code' => $code], [
                        'element_id' => $returnData->id,
                        'tailori_style_code' => $code,
                        'style_name' => $name
                    ]);

            foreach ( $productElements as $key => $value ) {
                    TailoriProductElementStyleAttributes::updateOrCreate(['tailori_attribute_code' => $value], [
                        'style_id' => $styleData->id,
                        'tailori_attribute_code' => $value,
                        'attribute_name' => $key
                    ]);
            }
        }
    }
}
