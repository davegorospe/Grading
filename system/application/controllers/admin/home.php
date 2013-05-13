<?php 

class Home extends controller { //class begin Home
	
	function Home(){
		parent::Controller();
		$this->load->model('home_model');
		$this->load->model('user_model');
		$this->load->model('admin_model');
		$this->load->helper('check_login');
		$this->load->helper('breadcrumb');
		
		if(!admin_login()){
			redirect('main/home/admin_login');
		}
	}

	//home page
	function index(){
		$data['title']		= 	'Admin | Grading System';
		$data['main_content'] 	= 	'admin/index';
		$data['page']		=	'dashboard';
		$this->load->view('admin/default/template',$data);
	}
	
	//view admin profile
	function view_profile(){
		$data['title']		=	'Grading System | Admin View Profile';
		$admin_id		=	$this->session->userdata('admin_id');
		$data['admin']		=	$this->admin_model->admin_profile_info($admin_id);
		$data['page']		=	'admin_profile';
		$data['main_content'] 	= 	'admin/admin_profile';
		$this->load->view('admin/default/template',$data);
	}
	
	//update admin profile
	function update_profile(){
		
		$admin_id		=	$this->session->userdata('admin_id');
		$data['uname'] 		= 	$this->input->post('uname');
		$data['fname'] 		= 	$this->input->post('fname');
		$data['email'] 		= 	$this->input->post('email');
		$data['lname'] 		= 	$this->input->post('lname');
		$data['company'] 	= 	$this->input->post('company');
		$data['phone'] 		= 	$this->input->post('phone');
		
		$data['admin_update']	=	$this->admin_model->update_profile($admin_id, $data);
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Success!</strong><br/>Your profile has been updated.</div>');
		redirect('admin/home/view_profile');
		
	}
	
	//change admin password
	function change_password(){
		$data['title']		=	'Grading System | Admin Change Password';
		$data['main_content'] 	= 	'admin/admin_change_password';
		$data['page']		=	'admin_profile';
		$this->load->view('admin/default/template',$data);
	}
	
	//update admin password
	function update_password(){
		$admin_id		=	$this->session->userdata('admin_id');
		$password 		= 	$this->input->post('new_pass');
		$data['password']	=	$this->admin_model->change_password($admin_id, $password);
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Success!</strong><br/>Your password has been updated.</div>');
		redirect("admin/home/view_profile");
	}
	
	//admin manage users
	function manage_users(){
		$data['pending_users']	=	$this->user_model->users_list($status = '0');
		$data['all_users']	=	$this->user_model->users_list($status = '1');	
		$data['user_types']	=	$this->user_model->users_types();
		$data['title']		=	'Grading System | Admin Manage Users';
		$data['main_content'] 	= 	'admin/admin_manage_users';
		$data['page']		=	'users';
		$this->load->view('admin/default/template',$data);
	}
	
	//admin create users page
	function create_users(){
		$data['pending_users']	=	$this->user_model->users_list($status = '0');
		$data['all_users']	=	$this->user_model->users_list($status = '1');	
		$data['user_types']	=	$this->user_model->users_types();
		$data['title']		=	'Grading System | Admin Manage Users';
		$data['main_content'] 	= 	'admin/admin_add_user';
		$data['page']		=	'users';
		$this->load->view('admin/default/template',$data);
	}
	
	//activate and deactivate users
	function control_users()
	{
		$data['action']		=	$this->input->post('action');
		$data['user_id']	=	$this->input->post('uid');
		$this->admin_model->control_users($data);
	}
	
	//admin manage users filter
	function filter_users($type=''){
		$data['pending_users']	=	$this->user_model->users_list($status = '0');
		$data['all_users']	=	$this->user_model->users_filtered_list($type);
		$data['user_types']	=	$this->user_model->users_types();		
		$data['selected']	=	$type;
		$data['title']		=	'Grading System | Admin Manage Users';
		$data['main_content'] 	= 	'admin/admin_manage_users';
		$data['page']		=	'users';
		$this->load->view('admin/default/template',$data);
	}
	
