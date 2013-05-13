<script type="text/javascript" src="<?php echo base_url();?>system/assets/datetimepicker/js/bootstrap-datetimepicker.min.js" ></script>
<link href="<?php echo base_url();?>system/assets/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />


<?php 
foreach ($session as $row) {
	$sid 		= $row['session_id'];
	$title 		= $row['title'];
	$description 	= $row['description'];
	$create_date 	= $row['create_date'];
	$end_date 	= $row['end_date'];
	$submission 	= $row['submissions'];
}

$count = $session_quiz->RowCount();
?>


<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Edit Session</h3>
            </div>
        </div>
        
        <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        
        
<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/home/update_session" id="edit_session_form" name="edit_session_form" class="form-horizontal" autocomplete="off" >

    <input id="action" name="action" type="hidden" value="edit_session_form" />
    <input id="pid" name="pid" type="hidden" value="<?php echo $program_id;?>" />
    <input id="sid" name="sid" type="hidden" value="<?php echo $session_id;?>" />
	
    <div class="control-group">
        <label class="control-label">Title <span class="red">*</span></label> 
        <div class="controls">
            <input id="title" class="input-xlarge required" name="title" maxlength="20" type="text" value="<?php echo $title; ?>" placeholder="Title" data-type="alphabets" /> 
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Description <span class="red">*</span></label>
        <div class="controls">
        	<textarea id="desc" class="input-xlarge required" name="desc" placeholder="Description" /><?php echo $description; ?></textarea>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Support Material</label>
        <div class="controls">
        	<input name="userfile[]" id="userfile[]" class="date-input btn" type="file" value="Upload" multiple="multiple"/>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Session Questions</label>
        <div class="controls">
        	<?php if($count==0){ ?>
        		<a href="<?php echo base_url(); ?>admin/home/create_session_quiz/<?php echo $program_id;?>/<?php echo $session_id;?>" class="btn btn-info">Create Session Quiz</a>
                <?php }else{ ?>
                	<a href="<?php echo base_url(); ?>admin/home/create_session_quiz/<?php echo $program_id;?>/<?php echo $session_id;?>" class="btn btn-info">View Session Quiz</a>
                <?php } ?>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
                <label class="checkbox">
                        <input type="checkbox" name="submission" value="Y" id="submission" <?php if($submission=='Y'){ echo 'checked="checked"'; } ?>>Allow Documents Submission
                </label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Session Start Date <span class="red">*</span></label>
        <div class="controls">
                  <div id="datetimepicker3" class="input-append">
                    <input data-format="yyyy-MM-dd" type="text" class="date-input required" name="sessiondate" id="sessiondate" placeholder="Session Start Date" value="<?php echo $create_date; ?>">
                    <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>
                  </div>
        </div>
                <script type="text/javascript">
                  $(function() {
                    $('#datetimepicker3').datetimepicker({
                      pickTime: false
                    });
                  });
                </script>
    </div>
    
    <div class="control-group">
        <label class="control-label">Session End Date <span class="red">*</span></label>
        <div class="controls">
                  <div id="datetimepicker4" class="input-append">
                    <input data-format="yyyy-MM-dd" type="text" class="date-input required" name="sessionenddate" id="sessionenddate" placeholder="Session End Date" value="<?php echo $end_date; ?>">
                    <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>
                  </div>
        </div>
                <script type="text/javascript">
                  $(function() {
                    $('#datetimepicker4').datetimepicker({
                      pickTime: false
                    });
                  });
                </script>
    </div>

    
    <div class="control-group">
        <label class="control-label">Associated Files:</label>
                <div class="controls">
                    <p>
                                <?php $i = 1; $path = base_url()."uploads/";
                    foreach ($files as $row) { ?>
                        <?php echo "<strong>Session File ".$i.":</strong> <a href='".$path.$row['display_name']."' target='_blank'>".$row['display_name']."</a>"; ?><br />
                    <?php
                       $i++;
                    }
                    ?>
                    </p>
           	 </div>
    </div>
    
    <div class="control-group">
    	<label class="control-label">&nbsp;</label>
        <div class="controls">
	        <button id="btn-save" class="btn btn-info" name="submit" type="submit">Update Session</button>
        </div>
    </div>
    
</form>


</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->