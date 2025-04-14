<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\User;
use App\Jobs\VendorJob;
use Yajra\Datatables\Datatables;
use Hash;
use Config,Auth;
use App\Models\UserPackage;
use App\Models\PackageProduct;
use App\Models\Vendor;
use App\Models\VendorPackageAttributeSelection;
use App\Models\TailoriProductElementStyleAttributes;
use App\Models\TailoriProductElement;
use App\Jobs\SendAccountActivateEmailJob;
use Validator,Log;

class VendorsController extends Controller
{   
    private $appKey;

    public function __construct()
    {
        $this->middleware('auth');
        $client = new Client;
        $request = $client->get(Config::get('constants.API_URL').'LoginUsers?UserName='.Config::get('constants.API_USERNAME').'&PasswordHash='.Config::get('constants.API_PASSWORD'));
        $this->appKey = $request->getBody()->getContents();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('admin.tailori-vendors.index');
    }

    public function getVendors(){
        
        $vendors = Vendor::where('issuperadmin', 2)->get();
        return Datatables::of($vendors)
        ->editColumn('status', function($vendors){
            if($vendors->status == 0)
                return '<span class="badge bg-danger">Disabled</span>';
            else
                return '<span class="badge bg-success-400">Active</span>';
        })
        ->addColumn('action', function($vendors){

            if($vendors->status == 0){
                $changeStatusTo = 'Activate';
                $setTo = 1;
            }
            else{
                $changeStatusTo = 'Disable';
                $setTo = 0;
            }
            return '<ul class="list-inline mb-0">
                <li class="dropdown">
                    <a href="#" class="list-icons-item text-teal-600 dropdown-toggle text-default" data-toggle="dropdown" aria-expanded="false"><i class="icon-cog6"></i></a>
                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 17px, 0px);">
                        <a href="#" class="dropdown-item" onclick="updateVendorStatus('.$vendors->vendor_id.', '.$setTo.')"><i class="icon-pencil7"></i>'.$changeStatusTo.'</a>
                         <a href="#" class="dropdown-item" onclick="editVendor('.$vendors->vendor_id.')"><i class="icon-pencil"></i>Edit</a>
                         <a href="#" class="dropdown-item" onclick="getProducts('.$vendors->vendor_id.')" data-toggle="modal" data-target="#vendorProducts"><i class="fas fa-edit"></i>Edit Vendor Products</a>
                        <a href="#" class="dropdown-item"  onclick="showSubscription('.$vendors->vendor_id.')"><i class="icon-eye"></i>Subscription</a>
                         </ul>
                </li>
            </ul>';
        })
        ->rawColumns(['status', 'action', 'name'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $isRegistered = 0;
        $vendorId = '';
        $firstName = $request['first_name'];
        $lastName = $request['last_name'];
        $contactNumber = $request['contact_number'];
        $email = $request['email'];
        $username = $request['username'];
        $password = Hash::make($request['password']);

        $params['UserName']=  $username;
        $params['Forename']= $firstName;
        $params['Surname']= $lastName;
        $params['Email']= $email;
        $params['phone']= $contactNumber;
        $params['Mobile']= $contactNumber;
        $params['PasswordHash']= $password;
        $params['Key']= $this->appKey;
        $params['StoreURL']= $request['store_url'];
        $params['vendorProducts'] = $request['vendorProducts'];

        $addressParams = [
            'store_name'=> $request['store_name'],
            'city' => $request['city'],
            'state' => $request['state'],
            'pincode' => $request['pincode'],
            'address' => $request['address']
        ];

        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'body'=> json_encode($params)
        ];
 
         $job = (new VendorJob($options, $addressParams, $isRegistered, $vendorId));

        dispatch($job);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = User::find($id);
        $subscribedPackage = UserPackage::where('user_id', auth()->user()->id)->with('package')->get();
        
        return view('admin.tailori-vendors.show')->with('vendor', $vendor)->with('package', $subscribedPackage);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editVendor($id)
    {
        //user group 1 for super admin user, 2 is for vendor_Admin_user and 3 for normal user
        $vendor = Vendor::with(['users' => function($query) use ($id) {
            $query->where('vendor_id', $id) 
                  ->where('user_group', 2);
        }])->find($id);
        return response()->json($vendor);
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateVendor(Request $request, $id)
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

    public function updateVendorStatus(Request $request){
        
        $vendorId = $request['vendorId'];

        $setToStatus = $request['setToStatus'];
       
        $userPluginKey = Vendor::where('vendor_id', $vendorId)->value('user_uid');

        if($userPluginKey == ''){
            
            $isRegistered = 1;

            $vendor = Vendor::where('vendor_id', $vendorId)->get()->toArray();
            $params['UserName']= $vendor[0]['username'];
            $params['Forename']= $vendor[0]['name'];
            $params['Surname']= $vendor[0]['name'];
            $params['Email']= $vendor[0]['email'];
            $params['phone']= $vendor[0]['contact_number'];
            $params['Mobile']= $vendor[0]['contact_number'];
            $params['PasswordHash']= 'password';
            $params['Key']= $this->appKey;
    
            $addressParams = [
                'store_name'=> $vendor[0]['store_name'],
                'city' => $vendor[0]['city'],
                'state' => $vendor[0]['state'],
                'pincode' => $vendor[0]['pincode'],
                'address' => $vendor[0]['address']
            ];
    
            $options = [
                'headers' => ['Content-Type' => 'application/json'],
                'body'=> json_encode($params)
            ];
        
            $job = (new VendorJob($options, $addressParams, $isRegistered, $vendorId));
    
            dispatch($job);
        }
        else{
            $isUpdated = Vendor::where('vendor_id', $vendorId)->update(['status'=>$setToStatus]);
            if($setToStatus){

                dispatch(new SendAccountActivateEmailJob($vendorId));
            }

            return $isUpdated;
        }
    }

    public function getVendorPackage($id){
       /*  $packageId = UserPackage::where('user_id', $id)->value('package_id');
        $packageProducts = PackageProduct::where('package_id', $packageId)->with('tailoriProducts')->get()->toArray();
        echo '<pre>';
        print_r($packageProducts); */
    }

    public function showChangePasswordForm()
    {
        return view('auth.changepassword');
    }
    public function changePassword(Request $request)
    {
            $validator = Validator::make($request->all(),[
                'current_password' => 'required',
                'new_password'     => 'required|string|min:8|confirmed',
                 ],
                 ['current_password.required' => 'Enter Current Password',
                  'new_password.required' => 'Enter New Password',
                  'new_password.min' => 'Enter at least 8 characters',
                ]
            );

            if($validator->fails()) 
            {
              return response()->json(['message_code'=> 0,'message'=>$validator->errors()->first()],200);            
            }

            if (!(Hash::check($request->get('current_password'), Auth::user()->password))) 
            {
                return response()->json(['message_code'=> 0,'message'=>'Your current password does not matches with the password you provided. Please try again.'],200);
            }
            if(strcmp($request->get('current_password'), $request->get('new_password')) == 0)
            {
                return response()->json(['message_code'=> 0,'message'=>'New Password cannot be same as your current password. Please choose a different password.'],200);
            }
            //Change Password
            $userId         = Auth::user()->id;
            $user           = User::find($userId); 
            $user->password = bcrypt($request->get('new_password'));
            $is_updated      = $user->save();

            Log::info('Change Password <br> Request: '.json_encode($request->all()).'<br>Response: '.json_encode($is_updated));
            
            if($is_updated)
            {
                return response()->json(['message_code'=> 1,'message'=>'Password changed successfully'],200);
            }
            else
            {
                return response()->json(['message_code'=> 0,'message'=>'Not Updated'],200);
            }        
    }

    public function showProfile($id)
    {
        if(Auth::user()->vendor_id == $id){
            $vendor      = Vendor::where('vendor_id',$id)->get()->first();
            $nameArr =  explode(' ',Auth::user()->name);
            $vendor->first_name = $nameArr[0];
            $vendor->last_name = isset($nameArr[1])?$nameArr[1]:'';
            $vendor->email = Auth::user()->email;
            
            return view('site.my-account',compact('vendor'));
        }
        else{
            return redirect()->back();
        }
    }

    

    public function profileUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
          'first_name' => 'required',
          'last_name' => 'required',
          'contact_number' => 'required',
          'state' => 'required',
          'city' => 'required',
          'address' => 'required',
          'store_name' => 'required',
          'store_url' => 'required',
          'username' => 'required',
        ]);

