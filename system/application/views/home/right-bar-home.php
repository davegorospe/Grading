            
            <div class="row-fluid" style="padding-top:15px">
                <div class="span12">
                	<h4>Follow us</h4>
                    <img src="<?php echo base_url();?>system/assets/images/facebook.png" width="32" height="32" />
                    <img src="<?php echo base_url();?>system/assets/images/twitter.png" width="32" height="32" />
                    <img src="<?php echo base_url();?>system/assets/images/rss.png" width="32" height="32" />
                </div>
            </div>
            
            <?php if(!user_login() && !admin_login()){ ?>
            
            <div class="row-fluid" style="padding-top:15px">
                <div class="span12">
                <h4>Login</h4>
                <form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>main/home/user_dologin" id="user_login_form" name="user_login_form" class="form-horizontal" autocomplete="off" >
                <input id="action" name="action" type="hidden" value="user_login_form" />
                <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
                <table width="100%">
                  <tr>
                    <td>Email</td>
                  </tr>
                  <tr>
                    <td><input id="email" class="required" name="email" type="text" value="" placeholder="Email" data-type="email" /></td>
                  </tr>
                  <tr>
                    <td>Password</td>
                  </tr>
                  <tr>
                    <td><input id="password" class="required" name="password" type="password" value="" placeholder="Password" data-type="password" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><button type="submit" class="btn btn-info">Login</button></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                  	<td><a href="<?php echo base_url(); ?>main/home/forgot_password">Forgot your password?</a></td>
                  </tr>
                  <tr>
                  	<td><a href="<?php echo base_url(); ?>main/home/user_signup">Create an account</a></td>
                  </tr>
                </table>
		</form>
                </div>
            </div>
            
            <?php } ?>