
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
                
                  <a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/credit_customer')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/paid_customer')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('paid_customer')?> </a>

            </div>
        </div>


		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('customer_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div style="float:left">
							<h4><?php echo display('customer_name') ?> : <?= $customer_name ?></h4>
							<h4><?php echo display('address') ?> : <?= $customer_address ?></h4>
							<h4><?php echo display('mobile') ?> : <?= $customer_mobile ?></h4>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Manage Supplier -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('customer_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('date') ?></th>
										<th class="text-center"><?php echo display('receipt_no') ?></th>
										<th class="text-center"><?php echo display('description') ?></th>
										<th class="text-center"><?php echo display('ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($receipt_info) {
										foreach ($receipt_info as $receipt) {
								?>
									<tr>
										<td><?= $receipt['final_date'] ?></td>
										<td>
											<?= $receipt['receipt_no'] ?>
										</td>
										<td><?= $receipt['description'] ?></td>
										<td class="text-right"><?php echo (($position==0)?$currency." ".$receipt['amount']:$receipt['amount']." ".$currency) ?></td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td class="text-right" colspan="3" style="font-weight: bold"><?php echo display('total_ammount');?>:</td>
										<td class="text-right"><b><?php echo (($position==0)?$currency." ".$receipt_amount:$receipt_amount." ".$currency) ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>