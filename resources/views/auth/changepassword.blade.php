@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header header-elements-inline">
              <h5 class="card-title"><i class="fa fa-user"></i> Change Password</h5>
           </div>
           <legend class="font-weight-semibold"></legend>
                    <div class="card-body">
                        <form class="form-horizontal" id="changepassword" method="POST" autocomplete="off" action="{{ route('changePassword') }}">
                            {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Current Password: <span class="text-danger">*</span></label>
                                    <div class="col-md-9">{{ Form::password('current_password',['class'=>'form-control', 'placeholder'=> 'Current Password']) }}
                                        <div id="validate-current_password" class="validate error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">New Password: <span class="text-danger">*</span></label>
                                    <div class="col-md-9">{{ Form::password('new_password',['class'=>'form-control', 'placeholder'=> 'New Password']) }}
                                        <div id="validate-new_password" class="validate error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Confirm New Password: <span class="text-danger">*</span></label>
                                    <div class="col-md-9">{{ Form::password('new_password_confirmation',['class'=>'form-control', 'placeholder'=> 'Confirm New Password']) }}
                                        <div id="validate-new_password_confirmation" class="validate error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <div class="text-right">
                                    <button type="submit" class="btn btn-primary legitRipple save_button" id="scheme_submit">Submit form <i class="icon-paperplane ml-2"></i>
                                    </button>
                                    </div>

                                </div>
                            </div>
                        </div> 
                        </form>
                    </div>
                </div>
            </div>
@endsection
@section('scripts')
{!!Html::script('js/jquery.form.min.js')!!}
{!!Html::script('js/plugins/forms/validation/validate.min.js')!!}
<script type="text/javascript">
 
$('#changepassword').validate({

ignore: 'input[type=hidden], .select2-search__field',
errorClass: 'validation-invalid-label',
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
else 
{
error.insertAfter(element);
}
},

rules: {
current_password:{
  required:true
},
new_password_confirmation:{
  required:true
},
new_password: {
required: true,
maxlength: 16,
minlength:6
}

},
messages: 
{
current_password:"Enter Current Password",
new_password: 
{
required: 'Enter New Password',
maxlength: 'Enter no more than 16 characters',
minlength:'Enter at least 3 characters'
},
new_password_confirmation:"Enter Confirm Password",
}

});

   $('#changepassword').ajaxForm({
    type : "POST",
    url : "{{route('changePassword')}}",
    data: $(this).closest('form').serialize(),
    beforeSubmit : function()
    {
        $('.save_button').html('<i class="fa fa-spin fa-spinner"></i> Loading...').prop('disabled',true);
        $(".validate").html('');
       /*$('#employee-validate').html('');*/
    },
    error: function(resp)
    {
      try
        {
            var messages = JSON.parse(resp.responseText);
            console.log(messages);
            // $.each( messages['errors'], function( key, value ) {
            //     console.log( key  );
            //     console.log(  value );
            //    $('#validate-'+key).html(value).addClass('errors');
            // });
        }
        catch(e)
        { 
         alert('invalid json');
        }
       $('.save_button').html('<i class="fa fa-lg fa-fw fa-check-circle"></i> Submit form').prop('disabled',false);
    },
    success : function(data)
    {
        $('.save_button').html('<i class="fa fa-lg fa-fw fa-paper-plane"></i> Submit form').prop('disabled',false);
        if(data.message_code)
        {
            swal({
                  title: data.message,
                  type: 'success',
                  showCloseButton: true
              }).catch(swal.noop)
              .then(function() {
                  window.location = "{{route('changePassword')}}";
              });
        }
        else
        { 
             if($.isArray(data.message))
             {
                 $.each( data.message, function( key, value ) {
                    console.log( key  );
                    console.log(  value );
                   $('#validate-'+key).html(value).addClass('validation-invalid-label');
                });
                
             }
             else
             {
                 swal({
                      title: data.message,
                      type: 'error',
                      showCloseButton: true
                  }).catch(swal.noop)
                  .then(function() {

                  });
                
             }

        }


       $('#changepassword')[0].reset();
    },
});

 
</script>
@endsection