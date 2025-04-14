@extends('layouts.admin')

@section('content')

    <div class="content">
        <!-- Ajax sourced data -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h4 class="card-title">Fabrics</h4>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-labeled btn-labeled-left dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="false">
                            <b><i class="icon-reading"></i></b> Fabric
                            <div class="legitRipple-ripple" style="left: 34.5162%; top: 39.4737%; transform: translate3d(-50%, -50%, 0px); transition-duration: 0.15s, 0.5s; width: 205.485%;"></div>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(161px, 38px, 0px);">
                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_form_vertical">
                                <i class="icon-add-to-list"></i> Add new
                            </a>
                            <a href="{{route('fabric.tailori.sync')}}" class="dropdown-item">
                                <i class="icon-sync"></i> Sync
                            </a>
                            <a href="#" class="dropdown-item" id="sync_to_store">
                                <i class="icon-mail5"></i> Sync to store
                            </a>
                        </div>
                    </div>
                
                    {{-- <button type="button" class="btn btn-primary btn-labeled btn-labeled-left legitRipple" data-toggle="modal" data-target="#modal_export_form">
                        <b><i class="icon-file-spreadsheet"></i></b> Export
                        <div class="legitRipple-ripple" style="left: 69.0031%; top: 64.4737%; transform: translate3d(-50%, -50%, 0px); transition-duration: 0.15s, 0.5s; width: 205.352%;"></div>
                    </button>
                    <button type="button" class="btn btn-primary legitRipple data-reload" data-action="reload" id="data_refresh">
                        <b></b>
                        <div class="legitRipple-ripple" style="left: 69.0031%; top: 64.4737%; transform: translate3d(-50%, -50%, 0px); transition-duration: 0.15s, 0.5s; width: 205.352%;"></div>
                    </button> --}}
                </div>
            </div>
            <table class="table datatable-ajax table-hover dataTable" id="fabric_tbl">
                <thead>
                    <tr>
                        <th>Fabric Name</th>
                        <th>Fabric ID</th>
                        <th>Product Type</th>
                        <th>Description</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /ajax sourced data -->
    </div>

    <!-- Vertical form modal -->
    <div id="modal_form_vertical" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h4 class="modal-title">Fabric</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="card-body">
                    <form action="#" id="fabric_form" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Select vendor</b></label>
                                    {{Form::select('vendor',$vendors,null,['class'=>'form-control select-search','data-placeholder'=> 'Select vendor', 'required'=>'required','data-fouc'])}}
                                </div>
                                <div class="col-md-6">
                                    <label><b>Fabric name</b></label>
                                    <input type="text" id="fabric_name" name="fabric_name" class="form-control" placeholder="Enter fabric name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Product type</b></label>
                                    <select id="product_type" name="product_type" class="form-control">
                                        <option value="">Select Product Type</option>
                                        <option value="SHIRT">SHIRT</option>
                                        <option value="TROUSER">TROUSER</option>
                                        <option value="JACKET">JACKET</option>
                                        <option value="SUIT">SUIT</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Price</b></label>
                                    <input type="text" id="price" name="price" class="form-control" placeholder="Enter fabric price" required>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Wear type</b></label>
                                    <select id="wear_type" name="wear_type" class="form-control">
                                        <option value="">Select Wear Type</option>
                                        <option value="men">Men</option>
                                        <option value="women">Women</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Color</b></label>
                                    <input type="text" id="color" name="color" class="form-control" placeholder="Enter fabric color" required>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Design Pattern</b></label>
                                    <input type="text" id="design_pattern" name="design_pattern" class="form-control" placeholder="Enter Design Pattern" required>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Fabric Blend</b></label>
                                    <input type="text" id="fabric_blend" name="fabric_blend" class="form-control" placeholder="Enter fabric_blend">
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Fabric image</b></label>
                                    <input type="file" name="fabric_image" class="file-input" data-fouc required>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Description</b></label>
                                    <textarea id="fabric_description" rows="7" name="description" class="form-control" placeholder="Enter description"></textarea>
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
@endsection

@section('scripts')
    {!!Html::script('js/plugins/forms/validation/validate.min.js')!!}
    
    {!!Html::script('js/plugins/uploaders/fileinput/fileinput.min.js')!!}
    <script>
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
            allowedFileExtensions: ["jpg", "png"],
        });

        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });

        $('.select-search').select2({
            dropdownParent: $("#modal_form_vertical"),
            placeholder: 'Select a Vendor',
            allowClear: true
        });
        var fabricsTbl = $('#fabric_tbl').dataTable({
            processing: true,
            serverSide: true,
            fixedHeader: {
                header: true
            },
            ajax: '{{route('fabric.get') }}',
            columns: [
                { data: 'fabric_name', name: 'fabric_name'},
                { data: 'tailori_fabric_code', name: 'tailori_fabric_code'},
                { data: 'product_type', name: 'product_type'},
                { data: 'description', name: 'description'},
            ]
        });

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
                  price: {
                    required: true,
                    digits:true
                  },
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
                    price:{
                        required:'Enter Price',
                    },
                    wear_type:{
                        required:'Select Wear Type'
                    },
                    color:{
                        required:'Enter Color',
                        
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
                $.blockUI(
                    { 
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
                            $('#fabric_form')[0].reset();
                            $('.close').trigger('click');
                            fabricsTbl.DataTable().ajax.reload();
                        });
                    }
                });
            }
        });
// jQuery.validator.addMethod("lettersonly", function(value, element) {
//   return this.optional(element) || /^[a-z]+$/i.test(value);
// }, "Letters only please"); 

        $('#sync_to_store').click( function(){
            $.ajax({
                type: 'GET',
                url: '{!! route('fabric.tailori.sync.store') !!}',
                success: function (response) {
                    syncFabricToStore(response);
                }
            });
        });

        function syncFabricToStore(fabrics){
            $.ajax({
                type: 'POST',
                url: 'http://store.mytailorsstore.com/index.php?route=tailori/custom/syncFabrics',
                dataType: 'json',
                data: {'fabrics': fabrics},
                success: function(response){
                    
                }
            });
        }
    </script>
@endsection
