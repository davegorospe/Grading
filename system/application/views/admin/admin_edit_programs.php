<script type="text/javascript" src="<?php echo base_url();?>system/assets/datetimepicker/js/bootstrap-datetimepicker.min.js" ></script>
<link href="<?php echo base_url();?>system/assets/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<script>
$(document).ready(function() {

	//Add new user form
	$('#btn-add-form').live('click', function() {		
		$('#add-form').removeClass('hidden').fadeIn('slow');
	});
	
	$(function () {
		var hash = window.location.hash;
		hash && $('ul.nav a[href="' + hash + '"]').tab('show');
	});
	
	
}); //ending document.ready();
</script>

<?php 
foreach ($program as $row) {
	$pid 		= $row['program_id'];
	$pname 		= $row['program_name'];
	$desc 		= $row['description'];
	$sdate 		= $row['start_date'];
	$edate 		= $row['end_date'];
	$sessions 	= $row['no_sessions'];
	$state 		= $row['state_id'];
}
?>

<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Program Information Page</h3>
            </div>
        </div>


	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

        
        <div class="tabbable"> <!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Program Info</a></li>
            <li><a href="#tab2" data-toggle="tab">Sessions</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
            
            
        
        <form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/home/update_program" id="update_program_form" name="update_program_form" class="form-horizontal" autocomplete="off" >

                <input id="action" name="action" type="hidden" value="update_program_form" />
                <input id="pid" name="pid" type="hidden" value="<?php echo $pid;?>" />
    
            <div class="control-group">
                <label class="control-label">Program Name <span class="red">*</span></label> 
                <div class="controls">
                    <input id="pname" class="input-xlarge required" name="pname" maxlength="20" type="text" value="<?php echo $pname; ?>" placeholder="Program Name" data-type="alphabets" /> 
                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label">Description <span class="red">*</span></label>
                <div class="controls">
                    <textarea id="desc" class="input-xlarge required" name="desc" placeholder="Description" /><?php echo $desc; ?></textarea>
                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label">Start Date <span class="red">*</span></label>
                <div class="controls">
                         
                          <div id="datetimepicker1" class="input-append">
                            <input data-format="yyyy-MM-dd" type="text" class="date-input required" name="startdate" id="startdate" value="<?php echo $sdate; ?>" placeholder="Start Date">
                            <span class="add-on">
                              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                            </span>
                          </div>
                        </div>
                        <script type="text/javascript">
                          $(function() {
                            $('#datetimepicker1').datetimepicker({
                              pickTime: false
                            });
                          });
                        </script>
                
            </div>
        
            <div class="control-group">
                <label class="control-label">End Date <span class="red">*</span></label>
                <div class="controls">
                    
                          <div id="datetimepicker2" class="input-append">
                            <input data-format="yyyy-MM-dd" type="text" class="date-input required" name="enddate" id="enddate" value="<?php echo $edate; ?>" placeholder="End Date">
                            <span class="add-on">
                              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                            </span>
                          </div>
                        </div>
                        <script type="text/javascript">
                          $(function() {
                            $('#datetimepicker2').datetimepicker({
                              pickTime: false
                            });
                          });
                        </script>
                
            </div>
        
            <div class="control-group">
                <label class="control-label">Program State <span class="red">*</span></label>
                <div class="controls">
                    <select name="state" class="select-input required" id="state">
			<?php 
                        foreach ($states as $row) {
                            if($row['state_id']==$state){
                                echo "<option value=".$row['state_id']." selected='selected'>".$row['state_name']."</option>";				
                            }else{
                                echo "<option value=".$row['state_id'].">".$row['state_name']."</option>";				
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">No of Sessions <span class="red">*</span></label>
                <div class="controls">
                    <input id="sessions" class="input-xlarge required" name="sessions" type="text" value="<?php echo $sessions; ?>" placeholder="No. of Sessions" data-type="numeric" />
                </div>
            </div>
            
            
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
	                <button id="btn-add-form" class="btn btn-success" name="button" type="submit">Update Program</button>
                </div>
                </div>
            
            
            
            </form>
            
            </div>
            <div class="tab-pane" id="tab2">
            
           
        <?php //if($session->RowCount() > 0){ ?>
        
        <h3>Program: <?php echo $pname; ?></h3>
        
        <table class="table table-hover">
              <thead>
                <tr style="text-align:center">
                  <th>Session #</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th style="text-align:center;">Session Quiz</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
              
              
		<?php if($session->RowCount() > 0){ $i = 1; foreach ($session as $row) { 
		
		//echo $pid." ".$row['session_id']; exit;
		$session_quiz	=	$this->admin_model->session_quiz($pid, $row['session_id']);
		$count 		= 	$session_quiz->RowCount();
		
		?>
                
                <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td style="text-align:center;">
				<?php if($count==0){ ?>
                                	<a href="<?php echo base_url(); ?>admin/home/create_session_quiz/<?php echo $pid;?>/<?php echo $row['session_id'];?>" class="btn btn-info">Create Session Quiz</a>
                                <?php }else{ ?>
                                        <a href="<?php echo base_url(); ?>admin/home/create_session_quiz/<?php echo $pid;?>/<?php echo $row['session_id'];?>" class="btn btn-success" style="width: 96px;">View Session Quiz</a>
                                <?php } ?>
                        </td>
                        <td><a href="<?php echo base_url(); ?>admin/home/edit_session/<?php echo $pid; ?>/<?php echo $row['session_id']; ?>" class="btn btn-info">Edit</a></td>
                </tr>
                
                       
                
                
               <?php $i++; } }else{ ?>
               
			<tr>
                        	<td colspan="5">No sessions added for this program</td>
	                </tr>
               
               <?php } ?>
              </tbody>
            </table>
            
            
           	<div class="control-group form-horizontal">
                <?php if($sessions > ($i-1)){ ?>
                                <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Add New Session</a>
                        <?php } ?>
                </div>
        
         <?php //} ?>
		
                
                
              
                
                
               
             
              </div>
          </div>
        </div>
                
                
                <!--<div class="hidden" id="add-form">
                
                	 <?php //include('admin_add_session.php'); ?>
                
                </div>-->

		
                
                
                
                </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->
        
        <!--Add Session Dialog-->
        	<?php include('admin_add_session.php'); ?>
        <!--Add Session Dialog-->
         	