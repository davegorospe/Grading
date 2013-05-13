<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/home/save_email_template" id="add_email_form" name="add_email_form" class="form-verticle" autocomplete="off" >
<div id="form_new_session">



<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Add New Email Template</h3>
        </div>
        <div class="modal-body">

			<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
                        
                            <input id="action" name="action" type="hidden" value="add_email_form" />
                            <input id="typename" name="typename" type="hidden" value="" /> 
                            <div class="control-group">
                                <label class="control-label">Title <span class="red">*</span></label> 
                                <div class="controls">
                                    <select name="type" class="required input-xxlarge" id="type">
					<option value="0">Please Select</option>
                                        <option value="ac">Account Confirmation</option><!--1-->
                                        <option value="aa">Account Activation</option><!--2-->
                                        <option value="pr">Password Recovery</option><!--3-->
                                    </select>
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label">Template <span class="red">*</span></label>
                                <div class="controls">
                                        <textarea style="width: 516px;" id="temp" class="required" name="temp" placeholder="Email Template" rows="10" /></textarea>
                                </div>
                            </div>
                            
                            
                        
                        

        </div>
        <div class="modal-footer">
                <button id="btn-save" class="btn btn-info" name="submit" type="submit">Save Template</button>
        </div>
</div>


</div>
</form>