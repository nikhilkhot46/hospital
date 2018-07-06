
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
<div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("purchase_manager/item/add") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_item') ?> </a>  
                </div>
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("purchase_manager/item/purchase") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_purchase') ?> </a>  
                </div>
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("purchase_manager/item/manage_purchase") ?>"> <i class="fa fa-plus"></i>  <?php echo display('manage_purchase') ?> </a>  
                </div>
            </div>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('product_details') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<h2> <span style="font-weight:normal;"><?php echo display('product_name') ?>: </span><span style="color:#005580;"><?= $product_name ?></span></h2>

						<table class="table">
							<tr>
								<th><?php echo display('total_purchase') ?> = <span style="color:#ff0000;"><?= $total_purchase ?></span></th>
								<th><?php echo display('total_sales') ?> = <span style="color:#ff0000;"> <?= $total_sales ?></span></th>
								<th><?php echo display('stock') ?> = <span style="color:#ff0000;"> <?= $stock ?></span></th>
							</tr>
						</table>
		            </div>
		        </div>
		    </div>
		 </div>

		<!-- Total Purchase report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('purchase_report') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
				            	<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_no') ?></th>
											<th><?php echo display('invoice_id') ?></th>
										<th><?php echo display('supplier_name') ?></th>
										<th><?php echo display('quantity') ?></th>
										<th><?php echo display('rate') ?></th>
										<th style="text-align:right;"><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($purchaseData) {
										foreach ($purchaseData as $purchase) {
								?>
									<tr>
										<td><?= $purchase['final_date'] ?></td>
										<td>
											<?= $purchase['chalan_no'] ?>
										</td>
											<td>
												<?= $purchase['purchase_id'] ?>
										</td>
										<td>
											<?= $purchase['supplier_name'] ?>
										</td>
										<td  style="text-align:right;"><?= $purchase['quantity'] ?></td>
										<td  style="text-align:right;"><?php echo (($position==0)?$currency." ".$purchase['rate']:$purchase['rate']." ".$currency) ?></td>
										<td style="text-align:right;"> <?php echo (($position==0)?$currency." ".$purchase['total_amount']:$purchase['total_amount']." ".$currency) ?></td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" style="text-align:right;"><b><?php echo display('total') ?></b></td>
										<td></td>
										<td  style="text-align:right;"> <?= $total_purchase ?></td>
										<td style="text-align:right;"><b><?php echo display('grand_total') ?></b></td>
										<td style="text-align:right;"><b> <?php echo (($position==0)?$currency." ".$purchaseTotalAmount:$purchaseTotalAmount." ".$currency) ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<!--Total sales report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('sales_report') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
		             			<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_id') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('quantity') ?></th>
										<th><?php echo display('rate') ?></th>
										<th style="text-align:right;"><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($salesData) {
										foreach ($salesData as $sales) {
								?>
									<tr>
										<td><?= $sales['final_date'] ?></td>
										<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/invoice/Cinvoice/invoice_inserted_data/'.$sales['invoice_id']; ?>">
												<?= $sales['invoice_id'] ?>
											</a>
										</td>
											<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/invoice/Cinvoice/invoice_inserted_data/'.$sales['invoice_id']; ?>">
												<?= $sales['invoice'] ?>
											</a>
										</td>
										<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/patient/Cpatient/customer_ledger/'.$sales['customer_id']; ?>"><?= $sales['firstname']." ".$sales['lastname'] ?></a>
										</td>
										<td  style="text-align:right;"><?= $sales['quantity'] ?></td>
										<td  style="text-align:right;"> <?php echo (($position==0)?$currency." ".$sales['rate']:$sales['rate']." ".$currency) ?></td>
										<td style="text-align:right;"> <?php echo (($position==0)?$currency." ".$sales['total_price']:$sales['total_price']." ".$currency) ?></td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" style="text-align:right;"><b><?php echo display('total') ?></b></td>
										<td></td>
										<td  style="text-align:right;"><?= $total_sales ?></td>
										<td><b><?php echo display('grand_total') ?></b></td>
										<td  style="text-align:right;"><b> <?php echo (($position==0)?$currency." ".$salesTotalAmount:$salesTotalAmount." ".$currency) ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>