<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TailoriProduct;
use App\Models\TailoriProductElement;
use App\Models\TailoriProductElementStyle;
use App\Models\TailoriProductElementStyleAttributes;
use App\Models\UserPackage;
use App\Models\PackageProduct;
use App\Models\VendorPackageAttributeSelection;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\VendorProductAttributeSelection;
use GuzzleHttp\Client;
use App\Http\Controllers\FabricController;
use Config, Log;
header('Access-Control-Allow-Origin: *');

class StyleAttributeController extends Controller
{   
    /**
     * Initialize configurator
     */
    public function configurator(){
        $vendorId = auth()->user()->vendor_id;
        $isActiveUser = Vendor::where('vendor_id', auth()->user()->vendor_id)->where('status', 1)->count();

        if($isActiveUser >= 1){
            $vendor_product_ids = VendorProduct::where('vendor_id', $vendorId)
                ->where('is_active', 1)
                ->pluck('tailori_products_id'); 
            
            $vendor_products = TailoriProduct::whereIn('tailori_products_id', $vendor_product_ids)
                ->with('tailoriProducts')
                ->get()
                ->toArray();
        }
        else{
            $vendor_products = [];
        }
        return view('admin.configurator.index')->with('vendor_products', $vendor_products);
    }
    /**
     * Get tailori products
     */
    public function getTailoriProducts($packageId){
        $packageProducts = PackageProduct::where('package_id', $packageId)->with('tailoriProducts')->get()->toArray();
        return $packageProducts;
    }

    /**
     * Get tailori elements
     */
    public function getTailoriElements(Request $request){
        // $tailoriElements = TailoriProductElement::where('product_id', $request['productId'])->orderBy('sort_order')->get()->toJson();
        // return $tailoriElements;

        $vendorId = auth()->user()->vendor_id;

        // Fetch elements from TailoriProductElement
        $tailoriElements = TailoriProductElement::where('product_id', $request['productId'])
            ->get()
            ->toArray();

        // Fetch parent_style_name and parent_sort_order
        $customElementNames = VendorProductAttributeSelection::where('vendor_id', $vendorId)
            ->where('is_active', 1)
            ->pluck('parent_style_name', 'element_id')
            ->toArray();

        // Fetch parent_sort_order separately
        $parentSortOrders = VendorProductAttributeSelection::where('vendor_id', $vendorId)
            ->where('is_active', 1)
            ->pluck('parent_sort_order', 'element_id')
            ->toArray();

        // Assign custom names and sort order to elements
        foreach ($tailoriElements as &$element) {
            if (isset($customElementNames[$element['id']])) {
                $element['element_name'] = $customElementNames[$element['id']];
                $element['parent_sort_order'] = $parentSortOrders[$element['id']] ?? PHP_INT_MAX; // Default to a high number if not found
            } else {
                $element['parent_sort_order'] = PHP_INT_MAX; // Default order if not in $parentSortOrders
            }
        }

        // Sort by parent_sort_order
        usort($tailoriElements, function ($a, $b) {
            return $a['parent_sort_order'] <=> $b['parent_sort_order'];
        });

        // Remove parent_sort_order from final output (if needed)
        foreach ($tailoriElements as &$element) {
            unset($element['parent_sort_order']);
        }

        return response()->json($tailoriElements);
        // return $tailoriElements;
    }
    /**
     * Populate styles with attributes
     */
    public function getTailoriStyles(Request $request){
      
        $tailoriStyles = TailoriProductElementStyle::select(['id', 'tailori_style_code', 'style_name'])
        ->where('element_id', $request['elementId'])
        ->get()
        ->toArray();
    
        $styleIds = [];
        $styleNames = [];
        
        foreach ($tailoriStyles as $style) {
            $styleIds[] = $style['id'];
            $styleNames[$style['id']] = $style['style_name'];
        }
        
        $tailoriAttributes = TailoriProductElementStyleAttributes::whereIn('style_id', $styleIds)
            ->get()
            ->groupBy('style_id')
            ->toArray();
        
        $arr = [];
        foreach ($tailoriAttributes as $key => $attr) {
            for ($i = 0; $i < count($attr); $i++) {
                $isExist = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
                    ->where('attribute_id', $attr[$i]['id'])
                    ->where('is_active', 1)
                    ->count();
        
                $customStyleName = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
                    ->where('attribute_id', $attr[$i]['id'])
                    ->value('style_name');
        
                $customThumbImage = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
                    ->where('attribute_id', $attr[$i]['id'])
                    ->value('child_thumb_image');
        
                $sort_order = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
                    ->where('attribute_id', $attr[$i]['id'])
                    ->value('sort_order');
        
                $attr[$i]['is_selected'] = ($isExist == 1) ? 1 : 0;
                $attr[$i]['custom_style_name'] = $customStyleName;
                $attr[$i]['customThumbImage'] = $customThumbImage;
                $attr[$i]['sort_order'] = $sort_order;
            }
        
            // Sort attributes within each style group by `sort_order`
            usort($attr, function ($a, $b) {
                return $a['sort_order'] <=> $b['sort_order'];
            });
        
            $arr[$key] = $attr;
        }
        
        // Convert the sorted attributes into a structured array with style names
        $attributes = [];
        foreach ($styleNames as $key => $styleName) {
            $attributes[str_replace(' ', '_', $styleName)] = $arr[$key] ?? [];
        }
        
        return json_encode($attributes);
    }

