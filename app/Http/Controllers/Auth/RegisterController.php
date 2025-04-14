<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Models\UserPackage;
use App\Models\Package;
use App\Jobs\SendEmailJob;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:255'],
            'lname' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:60'],
            'store_ui' => ['required'],
            'plugin_ui' => ['required'],
            'phonenumber' => ['required', 'numeric','digits:10'],
            'mobilenumber' => ['required', 'numeric','digits:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'].' '.$data['lname'],
            'lname' => $data['lname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'contact_number' => $data['mobilenumber'],
            'password' => Hash::make($data['password']),
            'plugin_ui' => $data['plugin_ui'],
            'store_ui' =>  $data['store_ui'],
            'status' => 0
        ]);
        //Mail::to($data['email'])->send(new WelcomeMail($data['name']));

        $details= array('email'=> $data['email'],'name'=>$data['name']);

        dispatch(new SendEmailJob($details));
        
        if($data['package_secret']){

            $packageSecret = $data['package_secret'];
    
            $package = Package::where('package_secret', $packageSecret)->first();
    
            $userPackage = UserPackage::create([
                'user_id' =>  $user->id,
                'package_id' =>  $package->id
            ]);
            User::where('id',$user->id)->update(['fabric_upload_limit'=>$package->fabric_limit]);
           //Mail::to($data['email'])->send(new WelcomeMail($data['name'])); 
        }
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        return redirect($this->redirectTo)->with('message', 'Account Registered successfully,You will only be able to login after an administrator approves and activates the account.');
    }

    protected function checkEmailAvailability(Request $request)
    {
        $validate = $request['validate'];
        
        if($validate =="email")
        {
            $email = $request['email'];
            $user_exists = (count(User::where('email', $email)->get()) > 0) ? true : false;
        }
        elseif($validate =="phone")
        {
            $phone_number = $request['phone_number'];
            $user_exists  = (count(User::where('phone_number', $phone_number)->get()) > 0) ? true : false;
        }

        return response()->json(['exist' => $user_exists]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $packageSecret = $request->input('siop');
        $packageList = Package::where('is_active',1)->select('package_name','package_secret','price')->get()->toArray();
        
        return view('auth.register',compact('packageList'))->withSecret($packageSecret);
    }


}
