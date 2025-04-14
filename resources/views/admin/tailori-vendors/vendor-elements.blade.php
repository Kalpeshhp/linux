@extends('layouts.admin')

@section('content')
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header bg-primary text-white header-elements-inline">
                <h6 class="card-title">Current package</h6>
                <div class="header-elements">
                  <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                          </div>
                        </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                      <tbody>
                        <tr class="table-success">
                          <th>Package Name</th>
                          <th><center>Price</center></th>
                        </tr>
                        <tr>
                        <td>{{$packages[0]['package_name']}}</td>
                        <td><center>₹ {{$packages[0]['price']}}</center></td></tr>
                        <tr class="table-success">
                          <th>Validity</th>
                          <th><center>(in Years)</center></th>
                        </tr>
                        <tr><td></td><td><center>{{$packages[0]['validity_years']}}</center></td></tr>
                        <tr class="table-success">
                            <th>Products</th>
                            <th><center>Product Code</center></th>
                        </tr>
                          @foreach($packages[0]['package_products'] as $key=>$values)
                                  <tr>
                                      <td>{{$values['tailori_products']['product_name']}}</td>
                                      <td><center>{{$values['tailori_products']['tailori_product_code']}}</center></td>
                                  </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              </div>
            </div>
          </div>
        </div>
        
        @if($is_package_enabled)
        <div class="card-group-control card-group-control-right" id="accordion-control-right">
            @if($selections)
                @php
                @endphp
                @foreach($selections as $key=>$styles)
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">
                                <a data-toggle="collapse" class="text-default collapsed" href="#accordion-control-right-group{{ $key }}"><b>{{$products[$key]}}</b></a>
                            </h6>
                        </div>

                        <div id="accordion-control-right-group{{ $key }}" class="collapse" data-parent="#accordion-control-right">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        @foreach($selections[$key] as $key=>$values)
                                            <tr class="bg-blue">
                                                <th colspan="2" class="text-uppercase" style="font-weight:600"><center>{{$key}}</center></th>
                                            </tr>
                                            <tr class="table-success">
                                                <th>Attribute</th>
                                                <th><center>Price</center></th>
                                            </tr>
                                            @foreach($values as $value)
                                                <tr>
                                                    <td>{{$value['attributes']['attribute_name']}}</td>
                                                    <td><center>₹ {{$value['price']}}</center></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center mb-3 py-2">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAT4AAACfCAMAAABX0UX9AAAAk1BMVEX///8RSIXb4+yluM739/cAQYEAO377+/uywtXW19fq7/RlhKsAPoBqiK3Z2toARITJy8vj5OTv8PDp6urQ0dHi6O/X3+mEn76LpMLBzt7O2OTy9fi6yNnf4ODz8/Odsss+Z5mdssp2lrmpvNGSqsUAKnkzYJQcVo9Nc6EAN31WfaiAmbl0kbQAMHk3ZZgZUo2/wMC7rbrwAAAFLElEQVR4nO2aeXOiTBDGEdABggeXcnmzahZN8v0/3TsXCARh9499jcXzqxTH0JMan+qZ7mlQFAAAAAAAAAAAAAAAAAAAAAAAAAAAAFpI1HhpPXsQr0ochntNy1Z7KPj3qIc0EVdBuH3uUF6QNCT3m+U1ed5IXpFIq91auf6kgbwkQdhoULOnjONFWRWTNQnkHD7GTxvMy7E8ynOYHaXbJU1/BA/ZBvykRfSQqrIN6cufsuIzlnAR1Ui0pdHzxvODIJnWEII0TZJ7nLDiqSGu1OM/HdbLsPpVn4bhqSmMVaxz0fZ0jmQOE2gKoL6mxTXviyfjUWNZk96XXFZRbimJ2HOokK8N6/y+a05fsfYl2ZaGjeC3eBph7WtF1b7F1DLKLleXPBfeJ6Mx6CeW4eK4y1VL4wmzjrzvzxGzVyGE7DWxAUHe8hcsyxKVXBat1bOG8qPQrQoddkZa73ZAxYpxncxLRssOw6NRuQly7Ng4uT0qsTujQbQqaiyWlsH3BNuKfPNdp2lirMKILn3bsMtLh4UxGVX0y4w27hM1uCrRFIW+O2lVvpE9aeGWl9bZx8Ho+GfDI67J18r4WhhbESJGHfUu3/gBk98sXSbfyliAOlQZOs7TtzvTCm/TFSdHuP1GMi+Wvd5XZxlqBN/5lPJN9n2WIbyPsaytYifpfpPe2nuI1Y+Sv1+rt7tCvvRRB0mCIgHjcrtU3egi5bP7smEL3xUwrHoIuI6lfH07sQCfVbUQysxl3BdX4+p+I0GxVLAv5LtvKKxSyaSiaVqZ3eR0w1TmHItth0xLSHq4FwWs67R8b3SszO7k84ZAwomEfPOTjCeBVpvFllFomVX3u+oR3/dxZM1g/tFnWGTNwXWKel+JKta++aXPUL5ss0a23ZvkDAdr3pQvvZTelbyVEYLIxW5LvdWuJd6DJvlsFPXI7vZWXBu/7GIlLD6HZKFmgrhB/W6pMm3O3P3se0m55n3l2yNVZs3Jx/vkE7UXFjTmLPkVNYPut2zMutgTE0ND6UVhheY5CwFi09tb7ksRLuoEacQ+U57yTa/dV+7bq//HmF6PXMjXrFfF2b6WGWd4S9SKqBnYzRqAmka18ugBxdJWRM2gNxNGqteOeFE+71naUGt+wHLMKwY9ycgW+9x2yI7qN867jQx8Rv+I+Dyx369H7THbA4rLjyFBEKhdYI8GAAAAAAAAAAAAAMBPhFSORZOu64/forGneue3fAN6A6d/8ZNfbTPN2cycVWxqPRYzRpdEs+F8KKkvuE41+bg2rlnem7UeNdNWhiTfbO0pQpON44k28fNNevRYk75YuwrxHFc8LeVzHGqxYVLTg6u4zoa1Urv1gOQzlYXCNXFM1xHSCPk8hwrqOqZCfE+n4rhrMZ+lfGThub4rbOlhZq5dn2rt0y6LQcmn+0wTwmTxuP8J+dw1NzAJ++P4/Ox7nkf9jjkn7baW8pkOv/XYaVjeR2ch/eEu++GEL3Ol9yneeu1vhHzskrf7LtVPF05oCqnogdtQNTfKsNY+JphJj9/km1HdvM1mJuRjl6aQT3Ssyse8T7QNUj5imrXJyzyJ3fNVccOk4U8XVfmKycsCylcpH5+8XwOTT/G+qqHD9Fy6/hMeB8zFRpk5hK549LIqHw0dHg0d/ESl9MXkZV18fzjyEZGOsGOZuLiOIy9pjGD7D4fnMERsRdyiKwsgCvdYnYhWV6nYAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIDh8h+ht0h9aQ96kgAAAABJRU5ErkJggg==">
                </div>
            @endif
        </div>
    @else
        @include('admin.tailori-vendors.package-listing');
    @endif
</div>
@endsection


@section('scripts')
<script>

     $(document).on('click', '.package_purchase', function(e)
     {
          var siop = $(this).attr('data-siop');
          var url   = '{{ route("register.package") }}';
             e.preventDefault();
              swal({
                  title: 'Are you sure?',
                  text: "You won't be able to subscribe this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, subscribe it!',
                  cancelButtonText: 'No, cancel!',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
                }).then(function (result) {
                  if(result.value){
          $.ajax({
              type: "POST",
              url:url,
              data:{
                  "_token": "{{ csrf_token() }}",
                  "package_secret": siop,
              },
              success: function (data) {
                 swal({
                            title: 'Package subscribed Successfully!',
                            type: 'success',
                            showCloseButton: true
                        }).catch(swal.noop)
                        .then(function() {
                  //dbTable.DataTable().ajax.reload();
                    location.reload();
                   });
                      }
                    });
              }
              else if(result.dismiss == 'cancel')
              {
                  swal({
                      title: 'For your information',
                      text: 'Package has not been subscribed!',
                      type: 'info',
                      animation: false
                    });
              }
        });
});
</script>
@endsection