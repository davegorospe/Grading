<script type="text/javascript" src="<?php echo base_url();?>system/assets/datetimepicker/js/bootstrap-datetimepicker.min.js" ></script>
<link href="<?php echo base_url();?>system/assets/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

	<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Program Management Console</h3>
            </div>
        </div>
        
        <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        
<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/home/save_program" id="add_program_form" name="add_program_form" class="form-horizontal" autocomplete="off" >

    <input id="action" name="action" type="hidden" value="add_program_form" />
   
    <div class="control-group">
        <label class="control-label">Program Name <span class="red">*</span></label> 
        <div class="controls">
            <input id="pname" class="input-xlarge required" name="pname" maxlength="20" type="text" value="" placeholder="Program Name" data-type="alphabets" /> 
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Description <span class="red">*</span></label>
        <div class="controls">
        	<textarea id="desc" class="input-xlarge required" name="desc" placeholder="Description" /></textarea>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Start Date <span class="red">*</span></label>
        <div class="controls">
        	
		

                  <div id="datetimepicker1" class="input-append">
                    <input data-format="MM-dd-yyyy" type="text" class="date-input required" name="startdate" id="startdate" placeholder="Start Date">
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
                    <input data-format="MM-dd-yyyy" type="text" class="date-input required" name="enddate" id="enddate" placeholder="End Date">
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
        <label class="control-label">No of Sessions <span class="red">*</span></label>
        <div class="controls">
	        <input id="sessions" class="input-xlarge required" name="sessions" type="text" value="" placeholder="No. of Sessions" data-type="numeric" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Program State <span class="red">*</span></label>
        <div class="controls">
	        <select name="state" class="select-input required" id="state">
                	<?php 
			foreach ($states as $row) {
				echo "<option value=".$row['state_id'].">".$row['state_name']."</option>";				
			}
			?>
                </select>
        </div>
    </div>

    <div class="control-group">
    	<label class="control-label">&nbsp;</label>
        <div class="controls">
	        <button id="btn-save" class="btn btn-info" name="submit" type="submit">Save</button>
        </div>
    </div>
    
</form>



             
                
                
                
</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->



