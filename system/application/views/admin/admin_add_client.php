<form method="post" enctype="multipart/form-data" action="#" id="add_email_form" name="add_email_form" class="form-horizontal" autocomplete="off" >
<div id="form_new_session">



<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Add New Client</h3>
        </div>
        <div class="modal-body">

			<div class="message"><?php echo $this->session->flashdata('alert_message');?></div>
                        
                            <input id="action" name="action" type="hidden" value="add_email_form" />
                            <input id="typename" name="typename" type="hidden" value="" /> 
                            <div class="control-group">
                                <label class="control-label">Client Name <span class="red">*</span></label> 
                                <div class="controls">
                                    <input class="input-xlarge" name="name" type="text" value="" placeholder="Client Name" />
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label">Features <span class="red">*</span></label>
                                <div class="controls">
                                        <label class="checkbox">
                                                <input type="checkbox" name="checkboxes" value="">Video
                                        </label>
                                        <label class="checkbox">
                                                <input type="checkbox" name="checkboxes" value="">Live Chat
                                        </label>
                                        <label class="checkbox">
                                                <input type="checkbox" name="checkboxes" value="">Email
                                        </label>
                                        <label class="checkbox">
                                                <input type="checkbox" name="checkboxes" value="">Share Screen
                                        </label>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Students Allowed per Program <span class="red">*</span></label> 
                                <div class="controls">
                                    <input class="input-xlarge" name="name" type="text" value="" placeholder="Students Allowed per Program" />
                                </div>
                            </div>
                            
                            
                        
                        

        </div>
        <div class="modal-footer">
                <button id="btn-save" class="btn btn-info" name="submit" type="button">Save Client</button>
        </div>
</div>


</div>
</form>