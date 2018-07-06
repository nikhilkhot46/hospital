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
                
                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/all_report')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('todays_report')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/todays_sales_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/product_sales_reports_date_wise')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report_product_wise')?> </a>

            </div>
        </div>

		<!-- Purchase report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('dashboard_pharmacist/Admin_dashboard/retrieve_dateWise_PurchaseReports',array('class' => 'form-inline'))?>
		                <?php date_default_timezone_set("Asia/Dhaka"); $today = date('Y-m-d'); ?>
		                    <div class="form-group">
		                        <label class="" for="from_date"><?php echo display('start_date') ?></label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" value="<?php echo $today?>">
		                    </div> 

		                    <div class="form-group">
		                        <label class="" for="to_date"><?php echo display('end_date') ?></label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		                    <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a>
		               <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('purchase_report') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		            	<div id="purchase_div" style="margin-left:2px;">
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
											<th><?php echo display('supplier_name') ?></th>
											<th><?php echo display('total_ammount') ?></th>
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
									<!-- <?php
										if($purchase_report) {
									?>
										{purchase_report}
											<tr>
												<td>{prchse_date}</td>
												<td>
													<a href="<?php echo base_url().'dashboard_pharmacist//purchase/cpurchase/purchase_details_data/{purchase_id}'; ?>">
														{chalan_no}
													</a>
												</td>
												<td>{supplier_name}</td>
												<td style="text-align: right;"><?php echo (($position==0)?"$currency {grand_total_amount}":"{grand_total_amount} $currency") ?></td>
											</tr>
										{/purchase_report}
									<?php
										}
									?> -->
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" align="right" style="text-align:right;font-size:14px !Important">&nbsp; <b><?php echo display('total_purchase') ?> </b></td>
											<!-- <td style="text-align: right;"><b><?php echo (($position==0)?"$currency {purchase_amount}":"{purchase_amount} $currency") ?></b></td> -->
											<td style="text-align: right;"><b><?php echo (($position==0)?$currency." ".$purchase_amount:$purchase_amount." ".$currency) ?></b></td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
			            <div class="text-right"><?php echo $links?></div>
		            </div>
		        </div>
		    </div>
		</div>