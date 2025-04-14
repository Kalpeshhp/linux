@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (!empty($vendor_products))
                            <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified" id="style-listing">
                                @foreach ($vendor_products as $key=>$product)
                                    @if ($key == 0) 
                                   
                                        <li class="nav-item"><a href="#bottom-justified-divided-{{$product['tailori_products']['product_name']}}" data-id="{{$product['tailori_products']['tailori_products_id']}}" data-code="{{$product['tailori_products']['tailori_product_code']}}" data-product="{{ $product['tailori_products']['product_name'] }}" class="nav-link active show default-trigger" data-toggle="tab" onclick="fetchElement(this)">{{ $product['tailori_products']['product_name'] }}</a></li>
                                    @else
                                        <li class="nav-item"><a href="#bottom-justified-divided-{{$product['tailori_products']['product_name']}}" data-id="{{$product['tailori_products']['tailori_products_id']}}" data-code="{{$product['tailori_products']['tailori_product_code']}}" data-product="{{ $product['tailori_products']['product_name'] }}" class="nav-link" data-toggle="tab" onclick="fetchElement(this)">{{ $product['tailori_products']['product_name'] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                @foreach ($vendor_products as $key=>$product)

                                    @if ($key == 0)
                                        <div class="tab-pane fade active show" id="bottom-justified-divided-{{ $product['tailori_products']['product_name'] }}">
                                    @else   
                                        <div class="tab-pane fade" id="bottom-justified-divided-{{ $product['tailori_products']['product_name'] }}">
                                    @endif
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="">
                                                        <div class="">
                                                            <div class="d-md-flex">
                                                                <ul class="nav nav-tabs nav-tabs-vertical flex-column mr-md-3 wmin-md-200 mb-md-0 border-bottom-0 hmin-340" id="element_content_{{ $product['tailori_products']['product_name'] }}"></ul>
                                                                <div class="tab-content element-container" id="element_container_{{$product['tailori_products']['product_name']}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-success save-btn" id="save_btn_{{$product['tailori_products']['product_name']}}" onclick="saveConfiguration('{{$product['tailori_products']['product_name']}}')">Save</button>
                                            <!-- <button type="button" class="btn btn-success save-btn " id="save_btn_{{$product['tailori_products']['product_name']}}" onclick="syncConfiguration('{{$product['tailori_products']['product_name']}}')">Sync</button> -->
                                    </div>
                                @endforeach
                            </div>
                        @else
                        <?php if(auth()->user()->user_group === 1) {?>
                        <button type="button" class="btn btn-success save-btn syncConfiguration" onclick="syncConfiguration('this')">Sync</button>
                        <?php } ?>
                        <h4 style="text-align:center"><i class="icon-warning22 mr-1 icon-2x" style="color:orangered"></i>No subscription available!</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vertical form modal -->
    <div id="modal_form_vertical" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h5 class="modal-title">Update</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="#" name="attr_details" id="attr_details">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" id="child_attr_id" name="child_attr_id" />
                                <div class="col-sm-6">
                                    <div class="col-sm-12 product">
                                        <div class="img_box_style">
                                            <label class="selected">
                                                <img id="child_attr_image_url" src="" alt="Default Image">
                                                <img id="child_attr_user_image_url" style="display:none;" src="" alt="User Uploaded Image">
                                            </label>
                                            <div class="img_btns">
                                            <input type="file" id="childImageUploader" accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('childImageUploader').click();">
                                                    <i class="icon-upload" style="padding-right:.5rem"></i>Upload
                                                </button>
                                                <button type="button" class="btn btn-primary" id="childDeleteButton" style="display:none;">
                                                    <i class="icon-trash" style="padding-right:.5rem"></i>Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-sm-12" style="padding-bottom:.6rem">
                                        <label>Child Attribute name</label>
                                        <input type="text" id="child_attr_name" placeholder="Eugene" class="form-control" name="style_name" required>
                                    </div>
                                    <div class="col-sm-12" style="padding-bottom:.6rem">
                                        <label>Sequence</label>
                                        <input type="text" id="child_attr_sequence" placeholder="Eugene" class="form-control" name="seq_name" required>
                                    </div>

                                    <div class="col-sm-12" style="padding-bottom:.6rem">
                                        <label>Price</label>
                                        <input type="text" id="child_attr_price" placeholder="Kopyov" class="form-control"  name="price" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-primary">Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /vertical form modal -->
        <!-- Vertical form modal -->
    <div id="modal_form_edit_list" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h5 class="modal-title">Edit List</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="#" name="attr_details_parent" id="attr_details_parent">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" id="attr_id" name="attr_id" />
                                <div class="col-sm-6">
                                    <div class="col-sm-12 product">
                                        <div class="img_box_style">
                                            <label class="selected">
                                                <img id="parent_attr_image_url" src="" alt="Default Image">
                                                <img id="parent_attr_user_image_url" style="display:none;" src="" alt="User Uploaded Image">
                                            </label>
                                            <div class="img_btns">
                                            <input type="file" id="parentImageUploader" accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('parentImageUploader').click();">
                                                    <i class="icon-upload" style="padding-right:.5rem"></i>Upload
                                                </button>
                                                <button type="button" class="btn btn-primary" id="parentDeleteButton" style="display:none;">
                                                    <i class="icon-trash" style="padding-right:.5rem"></i>Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-sm-6">
                                <div class="col-sm-12" style="padding-bottom:.6rem">
                                    <label>Attribute name</label>
                                    <input type="text" id="parent_attribute_name" placeholder="Eugene" class="form-control" name="parent_attribute_name" required>
                                </div>
                                <div class="col-sm-12" style="padding-bottom:.6rem">
                                    <label>Sequence</label>
                                    <input type="text" id="parent_attribute_sequence" placeholder="Eugene" class="form-control" name="parent_attribute_sequence" required>
                                </div>                                
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-primary">Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /vertical form modal -->
@endsection

@section('scripts')
    {!!Html::script('js/plugins/notifications/jgrowl.min.js')!!}
    {!!Html::script('js/plugins/notifications/noty.min.js')!!}
    {!!Html::script('js/plugins/forms/validation/validate.min.js')!!}
    <script>

        Noty.overrideDefaults({
            theme: 'limitless',
            layout: 'topRight',
            type: 'alert',
            timeout: 2500
        });
        
        $(document).ready(function() {
            if (localStorage.getItem("selected-style") != null) 
            {
                var selected_style = localStorage.getItem("selected-style");
                $("#style-listing").find(".nav-link[data-id="+selected_style+"]").trigger('click');
            }
            else{
                $('.default-trigger').trigger('click');
            }
        });

        function fetchElement(el){
            var productId = $(el).attr('data-id');
             localStorage.setItem('selected-style', productId);
            var productName = $(el).attr('data-product');
            $('#element_content_'+productName).html('');
            var contentElement = '';
            var container = ''; 
            $.ajax({
                url: '{!! route('tailori.elements.get') !!}',
                method: 'get',
                data: {'productId': productId},
                success: function (response) {
                    let elements = response;
                    $.each( elements, function(index, value){        
                        contentElement += '<li class="nav-item "><a data-product-id="'+value.product_id+'" data-element-index="'+value.id+'" data-element-id="'+value.tailori_element_code+'" onclick="fetchStyles(this)" href="#vertical-left-tab-'+value.tailori_element_code+'" class="nav-link" data-toggle="tab"><i class="icon-menu7 mr-2"></i><div class="editList" style="postiton:absolute;right:1rem" ><i class="icon-pencil"  title="Edit" data-toggle="modal" onclick="getparentAttributeData(this)"  data-target="#modal_form_edit_list"></i></div>'+ value.element_name+'</a></li>';
                        container += '<div class="tab-pane fade" id="vertical-left-tab-'+value.tailori_element_code+'"></div>'
                    });

                    $('#element_content_'+productName).append(contentElement);

                    $('#element_container_'+productName).append(container);

                    $( "#element_content_"+productName+ " li:nth-child(1) a" ).trigger('click');
                }
            })
        }

        function fetchStyles(el){
            var elementIndex = $(el).attr('data-element-index');
            var elementId = $(el).attr('data-element-id');
            var productId = $(el).attr('data-product-id');
            element = $('#vertical-left-tab-'+elementId).html('');
            $.ajax({
                url: '{!! route('tailori.styles.get') !!}',
                method: 'get',
                data: {'elementId': elementIndex},
                success: function (response) {
                    var attributes = JSON.parse(response);
                    var element = '';
                    element = $('#vertical-left-tab-'+elementId).html('');
                    $.each( attributes, function(index, styles){
                        var r = Math.random().toString(36).substring(7);
                        element = $('#vertical-left-tab-'+elementId);
                        $(element).append('<p><h4>'+index.replace('_', ' ')+'</h4></p>');
                        $(element).append('<div class="'+index.replace('/','')+'-'+r+' product"></div>');
                        console.log(styles);
                        $.each(styles, function(ind, value){
                            var customThumbImage = value.customThumbImage;
                            var selectStatus = value.is_selected;
                            if(selectStatus == 1){
                                var selectionClass = 'selected';
                                var isChecked = 'checked';
                                var isDisabled = 'disabled';
                            }
                            else{
                                var selectionClass = 'unselected';
                                var isChecked = '';
                                var isDisabled = '';
                            }

							if(customThumbImage === null){
                                var image = value.image;
                            }else{
                                var image =value.customThumbImage
                            }
                            if(value.custom_style_name === null){
                                var customAttributeName = value.attribute_name;
                                //alert(customAttributeName);
                            }
                            else{
                                var customAttributeName = value.custom_style_name;
                            }
                            var dataSelection = elementIndex+'-'+value.style_id+"-"+value.id;
                            var str = index.replace('/','');
                            $('.'+str+'-'+r).append('<input type="checkbox" '+isChecked+' '+isDisabled+' data-product-id="'+productId+'" data-selection="'+dataSelection+'" data-parent="'+elementId+'" value="'+value.attribute_name+'" class="product-checkbox attribute" id="'+value.tailori_attribute_code+'"><label title="Click to select" data-parent="'+elementId+'" id="lbl_attr_'+value.tailori_attribute_code+'" for="'+value.tailori_attribute_code+'" class="'+selectionClass+' lbl-'+value.tailori_attribute_code+'" ><input type="text" id="input_'+value.tailori_attribute_code+'" data-check-id="'+value.tailori_attribute_code+'"><img src="'+image+'">'+customAttributeName+'<div class="product-action"><a href="" onclick="getAttributeData(this)" data-record-id="'+value.id+'" title="Edit" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-pencil"></i></a><a href="JavaScript:void(0);" data-record-id="'+value.id+'" title="Delete" data-attribute-id="'+value.tailori_attribute_code+'" onclick="removeConfiguratorAttribute(this)"><i class="icon-trash"></i></a></div></label>');
                        });
                    });
                    checkSelected(elementId);
                }
            })
        }

        var selectedAttributes = [];
        var sArray = [];
        $(document).on('click', '.product-checkbox', function(){

            var productId = $(this).data('product-id');

            var parentId = $(this).data('parent');
            
            var attributeSelectionLimit = getSelectionLimit(productId);
            
            var selectedCount = $("#vertical-left-tab-"+parentId+" input[type=checkbox]:checked").length;
            
            if(selectedCount > attributeSelectionLimit){
                $(this). prop("checked", false);
                new Noty({
                theme: ' alert alert-danger alert-styled-left p-0',
                text: 'You can select upto <b>' +attributeSelectionLimit+ '</b> styles.',
                type: 'error',
                progressBar: false,
                closeWith: ['button']
            }).show();
                return false;
            }
            if($(this).is(':checked')) {
                
                selectedAttributes.push( this.id+'_'+$(this).data('selection') );

                $('#input_'+this.id).val(this.id+'_'+$(this).data('selection'));

                $('.lbl-'+this.id).addClass('checked');
               
            }else{
                selectedAttributes.splice( $.inArray(this.id, selectedAttributes), 1 );
                $('.lbl-'+this.id).removeClass('checked');
            }
            selectedAttributes = selectedAttributes.filter(function(elem, index, self) {
               return index === self.indexOf(elem);
            });

        });

        function checkSelected(elementId){
            $.each(selectedAttributes, function(index, value){
                var currentElementId = value.split('_')[0];
                $('#vertical-left-tab-'+elementId+' #'+currentElementId).trigger('click');
            });
            selectedAttributes = selectedAttributes.filter(function(elem, index, self) {
                return index === self.indexOf(elem);
            });
        }

        function saveConfiguration(product){
            var productSelectedElement = [];
            $("#element_container_"+product+" input[type='text']").each(function () {
                if($(this).val() != ""){
                    productSelectedElement.push($(this).val());
                }
            });
            $.ajax({
                url: '{!! route('tailori.configuration.store') !!}',
                method: 'post',
                data: {'product': product, 'attributes': productSelectedElement, '_token': "{{ csrf_token() }}" },
                success: function (response) {
                    swalInit({
                        title: 'Configuration updated successfully',
                        type: 'success',
                        showCloseButton: true
                    }).catch(swal.noop)
                    .then(function() {
                        //location.reload();
                    });
                }
            })
        }

        function getSelectionLimit(productId){
            var attributeLimit;
            $.ajax({
                url: '{!! route('tailori.selection.limit.get') !!}',
                method: 'get',
                async: false,
                data: {'productId': productId},
                success: function (response) {
                    response = JSON.parse(response);
                    attributeLimit = response[0]['attribute_limit'];
                }
            });
            return attributeLimit;
        }

        function removeConfiguratorAttribute(elem){

            var attributeId = $(elem).data('record-id');
            var attributeCode = $(elem).data('attribute-id');
            swalInit({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function(result) {
                if(result.value) {
                    $.ajax({
                        url: '{!! route('tailori.configuration.remove') !!}',
                        method: 'get',
                        data: {'attributeId': attributeId, '_token': "{{ csrf_token() }}"},
                        success: function (response) {
                            if(response == 1){
                                $.ajax({
                                    url: '{!! route('tailori.configuration.remove') !!}',
                                    method: 'get',
                                    data: {'attributeId': attributeId, '_token': "{{ csrf_token() }}"},
                                    success: function (response) {
                                        $("#"+attributeCode).prop('checked', false); 
                                        $("#"+attributeCode).prop('disabled', false);
                                        $('#lbl_attr_'+attributeCode).removeClass('selected');
                                        $('#lbl_attr_'+attributeCode).addClass('unselected');
                                        $('#lbl_attr_'+attributeCode).removeClass('checked');
                                         swalInit(
                                            'Removed!',
                                            'style configuration removed',
                                            'success'
                                        );
                                    }
                                });
                            }
                            else{
                                swalInit(
                                    'Cancelled',
                                    'Configuration does not exist',
                                    'error'
                                );
                            }
                        }
                    });
                }
                else if(result.dismiss === swal.DismissReason.cancel) {
                    swalInit(
                        'Cancelled',
                        'No changes made.',
                        'error'
                    );
                }
            });
        }

        var validator = $('#attr_details').validate({
            ignore: 'input[type=hidden], .select2-search__field',
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
				if (element.parents().hasClass('form-check')) {
					error.appendTo( element.parents('.form-check').parent() );
				}
				else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
					error.appendTo( element.parent() );
				}
				else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
					error.appendTo( element.parent().parent() );
				}
				else {
					error.insertAfter(element);
				}
			},
			rules: {
				price: {
					number: true
				},
				style_name:{
					required: true,
				}
			},
            submitHandler: function() {
                $.ajax({
                    type: 'POST',
					url: '{!! route('tailori.attribute.data.update') !!}',
					data: $('form').serialize(),
					success: function (response) {
                        swalInit({
                            title: 'Successfully updated',
                            type: 'success',
                            showCloseButton: true
                        })
                        .catch(swal.noop)
                        .then(function() {
                            location.reload();
                        });
                    }
                });
            }
        });

        function getAttributeData(elem){

            $("#modal_form_vertical").on("hidden.bs.modal", function () {
                $('#attr_details')[0].reset();
                validator.resetForm();
            });

            var attributeId = $(elem).data('record-id');
            $.ajax({
                url: '{!! route('tailori.attribute.data.get') !!}',
                method: 'GET',
                data: { 'attributeId': attributeId, '_token': "{{ csrf_token() }}" },
                success: function (response) {
                    response = JSON.parse(response);

                    $('#child_attr_name').val(response.name);
                    $('#child_attr_price').val(response.price);
                    $('#child_attr_id').val(attributeId);
                    $('#child_attr_sequence').val(response.Sequence);

                    const userImage = $('#child_attr_user_image_url');
                    const defaultImage = $('#child_attr_image_url');
                    const deleteButton = $('#childDeleteButton');

                    if (response.vendor_thumb_image) {
                        userImage.attr('src', response.vendor_thumb_image).show();
                        defaultImage.hide();
                        deleteButton.show();
                    } else {
                        userImage.hide();
                        defaultImage.attr('src', response.imageurl).show();
                        deleteButton.hide();
                    }
                }
            });
        }

        function getparentAttributeData(el) {
            var parent = $(el).closest('a');
            
            var productId = parent.data('product-id');
            var elementIndex = parent.data('element-index');
            var elementId = parent.data('element-id');
           
            $("#modal_form_vertical").on("hidden.bs.modal", function () {
                $('#attr_details_parent')[0].reset();
                validator.resetForm();
            });

            $.ajax({
                url: '{!! route('tailori.parent.attribute.data.get') !!}',
                method: 'get',
                data: {
                    productId: productId,
                    elementIndex: elementIndex,
                    elementId: elementId
                },
                success: function (response) {
                    var elements = JSON.parse(response);
                    
                    $('#parent_attribute_name').val(elements.name);
                    $('#parent_attribute_sequence').val(elements.Sequence);

                    const userImage = $('#parent_attr_user_image_url');
                    const defaultImage = $('#parent_attr_image_url');
                    const deleteButton = $('#parentDeleteButton');

                    if (elements.vendor_thumb_image) {
                        userImage.attr('src', elements.vendor_thumb_image).show();
                        defaultImage.hide();
                        deleteButton.show();
                    } else {
                        userImage.hide();
                        defaultImage.attr('src', elements.imageurl).show();
                        deleteButton.hide();
                    }
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        var validator = $('#attr_details_parent').validate({
            ignore: 'input[type=hidden], .select2-search__field',
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
				if (element.parents().hasClass('form-check')) {
					error.appendTo( element.parents('.form-check').parent() );
				}
				else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
					error.appendTo( element.parent() );
				}
				else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
					error.appendTo( element.parent().parent() );
				}
				else {
					error.insertAfter(element);
				}
			},
			rules: {
				style_name:{
					required: true,
				}
			},
            submitHandler: function(form) {
                var activeTab = document.querySelector('[id^="element_content_"] li .nav-link.active');        
                var productId = activeTab ? activeTab.getAttribute('data-product-id') : null;
                var elementIndex = activeTab ? activeTab.getAttribute('data-element-index') : null;
                var elementId = activeTab ? activeTab.getAttribute('data-element-id') : null;

                var formData = $(form).serialize();
                formData += '&product_id=' + encodeURIComponent(productId);
                formData += '&element_index=' + encodeURIComponent(elementIndex);
                formData += '&element_id=' + encodeURIComponent(elementId);

                $.ajax({
                    type: 'POST',
                    url: '{!! route('tailori.parent.attribute.data.update') !!}',
                    data: formData,
                    success: function(response) {
                        swalInit({
                            title: 'Successfully updated',
                            type: 'success',
                            showCloseButton: true
                        })
                        .catch(swal.noop)
                        .then(function() {
                            location.reload();
                        });
                    }
                });
            }
        });

        $('#parentImageUploader').on('change', function (event) {
        handleImageUpload(event, 'parent');
        });

        $('#childImageUploader').on('change', function (event) {
            handleImageUpload(event, 'child');
        });

        $('#parentDeleteButton').on('click', function () {
            deleteImage('parent');
        });

        $('#childDeleteButton').on('click', function () {
            deleteImage('child');
        });

        function handleImageUpload(event, type) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const base64Image = e.target.result;
                    const attrName = type === 'child' ? $('#child_attr_name').val() : $('#parent_attribute_name').val();
                    const attrId = type === 'child' ? $('#child_attr_id').val() : $('#parent_attr_id').val();
                    var activeTab = document.querySelector('[id^="element_content_"] li .nav-link.active');        
                    var productId = activeTab ? activeTab.getAttribute('data-product-id') : null;
                    var elementIndex = activeTab ? activeTab.getAttribute('data-element-index') : null;
                    var elementId = activeTab ? activeTab.getAttribute('data-element-id') : null;

                    // Update UI
                    if (type === 'child') {
                        $('#child_attr_user_image_url').attr('src', base64Image).show();
                        $('#child_attr_image_url').hide();
                        $('#childDeleteButton').show();
                    } else {
                        $('#parent_attr_user_image_url').attr('src', base64Image).show();
                        $('#parent_attr_image_url').hide();
                        $('#parentDeleteButton').show();
                    }

                    uploadImageToServer(base64Image, attrName, attrId, type,productId,elementIndex,elementId);
                };
                reader.readAsDataURL(file);
            }
        }

        function uploadImageToServer(base64Image, attrName, attrId, type, productId, elementIndex, elementId) {
            $.ajax({
                url: type === 'child' ? '{!! route("upload.child.thumb.image") !!}' : '{!! route("upload.parent.thumb.image") !!}',
                type: 'POST',
                data: {
                    'image': base64Image,
                    'attribute_name': attrName,
                    'attribute_id': attrId,
                    'issave': true,
                    'productId': productId,
                    'elementIndex': elementIndex,
                    'elementId': elementId,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    if(type === 'child'){
                        if (response) {
                            setTimeout(function () {
                                let imageElement = $("label[for='" + response['attr_tailori_code'] + "'] img"); // Alternative selector
                                if (imageElement.length) {
                                    imageElement.attr("src", response[0]);
                                } else {
                                    console.warn("Image element not found for elementId:", elementId);
                                }
                            }, 5000);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error uploading ' + type + ' image:', xhr.responseText || error);
                }
            });
        }


        function deleteImage(type) {
            const attrId = type === 'child' ? $('#child_attr_id').val() : $('#parent_attr_id').val();
            var activeTab = document.querySelector('[id^="element_content_"] li .nav-link.active');        
            var productId = activeTab ? activeTab.getAttribute('data-product-id') : null;
            var elementIndex = activeTab ? activeTab.getAttribute('data-element-index') : null;
            var elementId = activeTab ? activeTab.getAttribute('data-element-id') : null;

            $.ajax({
                url: type === 'child' ? '{!! route("delete.child.thumb.image") !!}' : '{!! route("delete.parent.thumb.image") !!}',
                type: 'POST',
                data: {
                    'attribute_id': attrId,
                    'issave': false,
                    'productId':productId,
                    'elementIndex':elementIndex,
                    'elementId':elementId,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    console.log(type + ' image deleted:', response);

                    // Reset UI
                    if (type === 'child') {
                        $('#child_attr_user_image_url').attr('src', '').hide();
                        $('#child_attr_image_url').attr('src', response.image_url).show();
                        $('#childDeleteButton').hide();
                        if (response) {
                            setTimeout(function () {
                                let imageElement = $("label[for='" + response['attr_tailori_code'] + "'] img");
                                if (imageElement.length) {
                                    imageElement.attr("src", response['image_url']);
                                } else {
                                    console.warn("Image element not found for elementId:", elementId);
                                }
                            }, 5000);
                        }
                    } else {
                        $('#parent_attr_user_image_url').attr('src', '').hide();
                        $('#parent_attr_image_url').attr('src', response.image_url).show();
                        $('#parentDeleteButton').hide();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error deleting ' + type + ' image:', xhr.responseText || error);
                }
            });
        }

        function syncConfiguration(product){
            $.ajax({
                url: '{!! route('tailori.product.sync') !!}',
                method: 'get',
                data: {'product': product }, //'_token': "{{ csrf_token() }}"
                success: function (response) {
                    swalInit({
                        title: 'Configuration updated successfully',
                        type: 'success',
                        showCloseButton: true
                    }).catch(swal.noop)
                    .then(function() {
                        //location.reload();
                    });
                }
            })
        }
    </script>
@endsection
@section('style')
<style>
    .element-container{
        width: 100%;
    }
    .product {
        display: flex;
        text-align: center;
        flex-wrap: wrap;
    }
    .product input{
        padding: 0;
        height: initial;
        width: initial;
        margin-bottom: 0;
        display: none;
        cursor: pointer;
    }
    .product input[type="text"] {
        display: none;
    }
    .product label.checked {
        display: block;
        border: 1px solid #bbd0e5;
        box-shadow: 0px 1px 5px #bbd0e5;
        background: #bbd0e55e;
    }
    .product label {
        position: relative;
        padding: 10px;
        margin: 0 1% 10px;
        border-radius: 5px;
        font-weight: 500;
        width: 18%;
        border: 1px solid #ddd;
        cursor: pointer;
    }
    .product-action {
        position: absolute;
        top: 5px;
        right: 8px;
        display: none;
    }
    .product label:hover .product-action{
        display: block;
    }
    .product-action a {
        padding: 2px 0;
        width: 25px;
        height: 25px;
        border: 2px solid #7ebdb7;
        border-radius: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
    }
    .product-action a i {
        font-size: 11px;
        color: #7ebdb7;
    }
    .product-action a:hover{
        background-color:#7ebdb7;
    }
    .product-action a:hover i{
        color:#fff;
    }
    .product label.selected {
        display: block;
        border: 1px solid #bbd0e5;
        box-shadow: 0px 1px 5px #bbd0e5;
        background: #bbd0e55e;
        /*pointer-events: none;*/
    }
    .product label img {
        width: 100px;
        margin: 0 auto;
        display: block;
        margin-bottom: 10px;
    }
    .save-btn{
        float: right;
        margin-top: 20px;
        /* position: fixed;
        right: 20px;
        bottom: 0; */
        z-index: 9999;
    }
    .mt-0{
        margin-top: 0;
    }
    .hmin-340{
        height: 600px;
        overflow-y: scroll;
		display: block;
    }
    .product label.selected {
    display: block;
    border: 1px solid #bbd0e5;
    box-shadow: 0px 1px 5px #bbd0e5;
    background: #bbd0e55e;  
    }
    .img_box_style label{
        width: 100%;
    }
    .nav-tabs .nav-item{
        position: relative;
    }
    .nav-link{
        position: relative;
    }
    i.icon-pencil.editList {
    position: absolute;
    top: 0.2rem;
    padding: .4rem;
    background: #ffffff;
    border-radius: 50%;
    color: #7ebdb7;
    display:none;
    z-index: 99;    
    }
    .editList {
    position: absolute;
    top: 0.2rem;
    padding: .4rem;
    background: #ffffff;
    border-radius: 50%;
    color: #7ebdb7;
    display:none;
    z-index: 99;   
}
    .nav-item:hover .editList{
        display: block;
    }
    @media (max-width:580px){
    .product label {
            width: 31%;
    }
</style>
@endsection