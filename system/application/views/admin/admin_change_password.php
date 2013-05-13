<script>
$(document).ready(function() {
	
	
	//check current password
	function check_current_pass(current_pass){
		
		var current_pass = current_pass;
		var response;
		
		$.ajax({
			type: 'POST',
			url: base_url+'main/home/password_validation/admin',
			data: 'action=ValidatePassword&password='+current_pass+'&table=prj_user',
			success: function(html) {
				response = html;
				if(response=='false'){
					$('#current_pass').addClass('redbrd');
				}else{
					$('#current_pass').removeClass('redbrd');
				}
				$('#currentpass-status').val(response);
			}
		});
		
	}
	
	
	$('#current_pass').blur(function(){
		check_current_pass($(this).val());
	});
	
	$('#confirm_pass').blur(function(){
		var new_password = $('#new_pass').val();
		var confirm_password = $('#confirm_pass').val();
			if(confirm_password!=new_password){
				$('#confirm_pass').addClass('redbrd');
				$('#confirm-status').val('false');
				return false;
			}else{
				$('#confirm-status').val('true');
				$('#confirm_pass_info').removeClass('redbrd');
			}
	});
	
	$('#new_pass').blur(function(){
		if ($('#new_pass').val() ==""){
			$('#new_pass').addClass('redbrd');;
		}
		else{
			$('#new_pass').removeClass('redbrd');
		}
	});
	
	//validate form before submit
	$('#user_password_form').submit(function(){ 
		var current_pass_status = $('#currentpass-status').val();
		var confirm_pass_status = $('#confirm-status').val();
		var new_pass = $('#new_pass').val();
		var confirm_pass = $('#confirm_pass').val();
		if(current_pass_status=='true' && confirm_pass_status == 'true' && new_pass !='' && confirm_pass!=''){
			return true;
		}else{
			$(".message").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Error!</strong><br/>Please see highlighted fields.</div>').hide().fadeIn('slow');
			//alert('Please enter all required information.');
			return false;
		}
	});
	

	
	
	
	
});
	
</script>

<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Change Password</h3>
            </div>
        </div>
                

<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/home/update_password" id="admin_password_form" name="admin_password_form" class="form-horizontal" autocomplete="off" >

    <input id="action" name="action" type="hidden" value="admin_password_form" />
    <input type="hidden" name="currentpass-status" id="currentpass-status" />
    <input type="hidden" name="confirm-status" id="confirm-status" />
    
	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

    <div class="control-group">
        <label class="control-label">Old Password <span class="red">*</span></label>
        <div class="controls">
        	<input id="current_pass" class="input-xlarge required" name="current_pass" type="password" value="" placeholder="Old Password" data-type="password" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">New Password <span class="red">*</span></label>
        <div class="controls">
        	<input id="new_pass" class="input-xlarge required" name="new_pass" type="password" value="" placeholder="New Password" data-type="password" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Confirm Password <span class="red">*</span></label>
        <div class="controls">
        	<input id="confirm_pass" class="input-xlarge required" name="confirm_pass" type="password" value="" placeholder="Confirm Password" data-type="password" />
        </div>
    </div>

    <div class="control-group">
    	<label class="control-label">&nbsp;</label>
        <div class="controls">
	        <button id="btn-save" class="btn btn-info" name="submit" type="submit">Change Password</button>
        </div>
    </div>

</form>

                </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->