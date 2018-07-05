<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("lab_manager/test") ?>"> <i class="fa fa-list"></i>  <?php echo display('test_list') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('lab_manager/test/form/'.$bed->test_id,'class="form-inner"') ?>

                            <?php echo form_hidden('test_id',$bed->test_id) ?>

                            <div class="form-group row">
                                <label for="test_name" class="col-xs-3 col-form-label"><?php echo display('test_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="test_name"  type="text" class="form-control" id="test_name" placeholder="<?php echo display('test_name') ?>" value="<?php echo $bed->test_name ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="test_short_name" class="col-xs-3 col-form-label"><?php echo display('test_short_name') ?></label>
                                <div class="col-xs-9">
                                <input name="test_short_name"  type="text" class="form-control" id="test_short_name" placeholder="<?php echo display('test_short_name') ?>" value="<?php echo $bed->test_short_name ?>">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="test_description" class="col-xs-3 col-form-label"><?php echo display('test_description') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <textarea id="test_description" name="test_description" placeholder="<?= display('test_description') ?>" class="form-control"><?= $bed->test_description?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="test_price" class="col-xs-3 col-form-label"><?php echo display('test_price') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="test_price"  type="text" class="form-control" id="test_price" placeholder="<?php echo display('test_price') ?>" value="<?php echo $bed->test_price ?>">
                                </div>
                            </div>

                            <!--Radio-->
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9"> 
                                    <div class="form-check">
                                    <?php 
                                    if($bed->test_id){
                                    ?>
                                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php echo $bed->status==1?"checked":"";?> ><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php echo $bed->status==0?"checked":"";?>><?php echo display('inactive') ?></label>
                                    <?php
                                    }else{
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