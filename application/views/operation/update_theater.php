<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("operation/operation/ot_list") ?>"> <i class="fa fa-list"></i>  <?php echo display('ot_list') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('operation/operation/add_theater/','class="form-inner"') ?>

                            <?php echo form_hidden('id',$theater->ot_id) ?>

                            <div class="form-group row">
                                <label for="type" class="col-xs-3 col-form-label"><?php echo display('ot_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name"  type="text" class="form-control" id="name" placeholder="<?php echo display('ot_name') ?>" value="<?php echo $theater->ot_name ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label"><?php echo display('ot_description') ?></label>
                                <div class="col-xs-9">
                                    <textarea name="description" class="form-control"  placeholder="<?php echo display('ot_description') ?>" rows="7"><?php echo $theater->ot_description ?></textarea>
                                </div>
                            </div>
                            <!--Radio-->
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9"> 
                                    <div class="form-check">
                                        <?php
                                        if(!empty($this->uri->segment(4))){
                                        ?>
                                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php echo($theater->status == 1?'checked':''); ?>><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php echo($theater->status == 0?'checked':''); ?>><?php echo display('inactive') ?></label>
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