	//add user from admin
	function add_user(){
		$data['fname']	 	= 	$this->input->post('fname');
		$data['lname'] 		= 	$this->input->post('lname');
		$data['email'] 		= 	$this->input->post('email');
		$data['password'] 	= 	md5($this->input->post('password'));
		$data['company'] 	= 	$this->input->post('company');
		$data['phone'] 		= 	$this->input->post('phone');
		$data['uname'] 		= 	$this->input->post('uname');
		$data['user_type'] 	= 	$this->input->post('user_type');
		
		$result = $this->admin_model->add_user($this->strip_slashes($data));
		
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Account Created!</strong><br/>A new account has been successfully created.</div>');
		redirect("admin/home/manage_users");
	
	}
	
	
	//view program
	function view_programs(){
		$data['active_programs']	=	$this->admin_model->active_programs();
		$data['previous_programs']	=	$this->admin_model->previous_programs();
		$data['all_users']		=	$this->user_model->users_list($status = '1');	
		$data['states']			=	$this->admin_model->all_states();	
		$data['title']			=	'Grading System | View Programs';
		$data['main_content'] 		= 	'admin/admin_programs';
		$data['page']			=	'programs';
		$this->load->view('admin/default/template',$data);
	}
	
	//Student & Grader Association program
	function student_grader_association($program_id=''){
		$data['program']		=	$this->admin_model->program($program_id);
		$data['session']		=	$this->admin_model->sessions($program_id);
		$data['active_programs']	=	$this->admin_model->active_programs();
		$data['previous_programs']	=	$this->admin_model->previous_programs();
		//$data['all_users']		=	$this->user_model->users_filtered_list('3');	
		$data['states']			=	$this->admin_model->all_states();	
		$data['graders']		=	$this->user_model->users_filtered_list('2');
		$data['program_id']		=	$program_id;
		$data['title']			=	'Grading System | Student & Grader Association';
		$data['main_content'] 		= 	'admin/admin_user_grader_association';
		$data['page']			=	'programs';
		$this->load->view('admin/default/template',$data);
	}
	
	//add new program
	function new_program(){
		$data['active_programs']	=	$this->admin_model->active_programs();
		$data['previous_programs']	=	$this->admin_model->previous_programs();
		$data['all_users']		=	$this->user_model->users_list($status = '1');	
		$data['states']			=	$this->admin_model->all_states();	
		$data['title']			=	'Grading System | Add New Program';
		$data['main_content'] 		= 	'admin/admin_add_program';
		$data['page']			=	'programs';
		$this->load->view('admin/default/template',$data);
	}
	
	//save program
	function save_program(){
		$data['pname']	 	= 	$this->input->post('pname');
		$data['desc'] 		= 	$this->input->post('desc');
		$data['startdate'] 	= 	$this->input->post('startdate');
		$data['enddate'] 	= 	$this->input->post('enddate');
		$data['sessions'] 	= 	$this->input->post('sessions');
		$data['state'] 		= 	$this->input->post('state');
		
		$result = $this->admin_model->save_program($this->strip_slashes($data));
		
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Program Saved!</strong><br/>A new programs has been successfully saved.</div>');
		redirect("admin/home/view_programs");
	
	}
	
	//edit program
	function edit_program($program_id=''){
		$data['program']	=	$this->admin_model->program($program_id);
		$data['session']	=	$this->admin_model->sessions($program_id);
		$data['all_users']	=	$this->user_model->users_filtered_list('3');	
		$data['active_programs']	=	$this->admin_model->active_programs();
		$data['graders']	=	$this->user_model->users_filtered_list('2');
		$data['program_id']	=	$program_id;
		$data['states']		=	$this->admin_model->all_states();	
		$data['title']		=	'Grading System | Edit Program';
		$data['main_content'] 	= 	'admin/admin_edit_programs';
		$data['page']			=	'programs';
		$this->load->view('admin/default/template',$data);
	}
	
