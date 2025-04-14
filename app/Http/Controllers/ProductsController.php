<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TailoriProduct;
use App\Models\VendorProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
    public function getVendorProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendorId' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try {

            $vendorId = (int) $request->vendorId;

            $products = DB::table('tailori_products')
                ->leftJoin('vendor_products', function ($join) use ($vendorId) {
                    $join->on('tailori_products.tailori_products_id', '=', 'vendor_products.tailori_products_id')
                        ->where('vendor_products.vendor_id', $vendorId);
                })
                ->select(
                    'tailori_products.tailori_products_id',
                    'tailori_products.product_name',
                    DB::raw('COALESCE(vendor_products.fabric_limit, 0) as fabric_limit'),
                    // DB::raw('COALESCE(vendor_products.element_limit, 0) as element_limit'),
                    // DB::raw('COALESCE(vendor_products.style_limit, 0) as style_limit'),
                    DB::raw('COALESCE(vendor_products.attribute_limit, 0) as attribute_limit'),
                    DB::raw('IF(vendor_products.tailori_products_id IS NOT NULL, 1, 0) as isActive')
                )
                ->get();
            return json_encode($products);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 404);
        }
    }

    public function storeVendorProducts(Request $request)
    {
        try {
            $requestData = $request->all();
            $vendorId = (int) $requestData['vendorId'];
            $products = json_decode($requestData['data']);
            $putData = [];
            $selectedProducts = [];
            foreach ($products as $product) {
                $selectedProducts[] = $product->product_id;
                $validator = Validator::make((array)$product, [
                    'product_id' => 'required|integer',
                    'fabric_limit' => 'required|integer',
                    'attribute_limit' => 'required|integer',
                ]);
                if($validator -> passes()){
                    $vendorProduct = VendorProduct:: updateOrInsert(['vendor_id' => $vendorId, 'tailori_products_id' => $product->product_id],
                        [
                        'fabric_limit' => $product->fabric_limit,
                        'attribute_limit' => $product->attribute_limit,
                        'is_active' => 1,
                    ]);
                }else{
                    return response()->json(['error' => 'Some of Data Not Saved'], 401);
                }
             
            }
           VendorProduct::where('vendor_id',$vendorId )
                        ->whereNotIn('tailori_products_id', $selectedProducts)
                            ->delete();
                            
                return response()->json(['Done' => 'Saved Successfully'], 200);
            
        } catch (Exception $e) {
            return response()->json(['message' => $e], 404);
        }
    }
}