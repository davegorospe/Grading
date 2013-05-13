/* ===================================================
 * grading.js v2.0
 * ===================================================
 * Copyright 2013 Grading.
 *
 *
 * This js file is needed by the site to fucntion properly.
 * It coveres and includes most of the common eventhandlers for differnt
 * key elements.
 * ========================================================== */

$(document).ready(function(){
	
	//////////////////////////////////////////////////////////////////////VALIDATION FUNCTIONS////////////////////////////////////////////////////////////////
	
	$("form").live("submit",function(e){ 
		//e.preventDefault();
		//var form_id = $(this).attr("id");
		if(validate_form()){
			//alert('fine');
		}else{
			//alert('wrong'); 
			return false;
		}
		
		
		
	});
	
	//Form validation function
	function validate_form() {
		var valid = true;
		var echeck = '';
		//console.dir(this);
		
		if($('#email').length){
			if(check_valid_email($('#email').attr("value"))){
				/*if(!verify_email()){ 
					valid = false; 
				} */
				valid = true;
				echeck = true;
			}else{
				$('#email').addClass('redbrd');
				valid = false;
				echeck = false;
			}
		}
		
		if($('#cpassword').length){
			if($('#password').attr("value") != $('#cpassword').attr("value")){ 
				$('#cpassword').addClass('redbrd');
				valid = false;
			}
		}
		
		$('form .required').each(function(){
			//alert(this.name);
			if ($(this).val()!=""){ //If text has value
			   	$(this).removeClass('redbrd');
			}else if($(this).val()==""){ //If text is empty     
				show_message('error','Error!','Please see highlighted fields.'); 
				$(this).addClass('redbrd');
				valid = false;
			} 
		});
		
		if(echeck===false){ $('#email').addClass('redbrd'); valid = false; }
		
		//alert(valid);
		return valid;
	}
	
	//Function to display messages
	function show_message(type, heading, message) {
		$(".message").html('<div class="alert alert-'+type+'"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>'+heading+'</strong><br/>'+message+'</div>').hide().fadeIn('slow');
	}
	
	//remove error class on focus
	$('input, select, textarea').focus(function(e) {		
		$(this).removeClass("redbrd");
	});
	
	//verify email address validity & existence
	var verify_email = function(){
		
		var email_input	= $('#email');
		var success 	= true;
		var emailtext	= $('.email-text');
		
		$.ajax({
			type: "POST",
			data: "email="+$(email_input).attr("value"),
			url: base_url+"main/home/verify_email",
			beforeSend: function(){
				$('.email-text').html("Checking Email...");
			},
			success: function(data){
				if(data == "invalid")
				{	
					email_input.addClass('redbrd');
					emailtext.addClass('text-error');
					emailtext.html("Inavlid Email");
					success = false;
				}
				else if(data == "1")
				{
					email_input.addClass('redbrd');
					emailtext.addClass('text-error');
					emailtext.html("Email Already Exists");
					success = false;
				}
				else
				{
					email_input.removeClass('redbrd');
					emailtext.removeClass('text-error');
					emailtext.addClass('text-success');
					emailtext.html("Email Available");
					success = true;
				}
			},
			async: false
		});
		
		return success;
	}
	
	
	// Email Validation Check
	function check_valid_email(str)
	{
		var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;
		if(regex.test(str))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
});