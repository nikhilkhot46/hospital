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
                
                  <a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m/return_list')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('c_r_slist')?> </a>
                    <a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m/supplier_return_list')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_return')?> </a>
                      <a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m/wastage_return_list')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('wastage_list')?> </a>

            </div>
        </div>
         <!-- Add Product Form -->
         <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('dashboard_pharmacist/return/Cretrun_m/invoice_return_form',array('class' => 'form-inline'))?>

                            <div class="form-group">
                                <label for="to_date">Enter Your Invoice ID:</label>
                                <input type="text" name="invoice_id" class="form-control" id="to_date" placeholder="<?php echo display('invoice_id')?>" required="required">
                            </div>  

                            <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                       <?php echo form_close()?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                      <div class="panel-body"> 
                        <?php echo form_open('dashboard_pharmacist/return/Cretrun_m/supplier_return_form',array('class' => 'form-inline'))?>

                            <div class="form-group">
                                <label for="to_date">Enter Your Purchase ID:</label>
                                <input type="text" name="purchase_id" class="form-control" id="to_date" placeholder="Return Purchase Id" required="required">
                            </div>  

                            <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                       <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>