    /** store or update configuration record(s) */
    public function storeConfigurator(Request $request){
       
        if($request['attributes']){
            // $packageId = UserPackage::where('user_id', auth()->user()->vendor_id)->where('is_active', 1)->value('package_id');
            $vendor_product_id = VendorProduct::where('vendor_id', auth()->user()->vendor_id)->where('is_active', 1)->value('vendor_products_id');
            $defaultAttributePrice = 0.00;
            foreach($request['attributes'] as $attributes){

                $attributeArray = explode('_', $attributes);

                $attr = explode('-', $attributeArray[1]);
                
                $isRecordExist = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where(['attribute_id'=> $attr[2], 'is_active'=> 0])->count();
                if($isRecordExist>0){
                    $data = VendorProductAttributeSelection::updateOrCreate(
                        [
                            'vendor_id'     => auth()->user()->vendor_id,
                            'vendor_product_id'    => $vendor_product_id,
                            'attribute_id'  => $attr[2]
                        ], 
                        [
                            'vendor_id'     => auth()->user()->vendor_id, 
                            'vendor_product_id'    => $vendor_product_id,
                            'element_id'    => $attr[0],
                            'style_id'      => $attr[1],
                            'attribute_id'  => $attr[2],
                            'is_active'     => 1
                        ]
                    );

                    echo $data->attribute_id;
                }
                else{
                    $attributeDetails = TailoriProductElementStyleAttributes::where('id', $attr[2])->get()->toArray();
                    //->value('attribute_name');
                    $attributeName = $attributeDetails[0]['attribute_name'];
                    $styleId = TailoriProductElementStyle::where('id', $attr[1])->value('element_id');
                    $element = TailoriProductElement::where('id', $styleId)->get()->toArray();
                    $elemntId = $attr[0];
                    $parentelementname = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('element_id', $elemntId)->value('parent_style_name');
                    VendorProductAttributeSelection::updateOrCreate(
                        [
                            'vendor_id'     => auth()->user()->vendor_id,
                            'vendor_product_id'    => $vendor_product_id,
                            'attribute_id'  => $attr[2]
                        ], 
                        [
                            'vendor_id'     => auth()->user()->vendor_id, 
                            'vendor_product_id'    => $vendor_product_id,
                            'element_id'    => $attr[0],
                            'style_id'      => $attr[1],
                            'attribute_id'  => $attr[2],
                            'style_name'    => $attributeName,
                            'parent_style_name'   => $parentelementname ?: $element[0]['element_name'],
                            'price'         => (float)$defaultAttributePrice,
                            'is_active'     => 1
                        ]
                    );
                }
            }
        }
        $fabricController = new FabricController;
        $fabricController->createJson($request);
    }

    /**
     * Get attribute selection limits by applied package
     */
    public function getSelectionLimits(Request $request){

        $vendorId   = auth()->user()->vendor_id;
        
        // $packageId  = UserPackage::where('user_id', $vendorId)->value('package_id');

        // $selectionLimits = PackageProduct::where(['package_id'=>$packageId, 'product_id'=>$request['productId']])->get()->toJson();

        $selectionLimits = VendorProduct::where(['vendor_id'=>$vendorId, 'tailori_products_id'=>$request['productId']])->get()->toJson();
    
        return $selectionLimits;
    }

