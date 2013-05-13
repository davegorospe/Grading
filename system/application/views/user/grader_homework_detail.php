<script>
$(document).ready(function() {
	
	//filter by user type
	$('#programs').change(function() {
		if($(this).val()!='0'){
			window.location = base_url+"main/grader/homeworks/" + $(this).val();
		}
	});
	
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
                <h3>Homework Detail</h3>
            </div>
        </div>
        
        
        	<div class="form-horizontal">
                <legend>Needs Review</legend>
        
                
                <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        
        	<?php $i=1; foreach ($active_homeworks as $row) { ?>
                
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
                
                <!--<div class="control-group">
                <label class="control-label"><strong>Completed Questions:</strong></label>
                <div class="controls">
                <label class="radio"><?php echo $completeq; ?></label>
                </div>
            	</div>-->
                
                
                <label class="control-label"><strong>Status:</strong></label>
                <div class="controls clearfix">
                <label class="radio"><span class="label label-info"><?php echo $status; ?></span></label>
                </div>
            	
                
                <!--<div class="control-group">
                <label class="control-label"><strong>Session Feedback:</strong></label>
                <div class="controls">
                <label class="radio">xx</label>
                </div>
            	</div>-->
                
                
                <label class="control-label"><strong>Question Display:</strong></label>
                <div class="controls">
		<label class="radio">
                        <input type="radio" name="format" value="0">All at once
                </label>
                <label class="radio">
                        <input type="radio" name="format" value="1">One at a time
                </label>
                </div>
           	
                
        <?php if($status!='Completed'){ ?>
            	
                        <div class="controls">
                        	<a id="btn-save" class="btn btn-info link-to-quiz-review" name="submit" type="submit" href="<?php echo base_url();?>main/grader/view_homework/<?php echo $row['program_id']; ?>/<?php echo $row['session_id']; ?>/<?php echo $row['user_id']; ?>" >Review Homework</a>
                        </div>
           	
        <?php } ?>        
                
                </div>
		<?php $i++; } ?>
                
                
                
                </div>
                    
            
                


</div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->