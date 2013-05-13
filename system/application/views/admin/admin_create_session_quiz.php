<?php 
foreach ($session as $row) {
	$sid 		= $row['session_id'];
	$title 		= $row['title'];
	$description 	= $row['description'];
	$create_date 	= $row['create_date'];
	$submission 	= $row['submissions'];
}

$count = $session_quiz->RowCount();
if($count==0){$count=1;}else{$count+=1;} //echo $count;
foreach ($session_quiz as $row) {
	//$quiz_form 	= $row['quiz_form'];
	$quiz_id 	= $row['quiz_id'];
}
?>

<script>
$(document).ready(function() { //alert('ready');
		
	var count = <?php echo $count; ?>;
	var qtype = '';
	var qtypename = '';
	var option = '';
	var controls = '';
	
	$('#btn-add').click(function(){  //alert('asdasd');
		count += 1;
		option = '';
		controls = '';
		qtype = $('#question_type').val(); //alert(qtype);
		qtypename = $("#question_type option:selected").text(); //alert(qtypename);
		if(qtype == '2' || qtype == '3'){
			option = '<div class="clearfix">&nbsp;</div><label class="control-label">Options <span class="red">*</span></label><div class="controls">    <textarea id="options_' + count + '" class="input-xxlarge required" name="options[]" placeholder="Enter your options here" rows="6"></textarea></div>';
		}else if(qtype == '1'){
			option = '<div class="hidden"><div class="clearfix">&nbsp;</div><label class="control-label">Options <span class="red">*</span></label><div class="controls">    <textarea id="options_' + count + '" class="input-xxlarge required" name="options[]" placeholder="Enter your options here" rows="6">null</textarea></div></div>';
		}else if(qtype == '4'){
			option = '<div class="clearfix">&nbsp;</div><label class="control-label">Embed Code <span class="red">*</span></label><div class="controls">    <textarea id="options_' + count + '" class="input-xxlarge required" name="options[]" placeholder="Enter your Video Embed Code here" rows="9"></textarea></div>';
		}else if(qtype == '5'){
			option = '<div class="clearfix">&nbsp;</div><label class="control-label">Upload File <span class="red">*</span></label><div class="controls"><input name="options[]" id="options_' + count + '" class="date-input btn" type="file" value="Upload" /></div>';
		}
		
		if(qtype!='0'){
			control = '<div class="control-group row-'+count+' border-bottom" ><label class="control-label">'+qtypename+': <span class="red">*</span></label><div class="controls"><input id="question_' + count + '" class="input-xxlarge required" name="question[]" type="text" value="" placeholder="Type your question here" /><input id="qtype_' + count + '" name="qtype[]" type="hidden" value ="'+qtype+'"/>&nbsp;<span id="row-'+count+'" class="remove"><i class="icon-trash" title="Remove"></i></span></div>'+option+'</div>';
			
			$('#build').append(control);
		}
		
		$('#btn-save').removeClass('hidden' );
		
		return false;
	});
		
	$('.remove').live('click', function(){  //alert('removing');
		var id = $(this).attr('id');
		$('.'+id).remove();
		count -= 1;
		if(count==0){ $('#btn-save').addClass('hidden' ); }
	});
	
	$('.qremove').live('click', function(){  
		var id = $(this).attr('id');
		var sid = $('#sid').val();
		var pid = $('#pid').val();
		var qid = $('#quiz_id').val();
		
		//alert(id + sid + pid + qid); return false;
		var response;
		$.ajax({
			type: 'POST',
			url: base_url+'admin/home/remove_question/',
			data: 'action=remove_question&qid='+id+'&sid='+sid+'&pid='+pid+'&quiz_id='+qid,
			success: function(response) { //alert(response); 
				if(response=='true'){
					$('.question-'+id).fadeOut(); 
				}
			}
		});
		
		
		
	});
		
});
</script>

<style>
fieldset { border:none; width:545px; }
#btn-save { margin-top:10px; }
.option-box iframe { width:543px !important; }
</style>

