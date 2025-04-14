<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Fabric;
use App\Models\VendorFabric;
use App\Models\Brand;
use App\Models\VendorBrand;
use App\Models\UserPackage;
use App\Jobs\FabricJob;
use App\Jobs\FabricJobNew;
use Yajra\Datatables\Datatables;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Config, Illuminate\Support\Facades\Storage;
use App\Jobs\TailoriFabricSyncJob;
use App\Jobs\TailoriFabricImageSyncJob;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StyleAttributeController;
use Illuminate\Support\Facades\Http;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\TailoriProduct;
header('Access-Control-Allow-Origin: *');

class FabricController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $vendors = User::where('user_group', 2)->where('status', 1)->with('vendor')->get()->pluck('name', 'vendor.user_uid');
        
        return view('admin.fabric.index')->withVendors($vendors);
    }
    /**
     * Load all fabrics on listing page
     */
    public function loadFabrics(Request $request){
        $fabrics = $this->fetchFabrics();
        return Datatables::of($fabrics)
        ->editColumn('description', function($fabrics){
            return $fabrics['description']!=''?$fabrics['description']:'N/A';
        })
        ->editColumn('product_type', function($fabrics){
            return $fabrics['product_type']!=''?$fabrics['product_type']:'N/A';
        })
        ->make('true');
    }

    /**
     * Fetch all fabrics
     */
    public function fetchFabrics(){
        $fabrics = Fabric::all();
        return $fabrics;
    }
    public function getBrands()
    {
        $brand = [];
        $vendorID = auth()->user()->vendor_id;
        $_SESSION["AppKey"] = Vendor::where('vendor_id', $vendorID)->value('user_uid');
        if(auth()->user()->user_group !=1)
        {
            $brandArr = VendorBrand::with('brand')->where('vendor_id',auth()->user()->vendor_id)->get()->toArray();

            $i = 0;
            $lastElement = end($brandArr);
            $vendorBrandArr = [];

            foreach ($brandArr as $key => $value) 
            {
                $brand[$i]['brand'] = $value['brand']['brand_name'];
                $i++;
                if($value == $lastElement) 
                {
                    $brand[$i]['brand'] ='TEXTRONIC';//Admin Brand
                }

            }
        }
        else
        {
            $brand = Brand::select('brand_name as brand')->where('is_active',1)->get(['brand'])->toArray();
        }
        return $brand;
    }
    public function fabricGrid(Request $request){

        $brand           = $this->getBrands();

        $inStoreCount    = 0;
        $offStoreCount   = 0;
        
        $vendorBrandArr  = array_map(function ($ar) {return $ar['brand'];}, $brand);

        if(auth()->user()->user_group !=1)
        {
            $inStoreCount     = VendorFabric::where('vendor_id', auth()->user()->vendor_id)->where('is_active',1)->get()->count();

            $inStorefabricIds = VendorFabric::where('vendor_id', auth()->user()->vendor_id)->where('is_active',1)->get(['fabric_id'])->pluck('fabric_id');

            $offStoreCount    = Fabric::whereNotIn('fabric_id',$inStorefabricIds)->whereIn('brand',$vendorBrandArr)->get()->count();
        }
        $allStoreCount = Fabric::whereIn('brand',$vendorBrandArr)->get()->count();

            $fabrics = Fabric::where(function($query){
                            $query->WhereNull('vendor_key')->orWhere('vendor_key',auth()->user()->user_uid);
                       })->orderBy('fabric_id', 'desc');

            $fabricColors = Fabric::select('color')->WhereNull('vendor_key')->orWhere('vendor_key',auth()->user()->user_uid)->distinct()->get()->toArray();
            
            if($request['search'] != '' || $request['product'] != '' || $request['wear'] != '' || $request['colors'] != '' || $request['view'] != '' ){
    
                if($request['view'] != '')
                {
                    if($request['view'] == 'in_store'){
                       
                        $fabricIds  = VendorFabric::where('vendor_id', auth()->user()->vendor_id)->where('is_active',1)->get(['fabric_id'])->pluck('fabric_id');

                        $fabrics    = Fabric::whereIn('fabric_id', $fabricIds);   
                    }
                    else if($request['view'] == 'off_store')
                    {
                        $inStorefabricIds   = VendorFabric::where('vendor_id', auth()->user()->vendor_id)->where('is_active',1)->get(['fabric_id'])->pluck('fabric_id');

                        $fabrics            = Fabric::whereNotIn('fabric_id',$inStorefabricIds); 
                    }
                }
                
                if($request['search'] != '')
                {
                     $fabricsCount      = Fabric::where('fabric_name', 'LIKE', "%" .$request['search']. "%")->get()->count();

                     if($fabricsCount)
                     {
                        $fabrics = Fabric::where('fabric_name', 'LIKE', "%" .$request['search']. "%");
                     }
                     else
                     {
                        $fabricId = VendorFabric::where('fabric_name', 'LIKE', "%" .$request['search']. "%")->where('vendor_id', auth()->user()->vendor_id)->get(['fabric_id'])->pluck('fabric_id');
                        
                        if(count($fabricId))
                        {
                            $fabrics = Fabric::where('fabric_id', $fabricId);
                        }
                        else
                        {
                            $fabrics = Fabric::where('fabric_name', 'LIKE', "%" .$request['search']. "%");
                        }
                     }
                    
                }
                
                if($request['product'] != '')
                {
                    $type = json_decode($request['product'], true);
                    $fabrics = $fabrics->whereIn('product_type', $type);
                }
                if($request['wear'] != '')
                {
                    $wearType = json_decode($request['wear'], true);
                    $fabrics = $fabrics->whereIn('wear_type', $wearType);
                }
                if($request['brand'] != '')
                {
                    $requestBrand = json_decode($request['brand'],true);
                    $fabrics = $fabrics->whereIn('brand', $requestBrand);
                }
                if($request['colors'] != '')
                {
                    $colors = json_decode($request['colors'], true);
                    $fabrics = $fabrics->whereIn('color', $colors);
                }
                $fabrics = $fabrics->with('vendorFabrics')->whereIn('brand',$vendorBrandArr)->paginate(20);
            }
            else
            {
                $fabrics = $fabrics->with('vendorFabrics')->whereIn('brand',$vendorBrandArr)->paginate(20);
            }
    
            if($request->ajax())
            {
                return view('admin.fabric.filtered')->withFabrics($fabrics)->withInStore($inStoreCount)->withOffStore($offStoreCount)->withAllStore($allStoreCount);
            }
            else
            {
                $vendorDetails = Vendor::where('vendor_id', auth()->user()->vendor_id)->get();
                $hostUrl = $vendorDetails[0]->store_url;
                auth()->user()->fabric_upload_limit = $vendorDetails[0]->fabric_upload_limit;
                return view('admin.fabric.grid')->withFabrics($fabrics)->withColors($fabricColors)->withHost($hostUrl)->withBrand($brand)->withInStore($inStoreCount)->withOffStore($offStoreCount)->withAllStore($allStoreCount);
            }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storemulti(Request $request){
        $brandArr = VendorBrand::with('brand')->where('vendor_id',auth()->user()->vendor_id)->get()->toArray();
        $brand_name = $brandArr[0]['brand']['brand_name'];
        $requestData[]=$request['FabricData'];
       $i = 0;
        foreach($requestData as $fabarray){
                $requestData[0]['key']=isset($request['vendor'])?$request['vendor']:Auth::user()->user_uid;  
                $requestData[0]['designerName']=isset($request['vendor'])?$request['vendor']:Auth::user()->user_uid; 
                $requestData[0]['propertyValues']['brand']=$brand_name;
                $i++;
            }
            $returnData =  $this->dispatch(new FabricJob($requestData));
            return json_encode($returnData);
    }
    public function fetchFabricAndElementDetails(Request $request,$returnData ) {
        $requestData = $request->get('FabricData');
        $brandArr = VendorBrand::with('brand')->where('vendor_id', auth()->user()->vendor_id)->first();
        $brandName = $brandArr->brand->brand_name ?? '';
        
        $fabricId = $returnData[0]['Id'][0] ?? null;
        
        $fabricDetails = [
            'fabricId' => $fabricId,
            'imageName' => $requestData['propertyValues']['imageName'] ?? null,
            'description' => $requestData['propertyValues']['description'] ?? null,
            'libraryName' => $requestData['propertyValues']['libraryName'] ?? null,
            'brand' => $brandName,
        ];
    
        $vendorId = Auth::id();
    
        $styleController = new StyleAttributeController();
        $packageId = UserPackage::where('user_id', $vendorId)->value('package_id');
        $products = $styleController->getTailoriProducts($packageId);
    
        $allProductDetails = [];    
    
        foreach ($products as $product) {
            $productId = $product['product_id'] ?? null;
    
            if ($productId) {
                $elementRequest = new Request(['productId' => $productId]);
                $elements = json_decode($styleController->getTailoriElements($elementRequest), true);
    
                $elementDetails = [];
    
                foreach ($elements as $element) {
                    $elementId = $element['id'];
                    $elementName = $element['element_name'];
    
                    $styleRequest = new Request(['elementId' => $elementId]);
                    $stylesWithAttributes = json_decode($styleController->getTailoriStyles($styleRequest), true);
    
                    $elementDetails[] = [
                        'elementId' => $elementId,
                        'elementName' => $elementName,
                        'styles' => $stylesWithAttributes,
                    ];
                }
    
                $allProductDetails[] = [
                    'productId' => $productId,
                    'productName' => $product['tailoriProducts']['name'] ?? null,
                    'elements' => $elementDetails,
                ];
            }
        }
    
        $completeDetails = [
            'fabricDetails' => $fabricDetails,
            'vendorId' => $vendorId,
            'packageId' => $packageId,
            'products' => $allProductDetails,
        ];
    
        return response()->json($completeDetails);
    }
    public function store(Request $request)
    {          
        $requestParam = $request->all();
        $image = $request->file('fabric_image');
        $input['imagename'] = 'test.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);
        $imageData = file_get_contents(public_path('/images/').'test.'.$image->getClientOriginalExtension());
        $imageData = base64_encode($imageData);
        $brandArr = VendorBrand::with('brand')->where('vendor_id',auth()->user()->vendor_id)->get()->toArray();
        $brand_name = $brandArr[0]['brand']['brand_name'];
        $requestData[] = [
            'key'         => isset($request['vendor'])?$request['vendor']:Auth::user()->user_uid,
            'imageName'   => $request['fabric_name'],
            'designerName'=> isset($request['vendor'])?$request['vendor']:Auth::user()->user_uid,
            'libraryName' => $request['product_type'],
            'description' => isset($request['description'])?$request['description']:"",
            //'price'       => $request['price'],
            'fabricImage'  => preg_replace('#^data:image/[^;]+;base64,#', '', $imageData),
            'propertyValues'=>[
                'DESIGN'    => $request['design_pattern'],
                'COLOUR'    => $request['color'],
                'blend'     => $request['fabric_blend'],
                'brand'     => $brand_name,
            ],
        ];
        
        $job = (new FabricJob($requestData));

        $returnData = dispatch($job);

        if($returnData){
            return response()->json(['message_code'=> 1,"message"=> "Fabric uploaded successfully"],200);
        }
        else{
            return response()->json(['message_code'=> 0,"message"=> "Fabric not uploaded"],200);
        }
    }

    public function tailoriFabricSync(Request $request)
    {   
        /**
         * Job to sync Tailori fabrics to application
         */
        $tailoriFabricSyncJob = (new TailoriFabricSyncJob($this->appKey));
        dispatch($tailoriFabricSyncJob);

        /**
         * Job to sync Tailori fabrics images to application
         */
        /* $fabrics = Fabric::all()->toArray();
        
        foreach($fabrics as $fabric){
            if( !Storage::disk('public')->exists( 'thumbnail/'.$fabric['fabric_image'] ) ){
                $tailoriFabricImageSyncJob = (new TailoriFabricImageSyncJob($this->appKey, $fabric['tailori_fabric_id'], $fabric['id']));
                dispatch($tailoriFabricImageSyncJob);
            }
        } */
    }

    /**
     * Get fabrics and sync it to the opencart store
     */
    public function tailoriFabricSyncToStore(Request $request)
    {
        $fabricIds = $request['fabricIds'];
        $fabrics = Fabric::whereIn('tailori_fabric_code', $fabricIds)
            ->with('vendorFabrics')
            ->get();

        $fabricData = [];
        $i = 0;

        foreach ($fabrics as $eachFabric) {
            foreach ($eachFabric->toArray() as $key => $value) {
                $fabricData[$i][$key] = $value;
            }

            $productType = $eachFabric->product_type ?? null;

            if ($productType) {
                $mainProductType = explode('_', $productType)[0];

                $fabricRequest = new Request(['text' => $mainProductType]);
                $this->createFabricJSON($fabricRequest);
            }

            $i++;
        }

        return json_encode($fabricData);
    }


    /**
     * Set or update the vendor fabrics with active status
     */
    public function setVendorFabricStatus(Request $request){
        if( count($request['fabricIds']) > 0 ){
            foreach($request['fabricIds'] as $fabricId){
                VendorFabric::updateOrCreate([ 'fabric_id' => $fabricId, 'vendor_id' => auth()->user()->vendor_id ], [
                    'vendor_id' => auth()->user()->vendor_id,
                    'fabric_id' => $fabricId,
                    'is_active' => 1
                ]);
            }
            return 1;
        }
        return 0;
    }

    /**
     * Get requested fabric
     */
    public function getRequestedFabric(Request $request){

        $fabricId = $request['fabricId'];

        $vendorFabricCount = VendorFabric::where('vendor_id', auth()->user()->vendor_id)
        ->where('fabric_id', $fabricId)->count();
        
        if($vendorFabricCount > 0){
          
            $fabricRecord = VendorFabric::where('vendor_id', auth()->user()->vendor_id)
            ->where('fabric_id', $fabricId)
            ->with('fabric')
            ->get()
            ->toArray();
           
            $fabricRecord = [
                'fabric_id' => $fabricRecord[0]['fabric_id'],
                'tailori_fabric_code' => $fabricRecord[0]['fabric']['tailori_fabric_code'],
                'fabric_name' => $fabricRecord[0]['fabric_name'],
                'description'  => $fabricRecord[0]['description'],
                'price'  => $fabricRecord[0]['price'],
            ];
        }
        else{
           
            $fabricRecord = Fabric::where('fabric_id', $fabricId)->get(['fabric_id', 'tailori_fabric_code', 'fabric_name', 'price', 'description'])->toArray();
            $fabricRecord = [
                'fabric_id' => $fabricRecord[0]['id'],
                'tailori_fabric_code' => $fabricRecord[0]['tailori_fabric_code'],
                'fabric_name' => $fabricRecord[0]['fabric_name'],
                'description'  => $fabricRecord[0]['description'],
                'price'  => $fabricRecord[0]['price'],
            ];
        }
       
        return $fabricRecord;
    }

	/*
        * Send the Configuration to service for uploading --> Pravesh
    */
    // public function forwardConfigData(Request $request)
    // {                
    //     try {
    //         $client = new Client();
    //         $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL'));
    //         $url = $apiurl . "api/UploadConfigurationJson?DeleteExistingJson=true";
    //         $token = $request->input('_token');
    
    //         $configData = $request->input('configData');
    //         if (is_string($configData)) {
    //             $configData = json_decode($configData, true);
    //         }
    //         $response = $client->request('POST', $url, [
    //             'json' => $configData,
    //             'headers' => [
    //                 'X-CSRF-TOKEN' => $token,
    //             ],
    //         ]);
    
    //         return response()->json(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Failed to upload configuration.',
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    /**
     * Update vendor fabric details 
     */
    public function vendorFabricUpdate(Request $request){

        $isCreated = VendorFabric::updateOrCreate([ 'fabric_id' => $request['hd_fabric_id'], 'vendor_id'=> auth()->user()->vendor_id ], [
            'vendor_id' => auth()->user()->vendor_id,
            'fabric_name' => $request['hd_fabric_name'],
            'price' => $request['hd_price'],
            'description' => $request['hd_fabric_description']!=''?$request['hd_fabric_description']:NULL,
        ]);

        if($isCreated->wasRecentlyCreated == false)
        {

            $active = VendorFabric::where('id',$isCreated->id)->first();
            
            if($active){

                $fabricCode = Fabric::where('fabric_id', $request['hd_fabric_id'])->value('tailori_fabric_code');

                $productType = Fabric::where('fabric_id', $request['hd_fabric_id'])->value('product_type');
                
                $storeUrl = Vendor::where('vendor_id', auth()->user()->vendor_id)->value('store_url');
                // $url = $storeUrl.'index.php?route=tailori/custom/updateFabric';
                
                $response = ['exist'=>1,'tailori_fabric_code' => $fabricCode, 'storeUrl' => $storeUrl, 'price' => $request['hd_price'], 'fabric_name' => $request['hd_fabric_name'], 'description' => $request['hd_fabric_description'] ];
            }
            else{
                $response = ['exist'=>0];
            }
        }
        else
        {
            $response = ['exist'=>0];
        }
        $productType = explode('_', $productType)[0];
        $request = new Request(['text' => $productType, ]);
        $fabricController = new FabricController;
        $fabricController->createFabricJSON($request);

        return json_encode($response);
        
    }

    public function removeVendorFabric(Request $request)
    {
        $fabricIds = $request['fabrics'];

        if (count($fabricIds) > 0) {
            $fabrics = Fabric::whereIn('tailori_fabric_code', $fabricIds)
                ->pluck('fabric_id')
                ->toArray();

            $storeUrl = Vendor::where('vendor_id', auth()->user()->vendor_id)->value('store_url');
            $url = $storeUrl . 'index.php?route=tailori/custom/removeFabric';

            if (count($fabrics) > 0) {
                foreach ($fabrics as $fabricIdData) {
                    VendorFabric::updateOrCreate(
                        ['fabric_id' => $fabricIdData, 'vendor_id' => auth()->user()->vendor_id],
                        [
                            'vendor_id' => auth()->user()->vendor_id,
                            'fabric_id' => $fabricIdData,
                            'is_active' => 0
                        ]
                    );

                    $productType = Fabric::where('fabric_id', $fabricIdData)->value('product_type');

                    if ($productType) {
                        $productType = explode('_', $productType)[0];
                        $fabricRequest = new Request(['text' => $productType]);
                        $this->createFabricJSON($fabricRequest);
                    }
                }
            }

            return json_encode(['message' => 'Fabric removed successfully', 'url' => $url, 'sku' => $fabricIds]);
        } else {
            return json_encode(['message' => 'Invalid Request']);
        }
    }
    //Vijay Remove Fabric From Vendor Panel 
    public function DeleteFromVendorPanel(Request $request)
    {
        $fabricId = $request['fabricID'];

        array_unshift($fabricId, isset($request['vendor']) ? $request['vendor'] : Auth::user()->user_uid);

        $fabrics = Fabric::whereIn('tailori_fabric_code', $fabricId)->pluck('fabric_id')->toArray();

        foreach ($fabrics as $fabricIdData) {
            $productType = Fabric::where('fabric_id', $fabricIdData)->value('product_type');

            if ($productType) {
                $mainProductType = explode('_', $productType)[0];
                $fabricRequest = new Request(['text' => $mainProductType]);
                $this->createFabricJSON($fabricRequest);
            }
        }

        VendorFabric::whereIn('fabric_id', $fabrics)->where('vendor_id', auth()->user()->vendor_id)->delete();

        Fabric::whereIn('fabric_id', $fabrics)
            ->where('vendor_key', isset($request['vendor']) ? $request['vendor'] : Auth::user()->user_uid)
            ->delete();

        $job = new FabricJobNew($fabricId);
        $returnData = dispatch($job);

        if ($returnData) {
            return response()->json(['message_code' => 1, "message" => "Fabric deleted successfully"], 200);
        } else {
            return response()->json(['message_code' => 0, "message" => "Fabric not uploaded"], 200);
        }
    }

    /**
     * Create fabric JSON after creating or updating fabric 
     */
    public function createFabricJSON(Request $request)
    {
        try {
            $vendorId = auth()->user()->vendor_id;
            $checksum = Vendor::where('vendor_id', $vendorId)->value('user_uid');
    
            $vendorFabrics = VendorFabric::where('vendor_id', $vendorId)->get()->keyBy('fabric_id');
    
            $vendorBrand = VendorBrand::with('brand')
                ->where('vendor_id', $vendorId)
                ->first();
    
            if (!$vendorBrand) {
                return response()->json(['message' => 'Vendor Brand not found'], 404);
            }
    
            $vendorName = $vendorBrand->brand->brand_name;
    
            $productOptions = [
                'Shirt' => ['SHIRT', 'SHIRT_THREAD_HOLE', 'SHIRT_BUTTON_T'],
                'Suit' => ['SUIT', 'SUIT_INNER_LINING', 'SUIT_BUTTON_THREAD', 'SUIT_BUTTON'],
                'Waistcoat' => ['WAISTCOAT', 'WAISTCOAT_INNER_LINING', 'WAISTCOAT_BUTTON_THREAD', 'WAISTCOAT_BUTTON'],
                'Jacket' => ['JACKET', 'JACKET_INNER_LINING', 'JACKET_BUTTON_THREAD', 'JACKET_BUTTON'],
                'Bundy' => ['BUNDY', 'BUNDY_BUTTON'],
                'Bandhgala' => ['BANDHGALA', 'BANDHGALA_BUTTON_THREAD', 'BANDHGALA_BUTTON'],
                'Trouser' => ['TROUSER'],
                'Women'=> ["WOMEN_SHIRT", "SHIRT_CONTRAST", "SHIRT_THREAD_HOLE", "SHIRT_BUTTON_T"],
            ];
    
            $desiredProductType = ucfirst(strtolower($request['text']));
    
            if (!isset($productOptions[$desiredProductType])) {
                return response()->json(['message' => 'Invalid product type'], 400);
            }
    
            $fabricIds = $vendorFabrics->keys();
    
            $fabricData = Fabric::whereIn('fabric_id', $fabricIds)
                ->whereIn('product_type', $productOptions[$desiredProductType])
                ->get()
                ->map(function ($fabric) use ($vendorFabrics, $checksum) {
                    return [
                        'BLEND' => $fabric->fabric_blend ?? '',
                        'BRAND' => $fabric->brand ?? '',
                        'BestfitPath' => $fabric->bestfit_image ?? '',
                        'COLOUR' => $fabric->color ?? '',
                        'DESIGN' => $fabric->design_pattern ?? '',
                        'Description' => $fabric->description ?? '',
                        'FabricPath' => $fabric->original_image ?? '',
                        'Id' => $fabric->tailori_fabric_code ?? '',
                        'LibraryName' => strtoupper($fabric->product_type),
                        'Name' => $fabric->fabric_name,
                        'Price' => $fabric->price ?? 0,
                        'ThumbPath' => $fabric->thumbnail_image ?? '',
                        'isactive' => $vendorFabrics[$fabric->fabric_id]->is_active ?? 0,
                        'order' => $fabric->sort_order ?? 0,
                        'vendor_key' => $checksum,
                    ];
                });
                // ->groupBy('LibraryName');
    
            $formattedData = [];
            
            if (isset($fabricData[$productOptions[$desiredProductType][0]])) {
                $formattedData[0] = $fabricData[$productOptions[$desiredProductType][0]]->values()->toArray();
            }
    
            $index = 1;
            foreach ($productOptions[$desiredProductType] as $category) {
                if ($category !== $productOptions[$desiredProductType][0] && isset($fabricData[$category])) {
                    $formattedData[$index] = [
                        $category => $fabricData[$category]->values()->toArray()
                    ];
                    $index++;
                }
            }
    
            $data = [
                'vendor_name' => $vendorName,
                'fabrics' => json_encode($fabricData),
                'checksum' => $checksum,
                'product_type' => $desiredProductType,
            ];
    
            $client = new Client();
            $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL'));
            $externalUrl = $apiurl . "api/UploadFabricJson?DeleteExistingJson=true";
    
            $response = $client->post($externalUrl, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-CSRF-TOKEN' => csrf_token(),
                ],
            ]);
    
            $apiResponse = json_decode($response->getBody(), true);
    
            return response()->json(['message' => 'Data sent successfully', 'response' => $apiResponse]);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred: ' . $e->getMessage()], 500);
        }
    }    

    public function GetVendorProducts1(Request $request)
    {
        $vendorId = auth()->user()->vendor_id;
        $products_ids = VendorProduct::where('vendor_id', $vendorId)->pluck('tailori_products_id')->toArray();

        $products = TailoriProduct::whereIn('tailori_products_id', $products_ids)
                        ->where('is_active', 1)
                        ->get();

        return response()->json($products);
    }

    /**
     * Create JSON file for a given product type after updating or adding configurators 
     */
    public function createJson(Request $request)
    {
        $vendorId = auth()->user()->vendor_id;
        $appKey = Vendor::where('vendor_id', $vendorId)->value('user_uid');
        $apiUrl = preg_replace('/\/v1/', '', config('constants.API_URL'));
        
        $response = file_get_contents("{$apiUrl}/api/GetPath?key={$appKey}");
        $serviceData = json_decode($response, true);
        
        if (!$serviceData) {
            return response()->json(['error' => 'Failed to fetch path data'], 500);
        }
        
        $cachePath = $serviceData['Path'] ?? '';
        $cdnPath = $serviceData['Path'] ?? '';
        $clientName = $serviceData['ClientName'] ?? '';
        $isCdn = $serviceData['iscdn'] ?? 'false';
        $s3Path = $isCdn === "true" ? null : $serviceData['Path'];
        $username = $serviceData['UserName'] ?? '';
        
        $text = $request->input('text', null) ?? $request->product;
        $men_products = ['shirt', 'suit', 'jacket', 'trouser', 'waistcoat', 'bandhgala', 'bundys','women'];

        if (!$text) {
            $product_id = $request->input('product_id');
            $product_name = TailoriProduct::where('tailori_products_id', $product_id)->value('product_name');

            $product_name_lower = strtolower($product_name);

            if (in_array($product_name_lower, $men_products)) {
                $text = "men-" . $product_name_lower;
            } else {
                $text = "women-" . $product_name_lower;
            }
        } else {
            $text_lower = strtolower($text);
            if (!(substr($text_lower, 0, 4) === 'men-' || substr($text_lower, 0, 6) === 'women-')) {
                if (in_array($text_lower, $men_products)) {
                    $text = "men-" . $text_lower;
                } else {
                    $text = "women-" . $text_lower;
                }
            }
        }
        $fileUrl = $isCdn === "true" 
            ? "$cdnPath/files/v1/$clientName/ProductImages/Configuartion/$text.json/json-file"
            : "$s3Path/$clientName/ProductImages/Configuartion/$text.json";
    
        $configResponse = file_get_contents($fileUrl);
        $configData = json_decode($configResponse, true);
        
        if (!$configData) {
            return response()->json(['error' => 'Failed to fetch configuration data'], 500);
        }
        
        $enrichedProducts = [];
        
        $userResponse = file_get_contents(route('generate.id') . "?username=$username&text=$text");
        $userData = json_decode($userResponse, true);
        
        if (!$userData) {
            return response()->json(['error' => 'Failed to fetch user data'], 500);
        }
        
        $userId = $userData['user_id'] ?? '';
        $checksum = $userData['Checksum'] ?? '';
        $products = $userData['elementsid'] ?? [];
        $idsToRemove = ["7F35C1511", "4648D9A85", "89A78609A", "MONFWS", "MONCWS"];
        $products = array_diff($products, $idsToRemove);
    
        foreach ($products as $productId) {
            $vendorResponse = file_get_contents(route('vendor.package.attribute.get.active') . "?elementId=$productId&userId=$userId");
            $vendorData = json_decode($vendorResponse, true);
            
            if (!$vendorData) {
                continue;
            }
            
            foreach ($configData['Product'] as &$product) {
                if ($product['Id'] === $productId) {
                    if (!empty($product['Options'][0]['Features'])) {
                        $existingFeatures = [];
                        foreach ($product['Options'][0]['Features'] as $existingFeature) {
                            $existingFeatures[$existingFeature['Id']] = $existingFeature;
                        }
            
                        if ($productId === "395D39A3E") {
                            if (!empty($product['Options'][0]['Features'][0])) {
                                $product['Options'][0]['Features'][0] = [
                                    'Alignment' => $product['Options'][0]['Features'][0]['Alignment'] ?? 'FACE',
                                    'DataAttr' => $product['Options'][0]['Features'][0]['DataAttr'] ?? " data-tds-element='{$vendorData['Features'][0]['tailori_attribute_code']}' data-tds-key='{$vendorData['Features'][0]['id']}'",
                                    'DrapeOrderNo' => $product['Options'][0]['Features'][0]['DrapeOrderNo'] ?? $vendorData['Features'][0]['DrapeOrderNo'] ?? null,
                                    'FeatureAlignments' => $product['Options'][0]['Features'][0]['FeatureAlignments'] ?? ["FACE", "BACK", "FACE OPEN", "BACK OPEN"],
                                    'Id' => $product['Options'][0]['Features'][0]['Id'] ?? $vendorData['Features'][0]['tailori_attribute_code'],
                                    'ImageSource' => $vendorData['Features'][0]['child_thumb_image'] ?? $vendorData['Features'][0]['image'],
                                    'Name' => $vendorData['Features'][0]['Name'] ?? $vendorData['Features'][0]['attribute_name'],
                                    'Price' => $vendorData['Features'][0]['price'] ?? '100',
                                    'order' => $vendorData['Features'][0]['order'] ?? 1
                                ];
                            }
            
                            foreach ($vendorData['Features'] as $feature) {
                                if (!isset($existingFeatures[$feature['tailori_attribute_code']])) {
                                    $product['Options'][0]['Features'][] = [
                                        'Alignment' => 'FACE',
                                        'DataAttr' => " data-tds-element='{$feature['tailori_attribute_code']}' data-tds-key='{$feature['id']}'",
                                        'DrapeOrderNo' => $feature['DrapeOrderNo'] ?? null,
                                        'FeatureAlignments' => ["FACE", "BACK", "FACE OPEN", "BACK OPEN"],
                                        'Id' => $feature['tailori_attribute_code'],
                                        'ImageSource' => $feature['child_thumb_image'] ?? $feature['image'],
                                        'Name' => $feature['Name'] ?? $feature['attribute_name'],
                                        'Price' => $feature['price'] ?? '100',
                                        'order' => $feature['order'] ?? 1
                                    ];
                                }
                            }
                        } else {
                            $product['Options'][0]['Features'] = array_map(function ($feature) use ($existingFeatures) {
                                $featureId = $feature['tailori_attribute_code'];
                                $existingFeature = $existingFeatures[$featureId] ?? [];
            
                                return [
                                    'Alignment' => $existingFeature['Alignment'] ?? 'FACE',
                                    'DataAttr' => $existingFeature['DataAttr'] ?? " data-tds-element='{$featureId}' data-tds-key='{$feature['id']}'",
                                    'DrapeOrderNo' => $existingFeature['DrapeOrderNo'] ?? $feature['DrapeOrderNo'] ?? null,
                                    'FeatureAlignments' => $existingFeature['FeatureAlignments'] ?? ["FACE", "BACK", "FACE OPEN", "BACK OPEN"],
                                    'Id' => $existingFeature['Id'] ?? $featureId,
                                    'ImageSource' => $feature['child_thumb_image'] ?? $feature['image'],
                                    'Name' => $feature['Name'] ?? $feature['attribute_name'],
                                    'Price' => $feature['price'] ?? '100',
                                    'order' => $feature['order'] ?? 1
                                ];
                            }, $vendorData['Features'] ?? []);
                        }
                    }
            
                    if (!empty($vendorData['Parent'])) {
                        $product['Name'] = $vendorData['Parent']['Name'] ?? $product['Name'];
                        $product['ImageSource'] = $vendorData['Parent']['ImageSource'] ?? $product['ImageSource'];
                        $product['parent_order'] = $vendorData['Parent']['parent_order'] ?? $product['parent_order'];
                    }
            
                    $enrichedProducts[] = $product;
                }
            }
        }
    
        usort($enrichedProducts, function ($a, $b) {
            return ($a['parent_order'] ?? 0) <=> ($b['parent_order'] ?? 0);
        });
    
        $configData['Product'] = $enrichedProducts;
        $configData['checksum'] = $checksum;
        $configData['Productname'] = $text;
    
        try {
            $client = new Client();
            $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL'));
            $url = $apiurl . "api/UploadConfigurationJson?DeleteExistingJson=true";
    
            if (is_string($configData)) {
                $configData = json_decode($configData[0], true);
            }
            $response = $client->request('POST', $url, [
                'json' => $configData,
                'headers' => [
                    'X-CSRF-TOKEN' => csrf_token(),
                ],
            ]);
    
            return response()->json(json_decode($response->getBody()->getContents()), $response->getStatusCode());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload configuration.',
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }
}
