<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Admin Login</h3>
            </div>
        </div>

<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>main/home/admin_dologin" id="admin_login_form" name="admin_login_form" class="form-horizontal" autocomplete="off" >

    <input id="action" name="action" type="hidden" value="admin_login_form" />

	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

    <div class="control-group">
        <label class="control-label">E-mail <span class="red">*</span></label>
        <div class="controls">
        	<input id="email" class="input-xlarge required" name="email" type="text" value="" placeholder="Email" data-type="email" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Password <span class="red">*</span></label>
        <div class="controls">
        	<input id="password" class="input-xlarge required" name="password" type="password" value="" placeholder="Password" data-type="password" />
        </div>
    </div>

    <div class="control-group">
    	<label class="control-label">&nbsp;</label>
        <div class="controls">
	        <button id="btn-save" class="btn btn-info" name="submit" type="submit">Login</button>
        </div>
    </div>

</form>

                </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->