$(document).ready(function(){
    
    //global function to remove any placeholder frn any input fiels while  focusing ;
$('[placeholder]').focus(function(){
    $(this).attr('data-text',$(this).attr('placeholder'));
    $(this).attr('placeholder','');
}).blur(function(){
    $(this).attr('placeholder',$(this).attr('data-text'));
    $(this).attr('data-text','');
					});
//=============================================================================================================================================================
//global function to add asterisk to all important input fieds 

$('input').each(function(){

if ($(this).attr('required')==='required')
	{$(this).after('<i class="fa fa-asterisk" aria-hidden="true"></i>')}
});
    
//=============================================================================================================================================================
//global function to show password and hide it  
    
$('.showpass').click(function(){
	$(this).toggleClass("fa-eye-slash");
	if($(this).prevUntil('.password:frist').attr('type')==='password')
		{$('.password').attr('type','text');
		}else{$('.password').attr('type','password');}
});
    
//=============================================================================================================================================================
//global function to show password and hide it  
$('.confirm').click(function(){
 return confirm('are you sure?');
});
    
//=============================================================================================================================================================
//global function to show toggle any type of data 
$(".togglenext").click(function(){

	$(this).next().fadeToggle(500); 
    $(this).children('i').toggleClass('fa-minus-square-o').toggleClass('fa-plus-square-o');
});

    $(".pglo").click(function(){

	$(this).next('div').fadeToggle(500); 
    $(this).toggleClass('fa-minus').toggleClass('fa-plus'); });
    
  //=============================================================================================================================================================
//calling function to selectbox blugin
 $("select").selectBoxIt({

  // Sets default text to appear for the drop down
  });
 //==========================================function to upload Photos and preview it before upload it ========================================================================
 $(".addone").click(function(){

  // Sets default text to appear for the drop down
    document.getElementById('uploads').click();
  });
       
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#uploads + img').remove();
            $('#uploads').after('<img src="'+e.target.result+'" width="300" height="300"/>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#uploads").change(function () {
    filePreview(this);
});
    
//============================================================ratting function=====================================================================     
$('.typing').keyup(function(){
$(this).data()   
$($(this).data('tag')).text($(this).val())});

$('.tags').keydown(function(event){
    if (event.keyCode == 13 || event.keyCode == 32) {
$(this).val(($(this).val()).concat(','));
        return 109;
    }
});

 });


