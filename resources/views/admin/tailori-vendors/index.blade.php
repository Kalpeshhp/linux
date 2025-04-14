@extends('layouts.admin')

@section('content')
    <div class="content">
        <!-- Ajax sourced data -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h4 class="card-title">Vendors</h4>
                <div>
                    <button type="button" class="btn btn-primary btn-labeled btn-labeled-left legitRipple"
                        data-toggle="modal" data-target="#modal_form_vertical">
                        <b><i class="icon-plus3"></i></b> Add Vendor
                        <div class="legitRipple-ripple"
                            style="left: 69.0031%; top: 64.4737%; transform: translate3d(-50%, -50%, 0px); transition-duration: 0.15s, 0.5s; width: 205.352%;">
                        </div>
                    </button>
                </div>
            </div>
            <table class="table datatable-ajax table-hover dataTable" id="vendor_tbl">
                <thead>
                    <tr>
                        <!-- <th></th> <th></th>  commented for AWS as it is showing error  -->
                        <th>Vendor</th>
                        <th>Store name</th>
                        <!-- <th>Email</th> -->
                        <th>Contact Number</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /ajax sourced data -->
    </div>

    <!-- vendor products edit popup start -->
    <div id="vendorProducts" vend class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width:75%">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h4 class="modal-title">Vendor Products</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="card-body">
                <form action="#" id="vendor_products_form" method="POST">
                    <table class="table mb-2" id="productList" style="border-bottom:1px solid #dddd;">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Enable/Disable</th>
                                <th scope="col">Fabric Limit</th>
                                <!-- <th scope="col">Element Limit</th>
                                <th scope="col">Style Limit</th> -->
                                <th scope="col">Attribute Limit</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <button id="vendor_product_saveBtn" type="submit" class="btn btn-primary">Submit form <i
                                class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- vendor products edit popup end -->
    <!--Subscription Popup-->
    <div id="subscription_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h4 class="modal-title">Subscription</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="card-body">
                    <form action="#" id="subscription_form" method="POST">
                        <input type="hidden" name="version" id="version">
                        <!-- <div class="form-group">
                            <label><b>Fabric Limit</b></label>
                            <input type="number" name="fabric_limit" min="0" class="form-control" placeholder="Eg. 10"
                                required>
                        </div> -->
                        <div class="form-group">
                        <div class="row">
                             <div class="col-md-6">
                                 <label><b>Start Date</b></label>
                                 <input type="date" id="start_date" name="start_date"  required/>
                            </div>
                            <div class="col-md-6">
                                <label><b>End Date</b></label>
                                <input type="date" id="end_date" disabled/>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                 <div class="col-md-6">
                                        <label><b>Duration (in months)</b></label>
                                        <input type="number" name="duration" min="1" class="form-control" placeholder="Eg. 1" required />
                                </div>
                                      <div class="form-check">
                                          <label><b>Is Trial</b></label>
                                             <input  type="checkbox" id="is_trial"/>
                                     </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><b>Status</b></label>
                            <select id="status_drpdwn" class="form-control form-control-select2">
                                <option name="active" value="1">active</option>
                                <option name="inactive" value="0">inactive</option>
                            </select>
                    </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i
                                    class="icon-paperplane ml-2"></i></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Subscription Modal ends -->
    <!-- Vertical form modal -->
    <div id="modal_form_vertical" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h4 class="modal-title"> Add Vendor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="card-body">
                    <form action="#" id="vendor_form" vendorId="" method="POST" isEdit="false">
                        <div class="form-group">
                            <label><b>Store Name</b></label>
                            <input type="text" id="vendor_store_name" name="store_name" class="form-control"
                                placeholder="Eg. The shopify store" required>
                        </div>
                        <div class="form-group">
                            <label><b>Store URL</b></label>
                            <input type="text" id="vendor_store_url" name="store_url" class="form-control"
                                placeholder="Eg. The shopify store URL" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>First Name</b></label>
                                    <input type="text" id="vendor_first_name" name="first_name" class="form-control"
                                        placeholder="Eg. Smith" required>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Last name</b></label>
                                    <input type="text" id="vendor_last_name" name="last_name" class="form-control"
                                        placeholder="Eg. Walter" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Email</b></label>
                                    <input type="email" id="vendor_email" name="email" class="form-control"
                                        placeholder="Eg. demo@example.com" min="1" required>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Contact Number</b></label>
                                    <input type="text" id="vendor_contact_number" name="contact_number" class="form-control"
                                        placeholder="Enter contact number" required>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label><b>City</b></label>
                                    <input type="text" id="vendor_city" name="city" class="form-control"
                                        placeholder="Enter city" required>
                                </div>
                                <div class="col-md-4">
                                    <label><b>State</b></label>
                                    <input type="text" id="vendor_state" name="state" class="form-control"
                                        placeholder="Enter state" required>
                                </div>
                                <div class="col-md-4">
                                    <label><b>Pincode</b></label>
                                    <input type="text" id="vendor_pincode" name="pincode" class="form-control"
                                        placeholder="Enter state" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><b>Address</b></label>
                            <textarea id="vendor_address" name="address" class="form-control" placeholder="Enter address"
                                required></textarea>
                        </div>
                        <div class="form-group" id ="username_container">
                            <label><b>Username</b></label>
                            <input type="text" id="vendor_username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group" id="password">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Password</b></label>
                                    <input type="password" id="vendor_password" name="password" class="form-control"
                                        placeholder="Enter password" required>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Confirm Password</b></label>
                                    <input type="password" id="vendor_confirm_password" name="confirm_password"
                                        class="form-control" placeholder="Enter password" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i
                                    class="icon-paperplane ml-2"></i></button>
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
    <script>
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });

        var vendorsTbl = $('#vendor_tbl').dataTable({
            processing: true,
            serverSide: true,
            fixedHeader: {
                header: true
            },
            ajax: '{{route('vendor.get') }}',
            columns: [
                //{ data: 'id', name: 'id',visible:false},
                { data: 'username', name: 'username' },
                { data: 'store_name', name: 'store_name' },
                // { data: 'email', name: 'email'},
                { data: 'contact_number', name: 'contact_number' },
                { data: 'city', name: 'city' },
                { data: 'state', name: 'state' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' },
            ],
            "order": [[1, "desc"]],
        });

        /* Vendor form validation and submission */

        var validator = $('#vendor_form').validate({
            ignore: 'input[type=hidden], .select2-search__field,.ignore input', // ignore hidden fields //shubham added .ignore input
            errorClass: 'validation-invalid-label',
            successClass: 'validation-valid-label',
            validClass: 'validation-valid-label',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            /*  success: function(label) {
                 label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
             }, */
            // Different components require proper error label placement
            errorPlacement: function (error, element) {
                // Unstyled checkboxes, radios
                if (element.parents().hasClass('form-check')) {
                    error.appendTo(element.parents('.form-check').parent());
                }

                // Input with icons and Select2
                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo(element.parent());
                }

                // Input group, styled file input
                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                    error.appendTo(element.parent().parent());
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                store_name: {
                    required: true,
                    minlength: 5
                },
                store_url: {
                    required: true,
                    minlength: 5
                },
                first_name: {
                    required: true,
                    minlength: 3
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                contact_number: {
                    required: true,
                    digits: true,
                    checkMobileNumber: true
                },
                city: {
                    required: true,
                },
                state: {
                    required: true,
                },
                pincode: {
                    required: true,
                },
                address: {
                    required: true,
                },
                username: {
                    required: true,
                    checkUsername: true
                },
                password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                    equalTo: "#vendor_password"
                },
            },
            messages: {
                store_name: {
                    required: 'Enter Store Name',
                },
                store_url: {
                    required: 'Enter Store URL',
                },
                first_name: {
                    required: 'Enter First Name',
                },
                last_name: {
                    required: 'Enter Last Name',
                },
                email: {
                    required: 'Enter Email ',
                },
                contact_number: {
                    required: 'Enter Contact Number '
                },
                city: {
                    required: 'Enter City',
                },
                state: {
                    required: 'Enter State',
                },
                pincode: {
                    required: 'Enter Pincode',
                },
                address: {
                    required: 'Enter Address',
                },
                username: {
                    required: 'Enter Username',
                },
                password: {
                    required: 'Enter Password',
                },
                confirm_password: {
                    required: 'Enter Password',
                },

            },
            submitHandler: function (event) {
                //shubham added purpose: for edit vendor
                const isEdit = $("#vendor_form").attr('isEdit');
                let  url = '{!! route('vendor.store') !!}';
                let successMsg = 'Vendor created successfully';
                if (isEdit === 'true') {
                    const vendorId = $('#vendor_form').attr("vendorId");
                    cacheVendorDetails[vendorId] = null;
                    url = '{!! route('vendor.update', 'vendorId') !!}'.replace('vendorId', vendorId);
                    successMsg = 'Vendor updated successfully';
                } 
                    $.ajax({
                        type: 'POST',
                        url,
                        data: $('form').find("[name != confirm_password]").serialize(),
                        success: function (response) {
                            swalInit({
                                title: successMsg,
                                type: 'success',
                                showCloseButton: true
                            }).catch(swal.noop)
                                .then(function () {
                                    $('.close').trigger('click');
                                    vendorsTbl.DataTable().ajax.reload();
                                });
                        },
                        error: function (error) {
                            console.log(error);
                            swal({
                                title: 'Data Not Saved',
                                type: 'error',
                                showCloseButton: true,
                                confirmButtonClass: 'btn btn-success',
                            })
                        }
                    });
            }
        });
        //shubham Added purpose: for password validation
        jQuery.validator.addMethod("checkMobileNumber", function (value, element) {
            var regex = /[0-9]{10}$/;
            var txtmobile = $('[name="contact_number"]').val();

            if (txtmobile.length == 10 && txtmobile.match(regex)) {
                return regex.test(txtmobile);
            }
        }, "* Please enter 10 digits for a valid Mobile number");

        // $.validator.methods.email = function( value, element ) {
        //   return this.optional( element ) || /[a-z]+@[a-z]+\.[a-z]+/.test( value );
        // }

        $.validator.methods.email = function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+@[a-z]+\.[a-z]+$/.test(value);
        }

        $.validator.addMethod("checkUsername", function (value, element) {
            var regex = /^[A-Za-z][A-Za-z0-9]*$/;
            var txtusername = $('[name="username"]').val();
            if (txtusername.length >= 5 && txtusername.match(regex)) {
                return regex.test(txtusername);
            }
        }, "* Please enter valid Username");

        /* reset modal form and validation*/
        $("#modal_form_vertical").on("hidden.bs.modal", function () {
            $("#password").removeClass('ignore');//shubham added 
            $("#vendor_email").attr('readonly', false)
            $('#vendor_form').attr('isEdit', "false");
            $('#modal_form_vertical .modal-title').text('Add Vendor');
            $('#vendor_form')[0].reset();
            validator.resetForm();
        });

        $("body").on("change", "[name=product_chkbox]", function () {
            const isChecked = $(this).is(':checked');
            const rowNo = $(this).attr('row_no');
            if (isChecked) {
                $(`#${rowNo}`).addClass('checked');
                $(`#${rowNo} [name="attribute_limit"]`).attr('min', 1)
            } else {
                $(`#${rowNo}`).removeClass('checked');
                $(`#${rowNo} [name="attribute_limit"]`).removeAttr('min')
            }
        });

        $("#subscription_form").on("submit", function (e) {
            e.preventDefault();
            storeSubscription();
        });
        $("#vendor_products_form").on("submit", function (e) {
            e.preventDefault();
            storeVendorProducts($('#vendor_form').attr('vendorId'));
        });

        $('body').on('change','#start_date',function(){
            setEndDate();
        })
        $('body').on('input','[name="duration"]',function(){
            setEndDate();
        })

        $('body').on('keydown','input[type=number]',function(event){
           return event.keyCode != 69;
        })

        $('body').on('keydown','input[type=password]',function(event){
            return event.keyCode != 32;
        })
        
        $('body').on('paste','input[type=number]',function(event){
            const pasteData = event.originalEvent.clipboardData.getData('text');
            const isValid = /^[0-9]*$/.test(pasteData) ? true : false;
            return isValid;
        })

        function setEndDate(){
            let startDate = $('#start_date').val();
            let duration = Number($('[name="duration"]').val());
            if(!startDate || !duration || duration < 1){
                $('#end_date').val('');
                return;
            }
            let endDate = calculateEndDate(startDate, duration);
            $('#end_date').val(endDate);
        }

        function calculateEndDate(startDate, durationInMonths) {
                let date = new Date(startDate);
                let newMonth = date.getMonth() + durationInMonths;
                date.setMonth(newMonth);
                if (date.getDate() < new Date(startDate).getDate()) {
                    date.setDate(0);
                } else {
                    date.setDate(date.getDate() - 1);
                }

                let year = date.getFullYear();
                let month = String(date.getMonth() + 1).padStart(2, '0');
                let day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
        function updateVendorStatus(vendorId, setToStatus) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to update this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: 'GET',
                        url: '{!! route('vendor.status.update') !!}',
                        data: { 'vendorId': vendorId, 'setToStatus': setToStatus, '_token': '{{ csrf_token() }}' },
                        success: function (data) {
                            swal({
                                title: 'Vendor status updated',
                                type: 'success',
                                showCloseButton: true,
                                confirmButtonClass: 'btn btn-success',
                            }).catch(swal.noop)
                                .then(function () {
                                    vendorsTbl.DataTable().ajax.reload();
                                });
                        }
                    });
                }
                else if (result.dismiss == 'cancel') {
                    swal({
                        title: 'For your information',
                        text: 'Record has not been updated!',
                        type: 'info',
                        animation: false,
                        confirmButtonClass: 'btn btn-success',
                    });
                }
            });
        }

        function getProducts(VendorId = null) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getProducts') . '?vendorId='}}' + VendorId,
                isAsync: true,
                success: function (data) {
                    if (data) {
                        let products = JSON.parse(data);
                        let productList = '';
                        let srNo = 0;
                        Object.keys(products).forEach((key) => {
                            const { tailori_products_id, product_name, isActive, fabric_limit, attribute_limit } = products[key];
                            ++srNo;
                            const checked = isActive == 1 ? 'checked' : '';
                            productList += `<tr id = ${srNo} class="${checked}">
                                    <th scope="row">${srNo}</th>
                                    <td>${product_name}</td>
                                    <td><input type="checkbox" name="product_chkbox" row_no = ${srNo} value="${tailori_products_id}" style="width: 18px; height: 18px; border-radius: 0px;" ${checked}></td>
                                    <td> <input type="number" name="fabric_limit" class="form-control pl-2" value="${fabric_limit}" style="width: 80px; border:1px solid #ddd; border-top-color: #ddd!important;" min="0"></td>
                                    <td> <input type="number" name="attribute_limit" class="form-control pl-2" value="${attribute_limit}" style="width: 80px; border:1px solid #ddd; border-top-color: #ddd!important;"></td>
                                </tr>`

                        })
                        $('#vendor_form').attr('vendorId',VendorId);
                        $('#productList tbody').empty().html(productList);
                    }
                }
            });
        }

        function storeVendorProducts(vendorId) {
            if (!vendorId) {
                return;
            }
            let checkedElements = $("#vendorProducts tbody input:checked")

            let payload = {};
            checkedElements.each((index, element) => {
                const row_no = $(element).attr('row_no');
                const product_id = $(element).val();
                const fabric_limit = $(`#${row_no} [name="fabric_limit"]`).val();
                const attribute_limit = Number($(`#${row_no} [name="attribute_limit"]`).val());
               
                payload[index] = {
                    product_id,
                    fabric_limit,
                    attribute_limit
                }
            })
            if (payload != null) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('storeVendorProducts') }}',
                    data: { 'data': JSON.stringify(payload), 'vendorId': vendorId, '_token': '{{ csrf_token() }}' },
                    success: function (data) {
                        swal({
                            title: 'Vendor products updated',
                            type: 'success',
                            showCloseButton: true,
                            confirmButtonClass: 'btn btn-success',
                        }).catch(swal.noop)
                            .then(function () {
                                $('#vendorProducts').modal('hide');
                            });
                    },
                    error: function (error) {
                        console.log(error);
                        swal({
                            title: 'Data Not Saved',
                            type: 'error',
                            showCloseButton: true,
                            confirmButtonClass: 'btn btn-success',
                        })
                    }
                });
            }

        }
        let cacheSubscription = {};
        function showSubscription(vendorId) {
            $('#subscription_modal').modal('show');
            if (!vendorId) {
                return;
            }
            if (cacheSubscription[vendorId]) {
                fillSubscription(vendorId);
            } else {
                $.ajax({
                    type: 'GET',
                    url: '{!! route('getSubscription', 'vendorId') !!}'.replace('vendorId', vendorId),
                    isAsync: true,
                    success: function (data) {
                        if (data) {
                            cacheSubscription[vendorId] = data;
                            fillSubscription(vendorId);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

        }
        function fillSubscription(vendorId) {
            document.getElementById("subscription_form").reset();
            if (cacheSubscription[vendorId]) {
                const { start_date, duration_in_months, fabric_limit, isactive,version,is_trial } = cacheSubscription[vendorId];
                $('#start_date').val(start_date);
                $('[name="duration"]').val(duration_in_months);
                $('[name="fabric_limit"]').val(fabric_limit);
                $("#version").val(version);
                $('#end_date').val(calculateEndDate(start_date, duration_in_months));
                is_trial ? $("#is_trial").attr('checked', 'checked') : $("#is_trial").removeAttr('checked');
                isactive  ? $('#status_drpdwn option[name="active"]').attr('selected', 'selected') : $('#status_drpdwn option[name="inactive"]').attr('selected', 'selected');
                $('#subscription_form').attr('vendorId', vendorId);
            }
        }

        function storeSubscription() {
           debugger;
            const vendorId = $('#subscription_form').attr('vendorId');
            const start_date = $('#start_date').val();
            const duration = $('[name="duration"]').val();
            const fabric_limit = $('[name="fabric_limit"]').val();
            const status = $("#status_drpdwn :selected").val();
            const version = Number($("#version").val());
            const is_trial = $("#is_trial").is(':checked') ? 1 : 0;
            $.ajax({
                type: 'POST',
                url: '{{ route('storeSubscription') }}',
                data: {vendorId,start_date,duration,fabric_limit,status,version,is_trial,'_token': '{{ csrf_token() }}' },
                success: function (data) {
                    cacheSubscription[vendorId] = null;
                    swal({
                        title: 'Subscription updated',
                        type: 'success',
                        showCloseButton: true,
                        confirmButtonClass: 'btn btn-success'
                    }).catch(swal.noop)
                        .then(function () {
                            $('#subscription_modal').modal('hide');
                        });
                },
                error : function(error){
                    console.log(error);
                    swal({
                        title: 'Data Not Saved',
                        type: 'error',
                        showCloseButton: true,
                        confirmButtonClass: 'btn btn-success',
                    })
                }
            });
        }


        let cacheVendorDetails = {};
        function editVendor(vendorId) {
            if (cacheVendorDetails[vendorId]) {
                fillVendorDetails(vendorId);
            } else {
                $.ajax({
                    type: 'GET',
                    url: '{!! route('vendor.edit', 'vendorId') !!}'.replace('vendorId', vendorId),
                    data: { 'vendorId': vendorId },
                    success: function (data) {
                        if (typeof (data) == 'object') {
                            cacheVendorDetails[vendorId] = data;
                            fillVendorDetails(vendorId);
                        }
                    }
                });
            }
        }
            function fillVendorDetails(vendorId) {
                let data = cacheVendorDetails[vendorId];
                document.getElementById("vendor_form").reset();
                if (typeof (data) == 'object') {
                    const { vendor_id, store_name, store_url, users, state, pincode, city, contact_number, address,username } = cacheVendorDetails[vendorId];
                    $('#vendor_store_name').val(store_name);
                    $('#vendor_store_url').val(store_url);
                    let fullName = users[0]?.name?.split(' ') || ['', ''];
                    $('#vendor_first_name').val(fullName[0]);
                    $('#vendor_last_name').val(fullName[1]);
                    $('#vendor_email').val(users[0]?.email);
                    $('#vendor_contact_number').val(contact_number);
                    $('#vendor_city').val(city);
                    $('#vendor_state').val(state);
                    $('#vendor_pincode').val(pincode);
                    $('#vendor_address').val(data.address);
                    $('#vendor_username').val(username);
                    $('#vendor_form').attr("vendorId", vendor_id);
                }

                $("#password").addClass('ignore');
                // $("#vendor_email").attr('readonly', true); //shubham added purpose: for edit vendor
                // $('#vendor_username').val(username);
                $('#vendor_form').attr('isEdit', true);
                $('#modal_form_vertical .modal-title').text('Edit Vendor');
                $('#modal_form_vertical').modal('show');
            }

    </script>
@endsection