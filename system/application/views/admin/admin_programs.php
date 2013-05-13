<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Program Management Console</h3>
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
                  <th style="text-align:center">Options</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php if($active_programs->RowCount() > 0){ foreach ($active_programs as $row) { ?>
                        
                        <tr id="active_program-<?php echo $row['program_id']; ?>">
                                <td><?php echo $row['program_name']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['start_date'])); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['end_date'])); ?></td>
                                <td><a href="<?php echo base_url(); ?>admin/home/edit_program/<?php echo $row['program_id']; ?>#tab2"><?php echo $row['no_sessions']; ?> Sessions</a></td>
                                <td style="text-align:center"><a href="<?php echo base_url(); ?>admin/home/edit_program/<?php echo $row['program_id']; ?>">Edit</a></td>
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
                  <th>No of Sessions</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php if($previous_programs->RowCount() > 0){ foreach ($previous_programs as $row) { ?>
                        
                        <tr id="previous_program-<?php echo $row['program_id']; ?>">
                                <td><?php echo $row['program_name']; ?></td>
                                <td><?php echo $row['start_date']; ?></td>
                                <td><?php echo $row['end_date']; ?></td>
                                <td><?php echo $row['no_sessions']; ?></td>
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
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->