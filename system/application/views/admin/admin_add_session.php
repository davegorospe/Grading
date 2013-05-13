<script type="text/javascript" src="<?php echo base_url();?>system/assets/datetimepicker/js/bootstrap-datetimepicker.min.js" ></script>
<link href="<?php echo base_url();?>system/assets/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />


<form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/home/save_session" id="add_session_form" name="add_session_form" class="form-horizontal" autocomplete="off" >
<div id="form_new_session">



<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Add New Session</h3>
        </div>
        <div class="modal-body">


                            <input id="action" name="action" type="hidden" value="add_session_form" />
                            <input id="pid" name="pid" type="hidden" value="<?php echo $pid;?>" />
                                
                            <div class="control-group">
                                <label class="control-label">Title <span class="red">*</span></label> 
                                <div class="controls">
                                    <input id="title" class="input-xlarge" name="title" maxlength="20" type="text" value="" placeholder="Title" data-type="alphabets" /> 
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label">Description <span class="red">*</span></label>
                                <div class="controls">
                                        <textarea id="desc" class="input-xlarge" name="desc" placeholder="Description" /></textarea>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Support Material</label>
                                <div class="controls">
                                        <input name="userfile[]" id="userfile[]" class="btn" type="file" value="Upload" multiple="multiple"/>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div class="controls">
                                        <label class="checkbox">
                                        	<input type="checkbox" name="submission" value="Y" id="submission">Allow Documents Submission
                                        </label>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Session Start Date <span class="red">*</span></label>
                                <div class="controls">
                                          <div id="datetimepicker3" class="input-append">
                                            <input data-format="MM-dd-yyyy" type="text" class="date-input" name="sessiondate" id="sessiondate" placeholder="Session Start Date">
                                            <span class="add-on">
                                              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                            </span>
                                          </div>
                                        </div>
                                        <script type="text/javascript">
                                          $(function() {
                                            $('#datetimepicker3').datetimepicker({
                                              pickTime: false
                                            });
                                          });
                                        </script>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Session End Date <span class="red">*</span></label>
                                <div class="controls">
                                          <div id="datetimepicker4" class="input-append">
                                            <input data-format="MM-dd-yyyy" type="text" class="date-input" name="sessionenddate" id="sessionenddate" placeholder="Session End Date">
                                            <span class="add-on">
                                              <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                            </span>
                                          </div>
                                        </div>
                                        <script type="text/javascript">
                                          $(function() {
                                            $('#datetimepicker4').datetimepicker({
                                              pickTime: false
                                            });
                                          });
                                        </script>
                            </div>
                        
                        

        </div>
        <div class="modal-footer">
                <button id="btn-save" class="btn btn-info" name="submit" type="submit">Save Session</button>
        </div>
</div>


</div>
</form>