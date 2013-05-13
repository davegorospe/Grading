<?php
class User extends controller {
	
	function User(){
		parent::Controller();
		$this->load->model('home_model');
		$this->load->model('user_model');
		$this->load->model('admin_model');
		$this->load->helper('check_login');
		$this->load->helper('breadcrumb');
		
		if(!user_login()){
			redirect('main/home/user_login');
		}
	}

	//home page
	function index(){
		
		
		
		$data['active_programs']	=	$this->user_model->active_programs();
		$data['previous_programs']	=	$this->user_model->previous_programs();
		$data['title']			= 	'Grading System';
		$data['page']			= 	'dashboard';
		$data['main_content'] 		= 	'user/index';
		$this->load->view('user/default/template',$data);
	}
	
	//view user profile
	function view_profile(){
		$data['title']		=	'Grading System | User View Profile';
		$user_id		=	$this->session->userdata('user_id');
		$data['user']		=	$this->user_model->user_profile_info($user_id);
		$data['main_content'] 	= 	'user/user_profile';
		$data['page']			= 	'profile';
		$this->load->view('user/default/template',$data);
	}
	
	//update user profile
	function update_profile(){
		
		$user_id		=	$this->session->userdata('user_id');
		$data['uname'] 		= 	$this->input->post('uname');
		$data['fname'] 		= 	$this->input->post('fname');
		$data['email'] 		= 	$this->input->post('email');
		$data['lname'] 		= 	$this->input->post('lname');
		$data['company'] 	= 	$this->input->post('company');
		$data['phone'] 		= 	$this->input->post('phone');
		
		$data['user_update']	=	$this->user_model->update_profile($user_id, $data);
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Success!</strong><br/>Your profile has been updated.</div>');
		redirect('main/user/view_profile');
		
	}
	
	//change user password
	function change_password(){
		$data['title']		=	'Grading System | User Change Password';
		$data['main_content'] 	= 	'user/user_change_password';
		$data['page']			= 	'profile';
		$this->load->view('user/default/template',$data);
	}
	
	//update user password
	function update_password(){
		$user_id		=	$this->session->userdata('user_id');
		$password 		= 	$this->input->post('new_pass');
		$data['password']	=	$this->user_model->change_password($user_id, $password);
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Success!</strong><br/>Your password has been updated.</div>');
		redirect("main/user/view_profile");
	}
	
	//homeworks page
	function homeworks($program=''){
		//$data['active_programs']	=	$this->user_model->active_programs();
		$data['active_programs']	=	$this->user_model->enrolled_programs();
		$data['active_sessions']	=	$this->user_model->active_sessions($program);
		$data['title']			= 	'Grading System';
		$data['selected']		=	$program;
		$data['main_content'] 		= 	'user/user_homeworks';
		$data['page']			= 	'homeworks';
		$this->load->view('user/default/template',$data);
	}
	
	//load session quiz for user
	function session_quiz($program_id='', $session_id='', $format=''){
		$data['session_id']	=	$session_id;
		$data['program_id']	=	$program_id;	
		$data['session']	=	$this->admin_model->sessions($program_id, $session_id);	
		$data['session_quiz']	=	$this->admin_model->session_quiz($program_id, $session_id);
		$data['question_types']	=	$this->admin_model->question_types();	
		$data['title']		=	'Grading System | Begin Session Quiz';
		
		if($format=="0" || $format==""){
			$data['main_content'] 	= 	'user/user_session_quiz';
		}else if($format=="1"){
			$data['main_content'] 	= 	'user/user_session_quiz_single';
		}
		$data['page']			= 	'homeworks';
		$this->load->view('user/default/template',$data);
	}
	
