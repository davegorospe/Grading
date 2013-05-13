<?php
class Home extends controller {
	
	function Home(){
		parent::Controller();
		$this->load->model('home_model');
		$this->load->model('user_model');
		$this->load->model('admin_model');
		$this->load->helper('check_login');
		$this->load->helper('breadcrumb');
		//$this->load->library('Adodbx');
	}

	//home page
	function index(){
		$data['title']	= 'Grading System';
		$data['main_content'] 	= 'home/index';
		$data['page']		= 'home';
		$this->load->view('home/default/template',$data);
	}

	//user sigup page
	function user_signup($email_sent=''){
		$data['title']		=	'Grading System | User Signup';
		$data['main_content'] 	=	'user/user_signup';
		$data['email_sent'] 	=	$email_sent;
		$data['page']		= 'home';
		$this->load->view('user/default/template',$data);
	}
	
	//user signup form submit
	function user_register(){
		// Random confirmation code 
		$data['fname']	 	= 	$this->input->post('fname');
		$data['lname'] 		= 	$this->input->post('lname');
		$data['uname'] 		= 	$this->input->post('uname');
		$data['email'] 		= 	$this->input->post('email');
		$data['password'] 	= 	md5($this->input->post('password'));
		$data['company'] 	= 	$this->input->post('company');
		$data['phone'] 		= 	$this->input->post('phone');
		
		$result = $this->user_model->user_register_code($this->strip_slashes($data));
		
		$this->session->set_flashdata('alert_message','<div class="alert"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Activation Link Sent!</strong><br/>A confirmation link has been sent to you on <b>'.$data['email'].'</b>. Please follow the link found in the email to Activate your account. Kindly check your junk/spam in case you dont find the email in your inbox.</div>');
		redirect("main/home/user_signup/1");
	
	}
	
	//user confirmation
	function user_confirmation(){
		$code 			= 	$this->input->get('code');
		$data['user'] 		=	$this->user_model->user_confirmation($code);
		$status 		= 	$data['user'];
		if($status){
			$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Account Activated!</strong><br/>Your account has been successfully activated. Please login below to access your account.</div>');
			}else{
			$this->session->set_flashdata('alert_message','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Account Activated!</strong><br/>Incorrect verification link. Please try again or contact System Administrator.</div>');
		}
		redirect("main/home/user_login/");
	}
	
	//user login page
	function user_login(){
		$data['title']		=	'Grading System | User Login';
		$data['main_content'] 	=	'user/user_login';
		$data['page']		= 'home';
		$this->load->view('user/default/template',$data);
	}
	
	//do user login
	function user_dologin(){
		$data['email'] 		= 	$this->input->post('email');
		$data['password'] 	= 	$this->input->post('password');
		$result = $this->user_model->user_dologin($this->strip_slashes($data));
		if($result->RowCount() == 1){
			
			foreach ($result as $row) {
				$user_status 	= $row['status'];
				$user_id 	= $row['user_id'];
				$user_fname 	= $row['first_name'];
				$user_lname 	= $row['last_name'];
				$user_type 	= $row['type_id'];
				$user_email 	= $row['email'];
			}

			if($user_status=='2'){
				$this->session->set_flashdata('alert_message','<div class="alert"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Account Blocked!</strong><br/>Sorry. Your account has been temporarily blocked by administrator.</div>');
				redirect('main/home/user_login',$data);
			}else{
				
				if($user_type=='1'){
					
					$admin_status 	= $row['status'];
					$admin_id 	= $row['user_id'];
					$admin_fname 	= $row['first_name'];
					$admin_lname 	= $row['last_name'];
					$admin_type 	= $row['type_id'];
					$admin_email 	= $row['email'];
				
					$data = array(
						'admin_id' => $admin_id,
						'admin_name' => $admin_fname.' '.$admin_lname,
						'admin_type' => $admin_type,
						'admin_email' => $admin_email,
						'admin_login' => TRUE);
					$this->session->set_userdata($data);
					
					redirect('admin/home/');
				
				}else if($user_type=='2'){
					
					$data = array(
						'user_id' => $user_id,
						'user_name' => $user_fname.' '.$user_lname,
						'user_type' => $user_type,
						'user_email' => $user_email,
						'user_login' => TRUE);
					$this->session->set_userdata($data);
					
					redirect('main/grader/');
					
				}else{
					
					$data = array(
						'user_id' => $user_id,
						'user_name' => $user_fname.' '.$user_lname,
						'user_type' => $user_type,
						'user_email' => $user_email,
						'user_login' => TRUE);
					$this->session->set_userdata($data);
					
					redirect('main/user/');
					
				}
				
			}
			
		}else{		 
			$this->session->set_flashdata('alert_message','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Login Failed!</strong><br/>Invalid email or password. Please try again. Or if you forgot your password, please click <b><a href="forgot_password"> Forgot Password </a></b> to reset it.</div>');
			redirect('main/home/user_login',$data);
		}
	}
	
