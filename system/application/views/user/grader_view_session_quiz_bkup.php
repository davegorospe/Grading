<script>
$(document).ready(function(){
	
	$('.controls input[type="checkbox"]').click(function(){ 
		var allVals = [];
		var field = $(this); 
		var holder = field.parent().parent().parent().find('.check-inputs :checked').each(function(i) {
		//holder.find(':checked').each(function(i) {
			allVals.push((i!=0?"\r\n":"")+ $(this).val());
		});
		field.parent().parent().find('.textfield').val(allVals).attr('rows',allVals.length) ;
	});
	
});

/*function updateTextArea() {     
	var allVals = [];
	$('.controls :checked').each(function(i) {
		allVals.push((i!=0?"\r\n":"")+ $(this).val());
	});
	$(this).parent().parent().find('.textfield').val(allVals).attr('rows',allVals.length)     
	allVals.length = 0;
	alert(allVals.length);
}

$(function() {
	$('.controls input[type="checkbox"]').click(updateTextArea);
	
	updateTextArea();
});
*/
</script>


<?php 
foreach ($session as $row) {
	$sid 		= $row['session_id'];
	$title 		= $row['title'];
	$description 	= $row['description'];
	$create_date 	= $row['create_date'];
	$submission 	= $row['submissions'];
}

$count = $session_quiz->RowCount();
foreach ($session_quiz as $row) {
	//$quiz_form 	= $row['quiz_form'];
	$quiz_id 	= $row['quiz_id'];
}
?>

<div class="row-fluid"> <!--Body content start-->

    <div class="span9"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12">
                <!--Body content-->
                <h3>View Quiz Session: <?php echo $title; ?></h3>
            </div>
        </div>
        
        <div class="clearfix"></div>
        
        <form method="post" enctype="multipart/form-data"  class="form-horizontal" autocomplete="off" id="quiz_form" name="quiz_form" action="<?php echo base_url();?>main/grader/save_homework_feedback">
        
            <input id="action" name="action" type="hidden" value="save" />
            <input id="sid" name="sid" type="hidden" value="<?php echo $session_id; ?>" />
            <input id="pid" name="pid" type="hidden" value="<?php echo $program_id; ?>" />
            <input id="qid" name="qid" type="hidden" value="<?php echo $quiz_id; ?>" />
            <input id="uid" name="uid" type="hidden" value="<?php echo $user_id; ?>" />
            
            <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        	
           	<?php $i=1; foreach ($session_quiz as $row) { 
		
			//$question_options = $this->admin_model->question_options($row['question_id']);	
			$answers = $this->user_model->answers($row['question_id'], $row['qid'],$row['type_id'],$quiz_id,$program_id,$session_id);	
		
		?>
			<input id="tid[]" name="tid[]" type="hidden" value="<?php echo $row['type_id']; ?>" />
                        <div class="control-group">
                                <label class="control-label"><?php echo $row['question']; ?> <span class="red">*</span></label>
                                <div class="controls">
                                <?php if($row['type_id']=="1"){ ?>
                                
                                	<?php foreach ($answers as $option) { ?>
                                                <input id="question_<?php echo $i; ?>" class="input-xlarge" name="question[]" type="text" value="<?php echo $option['answer']; ?>" placeholder="<?php echo $row['question']; ?>" />
                                        <?php } ?>
                                        
                                <?php }else if ($row['type_id']=="2"){ ?>
                                
                                	<?php foreach ($answers as $option) { 
					$options = explode(",", $option['option_name']);
						foreach ($options as $opt) {
					?>
                                                <label class="radio">
                                                	<?php if($opt==$option['answer']){ ?>
                                                        	<input type="radio" name="question[]" value="<?php echo $opt; ?>" checked="checked">
                                                        <?php }else{ ?>
                                                        	<input type="radio" name="question[]" value="<?php echo $opt; ?>">
                                                        <?php } ?>
                                                        <?php echo $opt; ?>
                                                </label>
                                        <?php }
					} ?>
                                        
                                <?php }else if ($row['type_id']=="3"){ ?>
                                	<div class="check-inputs">
                                        <?php foreach ($answers as $option) { 
					$options = explode(",", $option['option_name']);
						foreach ($options as $opt) {?>
                                                <label class="checkbox">
                                                	<?php if($opt==$option['answer']){ ?>
                                                        	<input type="checkbox" name="checkbox[]" value="<?php echo $opt; ?>" class="checks" checked="checked">
                                                        <?php }else{ ?>
                                                        	<input type="checkbox" name="checkbox[]" value="<?php echo $opt; ?>" class="checks">
                                                        <?php } ?>
                                                        <?php echo $opt; ?>
                                                </label>
                                        <?php }
					} ?>
                                        <textarea class="textfield" name="question[]" style="display:none"></textarea>
                                        </div>
                                        
                                <?php } ?>
                                </div>
                        </div>
                        
                        
                        <div class="control-group form-horizontal">
                                <label class="control-label">Comments:</label>
                                <div class="controls">
                                        <textarea class="textfield input-xlarge" name="comments[]" ></textarea>
                                        <textarea class="textfield" name="answer_id[]" style="display:none"><?php echo $option['answer_id']; ?></textarea>
                                </div>
                        </div>
                        			
                <?php $i++; } ?>
                
                
                
                <div class="control-group">
                        <label class="control-label">Overall Homework Grade:</label>
                        <div class="controls">
                                <select name="grade" class="input-xlarge" id="grade">
                                        <option value="Excellent" >Excellent</option>	
                                        <option value="Good" >Good</option>
                                        <option value="Satisfactory" >Satisfactory</option>
                                        <option value="Need Improvement" >Need Improvement</option>		
                                </select>
                        </div>
                </div>
        
        
            
            
            <div class="control-group form-horizontal">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                        <button id="btn-save" class="btn btn-info" name="submit" type="submit">Submit</button>
                </div>
            </div>
        
        </form>
        
        

                </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->