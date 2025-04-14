@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header header-elements-inline">
              <h5 class="card-title"><i class="fa fa-user"></i> My Account</h5>
           </div>
           <legend class="font-weight-semibold"></legend>
           @if(Session::get('message'))
			<p style=" background: green; color: #fff;font-size: 16px;padding: 10px;">{{Session::get('message')}}</p>
			@endif
                    <div class="card-body">
                {{ Form::model($vendor, ['route' => array('vendor.update', $vendor->id),'id'=> 'my-account-form', 'method' => 'put']) }}
                    <div class="form-group">
                    	{{ method_field('POST') }} 
                    	<div class="row">
                            <div class="col-md-6">
		                        <label><b>Store Name</b></label>
		                        {{ Form::text('store_name', null, ['id'=>'first_name','class'=>'form-control', 'required'=>'required']) }}
			        				@if ($errors->has('store_name'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('store_name') }}</strong>
							            </span>
							        @endif
                            	
                            </div>
                            <div class="col-md-6">
	                        <label><b>Store URL</b></label>
	                       {{ Form::text('store_url', null, ['id'=>'store_url','class'=>'form-control', 'required'=>'required']) }}
			        				@if ($errors->has('store_url'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('store_url') }}</strong>
							            </span>
							        @endif
                            	
                            </div>
                    </div>
                </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label><b>First Name</b></label>
                                {{ Form::text('first_name', null, ['id'=>'first_name','class'=>'form-control', 'required'=>'required']) }}
			        				@if ($errors->has('first_name'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('first_name') }}</strong>
							            </span>
							        @endif
                            </div>
                            <div class="col-md-6">
                                <label><b>Last name</b></label>
                                {{ Form::text('last_name', null, ['id'=>'last_name','class'=>'form-control', 'required'=>'required']) }}
			        				@if ($errors->has('last_name'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('last_name') }}</strong>
							            </span>
							        @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label><b>Email</b></label>
                                {{ Form::email('email', null, ['id'=>'email','class'=>'form-control', 'required'=>'required','readonly']) }}
			        				@if ($errors->has('email'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('email') }}</strong>
							            </span>
							        @endif
                            </div>
                            <div class="col-md-6">
                                <label><b>Contact Number</b></label>
                                {{ Form::text('contact_number', null, ['id'=>'contact_number', 'class'=>'form-control','required'=>'required']) }}
			        				@if ($errors->has('contact_number'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('contact_number') }}</strong>
							            </span>
							        @endif
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label><b>City</b></label>
                                {{ Form::text('city', null, ['id'=>'city','class'=>'form-control', 'required'=>'required']) }}
			        				@if ($errors->has('city'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('city') }}</strong>
							            </span>
							        @endif
                            </div>
                            <div class="col-md-4">
                                <label><b>State</b></label>
                                {{ Form::text('state', null, ['id'=>'state','class'=>'form-control', 'required'=>'required']) }}
			        				@if ($errors->has('state'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('state') }}</strong>
							            </span>
							        @endif
                            </div>
                            <div class="col-md-4">
                                <label><b>Pincode</b></label>
                                {{ Form::text('pincode', null, ['id'=>'pincode', 'class'=>'form-control','required'=>'required']) }}
			        				@if ($errors->has('pincode'))
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $errors->first('pincode') }}</strong>
							            </span>
							        @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><b>Address</b></label>
                        {!! Form::textarea('address', null, ['class'=>'form-control','placeholder'=>"Enter address",'rows' => 4, 'cols' => 54,]) !!}
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                    </div>

                </form>
            </div>
                </div>
            </div>
@endsection
@section('scripts')
{!!Html::script('js/plugins/forms/validation/validate.min.js')!!}
<script type="text/javascript">
	   /* Vendor form validation and submission */
	$(document).ready(function(){
	    var validator = $('#my-account-form').validate({
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
	       /*  success: function(label) {
	            label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
	        }, */
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
	             store_name: {
	                required:true,
	                minlength: 5
	            },
	            store_url: {
	                required:true,
	                minlength: 5
	            }, 
	            first_name: {
	                required:true,
	                minlength: 3
	            },
	            last_name: {
	                required:true,
	                minlength: 2
	            },
	            email: {
	                required:true,
	                email: true
	            },
	            contact_number: {
	                required:true,
	                digits: true
	            },
	            city: {
	                required:true,
	            },
	            state: {
	                required:true,
	            },
	            pincode: {
	                required:true,
	            },
	            address: {
	                required:true,
	            },
	        },
	        messages: {
	            store_name: {
	                required:'Enter Store Name',
	            }, 
	            store_url: {
	                required:'Enter Store URL',
	            },
	            first_name: {
	                required:'Enter First Name',
	            },
	            last_name: {
	                required:'Enter Last Name',
	            }, 
	            email: {
	                required:'Enter Email ',
	            },
	            contact_number: {
	                required:'Enter Contact Number ',
	            },
	            city: {
	                required:'Enter City',
	            },
	            state: {
	                required:'Enter State',
	            },
	            pincode: {
	                required:'Enter Pincode',
	            },
	            address: {
	                required:'Enter Address',
	            },

	        },
	        submitHandler: function() {
	            $.ajax({
	                type: 'POST',
	                url: '{!! route('vendor.update','null') !!}',
	                data: $('form').serialize(),
	                datatype:'json',
	                success: function (response) {
	                    swalInit({
	                        title: 'Account updated successfully',
	                        type: 'success',
	                        showCloseButton: true
	                    }).catch(swal.noop)
	                    .then(function() {
	                       
	                    });
	                }
	            });
	        }
	    });

	})

</script>

@endsection