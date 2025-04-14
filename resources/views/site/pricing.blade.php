@extends('layouts.site')
@section('content')
<div class="container">
    {{-- <div class="row">
        @foreach($packages as $package)

            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="mt-2 mb-3">{{$package['package_name']}}</h4>
                        <h1 class="pricing-table-price"><span class="mr-1"></span>{{intval($package['price']) !=0 ?'$'.intval($package['price']):'Free'}}</h1>
                        <ul class="pricing-table-list list-unstyled mb-3">
                            <li><strong></strong> Setup cost in USD
Shirt, Suit, Jacket, Trouser</li>
                            <li> SaaS including hosting <strong>{{intval($package['saas_hosting_price']) !=0 ?'$'.intval($package['saas_hosting_price']):''}}</strong></li>
                            <li>Product <strong>{{$package['product']}}</strong></li>
                            <li> Fabric Upload <strong>{{$package['is_upload_fabric'] ==1 ?'Yes':'No'}}</strong></li>
                            <li>Number Of Fabric Limit <strong>{{$package['fabric_limit']}}</strong> </li>
                            <li>Payment Gateway <strong>{{$package['is_payment_gateway'] ==1 ?'Yes':'No'}}</strong></li>
                            <li>Analysis <strong>{{$package['is_analysis'] ==1 ?'Yes':'No'}}</strong></li>
                        </ul>
                        <a href="{{route('register')}}?siop={{$package['package_secret']}}" class="btn bg-success-400 btn-lg text-uppercase font-size-sm font-weight-semibold">Purchase</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}
    <div class="row pricing-wrapper comparison-table clearfix style-3">
        <div class="col-md-3 pricing-col list-feature">
          <div class="pricing-card">
            <div class="pricing-header">
              
              <p>Compare Package Feature</p>
            </div>
            <div class="pricing-feature">
              {{-- <li>
                <p>monthly updates</p>
              </li> --}}
              <li>
                <p>SaaS including hosting</p>
              </li>
              <li>
                <p>Product</p>
              </li>
              <li>
                <p>Fabric Upload</p>
              </li>
              <li>
                <p>Number Of Fabric Limit</p>
              </li>
              <li>
                <p>Payment Gateway</p>
              </li>
              <li>
                <p>Analysis</p>
              </li>
            </div>
          </div>
        </div>
        @foreach($packages as $package)
            @if($package['package_name'] == 'Standard')
             <div class="col-md-3 pricing-col unlim">
            @elseif($package['package_name'] == 'Enterprise')
             <div class="col-md-3 pricing-col business">
            @else
             <div class="col-md-3 pricing-col person">
            @endif
              <div class="pricing-card">
                <div class="pricing-header">
                  <h5>{{$package['package_name']}}</h5>
                  <div class="price-box">
                    <div class="price">{{intval($package['price']) !=0 ?intval($package['price']):'Free'}}
                      <div class="currency">{{intval($package['price']) !=0 ?'$':''}}</div>
                      <div class="plan">{{intval($package['price']) !=0 ?'/ yr.':''}}</div>
                    </div>
                  </div>
                </div>
                <div class="pricing-feature">
                  {{-- <li>
                    <p>
                      <i class="fa fa-check available"></i>
                    </p>
                  </li> --}}
                  <li>
                    <p>
                      <span>{{intval($package['saas_hosting_price']) !=0 ?'$'.intval($package['saas_hosting_price']):'Free'}}</span>
                    </p>
                  </li>
                  <li>
                    <p>
                      <span>{{$package['product']}}</span>
                    </p>
                  </li>
                  <li>
                    <p>
                      <span>{!!$package['is_upload_fabric'] ==1 ?'<i class="fa fa-check available"></i>':'<i class="fa fa-times unavailable">'!!}</span>
                    </p>
                  </li>
                  <li>
                    <p>
                      <span>{{$package['fabric_limit']}}</span>
                    </p>
                  </li>
                  <li>
                    <p>
                      {!!$package['is_payment_gateway'] ==1 ?'<i class="fa fa-check available"></i>':'<i class="fa fa-times unavailable">'!!}</i>
                    </p>
                  </li>
                  <li>
                    <p>
                      {!!$package['is_analysis'] ==1 ?'<i class="fa fa-check available"></i>':'<i class="fa fa-times unavailable"></i>'!!}
                    </p>
                  </li>
                  
                </div>
                <div class="pricing-footer">
                    <a href="{{route('register')}}?siop={{$package['package_secret']}}" class="btn bg-success-400 btn-lg text-uppercase font-size-sm font-weight-semibold">Purchase</a>
                </div>
              </div>
            </div>
        @endforeach
        
      </div>
</div>
@endsection