<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("blood_bank/blood/donor_list") ?>"> <i class="fa fa-list"></i>  <?php echo display('donor_list') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('blood_bank/blood/blood_doners/'.$blood_doner->donor_id,'class="form-inner"') ?>

                            <?php echo form_hidden('donor_id',$blood_doner->donor_id) ?>

                            <div class="form-group row">
                                <label for="donar_name" class="col-xs-3 col-form-label"><?php echo display('donar_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="donar_name"  type="text" class="form-control" id="donar_name" placeholder="<?php echo display('donar_name') ?>" value="<?php echo $blood_doner->donar_name ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blood_type" class="col-xs-3 col-form-label"><?php echo display('blood_group') ?><span class="text-danger">*</span> <?php echo form_error('blood_type') ?></label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('blood_type', $this->config->item('blood_group'), $blood_doner->blood_type, 'class="form-control input-sm" id="blood_type"'); ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="email" class="col-xs-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="email"  type="text" class="form-control" id="email" placeholder="<?php echo display('email') ?>" value="<?php echo $blood_doner->email ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-xs-3 col-form-label"><?php echo display('mobile') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="mobile"  type="text" class="form-control" id="mobile" placeholder="<?php echo display('mobile') ?>" value="<?php echo $blood_doner->mobile ?>">
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