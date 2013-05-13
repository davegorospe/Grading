<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Welcome! Lets set up your account</h3>
            </div>
        </div>    
                

<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>main/home/user_register" id="user_signup_form" name="user_signup_form" class="form-horizontal" autocomplete="off" >

    <input id="action" name="action" type="hidden" value="user_signup_form" />

	<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>

<?php //if($email_sent!=1){ ?>
	
     <div class="control-group">
        <label class="control-label">First Name <span class="red">*</span></label>
        <div class="controls">
        	<input id="fname" class="input-xlarge required" name="fname" maxlength="20" type="text" value="" placeholder="First Name" data-type="alphabets" /> 
        </div>
    </div>
    
     <div class="control-group">
        <label class="control-label">Last Name <span class="red">*</span></label>
        <div class="controls">
        	<input id="lname" class="input-xlarge required" name="lname" maxlength="20" type="text" value="" placeholder="Last Name" data-type="alphabets" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Username <span class="red">*</span></label>
        <div class="controls">
        	<input id="uname" class="input-xlarge required" name="uname" type="text" value="" placeholder="Username" data-type="alphabets" />
        </div>
    </div>

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
        <label class="control-label">Confirm Password <span class="red">*</span></label>
        <div class="controls">
        	<input id="cpassword" class="input-xlarge required" name="cpassword" type="password" value="" placeholder="Confirm Password" data-type="password" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Company <span class="red">*</span></label>
        <div class="controls">
        	<input id="company" class="input-xlarge required" name="company" maxlength="20" type="text" value="" placeholder="Company" data-type="notnull" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Phone No <span class="red">*</span></label>
        <div class="controls">
	        <input id="phone" class="input-xlarge required" name="phone" type="text" value="" placeholder="Phone" data-type="phone" />
        </div>
    </div>

    <div class="control-group">
    	<label class="control-label">&nbsp;</label>
        <div class="controls">
	        <button id="btn-save" class="btn btn-info" name="submit" type="submit">Get Started</button>
        </div>
    </div>
    
<?php //} ?>

</form>

 </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->