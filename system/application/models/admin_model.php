<?php

class Admin_model extends model {

	//Constructor
	function Admin_model(){
		parent::Model();
		$this->load->library('Adodbx'); //Load Adodb Library
		$this->load->library('email'); // Load Email Library
		//$this->adodb->debug = true;
	}

	//register a new user from admin
	function add_user($data){
	
		$base_url = base_url();
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$sql = "INSERT INTO `prj_user` (`first_name`, `last_name`, `email`, `company`, `phone`, `create_date`, `create_ip`, `updt_date`, `updt_ip`, `type_id`, `password`, `create_by`, `status`, `user_name`, `verify_code`) VALUES ('".$data['fname']."', '".$data['lname']."', '".$data['email']."', '".$data['company']."', '".$data['phone']."', '".$date."', '".$ip."', '".$date."', '".$ip."', '".$data['user_type']."', '".$data['password']."', '".$this->session->userdata('admin_id')."', '0', '".$data['uname']."', '')";
		$result = $this->adodb->Execute($sql);
		return $result;	
	}
	
	
	//login admin and generate sessions
	function admin_dologin($data) {
		$sql = "SELECT * FROM prj_user where email = '".$data['email']."' and password = '".md5($data['password'])."' and type_id = '1'";
		$result = $this->adodb->Execute($sql);
		return $result;
		/*$data = $this->adodb->GetAll($sql);
		if (count($data) != 0 ) { return $data; } else { $data = array(); }*/
	}
	
	//select current logged in admin
	function admin_profile_info($admin_id){
		$sql="SELECT * FROM prj_user WHERE user_id = '".$admin_id."'";
		$result = $this->adodb->Execute($sql);
		return $result;	
	}
	
	//update admin profile
	function update_profile($admin_id, $data) {
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "UPDATE prj_user SET user_name = '".$data['uname']."', first_name = '".$data['fname']."', last_name = '".$data['lname']."', email = '".$data['email']."', company = '".$data['company']."', phone = '".$data['phone']."', updt_date = '".$date."', updt_ip = '".$ip."' WHERE user_id = '".$admin_id."'";
		$result = $this->adodb->Execute($sql);
		return $result;
	}
	
	//check admin password
	function check_password($data)
	{
		$sql = "select password from prj_user where user_id = '".$data['adminid']."' and password = '".$data['enc_pass']."'";
		$result = $this->adodb->Execute($sql);
		return $result;
	}
	
	//update admin password
	function change_password($admin_id, $password)
	{	
		$enc_pass 	=	md5($password);
		$sql		=	"UPDATE prj_user SET password ='".$enc_pass."' WHERE user_id = '".$admin_id."'";
		$result		=	$this->adodb->Execute($sql);
		return $result;
	}
	
	//update users status
	function control_users($data)
	{	
		if($data['action']=='activate'){ $status = 1; }else if($data['action']=='deactivate'){ $status = 2; }
		$sql		=	"UPDATE prj_user SET status ='".$status."' WHERE user_id = '".$data['user_id']."'";
		$result		=	$this->adodb->Execute($sql);
		return $result;
	}
	
