<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\TailoriProductSyncJob;
use App\Jobs\TailoriProductElementSyncJob;
use App\Jobs\TailoriProductElementStyleSyncJob;
use App\Jobs\TailoriProductElementStyleAttributeSyncJob;
use App\Jobs\TailoriStyleImageSyncJob;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Config, Log;
use App\Models\TailoriProduct;
use App\Models\TailoriProductElement;
use App\Models\TailoriProductElementStyle;
use App\Models\TailoriProductElementStyleAttributes;
use App\Models\TailoriStyleImage;
use App\Models\VendorPackageAttributeSelection;
use GuzzleHttp\Exception\ClientException;
header('Access-Control-Allow-Origin: *');

class TailoriAssetSyncController extends Controller
{   
    private $appKey;
    private $client;

    public function __construct()
    {
        $this->middleware('auth');
        $this->client = new Client;
        $request = $this->client->get(Config::get('constants.API_URL').'LoginUsers?UserName='.Config::get('constants.API_USERNAME').'&PasswordHash='.Config::get('constants.API_PASSWORD'));
        $this->appKey = $request->getBody()->getContents();
    }
    /**
     * Sync tailori products
     */
    public function tailoriProductSync(Request $request){

        $client = new Client;
    
        $request = $client->get(Config::get('constants.TAILORI_PRODUCT_API_URL').'Key='. $this->appKey);

        $products = json_decode($request->getBody()->getContents(), true);

        if($products){
            foreach($products as $key=>$value){
                $productStrArray = explode('-', $key);
                $productName = $productStrArray[1];
                TailoriProduct::updateOrCreate( ['tailori_product_code' => $value], [
                    'tailori_product_code' => $value,
                    'product_name' => $productName,
                ]);
            }
        }

        $this->tailoriProductElementSync();
    }
    /**
     * Sync tailori product elements
     */
    public function tailoriProductElementSync(){
        $products = TailoriProduct::select('tailori_products_id', 'tailori_product_code', 'product_name', 'is_active')->where('is_active', 1)->get()->toArray();
        $client = new Client;
        if($products){
            foreach ($products as $product) {
                // $job = (new TailoriProductElementSyncJob($this->appKey, $product['tailori_product_code'], $product['tailori_products_id']));
                // dispatch($job)->onQueue('product_elements')->delay(now()->addSeconds(1));
                $productId = $product['tailori_products_id'];
                $product_code = $product['tailori_product_code'];
                try{
                    $request = $client->get(Config::get( 'constants.TAILORI_PRODUCT_ELEMENT_API_URL') . 'Key=' . $this->appKey . '&' . $product_code);
                    $productElements = json_decode($request->getBody()->getContents(), true);
                    if ( $productElements ) {
                        foreach ( $productElements as $key => $value ) {
                            TailoriProductElement::updateOrCreate(['tailori_element_code' => $value], [
                                'tailori_element_code' => $value,
                                'product_id' => $productId,
                                'element_name' => $key,
                            ]);
                        }
                    }
                    if($productId == 1 || $productId == 2 || $productId == 3 || $productId == 5){
                        $placementUrl = Config::get( 'constants.TAILORI_Monogram_Placement_API_URL');
                        $fontUrl      = Config::get( 'constants.TAILORI_Monogram_Font_API_URL');
                        $colorUrl     = Config::get( 'constants.TAILORI_Monogram_Color_API_URL');
                        $placementArr = [1 => 'MONPWS',2 =>'MONPS',3 => 'MONPSU',5 => 'MONPJ'];
                        $fontArr      = [1 => 'MONFWS',2 =>'MONFS',3 => 'MONFSU',5 => 'MONFJ'];
                        $colorArr     = [1 => 'MONCWS',2 =>'MONCS',3 => 'MONCSU',5 => 'MONCJ'];
                        $this->getMonogramData($this->appKey,$product_code,$placementUrl,$placementArr[$productId],'MonogramPlacement',$productId);
                        $this->getMonogramData($this->appKey,$product_code,$fontUrl,$fontArr[$productId],'MonogramFont',$productId);
                        $this->getMonogramData($this->appKey,$product_code,$colorUrl,$colorArr[$productId],'MonogramColor',$productId);
                    }
                }
                catch(ClientException $e){
                    Log::error($e);
                }
            }
            $this->tailoriProductElementStyleSync();
        }
    }

