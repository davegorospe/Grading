<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url();?>system/assets/images/xx.png" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo base_url();?>system/assets/images/xx.png" type="image/x-icon">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="<?php echo base_url();?>system/assets/css/style.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo base_url();?>system/assets/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/bootstrap/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/bootstrap/js/bootstrap.js"></script>    
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/bootstrap/js/bootstrap-tooltip.js"></script>  
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/js/grading.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>system/assets/slicebox/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>system/assets/slicebox/css/slicebox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>system/assets/slicebox/css/custom.css" />
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/slicebox/js/modernizr.custom.46884.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>system/assets/slicebox/js/jquery.slicebox.js"></script>
	<script type="text/javascript">
                $(function() {

                        var Page = (function() {

                                var $navArrows = $( '#nav-arrows' ).hide(),
                                        $navDots = $( '#nav-dots' ).hide(),
                                        $nav = $navDots.children( 'span' ),
                                        $shadow = $( '#shadow' ).hide(),
                                        slicebox = $( '#sb-slider' ).slicebox( {
                                                onReady : function() {

                                                        $navArrows.show();
                                                        $navDots.show();
                                                        $shadow.show();

                                                },
                                                onBeforeChange : function( pos ) {

                                                        $nav.removeClass( 'nav-dot-current' );
                                                        $nav.eq( pos ).addClass( 'nav-dot-current' );

                                                }
                                        } ),
                                        
                                        init = function() {

                                                initEvents();
                                                
                                        },
                                        initEvents = function() {

                                                // add navigation events
                                                $navArrows.children( ':first' ).on( 'click', function() {

                                                        slicebox.next();
                                                        return false;

                                                } );

                                                $navArrows.children( ':last' ).on( 'click', function() {
                                                        
                                                        slicebox.previous();
                                                        return false;

                                                } );

                                                $nav.each( function( i ) {
                                                
                                                        $( this ).on( 'click', function( event ) {
                                                                
                                                                var $dot = $( this );
                                                                
                                                                if( !slicebox.isActive() ) {

                                                                        $nav.removeClass( 'nav-dot-current' );
                                                                        $dot.addClass( 'nav-dot-current' );
                                                                
                                                                }
                                                                
                                                                slicebox.jump( i + 1 );
                                                                return false;
                                                        
                                                        } );
                                                        
                                                } );

                                        };

                                        return { init : init };

                        })();

                        Page.init();

                });
        </script>
        
        <script type="text/javascript">
        //<![CDATA[
                base_url = '<?php echo base_url(); ?>';
        //]]>
        </script> 
</head>

<body>

