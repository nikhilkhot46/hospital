
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
                  <a href="<?php echo base_url('purchase_manager/item/purchase')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_purchase')?> </a>

                  <a href="<?php echo base_url('purchase_manager/item/manage_purchase')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_purchase')?> </a>
            </div>
        </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('invoice_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div style="float:left">
							<th width="100%" colspan="5" style="font-weight:normal">
							<?php 
								echo $company_info[0]['title'];
							?>
				        	
				        	<h5> <u> <?= $company_info[0]['title'] ?></u> </h5> 
				        	
				        	 <?php echo display('supplier_name') ?> : &nbsp;<span style="font-weight:normal"><?= $supplier_name ?></span>  <span style="margin-left:800px;float:right"><?php echo display('supplier_invoice') ?> </span> <br />
				            Date :&nbsp;<?= $final_date?> <br /><?php echo display('invoice_no') ?> :&nbsp; <?= $chalan_no?><br> <?= $purchase_details?> <span style="float:right"><?php echo display('print_date') ?> : <?php echo date("d/m/Y h:i:s");?> </span>
				            </th>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Purchase Ledger -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('invoice_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('item_name') ?></th>
										<th><?php echo display('quantity') ?></th>
										<th><?php echo display('rate') ?></th>
										<th><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($purchase_all_data) {
										foreach ($purchase_all_data as $purdata) {	
								?>
									<tr>
										<td><?= $purdata['sl'] ?></td>
										<td>
											<a href="<?php echo base_url().'purchase_manager/item/item_details/'.$purdata['item_id']; ?>">
											<?= $purdata['item_name'] ?>
											</a>
										</td>
										<td style="text-align: right"><?= $purdata['quantity'] ?></td>
										<td style="text-align: right;"><?php echo (($position==0)?$currency." ".$purdata['rate']:$purdata['rate']." ".$currency) ?></td>
										<td style="text-align:right;padding-right:20px !important;"><?php echo (($position==0)?$currency." ".$purdata['total_amount']:$purdata['total_amount']." ".$currency) ?></td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td style="text-align:right" colspan="4"><b><?php echo display('grand_total') ?>:</b></td>
										<td  style="text-align:right;padding-right:20px !important;"><b><?php echo (($position==0)?$currency." ".$sub_total_amount:$sub_total_amount." ".$currency) ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>