        if ($validator->fails()) 
        { 
          return response()->json(['error',$validator->errors()],400);            
        }
        $vendorId = $id == 'null' ? Auth::user()->vendor_id : (int)$id;//shubham Added purpose : To Edit vendor Details

        $user = User::where('vendor_id',$vendorId)-> first();
    
        $user->name = $request['first_name'].' '.$request['last_name'];

        $user->save();

        $vendor = Vendor::where('vendor_id',$vendorId)->first();

        $vendor -> username = $request['username'];

        $vendor->store_url = $request['store_url'];

        $vendor->contact_number = $request['contact_number'];

        $vendor->city = $request['city'];
        
        $vendor->state = $request['state'];
        
        $vendor->pincode = $request['pincode'];
        
        $vendor->address = $request['address'];

        $vendor->store_name = $request['store_name'];

        $vendor->save();


        //below code is for update user details in syestem user table
        $params["UserName"] = $vendor->username;

        if($request->email){
            $params["Email"] = $request->email;
        }
        if($request->first_name){
            $params["Forename"] = $request->first_name;
        }
        if($request->last_name){
            $params["Surname"] = $request->last_name;
        }
        if($request->store_url){
            $params["store_url"] = $request->store_url;
        }
        if($request->contact_number){
            $params["Phone"] = $request->contact_number;
        }
        if($request->contact_number){
            $params["Mobile"] = $request->contact_number;
        }
        
        
        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'body'=> json_encode($params)
        ];

        $client = new Client;

        $url = Config::get('constants.API_URL').'UpdateUser1?id='.$vendor->user_uid;

        $request = $client->request('PATCH', $url, $options);

        $response = $request->getBody()->getContents();
    
        if($request->getStatusCode() == 200){
            return redirect()->back()->with('message','Profile Updated Successfully !');
        }
        else{
            return redirect()->back()->with('message','Profile Not Updated !');
        }
    }
}
