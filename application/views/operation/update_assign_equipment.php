<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("operation/operation/assign_equipment_list") ?>"> <i class="fa fa-list"></i>  <?php echo display('assign_equipment_list') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('operation/operation/assign_equipment/','class="form-inner"') ?>

                            <?php echo form_hidden('assign_id',$assign_equip->assign_id) ?>

                            <div class="form-group row">
                                <label for="ot_name" class="col-xs-3 col-form-label"><?php echo display('ot_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select class="form-control" name="ot_name" id="ot_name">
                                    <?php
                                        foreach ($ot as $o) {
                                    ?>
                                        <option <?php if($o->ot_id == $assign_equip->ot_id){ echo 'selected'; } ?> value="<?= $o->ot_id ?>"><?= $o->ot_name ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="equip_name" class="col-xs-3 col-form-label"><?php echo display('equip_name') ?></label>
                                <div class="col-xs-9">
                                <select class="form-control" name="equip_name" id="equip_name">
                                    <?php
                                        foreach ($equipment as $eq) {
                                    ?>
                                        <option <?php if($eq->equip_id == $assign_equip->equip_id){ echo 'selected'; } ?> value="<?= $eq->equip_id ?>"><?= $eq->equip_name ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="equip_qty" class="col-xs-3 col-form-label"><?php echo display('quantity') ?></label>
                                <div class="col-xs-9">
                                    <input name="equip_qty" pattern="\d*" oninvalid="this.setCustomValidity('Enter digits only')" oninput="this.setCustomValidity('')"  type="text" class="form-control" id="equip_qty" placeholder="<?php echo display('quantity') ?>" value="<?php echo $assign_equip->equip_qty ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date" class="col-xs-3 col-form-label"><?php echo display('date') ?></label>
                                <div class="col-xs-9">
                                    <input name="date" type="text" class="datepicker-avaiable-days form-control" id="date" placeholder="<?php echo display('date') ?>" value="<?php echo date("Y-m-d",strtotime($assign_equip->start_date)) ?>">
                                </div>
                            </div>
<!--                             
                            <div class="form-group row">
                                <label for="end_date" class="col-xs-3 col-form-label"><?php echo display('end_date') ?></label>
                                <div class="col-xs-9">
                                    <input name="end_date" type="text" class="datepicker-avaiable-days form-control" id="end_date" placeholder="<?php echo display('end_date') ?>">
                                </div>
                            </div> -->

                            <!--Radio-->
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9"> 
                                    <div class="form-check">
                                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php if($assign_equip->status == 1){ echo "checked"; } ?>><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php if($assign_equip->status == 0){ echo "checked"; } ?>><?php echo display('inactive') ?></label>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $( ".datepicker-avaiable-days" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        minDate: 0,  
        // beforeShowDay: DisableDays 
        });
});
</script>