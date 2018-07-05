
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
                  <a href="<?php echo base_url('dashboard_pharmacist/return/Cretrun_m')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_return')?> </a>

            </div>
        </div>
  
 <div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('dashboard_pharmacist/return/Cretrun_m/datebwteen_supplier_return_list',array('class' => 'form-inline'))?>
		                <?php date_default_timezone_set("Asia/Dhaka"); $today = date('Y-m-d'); ?>
		                    <div class="form-group">
		                        <label class="" for="from_date"><?php echo display('start_date') ?></label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="<?php echo $today?>" placeholder="<?php echo display('start_date') ?>" >
		                    </div> 

		                    <div class="form-group">
		                        <label class="" for="to_date"><?php echo display('end_date') ?></label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		                  
		               <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

  
		<!-- Manage Invoice report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('return_list') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                    	<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('purchase_id') ?></th>
										<th><?php echo display('supplier_name') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('total_amount') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($return_list) {
										foreach ($return_list as $return) {
								?>
								
									<tr>
										<td><?= $return['sl'] ?></td>
										<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/return/Cretrun_m/supplier_inserted_data/'.$return['purchase_id']; ?>">
											<?= $return['purchase_id'] ?>
											</a>
										</td>
										<td>
												<?= $return['supplier_name'] ?>		
										</td>

										<td><?= $return['final_date'] ?></td>
										<td style="text-align: right;"><?php echo (($position==0)?$currency." ".$return['net_total_amount']:$return['net_total_amount']." ".$currency) ?></td>
										<td>
											<center>
												<?php echo form_open()?>
													<a href="<?php echo base_url().'dashboard_pharmacist/return/Cretrun_m/supplier_inserted_data/'.$return['purchase_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
													<a href="<?php echo base_url().'dashboard_pharmacist/return/Cretrun_m/delete_retutn_purchase/'.$return['purchase_id']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
												<?php echo form_close()?>
											</center>
										</td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
		                    </table>
		                    <div class="text-right"><?php echo $links?></div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>