	//user logout
	function user_dologout(){
		$data = array(
			'user_id' => NULL,
			'user_email' => NULL,
			'user_name' => NULL,
			'user_login' => FALSE);
		$this->session->set_userdata($data);
		$this->session->destroy();
		redirect('main/home/');		
	}
	
	//admin login page
	function admin_login(){
		$data['title']		=	'Grading System | admin Login';
		$data['main_content'] 	=	'admin/admin_login';
		$data['page']		= 'home';
		$this->load->view('admin/default/template',$data);
	}
	
	//do admin login
	function admin_dologin(){
		$data['email'] 		= 	$this->input->post('email');
		$data['password'] 	= 	$this->input->post('password');
		$result = $this->admin_model->admin_dologin($this->strip_slashes($data));
		if($result->RowCount() == 1){
			
			foreach ($result as $row) {
				$admin_status 	= $row['status'];
				$admin_id 	= $row['user_id'];
				$admin_fname 	= $row['first_name'];
				$admin_lname 	= $row['last_name'];
				$admin_type 	= $row['type_id'];
				$admin_email 	= $row['email'];
			}

			if($admin_status=='2'){
				$this->session->set_flashdata('alert_message','<div class="alert"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Account Blocked!</strong><br/>Sorry. Your account has been temporarily blocked by administrator.</div>');
				redirect('admin/home/admin_login',$data);
			}else{
				$data = array(
					'admin_id' => $admin_id,
					'admin_name' => $admin_fname.' '.$admin_lname,
					'admin_type' => $admin_type,
					'admin_email' => $admin_email,
					'admin_login' => TRUE);
				$this->session->set_userdata($data);
			 	
				redirect('admin/home/');
			}
			
		}else{		 
			$this->session->set_flashdata('alert_message','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Login Failed!</strong><br/>Invalid email or password. Please try again. Or if you forgot your password, please click <b><a href="forgot_password"> Forgot Password </a></b> to reset it.</div>');
			redirect('main/home/admin_login',$data);
		}
	}
	
	//admin logout
	function admin_dologout(){
		$data = array(
			'admin_id' => NULL,
			'admin_email' => NULL,
			'admin_name' => NULL,
			'admin_login' => FALSE);
		$this->session->set_userdata($data);
		$this->session->destroy();
		redirect('main/home/');		
	}
	
	//validate password for users
	function password_validation($type=''){
		$action = $this->input->post('action');
		if($action == 'ValidatePassword')
		{
		
			$data['enc_pass']	=	md5($this->input->post('password'));
			$data[''.$type.'id']  	=	$this->session->userdata(''.$type.'_id');
			$model = $type.'_model';
			$data['reset']		=	$this->$model->check_password($data);
			if($data['reset']->RowCount() > 0)
			{
				$result = 'true';
			}
			else
			{
				$result = 'false';
			}
			echo $result;
		}
	}
	
	//home page
	function schedule(){
		$data['title']	= 'Grading System';
		$data['main_content'] 	= 'home/schedule';
		$data['page']		= 'schedule';
		$this->load->view('home/default/template',$data);
	}
	
	//home page
	function faqs(){
		$data['title']	= 'Grading System';
		$data['main_content'] 	= 'home/faqs';
		$data['page']		= 'faqs';
		$this->load->view('home/default/template',$data);
	}
	
	//home page
	function contact(){
		$data['title']	= 'Grading System';
		$data['main_content'] 	= 'home/contact';
		$data['page']		= 'contact';
		$this->load->view('home/default/template',$data);
	}
	
	//user forget password page
	function forgot_password(){
		$data['title']		=	'Grading System | User Forgot Password';
		$data['main_content'] 	=	'user/user_forgot_password';
		$data['page']		= 	'home';
		$this->load->view('user/default/template',$data);
	}
	
	//password reset for users
	function reset_password(){
	
		$email = $this->input->post('email');
		$data['reset']=$this->user_model->reset_password($email);
		$count = $data['reset'];
		if($count == 1){
			$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Password Reset!</strong><br/>Your new password has been emailed to you.</div>');
		}else{
			$this->session->set_flashdata('alert_message','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Password Reset!</strong><br/>Sorry! The email you entered is invalid. Please try again.</div>');
		}
		redirect("main/home/forgot_password");
	}
	
	
	//Sanitize String
	function strip_slashes($input)
	{
		$this->load->helper('string');
		if(is_array($input))
		{
			foreach($input as $k=>$v)
			{
				$input[$k] = quotes_to_entities($v);
			}
		}
		else
		{
			$input = quotes_to_entities($input);
		}
		
		return $input;
	}
	
	

	
}
?>
