
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
                
                  <a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/credit_customer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer')?> </a>

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
							
							<h5><u> <?= $company_info[0]['title'] ?></u></h5>
							
							<?php echo display('customer_name') ?> : <?= $customer_name ?> <br>
							<?php echo display('address') ?> : <?= $customer_address ?><br>
							<?php echo display('mobile') ?> : <?= $customer_mobile ?>
						</div>
						<div style="float:right;margin-right:100px">
							<table class="table table-striped table-condensed table-bordered">
								<tr><td> <?php echo display('debit_ammount') ?> </td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?$currency." ".$total_debit:$total_debit." ".$currency)?></td> </tr>
								<tr><td><?php echo display('credit_ammount');?></td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?$currency." ".$total_credit:$total_credit." ".$currency) ?></td> </tr>
								<tr><td><?php echo display('balance_ammount');?> </td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?$currency." ".$total_balance:$total_balance." ".$currency)?></td> </tr>
							</table>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Customer Ledger -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('customer_ledger') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('receipt_no') ?></th>
										<th><?php echo display('description') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('debit') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('credit') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('balance') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($ledger){
										foreach ($ledger as $led) {
								?>
									<tr>
										<td><?= $led['final_date'] ?></td>
										<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/invoice/Cinvoice/invoice_inserted_data/'.$led['invoice_no']; ?>">
												<?= $led['invoce_n'] ?>
											</a>
										</td>
										<td>
											<?= $led['receipt_no'] ?>
										</td>
										<td><?= $led['description'] ?></td>
										<td style="text-align:right;"> 

										<?php echo (($position==0)?$currency." ".$led['debit']:$led['debit']." ".$currency)?>
										</td>
										<td style="text-align:right;"> <?php echo (($position==0)?$currency." ".$led['credit']:$led['credit']." ".$currency) ?></td>
										<td style="text-align:right;"> <?php echo (($position==0)?$currency." ".$led['balance']:$led['balance']." ".$currency) ?></td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>