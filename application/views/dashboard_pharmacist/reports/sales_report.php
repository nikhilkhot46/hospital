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

                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/todays_purchase_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('purchase_report')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/Admin_dashboard/todays_sales_report')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report')?> </a>

            </div>
        </div>

		<!-- Sales report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('dashboard_pharmacist/Admin_dashboard/retrieve_dateWise_SalesReports',array('class' => 'form-inline'))?>
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
		                    <h4><?php echo display('sales_report') ?> </h4>
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
											<th><?php echo display('customer_name') ?></th>
											<th><?php echo display('total_amount') ?></th>
			                            </tr>
			                        </thead>
			                        <tfoot>
										<tr>
											<td colspan="3" style="text-align: right;"><b><?php echo display('total_seles') ?></b></td>
											<td style="text-align: right;"><b><?php echo (($position==0)?$currency." ".$sales_amount:$sales_amount." ".$currency) ?></b></td>
										</tr>
									</tfoot>
			                        <tbody>
									<?php
			                        	if ($sales_report) {
											foreach ($sales_report as $sales) {
			                        ?>
											<tr>
												<td><?= $sales['sales_date']?></td>
												<td>
													<a href="<?php echo base_url().'dashboard_pharmacist/invoice/Cinvoice/invoice_inserted_data/'.$sales['invoice_id']; ?>">
														<?= $sales['invoice']?>
													</a>
												</td>
												<td><a href="<?php echo base_url().'dashboard_pharmacist/patient/Cpatient/customerledger/'.$sales['patient_id']; ?>"><?= $sales['customer_name']?></a></td>
												<td style="text-align: right;"><?php echo (($position==0)?$currency." ".$sales['total_amount']:$sales['total_amount']." ".$currency) ?></td>
											</tr>
									<?php
											}
										}
									?>
<!-- 									
			                        <?php
			                        	if ($sales_report) {
			                        ?>
			                            {sales_report}
										<tr>
											<td>{sales_date}</td>
											<td>
												<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/{invoice_id}'; ?>">
													{invoice}
												</a>
											</td>
											<td><a href="<?php echo base_url().'Ccustomer/customerledger/{customer_id}'; ?>">{customer_name}</a></td>
											<td style="text-align: right;"><?php echo (($position==0)?"$currency {total_amount}":"{total_amount} $currency") ?></td>
										</tr>
									{/sales_report}
									<?php
										}
									?> -->
			                        </tbody>
			                    </table>
			                </div>
			            </div>
			            <div class="text-right"><?php echo $links?></div>
		            </div>
		        </div>
		    </div>
		</div>