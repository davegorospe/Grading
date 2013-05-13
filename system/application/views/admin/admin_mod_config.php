<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Module Configuration Settings</h3>
            </div>
        </div>

<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>main/home/admin_dologin" id="admin_login_form" name="admin_login_form" class="form-horizontal" autocomplete="off" >

    <input id="action" name="action" type="hidden" value="admin_login_form" />

	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

    <div class="control-group">
        <label class="control-label">Client Platinum Supplier Features</label>
        <div class="controls">
        	<label class="checkbox">
                        <input type="checkbox" name="checkboxes" value="">Video
                </label>
                <label class="checkbox">
                        <input type="checkbox" name="checkboxes" value="">Live Chat
                </label>
                <label class="checkbox">
                        <input type="checkbox" name="checkboxes" value="">Email
                </label>
                <label class="checkbox">
                        <input type="checkbox" name="checkboxes" value="">Share Screen
                </label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
        	Students allowed per program: 100
        </div>
    </div>

    <div class="control-group">
    	<label class="control-label">&nbsp;</label>
        <div class="controls">
	        <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Add New Client</a>
                <button id="btn-save" class="btn btn-success" name="submit" type="button">Save Changes</button>
        </div>
    </div>

</form>

                </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->

<!--Add Email Template Dialog-->
	<?php include('admin_add_client.php'); ?>
<!--Add Email Template Dialog-->