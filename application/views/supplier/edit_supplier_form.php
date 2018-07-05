
        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>

        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('supplier_edit') ?> </h4>
                        </div>
                    </div>
                   <?php echo form_open_multipart('supplier/Csupplier/supplier_update',array( 'id' => 'supplier_update'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="supplier_name" class="col-sm-3 col-form-label"><?php echo display('supplier_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="supplier_name" id="supplier_name" type="text" value="<?= $supplier_name ?>" placeholder="<?php echo display('supplier_name') ?>"  required="" tabindex="1">
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('supplier_mobile') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="mobile" id="mobile" type="number" placeholder="<?php echo display('supplier_mobile') ?>" value="<?= $mobile ?>" required="" min="0" tabindex="2">
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="address " class="col-sm-3 col-form-label"><?php echo display('supplier_address') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('supplier_address') ?>" tabindex="3"><?= $address ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-sm-3 col-form-label"><?php echo display('supplier_details') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="details" id="details" rows="3" placeholder="<?php echo display('supplier_details') ?>" tabindex="4"><?= $details ?></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="supplier_id" value="<?= $supplier_id ?>" />

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                               <input type="submit" id="add-supplier" class="btn btn-success btn-large" name="add-supplier" value="<?php echo display('save_changes') ?>" tabindex="5" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>