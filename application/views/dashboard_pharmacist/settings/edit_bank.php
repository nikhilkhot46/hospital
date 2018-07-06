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


        <!-- New bank -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('bank_edit') ?></h4>
                        </div>
                    </div>
                   <?php echo form_open_multipart('dashboard_pharmacist/Csettings/update_bank/'.$bank_list[0]['bank_id'],array('class' => 'form-vertical','id' => 'validate' ))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bank_name" id="bank_name" required="" placeholder="<?php echo display('bank_name') ?>" value="<?php echo $bank_list[0]['bank_name']?>" tabindex="1"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label"><?php echo display('ac_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="ac_name" id="ac_name" required="" placeholder="<?php echo display('ac_name') ?>" value="<?php echo $bank_list[0]['ac_name']?>" tabindex="2"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ac_no" class="col-sm-3 col-form-label"><?php echo display('ac_no') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="ac_no" id="ac_no" required="" placeholder="<?php echo display('ac_no') ?>" value="<?php echo $bank_list[0]['ac_number']?>" tabindex="3"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="branch" class="col-sm-3 col-form-label"><?php echo display('branch') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="branch" id="branch" required="" placeholder="<?php echo display('branch') ?>" value="<?php echo $bank_list[0]['branch']?>" tabindex="4"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="signature_pic" class="col-sm-3 col-form-label"><?php echo display('signature_pic') ?></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" name="signature_pic" id="signature_pic" placeholder="<?php echo display('signature_pic') ?>" tabindex="5" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="signature_pic" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="hidden" name="old_pic"  value="<?php echo $bank_list[0]['signature_pic']?>"/>
                                <img src="<?php echo $bank_list[0]['signature_pic']?>" class="img img-responsive" height="80" width="80">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-deposit" class="btn btn-success" name="add-deposit" value="<?php echo display('save_changes') ?>" tabindex="6"/>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>