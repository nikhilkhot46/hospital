<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("blood_bank/blood/wastage") ?>"> <i class="fa fa-list"></i>  <?php echo display('wastage') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('blood_bank/blood/add_wastage/'.$wastage->wastage_id,'class="form-inner"') ?>
                            <?php echo form_hidden('wastage_id',$wastage->wastage_id);?>

                            <div class="form-group row">
                                <label for="blood_type" class="col-xs-3 col-form-label"><?php echo display('blood_group') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('blood_type', $this->config->item('blood_group'), $wastage->blood_type, 'class="form-control dateChange" id="blood_type"') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-xs-3 col-form-label"><?php echo display('quantity') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="quantity"  type="text" class="form-control" id="quantity" placeholder="<?php echo display('quantity') ?>" value="<?php echo $wastage->qty ?>">
                                </div>
                            </div>
 
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
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
$(document).ready(function() {

    //check patient id
    $('#patient_id').keyup(function(){
        var pid = $(this);

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
                } else if (data.status == false) {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });

});
 
 </script>