<!-- Stock report start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	document.body.style.marginTop="0px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

		<div class="row">
            <div class="col-sm-12">
                
                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/todays_sales_report')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('sales_report')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/todays_purchase_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('purchase_report')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/product_sales_reports_date_wise')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report_product_wise')?> </a>

            </div>
        </div>

		<!-- Todays sales report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('todays_sales_report') ?> </h4>
		                    <p class="text-right">
		                    <a  class="btn btn-warning btn-sm" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
		                </p>
		                </div>
		            </div>
		            <div class="panel-body">
		            	
		            	
		            	<div id="printableArea" style="margin-left:2px;">
			            	<div class="text-center">
								<h3> <?= $company_info[0]['title']?> </h3>
								<h4 > <?= $company_info[0]['description']?> </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>
			                <div class="table-responsive">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
			                            <tr>
			                                <th><?php echo display('sales_date') ?></th>
											<th><?php echo display('invoice_no') ?></th>
											<th><?php echo display('customer_name')?></th>
											<th><?php echo display('total_amount')?></th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        <?php
			                        	if ($sales_report) {
											foreach ($sales_report as $sales) {
			                        ?>
											<tr>
												<td><?= $sales['sales_date']?></td>
												<td>
													<a href="<?php echo base_url().'dashboard_pharmacist/invoice/Cinvoice/invoice_inserted_data/'.$sales['invoice_id']; ?>">
														<?= $sales['invoice_id']?>
													</a>
												</td>
												<td><?= $sales['firstname']?></td>
												<td style="text-align: right;"><?php echo (($position==0)?$currency." ".$sales['total_amount']:$sales['total_amount']." ".$currency) ?></td>
											</tr>
									<?php
											}
										}
									?>
			                        </tbody>
			                        <tfoot>
										<tr>
											<td colspan="3" align="right"  style="text-align:right;font-size:14px !Important">&nbsp;<b><?php echo display('total_sales') ?>:</b></td>
											<td style="text-align: right;"><b><?php echo (($position==0)?$currency." ".$sales_amount:$sales_amount." ".$currency) ?></b></td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Todays purchase report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('todays_purchase_report') ?></h4>
		                    	<p class="text-right">
		                    <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a>
		                </p>
		                </div>
		            </div>
		            <div class="panel-body">
		            

		                <div id="purchase_div" style="margin-left:2px;">
		                	<div class="text-center">
								<h3> <?= $company_info[0]['title']?> </h3>
								<h4 > <?= $company_info[0]['description']?> </h4>
								<h4> <?php echo display('stock_date') ?> : <?= $date?> </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>
			                <div class="table-responsive">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
			                            <tr>
			                                <th><?php echo display('purchase_date') ?></th>
											<th><?php echo display('invoice_no') ?></th>
											<th><?php echo display('supplier_name') ?></th>
											<th><?php echo display('total_amount') ?></th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        	<?php
			                        		if ($purchase_report) {
												foreach ($purchase_report as $purc) {
			                        	?>
											<tr>
												<td><?= $purc['prchse_date']?></td>
												<td>
													<a href="<?php echo base_url().'dashboard_pharmacist/purchase/Cpurchase/purchase_details_data/'.$purc['purchase_id']; ?>">
														<?= $purc['chalan_no']?>
													</a>
												</td>
												<td><?= $purc['supplier_name']?></td>
												<td style="text-align: right;"><?php echo (($position==0)?$currency." ".$purc['grand_total_amount']:$purc['grand_total_amount']." ".$currency) ?></td>
											</tr>
										<?php
												}
											}
										?>
			                        </tbody>
			                        <tfoot>
										<tr>
											<td colspan="3" align="right" style="text-align:right;font-size:14px !Important">&nbsp; <b><?php echo display('total_purchase') ?>: </b></td>
											<td style="text-align: right;"><b><?php echo (($position==0)?$currency." ".$purchase_amount:$purchase_amount." ".$currency) ?></b></td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
		            	</div>
		            </div>
		        </div>
		    </div>
		</div>