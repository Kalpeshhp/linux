<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Fabric;
use App\Models\VendorFabric;
use Config,Log;
use App\Models\UserPackage;
use App\Http\Controllers\StyleAttributeController;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\TailoriProduct;
use App\Models\TailoriProductElement;
use App\Models\VendorProductAttributeSelection;
header('Access-Control-Allow-Origin: *');

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Generate the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generateKey(Request $request)
    {
        $storeUrl = $request['url'];
        $userArr = Vendor::where('store_url',$storeUrl)->first();
        if(isset($userArr))
        {
            echo json_encode(['key'=>$userArr->user_uid,'user_id'=>$userArr->vendor_id,'status'=>1]);
        }
        else{
            echo json_encode(['key'=>'','user_id'=>'','status'=>0]);
        }
    }

	public function generateid(Request $request)
    {
        $username = $request['username'];
        $request_text = $request['text'];
        $split_text = explode('-', $request_text);

        $product_name = $split_text[1] ?? null;
        $userArr = Vendor::where('username',$username)->first();
        $vendorId = $userArr->vendor_id;
        $checksum = $userArr->user_uid;

        $vendor_product_ids = VendorProduct::where('vendor_id', $vendorId)
                ->where('is_active', 1)
                ->pluck('tailori_products_id');
            
        $vendor_products = TailoriProduct::whereIn('tailori_products_id', $vendor_product_ids)
                ->with('tailoriProducts')
                ->get()
                ->toArray();
        foreach ($vendor_products as $product) {
            if(strtolower($product['tailori_products']['product_name']) == $product_name)
            $productId = $product['tailori_products_id'] ?? null;
        }

        $tailoriElements = TailoriProductElement::where('product_id', $productId)
            ->orderBy('sort_order')
            ->get()
            ->toArray();

            $customElementNames = VendorProductAttributeSelection::where('vendor_id', $vendorId)
            ->where('is_active', 1)
            ->pluck('parent_style_name', 'element_id')
            ->toArray();
        
        $elementsid = [];
        
        foreach ($tailoriElements as $element) {
            if (isset($customElementNames[$element['id']])) {
                $element['element_name'] = $customElementNames[$element['id']];
            }
        
            $ids = $element['tailori_element_code'] ?? null;
            if ($ids !== null && !in_array($ids, $elementsid)) {
                $elementsid[] = $ids;
            }
        }
        
        $response = [
            'key' => isset($userArr) ? $userArr->user_uid : '',
            'user_id' => isset($userArr) ? $userArr->vendor_id : '',
            'status' => isset($userArr) ? 1 : 0,
            'elementsid' => $elementsid,
            'Checksum' => $checksum
        ];
        
        echo json_encode($response);
    }
    public function getFilterOptions(Request $request)
    {
        if(isset($request['key']))
        {
            $key = $request['key'];
            $vendorId = Vendor::where('user_uid',$key)->first()->vendor_id;
        }
        else
        {
            $sku = $request['sku'];
        }

        if(isset($vendorId)|| isset($sku))
        {
            if(isset($vendorId))
            {
                $inStorefabricIds = VendorFabric::where('vendor_id', $vendorId)->where('is_active',1)->get(['fabric_id'])->pluck('fabric_id');
                $fabricArr    = Fabric::select('brand','color','design_pattern','fabric_blend')->whereIn('fabric_id',$inStorefabricIds)->get()->toArray();
            }
            else
            {
                $fabricArr    = Fabric::select('brand','color','design_pattern','fabric_blend')->where('tailori_fabric_code',$sku)->get()->toArray();
            }


            $i = 0;
            $data = [];
            if(count($fabricArr))
            {
                foreach ($fabricArr as $key => $value) 
                {
                    $data['brand'][]=$value['brand'];
                    $data['color'][]=$value['color'];
                    $data['design_pattern'][]=$value['design_pattern'];
                    $data['fabric_blend'][]=$value['fabric_blend'];
                }
            }
            $data['brand'] = array_unique($data['brand'], SORT_REGULAR);
            $data['color'] = array_unique($data['color'], SORT_REGULAR);
            $data['design_pattern'] = array_unique($data['design_pattern'], SORT_REGULAR);
            $data['fabric_blend'] = array_unique($data['fabric_blend'], SORT_REGULAR);

            echo json_encode(['BLEND'=>$data['fabric_blend'],'BRAND'=>$data['brand'],'COLOUR'=>$data['color'],'DESIGN'=>$data['design_pattern']]);
        }
        else
        {
            echo json_encode(['key'=>'','user_id'=>'','status'=>0]);
        }
    }

    public function createShopifyProduct(Request $request)
    {
        $image = '';
        //$productList = $request['prod_array'];
        /*try {*/
            $productList = $request['prod_array'];

            //$productSku = $productList[0]['feature'];

            $productPrice = $request['productPrice'];
            
            $productType = $request['product_type'];
            $productTitle = $request['product_title'];
            $timestamp   = time();

            $productIds = [];

            $image = $this->search($productList,'product','image');
            
            //print_r($image);die;
            //$image = head($image);
            
            $image1 = base64_encode(file_get_contents($image[0]['feature']));
            $image2 = base64_encode(file_get_contents($image[1]['feature']));
            
            $shopify_config = Config::get('ShopifyApp');

            $url = trim('https://'.$shopify_config['domain'].'/admin/products.json');

            //$timestamp = time();
            
            $productData = [
                'product'=>[
                    'title'=> $productTitle, 
                    'body_html'=> "<h2>FC ".ucfirst($productType)."</h2>", 
                    'vendor'=> 'FC', 
                    'product_type'=> 'FC-'.$productType,
                    "published"=> true,
                    "images"=> [
                        [
                            'attachment' => $image1
                        ],
                        [
                            'attachment' => $image2
                        ]    
                    ],
                    'variants'=>[
                        [
                            "option1"=> "First",
                            'price'=> number_format($productPrice, 2),
                            'sku'=> 'customise-'.$timestamp
                        ]
                    ]
                ]
            ]; 
            
            $params = json_encode($productData);
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_USERPWD, $shopify_config['api_key'].":".$shopify_config['password']); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($params)));
            $response = curl_exec($ch);
            $response = json_decode($response, true);

            $productIds[] = [
                'variant_id'=>$response['product']['variants'][0]['id']
            ];
           
           $variantId = json_encode($productIds);
        
            Log::info('Shopify Product Create <br>Request :- '.json_encode($productList).'<br>Response'.json_encode($variantId));

           return $variantId;   
        /*} catch (Exception $e) {
            Log::error('Shopify Product create <br> Request :- '.json_encode($productList).'<br>Response'.json_encode($e));  
        }*/
    }
    public function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }


}
