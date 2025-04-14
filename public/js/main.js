var url = window.location.href;

function setProgress(elem, percent) {
  var
    degrees = percent * 3.6,
    transform = /MSIE 9/.test(navigator.userAgent) ? 'msTransform' : 'transform';
  elem.querySelector('.counter').setAttribute('data-percent', Math.round(percent));
  elem.querySelector('.progressEnd').style[transform] = 'rotate(' + degrees + 'deg)';
  elem.querySelector('.progress').style[transform] = 'rotate(' + degrees + 'deg)';
  if(percent >= 50 && !/(^|\s)fiftyPlus(\s|$)/.test(elem.className))
    elem.className += ' fiftyPlus';
}

elem = document.querySelector('.circlePercent'),
percent = 0;
function animate(percent) {
setProgress(elem, (percent += .25));
//if(percent < 100)
  // animate(percent);
  //setTimeout((animate), 15);
}
var lastURLSegment = url.substr(url.lastIndexOf('/') + 1);

if(lastURLSegment.includes('register') !=true && lastURLSegment.includes('login')!=true)
{
    var swalInit = swal.mixin({
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-light'
    });
}

$(".open-eye").hide();
$(".close-eye").show();

              
			   $('#grid').click(function(event){
          $(this).addClass('active');
          $('#list').removeClass('active');
          if(!document.getElementById('products').hasChildNodes()){
            swalInit({
              title: 'Please Import Fabric First!!!',
              type: 'success',
              showCloseButton: true,
                              timer: 2000
            });
            return;
          }
              event.preventDefault();
             $('#products .item').removeClass('list-group-item');
             $('#products .item').addClass('grid-group-item');
             $('#products.list-group').addClass('grid_layout');
             $('.thumbnail').removeClass('d-flex');
             $('.row.switch_tab').css('display','none');
             $('.description').css('display','none');
             $('.actions').css('display','none');
             });
            $('#list').click(function(event){
             event.preventDefault();
             $(this).addClass('active');
             $('#grid').removeClass('active');
             $('#products .item').addClass('list-group-item');
             $('#products.list-group').removeClass('grid_layout');
             $('.thumbnail').addClass('d-flex');
             $('.row.switch_tab').css('display','flex');
             $('.description').css('display','block');
             $('.actions').css('display','block');
             //product_title_head
           });

               $('#products .item').click(function(event){
                     event.preventDefault();
                     $('#products .item.selected').removeClass('selected');
                     $(this).addClass('selected');

               });
			   $("#products input").hide()//hide input from table
 var indexs=0;
 if(document.getElementById('products').hasChildNodes()){
 // indexs=document.getElementById('products').childNodes.length;
 }
         var imagesPreview = function(input, placeToInsertImagePreview) {
          
          $('#products').empty();
		  
          setTimeout(function() {
			  var indexs=0;
            var ArryIndex=[];
            var fNames="";
          if (input.files&&input.files.length<=10) {
              var filesAmount = input.files.length;
              var fListArray1 = document.getElementById("file").files;
            var fListArray = new Array();
            fListArray=fListArray1;
            var isValidFile=true;
            for (var a = 0; a < fListArray.length; a++) {
              //indexs++;
              if (fListArray[a].name.split('.')[1].toLowerCase() == "jpeg"||fListArray[a].name.split('.')[1].toLowerCase() == "jpg"||fListArray[a].name.split('.')[1].toLowerCase() == "png") {
                var fabricSize = 0;
                fabricSize = fListArray[a].size / 1024;
                if (fabricSize < 2000) {
                  var appendDiv='<div class="item col-xs-12 col-lg-12 grid-group-item  list-group-item">'+
                      '<div class="thumbnail d-flex">'+
                      '<div class="swatch">  '+
                      '<img class="group list-group-image" src="" alt="" id="img_' + indexs + '">'+
                      '</div>'+
                      '<div class="btns d-flex">'+
                      '<div class="caption">'+
                      '<div class="">'+
                      '<h6 class="group inner list-group-item-heading">'+
                      'Fabric Name'+
                      '</h6>'+
                      '<div class="row m-0">'+
                      '<p class="group inner list-group-item-text">                                             '+
                      '<span class="product_title_head" style="">'+fListArray[a].name.split('.')[0]+'</span><input type="text" class="key" value= "'+fListArray[a].name.split('.')[0]+'" style="display: none;">'+
                      '</p>'+
                      '</div>'+
                      '</div>'+
                      '</div>'+
                      '<div class="description" style="display: block;">'+
                      '<div class="">'+
                      '<h6 class="group inner list-group-item-heading">'+
                      'Description'+
                      '</h6>'+
                      '<div class="row m-0">'+
                      '<p class="group inner list-group-item-text">   '+
                      '<span style=""></span><input type="text" class="value" value="" style="display: none;">                         '+
                      '</p>'+
                      '</div>'+
                      '</div>'+
                      '</div>'+
                      '<div class="actions" style="display: block;">'+
                      '<div class="">'+
                      '<div class="d-flex">'+
                      '<button class="EditSave" data-text="Save" data-id="D"><i class="fa fa-edit" aria-hidden="true"></i></button>'+
                      '<button class="Cancel" data-text="Cancel" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i></button>'+
                      '</div>'+
                      '</div>'+
                      '</div>'+
                      '</div>'+
                      '<div class="row switch_tab " style="display: flex;">'+
                      '<div class="col category_sel">'+
                      '<span></span>'+
                      '</div>'+
                      '<div class="col category_sel">'+
                      '<span></span>'+
                      '</div>'+
                      '<div class="col category_sel">'+
                      '<span></span>'+
                      '</div>'+
                      '</div>'+
                      '</div>'+
                      '</div>';    
                      indexs++;  
                      $('#products').append(appendDiv);  
                      const reader = new FileReader();			
                      reader.onload=function(e,val) {
                        // convert image file to base64 string
                        if(!ArryIndex.some(p=>p==indexs))
                        $('#img_' + (this-1)).attr('src', reader.result);
                      }.bind(indexs);				
                      reader.readAsDataURL(fListArray[a]);
                  } 
                  else {   
                    //indexs--;  
                    fNames+=fListArray[a].name +',';
                    swalInit({
                      title: 'File size exceeds the maximum limit of 2 MB. Reduce the file size and try again. !!!!',
                      text:fNames.slice(0, fNames.length - 1),
                      type: 'success',
                      showCloseButton: true,
                      
                    }).then(function (result) {
                      //ArryIndex.push(indexs);
                       // ArryIndex.push(indexs);
                        isValidFile=false;});
                    
                        //ArryIndex.push(indexs); //prerana changes commented
                        //isValidFile=false;
                  }
                //$('#products').append(appendDiv); 
                // const reader = new FileReader();			
                // reader.onload=function(e,val) {
                //   // convert image file to base64 string
                //   $('#img_' + (this-1)).attr('src', reader.result);
                // }.bind(indexs);				
                // reader.readAsDataURL(fListArray[a]);
                } else {     
                isValidFile=false;       
              }
              if(!isValidFile)swalInit({
                title: 'Please Select JPEG and PNG Files Only !!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
              $.unblockUI();
          }
  
      }
      else{
        swalInit({
          title: 'Please Select Less Than 10 Files At Single Time !!!',
          type: 'success',
          showCloseButton: true,
                          timer: 2000
        });
        $.unblockUI();
      }
    },2000);
    }
     
       $('#file').on('change', function() {
        if($('#products').children().length>=10){
          swalInit({
            title: 'More Than 10 Design is Not Supported !!!',
            type: 'success',
            showCloseButton: true,
                            timer: 2000
          });
          }
       else if(this.files.length)
         { 
           loadBlockUI();
          imagesPreview(this, "");
         // $('#file').val('');
        }
      });
 
         $('#AddAll,#AddSingle,#Clear,#fRemove,#fRemoveAll').on('click',function(e){        
      switch(e.currentTarget.innerText){
       case "ADD ALL":
        $('#fPattern').css('border','1px inset rgb(118, 118, 118)');
        $('#fColor').css('border','1px inset rgb(118, 118, 118)');
        if(!$('#fPattern').val()){$('#fPattern').css('border','1px solid red');}
        if(!$('#fColor').val()){$('#fColor').css('border','1px solid red');}
        $('.list-group-item').each(function(index,element){
          $(element).find('.category_sel>span')[0].innerHTML= $('#fColor').val();
          $(element).find('.category_sel>span')[1].innerHTML= $('#fPattern').val();
          $(element).find('.category_sel>span')[2].innerHTML= $('#fBlend').val();
          });
       break;
       case "ADD":
        $('#fPattern').css('border','1px inset rgb(118, 118, 118)');
        $('#fColor').css('border','1px inset rgb(118, 118, 118)');
        if(!$('#fPattern').val()){$('#fPattern').css('border','1px solid red');}
        if(!$('#fColor').val()){$('#fColor').css('border','1px solid red');}
        $('.list-group-item.selected').each(function(index,element){
          $(element).find('.category_sel>span')[0].innerHTML= $('#fColor').val();
          $(element).find('.category_sel>span')[1].innerHTML= $('#fPattern').val();
          $(element).find('.category_sel>span')[2].innerHTML= $('#fBlend').val();
          });
        break;
        case "CLEAR":
          if($('.list-group-item').hasClass('selected')){
            $('.list-group-item.selected').each(function(index,element){
              $(element).find('.category_sel>span')[0].innerHTML= '';
              $(element).find('.category_sel>span')[1].innerHTML= '';
              $(element).find('.category_sel>span')[2].innerHTML= '';
              });
          }
          else{
           $('.list-group-item').each(function(index,element){
            $(element).find('.category_sel>span')[0].innerHTML= '';
            $(element).find('.category_sel>span')[1].innerHTML= '';
            $(element).find('.category_sel>span')[2].innerHTML= '';
            });
          }
          break;
          case "REMOVE":
            if(!document.getElementById('products').hasChildNodes()){
              swalInit({
                title: 'Please Import Fabric First to Remove !!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
            }
            else if($('.list-group-item').hasClass('selected'))
            {
              swal({
                title: 'Are you sure?',
                text: "Do You Want To Remove Selected Fabrics?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
              }).then(function (result) {
                if(result.value){
                $('.list-group-item.selected').remove();
                swalInit({
                title: 'Selected Fabric Removed !!!',
                type: 'success',
                showCloseButton: true,
                timer: 2000
              });
            }
              });  
            }
            else  swalInit({
              title: 'Select Fabric To Remove !!!',
              type: 'success',
              showCloseButton: true,
                              timer: 2000
            });
          break;
          case "REMOVE ALL":
            if(!document.getElementById('products').hasChildNodes()){
              swalInit({
                title: 'Please Import Fabric First to Remove !!!',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
            }else{
              swal({
                title: 'Are you sure?',
                text: "Do You Want To Remove All Fabrics?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
              }).then(function (result) {
                if(result.value){
                  $('#products').empty();
                  $('.list-group-item.selected').remove();
                  swalInit({
                    title: 'All Fabrics Removed !!!',
                    type: 'success',
                    showCloseButton: true,
                                    timer: 2000
                  });
            }
              });  
          }
            break;     
             }       
        });
        
        $(document).on("click",".EditSave",function() {
          var selector = $(this).closest(".thumbnail")
          var id = $(this).data('id');
          var btnText = $(this).text();
          if ($(this).find('i').attr('class') == 'fa fa-edit') {
            // $(this).text('Save');
            $(this).find('i').attr('class','fa fa-check');
            $(this).next("button").show(); //hide
            selector.find("p span").hide() //span hide
            selector.find("p input").show() //show inputs
          } else {
            // $(this).text('Edit');
             $(this).find('i').attr('class','fa fa-edit');
            $(this).next("button").hide();
            selector.find("p span").show()
            selector.find("p input").hide()
        
            //get values from input box which is edited
            var key = selector.find(".key").val();
            var value = selector.find(".value").val();
            if(value.length>500){
              swalInit({
                title: 'Description Should be Bellow 500 Character ',
                type: 'success',
                showCloseButton: true,
                                timer: 2000
              });
              //$(selector.find('input')[1]).attr('value',selector.find(" p:eq(1) span").text());
              $(selector.find('input')[1]).val('');
              return;
            }
            //your ajax call put here to send both value  and id as well
            //put updated values in span again add this inside success fn of ajax call
            selector.find(" p:eq(0) span").text(key);
            selector.find(" p:eq(1) span").text(value);
            $(selector.find('input')[1]).attr('value',value);
          }
        });
          $(document).on("click",".Cancel",function() {
          $(this).hide();
          $(this).prev(".EditSave").find('i').attr('class','fa fa-edit');
          $(this).closest(".thumbnail").find("p span").show();
          $(this).closest(".thumbnail").find("p input")[0].value=$($(this).closest(".thumbnail").find("p input")[0]).attr('value');
          $(this).closest(".thumbnail").find("p input")[1].value=$($(this).closest(".thumbnail").find("p input")[1]).attr('value');
          $(this).closest(".thumbnail").find("p input").hide();
        });
          $(document).on("click","#showHid",function() {
          if ($(this).is(":checked")) {
              $(".password").attr("type", "text");
              $("#password-confirm").attr("type", "text");
              $(".close-eye").hide();
              $(".open-eye").show();
          } else {
              $(".password").attr("type", "password");
              $("#password-confirm").attr("type", "password");
              $(".open-eye").hide();
              $(".close-eye").show();
          }
        });
        $(document).on("click","#products .item",function(event) {
          event.preventDefault();
          if(event.ctrlKey){
            $(this).addClass('selected');
          }else{
          $('#products .item.selected').removeClass('selected');
          $(this).addClass('selected');}
        });
        $('#upload_modal_form_vertical').keyup(function(e){
          if(e.keyCode==27) $('#products .item.selected').removeClass('selected');
          }); 
        function RequestDataForSaveDesign(Listelement) {
          $('#fPattern').css('border','1px inset rgb(118, 118, 118)');
          $('#fColor').css('border','1px inset rgb(118, 118, 118)');
          $('#product_type').css('border','1px inset rgb(118, 118, 118)');
          $('#wear_type').css('border','1px inset rgb(118, 118, 118)');
          var IsMandi=false;
          var RequestArray=[];
          Listelement.each(function(index,element){
            if(!$('#product_type').val()){$('#product_type').css('border','1px solid red'); IsMandi=true;}
            if(!$('#wear_type').val()){$('#wear_type').css('border','1px solid red');IsMandi=true;}
            var RequestData=new Object(); 
           // var PropertyValues=new Array();
              var PropertyValues1=new Object();
            $(element).find('span').each(function(i,e){
             if(i==0||i==2||i==3){
               if($(e).html()==""){
                if(i==3)$('#fPattern').css('border','1px solid red');
                else if(i==2) $('#fColor').css('border','1px solid red');
                else if(i==0) e.style.border='1px solid red';
                 IsMandi=true;
               }else if(i==3)PropertyValues1.DESIGN=$(e).html();
               else if(i==2) PropertyValues1.COLOUR=$(e).html();
               else if(i==0) RequestData.imageName=$(e).html();
             }           
             if(i==4) PropertyValues1.blend=$(e).html();
             if(i==1)RequestData.description=$(e).html();
            });
            RequestData.libraryName=$('#product_type').val();
           RequestData.propertyValues= PropertyValues1;
           RequestArray.push(RequestData);
            RequestData.fabricImage=$(element).find('img').attr('src').split('base64')[1].substring(1);
          });
          if(IsMandi) return false;
           else return RequestArray;      
        }
        
        function CloseUpload(){
          $('#products').empty();
          $('#file').val('');
        }
       
      
         

