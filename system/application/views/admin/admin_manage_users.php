<script>
$(document).ready(function() {

	//Activate Users
	$('.cbs_active').live('click', function() {
					
		var uid = $(this).attr('value');
		
		var dataString = 'action=activate&uid='+uid;
		
			$.ajax({
				type: "POST",
				url: base_url+"admin/home/control_users",
				data: dataString,
				cache: false,
				success: function(html){
					$('#active_user-'+uid).fadeOut('slow'); 
					$(".message").html('<div class="alert"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>User Activated!</strong><br/>Account has been approved.</div>').hide().fadeIn('slow');
				}
		}); // ending ajax
	
	}); //ending active
	
	
	
	//Deactivate Users
	$('.cbs_deactive').live('click', function() {
					
		var uid = $(this).attr('value');
		
		var dataString = 'action=deactivate&uid='+uid;
		
			$.ajax({
				type: "POST",
				url: base_url+"admin/home/control_users",
				data: dataString,
				cache: false,
				success: function(html){
					$('#deactive_user-'+uid).fadeOut('slow'); 
					$(".message").html('<div class="alert"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>User Deactivated!</strong><br/>Account has been deactivated.</div>').hide().fadeIn('slow');
				}
		}); // ending ajax
	
	}); //ending active
	
	
	
	
	//filter by user type
	$('#user_type').change(function() {
		if($(this).val()=='0'){
			window.location = base_url+"admin/home/manage_users/";
		}else{
			window.location = base_url+"admin/home/filter_users/" + $(this).val();
		}
	});

}); //ending document.ready();

</script>

<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>User Management Console</h3>
            </div>
        </div>

	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
    
    
    	<div class="tabbable"> <!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Active Users</a></li>
            <li><a href="#tab2" data-toggle="tab">Pending Users</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
              
            	<div class="control-group">
                <div class="controls">
                        <select name="user_type" class="input" id="user_type">
                        <option value="0">All</option>
                        <?php 
			foreach ($user_types as $row) {
				if($row['type_id']==$selected){
					echo "<option value=".$row['type_id']." selected='selected'>".$row['type_name']."</option>";				
				}else{
					echo "<option value=".$row['type_id'].">".$row['type_name']."</option>";				
				}
			}
			?>
                        
                        </select>
                </div>
            </div>
            
        <table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Role</th>
                  <th style="text-align:center">Deactivate</th>
                </tr>
              </thead>
              <tbody>
              
              
				<?php if($all_users->RowCount() > 0){ foreach ($all_users as $row) { ?>
                        
                        <tr id="deactive_user-<?php echo $row['user_id']; ?>">
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php if($row['type_id'] == '1'){ echo "Admin"; }else if($row['type_id'] == '2'){ echo "Grader"; }else if($row['type_id'] == '3'){ echo "Student"; } ?></td>
                                <td style="text-align:center"><input type="checkbox" name="cbs_deactive[]" value="<?php echo $row['user_id']; ?>" class="cbs_deactive"></td>
                        </tr>
                 
               <?php } }else{ ?>
               		
                        <tr>
                                <td colspan="5">There are no Active users for the moment.</td>
                        </tr>
                        
               <?php } ?>
               
              </tbody>
            </table>
              
            </div>
            <div class="tab-pane" id="tab2">
              
            	<table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Role</th>
                  <th style="text-align:center">Activate</th>
                </tr>
              </thead>
              <tbody>
              
              
				<?php if($pending_users->RowCount() > 0){ foreach ($pending_users as $row) { ?>
                        
                        <tr id="active_user-<?php echo $row['user_id']; ?>">
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php if($row['type_id'] == '1'){ echo "Admin"; }else if($row['type_id'] == '2'){ echo "Grader"; }else if($row['type_id'] == '3'){ echo "Student"; } ?></td>
                                <td style="text-align:center"><input type="checkbox" name="cbs_active[]" value="<?php echo $row['user_id']; ?>" class="cbs_active"></td>
                        </tr>
                 
               <?php } }else{ ?>
               		
                        <tr>
                                <td colspan="5">There are no Pending users for the moment.</td>
                        </tr>
                        
               <?php } ?>
               
              </tbody>
            </table>
              
            </div>
          </div>
        </div>
    
    
		
                
                

</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->