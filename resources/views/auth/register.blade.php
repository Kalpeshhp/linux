@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><center><b>CREATE YOUR ACCOUNT</b></center></div>

                <div class="card-body">
                    <form method="POST" id="register-form" name="register">
                        @csrf
                        <input type="hidden" readonly id="package_secret" name="package_secret" value="{{ app('request')->input('siop') }}">
                        
                        <div class="form-group row">
                            <div class="col-md-6">
                                
                            <label for="name" class="col-form-label text-md-left">Selected Package</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <select name="comic_publisher" id="publishers" class="form-control" disabled="">
                                        @foreach($packageList as $key=> $package)
                                            <option value="{{$package['package_secret']}}" {{ $secret == $package['package_secret'] ? 'selected' : ''}}>{{intval($package['price']) !=0 ?$package['package_name'].' - $'.intval($package['price']).'/yr.':$package['package_name'].'- Free'}}</option>
                                        @endforeach
                                  </select>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name" class="col-form-label text-md-left">Plugin UI</label>
                                <a title="Dark Plugin" href="images/UI/plugin-ui-1.png" class="btn "  rel="first_group">
                                        Preview
                                    </a>
                                    <a title="Light Plugin" href="images/UI/plugin-ui-2.png"  rel="first_group"></a>
                                <div class="form-field">
                                    
                                    <select id="plugin_ui" name="plugin_ui" class="form-control @error('plugin_ui') is-invalid @enderror">
                                        <option value="">Select Plugin UI</option>
                                        <option value="plugin-dark">Dark Plugin</option>
                                        <option value="plugin-light">Light Plugin</option>
                                    </select>
                                    @error('plugin_ui')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                     
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <label for="name" class="col-form-label text-md-left">Store UI</label>
                                    <a title="Store One" href="images/UI/store-ui-1.png" class="btn "  rel="group">
                                        Preview
                                    </a>
                                    <a title="Store Two" href="images/UI/store-ui-2.png"  rel="group"></a>
                                    <a title="Store Three" href="images/UI/store-ui-3.png"  rel="group"></a>

                                <div class="form-field">
                                    <select id="store_ui" name="store_ui" class="form-control @error('store_ui') is-invalid @enderror">
                                        <option value="">Select Store UI</option>
                                        <option value="store-1">Store One</option>
                                        <option value="store-2">Store Two</option>
                                        <option value="store-3">Store Three</option>
                                    </select>
                                    @error('store_ui')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name" class="col-form-label text-md-left">First name</label>
                                <div class="form-field">
                                    <input data-msg="Enter First Name" data-rule="required" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                     
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <label for="name" class="col-form-label text-md-left">Last name</label>
                                <div class="form-field">
                                    <input id="lname" data-msg="Enter Last Name" data-rule="required" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}"  autocomplete="name" autofocus>
                                    @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="username" class="col-form-label text-md-left">Username</label>
                                <div class="form-field">
                                    <input id="username" data-msg="Enter User Name" data-rule="required" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}"  autocomplete="username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                                <div class="form-field">
                                    <input id="email" data-msg="Enter Email" data-rule="email" data-rule="required" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="phonenumber" class="col-form-label text-md-left">Phone Number</label>
                                <div class="form-field">
                                    <input id="phonenumber" data-rule="regexp:/[0-9]{10}$/" data-msg="Enter Phone Number" data-rule="required"  type="text" class="form-control @error('phonenumber') is-invalid @enderror" name="phonenumber" value="{{ old('phonenumber') }}"  autocomplete="phonenumber">
                                    @error('phonenumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="mobilenumber" class="col-form-label text-md-left">Mobile Number</label>
                                <div class="form-field">
                                    <input id="mobilenumber" data-msg="Enter Mobile Number" data-rule="required" type="text" class="form-control @error('mobilenumber') is-invalid @enderror" name="mobilenumber" value="{{ old('mobilenumber') }}"  autocomplete="mobilenumber">
                                    @error('mobilenumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label for="password" class="col-form-label text-md-left">{{ __('Password') }}</label>
                                <div class="user-pwd form-field">
                                    <input id="password" type="password" data-msg="Enter Password" data-rule="required" class="password form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">
                                    
                                    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <label for="password-confirm" class="col-form-label text-md-left">{{ __('Confirm Password') }}</label>
                                <div class="form-field">
                                    <input id="password-confirm" data-msg="Enter Confirm Password" data-rule="required" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-md-1 show-hide-pwd">
                                <input type="checkbox" id="showHide" class="show-pwd">
                                 <svg aria-hidden="true" style="display: none;" class="close-eye" fill="currentColor" focusable="false" width="24px" height="24px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg"><path d="M10.58,7.25l1.56,1.56c1.38,0.07,2.47,1.17,2.54,2.54l1.56,1.56C16.4,12.47,16.5,12,16.5,11.5C16.5,9.02,14.48,7,12,7 C11.5,7,11.03,7.1,10.58,7.25z"></path><path d="M12,6c3.79,0,7.17,2.13,8.82,5.5c-0.64,1.32-1.56,2.44-2.66,3.33l1.42,1.42c1.51-1.26,2.7-2.89,3.43-4.74 C21.27,7.11,17,4,12,4c-1.4,0-2.73,0.25-3.98,0.7L9.63,6.3C10.4,6.12,11.19,6,12,6z"></path><path d="M16.43,15.93l-1.25-1.25l-1.27-1.27l-3.82-3.82L8.82,8.32L7.57,7.07L6.09,5.59L3.31,2.81L1.89,4.22l2.53,2.53 C2.92,8.02,1.73,9.64,1,11.5C2.73,15.89,7,19,12,19c1.4,0,2.73-0.25,3.98-0.7l4.3,4.3l1.41-1.41l-3.78-3.78L16.43,15.93z M11.86,14.19c-1.38-0.07-2.47-1.17-2.54-2.54L11.86,14.19z M12,17c-3.79,0-7.17-2.13-8.82-5.5c0.64-1.32,1.56-2.44,2.66-3.33 l1.91,1.91C7.6,10.53,7.5,11,7.5,11.5c0,2.48,2.02,4.5,4.5,4.5c0.5,0,0.97-0.1,1.42-0.25l0.95,0.95C13.6,16.88,12.81,17,12,17z"></path></svg>

                                    <svg aria-hidden="true" style="display: inline;" class="open-eye" fill="currentColor" focusable="false" width="24px" height="24px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg"><path d="M12,7c-2.48,0-4.5,2.02-4.5,4.5S9.52,16,12,16s4.5-2.02,4.5-4.5S14.48,7,12,7z M12,14.2c-1.49,0-2.7-1.21-2.7-2.7 c0-1.49,1.21-2.7,2.7-2.7s2.7,1.21,2.7,2.7C14.7,12.99,13.49,14.2,12,14.2z"></path><path d="M12,4C7,4,2.73,7.11,1,11.5C2.73,15.89,7,19,12,19s9.27-3.11,11-7.5C21.27,7.11,17,4,12,4z M12,17 c-3.79,0-7.17-2.13-8.82-5.5C4.83,8.13,8.21,6,12,6s7.17,2.13,8.82,5.5C19.17,14.87,15.79,17,12,17z"></path></svg>
                                {{--  <img src="{{asset('/images/close-eye.png')}}" class="close-eye" alt="Password" style="display: none;">
                                 <img src="{{asset('/images/open-eye.png')}}" class="open-eye" alt="Password" style="display: inline;"> --}}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <center><button type="submit" class="btn btn-primary">
                                    CREATE ACCOUNT
                                </button></center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Theme JS files -->
    <script type="text/javascript" src="{{ asset('js/main/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/media/fancybox.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("a[rel=group]").fancybox({
                'transitionIn'      : 'none',
                'transitionOut'     : 'none',
                'titlePosition'     : 'over',
                'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                }
            });
        $("a[rel=first_group]").fancybox({
                'transitionIn'      : 'none',
                'transitionOut'     : 'none',
                'titlePosition'     : 'over',
                'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                }
            });
    })
</script>
@endsection