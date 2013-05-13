<script>
$(document).ready(function() {
	
	//filter by user type
	$('#programs').change(function() {
		if($(this).val()!='0'){
			window.location = base_url+"main/grader/homeworks/" + $(this).val();
		}
	});
	
	

}); //ending document.ready();

</script>


<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Homeworks</h3>
            </div>
        </div>
        
        <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

        
        <div class="tabbable"> <!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Need Review</a></li>
            <li><a href="#tab2" data-toggle="tab">Completed</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
            
            
               <table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>Program</th>
                  <th>Homework Title (Session)</th>
                  <th>Student</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php if($active_homeworks_list->RowCount() > 0){ 
		foreach ($active_homeworks_list as $row) { ?>
                        
                        <tr id="active_homeworks-<?php echo $row['program_id']; ?>">
                        	<td><a href="<?php echo base_url(); ?>main/grader/homework_detail/<?php echo $row['program_id']; ?>"><?php echo $row['program_name']; ?></a></td>
                                <td><a href="<?php echo base_url(); ?>main/grader/homework_detail/<?php echo $row['program_id']; ?>/<?php echo $row['session_id']; ?>"><?php echo $row['title']; ?></a></td>
                                <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                        </tr>
                 
               <?php } }else{ ?>
               		
                        <tr>
                                <td colspan="4">There are no homeworks for the moment.</td>
                        </tr>
                        
               <?php } ?>
               
              </tbody>
            </table>
            
            
             
               
            </div>
            <div class="tab-pane" id="tab2">
               
               
               <table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>Program</th>
                  <th>Homework Title (Session)</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php if($completed_homeworks->RowCount() > 0){ 
		foreach ($completed_homeworks as $row) { ?>
                        
                        <tr id="completed_homeworks-<?php echo $row['program_id']; ?>">
                        	<td><?php echo $row['program_name']; ?></td>
                                <td><a href="<?php echo base_url(); ?>main/grader/homeworks/<?php echo $row['program_id']; ?>"><?php echo $row['title']; ?></a></td>
                                <td><?php echo $row['status']; ?></td>
                        </tr>
                 
               <?php } }else{ ?>
               		
                        <tr>
                                <td colspan="4">There are no homeworks for the moment.</td>
                        </tr>
                        
               <?php } ?>
               
              </tbody>
            </table>
            
             </div>
          </div>
        </div>
        
        
        <!--<div class="control-group pull-right">
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
        </div>-->
        
        	<?php /*?><div class="clearfix"></div>
                
                <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        
        	<?php $i=1; foreach ($active_homeworks as $row) { ?>
                
                <div class="form-horizontal border-bottom">
                <legend>Needs Review</legend>
                
        	<div class="control-group">
                <label class="control-label"><strong>Session <?php echo $i; ?>:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['title']; ?></label>
                </div>
            	</div>
                
                <div class="control-group">
                <label class="control-label"><strong>Date:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['start_date']; ?></label>
                </div>
            	</div>
                
                <div class="control-group">
                <label class="control-label"><strong>Due Date:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['end_date']; ?></label>
                </div>
            	</div>
                
                <?php 
			$total_questions = $this->admin_model->total_questions($row['session_id'], $row['program_id']); 
			foreach ($total_questions as $qrow){ $totalq = $qrow['total_questions']; }
		?>
                
                <div class="control-group">
                <label class="control-label"><strong>Total Questions:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $totalq; ?></label>
                </div>
            	</div>
                
                <?php 	$status = '';
			$completed_questions = $this->admin_model->completed_questions($row['session_id'], $row['program_id']); 
			foreach ($completed_questions as $qrow){ $completeq = $qrow['completed_questions']; }
			$homework_status = $this->admin_model->homework_status($row['session_id'], $row['program_id']); 
			foreach ($homework_status as $stat){ $status = $stat['status']; }
		?>
                
                <!--<div class="control-group">
                <label class="control-label"><strong>Completed Questions:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $completeq; ?></label>
                </div>
            	</div>-->
                
                <div class="control-group">
                <label class="control-label"><strong>Status:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $status; ?></label>
                </div>
            	</div>
                
                <!--<div class="control-group">
                <label class="control-label"><strong>Session Feedback:</strong></label>
                <div class="controls">
                <label class="radio">xx</label>
                </div>
            	</div>-->
                
                <div class="control-group">
                <label class="control-label"><strong>Question Display:</strong></label>
                <div class="controls">
		<label class="radio">
                        <input type="radio" name="radios" value="2">All at once
                </label>
                <label class="radio">
                        <input type="radio" name="radios" value="1">One at a time
                </label>
                </div>
           	</div>
        
        <?php if($status!='Completed'){ ?>
            	<div class="control-group">
                        <div class="controls">
                        	<a id="btn-save" class="btn btn-info" name="submit" type="submit" href="<?php echo base_url();?>main/grader/view_homework/<?php echo $row['program_id']; ?>/<?php echo $row['session_id']; ?>/<?php echo $row['user_id']; ?>/review" >Review Homework</a>
                        </div>
           	</div>
        <?php } ?>        
                </div>
                
		<?php $i++; } ?><?php */?>
                
                
                
                
                    
            
                


</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->