<div class="container" style="width:900px;"> <!--main container start-->
	
    <!--header start-->

	<div class="row-fluid">
		<div class="span12 logo">
			<!--Body content-->
            	<img src="<?php echo base_url();?>system/assets/images/logo.png" alt="logo"/>
		</div>
	</div>
    <div class="row-fluid">
		<div class="span12">
            <!--menu start-->
            <div class="navbar">
                    <div class="navbar-inner">                
                            	<?php $active = 'active'; ?>
				<?php if(user_login()){ ?>
                            	<ul class="nav">    
                                    <!--<li class="<?php if($page == 'home'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>">Home</a></li>-->
                                    <?php if($this->session->userdata('user_type') == '3'){ ?>
                                    <li class="<?php if($page == 'dashboard'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/user">Dashboard</a></li>
                                    <li class="<?php if($page == 'programs'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/user/programs">Program Information</a></li>
                                    <li class="<?php if($page == 'homeworks'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/user/homeworks">Homeworks</a></li>
                                    <?php }else{ ?>
                                    <li class="<?php if($page == 'dashboard'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/grader">Dashboard</a></li>
                                    <li class="<?php if($page == 'homeworks'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/grader/homeworks">Verify Homeworks</a></li>
                                    <?php } ?>
                                    
                                </ul>
                                <ul class="nav pull-right">                               
                                    <li class="dropdown <?php if($page == 'profile'){ echo $active; } ?>">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('user_name'); ?> <b class="caret"></b></a>
                                      <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url(); ?>main/user/view_profile">Profile</a></li>
                                        <li><a href="<?php echo base_url(); ?>main/user/change_password">Change Password</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo base_url(); ?>main/home/user_dologout">Logout</a></li>
                                      </ul>
                                    </li>
                                </ul>
				<?php }else if(admin_login()){ ?>
                                <ul class="nav">
                                    <!--<li class="<?php if($page == 'home'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>">Home</a></li>-->
                                    <li class="<?php if($page == 'dashboard'){ echo $active; } ?>" ><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                                    <li class="dropdown <?php if($page == 'programs'){ echo $active; } ?>">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Programs <b class="caret"></b></a>
                                      <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url(); ?>admin/home/view_programs">View Programs</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/home/new_program">Add New Programs</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo base_url(); ?>admin/home/student_grader_association">Student & Grader Association</a></li>
                                      </ul>
                                    </li>
                                    <li class="dropdown <?php if($page == 'users'){ echo $active; } ?>">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
                                      <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url(); ?>admin/home/manage_users">Manage Users</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/home/create_users">Add New Users</a></li>
                                      </ul>
                                    </li>
                                    <li class="dropdown <?php if($page == 'email_templates' || $page == 'config'){ echo $active; } ?>">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
                                      <ul class="dropdown-menu pull-right">
                                        <li class="<?php if($page == 'email_templates'){ echo $active; } ?>" ><a href="<?php echo base_url(); ?>admin/home/email_templates">Email Templates</a></li>
                                        <li class="<?php if($page == 'config'){ echo $active; } ?>" ><a href="<?php echo base_url(); ?>admin/home/mod_config">Module Configuration</a></li>
                                      </ul>
                                    </li>
                                    
                                    
                                </ul>
				<ul class="nav pull-right">                               
                                    <li class="dropdown <?php if($page == 'admin_profile'){ echo $active; } ?>">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('admin_name'); ?> <b class="caret"></b></a>
                                      <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url(); ?>admin/home/view_profile">Profile</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/home/change_password">Change Password</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo base_url(); ?>main/home/admin_dologout">Logout</a></li>
                                      </ul>
                                    </li>
                                </ul>
                            	<?php }else{ ?>
                            	<ul class="nav">
                                    <li class="<?php if($page == 'home'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="<?php if($page == 'schedule'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/home/schedule">Schedule</a></li>
                                    <li class="<?php if($page == 'faqs'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/home/faqs">FAQs</a></li>
                                    <li class="<?php if($page == 'contact'){ echo $active; } ?>"><a href="<?php echo base_url(); ?>main/home/contact">Contact</a></li>
                                </ul>
                            	<?php } ?>
                            
                    </div>
            </div>
            <!--menu end-->
		</div>
	</div>
    <div class="row-fluid">
		<div class="span12">
			<!--slider content start-->
            <div class="wrapper">

				<ul id="sb-slider" class="sb-slider">
					<li>
						<a href="#" target="_blank"><img src="<?php echo base_url();?>system/assets/slicebox/images/slider/1.jpg" alt="image1"/></a>
						<div class="sb-description">
							<h3>Platinum Supplier Program</h3>
						</div>
					</li>
					<li>
						<a href="#" target="_blank"><img src="<?php echo base_url();?>system/assets/slicebox/images/slider/2.jpg" alt="image2"/></a>
						<div class="sb-description">
							<h3>Platinum Supplier Program</h3>
						</div>
					</li>
					<li>
						<a href="#" target="_blank"><img src="<?php echo base_url();?>system/assets/slicebox/images/slider/3.jpg" alt="image1"/></a>
						<div class="sb-description">
							<h3>Platinum Supplier Program</h3>
						</div>
					</li>
					
				</ul>

				<div id="shadow" class="shadow"></div>

				<div id="nav-arrows" class="nav-arrows">
					<a href="#">Next</a>
					<a href="#">Previous</a>
				</div>

				<div id="nav-dots" class="nav-dots">
					<span class="nav-dot-current"></span>
					<span></span>
					<span></span>
				</div>

			</div><!-- /wrapper -->
            <!--slider content end-->
		</div>
                
                
	</div>
    <?php echo set_breadcrumb(); ?>
    <!--<div class="row-fluid">
    	<div class="span12"><hr /></div>
    </div>-->
    
    <!--header end-->