    public function getMonogramData($appKey,$tailoriProductCode,$url,$code,$name,$productId)
    {
        $client = new Client;
        $request = $client->get($url . 'Key=' . $appKey . '&' . $tailoriProductCode);
        $productElements = json_decode($request->getBody()->getContents(), true);
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
    /**
     * Sync tailori element styles
     */
    public function tailoriProductElementStyleSync(){
        $elements = TailoriProductElement::select('id', 'product_id', 'tailori_element_code', 'is_active')->where('is_active', 1)->get()->toArray();
        if($elements){
            foreach($elements as $element){
                // $job = (new TailoriProductElementStyleSyncJob($this->appKey, $element[ 'tailori_element_code'], $element['id']));
                // dispatch($job)->onQueue('product_element_styles')->delay(now()->addSeconds(1));
                $elementname = $element['tailori_element_code'];
                $elementid = $element['id'];
                $client = new Client;
                try{
                    $request = $client->get(Config::get('constants.TAILORI_PRODUCT_ELEMENT_STYLE_API_URL') . 'Key=' . $this->appKey . '&' . $elementname);
            
                    $productElements = json_decode($request->getBody()->getContents(), true);
                    
                    if ($productElements) {
                        foreach ($productElements as $key => $value) {
                            TailoriProductElementStyle::updateOrCreate(['tailori_style_code' => $value], [
                                'element_id' => $elementid,
                                'tailori_style_code' => $value,
                                'style_name' => $key
                            ]);
                        }
                    }
                }
                catch(ClientException $e){
                    Log::error($e);
                }
            }
            $this->tailoriProductElementStyleAttributeSync();
        }
    }
    /**
     * Sync tailori style attributes
     */
    public function tailoriProductElementStyleAttributeSync(){
        $styles = TailoriProductElementStyle::select('id', 'element_id', 'tailori_style_code', 'style_name', 'is_active')->where('is_active', 1)->get()->toArray();
        if($styles){
            foreach($styles as $style){
                // $job = (new TailoriProductElementStyleAttributeSyncJob($this->appKey, $style['tailori_style_code'], $style['id']));
                // dispatch($job)->onQueue('product_element_style_attributes')->delay(now()->addSeconds(1));

                try{
                    $styleId = $style['id'];
                    $tailoriStyleCode = $style['tailori_style_code'];
                    $client = new Client;
                    
                    $request = $client->get(Config::get('constants.TAILORI_PRODUCT_ELEMENT_STYLE_ATTRIBUTE_API_URL') . 'Key=' . $this->appKey . '&' . $tailoriStyleCode);
                    
                    $styleAttributes = json_decode($request->getBody()->getContents(), true);
                    
                    if ( $styleAttributes ) {
                        foreach ($styleAttributes as $key => $value) {
                            TailoriProductElementStyleAttributes::updateOrCreate(['tailori_attribute_code' => $value], [
                                'style_id' => $styleId,
                                'tailori_attribute_code' => $value,
                                'attribute_name' => $key
                            ]);
                        }
                    }
                }
                catch(ClientException $e){
                    Log::error($e);
                }
            }
        }
        $this->syncImages();
    }

    public function syncImages(){
        $client = new Client;
        $prodArr = ['Men-Shirt','Men-Trouser','Men-Jacket','Men-Suit','Men-Waistcoat','Men-Bandhgala','Men-Bundys','Women-Women_Shirt','Women-Women_Suit'];
        foreach($prodArr as $val)
        {
            $request = $client->get(Config::get('constants.TAILORI_PRODUCT_ELEMENT_IMAGES').$val.'/'.$this->appKey.'?DeleteExistingJson=true');
            
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
        $this->syncElementImages();
    }


    public function syncElementImages(){
        // $job = (new TailoriStyleImageSyncJob($this->appKey));
        // dispatch($job)->onQueue('style_image_sync')->delay(now()->addSeconds(1));
        $client = new Client;
        $prodArr = ['Men-Shirt','Men-Trouser','Men-Jacket','Men-Suit','Men-Waistcoat','Men-Bandhgala','Men-Bundys','Women-Women_Shirt','Women-Women_Suit'];
        foreach($prodArr as $val)
        {
            $request = $client->get(Config::get('constants.TAILORI_PRODUCT_ELEMENT_IMAGES').$val.'/'.$this->appKey.'?DeleteExistingJson=true');
            
            $productImages = json_decode($request->getBody()->getContents(), true);

            foreach($productImages['Product'] as $productImage){
                $updateImage = TailoriProductElement::where('tailori_element_code', $productImage['Id'])->update(['image_url'=> $productImage['ImageSource']]);
            }
            //Monogram Placement
            foreach($productImages['MonogramPlacement'] as $monogramPlacement){
                
                $updateImage = TailoriProductElement::where('tailori_element_code', $monogramPlacement['Id'])->update(['image_url'=> $monogramPlacement['ImageSource']]);
            }
            // MonogramFont
            foreach($productImages['MonogramFont'] as $monogramFont){
                
                $updateImage = TailoriProductElement::where('tailori_element_code', $monogramFont['Id'])->update(['image_url'=> $monogramFont['ImageSource']]);
            }
            //MonogramColor
            foreach($productImages['MonogramColor'] as $monogramColor){
                
                $updateImage = TailoriProductElement::where('tailori_element_code', $monogramColor['Id'])->update(['image_url'=> $monogramColor['ImageSource']]);
            }
        }
    }

    /**
     * Get product with all possible elements, styles & attributes
     */
    public function getTailoriProducts(){
        $products = TailoriProduct::select('id', 'tailori_product_code', 'product_name')
        ->where('is_active', 1)
        ->with([ 'productElements' => 
            function($query){ 
                $query->select('id', 'product_id', 'tailori_element_code', 'element_name')
                ->with([ 'elementStyles' => 
                    function($query){ 
                        $query->select('id', 'element_id', 'tailori_style_code', 'style_name')
                        ->with([ 'styleAttributes' => 
                            function($query){ 
                                $query->select('id', 'style_id', 'tailori_attribute_code', 'attribute_name'); 
                            }]); 
                    }]);
            }])
        ->get()
        ->toJson();
    }

}