<script>
$(document).ready(function() {
	
	//filter by user type
	$('#programs').change(function() {
		if($(this).val()!='0'){
			window.location = base_url+"admin/home/student_grader_association/" + $(this).val();
		}
	});
	
	
	//pass values to a function after assign button is clicked
	$('.assign').click(function() { //alert($(this).parent().parent('tr').html());
		var uid = $(this).parent().parent('tr').find('#uid').attr('value');
		var sid = $(this).parent().parent('tr').find('#session :selected').attr('value');
		var gid = $(this).parent().parent('tr').find('#grader :selected').attr('value');
		var pid = $(this).parent().parent('tr').find('.pid').attr('value');
		
		//alert(uid + sid + gid + pid);
		
		
		
		if(uid > 0 && sid > 0 && gid > 0 && pid > 0){
			window.location = base_url+"admin/home/map_users/"+uid+"/"+sid+"/"+gid+"/"+pid;
		}else{
			alert('Please Select the options');
		}
	});
	
	
	//association list
	$('.aid').click(function() {
		var ids = $(this).attr('id');
		ids = ids.split(",");
		var uid = ids[0];
		var pid = ids[1];
		//alert(ids + uid + pid); return false;
		
		
		var dataString = 'uid='+uid+'&pid='+pid;
		$.ajax({
			type: "POST",
			url: base_url+"admin/home/association",
			data: dataString,
			cache: false,
			success: function(html){
				//alert(html);
				$('.modal-body').html(html);
			}
		}); // ending ajax
	});

}); //ending document.ready();

</script>


<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Program Association for Student & Grader:</h3>
            </div>
        </div>
        
        
        <div class="control-group">
		<label class="control-label">Please Select a Program:</label>
                <div class="controls">
                        <select name="programs" class="input-xlarge" id="programs">
                        <option value="0">Please Select</option>
                        <?php 
                        foreach ($active_programs as $row) {
                                if($row['program_id']==$program_id){
                                        echo "<option value=".$row['program_id']." selected='selected'>".$row['program_name']."</option>";				
                                }else{
                                        echo "<option value=".$row['program_id'].">".$row['program_name']."</option>";				
                                }
                        }
                        ?>
                        </select>
                </div>
        </div>
        
        	<div class="clearfix"></div>
                
                <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        
        
        <?php if($program_id){ ?>
        
        	<table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>#</th>
                  <th>Student</th>
                  <th style="text-align:center">Session</th>
                  <th style="text-align:center">Grader</th>
                  <th style="text-align:center">Option</th>
                  <th style="text-align:center">Associations</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php 
		
		$enrolled_users = $this->user_model->enrolled_users($program_id);
		if($enrolled_users->RowCount() > 0){ foreach ($enrolled_users as $row) { ?>
                
                <tr id="deactive_user-<?php echo $row['user_id']; ?>">
                        <td><?php echo $row['user_id']; $uid = $row['user_id']; ?> <input type="hidden" value="<?php echo $row['user_id']; ?>" id="uid"/></td>
                        <td><?php echo $row['user_name']; $uname = $row['user_name']; ?></td>
                        <td style="text-align:center">
                                <select name="session" class="input-medium" id="session">
                                	<option value="-1">Please Select</option>
                                        <?php 
                                        foreach ($session as $row) {
						echo "<option value=".$row['session_id'].">".$row['title']."</option>";				
                                        }
                                        ?>
                                </select>
                        </td>
                        <td style="text-align:center">
                                <select name="grader" class="input-medium" id="grader">
                               		<option value="-1">Please Select</option>
                                        <?php 
                                        foreach ($graders as $row) {
						echo "<option value=".$row['user_id'].">".$row['first_name'].' '.$row['last_name']."</option>";				
                                        }
                                        ?>
                                </select>
                        </td>
                        <td style="text-align:center">
                                <button class="btn btn-info assign" name="button" type="button">Assign</button>
                                <input type="hidden" name="pid" class="pid" value="<?php echo $program_id; ?>" />
                        </td>
                        <td style="text-align:center">
                                <a class="btn aid" href="#myModal" role="button" id="<?php echo $uid.",".$program_id; ?>" data-toggle="modal"><i class="icon-align-justify"></i></a>
                        </td>
                </tr>
                
                
                
                
			<?php /*?><?php $association = $this->user_model->association($uid); foreach ($association as $rowa) { ?>              
                
                	<tr style="background-color:#ccc;">
                        <td><?php echo $uid; ?></td>
                        <td><?php echo $uname; ?></td>
                        <td><?php echo $rowa['title']; ?></td>
                        <td colspan="2"><?php echo $rowa['first_name']." ".$rowa['last_name']; ?></td>
	                </tr>
        		
                        <?php } ?><?php */?>
                
                
               <?php } } /*else{ ?>
               
			<tr>
                        	<td colspan="5">No associations at the moment</td>
	                </tr>
               
               <?php }*/ ?>
              </tbody>
            </table>
                
	<?php } ?>

</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->




<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Association List</h3>
        </div>
        <div class="modal-body">


                            
                        
                        

        </div>
        <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
</div>