    /**
     * Remove selected configuration record
     */
    public function removeConfiguration(Request $request){
        $attributeId    = $request['attributeId'];
        $isRecordExist  = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('attribute_id', $attributeId)->where('is_active', 1)->count();
        if($isRecordExist > 0){
            $isUpdated  = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('attribute_id', $attributeId)->update(['is_active'=>0]);
            $fabricController = new FabricController;
            $fabricController->createJson($request);
            return $isUpdated;
        }
        return 0;
    }

    /**
     * Get specific attribute data
     */
    public function getAttributeData(Request $request){

        $attributeId    = $request['attributeId'];

        $isRecordExist  = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('attribute_id', $attributeId)->count();

        if($isRecordExist > 0){
            $attributeData  = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('attribute_id', $attributeId)->get()->toArray();
            $attributeimage = TailoriProductElementStyleAttributes::where('id', $attributeId)->get()->toArray();
            $attributeName  = $attributeData[0]['style_name'];
            $attributePrice = $attributeData[0]['price'];
            $attributeOrder = (string) $attributeData[0]['sort_order'];
            $imageurl = $attributeimage[0]['image'];
            $tailori_attribute_code = $attributeimage[0]['tailori_attribute_code'];
            $vendor_thumb_image = $attributeData[0]['child_thumb_image'];
        }
        else{
            $attributeData  = TailoriProductElementStyleAttributes::where('id', $attributeId)->get()->toArray();
            $attributeName  = $attributeData[0]['attribute_name'];
            $attributePrice = (float)0.00;
            $imageurl = $attributeData[0]['image'];
            $vendor_thumb_image = NULL;
            $attributeOrder = (int)1;
        }

        $attributeProperties = ['name' => $attributeName, 'price' => $attributePrice,'Sequence'=>$attributeOrder,'imageurl'=>$imageurl,'vendor_thumb_image'=>$vendor_thumb_image];

        return json_encode($attributeProperties);
    }

    public function getParentAttributeData(Request $request){

        $element_id    = $request['elementIndex'];

        $isRecordExist  = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('element_id', $element_id)->count();

        if($isRecordExist > 0){
            $attributeData  = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('element_id', $element_id)->get()->toArray();
            $attributeimage = TailoriProductElement::where('id', $element_id)->get()->toArray();
            if($attributeData[0]['parent_style_name'] == NULL){
                $attributeName  = $attributeimage[0]['element_name'];
            }
            else{
                $attributeName  = $attributeData[0]['parent_style_name'];
            }
            $attributeOrder = (string) $attributeData[0]['parent_sort_order'];
            $imageurl = $attributeimage[0]['image_url'];
            $tailori_attribute_code = $attributeimage[0]['tailori_element_code'];
            $vendor_thumb_image = $attributeData[0]['parent_thumb_image'];
        }
        else{
            $attributeData  = TailoriProductElement::where('id', $element_id)->get()->toArray();
            $attributeName  = $attributeData[0]['element_name'];
            $imageurl = $attributeData[0]['image_url'];
            $vendor_thumb_image = NULL;
            $attributeOrder = $attributeData[0]['sort_order'];
        }

        $attributeProperties = ['name' => $attributeName,'Sequence'=>$attributeOrder,'imageurl'=>$imageurl,'vendor_thumb_image'=>$vendor_thumb_image];

        return json_encode($attributeProperties);
    }

    public function updateParentAttributeData(Request $request){
        $style_id  = TailoriProductElementStyle::where('element_id', $request['element_index'])->value('id');
        $attributeId    = TailoriProductElementStyleAttributes::where('style_id', $style_id)->value('id');
        $attributename = TailoriProductElement::where('id', $request['element_index'])->value('element_name');
        $attributeStyleName     = $request['parent_attribute_name'];
        $attributesequence    = $request['parent_attribute_sequence'];
        $isRecordExist = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
            ->where(function ($query) use ($attributename, $attributeStyleName) {
                $query->where('parent_style_name', $attributename)
                    ->orWhere('parent_style_name', $attributeStyleName);
            })->count();
        $product_name = TailoriProduct::where('tailori_products_id', $request->productId)->value('product_name');
        if($isRecordExist > 0){
			VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('element_id', $request['element_index'])->update(['parent_style_name'=> $attributeStyleName,'parent_sort_order'=>$attributesequence]);
        }
        else{
            $styleId    = TailoriProductElementStyleAttributes::where('id', $attributeId)->value('style_id');
            $elementId  = TailoriProductElementStyle::where('id', $styleId)->value('element_id');
            $vendorId   = auth()->user()->vendor_id;
            $vendor_product_id = VendorProduct::where('vendor_id', auth()->user()->vendor_id)->where('is_active', 1)->value('vendor_products_id');
            $attributeData  = TailoriProductElement::where('id', $elementId)->get()->toArray();
            VendorProductAttributeSelection::updateOrCreate(
                [
                    'vendor_id'     => $vendorId,
                    'vendor_product_id'    => $vendor_product_id,
                    'element_id'  => $elementId
                ],
                [
                    'vendor_id'     => $vendorId, 
                    'vendor_product_id'    => $vendor_product_id,
                    'element_id'    => $elementId,
                    'style_id'      => $styleId,
                    'attribute_id'  => $attributeId,
                    'parent_style_name'  => $attributeStyleName,
                    'is_active'  => 1,
                    'parent_thumb_image' => $attributeData[0]['image_url'],
                    'style_name' => $attributeData[0]['element_name'],
                    'parent_sort_order' => $attributesequence
                ]
            );
        }
        $fabricController = new FabricController;
        $fabricController->createJson($request);
        // return $response;
        // $response = $this->fabricController->createJson($product_name);
        // return $response;
    }

