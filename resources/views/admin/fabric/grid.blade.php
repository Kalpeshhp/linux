@extends('layouts.admin')

@section('content')
    <div class="content">
		@if(!empty($fabrics))
			<div class="d-flex align-items-start flex-column flex-md-row">
			<script>
				localStorage.setItem('AppKey', JSON.stringify(<?php echo json_encode($_SESSION); ?>));
			</script>
				<!-- Left content -->
				<div class="w-100 order-2 order-md-1" id="order_2">
					<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline" style="margin-bottom: 16px; padding: 0.282rem 1.25rem; background: #FFFFFF">
						<div class="d-flex">
						</div>

						<div class="header-elements d-none">
							<div class="breadcrumb justify-content-center">
								<div class="breadcrumb-elements-item dropdown p-0">
									@can('vendor-only', auth()->user())
										@if(auth()->user()->fabric_upload_limit)
											<a href="javascript:void(0)" class="" data-toggle="modal" data-target="#upload_modal_form_vertical" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
		                                		<i class="icon-add-to-list"></i> Upload Fabric
		                            		</a>
		                            	@endif
                            		@endcan
									
									<a href="javascript:void(0)" class="breadcrumb-elements-item fabric-selected-count-element d-none" style="font-size:15px">
										<span class="badge badge-pill bg-success ml-auto selected-fabric-count">0</span>
									</a>

									<a href="javascript:void(0)" class="breadcrumb-elements-item fabric-to-store-btn d-none" onclick="moveFabricToStore()" style="font-size:15px">
										<span class="badge badge-pill bg-primary ml-auto">MOVE TO STORE</span>
									</a>
									<a href="javascript:void(0)" class="breadcrumb-elements-item remove-fabric-from-store-btn d-none" onclick="removeFabricToStore()" style="font-size:15px">
										<span class="badge badge-pill bg-danger ml-auto">REMOVE FROM STORE</span>
									</a>
									<a href="javascript:void(0)" class="breadcrumb-elements-item remove-fabric-from-store-btn V d-none" onclick="DeleteFromVendorPanel()" style="font-size:15px">
										<span class="badge badge-pill bg-danger ml-auto">DELETE FROM STORE</span>
									</a>  <!--Vijay-->
									<a href="javascript:void(0)" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">More options
									</a>

									<a href="javascript:void(0)" title="Hide Filter" class="breadcrumb-elements-item sidebar-component-toggle">
										<span class="badge badge-pill bg-orange ml-auto"><i class="icon-drag-right"></i></span>
									</a>
									
									<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 40px, 0px);">
										<a href="javascript:void(0)" class="dropdown-item" onclick="selectAllPageItems()"><i class="icon-user-lock"></i> Select all</a>
										<a href="javascript:void(0)" class="dropdown-item" onclick="deleteAllPageItems()"><i class="icon-trash"></i> Remove all</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="listing">
						@include('admin.fabric.filtered')
					</div>
				</div>
				<!-- /left content -->

				<!-- Right sidebar component -->
				<div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right border-0 shadow-0 order-1 order-md-2 sidebar-expand-md">

					<!-- Sidebar content -->
					<div class="sidebar-content">

						<!-- Filters -->
						<div class="card">
							<div class="card-header bg-transparent header-elements-inline">
								<span class="text-uppercase font-size-sm font-weight-semibold text-dark">Filter Fabrics</span>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item" data-action=""></a>
									</div>
								</div>
							</div>

							<div class="card-body">
								<form action="#">
									<div class="form-group">
										<div class="form-group form-group-feedback form-group-feedback-right">
											<input type="search" class="form-control" placeholder="Search" id="search">
											<div class="form-control-feedback">
												<i class="icon-search4 font-size-base text-muted"></i>
											</div>
										</div>

										<div class="font-size-xs text-uppercase text-muted mb-3 text-dark">Show fabrics</div>
										<div class="" style="max-height: 192px;">
											<div class="form-check">
												<label class="form-check-label">
													<input type="radio" title="Sync in store" class="form-input-styled fabric-view" name="fabric-view" value="in_store" data-fouc>
													In Store({{$inStore}})
												</label>	
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input title="Not Sync in store" type="radio" class="form-input-styled fabric-view" name="fabric-view" value="off_store" data-fouc>
													Off Store({{$offStore}})
												</label>	
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="radio" title="All Fabrics" class="form-input-styled fabric-view" name="fabric-view" value="all" data-fouc>
													All({{$allStore}})
												</label>	
											</div>
										</div>
									</div>
									<div class="form-group">
									
										<div class="font-size-xs text-uppercase mb-3 text-dark">Product</div>

										<div class="" style="max-height: 192px;">
											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Shirt" data-fouc>
													Shirt
												</label>	
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Trouser" data-fouc>
													Trouser
												</label>
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Jacket" data-fouc>
													Jacket
												</label>
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Blazer" data-fouc>
													Blazer
												</label>
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Suit" data-fouc>
													Suit
												</label>
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Bundy" data-fouc>
													Bundy
												</label>
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Bandhgala" data-fouc>
													Bandhgala
												</label>
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Waistcoat" data-fouc>
													Waistcoat
												</label>
											</div>

											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-input-styled product-type" name="type" value="Women_shirt" data-fouc>
													Women_Shirt
												</label>
											</div>

										</div>
									</div>

									<div class="form-group">
										<div class="font-size-xs text-uppercase mb-3 text-dark" >Fabrics for</div>

										<div class="form-check">
											<label class="form-check-label">
												<input type="checkbox" name="wear" value="men" class="form-input-styled wear-type" data-fouc>
												Men
											</label>	
										</div>

										<div class="form-check">
											<label class="form-check-label">
												<input type="checkbox" name="wear" value="women" class="form-input-styled wear-type" data-fouc>
												Women
											</label>
										</div>

									</div>

									<div class="form-group">
										<div class="font-size-xs text-uppercase mb-3 text-dark">Brand</div>

										@foreach($brand as $brandVal)
										@if($brandVal['brand'] !=NULL)
											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" name="brand" value="{{$brandVal['brand']}}" class="form-input-styled brand" data-fouc>
													{{$brandVal['brand']}}
												</label>
											</div>
										@endif
										@endforeach

									</div>

									<div class="form-group color-multiselect">
										<div class="font-size-xs text-uppercase  mb-3 text-dark">Color</div>

										<div class="row">
											<div class="col-12">
												<select class="js-example-basic-multiple" name="states[]" multiple="multiple">
													@foreach($colors as $color)
														<option value="{{ $color['color'] }}">{{ $color['color'] }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- /filters -->

					</div>
					<!-- /sidebar content -->

				</div>
				<!-- /right sidebar component -->

				<!-- Vertical form modal -->
				<div id="modal_form_vertical" class="modal fade" tabindex="-1">
					<div class="modal-dialog" style="width:600px">
						<div class="modal-content">
							<div class="modal-header bg-primary-800">
								<h4 class="modal-title">Edit Fabric</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
			
							<div class="card-body">
								<form action="#" id="fabric_form" enctype="multipart/form-data">
									@csrf

									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<input type="hidden" name="hd_fabric_id" id="hd_fabric_id">
											</div>
											<div class="col-md-6">
												<input type="hidden" name="hd_fabric_code" id="hd_fabric_code">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label><b>Fabric name</b></label>
												<input type="text" id="hd_fabric_name" name="hd_fabric_name" class="form-control" placeholder="Enter fabric name" autocomplete="off" required>
											</div>
											<div class="col-md-6">
												<label><b>Price</b></label>
												<input type="text" id="hd_price" name="hd_price" class="form-control" placeholder="Enter fabric price" autocomplete="off" required>
											</div>
										</div>
									</div>
			
									<div class="form-group">
										<div class="row">
											<div class="col-md-12">
												<label><b>Description</b></label>
												<textarea id="hd_fabric_description" name="hd_fabric_description" class="form-control" placeholder="Enter description" required></textarea>
											</div>
										</div>
									</div>
			
									<div class="text-right">
										<button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
									</div>
			
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /vertical form modal -->
			</div>
		@else
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 style="text-align:center"><i class="icon-warning22 mr-1 icon-2x" style="color:orangered"></i>No subscription available!</h4>
						</div>
					</div>
				</div>
			</div>
		@endif
    </div>
    <!-- Vertical form modal -->
<div id="upload_modal_form_vertical" class="modal fade p-0" tabindex="-1" style="padding:0;">
	<div class="progress" style="width: 100%; height: 100%;position: absolute;z-index: 9;vertical-align: baseline;display:flex;
    flex-direction: column;background: none;text-align:right;padding-right:10px;padding: 0 14px; display:none;left: 50%;top:50%; transform: translate(-50%,-50%);"id="progressdiv"> 
		<div class="circlePercent">
			<div class="counter" data-percent="0"></div>
			<div class="progress"></div>
			<div class="progressEnd"></div>
		</div>						
	</div>
  <div class="modal-dialog" style="">
      <div class="modal-content rounded-0 shadow">
         <div class="modal-header border-bottom-0 bg-light">
            <h5 class="modal-title">Save Design</h5>
			<button type="button" class="close" data-dismiss="modal" onclick="CloseUpload();">&times;</button>
         </div>
         <div class="modal-body p-0">
            <row>
               <div class="col-lg-12 p-0">
                  <form class="row rowhead m-0">
                     <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-sm" id="upload">Import<input type="file" name="file" id="file" multiple="true"accept="image/x-png,image/jpeg,image/jpg" ></button>   
                     </div>
                     <div class="col-auto">
                        <button type="button" class="btn btn-light btn-sm" id="fRemove">Remove</button>   
                     </div>
                     <div class="col-auto">
                        <button type="button" class="btn btn-light btn-sm"id='fRemoveAll'>Remove All</button>   
                     </div>
                     <div class="col-auto">
                        <select id="wear_type" name="wear_type" class="form-control myselect">
                           <option disabled="disabled" selected="selected">Select Wear Type</option>
                                        <option value="men">Men</option>
                                        <option value="women">Women</option>
                        </select>
                     </div>
					 <div class="col-auto">
						<select id="product" class="form-control myselect" onchange="updateProductType()">
							<option disabled="disabled" selected="selected">Select Product</option>
						</select>
					</div>

					<div class="col-auto">
						<select id="product_type" class="form-control myselect">
							<option disabled="disabled" selected="selected">Select Product Type</option>
						</select>
					</div>
					 <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-sm" id="Saveall">Save all</button>   
                     </div>
                     <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-sm" id='Save'>Save</button>   
                     </div>
                  </form>
               </div>
            </row>
            <row>
               <div class="col-lg-12 p-0">
                  <div class="col-lg-12 h-100 mh-100 rowhead_b d-flex" style="float: left">
                     <div class="swatch">
                        <div class="btn-group mt-3" style="margin-left: 1rem">
                           <a href="#" id="list" class="btn btn-default btn-sm view"><i class="fa fa-list" aria-hidden="true"></i>
                           </a>
                           <a href="#" id="grid" class="btn btn-default btn-sm view"><i class="fa fa-th" aria-hidden="true"></i></a>
                        </div>
                     </div>
                     <div class="d-flex btns pt-2">
                        <div class="col-auto">
                           <button type="button" class="btn btn-primary btn-sm" id='AddAll'>Add All</button>   
                        </div>
                        <div class="col-auto">
                           <button type="button" class="btn btn-primary btn-sm" id='AddSingle'>Add</button>   
                        </div>
                        <div class="col-auto">
                           <button type="button" class="btn btn-secondary btn-sm"id='Clear'>Clear</button>   
                        </div>
                     </div>
                     <div class="d-flex" style="width:45%">
                        <div class="col mr-1 category_sel">
                           <label for="exampleInputName2">Color</label>
                           <div class="form-group myselect">     
						   <input type="text" class="value" value="" style="" id='fColor'>
                           </div>
                        </div>
                        <div class="col mr-1 category_sel">
                           <label for="exampleInputName2">Pattern</label>
                           <div class="form-group myselect">                            
						   <input type="text" class="value" value="" style="" id='fPattern'>
                           </div>
                        </div>
                        <div class="col mr-1 category_sel">
                           <label for="exampleInputName2">Blend</label>
                           <div class="form-group myselect">
						   <input type="text" class="value" value="" style="" id='fBlend'>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-lg-12 h-100 mh-100  p-0" style="float: left">
                    <div class="outer_div"> <div id="products" class="row list-group p-0"></div></div>
                  </div>
                 
               </div>
            </row>
         </div>
      </div> 
   </div>
</div>
    <!-- /vertical form modal -->
@endsection

@section('scripts')
    {!!Html::script('js/plugins/media/fancybox.min.js')!!}
    {!!Html::script('js/plugins/forms/styling/uniform.min.js')!!}
	{!!Html::script('js/plugins/loaders/blockui.min.js')!!}
	{!!Html::script('js/plugins/forms/validation/validate.min.js')!!}
    {!!Html::script('js/plugins/uploaders/fileinput/fileinput.min.js')!!}
    <script>
    	$("input[name=fabric-view][value='all']").trigger('click');
		localStorage.removeItem('fabrics');
		localStorage.removeItem('remove-fabrics');
		localStorage.removeItem('delFabrics');

		$('.file-input').fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            initialCaption: "No file selected",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings,
            allowedFileExtensions: ["jpg", "png","jpeg"],
        });

        $('.select-search').select2({
            dropdownParent: $("#modal_form_vertical"),
            placeholder: 'Select a Vendor',
            allowClear: true
        });
		$('.js-example-basic-multiple').select2({
			closeOnSelect : false,
			placeholder : "Select colors",
			allowHtml: true,
			tags: true
		});
		/* Fancy box product zoom initialisation */

		function ProductZoom(){
			$('[data-popup="lightbox"]').fancybox({
				padding: 15
			});
		}

		/** BlockUI initialization */

		function loadBlockUI(){

			$.blockUI({ 
                message: '<span class="font-weight-semibold"><i class="icon-spinner4 spinner mr-2"></i>&nbsp; Updating fabrics</span>',
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    padding: 0,
                    zIndex: 1201,
                    backgroundColor: 'transparent'
                }
            });
		}

		ProductZoom();

		/* Call to filter records by filter inputs */

		function ajaxLoad(filename, content) {

			loadBlockUI();

			content = typeof content !== 'undefined' ? content : 'listing';
			
			$.ajax({
				type: "GET",
				url: filename,
				contentType: true,
				success: function (data) {

					$("#" + content).html(data);

					ProductZoom();
					
					var selectedFabrics = localStorage.getItem('fabrics');
					
					if(selectedFabrics !=null){
						localStorage.removeItem('delFabrics');
						if (selectedFabrics !== null && selectedFabrics !== undefined) {

							var unique = JSON.parse(selectedFabrics).filter((v, i, a) => a.indexOf(v) === i);
						
							$.each(unique, function( index, value ){
								$('#'+value).trigger('click');
							});
						}
					}
					//For Remove Fabrics
					var selectedRemovedFabrics = localStorage.getItem('remove-fabrics');

					if(selectedRemovedFabrics !=null){
						if (selectedRemovedFabrics !== null && selectedRemovedFabrics !== undefined) {

							var uniqueF = JSON.parse(selectedRemovedFabrics).filter((v, i, a) => a.indexOf(v) === i);
						
							$.each(uniqueF, function( index, value ){
								$('#'+value).trigger('click');
								$('input[data-remove-fabric-id='+value+']').trigger('click');
							});
						}
					}
					//END
					
					setTimeout( function(){
						$.unblockUI();
					}, 400);
				},
				error: function (xhr, status, error) {
					alert(xhr.responseText);
				}
			});
		}

		function onlyUnique(value, index, self) { 
			return self.indexOf(value) === index;
		}

		/* Load records on pagination */

		$(document).on('click', 'a.page-link', function (event) {

			event.preventDefault();

			var phrase = $('#search').val();
			var productType = [];
			var wearType = [];
			var brand = [];
			var colors = [];
			var fabricView = '';

			$("input:radio[name=fabric-view]:checked").each(function(){
				fabricView = $(this).val();
			});

			$("input:checkbox[name=type]:checked").each(function(){
				productType.push($(this).val());
			});

			$("input:checkbox[name=wear]:checked").each(function(){
				wearType.push($(this).val());
			});

			$("input:checkbox[name=brand]:checked").each(function(){
				brand.push($(this).val());
			});

			colors = $(".js-example-basic-multiple").select2("val");

			if(productType.length > 0 || wearType.length > 0 || colors.length > 0 || fabricView != '' || brand.length > 0){
				if(wearType.length > 0){
					wearType = JSON.stringify(wearType);
				}
				if(brand.length > 0){
					brand = JSON.stringify(brand);
				}
				if(productType.length > 0){
					productType = JSON.stringify(productType);
				}
				ajaxLoad($(this).attr('href')+'&search='+phrase+'&product='+productType+'&wear='+wearType+'&brand='+brand+'&colors='+colors+'&view='+fabricView);
			}
			else{
				ajaxLoad($(this).attr('href')+'&search='+phrase);
			}
			
		});

		/* Delay search to avoid filter on every keystroke */
		var delay = (function(){
			var timer = 0;
			return function(callback, ms){
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();

		/* Search records on keystroke */

		$('#search').keyup(function() {
			delay( function(){
				filterType();
			}, 1000);
		});

		$('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-warning'
        });
		
		$('.product-type').change(function() {
			filterType();
		});

		$('.wear-type').change(function() {
			filterType();
		});
		$('.brand').change(function() {
			filterType();
		});

		$('.fabric-view').change(function() {
			filterType();
		});

		/* Get all fabric filter types */

		function filterType(){

			var phrase = $('#search').val();
			var productType = [];
			var wearType = [];
			var brand = [];
			var colors = [];
			var fabricView = '';

			$("input:radio[name=fabric-view]:checked").each(function(){
				fabricView = $(this).val();
			});

			$("input:checkbox[name=type]:checked").each(function(){
				productType.push($(this).val());
			});

			$("input:checkbox[name=wear]:checked").each(function(){
				wearType.push($(this).val());
			});
			$("input:checkbox[name=brand]:checked").each(function(){
				
				brand.push($(this).val());
			});

			colors = $(".js-example-basic-multiple").select2("val");
			
			if(wearType.length > 0 || productType.length > 0 || colors.length > 0 || fabricView != ''|| brand.length > 0){
				if(wearType.length > 0){
					wearType = JSON.stringify(wearType);
				}
				if(brand.length > 0){
					brand = JSON.stringify(brand);
				}
				if(productType.length > 0){
					productType = JSON.stringify(productType);
				}
				if(colors.length > 0){
					colors = JSON.stringify(colors);
				}
				/* if(fabricView != ''){
					fabricView = JSON.stringify(fabricView);
				} */
				ajaxLoad('{{url('fabric-list')}}?search='+phrase+'&product='+productType+'&wear='+wearType+'&brand='+brand+'&colors='+colors+'&view='+fabricView);
			}
			else{
				ajaxLoad('{{url('fabric-list')}}?search='+phrase);
			}
		}

		/* Select fabrics and store it into local storage */

		var selectedFabrics = [];

		function handleChange(checkbox) {

			var fabricArray = localStorage.getItem('fabrics');

			var fabricArray = JSON.parse(fabricArray);
		
			if( fabricArray === null ){
				selectedFabrics = [];
			}
			
			var lblClass;

			if(checkbox.checked == true){

				lblClass = $(checkbox).attr('id');
				console.log(lblClass);

				var a = document.querySelectorAll('.add-to-store'); 
				
				var b = $(a).find('.bg-blue-400');

				if($(b).hasClass(lblClass)){
					var v = document.getElementsByClassName(lblClass);
					for(i=0;i<v.length;i++){
						var g = v[i];
						if($(g).hasClass('bg-blue-400')){
						$(g).addClass('thisone');
						$('.thisone').append('.'+lblClass).html('<i class="icon-checkmark3"></i>');
						$(g).removeClass('thisone');
					}
					}										
				}

				 $(b).click (function(){
				 	var c = $(this); 
				 	$(c).append('.'+lblClass).html('<i class="icon-checkmark3"></i>');
				 })

				selectedFabrics.indexOf(lblClass) === -1 ? selectedFabrics.push(lblClass):console.log("This item already exists");
				
			}
			else
			{

				lblClass = $(checkbox).attr('id');

				var index = selectedFabrics.indexOf(lblClass);

				if (index > -1) {
					selectedFabrics.splice(index, 1);
				}

				var a = document.querySelectorAll('.add-to-store'); 
				
				var b = $(a).find('.bg-blue-400');

				if($(b).hasClass(lblClass)){
					var v = document.getElementsByClassName(lblClass);
					for(i=0;i<v.length;i++){
						var g = v[i];
						if($(g).hasClass('bg-blue-400')){
						$(g).addClass('thisone');
						$('.thisone').append('.'+lblClass).html('<i class="icon-cart-add"></i>');
						$(g).removeClass('thisone');
					}
					}										
				}

			}
			localStorage.setItem('fabrics',JSON.stringify(selectedFabrics));
			selectedFabricCount('fabrics');
		}

		var selectedFabricsForDelete = [];
		var selectedFabricsForDeleteV = [];//vijay
        
		function handleRemove(checkbox) {
			if($($('.remove-fabric-from-store-btn')[1]).is(':visible')){swal({
								title: 'Please select fabric which are present in store',
								type: 'success',
								showCloseButton: true
							});checkbox.checked=false; return false;}
			var removeFabricArray = localStorage.getItem('remove-fabrics');
			var removeFabricArray = JSON.parse(removeFabricArray);
		
			if( removeFabricArray === null ){
				selectedFabricsForDelete = [];
			}
			
			var lblClass;

			if(checkbox.checked == true){

				lblClass = $(checkbox).attr('data-remove-fabric-id');
				localStorage.setItem('delFabrics',true);

				
				$("label[data-fabric-sku='" + lblClass + "']").html('<i class="icon-cross"></i>').removeClass('bg-grey-400').addClass('bg-danger-400');
			
				selectedFabricsForDelete.indexOf(lblClass) === -1 ? selectedFabricsForDelete.push(lblClass):console.log("This item already exists");
				
			}
			else
			{

				lblClass = $(checkbox).attr('data-remove-fabric-id');

				var index = selectedFabricsForDelete.indexOf(lblClass);

				if (index > -1) {
					selectedFabricsForDelete.splice(index, 1);
				}

				$("label[data-fabric-sku='" + lblClass + "']").html('<i class="icon-cross"></i>').removeClass('bg-danger-400').addClass('bg-grey-400');

			}
			
			localStorage.setItem('remove-fabrics',JSON.stringify(selectedFabricsForDelete));
			selectedFabricCount('remove-fabrics');
		}

//vijay 
function selectedFabricCount1(action_type){
			
			var selectedFabricsV = localStorage.getItem(action_type);

			if (selectedFabricsV !== null && selectedFabricsV !== undefined) {

				var unique = JSON.parse(selectedFabricsV).filter((v, i, a) => a.indexOf(v) === i);
				
				if( unique.length > 0 ){
					$('.fabric-selected-count-element').removeClass('d-none');

					if(action_type =='remove-fabricsV')
					{
						$($('.remove-fabric-from-store-btn')[1]).removeClass('d-none');
					}
					else
					{
						$('.fabric-to-store-btn').removeClass('d-none');
					}
				}
				else
				{
					$('.fabric-selected-count-element').addClass('d-none');

					if(action_type =='remove-fabricsV')
					{
						$($('.remove-fabric-from-store-btn')[1]).addClass('d-none');
					}
					else
					{
						$('.fabric-to-store-btn').addClass('d-none');
					}
				}
				$('.selected-fabric-count').html(unique.length+' selected  <a href="javascript:void(0)" id="remove_selected_fabrics" onclick="removeAllPageItems()" style="color:#444444; padding-left:3px" title="Remove all"> X</a>');
			}
		}
	function DeleteFromVendorPanel1(checkbox) {
		if($($('.remove-fabric-from-store-btn')[0]).is(':visible')){swal({
										title: 'Please select fabric which are not present in store',
										type: 'success',
										showCloseButton: true
									});checkbox.checked=false;return false;}
		var deleteFabricArray = localStorage.getItem('remove-fabricsV');
		var deleteFabricArray = JSON.parse(deleteFabricArray);

		if( deleteFabricArray === null ){
			selectedFabricsForDeleteV = [];
		}

		var lblClass;

		if(checkbox.checked == true){

			lblClass = $(checkbox).attr('data-remove-fabric-id');
			localStorage.setItem('delFabricsV',true);

			
			$("label[data-fabric-sku='" + lblClass + "']").html('<i class="icon-cross"></i>').removeClass('bg-grey-400').addClass('bg-danger-400');

			selectedFabricsForDeleteV.indexOf(lblClass) === -1 ? selectedFabricsForDeleteV.push(lblClass):alert("This item already exists");
			
		}
		else
		{

			lblClass = $(checkbox).attr('data-remove-fabric-id');

			var index = selectedFabricsForDeleteV.indexOf(lblClass);

			if (index > -1) {
				selectedFabricsForDeleteV.splice(index, 1);
			}

			$("label[data-fabric-sku='" + lblClass + "']").html('<i class="icon-cross"></i>').removeClass('bg-danger-400').addClass('bg-grey-400');

		}
		localStorage.setItem('remove-fabricsV',JSON.stringify(selectedFabricsForDeleteV));
		selectedFabricCount1('remove-fabricsV');
	}
function DeleteFromVendorPanel() {
var selectedFabrics = localStorage.getItem('remove-fabricsV');
selectedFabrics 	= JSON.parse(selectedFabrics);
swal({
  title: 'Are you sure?',
  text: "Do You Want To Delete this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, remove it!',
  cancelButtonText: 'No, cancel!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false
}).then(function (result) {
  if(result.value){
	  loadBlockUI();
	  $.ajax({
		  type: 'POST',
		  url: '{!! route('delete.vendor.fabric') !!}',
		  data: {'fabricID': selectedFabrics, "_token": "{{ csrf_token() }}"},
		  success: function (data) 
				  {
					$.unblockUI();
						swal({
								title: data.message,
								type: 'success',
								showCloseButton: true
							}).catch(swal.noop)
							.then(function() {
								location.reload(true);
					   });
					

					 
				}
			});
		  }
		  
	});

}
var counter=0;
function loadImage(index){
	 $('.progress').show();  
	 var fName=FabricData[index].imageName;
		var count=index +1;
		$('#progress_file').siblings().html(fName+" "+"Is Uploading!!!!  Progress("+count+"/"+FabricData.length+")");
		elem.querySelector('.counter').setAttribute('data-percent',+count+"/"+FabricData.length );
	$.ajax({
		  type: 'POST',
		  url: '{!! route('upload.vendor.storemulti') !!}',
		  data: {'FabricData': FabricData[index], "_token": "{{ csrf_token() }}"},
		  success: function (response) 
				  { 
					  
					  var persentage=(count/(FabricData.length)*100).toFixed();
					animate(parseInt(persentage));
					  var Data=JSON.parse(response);
					  $('input[value="'+Data[0].fabricName+'"]').parent().parent().parent().parent().parent().parent().remove();
					if(index != (FabricData.length - 1))
                        loadImage(index + 1);
                     else {
						$('.progress').hide();
						swalInit({
                       title: 'File Uploaded Successfully !!!!',
                       text:"",
                       type: 'success',
                       showCloseButton: true,
                      
                     }).then(function (result) {
				 	location.reload();})}; 
            
				},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				if(counter==2)
				swalInit({
                       title: 'Server seems to be busy, please upload designs after some time. !!!!',
                       text:"",
                       type: 'success',
                       showCloseButton: true,
                      
                     }).then(function (result) {
				 	location.reload();})
				else {loadImage(index);
				counter++;
				}
			}
			});
}
var FabricData;
$('#Save,#Saveall').click(function(e) {
	loadBlockUI();
if(e.currentTarget.id=='Save'){
	if($('.list-group-item').hasClass('selected')){
	FabricData=RequestDataForSaveDesign($('.list-group-item.selected'));
	if(!FabricData) { 
		swalInit({
                title: 'Please Add Mandetory Properties !!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
		$.unblockUI(); return;}
	if(!FabricData.length){ 
		swalInit({
                title: 'Please Import Fabrics Or Select Fabric!!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
		$.unblockUI(); return;}
			}else{
				if(!document.getElementById('products').hasChildNodes()){
              swalInit({
                title: 'Please Import Fabric!!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
			}
				else swalInit({
                title: 'Please Select Fabric To Save!!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
		$.unblockUI(); return;
			}
}
else FabricData=RequestDataForSaveDesign($('.list-group-item'));
	if(!FabricData) { 
		swalInit({
                title: 'Please Add Mandetory Properties !!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
		$.unblockUI(); return;}
	if(!FabricData.length){ 
		swalInit({
                title: 'Please Import Fabrics !!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
		$.unblockUI(); return;}
		$.unblockUI();
		loadImage(0);
        });
	
		/* Select all fabrics of the page */

		function selectAllPageItems(){
			$.each($("input[name='fabric']:not(:checked)"), function(index, ele){            
                $('#'+$(ele).val()).trigger('click');
            });
		}

		/* Remove all selected fabrics from Store */

		function deleteAllPageItems(){
            localStorage.setItem('delFabrics',true);
			$.each($("input[name='remove_fabric']:not(:checked)"), function(index, ele){            
                $('input[data-remove-fabric-id='+$(ele).val()+']').trigger('click');
            });
		}


		/* Remove all selected fabrics */

		function removeAllPageItems(){  //vijay
			if (localStorage.getItem("remove-fabrics") != null) 
			{
				$.each($("input[name='remove_fabric']:checked"), function(index, ele){            
                	$('input[data-remove-fabric-id='+$(ele).val()+']').trigger('click');
            	});
	            $('.remove-fabric-from-store-btn').addClass('d-none');
				localStorage.removeItem('remove-fabrics');
				localStorage.removeItem('remove-fabricsV');
			}
			else if(localStorage.getItem("fabrics") != null)
			{
				$.each($("input[name='fabric']:checked"), function(index, ele){            
	                $('#'+$(ele).val()).trigger('click');
	            });
	            $('.fabric-to-store-btn').addClass('d-none');
				localStorage.removeItem('fabrics');
				localStorage.removeItem('fabricsV');
			}
			if (localStorage.getItem("remove-fabricsV") != null) 
			{
				$.each($("input[name='remove_fabric']:checked"), function(index, ele){            
                	$('input[data-remove-fabric-id='+$(ele).val()+']').trigger('click');
            	});
	            $('.remove-fabric-from-store-btn').addClass('d-none');
				localStorage.removeItem('remove-fabrics');
				localStorage.removeItem('remove-fabricsV');
			}
			else if(localStorage.getItem("fabricsV") != null)    //vijay
			{
				$.each($("input[name='fabric']:checked"), function(index, ele){            
	                $('#'+$(ele).val()).trigger('click');
	            });
	            $('.fabric-to-store-btn').addClass('d-none');
				localStorage.removeItem('fabrics');
				localStorage.removeItem('fabricsV');
			}


			$('.fabric-selected-count-element').addClass('d-none');
			
			$('.selected-fabric-count').html('0 selected  <a id="remove_selected_fabrics" href="javascript:void(0)" onclick="removeAllPageItems()" style="color:#444444; padding-left:3px" title="Remove all"> X</a>');
			localStorage.removeItem("delFabrics");
			localStorage.removeItem("delFabricsV"); 
		}

		/* Get the count of selected fabric and display it */

		function selectedFabricCount(action_type){
			
			var selectedFabrics = localStorage.getItem(action_type);

			if (selectedFabrics !== null && selectedFabrics !== undefined) {

				var unique = JSON.parse(selectedFabrics).filter((v, i, a) => a.indexOf(v) === i);
				
				if( unique.length > 0 ){
					$('.fabric-selected-count-element').removeClass('d-none');

					if(action_type =='remove-fabrics')
					{
						$($('.remove-fabric-from-store-btn')[0]).removeClass('d-none');
					}
					else
					{
						$('.fabric-to-store-btn').removeClass('d-none');
					}
				}
				else
				{
					$('.fabric-selected-count-element').addClass('d-none');

					if(action_type =='remove-fabrics')
					{
						$($('.remove-fabric-from-store-btn')[0]).addClass('d-none');
					}
					else
					{
						$('.fabric-to-store-btn').addClass('d-none');
					}
				}
				$('.selected-fabric-count').html(unique.length+' selected  <a href="javascript:void(0)" id="remove_selected_fabrics" onclick="removeAllPageItems()" style="color:#444444; padding-left:3px" title="Remove all"> X</a>');
			}
		}

function CreateJSON(clickedElement) {
    let text = $(clickedElement).text();

    $.ajax({
        url: '{!! route('create.json') !!}',
        type: 'POST',
        data: {
            'text': text,
            '_token': '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function (response) {
            console.log('Configuration forwarded successfully:', response);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            console.error('Details:', xhr.responseText);
        }
    });
}
	
	/* Store JSON file*/

	/* Create FabricJSON data start */
	function CreateFabricJSON(clickedElement) {
		const text = $(clickedElement).text();
		$.ajax({
			type: "GET",
			url: '{!! route('create.json.fabric') !!}',
			data: {'text':text},
			xhrFields: {
				responseType: 'json'
			},
			success: function (response, status, xhr) {
				const disposition = xhr.getResponseHeader('Content-Disposition');
				let filename = "fabric.json";
				if (disposition && disposition.indexOf('attachment') !== -1) {
					const matches = /filename="([^"]*)"/.exec(disposition);
					if (matches != null && matches[1]) {
						filename = matches[1];
					}
				}

			},
			error: function (xhr, status, error) {
				console.error('Error downloading JSON file:', error);
				alert('Failed to download JSON file. Please try again.');
			}
		});
	}
	/* Create FabricJSON data end */
		/* Call to move fabrics from vendor panel to store */

		function moveFabricToStore(){

			var selectedFabrics = localStorage.getItem('fabrics');

			selectedFabrics = JSON.parse(selectedFabrics);

			$.ajax({
				type: "GET",
				url: '{!! route('fabric.tailori.sync.store') !!}',
				contentType: true,
				data: {'fabricIds': selectedFabrics},
				success: function (response) {
					syncFabricToStore(response);
				},
				error: function (xhr, status, error) {
					alert(xhr.responseText);
				}
			});
		}

		/* Call to remove fabrics from vendor panel*/

		function removeFabricToStore(){

			var selectedFabrics = localStorage.getItem('remove-fabrics');

			selectedFabrics 	= JSON.parse(selectedFabrics);
			var selected_store 	= $("input[name=fabric-view]:checked").val();

			swal({
              title: 'Are you sure?',
              text: "You won't be able to recover this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, remove it!',
              cancelButtonText: 'No, cancel!',
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false
            }).then(function (result) {
              if(result.value){
              	loadBlockUI();
			      $.ajax({
			          type: 'POST',
			          url: '{!! route('remove.vendor.fabric') !!}',
			          data: {'fabrics': selectedFabrics, "_token": "{{ csrf_token() }}"},
			          success: function (data) 
			          		{
					            localStorage.removeItem("delFabrics");
					            data = JSON.parse(data);
					            console.log(data);
					            $.ajax({
								type: 'Get',
								url: data.url,
								dataType:'json',
								data: { 'tailori_fabric_code': data.sku},
								success: function(resp){
									$.unblockUI();
									swal({
					                        title: 'Fabric removed successfully',
					                        type: 'success',
					                        showCloseButton: true
					                    }).catch(swal.noop)
					                    .then(function() {
					                    	location.reload(true);
					               });
								}
							});

					             
			                }
			            });
			          }
			          else if(result.dismiss == 'cancel'){
			                  swal({
			                      title: 'For your information',
			                      text: 'Record has not been removed!',
			                      type: 'info',
			                      animation: false
			                    });
			      }
			    });
		}

		

		function syncFabricToStore(fabrics){
			loadBlockUI();
            $.ajax({
                type: 'POST',
                url: '{!! $host !!}index.php?route=tailori/custom/syncFabrics',
                dataType: 'json',
                data: {'fabrics': fabrics},
                success: function(response){
                    setVendorFabricStatus(response);
					setTimeout( function(){
						$.unblockUI();
					}, 400);
                }
            });
        }

		/* Set or update vendor fabric status */
		function setVendorFabricStatus(fabricIds){

			fabricIds = JSON.parse(JSON.stringify(fabricIds));
			
			$.ajax({
				type: 'POST',
				url: '{!! route('vendor.fabric.status.store') !!}',
				dataType: 'json',
				data: {'fabricIds': fabricIds, "_token": "{{ csrf_token() }}" },
				success: function(response){
					swalInit({
                        title: 'Fabrics migrated to store successfully',
                        type: 'success',
                        showCloseButton: true
                    }).catch(swal.noop)
                    .then(function() {
                        location.reload(true);
                    });
				}
			});
		}

		function getFabric(ele){

			$("#modal_form_vertical").on("hidden.bs.modal", function () {
				$('#fabric_form')[0].reset();
				validator.resetForm();
			});

			var fabricId = $(ele).data('fabric-id');

			$.ajax({
				type: 'POST',
				url: '{!! route('requested.fabric.get') !!}',
				dataType: 'json',
				data: {'fabricId': fabricId, "_token": "{{ csrf_token() }}" },
				success: function(response){
					$('#hd_fabric_name').val(response.fabric_name);
					$('#hd_price').val(response.price);
					$('#hd_fabric_description').val(response.description);
					$('#hd_fabric_id').val(response.fabric_id);
					$('#hd_fabric_code').val(response.tailori_fabric_code);
				}
			});
		}

		/* Vendor Upload fabric validation and submission */

		 $('#upload_modal_form_vertical').find('#upload_fabric_form').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            successClass: 'validation-valid-label',
            validClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            errorPlacement: function(error, element) {
                // Unstyled checkboxes, radios
                if (element.parents().hasClass('form-check')) {
                    error.appendTo( element.parents('.form-check').parent() );
                }

                // Input with icons and Select2
                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo( element.parent() );
                }

                // Input group, styled file input
                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                    error.appendTo( element.parent().parent() );
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                  fabric_name: {
                    required: true,
                    minlength: 3
                  },
                  product_type: {
                    required: true,
                  },
                  // price: {
                  //   required: true,
                  //   digits:true
                  // },
                  wear_type: {
                    required: true,
                  },
                  color: {
                    required: true,
                    //lettersonly:true
                  },
                  design_pattern: {
                    required: true,
                  },

                //  fabric_image: { 
                //     required: true, 
                //     extension: "png|jpg", 
                //     filesize: 1048576  
                // }, 
                
            },
            messages: {
                    fabric_name:{
                        required:'Enter Fabric Name'
                    },
                    product_type:{
                        required:'Enter Product Type'
                    },
                    // price:{
                    //     required:'Enter Price'
                    // },
                    wear_type:{
                        required:'Select Wear Type'
                    },
                    color:{
                        required:'Enter Color'
                    },
                    design_pattern:{
                        required:'Enter Design pattern'
                    },
                    // fabric_image: { 
                    //     required: 'Upload Fabric', 
                    //     extension: "png|jpg", 
                    //     filesize: 1048576  
                    // }, 
                },
            submitHandler: function(form) {
                $.blockUI({ 
                    message: '<i class="icon-spinner4 spinner"></i><h5>Please Wait...</h5>',
                    overlayCSS: {
                      backgroundColor: '#1b2024',
                      opacity: 0.9,
                      zIndex: 1200,
                      cursor: 'wait'
                    },
                    css: {
                      border: 0,
                      color: '#fff',
                      padding: 0,
                      zIndex: 1201,
                      backgroundColor: 'transparent'
                    }
                  });
                var formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: '{!! route('fabric.store') !!}',
                    data: formData,
                    processData: false, 
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        $.unblockUI();
                        swalInit({
                            title: response.message,
                            type: (response.message_code==1)?'success':'error',
                            showCloseButton: true
                        }).catch(swal.noop)
                        .then(function() {
                            $('#upload_fabric_form')[0].reset();
                            $('.close').trigger('click');
                            location.reload();
                        });
                    }
                });
            }
        });
// jQuery.validator.addMethod("lettersonly", function(value, element) {
//   return this.optional(element) || /^[a-z]+$/i.test(value);
// }, "Letters only please"); 
		/* Vendor form validation and submission */

		var validator = $('#fabric_form').validate({
			ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
			errorClass: 'validation-invalid-label',
			successClass: 'validation-valid-label',
			validClass: 'validation-valid-label',
			highlight: function(element, errorClass) {
				$(element).removeClass(errorClass);
			},
			unhighlight: function(element, errorClass) {
				$(element).removeClass(errorClass);
			},
			// Different components require proper error label placement
			errorPlacement: function(error, element) {
				// Unstyled checkboxes, radios
				if (element.parents().hasClass('form-check')) {
					error.appendTo( element.parents('.form-check').parent() );
				}

				// Input with icons and Select2
				else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
					error.appendTo( element.parent() );
				}

				// Input group, styled file input
				else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
					error.appendTo( element.parent().parent() );
				}

				// Other elements
				else {
					error.insertAfter(element);
				}
			},
			rules: {
				hd_price: {
					number: true
				},
				hd_fabric_name:{
					required: true,
				}
			},
			submitHandler: function(form) {
				//var formData = new FormData(form);
				var formData1 = new FormData(form);
				console.log(formData1);
				$.ajax({
					type: 'POST',
					url: '{!! route('vendor.fabric.update') !!}',
					data: formData1,
					processData: false,
					contentType: false,
					success: function (response) {
						response = JSON.parse(response);
						if(response.exist){
							// $.ajax({
							// 	type: 'POST',
							// 	url: response.storeUrl,
							// 	dataType:'json',
							// 	data: { 'tailori_fabric_code': response.tailori_fabric_code, 'fabric_name': response.fabric_name, 'description': response.description, 'price': response.price },
							// 	success: function(resp){
							// 		console.log(resp);
									swalInit({
										title: 'Fabric details updated successfully',
										type: 'success',
										showCloseButton: true
									}).catch(swal.noop)
									.then(function() {
										$('.close').trigger('click');
										location.reload();
								// 	});
								// }
							});
							
						}
						else
						{
							swalInit({
										title: 'Fabric details updated successfully',
										type: 'success',
										showCloseButton: true
									}).catch(swal.noop)
									.then(function() {
										$('.close').trigger('click');
										location.reload();
									});
						}
					}
				});
			}
		});
		
		function selectedFabricColors(ele){

			var count = $(ele).select2('data').length;
			if(count > 1){
				var uldiv = $(ele).siblings('span.select2').find('ul');
				uldiv.html("<li class='select2-selection__choice'>"+count+" items selected</li>");
				$('.color-multiselect ').css('border-bottom','2px solid #009688');
			}
			if(count >= 1){	
				
				$('.color-multiselect ').css('border-bottom','2px solid #009688');
			}
			else{
				$('.color-multiselect ').css('border-bottom','1px solid #ddd');
			}
		}

		$(document).on('select2:select', ".color-multiselect select", function (evt) {
			selectedFabricColors(this);
			filterType();
		});

		$(document).on('select2:unselect', ".color-multiselect select", function (evt) {
			selectedFabricColors(this);
			filterType();
		});

		$("#wear_type").change(function () {
        let selectedWearType = $(this).val();
        let productDropdown = $("#product");

        productDropdown.html('<option disabled="disabled" selected="selected">Select Product</option>');

        $.ajax({
            url: '{!! route('get.vendor.products') !!}',
            type: "GET",
            dataType: "json",
            success: function (products) {
                // Filter products based on wear type selection
                products.forEach(product => {
					let productName = product.product_name.toUpperCase();
                    if ((selectedWearType === "men" && product.product_name !== "Women_Shirt") ||
                        (selectedWearType === "women" && product.product_name === "Women_Shirt")) {
                        
                        let newOption = $("<option>", {
                            value: productName,
                            text: product.product_name
                        });

                        productDropdown.append(newOption);
                    }
                });
            },
            error: function (error) {
                console.error("Error fetching products:", error);
            }
        });
    });
		

// For product and its types 
		const productOptions = {
			SHIRT: [
			{ value: "SHIRT", label: "Shirt" },
			{ value: "SHIRT_CONTRAST", label: "Contrast" },
			{ value: "SHIRT_THREAD_HOLE", label: "Thread Hole" },
			{ value: "SHIRT_BUTTON_T", label: "Button" }
			],
			WOMEN_SHIRT: [
			{ value: "WOMEN_SHIRT", label: "Women-Shirt" },
			{ value: "SHIRT_CONTRAST", label: "Contrast" },
			{ value: "SHIRT_THREAD_HOLE", label: "Thread Hole" },
			{ value: "SHIRT_BUTTON_T", label: "Button" }
			],
			SUIT: [
			{ value: "SUIT", label: "Suit" },
			{ value: "SHIRT_CONTRAST", label: "Contrast" },
			{ value: "INNER_LINING", label: "Inner Lining" },
			{ value: "JACKET_THREAD_HOLE", label: "Button Thread" },
			{ value: "JACKET_BUTTON_T", label: "Button" }
			],
			WAISTCOAT: [
			{ value: "WAISTCOAT", label: "Waistcoat" },
			{ value: "INNER_LINING", label: "Inner Lining" },
			{ value: "JACKET_THREAD_HOLE", label: "Button Thread" },
			{ value: "JACKET_BUTTON_T", label: "Button" }
			],
			JACKET: [
			{ value: "JACKET", label: "Jacket" },
			{ value: "SHIRT_CONTRAST", label: "Contrast" },
			{ value: "INNER_LINING", label: "Inner Lining" },
			{ value: "JACKET_THREAD_HOLE", label: "Button Thread" },
			{ value: "JACKET_BUTTON_T", label: "Button" }
			],
			BUNDYS: [
			{ value: "BUNDY", label: "Bundy" },
			{ value: "JACKET_BUTTON_T", label: "Button" }
			],
			BANDHGALA: [
			{ value: "BANDHGALA", label: "Bandhgala" },
			{ value: "JACKET_THREAD_HOLE", label: "Button Thread" },
			{ value: "JACKET_BUTTON_T", label: "Button" }
			],
			TROUSER: [
				{ value: "TROUSER", label: "Trouser" }
			]
		};

		function updateProductType() {
			const productDropdown = document.getElementById('product');
			const productTypeDropdown = document.getElementById('product_type');

			// Clear previous options
			productTypeDropdown.innerHTML = '<option disabled="disabled" selected="selected">Select Product Type</option>';

			const selectedProduct = productDropdown.value;

			if (productOptions[selectedProduct]) {
			productOptions[selectedProduct].forEach(option => {
				const newOption = document.createElement('option');
				newOption.value = option.value;
				newOption.textContent = option.label;
				productTypeDropdown.appendChild(newOption);
			});
			}
		}

    </script>
@endsection