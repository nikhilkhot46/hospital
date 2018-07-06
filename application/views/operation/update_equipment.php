<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("operation/operation/equipment_list") ?>"> <i class="fa fa-list"></i>  <?php echo display('equipment_list') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('operation/operation/add_equipment/','class="form-inner"') ?>

                            <?php echo form_hidden('equip_id',$equipment->equip_id) ?>

                            <div class="form-group row">
                                <label for="type" class="col-xs-3 col-form-label"><?php echo display('equip_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="equip_name"  type="text" class="form-control" id="equip_name" placeholder="<?php echo display('ot_name') ?>" value="<?php echo $equipment->equip_name ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
                                <div class="col-xs-9">
                                    <textarea name="description" class="form-control"  placeholder="<?php echo display('description') ?>" rows="7"><?php echo $equipment->description ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-xs-3 col-form-label"><?php echo display('quantity') ?></label>
                                <div class="col-xs-9">
                                <input name="quantity" pattern="\d*" oninvalid="this.setCustomValidity('Enter digits only')" oninput="this.setCustomValidity('')"  type="text" class="form-control" id="quantity" placeholder="<?php echo display('quantity') ?>" value="<?php echo $equipment->qty ?>">
                                </div>
                            </div>
                            <!--Radio-->
                            <!-- <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9"> 
                                    <div class="form-check">
                                        <?php
                                        if(!empty($this->uri->segment(4))){
                                        ?>
                                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php echo($equipment->status == 1?'checked':''); ?>><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php echo($equipment->status == 0?'checked':''); ?>><?php echo display('inactive') ?></label>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div> -->
                            
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