<div class="row-fluid"> <!--Body content start-->

    <div class="span9 bgwhite"> <!--Body Left content start-->
    
    
    	 <div class="row-fluid">
            <div class="span12 heading-left">
                <!--Body content-->
                <h3>Create Quiz (Session: <?php echo $title; ?>)</h3>
            </div>
        </div>
        
        
                <div class="control-group form-horizontal mb40">
                <?php //if($count==0){ ?>
                        <label class="control-label" style="width:auto !important;">Question Type:</label>
                        <div class="controls" style="margin-left:80px !important;">
                                <select name="question_type" class="input-large" id="question_type">
                                        <option value="0">Please Select</option>
                                        <?php 
                                        foreach ($question_types as $row) {
                                                echo "<option value=".$row['type_id'].">".$row['type_name']."</option>";				
                                        }
                                        ?>
                                </select>
                                <button id="btn-add" class="btn btn-info" name="submit" type="submit">Add</button>
                        </div>
                <?php //} ?>
                </div>
        
        
        <div class="clearfix"></div>
        
        <form method="post" enctype="multipart/form-data"  class="form-verticle" autocomplete="off" id="quiz_form" name="quiz_form" action="<?php echo base_url();?>admin/home/save_session_quiz">
        
            <input id="action" name="action" type="hidden" value="<?php if($count==1){ echo "save"; }else{ echo "update"; }?>" />
            <input id="sid" name="sid" type="hidden" value="<?php echo $session_id; ?>" />
            <input id="pid" name="pid" type="hidden" value="<?php echo $program_id; ?>" />
            <input id="quiz_id" name="quiz_id" type="hidden" value="<?php if($count!=1){echo $quiz_id;} ?>" />
            <input id="qcount" name="qcount" type="hidden" value="<?php echo $count; ?>" />
            
            <div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
        	
            <?php //if($count==0){ ?>
            	<div id="build"></div>
            <?php //}else{ ?>
            
            
		<?php $i=1; foreach ($session_quiz as $row) { 
		
			$question_options = $this->admin_model->question_options($row['question_id']);	
		
		?>
                
                	<fieldset class="session-box">
                        <div class="control-group question-<?php echo $row['question_id']; ?>">
                                <label class="control-label"><strong>Question <?php echo $i; ?>:</strong> <?php echo $row['question']; ?> <span class="red">*</span></label>
                                <div class="controls">
                                <?php if($row['type_id']=="1"){ ?>
                                
                                        <input id="" class="input-xxlarge" name="text" type="text" value="" placeholder="<?php echo $row['question']; ?>" />
                                        &nbsp;<span id="<?php echo $row['question_id']; ?>" class="qremove"><i class="icon-trash" title="Remove"></i></span>
                                        
                                <?php }else if ($row['type_id']=="2"){ ?>
                                
                                	&nbsp;<span id="<?php echo $row['question_id']; ?>" class="qremove multi-remove"><i class="icon-trash" title="Remove"></i></span>
                                        <div class="option-box">
                                	<?php foreach ($question_options as $option) {
					$options = explode(",", $option['option_name']);
						foreach ($options as $opt) {
					?>
                                                <label class="radio">
                                                        <!--<input type="radio" name="radios" value="<?php echo $option['option_id']; ?>">-->
                                                        <input type="radio" name="radios[<?php echo $row['question_id']; ?>]" value="<?php echo $opt; ?>">
                                                        <?php echo $opt; ?>
                                                </label>
                                        <?php }
					} ?>
                                        </div>
                                        
                                <?php }else if ($row['type_id']=="3"){ ?>
                                	
                                        &nbsp;<span id="<?php echo $row['question_id']; ?>" class="qremove multi-remove"><i class="icon-trash" title="Remove"></i></span>
                                        <div class="option-box">
                                        <?php foreach ($question_options as $option) { 
					$options = explode(",", $option['option_name']);
						foreach ($options as $opt) {
					?>
                                                <label class="checkbox">
                                                        <!--<input type="checkbox" name="checkboxes" value="<?php echo $option['option_id']; ?>">-->
                                                        <input type="checkbox" name="checkboxes" value="<?php echo $opt; ?>">
                                                        <?php echo $opt; ?>
                                                </label>
                                        <?php }
					} ?>
                                        </div>
                                        
                                <?php }else if ($row['type_id']=="4"){ ?>
                                	
                                        &nbsp;<span id="<?php echo $row['question_id']; ?>" class="qremove multi-remove"><i class="icon-trash" title="Remove"></i></span>
                                        <div class="option-box">
                                        <?php foreach ($question_options as $option) { 
						echo $option['option_name'];
					} ?>
                                        </div>
                                        
                                <?php }else if ($row['type_id']=="5"){ ?>
                                	
                                        &nbsp;<span id="<?php echo $row['question_id']; ?>" class="qremove multi-remove"><i class="icon-trash" title="Remove"></i></span>
                                        <div class="option-box">
                                        <?php foreach ($question_options as $option) { 
						echo "<a href='".base_url()."uploads/".$option['option_name']."' target='_blank'>".$option['option_name']."</a>";
					} ?>
                                        </div>
                                        
                                <?php } ?>
                                </div>
                        </div>		
                        </fieldset>	
                        <div class="clearfix"><br/></div>
                <?php $i++; } ?>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <?php //} ?>
            
            
            
            
            
            
            <div class="control-group form-verticle pull-right">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                <?php if($count==0){ ?>
                        <button id="btn-save" class="btn btn-info hidden" name="submit" type="submit">Save Quiz</button>
                <?php }else{ ?>
                	<button id="btn-save" class="btn btn-info hidden" name="submit" type="submit">Update Quiz</button>
                <?php } ?>
                </div>
            </div>
        
        
        </form>
        
        

                </div> <!--Body Left content end-->
    
    
    
    <div class="span3"> <!--Right bar start-->
                
    	<?php $this->load->view('admin/right-bar-admin'); ?>
    
    </div> <!--Right bar end-->


</div><!--Body content end-->