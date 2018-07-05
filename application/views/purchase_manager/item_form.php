<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("purchase_manager/item") ?>"> <i class="fa fa-list"></i>  <?php echo display('item_list') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('purchase_manager/item/add/'.$item->item_id,'class="form-inner"') ?>

                            <?php echo form_hidden('item_id',$item->item_id) ?>

                            <div class="form-group row">
                                <label for="item_name" class="col-xs-3 col-form-label"><?php echo display('item_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="item_name"  type="text" class="form-control" id="item_name" placeholder="<?php echo display('item_name') ?>" value="<?php echo $item->item_name ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="item_desc" class="col-xs-3 col-form-label"><?php echo display('description') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <textarea id="item_desc" name="item_desc" placeholder="<?= display('description') ?>" class="form-control"><?= $item->item_desc ?></textarea>
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