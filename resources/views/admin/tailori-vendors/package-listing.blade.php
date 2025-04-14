<div class="row">
        @foreach($packages as $package)
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="mt-2 mb-3">{{$package['package_name']}}</h4>
                        <h1 class="pricing-table-price"><span class="mr-1">₹</span>{{$package['price']}}</h1>
                        <ul class="pricing-table-list list-unstyled mb-3">
                            <li><strong>25GB</strong> space</li>
                            <li><strong>2GB</strong> RAM</li>
                            <li><strong>1</strong> domain</li>
                            <li><strong>5</strong> emails</li>
                            <li><strong>Daily</strong> backups</li>
                            <li><strong>24/7</strong> support</li>
                        </ul>
                        <a href="javascript:void(0)" data-siop="{{$package['package_secret']}}" class="btn bg-success-400 btn-lg text-uppercase font-size-sm font-weight-semibold package_purchase">Purchase</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>