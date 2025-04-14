<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TailoriProduct;
use App\Models\TailoriProductElement;
use App\Models\TailoriProductElementStyle;
use App\Models\TailoriProductElementStyleAttributes;
use App\Models\VendorPackageAttributeSelection;
use App\Models\VendorProductAttributeSelection;
use App\Jobs\SendActivatePackageMailJob;
use App\Models\Package;
use App\Models\UserPackage;
use App\Models\PackageProduct;
use App\User;
header('Access-Control-Allow-Origin: *');

class PackageController extends Controller
{

    public function index(Request $request){
        
        $tailori_element_code = $request['elementId'];
        
        $elementId = TailoriProductElement::where('tailori_element_code', $tailori_element_code)->value('id');

        $attributes = VendorProductAttributeSelection::select('id', 'element_id', 'style_id', 'attribute_id', 'price', 'style_name','sort_order')
        ->with('styles')
        ->with(['attributes' => function($query){
            $query->select('id', 'tailori_attribute_code', 'attribute_name');
        }])
        ->where('vendor_id', $request['userId'])
            ->where('element_id', $elementId)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get()
            ->toArray();
        
        // Return null if there are no attributes
        if (empty($attributes)) {
            return json_encode(null);
        }

        $attributeRecords = [];

        foreach($attributes as $attribute){
            $attributeRecords[] = array_merge(
                $attribute['attributes'],
                array('recordId'=>$attribute['id']),
                array('element_id'=>$attribute['element_id']), 
                array('style_name'=>$attribute['style_name']),
                array('price'=>$attribute['price']),
                array('style_id'=>$attribute['style_id']),
                array('sort_order'=>$attribute['sort_order']),
                array('tailori_style_code'=> $attribute['styles']['tailori_style_code'])
            );
        }

        foreach ($attributeRecords as $key => $item) {
            $arr[$item['tailori_style_code']][] = $item;
        }

        ksort($arr, SORT_NUMERIC);
        
        return json_encode($arr);
    }
    public function activeAtrributes(Request $request){
        $tailori_element_code = $request['elementId'];
        $elementId = TailoriProductElement::where('tailori_element_code', $tailori_element_code)->value('id');
    
        $attributes = VendorProductAttributeSelection::select(
                'id', 'element_id', 'style_id', 'attribute_id', 'price', 'style_name', 
                'sort_order', 'child_thumb_image', 'parent_thumb_image', 
                'parent_style_name', 'parent_sort_order'
            )
            ->with(['attributes' => function($query){
                $query->select('id', 'tailori_attribute_code', 'attribute_name', 'image');
            }])
            ->where('vendor_id', $request['userId'])
            ->where('element_id', $elementId)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get()
            ->toArray();
    
        if (empty($attributes)) {
            return json_encode(null);
        }
    
        $attributeRecords = [];
    
        foreach ($attributes as $attribute) {
            $modifiedFeature = $attribute['attributes'];
            $modifiedFeature['Name'] = $attribute['style_name'];
            $modifiedFeature['ImageSource'] = $attribute['child_thumb_image'] ?? $attribute['attributes']['image'];
            $modifiedFeature['price'] = $attribute['price'];
            $modifiedFeature['order'] = $attribute['sort_order'];
    
            $attributeRecords[] = $modifiedFeature;
        }
    
        usort($attributeRecords, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });
    
        $parentData = [
            'Name' => $attributes[0]['parent_style_name'] ?? null,
            'ImageSource' => $attributes[0]['parent_thumb_image'] ?? null,
            'parent_order' => $attributes[0]['parent_sort_order'] ?? null,
        ];
    
        $responseData = [
            'Features' => $attributeRecords,
            'Parent' => $parentData
        ];
    
        return json_encode($responseData);
    }
    

    public function getAttributePrice(Request $request)
    {
        $record = VendorProductAttributeSelection::where('id', $request['record_id'])->get()->toArray();

        $attributeId  = $record[0]['attribute_id'];

        $tailori_attribute_code = TailoriProductElementStyleAttributes::where('id',$attributeId)->first()->tailori_attribute_code;
        $record[0]['attribute_code'] = $tailori_attribute_code;

        return json_encode($record);
    }

    public function getCartAttributePrice(Request $request)
    {
        $total = 0;
        if(count($request->all()))
        {
            foreach ($request->all() as $key => $value) 
            {
                $total += VendorPackageAttributeSelection::where('element_id', $value['element_id'])->where('attribute_id', $value['attribute_id'])->where('vendor_id',$value['vendor_id'])->first()->price; //Nikhil Shahu
            }
        }
        return $total;
    }

    public function userPackageElement()
    {
        $package_enabled = 0;

        $pack = User::where('id',Auth::user()->id)->with('userPackage')->first()->toArray();
        
        if(array_key_exists("user_package",$pack) && isset($pack['user_package']))
        {
            $package_enabled = 1;
        }

        $selections = VendorPackageAttributeSelection::where('vendor_id', auth()->user()->id)
        ->where('is_active', 1)
        ->with('styles')
        ->with('attributes')
        ->get()
        ->groupBy(['elements.product_id', 'elements.element_name'])
        ->toArray();
       
        $products = TailoriProduct::pluck('product_name', 'id');

        $packages = Package::whereIn('id',[$pack['user_package']['package_id']])->with(['packageProducts' => function($query){
            $query->with('tailoriProducts');
            }])->get()->toArray();

        return view('admin.tailori-vendors.vendor-elements')->withSelections($selections)->withPackages($packages)->with('products', $products)->with('is_package_enabled',$package_enabled);
    }

    public function registerPackage(Request $request)
    {
        $package_secret = $request['package_secret'];

        if($package_secret)
        {    
            $package = Package::where('package_secret', $package_secret)->first();
    
            $userPackage = UserPackage::create([
                'user_id' => Auth::user()->id ,
                'package_id' =>  $package->id
            ]);

            $data = [
                'package_name' => $package->package_name,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'price' => $package->price,
                'validity_years' => $package->validity_years,
        ];

            dispatch(new SendActivatePackageMailJob($data));

            return json_encode(['status'=>1,"message"=>"Package Registered Successfully"]);
        }

    }
}
