<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <link rel="icon" href="<?php echo base_url();?>system/assets/images/xx.png" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo base_url();?>system/assets/images/xx.png" type="image/x-icon">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url();?>system/assets/css/grading.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo base_url();?>system/assets/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/js/grading.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/bootstrap/js/bootstrap.js"></script>    
        <script type="text/javascript">
        //<![CDATA[
   		base_url = '<?php echo base_url(); ?>';
        //]]>
        </script> 
</head>

<body>
<!-- Header -->
<div id="header">
	
        
         <div class="container footer">
            <ul>
               
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li> |
                <li>
                    <a href="<?php echo base_url(); ?>admin">Dashboard</a>
                </li> |
                <li>
                    <a href="<?php echo base_url(); ?>admin/home/new_program">Add New Program</a>
                </li> |
                <li>
                    <a href="<?php echo base_url(); ?>admin/home/manage_users">Manage Users</a>
                </li> |
                <li>
                    <a href="<?php echo base_url(); ?>admin/home/view_profile">Profile</a>
                </li> 
                <?php if($this->session->userdata('admin_id')){ ?>
                |
                <li>
                    <a href="<?php echo base_url(); ?>main/home/admin_dologout">Logout</a>
                </li>
                <?php } ?>
                
            </ul>
        </div>
        
        
        
</div>
<!-- End Header -->
