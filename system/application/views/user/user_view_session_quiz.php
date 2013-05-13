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

<style>
fieldset { border:none; width:545px; }
#btn-save { margin-top:10px; }
.option-box iframe { width:543px !important; }
.option-box { margin-bottom: 15px; }
</style>

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

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>View Quiz Session: <?php echo $title; ?></h3>
            </div>
        </div>
        
        <div class="clearfix"></div>
        
        <form method="post" enctype="multipart/form-data"  class="form-verticle" autocomplete="off" id="quiz_form" name="quiz_form" action="<?php echo base_url();?>main/user/save_session_quiz">
        
            <input id="action" name="action" type="hidden" value="save" />
            <input id="sid" name="sid" type="hidden" value="<?php echo $session_id; ?>" />
            <input id="pid" name="pid" type="hidden" value="<?php echo $program_id; ?>" />
            <input id="qid" name="qid" type="hidden" value="<?php echo $quiz_id; ?>" />
            
            <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        	
           	<?php $i=1; foreach ($session_quiz as $row) { 
		
			//$question_options = $this->admin_model->question_options($row['question_id']);	
			$answers = $this->user_model->answers($row['question_id'], $row['qid'],$row['type_id'],$quiz_id,$program_id,$session_id);	
		
		?>
                	<fieldset class="session-box">
                	<input id="tid[]" name="tid[]" type="hidden" value="<?php echo $row['type_id']; ?>" />
                        <div class="control-group">
                                <label class="control-label"><strong>Question <?php echo $i; ?>:</strong> <?php echo $row['question']; ?> <span class="red">*</span></label>
                                <div class="controls">
                                <?php if($row['type_id']=="1"){ ?>
                                
                                	<?php foreach ($answers as $option) { ?>
                                                <textarea id="question_<?php echo $i; ?>" class="input-xxlarge" name="question[]" placeholder="<?php echo $row['question']; ?>" readonly="readonly" rows="4"><?php echo $option['answer']; ?></textarea>
                                        <?php } ?>
                                        
                                <?php }else if ($row['type_id']=="2"){ ?>
                                
                                	<?php foreach ($answers as $option) { 
					$options = explode(",", $option['option_name']);
						foreach ($options as $opt) {
					?>
                                                <label class="radio">
                                                	<?php if($opt==$option['answer']){ ?>
                                                        	<input type="radio" name="question[<?php echo $row['question_id']; ?>]" value="<?php echo $opt; ?>" checked="checked" disabled='disabled'>
                                                        <?php }else{ ?>
                                                        	<input type="radio" name="question[<?php echo $row['question_id']; ?>]" value="<?php echo $opt; ?>" disabled='disabled'>
                                                        <?php } ?>
                                                        <?php echo $opt; ?>
                                                </label>
                                        <?php }
					} ?>
                                        
                                <?php }else if ($row['type_id']=="3"){ ?>
                                	<div class="check-inputs">
                                        <?php foreach ($answers as $option) { 
					$options = explode(",", $option['option_name']);
						$i=0;
						foreach ($options as $opt) {
							
							$options_answers = explode(",", $option['answer']);
							//var_dump(array_map('trim',$options_answers));
							//echo $opt;
							$options_answers = array_map('trim',$options_answers)
							
							?>
							<label class="checkbox">
								<?php if (in_array($opt, $options_answers)){ //echo "found"; ?>
									<input type="checkbox" name="checkbox[]" value="<?php echo $opt; ?>" class="checks" checked="checked" disabled='disabled'>
								<?php }else{ //echo "not-found"; ?>
									<input type="checkbox" name="checkbox[]" value="<?php echo $opt; ?>" class="checks" disabled='disabled'>
								<?php } ?>
								<?php echo $opt; ?>
							</label>
                                        <?php 	$i++;
						}
					} ?>
                                        <textarea class="textfield" name="question[]" style="display:none"></textarea>
                                        </div>
                                        
                                <?php }else if ($row['type_id']=="4"){ ?>
                                	<div class="option-box">
                                        <?php foreach ($answers as $option) { 
						echo str_replace("&quot;", '"', $option['option_name']);
					} ?>
                                        </div>
                                        <strong>Answer:</strong>
                                	<div class="option-box">
                                        <?php foreach ($answers as $option) { 
						echo str_replace("&quot;", '"', $option['answer']);
					} ?>
                                        </div>
                                <?php }else if ($row['type_id']=="5"){ ?>
                                        <div class="option-box">
                                        <strong>Attachment:</strong>
                                        <?php foreach ($answers as $option) { 
						echo "<a href='".base_url()."uploads/".$option['option_name']."' target='_blank'>".$option['option_name']."</a>";
					} ?>
                                        </div>
                                        <br/><br/>
                                	<div class="option-box">
                                        <strong>Answer:</strong>
                                        <?php foreach ($answers as $option) { 
						echo $option['answer'];
					} ?>
                                        </div>
                                        <br/><br/>
                                <?php } ?>
                                </div>
                        </div>	
                        
                        <?php if($exam_status == "1"){ ?>
                        <div class="control-group form-vertcile">
                                <!--<label class="control-label">Comments:</label>-->
                                <label class="control-label">&nbsp;</label>
                                <div class="controls">
	                                <p class="triangle-border top"><strong>Grader's Comment:</strong> <?php echo $option['remarks']; ?>.</p>
                                        <!--<textarea class="textfield input-xlarge" name="comments[]" ><?php echo $option['remarks']; ?></textarea>-->
                                </div>
                        </div>
                        <?php } ?>
                        
                        </fieldset>	
                        <div class="clearfix"><br/></div>	
                <?php $i++; } ?>
            
            
            <div class="control-group form-horizontal">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                        <button id="btn-save" class="btn btn-info hidden" name="submit" type="button" disabled="disabled">Submit</button>
                </div>
            </div>
        
        </form>
        
        

                </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('user/right-bar-user'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->