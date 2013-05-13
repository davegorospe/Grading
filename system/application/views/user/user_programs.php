<script>
$(document).ready(function() {
	
	//filter by user type
	$('#programs').change(function() {
		if($(this).val()!='0'){
			window.location = base_url+"main/user/programs/" + $(this).val();
		}
	});

}); //ending document.ready();

</script>



<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Program Information</h3>
            </div>
        </div>
        
        
        <div class="control-group">
		<label class="control-label">Please Select a Program:</label>
                <div class="controls">
                        <select name="programs" class="input-xlarge" id="programs">
                        <option value="0">Please Select</option>
                        <?php 
                        foreach ($active_programs as $row) {
                                if($row['program_id']==$selected){
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
                
                <div class="form-horizontal">
        
        	<?php $i=1; foreach ($active_sessions as $row) { ?>
                
                
                
        	<div class="control-group session-box">
                <label class="control-label"><strong>Session <?php echo $i; ?>:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['title']; ?></label>
                </div>
            	
                
                <label class="control-label"><strong>Date:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['start_date']; ?></label>
                </div>
            	</div>
               
        
            	
                
                
                
		<?php $i++; } ?>
                
		</div>

</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->