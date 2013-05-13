<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
	<div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Welcome <?php echo $this->session->userdata('admin_name'); ?>!</h3>
            </div>
        </div>          

	<div class="row-fluid" style="padding-top:15px">
            <div class="span12">
                Admin Dashboard
            </div>
        </div>

    </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->