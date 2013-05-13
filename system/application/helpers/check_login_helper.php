<?php 

	function user_login()
	{
		$CI = & get_instance();
		if ($CI->session->userdata('user_login')){
			return true;
		}else{
			return false;
		}
	}


	function admin_login()
	{
		$CI = & get_instance();
		if ($CI->session->userdata('admin_login')){
			return true;
		}else{
			return false;
		}
	}

?>