	//get all active programs
	function active_programs()
	{
		$date 		= date('Y-m-d');
		//$sql 		= "select * from prj_program where '".$date."' >= start_date and '".$date."' <= end_date";
		$sql 		= "select * from prj_program";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all previous_programs
	function previous_programs()
	{
		$date 		= date('Y-m-d');
		$sql 		= "select * from prj_program where '".$date."' > end_date";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all states
	function all_states()
	{
		$sql 		= "select * from prj_state";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//save new program
	function save_program($data){
	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$data['startdate'] = date('Y-m-d', strtotime($data['startdate'])); 
		$data['enddate'] = date('Y-m-d', strtotime($data['enddate'])); 
		
		
		$sql = "INSERT INTO `grading`.`prj_program` (`program_name`, `description`, `start_date`, `end_date`, `no_sessions`, `state_id`, `create_by`, `create_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`) VALUES ('".$data['pname']."', '".$data['desc']."', '".$data['startdate']."', '".$data['enddate']."', '".$data['sessions']."', '".$data['state']."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."')";

		$result = $this->adodb->Execute($sql);
		return $result;	
	}
	
	//update progaram
	function update_program($data){
	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$sql = "UPDATE  `grading`.`prj_program` SET  `program_name` =  '".$data['pname']."', `description` =  '".$data['desc']."', `start_date` =  '".$data['startdate']."', `end_date` = '".$data['enddate']."', no_sessions = '".$data['sessions']."', state_id = '".$data['state']."', `updt_by` = '".$this->session->userdata('admin_id')."', `updt_date` = '".$date."', `updt_ip` = '".$ip."' WHERE  `prj_program`.`program_id` = '".$data['pid']."'";
		
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	//get program to edit
	function program($pid='')
	{
		$sql 		= "select * from prj_program where program_id = '".$pid."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get sessions for a program
	function sessions($pid='', $sid='')
	{
		if($sid!=""){ $clause = "and session_id = '".$sid."'"; }else{ $clause=""; }
		$sql 		= "select * from prj_session where program_id = '".$pid."' ".$clause."";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//save new session
	function save_session($data){
	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$data['date'] = date('Y-m-d', strtotime($data['date'])); 
		$data['enddate'] = date('Y-m-d', strtotime($data['enddate'])); 
		
		$sql = "INSERT INTO `grading`.`prj_session` (`program_id`, `title`, `description`, `submissions`, `create_by`, `create_date`, `end_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`) VALUES ('".$data['pid']."', '".$data['title']."', '".$data['desc']."', '".$data['submission']."', '".$this->session->userdata('admin_id')."', '".$data['date']."', '".$data['enddate']."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."')";
		
		$result = $this->adodb->Execute($sql);
		
		return $this->adodb->Insert_ID();
	}
	
	//update session
	function update_session($data){
	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		
		$sql = "UPDATE  `grading`.`prj_session` SET  `title` =  '".$data['title']."', `description` =  '".$data['desc']."', `submissions` =  '".$data['submission']."', `create_date` =  '".$data['date']."', `end_date` = '".$data['enddate']."', `updt_by` = '".$this->session->userdata('admin_id')."', `updt_date` = '".$date."', `updt_ip` = '".$ip."' WHERE  `prj_session`.`session_id` = '".$data['sid']."'";

		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	//save session documents
	function save_session_documents($data, $result, $i){
	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$sql = "INSERT INTO `grading`.`prj_session_documents` (`session_id`, `file_id`, `display_name`, `file_name`, `orignal_name`, `create_by`, `create_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`) VALUES ('".$result."', '".($i+1)."', '".$data['file_name']."', '".$data['file_name']."', '".$data['file_name']."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."')";
		
		$result = $this->adodb->Execute($sql);
		return $result;
	}
	
	//get sessions documents
	function files($pid='', $sid='')
	{
		$sql 		= "select * from prj_session_documents where session_id = '".$sid."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//save session quiz form
	function save_session_quiz($data)
	{	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		$data['form_html'] = "";
		$target_path = "uploads/";
		
		if($data['action']=='save'){ 
			$sql		=	"INSERT INTO `grading`.`prj_quiz` (`session_id`, `quiz_name`, `create_by`, `create_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`, `program_id`, `quiz_form`) VALUES ('".$data['session_id']."', 'Session Quiz', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$data['program_id']."', '".$data['form_html']."');";
			$result		=	$this->adodb->Execute($sql);
			$quiz_id = $this->adodb->Insert_ID();
			
			
			//var_dump($data["files"]); exit;
		
			
			//$q_count = 1;
			$q_count = $data['qcount'];
			$n=0;
			foreach( $data['questions'] as $k => $v )
			{
				$o_count = 1;
				$q_id = $k;
				//$q_text = $v;
				$question_text = explode("|", $v);
				
				$q_text = $question_text[0];
				$qt_id = $question_text[1];
				
				$sql		=	"INSERT INTO `grading`.`prj_question` (`question_id`, `question`, `type_id`, `create_by`, `create_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`, `session_id`, `program_id`, `quiz_id`) VALUES ('".$q_count."', '".$q_text."', '".$qt_id."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$data['session_id']."', '".$data['program_id']."', '".$quiz_id."');"; 
				$result		=	$this->adodb->Execute($sql);
				$latest_qid = $this->adodb->Insert_ID();
				
				$options = array_filter(explode("\n", trim($data['options'][$q_id])) , 'trim');
				var_dump($options);
				
				if(!empty($options)){
					$combined = implode(',', $options); //var_dump($combined); exit;
				}else{
					if(!empty($data["files"]) && $qt_id=="5"){
						
						
						$target_path = $target_path . basename( $data["files"]["name"][$n]); 
						if(move_uploaded_file($data["files"]['tmp_name'][$n], $target_path)) {
						    $combined = $data["files"]["name"][$n];
						    echo "The file ".  basename( $_FILES['userfile']['name'][$i]). " has been uploaded";
						} else{
						    echo "There was an error uploading the file, please try again!";
						}
						
						
					}
					$n++;
				}
				
				
				
				//echo $combined.$q_count." --- ";
				
				$sql		=	"INSERT INTO `grading`.`prj_question_options` (`question_id`, `option_id`, `option_name`, `create_by`, `create_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`, `session_id`, `program_id`, `quiz_id`) VALUES ('".$latest_qid."', '".$o_count."', '".$combined."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$data['session_id']."', '".$data['program_id']."', '".$quiz_id."');";						
				$result		=	$this->adodb->Execute($sql);
				
				$q_count++;
			}
			
			
		}else if($data['action']=='update'){ 
			
			$sql		=	"UPDATE `grading`.`prj_quiz` SET `updt_by` = '".$this->session->userdata('admin_id')."', `updt_date` = '".$date."', `updt_ip` = '".$ip."', `quiz_form` = '".$data['form_html']."' WHERE session_id = '".$data['session_id']."' AND program_id = '".$data['program_id']."'";
			$result		=	$this->adodb->Execute($sql);
			
			$quiz_id = $data['quiz_id'];
			
			//$q_count = 1;
			$q_count = $data['qcount'];
			$n=0;
			foreach( $data['questions'] as $k => $v )
			{
				$o_count = 1;
				$q_id = $k;
				//$q_text = $v;
				
				$question_text = explode("|", $v);
				
				$q_text = $question_text[0];
				$qt_id = $question_text[1];
				
				$sql	=	"SELECT MAX( question_id ) maxqid FROM  `prj_question` WHERE quiz_id = '".$quiz_id."'";
				$result	=	$this->adodb->Execute($sql);
				foreach ($result as $res => $qids) { echo $maxqid = $qids['maxqid']; }
				//echo $maxqid; exit;
				if($maxqid==""){$maxqid=0;}
				$maxqid = $maxqid+=1;
				
				$sql		=	"INSERT INTO `grading`.`prj_question` (`question_id`, `question`, `type_id`, `create_by`, `create_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`, `session_id`, `program_id`, `quiz_id`) VALUES ('".$maxqid."', '".$q_text."', '".$qt_id."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$data['session_id']."', '".$data['program_id']."', '".$quiz_id."');";
				$result		=	$this->adodb->Execute($sql);
				$latest_qid = $this->adodb->Insert_ID();
				
				$options = array_filter(explode("\n", trim($data['options'][$q_id])) , 'trim'); 
				
				if(!empty($options)){
					$combined = implode(',', $options); //var_dump($combined); exit;
				}else{
					if(!empty($data["files"]) && $qt_id=="5"){
						
						
						$target_path = $target_path . basename( $data["files"]["name"][$n]); 
						if(move_uploaded_file($data["files"]['tmp_name'][$n], $target_path)) {
						    $combined = $data["files"]["name"][$n];
						    echo "The file ".  basename( $_FILES['userfile']['name'][$i]). " has been uploaded";
						} else{
						    echo "There was an error uploading the file, please try again!";
						}
						
						
					}
					$n++;	
				}
				
				
				
				$sql		=	"INSERT INTO `grading`.`prj_question_options` (`question_id`, `option_id`, `option_name`, `create_by`, `create_date`, `create_ip`, `updt_by`, `updt_date`, `updt_ip`, `session_id`, `program_id`, `quiz_id`) VALUES ('".$latest_qid."', '".$o_count."', '".$combined."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$this->session->userdata('admin_id')."', '".$date."', '".$ip."', '".$data['session_id']."', '".$data['program_id']."', '".$quiz_id."');";
				$result		=	$this->adodb->Execute($sql);
					
				
				
			}
			
			
		}
		//exit;
		return $result;
	}
	
	//get sessions quiz
	function session_quiz($pid='', $sid='')
	{
		$sql 		= "select a.quiz_id, a.quiz_name, a.session_id, a.program_id, c.id as question_id, c.question, c.question_id as qid, d.type_id, d.type_name from prj_quiz a, prj_question_type d, prj_question c where a.quiz_id = c.quiz_id and c.type_id = d.type_id and a.session_id = '".$sid."' and a.program_id = '".$pid."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get question types
	function question_types()
	{
		$sql 		= "select * from prj_question_type";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get question options
	function question_options($qid='')
	{
		$sql 		= "select * from prj_question_options where question_id = '".$qid."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get total question in a session
	function total_questions($sid='',$pid='')
	{
		$sql 		= "select count(*) as total_questions from prj_question where session_id = '".$sid."' and program_id = '".$pid."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get completed question in a session
	function completed_questions($sid='',$pid='')
	{
		$sql 		= "select count(*) as completed_questions from prj_answers where answer != '' and session_id = '".$sid."' and program_id = '".$pid."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	
	//get homework status after submission
	function homework_status($sid='',$pid='')
	{
		$sql 		= "select status from prj_homeworks where session_id = '".$sid."' and program_id = '".$pid."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//remove question
	function remove_question($data)
	{
		$sql 		= "delete from prj_question where id = '".$data['qid']."' and session_id = '".$data['sid']."' and quiz_id = '".$data['quiz_id']."' and program_id = '".$data['pid']."'";
		$result 	= $this->adodb->Execute($sql);
		
		$sql 		= "delete from prj_question_options where question_id = '".$data['qid']."' and session_id = '".$data['sid']."' and quiz_id = '".$data['quiz_id']."' and program_id = '".$data['pid']."'";
		$result 	= $this->adodb->Execute($sql);
		
		if($result){
			echo "true";	
		}else{
			echo "false";	
		}
	}
	
	//select all email templates
	function email_templates($type='')
	{	
		if($type!=''){ $condition = "where template_type_id = '".$type."'"; }
		$sql 		= "select * from prj_email_templates ".$condition."";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	
	//save email template
	function save_email_template($data){
		if($data['type']=="ac"){
			$data['typename'] = "Account Confirmation";
		}else if($data['type']=="aa"){
			$data['typename'] = "Account Activation";
		}else if($data['type']=="pr"){
			$data['typename'] = "Password Recovery";
		}
	
		$sql = "INSERT INTO `prj_email_templates` (`template_type_id`, `template_type`, `template`) VALUES ('".$data['type']."', '".$data['typename']."', '".$data['temp']."')";
		$result = $this->adodb->Execute($sql);
		return $result;	
	}

}

?>
