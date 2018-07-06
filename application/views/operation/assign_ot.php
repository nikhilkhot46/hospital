<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("operation/operation/assign_ot_list") ?>"> <i class="fa fa-list"></i>  <?php echo display('assign_ot_list') ?> </a>  
                </div>
            </div> 


            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('operation/operation/assign_ot/'.$operation->assign_ot_id,'class="form-inner"') ?>

                            <?php echo form_hidden('id',$operation->assign_ot_id) ?>

                            <div class="form-group row">
                                <label for="patient_id" class="col-xs-3 col-form-label"><?php echo display('patient_id') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="patient_id"  type="text" class="form-control" id="patient_id" placeholder="<?php echo display('patient_id') ?>" value="<?php echo $operation->patient_id ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ot_id" class="col-xs-3 col-form-label"><?php echo display('ot_name') ?></label>
                                <div class="col-xs-9">
                                <select id="ot_id" name="ot_id" class="form-control">
                                    <?php
                                    foreach ($ot_list as $ot) {
                                    ?>
                                        <option value="<?= $ot->ot_id ?>" <?php if($ot->ot_id == $operation->ot_id){ echo 'selected'; } ?>><?= $ot->ot_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date" class="col-xs-3 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="date" type="text" class="form-control datepicker" id="date" placeholder="<?php echo display('date') ?>" value="<?php echo $operation->date ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time" class="col-xs-3 col-form-label"><?php echo display('time') ?> <i class="text-danger">*</i></label>
                                <div class="col-md-4">
                                    <input name="start_time" type="text" class="form-control timepicker" id="starttime" placeholder="<?php echo display('start_time') ?>" value="<?php echo $operation->start_time ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <input name="end_time" type="text" class="form-control timepicker" id="end_time" placeholder="<?php echo display('end_time') ?>" value="<?php echo $operation->end_time ?>" required>
                                </div>                                
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
                                <div class="col-xs-9">
                                    <textarea name="description" class="form-control" id="description"  placeholder="<?php echo display('description') ?>" rows="7"><?php echo $operation->description ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_id" class="col-xs-3 col-form-label"><?php echo display('doctor_name') ?></label>
                                <div class="col-xs-9">
                                <?php echo form_dropdown('doctor_id', $doctor_list, $operation->doctor_id, 'class="form-control" id="doctor_id"') ?>
                                </div>
                            </div>


                            <!--Radio-->
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9"> 
                                    <div class="form-check">
                                    <?php
                                    if($operation->assign_ot_id){
                                    ?>
                                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php if($operation->status == 1){ echo "checked"; } ?>><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php if($operation->status == 0){ echo "checked"; } ?>><?php echo display('inactive') ?></label>
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <label class="radio-inline"><input type="radio" name="status" value="1" checked><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
                                    <?php
                                    }
                                    ?>
                                    </div>
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
<script>
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
</script>