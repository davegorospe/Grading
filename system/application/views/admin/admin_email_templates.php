<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Email Templates</h3>
            </div>
        </div>
        
                

	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

	<?php foreach ($templates as $row) { ?>
	<div class="control-group">
                <label class="control-label"><strong><?php echo $row['template_type']; ?> Template</strong></label>
                <div class="controls">
                        <textarea class="input-xxlarge required" rows="9"><?php echo $row['template']; ?></textarea>
                </div>
        </div>
        <?php } ?>
	
        
        <div class="control-group form-horizontal">
		<a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Add New Email Template</a>
        </div>
        
        
        
        
  
              
                
                
                
                
                
                
            
              
          
                
                
                
                
                
                
</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->



<!--Add Email Template Dialog-->
	<?php include('admin_add_email_template.php'); ?>
<!--Add Email Template Dialog-->