<?php

class User_model extends model {
	
	//Constructor
	function User_model(){
		parent::Model();
		$this->load->library('Adodbx'); //Load Adodb Library
		$this->load->library('email'); // Load Email Library
		$this->load->model('admin_model'); // Load Admin Model
	}

	//register user and send confirmation code
	function user_register_code($data){
	
		$base_url = base_url();
		$confirm_code = md5(uniqid(rand())); 
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		$templates		=	$this->admin_model->email_templates("ac");
		foreach ($templates as $row) { $body = $row['template']; }
		$link = "<a href=".$base_url."main/home/user_confirmation/?code=".$confirm_code.">".$base_url."main/home/user_confirmation/?code=".$confirm_code."</a>";
		$body = str_replace('{username}', $data['fname'].' '.$data['lname'], $body);
		$body = str_replace('{link}', $link, $body);

		$sql = "INSERT INTO `prj_user` (`user_name`, `first_name`, `last_name`, `email`, `company`, `phone`, `create_date`, `create_ip`, `updt_date`, `updt_ip`, `type_id`, `password`, `create_by`, `status`, `verify_code`) VALUES ('".$data['uname']."', '".$data['fname']."', '".$data['lname']."', '".$data['email']."', '".$data['company']."', '".$data['phone']."', '".$date."', '".$ip."', '".$date."', '".$ip."', '3', '".$data['password']."', '0', '-1', '".$confirm_code."')";
		$result = $this->adodb->Execute($sql);
		if($result){
			$this->load->library('email');
			$this->email->from('accounts@grading.com', 'Grading');
			$this->email->to($data['email']);
			$this->email->subject('Your account activation link');
			$this->email->message(nl2br($body));
			/*$this->email->message("Dear ".$data['fname'].' '.$data['lname'].",<br>
	Please click on the following link to activate your account:<br>
	<a href=".$base_url."main/home/user_confirmation/?code=".$confirm_code.">".$base_url."main/home/user_confirmation/?code=".$confirm_code."</a><br><br>
	
	Thank You,<br>
	Grading Team.");*/
			
	//echo 'http://localhost/projects/grading/main/home/user_confirmation/?code=b985a53bbe738e5bdb82dbbd4589bb3c'; 
	
			$this->email->send();
			//echo $this->email->print_debugger();
			//exit;
		}
		
		return $result;	
	}
	
	//confirm user account after activation link is clicked
	function user_confirmation($code) {
		$sql = "UPDATE prj_user SET status = '0', verify_code = '' WHERE verify_code = '".$code."'";
		$result = $this->adodb->Execute($sql);
		return $result;
	}
	
	//login user and generate sessions
	function user_dologin($data) {
		$sql = "SELECT * FROM prj_user where email = '".$data['email']."' and password = '".md5($data['password'])."'";
		$result = $this->adodb->Execute($sql);
		return $result;
		/*$data = $this->adodb->GetAll($sql);
		if (count($data) != 0 ) { return $data; } else { $data = array(); }*/
	}
	
	//select current logged in user
	function user_profile_info($user_id){
		$sql="SELECT * FROM prj_user WHERE user_id = '".$user_id."'";
		$result = $this->adodb->Execute($sql);
		return $result;	
	}
	
	//update user profile
	function update_profile($user_id, $data) {
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "UPDATE prj_user SET user_name = '".$data['uname']."', first_name = '".$data['fname']."', last_name = '".$data['lname']."', email = '".$data['email']."', company = '".$data['company']."', phone = '".$data['phone']."', updt_date = '".$date."', updt_ip = '".$ip."' WHERE user_id = '".$user_id."'";
		$result = $this->adodb->Execute($sql);
		return $result;
	}
	
