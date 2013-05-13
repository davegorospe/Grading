<?php 
foreach ($user as $row) {
	$user_status 	= $row['status'];
	$user_id 	= $row['user_id'];
	$user_fname 	= $row['first_name'];
	$user_lname 	= $row['last_name'];
	$user_type 	= $row['type_id'];
	$user_email 	= $row['email'];
	$user_company 	= $row['company'];
	$user_phone 	= $row['phone'];
	$username 	= $row['user_name'];
	
}
?>

<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Profile Info</h3>
            </div>
        </div>                

<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>main/user/update_profile" id="user_profile_form" name="user_profile_form" class="form-horizontal" autocomplete="off" >

    <input id="action" name="action" type="hidden" value="user_profile_form" />

	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

	
    <div class="control-group">
        <label class="control-label">First Name <span class="red">*</span></label> 
        <div class="controls">
            <input id="fname" class="input-xlarge required" name="fname" maxlength="20" type="text" value="<?php echo $user_fname; ?>" placeholder="First Name" data-type="alphabets" /> 
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Last Name <span class="red">*</span></label> 
        <div class="controls">
            <input id="lname" class="input-xlarge required" name="lname" maxlength="20" type="text" value="<?php echo $user_lname; ?>" placeholder="Last Name" data-type="alphabets" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">E-mail Address<span class="red">*</span></label>
        <div class="controls">
        	<input id="email" class="input-xlarge required" name="email" type="text" value="<?php echo $user_email; ?>" placeholder="Email" data-type="email" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Company <span class="red">*</span></label>
        <div class="controls">
        	<input id="company" class="input-xlarge required" name="company" maxlength="20" type="text" value="<?php echo $user_company;?>" placeholder="Company" data-type="notnull" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Phone No <span class="red">*</span></label>
        <div class="controls">
	        <input id="phone" class="input-xlarge required" name="phone" type="text" value="<?php echo $user_phone;?>" placeholder="Phone" data-type="phone" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">User Name <span class="red">*</span></label>
        <div class="controls">
	        <input id="uname" class="input-xlarge required" name="uname" type="text" value="<?php echo $username; ?>" placeholder="User Name" data-type="alphabets" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Password </label>
        <div class="controls">
        	<a href="<?php echo base_url(); ?>main/user/change_password">Change Password</a>
        </div>
    </div>

    

    <div class="control-group">
    	<label class="control-label">&nbsp;</label>
        <div class="controls">
	        <button id="btn-save" class="btn btn-info" name="submit" type="submit">Update Profile</button>
        </div>
    </div>
    

</form>

            </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->