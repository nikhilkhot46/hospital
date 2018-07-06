
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

        <div class="row">
            <div class="col-sm-12">
                  <a href="<?php echo base_url('dashboard_pharmacist/accounts/Caccounts/closing_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('closing_report')?></a>
            </div>
        </div>


        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('closing_account') ?></h4>
                        </div>
                    </div>
                 	<?php echo form_open_multipart('dashboard_pharmacist/accounts/Caccounts/add_daily_closing',array('class' => 'form-vertical','id' => 'validate' ))?>
                 	<div class="panel-body">

                    	<div class="form-group row">
                            <label for="last_day_closing" class="col-sm-3 col-form-label"><?php echo display('last_day_closing') ?></label>
                            <div class="col-sm-6">
                                <input type="text" name="last_day_closing" class="form-control" value="<?= $last_day_closing ?>" readonly="readonly" />
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="cash_in" class="col-sm-3 col-form-label"><?php echo display('cash_in') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cash_in" value="<?= $cash_in ?>" readonly="readonly" />
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="cash_out" class="col-sm-3 col-form-label"><?php echo display('cash_out') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cash_out" value="<?= $cash_out ?>" readonly="readonly" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cash_in_hand" class="col-sm-3 col-form-label"><?php echo display('cash_in_hand') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="amount" name="cash_in_hand" value="<?= $cash_in_hand ?>" readonly="readonly" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="adjusment" class="col-sm-3 col-form-label"><?php echo display('adjustment') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="adjusment" name="adjusment" placeholder="<?php echo display('adjustment') ?>" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-deposit" class="btn btn-primary" name="add-deposit" value="<?php echo display('day_closing') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>