<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail"> 

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("patient/document") ?>"> <i class="fa fa-list"></i>  <?php echo display('document_list') ?> </a>  
                </div>
            </div>



            <div class="panel-body">
                <div class="row">
                    <div id="output" class="hide alert"></div>

                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open_multipart('patient/document_form','class="form-inner" id="mailForm" ') ?>

                            <div class="form-group row">
                                <label for="patient_id" class="col-xs-3 col-form-label"><?php echo display('patient_id')?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="patient_id" onchange="checkid(this.value)"  type="text" class="form-control" id="patient_id" placeholder="<?php echo display('patient_id')?>" value="<?php echo (($this->uri->segment(3)!=null)?$this->uri->segment(3):$document->patient_id) ?>">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            
                            <div class="form-group row" id="hideme">
                                <label for="attach_file" class="col-xs-3 col-form-label"><?php echo display('attach_file') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input type="file" name="attach_file" id="attach_file">

                                    <input type="hidden" name="hidden_attach_file" id="hidden_attach_file" value="<?php echo $document->hidden_attach_file ?>">

                                    <p id="upload-progress" class="hide alert"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_id" class="col-xs-3 col-form-label"><?php echo display('doctor_name') ?></label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('doctor_id',$doctor_list,$document->doctor_id,'class="form-control" id="doctor_id"') ?>
                                    <div id="available_days"></div>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
                                <div class="col-xs-9">
                                    <textarea name="description" class="form-control tinymce"  placeholder="<?php echo display('description') ?>"  rows="7"><?php echo $document->description ?></textarea>
                                </div>
                            </div>  
 

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('send') ?></button>
                                    </div>
                                </div>
                            </div>

                        <?php echo form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
$(function(){
    var browseFile = $('#attach_file');
    var form       = $('#mailForm');
    var progress   = $("#upload-progress");
    var hiddenFile = $("#hidden_attach_file");
    var output     = $("#output");
    browseFile.on('change',function(e)
    {
        e.preventDefault(); 
        uploadData = new FormData(form[0]);

        $.ajax({
            url      : '<?php echo base_url('patient/do_upload') ?>',
            type     : form.attr('method'),
            dataType : 'json',
            cache    : false,
            contentType : false,
            processData : false,
            data     : uploadData, 
            beforeSend  : function() 
            {
                hiddenFile.val('');
                progress.removeClass('hide').html('<i class="fa fa-cog fa-spin"></i> Loading..');
            },
            success  : function(data) 
            { 
                progress.addClass('hide');
                if (data.status == false) {
                    output.html(data.exception).addClass('alert-danger').removeClass('hide').removeClass('alert-info');
                } else if (data.status == true ) {
                    output.html(data.message).addClass('alert-info').removeClass('hide').removeClass('alert-danger');
                    hiddenFile.val(data.filepath);
                }  
            }, 
            error    : function() 
            {
                progress.addClass('hide');
                output.addClass('hide');
                alert('failed!');
            }   
        });
    });



});
</script>
<script type="text/javascript">
$.getJSON("<?php echo base_url('my-assets/js/admin_js/json/customer.json') ?>", function(data) {
        $("#patient_id").autocomplete({
            source: data,
            minLength: 1,
            select: function(event, ui) {
                setTimeout(function(){
                    $("#patient_id").val(ui.item.value);
                });
            }
        });
    });
    //$('#patient_id').keyup(function(){
function checkid(pid){
        var pid = $("#patient_id");

        $.ajax({
            url  : '<?= base_url('bed_manager/bed_assign/check_patient/') ?>',
            type : 'post',
            dataType : 'JSON',
            data : {
                '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>',
                patient_id : pid.val()
            },
            success : function(data) 
            {
                if (data.status == true) {
                    pid.next().text(data.message).addClass('text-success').removeClass('text-danger');
                    $("#hideme").css("display","block");
                } else if (data.status == false) {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                    $("#hideme").css("display","none");
                } else {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                    $("#hideme").css("display","none");
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    }
    $("#hideme").css("display","none");
    </script>