	//check user password
	function check_password($data)
	{
		$sql 		= "select password from prj_user where user_id = '".$data['userid']."' and password = '".$data['enc_pass']."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//update user password
	function change_password($user_id, $password)
	{	
		$enc_pass 	=	md5($password);
		$sql		=	"UPDATE prj_user SET password ='".$enc_pass."' WHERE user_id = '".$user_id."'";
		$result		=	$this->adodb->Execute($sql);
		return $result;
	}
	
	//users list
	function users_list($status = ''){
		if($status!=''){ $clause = " WHERE status = '".$status."'"; }else{ $clause = ""; }
		$sql		=	"SELECT * FROM prj_user ".$clause."";
		$result 	= 	$this->adodb->Execute($sql);
		return $result;	
	}
	
	//users filtered by type
	function users_filtered_list($type = ''){
		if($type!=''){ $clause = " WHERE type_id = '".$type."' and status = '1'"; }else{ $clause = ""; }
		$sql		=	"SELECT * FROM prj_user ".$clause."";
		$result 	= 	$this->adodb->Execute($sql);
		return $result;	
	}
	
	//get user types
	function users_types()
	{
		$sql 		= "select * from prj_user_type";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all active programs for this user
	function active_programs()
	{
		$date 		= date('Y-m-d');
		//$sql 		= "select a.* from prj_program a, prj_programs_users b where a.program_id = b.program_id and b.user_id = '".$this->session->userdata('user_id')."' and NOW() between a.start_date and a.end_date group by a.program_id";
		$sql 		= "select * from prj_program where '".$date."' >= start_date and '".$date."' <= end_date";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all enrolled programs for this user
	function enrolled_programs()
	{
		$date 		= date('Y-m-d');
		$sql 		= "select a.* from prj_program a, prj_programs_users b where a.program_id = b.program_id and b.user_id = '".$this->session->userdata('user_id')."' and '".$date."' >= a.start_date and '".$date."' <= a.end_date group by a.program_id";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all previous programs for this user
	function previous_programs()
	{
		$sql 		= "select a.*, c.remarks from prj_program a, prj_programs_users b, prj_homeworks c where a.program_id = b.program_id and c.program_id = a.program_id and b.user_id = '".$this->session->userdata('user_id')."' and NOW() > a.end_date";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all active sessions for a specific program for a user
	function active_sessions($program='')
	{
		$sql 		= "select c.session_id, c.program_id, c.title, c.create_date as start_date, c.end_date, b.grader_id, a.program_name from prj_program a, prj_programs_users b, prj_session c where a.program_id = b.program_id and b.session_id = c.session_id and b.program_id = '".$program."' and b.user_id = '".$this->session->userdata('user_id')."'";
		//$sql 	=	"select distinct c.session_id, c.program_id, c.title, a.start_date, a.end_date, b.grader_id, count(d.question_id) tot_quest, count(e.question_id) ans_quest from prj_program a, prj_programs_users b, prj_session c, prj_question d, prj_answers e where a.program_id = b.program_id and b.session_id = c.session_id and d.session_id = b.session_id and d.program_id = b.program_id and e.session_id = b.session_id and e.program_id = b.program_id and b.program_id = '".$program."' and b.user_id = '".$this->session->userdata('user_id')."' group by d.question_id";
		$result = 	$this->adodb->Execute($sql);
		return $result;
	}
	
	//save session quiz form submitted by user
	function save_session_quiz($data)
	{	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$data['tid'] = array_combine(range(1, count($data['tid'])), array_values($data['tid']));
		$data['answer'] = array_combine(range(1, count($data['answer'])), array_values($data['answer']));
		$data['question_id'] = array_combine(range(1, count($data['question_id'])), array_values($data['question_id']));
		
		
		
		
		$q_count = 1;
		foreach( $data['answer'] as $k => $v )
		{
			//if($k < count($data['tid'])){
				$tid = $data['tid'][$k];
				$question_id = $data['question_id'][$k];
			//}
			
			$a_id = $k;
			$a_text = $v;
			$sql		=	"INSERT INTO `grading`.`prj_answers` (`question_id`, `answer`, `user_id`, `create_date`, `create_ip`, `session_id`, `program_id`, `quiz_id`, `qt_id`) VALUES ('".$question_id."', '".$a_text."', '".$this->session->userdata('user_id')."', '".$date."', '".$ip."', '".$data['sid']."', '".$data['pid']."', '".$data['qid']."', '".$tid."')";
			//if($a_text!=""){
				$result		=	$this->adodb->Execute($sql);
			//}

			$q_count++;
		} //exit;
		return $result;
	}
	
	//get answers to a question
	function answers($question_id='', $qid='', $tid='', $quiz_id='', $program_id='', $session_id='')
	{
		/*$sql = "select a.question_id,a.question, a.type_id, a.session_id, a.program_id, a.quiz_id, b.option_id, b.option_name, 
		c.id as answer_id, c.answer, c.user_id, c.qt_id 
		from prj_question a 
		LEFT JOIN prj_question_options b 
		ON b.question_id = a.id 
		LEFT JOIN prj_answers c 
		ON c.question_id = a.question_id 
		where a.type_id = c.qt_id 
		and a.question_id = '".$qid."' 
		and a.type_id = '".$tid."' 
		and a.quiz_id = '".$quiz_id."' 
		and a.program_id = '".$program_id."' 
		and a.session_id = '".$session_id."' 
		and a.id = '".$question_id."'";*/
		
		////$sql = "select a.question_id,a.question, a.type_id, a.session_id, a.program_id, a.quiz_id, b.option_id, b.option_name, c.id as answer_id, c.answer, c.user_id, c.qt_id from prj_question a, prj_question_options b, prj_answers c where b.question_id = a.id and c.question_id = a.question_id  and a.type_id = c.qt_id and a.question_id = '".$qid."' and a.type_id = '".$tid."' and a.quiz_id = '".$quiz_id."' and a.program_id = '".$program_id."' and a.session_id = '".$session_id."' and a.id = '".$question_id."' group by a.question_id";
		
		$sql = "select a.question_id,a.question, a.type_id, a.session_id, a.program_id, a.quiz_id, b.option_id, b.option_name, c.id as answer_id, c.answer, c.user_id, c.qt_id, d.comment as remarks from prj_question a, prj_question_options b, prj_answers c LEFT JOIN prj_answers_comments d ON c.id = d.answer_id where b.question_id = a.id and c.question_id = a.question_id and a.type_id = c.qt_id and a.question_id = '".$qid."' and a.type_id = '".$tid."' and a.quiz_id = '".$quiz_id."' and a.program_id = '".$program_id."' and a.session_id = '".$session_id."' and a.id = '".$question_id."' group by a.question_id";
		
		
		
		
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//update session quiz form submitted by user
	function update_session_quiz($data)
	{	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$q_count = 1;
		foreach( $data['answer'] as $k => $v )
		{
			//if($k < count($data['tid'])){
				$tid = $data['tid'][$k];
				$aqid = $data['aqid'][$k];
			//}
			$a_id = $k;
			$a_text = $v;
			
			$sql = "select question_id from prj_answers WHERE qt_id = '".$tid."' and quiz_id = '".$data['qid']."' and program_id = '".$data['pid']."' and session_id = '".$data['sid']."' and question_id = '".$aqid."'"; 
			$result = $this->adodb->Execute($sql);
			
			if($result->RowCount() == 0){
				$sql = "INSERT INTO `grading`.`prj_answers` (`question_id`, `answer`, `user_id`, `create_date`, `create_ip`, `session_id`, `program_id`, `quiz_id`, `qt_id`) VALUES ('".$q_count."', '".$a_text."', '".$this->session->userdata('user_id')."', '".$date."', '".$ip."', '".$data['sid']."', '".$data['pid']."', '".$data['qid']."', '".$tid."')";
				$result	= $this->adodb->Execute($sql);
			}
			
			$sql = "UPDATE `grading`.`prj_answers` SET `answer` = '".$a_text."', `create_date` = '".$date."', `create_ip` = '".$ip."' WHERE question_id = '".$aqid."' and `session_id` = '".$data['sid']."' and `program_id` = '".$data['pid']."' and `quiz_id` = '".$data['qid']."' and `user_id` = '".$this->session->userdata('user_id')."' and `qt_id` = '".$tid."'";
			if($a_text!=""){
				$result		=	$this->adodb->Execute($sql);
			}

			$q_count++;
		}
		return $result;
	}
	
	
	//Map User / Graders / Program / Session
	function map_users($uid, $sid, $gid, $pid)
	{	
		
		$sql = "select * from prj_programs_users WHERE user_id = '".$uid."' and session_id = '".$sid."' and program_id = '".$pid."'"; 
		$result = $this->adodb->Execute($sql);
		
		if($result->RowCount() == 0){
			$sql = "INSERT INTO `grading`.`prj_programs_users` (`program_id`, `session_id`, `grader_id`, `user_id`, `status`) VALUES ('".$pid."', '".$sid."', '".$gid."', '".$uid."', 'Active')";
		}else{
			$sql = "UPDATE `grading`.`prj_programs_users` SET grader_id = '".$gid."' WHERE `program_id` = '".$pid."' and `session_id` = '".$sid."' and `user_id` =  '".$uid."'";
		}
			
		$result	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//Get associations of user
	function association($data)
	{	
		
		$sql = "select a.title, b.first_name, b.last_name from prj_session a, prj_user b, prj_programs_users c WHERE a.session_id = c.session_id and b.user_id = c.grader_id and c.user_id = '".$data['uid']."' and c.program_id = '".$data['pid']."'"; 
		$result = $this->adodb->Execute($sql);
		
		$html = "";
		
		$html .= '<table class="table table-hover">
              <thead>
                <tr>
                  <th>Sessions</th>
                  <th>Grader</th>
                </tr>
              </thead>
              <tbody>';
		if($result->RowCount() > 0){
			foreach ($result as $rowa) {           
			
				$html .= '<tr>
				<td>'.$rowa['title'].'</td>
				<td>'.$rowa['first_name']." ".$rowa['last_name'].'</td>
				</tr>';
				
			}
		}else{
			$html .= '<tr><td colspan="2">No associations at the moment for this user</td></tr>';
		}
		
		$html .= '</tbody>
            </table>';
		
		//echo "asd";
		echo $html;
	}
	
	
	
	
	//submit homework to grader
	function submit_homework($data){
	
		$sql = "INSERT INTO `prj_homeworks` (`program_id`, `session_id`, `user_id`, `grader_id`, `status`, `remarks`) VALUES ('".$data['pid']."', '".$data['sid']."', '".$data['uid']."', '".$data['gid']."', 'Submitted', '')";
		$result = $this->adodb->Execute($sql);
		return $result;
		
	}
	
	//Grader Functions
	
	//get all active programs for grader
	function active_grader_programs()
	{
		$date 		= date('Y-m-d');
		$sql 		= "select a.* from prj_program a, prj_programs_users b where a.program_id = b.program_id and b.grader_id = '".$this->session->userdata('user_id')."' and '".$date."' >= a.start_date and '".$date."' <= a.end_date group by a.program_id";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all previous programs for grader
	function previous_grader_programs()
	{
		$date 		= date('Y-m-d');
		$sql 		= "select a.* from prj_program a, prj_programs_users b where a.program_id = b.program_id and b.grader_id = '".$this->session->userdata('user_id')."' and '".$date."' > a.end_date";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	
	//get all active homeworks for the grader
	function active_homeworks_list()
	{
		$sql 		= "select distinct c.session_id, c.program_id, c.title, a.program_name, a.start_date, a.end_date, b.grader_id, d.user_id, d.status, e.first_name, e.last_name from prj_program a, prj_programs_users b, prj_session c, prj_homeworks d, prj_user e where a.program_id = b.program_id and b.session_id = c.session_id and c.session_id = d.session_id and d.user_id = e.user_id and d.grader_id = '".$this->session->userdata('user_id')."' and d.status != 'Completed'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get all active homeworks count for the grader
	function active_homeworks_count($program='')
	{
		$sql 		= "select distinct c.session_id, c.program_id, c.title, a.start_date, a.end_date, b.grader_id, d.user_id, d.status from prj_program a, prj_programs_users b, prj_session c, prj_homeworks d where a.program_id = b.program_id and b.session_id = c.session_id and c.session_id = d.session_id and d.grader_id = '".$this->session->userdata('user_id')."' and d.status != 'Completed'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	
	//get all active sessions for a specific program for a user
	function active_homeworks($program='',$session='')
	{
		if($session!=""){ $conditon = "and c.session_id = '".$session."'"; }else{ $conditon = ''; }
		$sql 		= "select distinct c.session_id, c.program_id, c.title, c.create_date as start_date, c.end_date, b.grader_id, d.user_id, d.status, a.program_name from prj_program a, prj_programs_users b, prj_session c, prj_homeworks d where a.program_id = b.program_id and b.session_id = c.session_id and c.session_id = d.session_id and d.program_id = '".$program."' ".$conditon." and d.grader_id = '".$this->session->userdata('user_id')."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	
	//get all active sessions for a specific program for a user
	function completed_homeworks($program='',$session='')
	{
		if($session!=""){ $conditon = "and c.session_id = '".$session."'"; }else{ $conditon = ''; }
		$sql 		= "select distinct c.session_id, c.program_id, c.title, a.program_name, a.start_date, a.end_date, b.grader_id, d.user_id, d.status from prj_program a, prj_programs_users b, prj_session c, prj_homeworks d where a.program_id = b.program_id and b.session_id = c.session_id and c.session_id = d.session_id ".$conditon." and d.grader_id = '".$this->session->userdata('user_id')."' and d.status = 'Completed'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//save session quiz form submitted by user
	function save_grader_feedback($data)
	{	
		$date = date('Y-m-d');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$q_count = 1;
		foreach( $data['comment'] as $k => $v )
		{
			
			$aid = $data['aid'][$k];
			
			$c_id = $k;
			$c_text = $v;
			$sql		=	"INSERT INTO `grading`.`prj_answers_comments` (`answer_id`, `comment`, `create_date`, `create_ip`, `session_id`, `program_id`, `quiz_id`, `user_id`) VALUES ('".$aid."', '".$c_text."', '".$date."', '".$ip."', '".$data['sid']."', '".$data['pid']."', '".$data['qid']."', '".$data['uid']."')";
			$result		=	$this->adodb->Execute($sql);
			
			$q_count++;
		}
		
		
		$sql		=	"UPDATE `grading`.`prj_homeworks` SET remarks = '".$data['grade']."', status = 'Completed' WHERE `program_id` = '".$data['pid']."' and `session_id` = '".$data['sid']."' and `user_id` =  '".$data['uid']."' and grader_id = '".$this->session->userdata('user_id')."'";
		$result		=	$this->adodb->Execute($sql);
		
		
		return $result;
	}
	
	
	//get total count assigned questions of all sessions to the user
	function total_question_assigned($program='')
	{
		$sql 	=	"select c.session_id, c.program_id, c.title, a.start_date, a.end_date, b.grader_id, count(d.question_id) tot_quest from prj_program a, prj_programs_users b, prj_session c, prj_question d where a.program_id = b.program_id and b.session_id = c.session_id and d.session_id = b.session_id and d.program_id = b.program_id and b.program_id = '".$program."' and b.user_id = '".$this->session->userdata('user_id')."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	
	//get total count answered questions of all sessions to the user
	function total_question_answered($program='')
	{
		$sql 	=	"select c.session_id, c.program_id, c.title, a.start_date, a.end_date, b.grader_id, count(e.question_id) ans_quest from prj_program a, prj_programs_users b, prj_session c, prj_answers e where a.program_id = b.program_id and b.session_id = c.session_id and e.session_id = b.session_id and e.program_id = b.program_id and b.program_id = '".$program."' and b.user_id = '".$this->session->userdata('user_id')."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//Enroll user to a program
	function enroll_users($pid='', $scount='', $uid='')
	{	
		//echo $scount; exit;
		for($i=1;$i<=$scount;$i++){
				
			$sql = "INSERT INTO `grading`.`prj_programs_users` (`program_id`, `session_id`, `grader_id`, `user_id`, `status`) VALUES ('".$pid."', '".$i."', null, '".$uid."', 'Active')";
			$result	= $this->adodb->Execute($sql);
		
		}
		
		return $result;
	}
	
	//get enrollment status for the user
	function enrollment_status($program='')
	{
		$sql 	=	"select * from `grading`.`prj_programs_users` WHERE program_id = '".$program."' and user_id = '".$this->session->userdata('user_id')."'";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//get enrolled users for a specific program
	function enrolled_users($program='')
	{
		$sql 	=	"select a.* from prj_user a, prj_programs_users b where a.user_id = b.user_id and b.program_id = '".$program."' group by b.program_id, b.user_id";
		$result 	= $this->adodb->Execute($sql);
		return $result;
	}
	
	//Get Exam Status for user
	function exam_status($pid, $sid)
	{	
		$sql = "select * from prj_answers_comments WHERE user_id = '".$this->session->userdata('user_id')."' and session_id = '".$sid."' and program_id = '".$pid."'"; 
		$result = $this->adodb->Execute($sql);
		if($result->RowCount() == 0){ return "0"; }else{ return "1"; }
	}
	
	
	//user password reset
	function reset_password($email)
	{
		$sql	=	"SELECT * FROM prj_user WHERE email='".$email."'";
		$result	=	$this->adodb->Execute($sql);
		$count 	= 	$result->RowCount();
		if($count == 1){
			$password  	= 	rand(10000, 90000); 
			$enc_pass	=	md5($password);
			$sql	=	"UPDATE prj_user SET password = '".$enc_pass."' where email='".$email."'";
			$result	=	$this->adodb->Execute($sql);
			
			$templates		=	$this->admin_model->email_templates("pr");
			foreach ($templates as $row) { $body = $row['template']; }
			$body = str_replace('{email}', $email, $body);
			$body = str_replace('{password}', $password, $body);
			$this->email->from('accounts@grading.com', 'Grading');
			$this->email->to($email);
			$this->email->subject('Password Reset');
			$this->email->message(nl2br($body));
			$this->email->send();
		}
		return $count;
	}
	
	
}

?>