	//update program
	function update_program($program_id=''){
		$data['pid']	 	= 	$this->input->post('pid');
		$data['pname']	 	= 	$this->input->post('pname');
		$data['desc'] 		= 	$this->input->post('desc');
		$data['startdate'] 	= 	$this->input->post('startdate');
		$data['enddate'] 	= 	$this->input->post('enddate');
		$data['state']		= 	$this->input->post('state');
		$data['sessions']	= 	$this->input->post('sessions');
		$result 		= 	$this->admin_model->update_program($this->strip_slashes($data));	
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Program Updated!</strong><br/>Program has been successfully updated.</div>');
		redirect("admin/home/edit_program/".$data['pid']);
	}
	
	//save session
	function save_session(){
		$data['pid']	 	= 	$this->input->post('pid');
		$data['title'] 		= 	$this->input->post('title');
		$data['desc'] 		= 	$this->input->post('desc');
		$data['date'] 		= 	$this->input->post('sessiondate');
		$data['enddate'] 	= 	$this->input->post('sessionenddate');
		$data['submission']	= 	$this->input->post('submission');
		if($data['submission']==''){ $data['submission']='N'; }
		
		$result = $this->admin_model->save_session($this->strip_slashes($data));
		
		$target_path = "uploads/";
		
		if(count($_FILES["userfile"]['name'])>0)
 		{
 
			for($i=0; $i<count($_FILES['userfile']['name']); $i++) {
			
				$target_path = $target_path . basename( $_FILES['userfile']['name'][$i]); 
				if(move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $target_path)) {
				    $data['file_name'] = $_FILES['userfile']['name'][$i];
				    echo "The file ".  basename( $_FILES['userfile']['name'][$i]). " has been uploaded";
				    $this->admin_model->save_session_documents($this->strip_slashes($data), $result, $i);
				} else{
				    echo "There was an error uploading the file, please try again!";
				}
			
			}

		}
		
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Session Saved!</strong><br/>A new session has been successfully saved.</div>');
		redirect("admin/home/edit_program/".$data['pid']."#tab2");
	
	}
	
	//edit session
	function edit_session($program_id='', $session_id=''){
		$data['session_id']	=	$session_id;
		$data['program_id']	=	$program_id;
		$data['session']	=	$this->admin_model->sessions($program_id, $session_id);	
		$data['session_quiz']	=	$this->admin_model->session_quiz($program_id, $session_id);
		$data['files']		=	$this->admin_model->files($program_id, $session_id);	
		$data['title']		=	'Grading System | Edit Session';
		$data['main_content'] 	= 	'admin/admin_edit_session';
		$data['page']		=	'programs';
		$this->load->view('admin/default/template',$data);
	}
	
	//update session
	function update_session(){
		$data['pid']	 	= 	$this->input->post('pid');
		$data['sid']	 	= 	$this->input->post('sid');
		$data['title'] 		= 	$this->input->post('title');
		$data['desc'] 		= 	$this->input->post('desc');
		$data['date'] 		= 	$this->input->post('sessiondate');
		$data['enddate'] 		= 	$this->input->post('sessionenddate');
		$data['submission']	= 	$this->input->post('submission');
		if($data['submission']==''){ $data['submission']='N'; }
		
		$result = $this->admin_model->update_session($this->strip_slashes($data));
		
		$target_path = "uploads/";
		
		if(count($_FILES["userfile"]['name'])>0)
 		{
 
			for($i=0; $i<count($_FILES['userfile']['name']); $i++) {
			
				$target_path = $target_path . basename( $_FILES['userfile']['name'][$i]); 
				if(move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $target_path)) {
				    $data['file_name'] = $_FILES['userfile']['name'][$i];
				    echo "The file ".  basename( $_FILES['userfile']['name'][$i]). " has been uploaded";
				    $this->admin_model->save_session_documents($this->strip_slashes($data), $data['sid'], $i);
				} else{
				    echo "There was an error uploading the file, please try again!";
				}
			
			}

		}
		
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Session Updated!</strong><br/>Session has been successfully updated.</div>');
		redirect("admin/home/edit_session/".$data['pid']."/".$data['sid']);
	
	}
	
	//initiate session quiz
	function create_session_quiz($program_id='', $session_id=''){
		$data['session_id']	=	$session_id;
		$data['program_id']	=	$program_id;
		$data['session']	=	$this->admin_model->sessions($program_id, $session_id);	
		$data['session_quiz']	=	$this->admin_model->session_quiz($program_id, $session_id);
		$data['question_types']	=	$this->admin_model->question_types();	
		$data['title']		=	'Grading System | Create Session Quiz';
		$data['main_content'] 	= 	'admin/admin_create_session_quiz';
		$data['page']		=	'programs';
		$this->load->view('admin/default/template',$data);
	}
	
	//save session quiz form
	function save_session_quiz()
	{
		$data['action']		=	$this->input->post('action');
		$data['session_id']	=	$this->input->post('sid');
		$data['program_id']	=	$this->input->post('pid');
		$data['quiz_id']	=	$this->input->post('quiz_id');
		$data['questions']	=	$this->input->post('question');
		$data['question_types']	=	$this->input->post('qtype');
		$data['qcount']		=	$this->input->post('qcount');
		$data['options']	=	$this->input->post('options');
		$data['files']		=	$_FILES["options"];
		
		$qt = array();
		foreach( $data['questions'] as $k=>$v ) {
		  $qt[$k] = $v;
		  if (isset($data['question_types'][$k]))
		    $qt[$k] .= '|' . $data['question_types'][$k];
		}
		//print_r($qt);
		
		$data['questions']	=	$qt;
		
		//$data['form_html']	=	$this->input->post('form');
		$this->admin_model->save_session_quiz($data);
		
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Quiz Created!</strong><br/>Quiz has been successfully saved.</div>');
		redirect("admin/home/create_session_quiz/".$data['program_id']."/".$data['session_id']);
	}
	
	
	//admin map users
	function map_users($uid='', $sid='', $gid='', $pid=''){
		$data['map_users']	=	$this->user_model->map_users($uid, $sid, $gid, $pid);
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Session & Grader Assigned!</strong><br/>The user has been successfully associated to the program\'s session and grader.</div>');
		redirect("admin/home/student_grader_association/".$pid);
	}
	
	//remove questions
	function remove_question()
	{
		$data['action']		=	$this->input->post('action');
		$data['qid']	=	$this->input->post('qid');
		$data['sid']	=	$this->input->post('sid');
		$data['pid']	=	$this->input->post('pid');
		$data['quiz_id']	=	$this->input->post('quiz_id');
		$this->admin_model->remove_question($data);
	}
	
	//pull associations
	function association()
	{
		$data['uid']	=	$this->input->post('uid');
		$data['pid']	=	$this->input->post('pid');
		
		$association = $this->user_model->association($data); 

	}
	
	//view email templates
	function email_templates(){
		$data['title']			=	'Grading System | Email Templates';
		$data['main_content'] 		= 	'admin/admin_email_templates';
		$data['page']			=	'email_templates';
		$data['templates']		=	$this->admin_model->email_templates($type='');	
		$this->load->view('admin/default/template',$data);
	}
	
	//save email template
	function save_email_template()
	{
		$data['type']		=	$this->input->post('type');
		$data['temp']		=	$this->input->post('temp');
		$data['typename']	=	$this->input->post('typename');
		$this->admin_model->save_email_template($data);
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Template Saved!</strong><br/>Email Template has been successfully saved.</div>');
		redirect("admin/home/email_templates");
	}
	
	//module configuration settings page
	function mod_config(){
		$data['title']			=	'Grading System | Module Configuration Settings';
		$data['main_content'] 		= 	'admin/admin_mod_config';
		$data['page']			=	'config';
		$this->load->view('admin/default/template',$data);
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
	
	

	
	
} //class end Home

?>
