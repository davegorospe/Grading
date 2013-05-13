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
	
	//form validation
	$("form").live("submit",function(e){ 

		//e.preventDefault();
		var form_id = $(this).attr("id");
		
		if($('#email').length){
			if(!verify_email(form_id)){
				return false;
			}
		}else{}
		
		if(!validate_form(form_id)){
			$(".message").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error!</strong> Please verify the highlighted fields.</div>').show().fadeIn('fast');
			return false;
		}
	
	});
	
	//Function to display messages
	function show_message(type, heading, message) {
		$(".message").html('<div class="alert alert-'+type+'"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>'+heading+'</strong> '+message+'</div>').hide().fadeIn('fast');
	}
	
	//remove error class on focus
	$('input, select, textarea').focus(function(e) {	 alert('sad');	
		$(this).removeClass("redbrd");
	});
	
	var validate_form = function(form_id){
		var success = true;
		
		$('form .required').each(function(){
			//alert(this.name);
			if ($(this).val()!=""){ //If text has value
			   	$(this).removeClass('redbrd');
			}else if($(this).val()==""){ //If text is empty     
				show_message('error','Error!','Please see highlighted fields.'); 
				$(this).addClass('redbrd');
				success = false;
			} 
		});
		
		$("#" + form_id + " :input:not([type=hidden],[type=submit],[type=button],[type=file])").each(function(){
			if(!validate_field(this)){
				success = false;
			}
		})
    	return success;
	}
	
	var validate_field = function(field){

		var success = true;
		var cg = $(field).parents(".control-group");

		//Check if Required
		if ($(field).attr("required") !== undefined){
		   if (!is_value_set(field)){
				cg.addClass("error");
				success = false;
		   }
		}
	
		if ($(field).data("type") !== undefined){
			if(!validate_type($(field).data("type"),$(field).val())){
				cg.addClass("error");
				success = false;
			}else{
				cg.removeClass("error");
				success = true;	
			}
		}    
		return success;
	}
	
	var is_value_set = function(field){
		switch($(field).attr("type")){
		   case "radio":
			   return $(field).is(":selected") ? true : false;
			   break;
		   case "checkbox":
			   return  $(field).is(":checked");
			   break;
		   default:
			   return $(field).val();
	   }
	}
	
	var verify_email = function(form_id){
		
		var email_input	= $('#email');
		var success 	= true;
		var emailtext	= $('.email-text');
		var cg 			= $(email_input).parents(".control-group");

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
					cg.addClass('error');
					emailtext.addClass('text-error');
					emailtext.html("Inavlid Email");
					success = false;
				}
				else if(data == "1")
				{
					cg.addClass('error');
					emailtext.addClass('text-error');
					emailtext.html("Email Already Exists");
					success = false;
				}
				else
				{
					cg.removeClass('error');
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
	
	
	
	var validate_type = function (type,data){
		var re;
		
		switch (type){
			case "int":
					re = /^\d+$/;
					return re.test(data);
			case "float":
					re = /^\d*(?:\.\d{0,2})?$/;
					return re.test(data);
			case "phone":
					data = data.replace(/[^0-9]/g, '');
					return data.length == 10 ? true : false;
			case "nospace":
					re = /^[A-Za-z0-9]*$/;
					return re.test(data);
			case "notnull":
					re = /([^\s])/;
					return re.test(data);
			case "alphabets":
					re = /^[A-Za-z]{3,20}$/;
					return re.test(data);
			case "password":
					re = /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;
					return re.test(data);
			case "email":
					re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					return re.test(data);
		}
		
		return true;
	}
		
	
	
});