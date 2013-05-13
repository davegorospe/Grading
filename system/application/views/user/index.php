<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
	<div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>User Dashboard</h3>
            </div>
        </div>          

	
        <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        
        
        
        
        
        
                
            
             <div class="tabbable"> <!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Active Programs</a></li>
            <li><a href="#tab2" data-toggle="tab">Program History</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
            
              
              <table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>Program Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>No of Sessions</th>
                  <th style="text-align:center">Completion Status</th>
                  <th style="text-align:center">Enrollment</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php if($active_programs->RowCount() > 0){ foreach ($active_programs as $row) { $pid = $row['program_id']; ?>
                        
                        <tr id="active_program-<?php echo $row['program_id']; ?>">
                                <td><a href="<?php echo base_url(); ?>main/user/programs/<?php echo $row['program_id']; ?>"><?php echo $row['program_name']; ?></a></td>
                                <td><?php echo $row['start_date']; ?></td>
                                <td><?php echo $row['end_date']; ?></td>
                                <td><?php echo $row['no_sessions']; $sess_count = $row['no_sessions'];
				
				//$sessions_assigned = $this->user_model->active_sessions($row['program_id']);
				//echo $sessions_assigned->RowCount();
				
				?></td>
                                <td style="text-align:center">
				<?php 
					$tquest = $this->user_model->total_question_assigned($row['program_id']);
					foreach ($tquest as $row) {
						$tq = $row['tot_quest'];
					}
					
					$aquest = $this->user_model->total_question_answered($row['program_id']);
					foreach ($aquest as $row) {
						$aq = $row['ans_quest'];
					}
					
					$percentage_completion = ($aq/$tq)*100;
				?>
                                	<div class="progress progress-success progress-striped">
                                          <div class="bar" style="width: <?php echo $percentage_completion; ?>%;"></div>
                                          <?php //echo $percentage_completion."%"; ?>
                                        </div>
                                        
				</td>
                                <td style="text-align:center">
                                
                                <?php 
				
				$enrollment_status = $this->user_model->enrollment_status($pid);
				$ecount = $enrollment_status->RowCount();
				//echo $sessions_assigned->RowCount();
				if($ecount>0){
				?>
                                        <!--<button class="btn btn-info assign" name="button" type="button" disabled="disabled">Enrolled</button>-->
                                        <i class="icon-ok" title="Enrolled"></i>
                                <?php }else{ ?>
                                        <a href="<?php echo base_url(); ?>main/user/program_enroll/<?php echo $pid."/".$sess_count."/".$this->session->userdata('user_id');?>" class="btn btn-info assign" >Get Enrolled</a>
                                <?php } ?>
                                </td>
                        </tr>
                      
                        
                        
                 
               <?php } }else{ ?>
               		
                        <tr>
                                <td colspan="5">There are no Active programs for the moment.</td>
                        </tr>
                        
               <?php } ?>
               
              </tbody>
            </table>
        
        
            
            </div>
            <div class="tab-pane" id="tab2">
              
              <table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>Program Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Final Grade</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php if($previous_programs->RowCount() > 0){ foreach ($previous_programs as $row) { ?>
                        
                        <tr id="previous_program-<?php echo $row['program_id']; ?>">
                                <td><a href="<?php echo base_url(); ?>main/user/program_detail/<?php echo $row['program_id']; ?>"><?php echo $row['program_name']; ?></a></td>
                                <td><?php echo $row['start_date']; ?></td>
                                <td><?php echo $row['end_date']; ?></td>
                                <td><?php echo $row['remarks']; ?></td>
                        </tr>
                 
               <?php } }else{ ?>
               		
                        <tr>
                                <td colspan="4">There are no programs for the moment.</td>
                        </tr>
                        
               <?php } ?>
               
              </tbody>
            </table>
              
              
            </div>
          </div>
        </div>
        
        
        
        
        
        
        

    </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->