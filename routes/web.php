<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view('site.home');
});
Route::get('/pricing', 'SiteController@pricing')->name('pricing');
Route::post('checkEmail',    'Auth\RegisterController@checkEmailAvailability')->name('check-Email');

// Registration Routes...
/*Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
*//* Front page routes */
//Route::get('/', 'SiteController@index')->name('site.home');

/* User authentication routes */
Auth::routes(['register' => false]);

/* Home/Dashboard routes */
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/register-package', 'PackageController@registerPackage')->name('register.package');

/* Vendor routes */
Route::resource('/vendor', 'VendorsController')->middleware('user.type');
Route::get('/get-vendors', 'VendorsController@getVendors')->middleware('user.type')->name('vendor.get');
Route::get('/get-products', 'ProductsController@getVendorProducts')->middleware('user.type')->name('getProducts');//shubham Added purpose : To get products
Route::post('/store-products', 'ProductsController@storeVendorProducts')->middleware('user.type')->name('storeVendorProducts');//shubham Added purpose : To store products
//shubham Added purpose : To Edit vendor Details
Route::get('/edit-vendor/{id}', 'VendorsController@editVendor')->middleware('user.type')->name('vendor.edit');
//shubham working done
Route::get('/vendor-status', 'VendorsController@updateVendorStatus')->middleware('user.type')->name('vendor.status.update');
Route::get('/vendor-package/{id}', 'VendorsController@getVendorPackage')->middleware('user.type')->name('vendor.package.get');

/* Fabric routes */
Route::resource('/fabric', 'FabricController');
Route::get('/get-fabrics', 'FabricController@loadFabrics')->name('fabric.get');
Route::get('/tailori-fabrics-sync', 'FabricController@tailoriFabricSync')->name('fabric.tailori.sync');
Route::get('/tailori-fabrics-sync-to-store', 'FabricController@tailoriFabricSyncToStore')->name('fabric.tailori.sync.store');
Route::get('/fabric-list', 'FabricController@fabricGrid')->name('fabric.grid.get');
Route::post('/vendor-fabric-status', 'FabricController@setVendorFabricStatus')->name('vendor.fabric.status.store');
Route::post('/requested-fabric', 'FabricController@getRequestedFabric')->name('requested.fabric.get');
Route::post('/vendor-fabric-update', 'FabricController@vendorFabricUpdate')->name('vendor.fabric.update');
Route::post('/remove-vendor-fabric', 'FabricController@removeVendorFabric')->name('remove.vendor.fabric');
Route::post('/delete-vendor-fabric', 'FabricController@DeleteFromVendorPanel')->name('delete.vendor.fabric'); //Vijay
Route::post('/upload-vendor-fabric', 'FabricController@storemulti')->name('upload.vendor.storemulti'); //Vijay
Route::get('/create-fabric-json', 'FabricController@createFabricJSON')->name('create.json.fabric');
Route::POST('/create-json', 'FabricController@CreateJSON')->name('create.json');
Route::post('/forward-config-data', 'FabricController@forwardConfigData')->name('forward.config.data');
Route::get('/get-vendor-products', 'FabricController@GetVendorProducts1')->name('get.vendor.products');

/* Tailori assets synchronization routes */
Route::get('/tailori-product-sync', 'TailoriAssetSyncController@tailoriProductSync')->name('tailori.product.sync');
Route::get('/tailori-product-elements-sync', 'TailoriAssetSyncController@tailoriProductElementSync')->name('tailori.product.element.sync');
Route::get('/tailori-product-element-styles-sync', 'TailoriAssetSyncController@tailoriProductElementStyleSync')->name('tailori.product.element.style.sync');
Route::get('/tailori-product-element-style-attributes-sync', 'TailoriAssetSyncController@tailoriProductElementStyleAttributeSync')->name('tailori.product.element.style.attribute.sync');
Route::get('/tailori-product-element-image-sync', 'TailoriAssetSyncController@syncImages')->name('tailori.product.element.image.sync');
Route::get('/get-tailori-products', 'TailoriAssetSyncController@getTailoriProducts')->name('tailori.product.get');

/* Packages routes */
Route::get('/vendor-package-attribute', 'PackageController@index')->name('vendor.package.attribute.get');
Route::get('/vendor-package-attribute-active', 'PackageController@activeAtrributes')->name('vendor.package.attribute.get.active');
Route::get('/tailori-addon-price', 'PackageController@getAttributePrice')->name('tailori.addon-price');
Route::get('/vendor-package-elements', 'PackageController@userPackageElement')->name('vendor.package.elements');

/* Style attribute/Garment configurator routes */
Route::get('/tailori-configurator', 'StyleAttributeController@configurator')->name('tailori.garment.configurator');
Route::get('/tailori-products', 'StyleAttributeController@getTailoriProducts')->name('tailori.products.get');
Route::get('/tailori-elements', 'StyleAttributeController@getTailoriElements')->name('tailori.elements.get');
Route::get('/tailori-styles', 'StyleAttributeController@getTailoriStyles')->name('tailori.styles.get');
Route::get('/tailori-attributes', 'StyleAttributeController@getTailoriAttributes')->name('tailori.attributes.get');
Route::post('/store-configuration', 'StyleAttributeController@storeConfigurator')->name('tailori.configuration.store');
Route::get('/selection-limit', 'StyleAttributeController@getSelectionLimits')->name('tailori.selection.limit.get');
Route::get('/remove-configuration', 'StyleAttributeController@removeConfiguration')->name('tailori.configuration.remove');
Route::get('/attribute-data', 'StyleAttributeController@getAttributeData')->name('tailori.attribute.data.get');
Route::post('/update-attribute-data', 'StyleAttributeController@updateAttributeData')->name('tailori.attribute.data.update');
Route::get('/parent-attribute-data', 'StyleAttributeController@getParentAttributeData')->name('tailori.parent.attribute.data.get');
Route::post('/parent-update-attribute-data', 'StyleAttributeController@updateParentAttributeData')->name('tailori.parent.attribute.data.update');
Route::get('/non-selected-attributes', 'StyleAttributeController@getNonSelectedAttributes')->name('non.selected.attributes.get');
Route::post('/upload-child-image', 'StyleAttributeController@uploadChildImage')->name('upload.child.thumb.image');
Route::post('/upload-parent-image', 'StyleAttributeController@uploadParentImage')->name('upload.parent.thumb.image');
Route::post('/delete-child-thumb-image', 'StyleAttributeController@deleteChildThumbImage')->name('delete.child.thumb.image');
Route::post('/delete-parent-thumb-image', 'StyleAttributeController@deleteParentThumbImage')->name('delete.parent.thumb.image');

/* Error Page routes */
Route::get('/access-denied', 'ErrorPageController@accessDenied')->name('access.denied');

/*Change Password*/

Route::get('changePassword','VendorsController@showChangePasswordForm');

Route::get('show-profile/{id}','VendorsController@showProfile')->name('show.profile');

Route::post('changePassword','VendorsController@changePassword')->name('changePassword');
Route::post('vendor-update/{id}','VendorsController@profileUpdate')->name('vendor.update');

Route::get('get-subscription/{vendorId}','SubscriptionController@getSubscription')->name('getSubscription');
Route::post('store-subscription', 'SubscriptionController@storeSubscription')->name('storeSubscription');