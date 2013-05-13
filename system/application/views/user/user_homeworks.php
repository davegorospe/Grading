<script>
$(document).ready(function() {
	
	//filter by user type
	$('#programs').change(function() {
		if($(this).val()!='0'){
			window.location = base_url+"main/user/homeworks/" + $(this).val();
		}
	});
	
	/*$("input:radio[name=format]").click(function() {
		var value = $('input:radio[name=format]:checked').val(); 
		if($('.link-to-quiz').length > 0){ 
			var a_href = $(this).parent().parent().parent().find('.controls > .link-to-quiz').attr('href'); 
			if(value==0){
				window.location.href = a_href+"/"+value+"/initiate-whole";
			}else{
				window.location.href = a_href+"/"+value+"/initiate-one-by-one";
			}
		}else if($('.link-to-quiz-review').length > 0){
			var a_href = $(this).parent().parent().parent().find('.controls > .link-to-quiz-review').attr('href'); 
			if(value==0){
				window.location.href = a_href+"/"+value+"/review-whole";
			}else{
				window.location.href = a_href+"/"+value+"/review-one-by-one";
			}
		
		}
	});*/
	
	$('.link-to-quiz').click(function(){
		var format = $(this).parent().parent().find("input:radio[name=format]:checked").val();	
		var href = $(this).parent().parent().parent().find('.controls > .link-to-quiz').attr('href');
		var element = $(this).parent().parent().parent().find('.controls > .link-to-quiz');
		if(typeof format == "undefined"){ format = 0; }
		if(format==0){
			//element.attr('href',href+"/"+format+"/initiate-whole");
			window.location.href = href+"/"+format+"/initiate-whole";
		}else{
			//element.attr('href',href+"/"+format+"/initiate-one-by-one");
			window.location.href = href+"/"+format+"/initiate-whole";
		}
		return false;
	});
	
	$('.link-to-quiz-review').live('click', function(){
		var format = $(this).parent().parent().find("input:radio[name=format]:checked").val();	
		var href = $(this).parent().parent().parent().find('.controls > .link-to-quiz-review').attr('href');
		var element = $(this).parent().parent().parent().find('.controls > .link-to-quiz-review');
		//alert(format);
		if(typeof format == "undefined"){ format = 0; }
		if(format==0){
			//element.attr('href',href+"/"+format+"/review-whole");
			window.location.href = href+"/"+format+"/review-whole";
		}else{
			//element.attr('href',href+"/"+format+"/review-one-by-one");
			window.location.href = href+"/"+format+"/review-one-by-one";
		}
		return false;
	});

}); //ending document.ready();

</script>




<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Homeworks</h3>
            </div>
        </div>
        
        
        <div class="control-group">
		<label class="control-label">Please Select a Program:</label>
                <div class="controls">
                        <select name="programs" class="input-xlarge" id="programs">
                        <option value="0">Please Select</option>
                        <?php 
                        foreach ($active_programs as $row) {
                                if($row['program_id']==$selected){
                                        echo "<option value=".$row['program_id']." selected='selected'>".$row['program_name']."</option>";				
                                }else{
                                        echo "<option value=".$row['program_id'].">".$row['program_name']."</option>";				
                                }
                        }
                        ?>
                        </select>
                </div>
        </div>
        
        	<div class="clearfix"></div>
                
                <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        
        	
                <div class="form-horizontal">
                
        	<?php $i=1; foreach ($active_sessions as $row) { ?>
                
                <div class="control-group session-box">
                
                
                <label class="control-label"><strong>Program:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['program_name']; ?></label>
                </div>
                
                
                <label class="control-label"><strong>Session <?php echo $i; ?>:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['title']; ?></label>
                </div>
            	
                
                
                <label class="control-label"><strong>Start Date:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['start_date']; ?></label>
                </div>
            	
                
                <label class="control-label"><strong>End Date:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $row['end_date']; ?></label>
                </div>
            	
                
                <?php 
			$total_questions = $this->admin_model->total_questions($row['session_id'], $row['program_id']); 
			foreach ($total_questions as $qrow){ $totalq = $qrow['total_questions']; }
		?>
                
                <label class="control-label"><strong>Total Questions:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $totalq; ?></label>
                </div>
            	
                
                <?php 	$status = '';
			$completed_questions = $this->admin_model->completed_questions($row['session_id'], $row['program_id']); 
			foreach ($completed_questions as $qrow){ $completeq = $qrow['completed_questions']; }
			$homework_status = $this->admin_model->homework_status($row['session_id'], $row['program_id']); 
			foreach ($homework_status as $stat){ $status = $stat['status']; }
		?>
                
                
                <label class="control-label"><strong>Completed Questions:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $completeq; ?></label>
                </div>
            	
                
                
                <label class="control-label"><strong>Status:</strong></label>
                <div class="controls clearfix">
                <label class="radio"><?php if($status!=''){ echo '<span class="label label-success">'.$status.'</span>'; }else{ echo '<span class="label label-warning">Not Submitted</span>'; } ?></label>
                </div>
            	
               
                
                <label class="control-label"><strong>Session Feedback:</strong></label>
                <div class="controls">
                <label class="radio">xx</label>
                </div>
            	
                
                
                <label class="control-label"><strong>Question Display:</strong></label>
                <div class="controls">
		<label class="radio">
                        <input type="radio" name="format" value="0">All at once
                </label>
                <label class="radio">
                        <input type="radio" name="format" value="1">One at a time
                </label>
                </div>
           	
                
            	
                <div class="controls">
                <?php if($completeq == '0'){ ?>
			<a id="btn-save" class="btn btn-info link-to-quiz" name="submit" type="submit" href="<?php echo base_url();?>main/user/session_quiz/<?php echo $row['program_id']; ?>/<?php echo $row['session_id']; ?>">Begin Quiz</a>
                <?php }else if($completeq < $totalq){ ?>
			<a id="btn-save" class="btn btn-info" name="submit" type="submit" href="<?php echo base_url();?>main/user/continue_session_quiz/<?php echo $row['program_id']; ?>/<?php echo $row['session_id']; ?>/resume">Continue Quiz</a>
                <?php }else if($status!=''){ ?>
			<a id="btn-save" class="btn btn-info link-to-quiz-review" name="submit" type="submit" href="<?php echo base_url();?>main/user/view_session_quiz/<?php echo $row['program_id']; ?>/<?php echo $row['session_id']; ?>">Review Quiz</a>
                <?php }else{ ?>
                	<a id="btn-save" class="btn btn-success" name="submit" type="submit" href="<?php echo base_url();?>main/user/submit_homework/<?php echo $row['program_id']; ?>/<?php echo $row['session_id']; ?>/<?php echo $this->session->userdata('user_id'); ?>/<?php echo $row['grader_id']; ?>/submit">Send to Grader</a>
                <?php } ?>
                </div>
           	
                
                </div>
                
                <div class="clearfix"></div>
                
		<?php $i++; } ?>
                
		</div>

</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->