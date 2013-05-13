<?php
class Grader extends controller {
	
	function Grader(){
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
		$data['active_programs']	=	$this->user_model->active_grader_programs();
		$data['previous_programs']	=	$this->user_model->previous_grader_programs();
		$data['active_homework_count']	=	$this->user_model->active_homeworks_count();
		$data['title']			= 	'Grading System';
		$data['page']			= 	'dashboard';
		$data['main_content'] 		= 	'user/grader_index';
		$this->load->view('user/default/template',$data);
	}
	
	//homeworks page
	function homeworks($program=''){
		$data['active_programs']	=	$this->user_model->active_grader_programs();
		$data['active_homeworks']	=	$this->user_model->active_homeworks($program);
		$data['completed_homeworks']	=	$this->user_model->completed_homeworks($program);
		$data['active_homeworks_list']	=	$this->user_model->active_homeworks_list();
		
		$data['title']			= 	'Grading System';
		$data['selected']		=	$program;
		$data['main_content'] 		= 	'user/grader_homeworks';
		$data['page']			= 	'homeworks';
		$this->load->view('user/default/template',$data);
	}
	
	//homeworks detail page
	function homework_detail($program='',$session=''){
		$data['active_programs']	=	$this->user_model->active_grader_programs();
		$data['active_homeworks']	=	$this->user_model->active_homeworks($program,$session);
		$data['completed_homeworks']	=	$this->user_model->completed_homeworks($program,$session);
		$data['active_homeworks_list']	=	$this->user_model->active_homeworks_list();
		
		$data['title']			= 	'Grading System';
		$data['selected']		=	$program;
		$data['main_content'] 		= 	'user/grader_homework_detail';
		$data['page']			= 	'homeworks';
		$this->load->view('user/default/template',$data);
	}
	
	//load session quiz for user with answers for view
	function view_homework($program_id='', $session_id='', $user_id='', $format=''){
		
		if($program_id == "" || $session_id == "" || $user_id=='' || $format == ""){
			redirect('main/grader/homeworks');
		}
		
		$data['session_id']	=	$session_id;
		$data['program_id']	=	$program_id;
		$data['user_id']	=	$user_id;
		$data['session']	=	$this->admin_model->sessions($program_id, $session_id);	
		$data['session_quiz']	=	$this->admin_model->session_quiz($program_id, $session_id);
		$data['question_types']	=	$this->admin_model->question_types();	
		$data['title']		=	'Grading System | View Session Quiz';
		
		if($format=="0" || $format==""){
			$data['main_content'] 	= 	'user/grader_view_session_quiz';
		}else if($format=="1"){
			$data['main_content'] 	= 	'user/grader_view_session_quiz_single';
		}

		$data['page']		= 	'homeworks';
		$this->load->view('user/default/template',$data);
	}
	
	
	//save session quiz filled by user
	function save_homework_feedback(){
		
		$data['pid']	 	= 	$this->input->post('pid');
		$data['sid']	 	= 	$this->input->post('sid');
		$data['qid']	 	= 	$this->input->post('qid');
		$data['uid']	 	= 	$this->input->post('uid');
		$data['aid']	 	= 	$this->input->post('answer_id');
		$data['comment']	= 	$this->input->post('comments');
		$data['grade']		= 	$this->input->post('grade');		
		
		$result = $this->user_model->save_grader_feedback($this->strip_slashes($data));
		$this->session->set_flashdata('alert_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" style="top: 3px;"><i class="icon-remove-sign"></i></button><strong>Feedback Saved!</strong><br/>Your feedback have been successfully saved.</div>');
		redirect("main/grader/homeworks/".$data['pid']);
	
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
