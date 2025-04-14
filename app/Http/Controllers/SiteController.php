<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class SiteController extends Controller
{   
    public function pricing(){
        $packages = Package::with(['packageProducts' => function($query){
            $query->with('tailoriProducts');
        }])->get()->toArray();

        $index = 0;
        $packageArr = [];

        foreach ($packages as $key => $value) 
        {
        	$productArr = [];
        	$product = $value['package_products'];
        	foreach ($product as $key => $result_product) 
        	{
        		array_push($productArr,$result_product['tailori_products']['product_name']);
        	}
        	$packages[$index]['product'] =  implode(',', $productArr);
        	$index++;
        }
        
        return view('site.pricing')->with('packages', $packages);
    }
}