    /**
     * Store or update attribute details
     */
    public function updateAttributeData(Request $request){
        $attributeId            = $request['child_attr_id'];
        $attributeStyleName     = $request['style_name'];
        $attributeStylePrice    = $request['price'];
        $attributesequence    = $request['seq_name'];
        $datas = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('attribute_id', $attributeId)->get()->toArray();
        $product_id = VendorProduct::where('vendor_id', auth()->user()->vendor_id)->where('vendor_products_id', $datas[0]['vendor_product_id'])->value('tailori_products_id');
        $product_name = TailoriProduct::where('tailori_products_id', $product_id)->value('product_name');
        $isRecordExist          = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('attribute_id', $attributeId)->count();

        if($isRecordExist > 0){
			VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)->where('attribute_id', $attributeId)->update(['style_name'=> $attributeStyleName, 'price'=> $attributeStylePrice,'sort_order'=>$attributesequence]);
        }
        else{
            $styleId    = TailoriProductElementStyleAttributes::where('id', $attributeId)->value('style_id');
            $elementId  = TailoriProductElementStyle::where('id', $styleId)->value('element_id');
            $vendorId   = auth()->user()->vendor_id;
            // $packageId  = UserPackage::where('user_id', $vendorId)->value('package_id');
            $vendor_product_id = VendorProduct::where('vendor_id', auth()->user()->vendor_id)->where('is_active', 1)->value('vendor_products_id');

            VendorProductAttributeSelection::updateOrCreate(
                [
                    'vendor_id'     => $vendorId,
                    'vendor_product_id'    => $vendor_product_id,
                    'attribute_id'  => $attributeId
                ], 
                [
                    'vendor_id'     => $vendorId, 
                    'vendor_product_id'    => $vendor_product_id,
                    'element_id'    => $elementId,
                    'style_id'      => $styleId,
                    'attribute_id'  => $attributeId,
                    'style_name'    => $attributeStyleName,
                    'price'         => (float)$attributeStylePrice,
                    'is_active'     => 0
                ]
            );
        }
        $request = new Request(['text' => $product_name, ]);
        $fabricController = new FabricController;
        $fabricController->createJson($request);
    }

    public function getNonSelectedAttributes(Request $request){
        
        $userId = $request['userId'];
        $selections = VendorProductAttributeSelection::where('vendor_id', $userId)->where('is_active', 1)->pluck('element_id','attribute_id')->toArray();
        $selectedElements = [];
        $selectedAttributes = [];
        foreach($selections as $key=>$value){
            $selectedElements[]= $value;
            $selectedAttributes[]= $key;
        }
        $selectedElements = array_unique($selectedElements);
        $selectedAttributes = array_unique($selectedAttributes);

        $nonSelectedElements = TailoriProductElement::whereIn('id', $selectedElements)->pluck('tailori_element_code')->toArray();
        $nonSelectedAttributes = TailoriProductElementStyleAttributes::whereIn('id', $selectedAttributes)->pluck('tailori_attribute_code')->toArray();
       
        return [$nonSelectedElements, $nonSelectedAttributes];
    }

    public function uploadImage(Request $request)
    {
        $vendordata = Vendor::where('vendor_id', auth()->user()->vendor_id)->first();

        if (!$vendordata) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }

        $checksum = $vendordata->user_uid;
        $product_name = TailoriProduct::where('tailori_products_id', $request->productId)->value('product_name');

        $base64Image = $request->input('image');
        $base64Image = preg_replace('/^data:image\/[a-zA-Z]+;base64,/', '', $base64Image);
        $childAttrName = $request->input('childAttrName');
        $attributeimage = TailoriProductElementStyleAttributes::where('attribute_name', $childAttrName)->get()->toArray();

        if (empty($attributeimage)) {
            return response()->json(['error' => 'Attribute not found'], 404);
        }

        $imageurl = $attributeimage[0]['image'];
        $styleid = $attributeimage[0]['style_id'];
        $elementId = '';
        $matches = '';
        if (preg_match('/\/([a-zA-Z0-9]+)\.png$/', $imageurl, $matches)) {
            $elementId = $matches[1];
        }
        $issave = $request->input('issave', true);

        // Merge vendor_id and element_id into the request
        $request->merge([
            'checksum' => $checksum,
            'ElementId' => $elementId,
        ]);

        // Validate the request
        $request->validate([
            'checksum' => 'required|string',
            'ElementId' => 'required|string',
            'image' => 'required|string',
            '$issave' => 'required|string',
        ]);

        try {
            $client = new Client;

            $options = [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'checksum' => $checksum,
                    'ElementId' => $elementId,
                    'Base64' => $base64Image,
                    'issave' => $issave
                ])
            ];
            $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL')); 
            $url = $apiurl . "/api/IconImage";

            $request = $client->request('POST', $url, $options);

            $response = $request->getBody()->getContents();
            $response = json_decode($response, true);

            VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
                ->where('style_id', $styleid)
                ->update(['thumb_image' => $response]);
            
            $request = new Request(['text' => $product_name, ]);
            $fabricController = new FabricController;
            $fabricController->createJson($request);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteChildThumbImage(Request $request)
    {
        $attributeId = $request->attribute_id;

        $attribute = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
            ->where('attribute_id', $attributeId)
            ->first();
        $product_name = TailoriProduct::where('tailori_products_id', $request->productId)->value('product_name');

        if ($attribute && $attribute->child_thumb_image) {
            // Delete image file if stored locally
            $imagePath = public_path($attribute->child_thumb_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Remove from database
            $attribute->update(['child_thumb_image' => null]);
            $attributeimage = TailoriProductElementStyleAttributes::where('id', $attributeId)->get()->toArray();

            if (empty($attributeimage)) {
                return response()->json(['error' => 'Attribute not found'], 404);
            }

            $imageurl = $attributeimage[0]['image'];
            // Send delete request to service
            try {
                $vendorData = Vendor::where('vendor_id', auth()->user()->vendor_id)->first();
                if (!$vendorData) {
                    return response()->json(['error' => 'Vendor not found'], 404);
                }
        
                $checksum = $vendorData->user_uid;
                $issave = false; // Since we are deleting
                $base64Image = ""; // No image data on deletion
        
                $client = new Client();
                $options = [
                    'headers' => ['Content-Type' => 'application/json'],
                    'body' => json_encode([
                        'checksum' => $checksum,
                        'ElementId' => $attributeimage[0]['tailori_attribute_code'],
                        'Base64' => $base64Image,
                        'issave' => $issave
                    ])
                ];
                $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL')); 
                $url = $apiurl . "/api/IconImage";
                $request = $client->request('POST', $url, $options);
                $response = json_decode($request->getBody()->getContents(), true);
                $request = new Request(['text' => $product_name, ]);
                $fabricController = new FabricController;
                $fabricController->createJson($request);
        
                return response()->json([
                    'message' => 'Images deleted successfully',
                    'image_url' => $imageurl,
                    'attr_tailori_code'=>$attributeimage[0]['tailori_attribute_code'],
                    'service_response' => $response
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to send delete request: ' . $e->getMessage()], 500);
            }

            //return response()->json(['message' => 'Image deleted successfully','image_url'=>$imageurl,'attr_tailori_code'=>$attributeimage[0]['tailori_attribute_code']]);
        }
        $fabricController = new FabricController;
        $fabricController->createJson($request);
        return response()->json(['error' => 'Image not found'], 404);
	}

    // new work for thumb image parent and child
    // For parent work with elementids
    public function uploadParentImage(Request $request)
    {
        $vendorData = Vendor::where('vendor_id', auth()->user()->vendor_id)->first();
        if (!$vendorData) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }

        $checksum = $vendorData->user_uid;
        $base64Image = preg_replace('/^data:image\/[a-zA-Z]+;base64,/', '', $request->input('image'));
        $issave = $request->input('issave', true);
        $elementId = $request->elementId;
        $elementindex = $request->elementIndex;
        $product_name = TailoriProduct::where('tailori_products_id', $request->productId)->value('product_name');

        try {
            $client = new Client();
            $options = [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'checksum' => $checksum,
                    'ElementId' => $elementId,
                    'Base64' => $base64Image,
                    'issave' => $issave
                ])
            ];
            $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL')); 
            $url = $apiurl . "/api/IconImage";
            $request = $client->request('POST', $url, $options);
            $response = json_decode($request->getBody()->getContents(), true);

            VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
                ->where('element_id', $elementindex)
                ->update(['parent_thumb_image' => $issave ? $response : null]);

            $request = new Request(['text' => $product_name, ]);
            $fabricController = new FabricController;
            $fabricController->createJson($request);

            return response()->json([$response, 200]); //'image_url'=>$imageurl
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // for child work with attributeids
    public function uploadChildImage(Request $request)
    {
        $vendorData = Vendor::where('vendor_id', auth()->user()->vendor_id)->first();
        if (!$vendorData) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }

        $checksum = $vendorData->user_uid;
        $base64Image = preg_replace('/^data:image\/[a-zA-Z]+;base64,/', '', $request->input('image'));
        $issave = $request->input('issave', true);
        $elementId = $request->elementId;
        $childAttrName = $request->input('attribute_name');
        $product_name = TailoriProduct::where('tailori_products_id', $request->productId)->value('product_name');
        $attributeimage = TailoriProductElementStyleAttributes::where('id', $request->attribute_id)->get()->toArray();
        $tailori_attribute_code = $attributeimage[0]['tailori_attribute_code'];
        try {
            $client = new Client();
            $options = [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'checksum' => $checksum,
                    'ElementId' => $tailori_attribute_code,
                    'Base64' => $base64Image,
                    'issave' => $issave
                ])
            ];
            $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL')); 
            $url = $apiurl . "/api/IconImage";
            $request = $client->request('POST', $url, $options);
            $response = json_decode($request->getBody()->getContents(), true);
            VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
                ->where('style_name', $childAttrName)
                ->update(['child_thumb_image' => $issave ? $response : null]);

            $request = new Request(['text' => $product_name, ]);
            $fabricController = new FabricController;
            $fabricController->createJson($request);

            return response()->json([$response, 200,'attr_tailori_code'=>$tailori_attribute_code]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteParentThumbImage(Request $request)
    {
        $elementId = $request->elementIndex;
        $elementname = $request->elementId;
        $product_name = TailoriProduct::where('tailori_products_id', $request->productId)->value('product_name');
        $attributes = VendorProductAttributeSelection::where('vendor_id', auth()->user()->vendor_id)
            ->where('element_id', $elementId)
            ->get();
        
        if ($attributes->isNotEmpty()) {
            foreach ($attributes as $attribute) {
                if ($attribute->parent_thumb_image) {
                    $attribute->update(['parent_thumb_image' => null]);
                }
            }
        
            $attributeImage = TailoriProductElement::where('id', $elementId)->first();
            if (!$attributeImage) {
                return response()->json(['error' => 'Attribute not found'], 404);
            }
        
            $imageUrl = $attributeImage->image_url;
        
            try {
                $vendorData = Vendor::where('vendor_id', auth()->user()->vendor_id)->first();
                if (!$vendorData) {
                    return response()->json(['error' => 'Vendor not found'], 404);
                }
        
                $checksum = $vendorData->user_uid;
                $issave = false;
                $base64Image = null;
        
                $client = new Client();
                $options = [
                    'headers' => ['Content-Type' => 'application/json'],
                    'body' => json_encode([
                        'checksum' => $checksum,
                        'ElementId' => $elementname,
                        'Base64' => $base64Image,
                        'issave' => $issave
                    ])
                ];
                $apiurl = preg_replace('/\/v1/', '', Config::get('constants.API_URL')); 
                $url = $apiurl . "/api/IconImage";
                $request = $client->request('POST', $url, $options);
                $response = json_decode($request->getBody()->getContents(), true);
                $request = new Request(['text' => $product_name, ]);
                $fabricController = new FabricController;
                $fabricController->createJson($request);
        
                return response()->json([
                    'message' => 'Images deleted successfully',
                    'image_url' => $imageUrl,
                    'service_response' => $response
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to send delete request: ' . $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'Images not found'], 404);
    }
}