	//save session quiz filled by user
	function save_session_quiz(){
		
		$data['pid']	 	= 	$this->input->post('pid');
		$data['sid']	 	= 	$this->input->post('sid');
		$data['qid']	 	= 	$this->input->post('qid');
		$data['tid']	 	= 	$this->input->post('tid');
		$data['question_id']	= 	$this->input->post('question_id');
		$data['answer']	 	= 	$this->input->post('question');
		
		$result = $this->user_model->save_session_quiz($this->strip_slashes($data));
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Quiz Saved!</strong><br/>Your answers have been successfully saved.</div>');
		redirect("main/user/homeworks/".$data['pid']);
	
	}
	
	//load session quiz for user with answers for view
	function view_session_quiz($program_id='', $session_id='', $format=''){
		if($program_id == "" || $session_id == "" || $format == ""){
			redirect('main/user/homeworks');
		}
		$data['session_id']	=	$session_id;
		$data['program_id']	=	$program_id;
		$data['session']	=	$this->admin_model->sessions($program_id, $session_id);	
		$data['session_quiz']	=	$this->admin_model->session_quiz($program_id, $session_id);
		$data['question_types']	=	$this->admin_model->question_types();	
		$data['exam_status']	=	$this->user_model->exam_status($program_id, $session_id);	
		$data['title']		=	'Grading System | View Session Quiz';
		
		
		if($format=="0" || $format==""){
			$data['main_content'] 	= 	'user/user_view_session_quiz';
		}else if($format=="1"){
			$data['main_content'] 	= 	'user/user_view_session_quiz_single';
		}
		
		$data['page']			= 	'homeworks';
		$this->load->view('user/default/template',$data);
	}
	
	//load session quiz for user with answers to resume
	function continue_session_quiz($program_id='', $session_id=''){
		$data['session_id']	=	$session_id;
		$data['program_id']	=	$program_id;
		$data['session']	=	$this->admin_model->sessions($program_id, $session_id);	
		$data['session_quiz']	=	$this->admin_model->session_quiz($program_id, $session_id);
		$data['question_types']	=	$this->admin_model->question_types();	
		$data['title']		=	'Grading System | Resume Session Quiz';
		$data['main_content'] 	= 	'user/user_resume_session_quiz';
		$data['page']			= 	'homeworks';
		$this->load->view('user/default/template',$data);
	}
	
	//update session quiz filled by user
	function update_session_quiz(){
		
		$data['pid']	 	= 	$this->input->post('pid');
		$data['sid']	 	= 	$this->input->post('sid');
		$data['qid']	 	= 	$this->input->post('qid');
		$data['tid']	 	= 	$this->input->post('tid');
		$data['aqid'] 		= 	$this->input->post('aqid');
		$data['answer']	 	= 	$this->input->post('question');
		
		$result = $this->user_model->update_session_quiz($this->strip_slashes($data));
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Quiz Submitted!</strong><br/>Your answers have been successfully submitted.</div>');
		redirect("main/user/homeworks/".$data['pid']);
	
	}
	
	//submit session quiz filled by user to grader
	function submit_homework($program_id='', $session_id='', $user_id='', $grader_id=''){
		
		$data['pid']	 	= 	$program_id;
		$data['sid']	 	= 	$session_id;
		$data['uid']	 	= 	$user_id;
		$data['gid']	 	= 	$grader_id;
		
		$result = $this->user_model->submit_homework($this->strip_slashes($data));
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Homework Submitted!</strong><br/>Your homework has been submitted to grader for verification.</div>');
		redirect("main/user/homeworks/".$data['pid']);
	
	}
	
	//programs page
	function programs($program=''){
		$data['active_programs']	=	$this->user_model->active_programs();
		$data['active_sessions']	=	$this->user_model->active_sessions($program);
		$data['title']			= 	'Grading System';
		$data['selected']		=	$program;
		$data['main_content'] 		= 	'user/user_programs';
		$data['page']			= 	'programs';
		$this->load->view('user/default/template',$data);
	}
	
	//user enroll to a program
	function program_enroll($pid='', $scount='', $uid=''){
		$data['program_enroll']	=	$this->user_model->enroll_users($pid, $scount, $uid);
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Enrollment Done!</strong><br/>You have been successfully enrolled to this program.</div>');
		redirect("main/user/");
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
